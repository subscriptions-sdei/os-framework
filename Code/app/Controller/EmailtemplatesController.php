<?php
    /*
        * Email Template Controller class
        * Functionality -  Manage the Email templates Management
        * Developer - Gurpreet Singh Ahhluwalia
        * Created date - 12-Feb-2014
        * Modified date - 
    */
    class EmailtemplatesController extends AppController {        
        var $name = 'Emailtemplates';                
		public $components = array('Paginator');
		public $paginate = array(
        'limit' => 10,
        'order' => array(
            'Emailtemplate.id' => 'Asc'
				)
			);
        function beforeFilter(){
            parent::beforeFilter();    
            
        }     
		/*
            * admin_index function
            * Functionality -  Emailtemplates Listing
            * Developer - Gurpreet Singh Ahhluwalia
            * Created date - 12-Feb-2014
            * Modified date - 
        */
        function admin_index()
        {           
            #To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');
			
			$value ="";
			$show ="";
			$criteria=  "Emailtemplate.company_id = $companyId"; 
			
			if(!empty($this->params)){ 
					if(!empty($this->params->query['keyword'])){
						$value = trim($this->params->query['keyword']);	
					}
					if($value !="") {
						$criteria .= " AND Emailtemplate.name LIKE '%".$value."%'";						
					}
			}
			$this->Paginator->settings = array('conditions' => array($criteria),'limit'=>10,'order'=>'id DESC');
			$this->set('getData',$this->Paginator->paginate('Emailtemplate'));
			$this->set('keyword', $value);			
			$this->set('navemailtemplate','class = "active"');			
			$this->set('breadcrumb','emailtemplates');
			
        }
		
	
		
        /*
            * admin_addedit function
            * Functionality -  Add & edit the Emailtemplates
            * Developer - Gurpreet Singh Ahhluwalia
            * Created date - 12-Feb-2014
            * Modified date - 
        */
        function admin_addedit($id = null)
        {
			#To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');
			
			if(empty($this->request->data)){
				$this->request->data = $this->Emailtemplate->read(null, base64_decode($id));			
			}else
			if(isset($this->request->data) && !empty($this->request->data))
			{
				$this->request->data['Emailtemplate']['id'] = base64_decode($this->request->data['Emailtemplate']['id']);
				$this->Emailtemplate->set($this->request->data);	
				if($this->Emailtemplate->validates()) 				
				{
					$this->request->data['Emailtemplate']['company_id'] = $companyId;
										
					$this->request->data['Emailtemplate']['name'] = trim($this->request->data['Emailtemplate']['name']);					
					if($this->Emailtemplate->save($this->request->data,false))
					{ 	
						$this->Session->setFlash("Emailtemplate has been saved sucessfully.",'default',array('class'=>'alert alert-success'));	
						$this->redirect(array('action' => 'index'));
					}
				}    
			}
			$textAction = ($id == null) ? 'Add' : 'Update';			
			$this->set('navemailtemplate','class = "active"');			
			$this->set('action',$textAction);			
			$this->set('breadcrumb','emailtemplates/'.$textAction);
			$buttonText = ($id == null) ? 'Submit' : 'Update';	
			$this->set('buttonText',$buttonText);
			
        }
		
		
        
    
    }

?>