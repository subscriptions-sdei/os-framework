<?php
    
	/*
        * Order Controller class
        * Functionality -  Manage the Orders Management
        * Developer - Gurpreet Singh Ahhluwalia
        * Created date - 31-MAr-2014
        * Modified date - 
    */
    class OrdersController extends AppController {        
        var $name = 'Orders';                
		
		public $components = array('Paginator','Common','Email','Paypal');
		var $helpers = array('Common');
		
		
        function beforeFilter(){
            parent::beforeFilter();    
            
        }
		
		
		/*
			* admin_index function
			* Functionality -  Orders Listing
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
			$criteria="is_deleted = 0 AND Order.company_id = $companyId "; 
			
			if(!empty($this->params)){ 
					if(!empty($this->params->query['keyword'])){
						$value = trim($this->params->query['keyword']);	
					}
					if($value !="") {
						$criteria .= " AND (Order.transaction_id LIKE '%".$value."%' OR Order.billing_name LIKE '%".$value."%' OR Order.order_no LIKE '%".$value."%' OR Order.billing_email LIKE '%".$value."%')";												
					}
			}
			
		
			
			$this->Paginator->settings = array(
				'conditions' => array($criteria),
				'limit' => 10,
				'order' => 'Order.id DESC'
			);
			
			
			$this->set('getData',$this->Paginator->paginate('Order'));
			$this->set('keyword', $value);
			$this->set('show', $show);
			$this->set('navorders','class = "active"');			
			$this->set('breadcrumb','Orders');			
        }
		
		/*
			* admin_view function
			* Functionality -  View order
			* Developer - Gurpreet Singh Ahhluwalia
			* Created date - 4-Apr-2014
			* Modified date - 
		*/
		function admin_view($id = null)
		{
			$this->loadModel('Item');
			$this->loadModel('User');								
			$getOrderDetail = array();
			
			if(!empty($id))
			{
				
				$getOrderDetail = $this->Order->find('first',array('conditions'=>array('Order.id'=>base64_decode($id)),'recursive' => 2));
				
			}			
			$this->set('getData',$getOrderDetail);
        }
		
		
       
		/*
            * admin_delete function
            * Functionality -  Add & edit the Orders
            * Developer - Gurpreet Singh Ahhluwalia
            * Created date - 4-Apr-2014
            * Modified date - 
        */       
		function admin_delete($id = null)
        {
			if(!empty($id)){
				$orderId= base64_decode($id);
				if($this->Order->updateAll(array('Order.is_deleted'=>'1'),array('Order.id'=>$orderId))){
					$this->Session->setFlash("Order deleted sucessfully.",'default',array('class'=>'alert alert-success'));	
					$this->redirect(array("controller"=>"orders","action" => "index"));
				}
			}
		}
		function admin_invoice($id = null){
			$id= base64_decode($id);
			$this->layout = "";
			$getdata = $this->Order->find('first',array('conditions'=>array('Order.id'=>$id)));
			$this->set('getdata',$getdata);
		}
		
		function admin_changeStatus(){
			
			
			$this->autoRender = false;
			$this->loadModel('Order');
			if(isset($_REQUEST['value'])){
				
					
					$field = "order_status";
					$this->Order->id = $_REQUEST['pk'];
					
						if($this->Order->saveField($field,trim($_REQUEST['value']))) {
						echo "1"; exit;    
					}
				
			}
	
		}

		
    }

?>