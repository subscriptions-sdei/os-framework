<?php
    /*
        * Users Controller class
        * Functionality -  Manage the Users Management
        * Developer -Navdeep kaur
        * Created date - 12-Feb-2014
        * Modified date - 
    */
    class UsersController extends AppController {
        var $name = 'Users';
        
        public $components = array('Paginator','Image','Common','Email');        
        
        function beforeFilter(){
            parent::beforeFilter();    
            
        }   
        /* Admin Functionality start */
        
        /*
            * admin_index function
            * Functionality -  Users Listing
            * Developer -Navdeep kaur
            * Created date - 12-Feb-2014
            * Modified date - 
        */
        function admin_index()
        {
			#To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');	
            /* Active/Inactive/Delete functionality */
			if((isset($this->data["User"]["setStatus"])))
			{
				if(!empty($this->request->data['User']['status'])){
					$status = $this->request->data['User']['status'];
				}else
				{
					$this->Session->setFlash("Please select the action.",'default',array('class'=>'alert alert-danger'));	
					$this->redirect(array('action' => 'index'));
					
				}
				$CheckedList = $this->request->data['checkboxes'];
				$model='User';				
				$controller = $this->params['controller'];				
				$action = $this->params['action'];				
				$this->setStatus($status,$CheckedList,$model,$controller,$action); 			 
			}
			/* Active/Inactive/Delete functionality */			
			$value ="";
			$value1= "";
			$show ="";
            $account_type ="";
			$criteria="User.is_deleted =0 AND User.company_id= $companyId"; 

			if(!empty($this->params)){ 
					if(!empty($this->params->query['keyword'])){
						$value = trim($this->params->query['keyword']);	
					}
					
					if($value !="") {
						$criteria .= " AND (User.first_name LIKE '%".$value."%' OR User.last_name LIKE '%".$value."%' OR User.email LIKE '%".$value."%')";						
					}
					if(!empty($this->params->query['alphabet_letter'])){
						$value1 = trim($this->params->query['alphabet_letter']);	
					}
					if($value1 !="") {
						$criteria .= " AND (User.first_name LIKE '".$value1."%')";						
					}
			}
			
            $this->Paginator->settings = array('conditions' => array($criteria),
				'limit' =>10,
				'fields' => array('User.id',
                                  'User.first_name',
                                  'User.last_name',
                                  'User.email',
                                  'User.gender',
								  'User.status',
								  'User.created',
                                  //'UserProfile.id'
                                  
								  ),
				'order' => array(
					'User.id' => 'DESC'
				)
            );
			$alphabetArray = array();
		//	$alphabetArray['0-9'] = '0-9';		
			for($i = 65 ; $i<=90; $i++)
			{
				$alphabetArray[chr($i)] = chr($i);
			}
			$this->set('getData',$this->Paginator->paginate('User'));
			$this->set('keyword', $value);
			$this->set('alphakeyword', $value1);
			$this->set('show', $show);
			$this->set('alphabetArray',$alphabetArray);
			$this->set('navusers','class = "active"');			
			$this->set('breadcrumb','Users');			
        }        
        /*
            * admin_addedit function
            * Functionality -  Add & edit the Users
            * Developer -Navdeep kaur
            * Created date - 12-Feb-2014
            * Modified date - 
        */
        function admin_addedit($id = null)
        {
			#To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');
			
            if(empty($this->request->data)){				
					$this->request->data = $this->User->read(null, base64_decode($id));
			}else
			if(isset($this->request->data) && !empty($this->request->data))
			{
				$this->request->data['User']['company_id'] = $companyId;
				$this->request->data['User']['id'] = base64_decode($this->request->data['User']['id']);
				if($this->request->data['User']['id'] == ""){
					$this->request->data['User']['password'] = md5($this->request->data['User']['password']);	
				}
				
                $this->User->set($this->request->data);	
				if($this->User->validates()) 				
				{ 													
					if($this->User->save($this->request->data))
					{ 	
                        $this->Session->setFlash("User has been added sucessfully.",'default',array('class'=>'alert alert-success'));	
						$this->redirect(array('action' => 'index'));
					}
				}    
			}
			// Calling arrays
			$this->getCountries();
			$textAction = ($id == null) ? 'Add' : 'Edit';			
			$this->set('navusers','class = "active"');			
			$this->set('action',$textAction);			
			$this->set('breadcrumb','Users/'.$textAction);
			$buttonText = ($id == null) ? 'Submit' : 'Update';	
			$this->set('buttonText',$buttonText);
			
        }
        /*
            * admin_view function
            * Functionality -  User detail view
            * Developer -Navdeep kaur
            * Created date - 24-Feb-2014
            * Modified date - 
        */
        function admin_view($id = null)
        {
            $getData =  array();
            if(!empty($id))
            {
                $conditions = "User.id = ".base64_decode($id);	
                $getData = $this->User->find('first',array('conditions' => array($conditions)));                
            }
            $this->set(compact('getData'));
        }
        
        /*
            * admin_delete function
            * Functionality -  Add & edit the Users
            * Developer -Navdeep kaur
            * Created date - 12-Feb-2014
            * Modified date - 
        */       
		function admin_delete($id = null)
        {
			if(!empty($id))
			{
				$id = base64_decode($id);
				if($this->User->updateAll(array('User.is_deleted'=>'1'),array('User.id'=>$id))){
					$this->Session->setFlash("User has been deleted sucessfully.",'default',array('class'=>'alert alert-success'));	
					$this->redirect('index');
				}				
			}
		}
# common function to get country realted states	

	public function get_states(){
		$this->layout = '';
        $this->autoRender = false;
		
		$states = array();
		$this->loadModel('State');
		if(!empty($this->request->data)){
			$country_id = $this->request->data['State']['country_id'];
			$states = $this->State->find('all',array('conditions'=>array('State.country_id'=>$country_id,'State.name <>'=>'null'),'order'=>array('State.name ASC'),'fields'=>array('State.id','name')));
		}
		echo json_encode($states);
        exit();
	}	
        /* Admin Functionality end */        
        
       
        
        
}
?>
