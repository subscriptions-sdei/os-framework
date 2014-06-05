<?php
    /*
        * Admins Controller class
        * Functionality -  Manage the admin login,listing,add 
        * Developer - Navdeep
        * Created date - 11-Feb-2014
        * Modified date - 
    */
    	App::uses('Sanitize', 'Utility'); 
    class AdminsController extends AppController {
	
        var $name = 'Admins';        
        var $components = array('Email','Cookie','Common','Paginator','Paypal','Braintree','Twilio.Twilio');
		   
        function beforeFilter(){
            parent::beforeFilter();    
            
        }        
        /*
            * admin_login function
            * Functionality -  Admin login functionality
            * Developer - Navdeep
            * Created date - 11-Feb-2014
            * Modified date - 
        */
        function admin_login() {        
            $userId = $this->Session->read('loggedUserInfo.id');            
            if(!empty($userId)) {
                $this->redirect('dashboard');
            }
            $this->layout = 'admin_login';
			$this->set('title','Sign in');
           
			if(isset($this->request->data) && (!empty($this->request->data)))
            {	
				$this->Admin->set($this->request->data);
				$this->Admin->validator()->remove('email', 'rule1');
				
				if($this->Admin->validates(array('fieldList' => array('email', 'password')))) 
				{	
					//$email = mysql_real_escape_string($this->request->data['Admin']['email']);
					//$user_password  = md5(mysql_real_escape_string($this->request->data['Admin']['password']));
					$email = $this->request->data['Admin']['email'];
					$user_password  = md5($this->request->data['Admin']['password']);					
					$userInfo = $this->Admin->find('first',array('fields'=>array('id','first_name','last_name','email','welcome','password','admin_role_id','company_id'),'conditions'=>array("Admin.email" => $email,"Admin.password" => $user_password,"Admin.status"=>1,"Admin.is_deleted"=>0)));                
					if(!empty($userInfo['Admin']['password']) && ($userInfo['Admin']['password'] == $user_password) ) {
						$this->Session->write('loggedUserInfo', $userInfo['Admin']);
						$this->Session->write('ADMIN_SESSION', $userInfo['Admin']['id']);						  
						if(!empty($this->request->data['Admin']['remember_me'])) {
						$email = $this->Cookie->read('AdminEmail');
						$password = base64_decode($this->Cookie->read('AdminPass'));						
						if(!empty($email) && !empty($password)) {
								$this->Cookie->delete('AdminEmail');
								$this->Cookie->delete('AdminPass');     
						} 						
						$cookie_email = $this->request->data['Admin']['email'];						
						$this->Cookie->write('AdminEmail', $cookie_email, false, '+2 weeks');						
						$cookie_pass = $this->request->data['Admin']['password'];
						$this->Cookie->write('AdminPass', base64_encode($cookie_pass), false, '+2 weeks'); 
						}else {
							$email = $this->Cookie->read('AdminEmail');
							$password = base64_decode($this->Cookie->read('AdminPass'));
							if(!empty($email) && !empty($password)) {
									$this->Cookie->delete('AdminEmail');
									$this->Cookie->delete('AdminPass');     
							}
						}
						$this->redirect('dashboard');                    
					}
					else {						
						$this->Session->setFlash("Email or Password is incorrect",'default',array('class'=>'flashError'));							
						//$this->render();
					}
				}else{
						$this->Session->setFlash("Please enter the valid Email or Password.",'default',array('class'=>'flashError'));	
						//$this->render();
					}
            }else {
				$email = $this->Cookie->read('AdminEmail');
				$password = base64_decode($this->Cookie->read('AdminPass'));				
				if(!empty($email) && !empty($password)) {
					$remember_me  = true;
					$this->request->data['Admin']['email']  = $email;
					$this->request->data['Admin']['password']  = $password;					
				}				
			}
			$this->set('remember_me',$remember_me);
        }     
        
		/*
            * admin_dashboard function
            * Functionality -  Dashboard functionality
            * Developer - Navdeep
            * Created date - 11-Feb-2014
            * Modified date - 
        */
        function admin_dashboard()
        {
            
            $this->set('navdashboard','class = "active"');
			$this->set('breadcrumb','Dashboard');
        }
		
		/*
            * admin_index function
            * Functionality -  Admins Listing
            * Developer - Navdeep
            * Created date - 11-Feb-2014
            * Modified date - 
        */
        function admin_index()
        {            
			#To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');
			/* Active/Inactive/Delete functionality */
			if((isset($this->data["Admin"]["setStatus"])))
			{
				if(!empty($this->request->data['Admin']['status'])){
					$status = $this->request->data['Admin']['status'];
				}else
				{
					$this->Session->setFlash("Please select the action.",'default',array('class'=>'alert alert-danger'));	
					$this->redirect(array('action' => 'index'));
					
				}
				$CheckedList = $this->request->data['checkboxes'];
				$model='Admin';				
				$controller = $this->params['controller'];				
				$action = $this->params['action'];				
				$this->setStatus($status,$CheckedList,$model,$controller,$action); 			 
			}
			/* Active/Inactive/Delete functionality */			
			$value ="";
			$value1= "";
			$show ="";
            $account_type ="";
			
			$criteria="Admin.is_deleted =0 AND Admin.id != 1 AND Admin.company_id =$companyId"; 
			if($companyId != 1){
				$criteria .= " AND Admin.admin_role_id <> 2";
			}
			if(!empty($this->params)){ 
					if(!empty($this->params->query['keyword'])){
						$value = trim($this->params->query['keyword']);	
					}
					if($value !="") {
						$criteria .= " AND (Admin.first_name LIKE '%".$value."%' OR Admin.last_name LIKE '%".$value."%' OR Admin.email LIKE '%".$value."%')";												
					}
			}
            $this->Paginator->settings = array('conditions' => array($criteria),
				'limit' => 10,
				'fields' => array('Admin.id',
                                  'Admin.first_name',
                                  'Admin.last_name',
                                  'Admin.email',
								  'Admin.phone',
								  'Admin.status',
								  'Admin.created',
                                  //'AdminProfile.id'
                                  
								  ),
				'order' => array(
					'Admin.id' => 'DESC'
				)
            );
			
			$this->set('getData',$this->Paginator->paginate('Admin'));
			$this->set('keyword', $value);
	
			$this->set('show', $show);
			
			$this->set('navadmins','class = "active"');			
			$this->set('breadcrumb','Admins');
			
			
        }
		
        /*
            * admin_addedit function
            * Functionality -  Add & edit the admin profile
            * Developer - Navdeep
            * Created date - 11-Feb-2014
            * Modified date - 
        */
        function admin_addedit($id = null)
        {
			#To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');
			$this->loadModel('AdminRole');
			
			if($id =="me"){
				$id = base64_encode($this->Session->read('loggedUserInfo.id'));
			}
			//$id = ($id == null) ? $this->Session->read('loggedUserInfo.id') : $id;
			if(empty($this->request->data)){
				$this->request->data = $this->Admin->read(null, base64_decode($id));			
			}else
			if(isset($this->request->data) && !empty($this->request->data))
			{    $this->request->data['Admin']['company_id'] = $companyId;
			//pr($this->request->data); die;
				$this->Admin->set($this->request->data);				
				
				if ($this->Admin->validates(array('fieldList' => array('first_name','email')))) 				
				{ 
					if($id == ""){
						$this->request->data['Admin']['password'] = md5($this->request->data['Admin']['password']);	
					}
					
					if($this->Admin->save($this->request->data))
					{ 						
						$this->Session->setFlash("The Profile has been updated successfully.",'default',array('class'=>'alert alert-success'));	
						$this->redirect(array('action' => 'index'));
					}
				}    
			}
			$roleData = $this->AdminRole->find('list',array('conditions'=>array('is_deleted'=>0,'status'=>1,'AdminRole.company_id'=>$companyId),'fields'=>array('id','role_name')));
			$this->set('roles',$roleData);
			$textAction = ($id == null) ? 'Add' : 'Edit';
			$buttonText = ($id == null) ? 'Submit' : 'Update';		
			$this->set('navadmins','class = "active"');			
			$this->set('action',$textAction);			
			$this->set('breadcrumb','Admins/'.$textAction);
			$this->set('buttonText',$buttonText);
        }
		
        /*
            * admin_addedit function
            * Functionality -  Add & edit the admin profile
            * Developer - Navdeep
            * Created date - 11-Feb-2014
            * Modified date - 
        */		
        function admin_changepassword()
        {
			if(isset($this->request->data) && !empty($this->request->data))
			{	
				$id = $this->Session->read('loggedUserInfo.id');				
				$userInfo = $this->Admin->find('first',array('fields'=>array('id','password','email','first_name','last_name'),'conditions'=>array("Admin.id" => $id)));				
				$Oldassword  = md5(trim($this->request->data['Admin']['old_password']));
				
				if(!empty($userInfo['Admin']['password']) && ($userInfo['Admin']['password'] == $Oldassword) ) {
					unset($this->request->data['Admin']['old_password']);
					unset($this->request->data['Admin']['confirm_password']);
					$this->request->data['Admin']['id'] = $id;
					$this->request->data['Admin']['password'] = md5(trim($this->request->data['Admin']['password']));
					if($this->Admin->save($this->request->data))
					{ 						
						App::import('Model','Emailtemplate');
						$this->Emailtemplate = new Emailtemplate;
						$SITE_URL = Configure::read('BASE_URL');
						
						//$active =  '<a href = "' .$SITE_URL. '/admin/admins/verify/'.sha1($hashCode).'">Link </a>'; 
						$template = $this->Emailtemplate->getEmailTemplate('change_admin_password');
						$to = $userInfo['Admin']['email'];
						$data1 = $template['Emailtemplate']['template'];					
						
						$data1 = str_replace('{FirstName}',ucfirst($userInfo['Admin']['first_name']),$data1);
						$data1 = str_replace('{LastName}',ucfirst($userInfo['Admin']['last_name']),$data1);
						$data1 = str_replace('{Email}',$userInfo['Admin']['email'],$data1);			
						$subject = ucfirst(str_replace('_', ' ', $template['Emailtemplate']['name']));
						$send_mail = $this->sendEmail($to,$subject,$data1);  
						$this->Session->setFlash("Password has been updated successfully.",'default',array('class'=>'alert alert-success'));					}
				}else{
					$this->Session->setFlash("Entered password does not match.Please try again.",'default',array('class'=>'alert alert-danger'));				}				
					$this->redirect(array('action' => 'changepassword'));
			}
			
			
			$this->set('navadmins','class = "active"');
			$this->set('breadcrumb','Change Password');
        }
       
	   
		/*
            * admin_addedit function
            * Functionality -  Add & edit the admin profile
            * Developer - Navdeep
            * Created date - 11-Feb-2014
            * Modified date - 
        */		
        function admin_forgot_password()
        {
            $this->layout = 'admin_login';
			$this->set('title','Forgot Password');
			$this->set('title_for_layout','Forgot Password');
			
			if(!empty($this->request->data)){
				$this->request->data = Sanitize::clean($this->request->data, array('encode' => false));
				
				
				if(empty($this->request->data['Admin']['email'])){ 
					$this->Session->setFlash('Please enter your email.','default',array('class'=>'alert alert-danger'));
					$this->redirect(array('controller'=>'users','action'=>'forgot_password'));
				}
				//$this->Admin->validate=$this->Admin->validateForgotPassword;
				
				//if($this->Admin->validates()) { 
					if(!empty($this->request->data['Admin']['email'])){ 
						$getStatus = $this->checkEmailValidation($this->request->data['Admin']['email']);
						if($getStatus) { 
							$userArr=$this->Admin->find('first',array('conditions'=>array('Admin.email'=>trim($this->request->data['Admin']['email']),'Admin.status'=>1),'fields'=>array('Admin.id','Admin.first_name','Admin.last_name','Admin.email')));
							
							if(count($userArr) > 0){  
								$passwd = $this->Common->getRandPass();
								$this->Admin->id = $userArr['Admin']['id'];
								$hashCode =  md5(uniqid(rand(), true));
								$this->Admin->saveField('random_key',$hashCode, false);
								App::import('Model','Emailtemplate');
								$this->Emailtemplate = new Emailtemplate;
								$SITE_URL = Configure::read('BASE_URL');
								//$to = $userArr['Admin']['email'];
								$link =  '<a href = "' .$SITE_URL. '/admin/admins/secure_check/'.$hashCode.'">Link </a>';  
								$template = $this->Emailtemplate->getEmailTemplate('admin_forgot_password');
								$to = $userArr['Admin']['email'];
								$data1 = $template['Emailtemplate']['template'];					
								$data1 = str_replace('{FirstName}',ucfirst($userArr['Admin']['first_name']),$data1);
								$data1 = str_replace('{LastName}',ucfirst($userArr['Admin']['last_name']),$data1);
								$data1 = str_replace('{Email}',$userArr['Admin']['email'],$data1);
								
								$data1 = str_replace('[LINK]',$link,$data1);			
								$subject = ucfirst(str_replace('_', ' ', $template['Emailtemplate']['name']));
								
								$send_mail = $this->sendEmail($to,$subject,$data1);
								$this->Session->setFlash('Please check your mailbox to access the account.','default',array('class'=>'alert alert-danger'));
								$this->redirect(array('controller'=>'admins','action'=>'login'));
							} else{ 
								$this->Session->setFlash('Invalid email address.','default',array('class'=>'alert alert-danger'));
								$this->redirect(array('controller'=>'admins','action'=>'forgot_password'));
							}
						} else { 
							$this->Session->setFlash('You have entered wrong email address.','default',array('class'=>'alert alert-danger'));
							$this->redirect(array('controller'=>'admins','action'=>'forgot_password'));
						}
					}
				//}
			}
			
        }
		
		function admin_secure_check($uniqueKey){
			$this->layout = 'admin_login';
			$this->set('title','Forgot Password');
			$this->set('title_for_layout','Forgot Password');
			$this->set('uniqueKey',$uniqueKey);
			$data = $this->Admin->find('first',array('conditions'=>array('Admin.random_key'=>$uniqueKey)));
			if(empty($data)){
				$this->Session->setFlash('Error Occured, Plesae check your secure code.','default',array('class'=>'alert alert-danger'));
				$this->redirect(array('controller'=>'admins','action'=>'login'));
			}
			if(!empty($this->request->data)){
				$adminId = $data['Admin']['id'];
				$this->request->data['Admin']['id'] = $adminId;
				$this->request->data['Admin']['password'] = md5($this->request->data['Admin']['password']);
				$this->request->data['Admin']['random_key'] = "";
				$this->Admin->save($this->request->data);
				$this->Session->setFlash('Password changed successfully','default',array('class'=>'alert alert-success'));
				$this->redirect(array('controller'=>'admins','action'=>'login'));
			}
		}
		/**
	Function Name:   checkEmailValidation
	params:          NULL	
	Description :    for the email validation - Front end
	*/
	public function checkEmailValidation($email){
		$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
		if (eregi($pattern, $email)){
		   return true;
		} else {
		   return false; 
		}
	}
		
        /*
            * admin_logout function
            * Functionality -  Logout Admin 
            * Developer - Navdeep
            * Created date - 11-Feb-2014
            * Modified date - 
        */
        function admin_logout(){		            
            $this->Session->delete('loggedUserInfo');			
            $this->redirect('login');
        }
    
    
	
	public function admin_newsletters() {
		#To get company Id
		$companyId = $this->Session->read('loggedUserInfo.company_id');
		
		$this->loadModel('Newsletter');
		$value ="";
		$show ="";
		$criteria="is_deleted = 0 AND Newsletter.company_id = $companyId"; 
		
		
		if(!empty($this->params)){ 
					if(!empty($this->params->query['keyword'])){
						$value = trim($this->params->query['keyword']);	
					}
					if($value !="") {
						$criteria .= " AND Newsletter.title LIKE '%".$value."%'";							
					}
			}

		$this->Paginator->settings = array('conditions' => array($criteria),'order'=>'id desc','limit'=>10); 
		
		$this->set('getData',$this->Paginator->paginate('Newsletter'));
		$this->set('keyword', $value);			
		$this->set('navNewsletter','class = "active"');			
		$this->set('breadcrumb','Newsletters');		
		
	}
	function admin_add_newsletter($id = null)
        {
			#To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');
			
			$this->loadModel('Newsletter');
			$this->loadModel('NewsletterTemplate');
			if(empty($this->request->data)){
				$this->request->data = $this->Newsletter->read(null, base64_decode($id));			
			}else
			if(isset($this->request->data) && !empty($this->request->data))
			{ // pr($this->request->data); die;
				$this->Newsletter->set($this->request->data);	
				if($this->Newsletter->validates()) 				
				{
					$this->request->data['Newsletter']['company_id'] = $companyId;
					$flag = 0;
					if(isset($this->request->data['save_send_button']) && $this->request->data['save_send_button'] == "save_send"){
						$flag = 1;

					}
					if($this->request->data['Newsletter']['send_type'] == 1){
						$bDate = explode('/',$this->data['Newsletter']['schedule_date']);
                        
						$schDate = $bDate[2].'-'.$bDate[0].'-'.$bDate[1];
						$this->request->data['Newsletter']['schedule_date'] = $schDate;
					}
					$this->request->data['Newsletter']['id'] = base64_decode($this->request->data['Newsletter']['id']);					
					$this->request->data['Newsletter']['title'] = trim($this->request->data['Newsletter']['title']);
										
					if($this->Newsletter->save($this->request->data))
					{ $newsltterId = $this->Newsletter->id;
						if($flag ==1){
							$this->Session->setFlash("Newsletter has been saved sucessfully,select users to whom you wish to send newsletter.",'default',array('class'=>'alert alert-success'));	
							$this->redirect('/admin/admins/send_newsletter/'.base64_encode($newsltterId));
						}
						$this->Session->setFlash("Newsletter has been saved sucessfully.",'default',array('class'=>'alert alert-success'));	
						$this->redirect(array('action' => 'newsletters'));
					}
				}    
			}
			$template = $this->NewsletterTemplate->find('list',array('conditions'=>array('is_deleted'=>0,'company_id'=>$companyId),'fields'=>array('id','title')));
			$this->set('template',$template);
			$textAction = ($id == null) ? 'Add' : 'Update';			
			$this->set('navNewsletter','class = "active"');			
			$this->set('action',$textAction);			
			$this->set('breadcrumb','Newsletters/'.$textAction);
			$buttonText = ($id == null) ? 'Submit' : 'Update';	
			$this->set('buttonText',$buttonText);
			
        }
		
	/*****Newsletters Template Functions***********************************/
	public function admin_newsletterTemplate() {
		#To get company Id
		$companyId = $this->Session->read('loggedUserInfo.company_id');
	$this->loadModel('NewsletterTemplate');
		$value ="";
		$show ="";
		$criteria="is_deleted = 0 AND NewsletterTemplate.company_id = $companyId"; 
		if(!empty($this->request->data['Search'])){
			if(isset($this->request->data['Search']['keyword']) && !empty($this->request->data['Search']['keyword'])){		   
				$value = $this->request->data['Search']['keyword'];				  
			}	
			if($value !="") {
					$criteria .= " AND NewsletterTemplate.title LIKE '%".$value."%'";						
			}				
			
		}
		$this->Paginator->settings = array('conditions' => array($criteria));
		$this->set('getData',$this->Paginator->paginate('NewsletterTemplate'));
		$this->set('keyword', $value);			
		$this->set('navNewsletterTemplate','class = "active"');			
		$this->set('breadcrumb','NewsletterTemplate');		
		
	}
	function admin_add_template($id = null)
        {
			#To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');
			
			$this->loadModel('NewsletterTemplate');
			if(empty($this->request->data)){
				$this->request->data = $this->NewsletterTemplate->read(null, base64_decode($id));			
			}else
			if(isset($this->request->data) && !empty($this->request->data))
			{
				$this->request->data['NewsletterTemplate']['id'] = base64_decode($this->request->data['NewsletterTemplate']['id']);					
				$this->NewsletterTemplate->set($this->request->data);	
				if($this->NewsletterTemplate->validates()) 				
				{ 
					$this->request->data['NewsletterTemplate']['company_id'] = $companyId;
					$this->request->data['NewsletterTemplate']['title'] = trim($this->request->data['NewsletterTemplate']['title']);					
					if($this->NewsletterTemplate->save($this->request->data))
					{ 	
						$this->Session->setFlash("NewsletterTemplate has been saved sucessfully.",'default',array('class'=>'alert alert-success'));	
						$this->redirect(array('action' => 'newsletterTemplate'));
					}
				}    
			}
			$textAction = ($id == null) ? 'Add' : 'Update';			
			$this->set('navNewsletterTemplate','class = "active"');			
			$this->set('action',$textAction);
			$this->set('breadcrumb','Newsletters/Newsletter Templates/'.$textAction);
			$buttonText = ($id == null) ? 'Submit' : 'Update';	
			$this->set('buttonText',$buttonText);
			
        }
	function admin_send_newsletter($newsletterId=null){
		$newsletterId=  base64_decode($newsletterId);
		$this->loadModel('Newsletter');
		$this->loadModel('User');
	
		
		$userData = $this->User->find('all',array('conditions'=>array('User.status'=>1),'fields'=>array('User.id','User.first_name','User.last_name','User.email')));
		$this->set('userData',$userData);
		$this->set('newsletterId',$newsletterId);
		if(!empty($this->request->data)){ 
		$data = $this->Newsletter->find('first',array('conditions'=>array('Newsletter.id'=>$this->request->data['Newsletter']['id'])));
		if($this->request->data['Newsletter']['send_to'] == 0){
			$userData = $this->User->find('list',array('conditions'=>array('User.status'=>1,'User.is_deleted'=>0),'fields'=>array('User.id','User.email')));
		}
		$userData = $this->request->data['Newsletter']['user_id'];

			foreach($userData as $uData){
				$to = $uData;
				$data1 = $data['Newsletter']['description'];					
					
				$subject = ucfirst(str_replace('_', ' ',$data['Newsletter']['title']));
				
				$send_mail = $this->sendEmail($to,$subject,$data1);
				
				
			}
			$this->Newsletter->id = $this->request->data['Newsletter']['id'];
				$this->Newsletter->saveField('is_sent', 1);
			$this->Session->setFlash("Newsletter sent sucessfully.",'default',array('class'=>'alert alert-success'));	
			$this->redirect(array('action' => 'newsletters'));
		}
		$this->set('breadcrumb','Newsletters/Send Newsletter');
	}
	 /*
            * admin_addrole function
            * Functionality -  Add & edit the admin profile
            * Developer - Navdeep
            * Created date - 11-Feb-2014
            * Modified date - 
        */
        function admin_addRole($id = null)
        {
			#To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');
			$this->loadModel('AdminRole');
			if(isset($this->request->data) && !empty($this->request->data)) 
			{   //pr($this->request->data); die;
				$this->request->data['AdminRole']['id'] = base64_decode($this->request->data['AdminRole']['id']);
				$this->AdminRole->set($this->request->data);	
				if($this->AdminRole->validates()) 				
				{ 
					if($id){
                        
                        $msz= "Role updated sucessfully.";
                    }else{
                        $msz= "Role saved sucessfully.";
                    }
					$this->request->data['AdminRole']['company_id']  = $companyId;
					if($this->AdminRole->save($this->request->data))
					{						
						$this->Session->setFlash($msz,'default',array('class'=>'alert alert-success'));	
						$this->redirect(array('action' => 'listRoles'));
					}
				}    
			}else{
                
                $this->request->data = $this->AdminRole->read(null, base64_decode($id));
            }
			$textAction = ($id == null) ? 'Add' : 'Edit';			
			$this->set('navitems','class = "active"');			
			$this->set('action',$textAction);			
			$this->set('breadcrumb','Roles And Permissions/'.$textAction);
			$buttonText = ($id == null) ? 'Submit' : 'Update';	
			$this->set('buttonText',$buttonText);
        }
		 function admin_listRoles()
        {
			#To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');
        $this->loadModel('AdminRole');
			/* Active/Inactive/Delete functionality */
			if((isset($this->data["AdminRole"]["setStatus"])))
			{
				if(!empty($this->request->data['AdminRole']['status'])){
					$status = $this->request->data['AdminRole']['status'];
				}else
				{
					$this->Session->setFlash("Please select the action.",'default',array('class'=>'alert alert-danger'));	
					$this->redirect(array('action' => 'adminRoles'));
					
				}
				$CheckedList = $this->request->data['checkboxes'];
				$model='AdminRole';				
				$controller = $this->params['controller'];				
				$action = $this->params['action'];				
				$this->setStatus($status,$CheckedList,$model,$controller,$action); 			 
			}
			/* Active/Inactive/Delete functionality */			
			$value ="";
			$value1= "";
			$show ="";
            $account_type ="";
			$criteria="AdminRole.is_deleted = 0 AND AdminRole.id != 1 AND AdminRole.company_id = $companyId"; 
			if(!empty($this->request->data['Search'])){ //pr($this->request->data); die;
                if(isset($this->request->data['Search']['keyword']) && !empty($this->request->data['Search']['keyword'])){		   
					$value = $this->request->data['Search']['keyword'];				  
				}

				
				if($value !="") {
						$criteria .= " AND (AdminRole.role_name LIKE '%".$value."%')";						
				}
                            
              				
				
			}			
            $this->Paginator->settings = array('conditions' => array($criteria),
				'limit' => 10,
				'fields' => array('AdminRole.id',
                                  'AdminRole.role_name', 
								  'AdminRole.status',
								  'AdminRole.created',
                                  //'AdminProfile.id'
                                  
								  ),
				'order' => array(
					'AdminRole.id' => 'DESC'
				)
            );
			
			$this->set('getData',$this->Paginator->paginate('AdminRole'));
			$this->set('keyword', $value);
	
			$this->set('show', $show);
			
			$this->set('navroles','class = "active"');			
			$this->set('breadcrumb','Roles And Permissions');
			
			
        }
	function admin_deleteRole($id = null)
	{
		$this->loadModel('AdminRole');
		if(!empty($id))
		{
			$id = base64_decode($id);
			if($this->AdminRole->updateAll(array('AdminRole.is_deleted'=>'1'),array('AdminRole.id'=>$id))){
				$this->Session->setFlash("Role has been deleted sucessfully.",'default',array('class'=>'alert alert-success'));	
				$this->redirect('listRoles');
			}				
		}
	}
	function admin_viewRole($id = null){
		$this->loadModel('AdminRole');
		if(!empty($id))
		{
			$id = base64_decode($id);
			$getData = $this->AdminRole->find('first',array('conditions'=>array('AdminRole.id'=>$id)));
			$this->set('getData',$getData);
							
		}
	}
	function admin_permissions($id = null){
		
		$this->set('id',$id);
		$this->layout = 'admin';		
		$this->loadModel("Module");
		$this->loadModel("RolePermission");
		if(!empty($this->request->data)){// pr($this->request->data); die;
		$this->request->data['RolePermission']['role_id']= base64_decode($this->request->data['RolePermission']['role_id']);
		$permissionarr= '';
		foreach($this->request->data['RolePermission']['permission_id'] as $key =>$val ){
			if($val != 0){
			$permissionarr[]  = $key;
			}
		}
		//pr($permissionarr); die;
		if(!empty($permissionarr)){
			$this->request->data['RolePermission']['permission_ids'] = implode(',',$permissionarr);
		}else{
			$this->request->data['RolePermission']['permission_ids'] = "";
		}
		 
		  $this->RolePermission->save($this->request->data);
		  $this->redirect(array("controller" => "admins","action" => "listRoles"));
		}
		$role_data = $this->RolePermission->find('first',array('conditions'=>array('RolePermission.role_id'=>base64_decode($id))));
		$this->set('role_data',$role_data);
		$permissions = $this->Module->find('all');
		$this->set('permissions',$permissions);
		$this->set('navroles','class = "active"');			
		$this->set('breadcrumb','Roles And Permissions/Assign Permissions');
    }
	function admin_getAllLinks(){
		$this->loadModel('RolePermission');
		$this->loadModel('Module');
		
		$id = $this->Session->read('loggedUserInfo.admin_role_id');
		if($id != ""){
			$data = $this->Module->find('all',array('order'=>'module_name ASC'));
			
			$rolData = $this->RolePermission->find('first',array('conditions'=>array('role_id'=>$id)));
			if(!empty($rolData)){
				$rolePermArr = explode(',',$rolData['RolePermission']['permission_ids']);
			}else{
				$rolePermArr[] ="";
			}
			$i =0 ;
			$links[] ="";
			foreach($data as $module){
				if(in_array($module['Module']['id'],$rolePermArr)){
					$links[$i]['Controller'] =  $module['Module']['controller'];
					$links[$i]['Action'] =  $module['Module']['action'];
					$links[$i]['Name'] =  $module['Module']['module_name'];
					$i++;
				}
				
			}
			
			return $links; 
		}else{
			$links[] ="";
			return $links; 
		}
		

	}
	
	// To get newsletter template
	function admin_getNewletterTemplate($templateId){
		$this->loadModel('NewsletterTemplate');
		$data = $this->NewsletterTemplate->find('first',array('conditions'=>array('NewsletterTemplate.id'=>$templateId)));
		if(!empty($data)){
			$content = $data['NewsletterTemplate']['template'];
		}else{
			$content = "";
		}
		echo  $content; exit;
	}
	/*
		* admin_delete function
		* Functionality - delete newsletter
		* Developer - Navdeep kaur
		* Created date - 16-Apr-2014
		* Modified date - 
	*/       
	function admin_deleteNewsletter($id = null)
	{
		$this->loadModel('Newsletter');		
		$id = base64_decode($id);
		if($this->Newsletter->updateAll(array('Newsletter.is_deleted'=>'1'),array('Newsletter.id'=>$id))){
			$this->Session->setFlash("Newsletter has been deleted sucessfully.",'default',array('class'=>'alert alert-success'));	
			$this->redirect('newsletters');
		}
	}
	/*
		* admin_delete function
		* Functionality - delete newsletter
		* Developer - Navdeep kaur
		* Created date - 16-Apr-2014
		* Modified date - 
	*/       
	function admin_deleteNlTemplate($id = null)
	{
		$this->loadModel('NewsletterTemplate');		
		$id = base64_decode($id);
		if($this->NewsletterTemplate->updateAll(array('NewsletterTemplate.is_deleted'=>'1'),array('NewsletterTemplate.id'=>$id))){
			$this->Session->setFlash("Newsletter Template has been deleted sucessfully.",'default',array('class'=>'alert alert-success'));	
			$this->redirect('newsletterTemplate');
		}
	}
	/*
		* admin_delete function
		* Functionality - delete newsletter
		* Developer - Navdeep kaur
		* Created date - 16-Apr-2014
		* Modified date - 
	*/       
	function admin_settings()
	{
		$this->loadModel('Setting');
		$id = 1;
			if(empty($this->request->data)){
				$this->request->data = $this->Setting->read(null, 1);			
			}else
			if(isset($this->request->data) && !empty($this->request->data))
			{  $this->request->data['Setting']['id'] = base64_decode($this->request->data['Setting']['id']);
				$this->Setting->set($this->request->data);	
				if($this->Setting->validates()) 				
				{ //pr($this->request->data); die;
										
					if($this->Setting->save($this->request->data))
					{ 	
						$this->Session->setFlash("Settings saved sucessfully.",'default',array('class'=>'alert alert-success'));
						
						$this->redirect($this->referer());
					}
				}    
			}
			$textAction = ($id == null) ? 'Add' : 'Edit';			
			$this->set('navcategory','class = "active"');			
			$this->set('action',$textAction);			
			$this->set('breadcrumb','Settings/'.$textAction);
	}
	function admin_delete($id = null)
        {				
			$id = base64_decode($id);
			if($this->Admin->updateAll(array('Admin.is_deleted'=>'1'),array('Admin.id'=>$id))){
				$this->Session->setFlash("Admin has been deleted sucessfully.",'default',array('class'=>'alert alert-success'));	
				$this->redirect('index');
			}
		}
		function admin_test_page(){
			$this->set('breadcrumb','Test Payment Page');
			$this->loadModel('Order');
			$this->loadModel('OrderDetail');
			 $flag=0;
			// Calling arrays
			$this->getCountries();
			if(!empty($this->request->data)){
                   // pr($this->request->data); die;
                    if(isset($this->request->data['Order']) && !empty($this->request->data['Order']))
                    {
						if( isset($this->request->data['Order']['payment_method']) && $this->request->data['Order']['payment_method'] == 1){
							$cardInfo = $this->request->data['Order'];
						
							$result= $this->Braintree->addCreditCard($cardInfo);
							//pr($result); die;
							if($result['status'] ==1){
								$token = $result['token'];
								$tokendetails['token'] = $token;
								$tokendetails['amount'] = $cardInfo['amount'];
								$status = $this->Braintree->payByToken($tokendetails);
								if($status['status'] == 1){
									$flag = 1;
									$this->request->data['Order']['transaction_id'] = $status['transaction_id'];
								}
							}else{
								$flag = 0;
								$this->Session->setFlash($result['error_message'],'default',array('class'=>'alert alert-danger'));
							}
							
							//pr($status); die;
							
						}else{
						//pr($this->request->data); die;
                        $paymentType = urlencode('Sale');				// or 'Sale'
                        $firstName = urlencode($this->request->data['Order']['billing_name']);
                        $lastName = ""; //urlencode($this->request->data['User']['lastname']);
                        $creditCardType = urlencode($this->request->data['Order']['card_type']);
                        $creditCardNumber = urlencode($this->request->data['Order']['cc_number']);
                        //$creditCardNumber = urlencode('4716796482327012');
                        
                        $expDateMonth = $this->request->data['Order']['exp_month'];
                        // Month must be padded with leading zero
                        $padDateMonth = urlencode(str_pad($expDateMonth, 2, '0', STR_PAD_LEFT));
                        
                        $expDateYear = urlencode($this->request->data['Order']['exp_year']);
                        $cvv2Number = urlencode($this->request->data['Order']['cvv']);
                        //$cvv2Number = urlencode('000');
                        $address1 = urlencode($this->request->data['Order']['billing_street_1']);
                        $address2 = urlencode($this->request->data['Order']['billing_street_2']);
                        $city = urlencode($this->request->data['Order']['billing_city']);
                        $state = ""; // urlencode($this->request->data['OrderDetail']['billing_state']);
                        $zip = urlencode($this->request->data['Order']['billing_zip']);
                        $country = urlencode('US');// US or other valid country code
                        $amount = urlencode($this->request->data['Order']['amount']);
						
                        //$amount = urlencode(1);
                        $currencyID = urlencode('USD'); // or other currency ('GBP', 'EUR', 'JPY', 'CAD', 'AUD')
                        
                        // Add request-specific fields to the request string.
						if(isset($this->request->data['Order']['is_recurring']) && $this->request->data['Order']['is_recurring'] == 1){
							$date = $this->convertDataFormat($this->request->data['Order']['payment_date']);
							$newdate= $date."T00:00:00Z";
							$startDate =urlencode($newdate);
							$nvpStr =	"&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber".
                                "&EXPDATE=$padDateMonth$expDateYear&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName".
                                "&STREET=$address1&CITY=$city&STATE=$state&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyID&PROFILESTARTDATE=$startDate&DESC=test&BILLINGPERIOD=Month&BILLINGFREQUENCY=1";
							/*******request to api for recurring payment**********/							
							$httpParsedResponseAr = $this->Paypal->PPHttpPost('CreateRecurringPaymentsProfile', $nvpStr);
							
						}else{
							$nvpStr =	"&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber".
                                "&EXPDATE=$padDateMonth$expDateYear&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName".
                                "&STREET=$address1&CITY=$city&STATE=$state&ZIP=$zip&COUNTRYCODE=$country&CURRENCYCODE=$currencyID";
								/*******request to api for recurring payment**********/							
							$httpParsedResponseAr = $this->Paypal->PPHttpPost('DoDirectPayment', $nvpStr);
						}
                        
                        
                      
					 
						
                         
                        if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
                       
							if(isset($this->request->data['Order']['is_recurring']) && $this->request->data['Order']['is_recurring'] == 1){
								$this->request->data['Order']['profile_id'] = urldecode($httpParsedResponseAr['PROFILEID']);
							}else{
								$this->request->data['Order']['transaction_id'] = $httpParsedResponseAr['TRANSACTIONID'];
							}
							
                             $flag = 1;
                        }else{
                            
                            $msg = str_replace("%20", " ",$httpParsedResponseAr['L_LONGMESSAGE0']);
                            $msg = str_replace("%2e", " ",$msg);
                            
                            
							$this->Session->setFlash($msg,'default',array('class'=>'alert alert-danger'));
							//$this->redirect(array("controller" => "admins", "action" => "test_page"));
                        }
						}
                    }else{
                        $flag=0;
                    }
                    //	die;
                    if($flag == 1){
                                $ccNumber = str_repeat('x', (strlen($this->request->data['Order']['cc_number']) - 4)) . substr($this->request->data['Order']['cc_number'],-4,4);
                                $this->request->data['Order']['cc_number'] = $ccNumber;                               
								$this->request->data['Order']['order_no'] = '130';
								$this->request->data['Order']['payment_status'] = 1;
								$this->request->data['Order']['order_status'] = 0;
								//Default company id
								$this->request->data['Order']['company_id'] = 1;
                        if($this->Order->save($this->request->data)){ 
                            $orderId = $this->Order->id;
                            if(isset($this->request->data['OrderDetail']) && !empty($this->request->data['OrderDetail'])){
                                /*-------------------------------for save payment deatail----------------------------*/
                                $this->request->data['OrderDetail']['order_id'] = $orderId;
                                
                                $this->OrderDetail->save($this->request->data);
                                 /*-------------------------------end save payment deatail----------------------------*/
                            }
                           		
                   
                            $this->Session->setFlash('Order proccesed successfully. ','default',array('class'=>'alert alert-success'));	
                            $this->redirect(array('controller'=>'orders','action'=>'index'));
                        }
                    }
                } 
		}
		/* Convert date 01/02/2014 to 2014-02-01 Format */
        function convertDataFormat($date = null)
		{
			$dateArray =  explode('/', $date);			
			return $dateArray[2].'-'.$dateArray[1].'-'.$dateArray[0] ;			
		}
		function admin_setnewStatus($id,$status,$model){
			$this->loadModel($model);
		
			$this->request->data[$model]['id'] = $id;
			$this->request->data[$model]['status'] = $status;
			if($this->$model->save($this->request->data,false)){
				echo $status; exit;
			}
			
			
		}
		function admin_braintree_payment(){
			$this->layout ='';
			$this->set('breadcrumb','Braintree Payment');
			if(!empty($this->request->data)){
				
				
				$cardInfo = $this->request->data['Order'];
				
				$result= $this->Braintree->addCreditCard($cardInfo);
				//pr($result); die;
				if($result['status'] ==1){
					$token = "6gybv6";
					$amt = 1;
				}
				$tokendetails['token'] = $token;
				$tokendetails['amount'] = 1;
				$status = $this->Braintree->payByToken($tokendetails);
				pr($status); die;
				
			}
			
		}
		function payment_test(){
			$this->layout ='';
			$this->autoRender=false;
		   $this->Braintree= & new BraintreeComponent();
		
		//code to create Custome account and save Vault
						
		/* 
		$result = Braintree_Customer::create(array(
			"firstName" => 'Shubham',
			"lastName" => 'Monga',
			"creditCard" => array(
				"number" => '5105105105105100',
				"expirationMonth" => '12',
				"expirationYear" => '2020',
				"cvv" => '123',
				"billingAddress" => array(
					"postalCode" => '213654'
				)
			)
		));
		
		if ($result->success) {
			echo("Success! Customer ID: " . $result->customer->id . "<br/>");
			echo("<a href='./subscription.php?customer_id=" . $result->customer->id . "'>Create subscription for this customer</a>");
		} else {
			echo("Validation errors:<br/>");
			foreach (($result->errors->deepAll()) as $error) {
				echo("- " . $error->message . "<br/>");
			}
		}*/
		
		$token ='bxybs6';   $subscription = 'gvcp7r';
		$cust_id = '78616836';
		//Braintree_Customer::delete($cust_id);   echo 'deleted';die;
		//code to create subscription plan with help of cust ID 
		
		try {
			$customer_id = $cust_id;
			$customer = Braintree_Customer::find($customer_id);
			$payment_method_token = $customer->creditCards[0]->token;
		
		   $result = Braintree_Subscription::create(array(
				'paymentMethodToken' => $payment_method_token,
				'planId' => 'pt'
			));   
			
			/*     $result = Braintree_Subscription::create(array(
					'paymentMethodToken' => $payment_method_token,
					'price'=> '200',
					'planId' => 'gym',
					// addone code start
					'addOns' => array(
							'add' => array(
								array(
									 'inheritedFromId' =>'additional_pt',
									'amount' => $add_on_price,
									'quantity' => $quantity
								)
							)
						)
				   // addon code ends here.
				));    */
					
		
			if ($result->success) {
				echo("Success! Subscription " . $result->subscription->id . " is " . $result->subscription->status);
			} else {
				echo("Validation errors:<br/>");
				foreach (($result->errors->deepAll()) as $error) {
					echo("- " . $error->message . "<br/>");
				}
			}
		} catch (Braintree_Exception_NotFound $e) {
			echo("Failure: no customer found with ID " . $cust_id);
		}

}


		function admin_sendMessage(){
			if(!empty($this->request->data) && isset($this->request->data)){		
	//echo "<pre>"; print_r($this->request->data); die;
				$from = "+15413726045";
				
				
				$message = $this->request->data['SendMessage']['message'];
				$to = $this->request->data['SendMessage']['message_to'];
				
				$this->sms($from, $to, $message);
	
			}
			$this->set('breadcrumb','Settings');
		}
		function sms($from, $to, $message)
		{
			$response = $this->Twilio->sms($from, $to, $message);
			
			if($response->IsError){
				$this->Session->setFlash($response->ErrorMessage,'default',array('class'=>'alert alert-danger'));
				//echo 'Error: ' . $response->ErrorMessage;
			} else {
				$this->Session->setFlash('Message sent successfully','success');
				//echo 'Sent message to ' . $to;
			}
		}
		function admin_twilio_settings(){
			$this->loadModel('Setting');
			$id = 1;
			if(empty($this->request->data)){
				$this->request->data = $this->Setting->read(null, 1);			
			}
			$this->set('breadcrumb','Settings');
		}
		
//	function admin_getControllerList() {
//
//        $controllerClasses = App::objects('controller');
//        foreach ($controllerClasses as $controller) {
//            if ($controller != 'AppController') {
//                // Load the controller
//                App::import('Controller', str_replace('Controller', '', $controller));
//                // Load its methods / actions
//                $actionMethods = get_class_methods($controller);
//                foreach ($actionMethods as $key => $method) {
//
//                    if ($method{0} == '_') {
//                        unset($actionMethods[$key]);
//                    }
//                }
//                // Load the ApplicationController (if there is one)
//                App::import('Controller', 'AppController');
//                $parentActions = get_class_methods('AppController');
//                $controllers[$controller] = array_diff($actionMethods, $parentActions);
//            }
//        } //pr($controllers); die;
//        return $controllers;
//    }

}
?>