<?php
    /*
        * Items Controller class
        * Functionality -  To manage items 
        * Developer - Navdeep Kaur
        * Created date - 17-Feb-2014
        * Modified date - 
    */
    class ItemsController extends AppController {        
        var $name = 'Items';                
		public $components = array('Paginator','Image','Common');
        public $uses = "Item";
		public $paginate = array(
        'limit' => 10,
        'order' => array(
            'Items.id' => 'DESC'
				)
			);
        function beforeFilter(){
            parent::beforeFilter();    
            
        }     
		/*
            * admin_index function
            * Functionality -  Items Listing
            * Developer - Navdeep Kaur
            * Created date - 17-Feb-2014
            * Modified date - 
        */
        function admin_index()
        {
			
			#To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');			
			
			$this->loadModel('ItemCategory');
			/* Active/Inactive/Delete functionality */
			if((isset($this->data["Item"]["setStatus"])))
			{
				if(!empty($this->request->data['Item']['status'])){
					$status = $this->request->data['Item']['status'];
				}else
				{
					$this->Session->setFlash("Please select the action.",'default',array('class'=>'alert alert-danger'));	
					$this->redirect(array('action' => 'index'));
					
				}
				$CheckedList = $this->request->data['checkboxes'];
				$model='Item';				
				$controller = $this->params['controller'];				
				$action = $this->params['action'];				
				$this->setStatus($status,$CheckedList,$model,$controller,$action); 			 
			}
			/* Active/Inactive/Delete functionality */
            $value ="";
			$criteria = "Item.is_deleted = 0 AND Item.company_id = $companyId";
			$this->Item->unbindModel(array('belongsTo'=>array('User')));
			$this->Item->bindModel(array('hasMany'=>array('ItemCategory')));
			$this->ItemCategory->bindModel(array('belongsTo'=>array('Category')));
			if(!empty($this->params)){ 
					if(!empty($this->params->query['keyword'])){
						$value = trim($this->params->query['keyword']);	
					}
					if($value !="") {
						$criteria .= " AND (Item.name LIKE '%".$value."%' OR Item.product_code LIKE '%".$value."%' )";												
					}
			}
			$this->Paginator->settings = array('conditions' => array($criteria),'order'=>'Item.id DESC','limit'=>10,'recursive'=>2);
			$getData =  $this->Paginator->paginate('Item');
			
			$this->set('getData',$getData);
			$this->set('keyword', $value);
			$this->set('navitems','class = "active"');			
			$this->set('breadcrumb','Items');			
        }
		
        /*
            * admin_addedit function
            * Functionality -  Add & edit the Showrooms
            * Developer - Navdeep kaur
            * Created date - 12-Feb-2014
            * Modified date - 
        */
        function admin_add($id = null)
        {
			#To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');
			//$companyName = $this->getCompanyName($companyId);
			//$this->set('companyName',$companyName);
			$this->loadModel('ItemImage');
            $this->loadMOdel('ItemCategory');
			$this->loadMOdel('RelatedItem');
            $this->getCategoryList();
            
			$picLimit = 10;
			$this->set('picLimit',$picLimit);
			$this->Item->bindModel(array('hasMany'=>array('ItemImage','ItemCategory','RelatedItem')));
			if(isset($this->request->data) && !empty($this->request->data))
			{	$this->request->data['Item']['id'] = base64_decode($this->request->data['Item']['id']);
				$this->Item->set($this->request->data);	
				if($this->Item->validates()) 				
				{ //echo "<pre>";  print_r(json_encode($this->request->data)); die;
					if($id){
                        
                        $msz= "Product updated sucessfully.";
                    }else{
                        $msz= "Product saved sucessfully.";
                    }
					$this->request->data['Item']['company_id'] = $companyId;
					$this->request->data['Item']['name'] = trim($this->request->data['Item']['name']);
					$this->request->data['Item']['unique_id'] = md5(uniqid(rand(), true));
					if($this->Item->save($this->request->data))
					{
						$itemId = $this->Item->id;
						if(!empty($this->request->data['ItemCategory']['category_id'])){
							
							$this->ItemCategory->deleteAll(array('ItemCategory.item_id'=>$itemId));
							foreach($this->request->data['ItemCategory']['category_id'] as $catval){
								if($catval != ""){
								$data['ItemCategory']['item_id'] = $itemId;
								$data['ItemCategory']['category_id'] = $catval;
								$this->ItemCategory->create();
								$this->ItemCategory->save($data['ItemCategory']);
								}
							}
							
						}
						if(!empty($this->request->data['RelatedItem']['other_item_id'])){							
							$this->RelatedItem->deleteAll(array('RelatedItem.item_id'=>$itemId));
							foreach($this->request->data['RelatedItem']['other_item_id'] as $itemval){
								if($itemval != ""){
									$data['RelatedItem']['item_id'] = $itemId;
									$data['RelatedItem']['other_item_id'] = $itemval;
									$this->RelatedItem->create();
									$this->RelatedItem->save($data['RelatedItem']);
								}
							}
							
						}
						/*****************image upload*****************/
						if(!empty($this->request->data['ItemImage']['image_name'])){
							
							foreach($this->request->data['ItemImage']['image_name'] as $imagesAdd){
								if(isset($imagesAdd['name']) && $imagesAdd['name'] != ""){
								// Variable declaration
								$file = $imagesAdd;
								$path = 'img/items';					
								$folder_name = 'original';
								$multiple[] = array('folder_name'=>'thumb','height'=>'355','width'=>'300'); 
								$multiple[] = array('folder_name'=>'thumb_small','height'=>'120','width'=>'120'); 
								// Code to upload the image
								$response = $this->Common->upload_image($file, $path, $folder_name, true, $multiple);
								
								// check if filename return or error return
								$is_image_error = $this->Common->is_image_error($response);
								
								if($response == 'exist_error'){
									$this->Session->setFlash($is_image_error,'error');
								}elseif($response == 'size_mb_error'){
									$this->Session->setFlash($is_image_error,'error');
								}elseif($response == 'type_error'){
									$this->Session->setFlash($is_image_error,'error');
								}else{							
								
									$flag = true;
									$filename = $response;
									$data['ItemImage']['image'] = $filename;
									$data['ItemImage']['item_id'] = $itemId;
									
									$this->ItemImage->create();
									$this->ItemImage->save($data['ItemImage']);
									
								}
								} 
							} 
						}
						$this->Session->setFlash($msz,'default',array('class'=>'alert alert-success'));	
						$this->redirect(array('action' => 'index'));
					}
				} else{
					$this->request->data['Item']['category_id'] = "";
					$this->request->data['Item']['other_item_id'] = "";
				}
			}else{
                
                $this->request->data = $this->Item->read(null, base64_decode($id));
            }
			
			//Get relatedproduct array
			$relItems = $this->Item->find('list',array('conditions'=>array('Item.id <>'=>$id,'status'=>1,'is_deleted'=>0,'Item.company_id'=>$companyId),'fields'=>array('id','name')));
			$this->set('relItems',$relItems);
			$textAction = ($id == null) ? 'Add' : 'Edit';			
			$this->set('navitems','class = "active"');			
			$this->set('action',$textAction);			
			$this->set('breadcrumb','Items/'.$textAction);
			$buttonText = ($id == null) ? 'Submit' : 'Update';	
			$this->set('buttonText',$buttonText);
			
        }
		/*
            * admin_delete function
            * Functionality -  Add & edit the Showrooms
            * Developer - Navdeep kaur
            * Created date - 12-Feb-2014
            * Modified date - 
        */       
		function admin_delete($id = null)
		{
			$this->autoRender=false;
			$this->loadModel('ItemImage');
			if(!empty($id)){
				$id = base64_decode($id);
				$this->Item->id = $id;
				$imageData=$this->ItemImage->find('all',array('conditions'=>array('ItemImage.item_id'=>$id),'fields'=>array('image')));
				if(!empty($imageData)){
					foreach($imageData as $imageName){
					// Variable declaration
					$path = 'img/items';
					$folder_name = 'original';
					// Delete Image
					$this->Common->delete_image($imageName['Image']['name'], $path, $folder_name, true, $multiple);
					}
					$this->ItemImage->deleteAll(array('ItemImage.item_id'=>$id));
				}
				if($this->Item->updateAll(array('Item.is_deleted'=>'1'),array('Item.id'=>$id))){
					$this->Session->setFlash('Item deleted successfully.','default',array('class'=>'alert alert-success'));	
					$this->redirect(array("controller"=>"items","action" => "index"));
				}
			}
			else{
			$this->redirect(array("controller"=>"items","action" => "index"));	
			}
			
			
		}
		/*
            * admin_delete function
            * Functionality -  view products
            * Developer - Navdeep kaur
            * Created date - 12-Feb-2014
            * Modified date - 
        */       
		function admin_view($id = null)
		{
			$this->loadModel('ItemCategory');
			$this->loadModel('RelatedItem');
			$id = base64_decode($id);
			$this->Item->bindModel(array('hasMany'=>array('ItemCategory','RelatedItem')));
			$this->ItemCategory->bindModel(array('belongsTo'=>array('Category',array('foreignKey'=>'other_item_id'))));
			$this->RelatedItem->bindModel(array('belongsTo'=>array('Item')));
			$this->Item->bindModel(array('hasMany'=>array('ItemImage')));
			$data = $this->Item->find('first',array('conditions'=>array('Item.id'=>$id),'recursive'=>2));
			$this->set('data',$data);
			//pr($data); die;
			$this->set('navitems','class = "active"');		
						
			$this->set('breadcrumb','items/view');
		}
        /* To get image Name */
		function getUploadedImageName($imagePath)
		{		
			$imageArray = explode('/',$imagePath); // to get uploaded image name
			return end($imageArray); // uploaded image name
						
		}
		
		
		function delete_pic($imageId =  null)
		{
			$this->loadModel('ItemImage');
			$data = $this->ItemImage->find('first',array('conditions'=>array('ItemImage.id'=>$imageId)));
			if(!empty($data)){
				$imageName = 'items/thumb/'.$data['ItemImage']['image'];                
				if(file_exists(WWW_ROOT.'/img/'.$imageName) && !empty($val['image']))
				{
					unlink(WWW_ROOT.'/img/'.$imageName);
				    unlink(WWW_ROOT.'/img/items/original/'.$imageName);
				}
				$this->ItemImage->id = $imageId;
				$this->ItemImage->delete();
				echo "1"; exit;
			}
		}

    }

?>