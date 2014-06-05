<?php
    /*
        * Staticpages Controller class
        * Functionality -  Manage the Staticpages Management
        * Developer - Navdeepk
        * Created date - 21-Apr-2014
        * Modified date - 
    */
    class StaticpagesController extends AppController {        
        var $name = 'Staticpages';                
		
		public $components = array('Paginator','Common');
		var $helpers = array('Common');
		
		public $paginate = array(
        'limit' => 10,
        'order' => array(
            'Staticpage.title' => 'asc'
				)
			);
        
        function beforeFilter(){
            parent::beforeFilter();    
            
        }
        
        /*
            * index function
            * Functionality -  Staticpages Listing
            * Developer - Navdeepk
            * Created date - 21-Apr-2014
            * Modified date - 
        */
        
        function index($pageName = null)
        {
			$getPageArr = array();
            if(!empty($pageName))
            {
                $getPageArr = $this->Staticpage->find('first',array('fields' => array('Staticpage.id','Staticpage.title','Staticpage.description'),'conditions' => array('Staticpage.page_name' => $pageName)));
                $this->set($pageName.'link','active');	            
            }
            $this->set(compact('getPageArr'));  
        }
        
        
        
		/*
            * admin_index function
            * Functionality -  Staticpages Listing
            * Developer - Navdeepk
            * Created date - 21-Apr-2014
            * Modified date - 
        */
        function admin_index()
        {
			#To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');
			/* Active/Inactive/Delete functionality */
			if((isset($this->request->data["Staticpage"]["setStatus"])))
			{
				if(!empty($this->request->data['Staticpage']['status'])){
					$status = $this->request->data['Staticpage']['status'];
				}else
				{
					$this->Session->setFlash("Please select the action.",'default',array('class'=>'alert alert-danger'));	
					$this->redirect(array('action' => 'index'));
					
				}
				$CheckedList = $this->request->data['checkboxes'];
				$model='Staticpage';				
				$controller = $this->params['controller'];				
				$action = $this->params['action'];				
				$this->setStatus($status,$CheckedList,$model,$controller,$action); 			 
			}
			/* Active/Inactive/Delete functionality */
           $value ="";
			$show ="";
			$criteria="is_deleted = 0 AND Staticpage.company_id = $companyId"; 
			
			if(!empty($this->params)){ 
					if(!empty($this->params->query['keyword'])){
						$value = trim($this->params->query['keyword']);	
					}
					if($value !="") {
						$criteria .= " AND Staticpage.title LIKE '%".$value."%'";				
					}
			}
			$this->Paginator->settings = array('conditions' => array($criteria),'limit'=>10,'order'=>'id DESC');
            $this->set('getData',$this->Paginator->paginate('Staticpage'));			
            $this->set('keyword', $value);
			$this->set('show', $show);
			$this->set('navstaticpages','class = "active"');			
			$this->set('breadcrumb','Staticpages');			
        }
		
        /*
            * admin_addedit function
            * Functionality -  Add & edit the Staticpages
            * Developer - Navdeepk
            * Created date - 21-Apr-2014
            * Modified date - 
        */
        function admin_addedit($id = null)
        {
			#To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');
			if(empty($this->request->data)){				
					$this->request->data = $this->Staticpage->read(null, base64_decode($id));				
			}else
			if(isset($this->request->data) && !empty($this->request->data))
			{  
				$this->Staticpage->set($this->request->data);	
				if($this->Staticpage->validates()) 				
				{
					$this->request->data['Staticpage']['company_id'] = $companyId;
					$this->request->data['Staticpage']['id'] = base64_decode($this->request->data['Staticpage']['id']);					
					$this->request->data['Staticpage']['title'] = trim($this->request->data['Staticpage']['title']);					
					if($this->Staticpage->save($this->request->data))
					{ 	
						$this->Session->setFlash("Page has been saved sucessfully.",'default',array('class'=>'alert alert-success'));	
						$this->redirect(array('action' => 'index'));
					}
				}    
			}
			$textAction = ($id == null) ? 'Add' : 'Edit';
			$buttonText = ($id == null) ? 'Submit' : 'Update';
			$this->set('navstaticpages','class = "active"');			
			$this->set('action',$textAction);			
			$this->set('breadcrumb','Staticpages/'.$textAction);
			$this->set('buttonText',$buttonText);
			
        }
        
    
    }

?>