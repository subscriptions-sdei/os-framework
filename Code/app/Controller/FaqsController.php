<?php
    /*
        * Faqs Controller class
        * Functionality -  Manage the Faqs Management
        * Developer - Navdeep kaur
        * Created date - 21-Apr-2014
        * Modified date - 
    */
    class FaqsController extends AppController {        
        var $name = 'Faqs';                
		
		public $components = array('Paginator','Common');
		var $helpers = array('Common');
		
	
        
        function beforeFilter(){
            parent::beforeFilter();    
            
        }
        
                
        
		/*
            * admin_index function
            * Functionality -  Faqs Listing
            * Developer - Navdeep kaur
            * Created date - 21-Apr-2014
            * Modified date - 
        */
        function admin_index()
        {
			#To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');
			
            /* Active/Inactive/Delete functionality */
			if((isset($this->data["Faq"]["setStatus"])))
			{
				if(!empty($this->request->data['Faq']['status'])){
					$status = $this->request->data['Faq']['status'];
				}else
				{
					$this->Session->setFlash("Please select the action.",'default',array('class'=>'alert alert-danger'));	
					$this->redirect(array('action' => 'index'));
					
				}
				$CheckedList = $this->request->data['checkboxes'];
				$model='Faq';				
				$controller = $this->params['controller'];				
				$action = $this->params['action'];				
				$this->setStatus($status,$CheckedList,$model,$controller,$action); 			 
			}
			/* Active/Inactive/Delete functionality */			
			$value ="";
			$show ="";
			$criteria="is_deleted =0 AND Faq.company_id = $companyId"; 
			
			if(!empty($this->params)){ 
					if(!empty($this->params->query['keyword'])){
						$value = trim($this->params->query['keyword']);	
					}
					if($value !="") {
						$criteria .= " AND Faq.title LIKE '%".$value."%'";								
					}
			}
			$this->Paginator->settings = array('conditions' => array($criteria),'limit'=>10,'order'=>'id DESC');
			
            $this->set('getData',$this->Paginator->paginate('Faq'));
			
            $this->set('keyword', $value);
			$this->set('show', $show);
			$this->set('navfaqs','class = "active"');			
			$this->set('breadcrumb','Faqs');			
        }
		
        /*
            * admin_addedit function
            * Functionality -  Add & edit the Faqs
            * Developer - Navdeep kaur
            * Created date - 21-Apr-2014
            * Modified date - 
        */
        function admin_addedit($id = null)
        {
			#To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');
			
			if(empty($this->request->data)){				
					$this->request->data = $this->Faq->read(null, base64_decode($id));				
			}else
			if(isset($this->request->data) && !empty($this->request->data))
			{  $this->request->data['Faq']['id'] = base64_decode($this->request->data['Faq']['id']);
				$this->Faq->set($this->request->data);	
				if($this->Faq->validates()) 				
				{ 
					$this->request->data['Faq']['company_id'] = $companyId;					
					$this->request->data['Faq']['title'] = trim($this->request->data['Faq']['title']);					
					if($this->Faq->save($this->request->data))
					{ 	
						$this->Session->setFlash("Faq has been saved sucessfully.",'default',array('class'=>'alert alert-success'));	
						$this->redirect(array('action' => 'index'));
					}
				}    
			}
			$textAction = ($id == null) ? 'Add' : 'Edit';			
			$this->set('navfaqs','class = "active"');			
			$this->set('action',$textAction);			
			$this->set('breadcrumb','Faqs/'.$textAction);
			$buttonText = ($id == null) ? 'Submit' : 'Update';	
			$this->set('buttonText',$buttonText);
			
        }
		/*
            * admin_delete function
            * Functionality -  Add & edit the Faqs
            * Developer - Navdeep kaur
            * Created date - 21-Apr-2014
            * Modified date - 
        */       
		function admin_delete($id = null)
        {
			$id = base64_decode($id);
			$this->Faq->updateAll(array('Faq.is_deleted'=>'1'),array('Faq.id'=>$id));
			$this->Session->setFlash("Faq has been deleted sucessfully.",'default',array('class'=>'alert alert-success'));	
			$this->redirect('index');
		}
		
        
    
    }

?>