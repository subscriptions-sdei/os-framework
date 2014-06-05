<?php
ob_start();
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    
    
    var $helpers = array('Form','Html');
    var $components =array('RequestHandler','Session');
        
    function beforeRender() {        
        if($this->name == 'CakeError') {
            $this->layout = 'error';
        }
    }
    
  
    
    function beforeFilter()
    {
		
		if(!empty($this->params['admin']) && ($this->params['action'] != 'admin_login' && $this->params['action'] != 'admin_forgot_password' && $this->params['action'] != 'admin_secure_check') && ($this->params['prefix'] == 'admin')  && $this->params['action'] != 'admin_getlogodata')
        {
            $this->CheckAdminSession();            
            $this->layout='admin';
            $loggedUserInfo = $this->Session->read('loggedUserInfo');
            $this->set('loggedUserInfo',$loggedUserInfo);            
        }/*else{
                // Frontend Login Session Management
                if(($this->params['prefix'] != 'admin'))
                { 

					$layout = 'frontend';
                    if(
					   ($this->params['action'] != 'login') &&
						($this->params['action'] != 'get_states') &&
						($this->params['action'] != 'delete_pic')
						
					)
                    {
                        $this->checkUserSession();                        
                    }else{                                               
                        $layout = 'login';
                    }
                    $this->layout = $layout;
                }
        }*/
    }
    
    /* Check admin session is Exist OR Not*/
   function checkAdminSession() {        
        	if(!$this->Session->check('loggedUserInfo')) {                                                
                $this->redirect('/admin/admins/login');
		}else {                    
        }
	}
    
    /** Check User Login Session */
    function checkUserSession()
    {
        if(!$this->Session->check('UserInfo')) {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }else{            
        }
    }
    
    /** The function setStatus to active/Inactive/Delete the records based on controller/model */    
    function setStatus($status,$CheckedList,$model,$controller,$action)
    {
        if(count($CheckedList) < 1)
        {
            $this->Session->setFlash("Please select the at least one record.",'default',array('class'=>'alert alert-danger'));					
            
        }else
        {
            for($i=0; $i<count($CheckedList); $i++)
            {				
                $this->$model->id = null;
                $this->$model->id = base64_decode($CheckedList[$i]); 
                $id = base64_decode($CheckedList[$i]);
                if($status == '1' || $status == '2')
                {
                    $statusValue = ($status == 1)  ? '1' : '0';
                    $operation = ($status == 1)  ? 'active' : 'inactive';
					$operation1 = ($status == 1)  ? 'activated' : 'inactivated';
                    $this->$model->saveField('status', $statusValue);	
                }else{
					$this->$model->updateAll(array($model.'.is_deleted'=>'1'),array($model.'.id'=>$id));
                    //$this->$model->delete();
                    $operation1 = 'deleted';
                }
            }
            $message = (count($CheckedList) == 1) ? "Record has been ".$operation1." successfully" : "Records have been ".$operation1." successfully";				$this->Session->setFlash($message,'default',array('class'=>'alert alert-success'));
        }
        $this->redirect(array("controller" =>$controller , "action" => $action));			
    }
    
    /** function to unbind all the models */
	function unbindModelAll() { 
	    $unbind = array(); 
	    foreach ($this->belongsTo as $model=>$info) 
	    { 
	      $unbind['belongsTo'][] = $model; 
	    } 
	    foreach ($this->hasOne as $model=>$info) 
	    { 
	      $unbind['hasOne'][] = $model; 
	    } 
	    foreach ($this->hasMany as $model=>$info) 
	    { 
	      $unbind['hasMany'][] = $model; 
	    } 
	    foreach ($this->hasAndBelongsToMany as $model=>$info) 
	    { 
	      $unbind['hasAndBelongsToMany'][] = $model; 
	    } 
	    parent::unbindModel($unbind); 
	}
	
	# Functionality to get list of categories
	function getCategoryList(){
			#To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');	
		    $this->loadModel('Category');
			$categories = $this->Category->find('list',array('conditions'=>array('Category.status'=>1,'Category.parent_id'=>NULL,'Category.is_deleted'=>0,'Category.company_id'=>$companyId),'fields'=>array('id','category'),'order'=>'category ASC'));
			$this->set('categories',$categories);
	}
	
	
	/* Get State List */
	function getStateList()
	{
		$statelist = array("AL" => "Alabama","AK" => "Alaska","AZ" => "Arizona","AR" => "Arkansas","AS" => "American Samoa","CA" => "California","CO" => "Colorado","CT" => "Connecticut","DE" => "Delaware","DC" => "District of Columbia","FL" => "Florida","GA" => "Georgia","GU" => "Guam","HI" => "Hawaii","ID" => "Idaho","IL" => "Illinois","IN" => "Indiana","IA" => "Iowa","KS" => "Kansas","KY" => "Kentucky","LA" => "Louisiana","ME" => "Maine","MD" => "Maryland","MA" => "Massachusetts","MI" => "Michigan","MN" => "Minnesota","MS" => "Mississippi","MO" => "Missouri","MT" => "Montana","NE" => "Nebraska","NV" => "Nevada","NH" => "New Hampshire","NJ" => "New Jersey","NM" => "New Mexico","NY" => "New York","NC" => "North Carolina","ND" => "North Dakota","MP" => "Northern Marianas Islands","OH" => "Ohio","OK" => "Oklahoma","OR" => "Oregon","PA" => "Pennsylvania","PR" => "Puerto Rico","RI" => "Rhode Island","SC" => "South Carolina","SD" => "South Dakota","TN" => "Tennessee","TX" => "Texas","UT" => "Utah","VT" => "Vermont","VA" => "Virginia","VI" => "Virgin Islands","WA" => "Washington","WV" => "West Virginia","WI" => "Wisconsin","WY" => "Wyoming");
		$this->set('statelist',$statelist);
	}
    
    /*
	* This function is used to send email with template  
	* @author        Navdeep Kaur
	* @copyright     smartData Enterprise Inc.
	* @method        sendEmail
	* @param         $to, $subject, $messages, $from, $reply,$path,$file_name
	* @return        void 
	* @since         version 0.0.1
	* @version       0.0.1 
	*/
	public function sendEmail($to = null, $subject ='', $messages = null, $from=null, $reply = null,$path=null,$file_name = null){
		$this->Email->smtpOptions = array(
			'host' => Configure::read('host'),
			'username' =>Configure::read('username'),
			'password' => Configure::read('password'),
			'timeout' => Configure::read('timeout')
		);                
        
		$this->Email->delivery = 'mail';//possible values smtp or mail 
        $admin_name = Configure::read('ADMIN_NAME');
		if(empty($reply)){
			$reply = $admin_name.'<'.Configure::read('replytoEmail').'>';
		}
		if(empty($from)){
			$from = $admin_name.'<'.Configure::read('fromEmail').'>';
		}
		$this->Email->from = $from;
		$this->Email->replyTo = $reply;
		if($to == 'admin'){
			$this->Email->to = $from;
		} else {
			$this->Email->to = $to;
		}
		
		if(!empty($path) && !empty($file_name))
		    $this->Email->attachments = array($file_name,$path.$file_name);
		    
		    if(empty($subject)){
		       $subject='Admin'; 
		    }
		    $this->Email->subject = $subject;
		    $this->set('data',$messages);
		    $this->set('smtp_errors', $this->Email->smtpError);
		    $this->Email->sendAs= 'both';
		    $this->Email->template='comman_template';
		 
		if($this->Email->send()){
			return true;
		} else {
			return false;
		}
	}
/*
 * This function is used to get the list of countries
 * @author        Navdeepkaur
 * @copyright     smartData Enterprise Inc.
 * @method        getCountries
 * @param         null
 * @return        array 
 * @since         version 0.0.1
 * @version       0.0.1 
 */	
	public function getCountries(){		
		$this->loadModel('Country');
		$country = $this->Country->find('list',array('fields'=>array('Country.id','name'),'order'=>'name ASC'));
		$this->set('country',$country);		
	}
	
	function getSubscriptions(){
		$this->loadModel('Subscription');
		$data=  $this->Subscription->find('list',array('conditions'=>array('Subscription.is_deleted'=>0,'Subscription.status'=>1)));
		$this->set('subscriptionPlans',$data);
	}
	function getCompanyName($cId){
		$this->loadModel('Company');
		$data =  $this->Company->find('first',array('conditions'=>array('Company.id'=>$cId),'fields'=>array('name')));
		return $data['Company']['name'];
	}
}
