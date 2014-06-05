<?php
    /*
        * Reports Controller class
        * Functionality -  Manage the Reports Management
        * Developer - Gurpreet Singh Ahhluwalia
        * Created date - 5-Mar-2014
        * Modified date - 
    */
    class ReportsController extends AppController {
        var $name = 'Reports';                
		
		public $components = array('Paginator','Common');
		var $helpers = array('Common');
		
		public $paginate = array(
        'limit' => 10,
        'order' => array(
            'Reports.id' => 'DESC'
				)
			);
        
        function beforeFilter(){
            parent::beforeFilter();    
            
        }
        
      
        /*
            * admin_addedit function
            * Functionality -  Add & edit the Faqs
            * Developer - Gurpreet Singh Ahhluwalia
            * Created date - 5-Mar-2014
            * Modified date - 
        */
        function admin_index()
        {	
			$getReportArray = $this->Common->getReport();
	
			$userType = '';
			
			if(isset($this->request->data) && !empty($this->request->data))
			{  
				
				$this->generateReport($this->request->data['Report']['report_id'], $this->request->data['Report']['start_date'], $this->request->data['Report']['end_date']);				
			}
			$textAction =  '' ;			
			$this->set('navreports','class = "active"');			
			$this->set('action',$textAction);			
				$this->set('breadcrumb','Orders/Generate Report');
			
			$this->set(compact('getReportArray'));
			
        }
		
		/*
            * generateReport function
            * Functionality -  Generate Report .csv
            * Developer - Gurpreet Singh Ahhluwalia
            * Created date - 5-Mar-2014
            * Modified date - 
        */
		function generateReport($report_type = null, $start_date = null, $end_Date = null)
		{
			
			
			if($report_type == '1')
			{
				$modelName = "Order";
				$getUserData = true;		
				$condition = "(".$modelName.".created BETWEEN '".$this->convertDataFormat($start_date)." 00:00:00' AND '".$this->convertDataFormat($end_Date)." 23:59:59')"; // get data from two dates
			
				$fileName = '';
				$this->loadModel('Order');
				
				$getDetail = array();
				
				$getDetail = $this->Order->find('all', array(											
											'conditions' => array($condition)));
			$csv_output='';
			if(!empty($getDetail))
			{
			
				ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large

                //create a file
                $filename = "orders_".$start_date.".csv";
                $csv_file = fopen('php://output', 'w');

                header('Content-type: application/csv');
                header('Content-Disposition: attachment; filename="'.$filename.'"');

                // The column headings of your .csv file
                $header_row = array("Order No",
									"Transaction ID",
									"Total Amount",
									"Name on Card",
									"CC No.",
									"Expiration",
									"Card Type",
									"CVV",
									"Billing User Name",
									"Billing Address 1",
									"Billing Address 2",
									"Billing City",
									"Billing State",
									"Billing Zip",
									"Billing Phone",
									"Shipping User Name",
									"Shipping Address 1",
									"Shipping Address 2",
									"Shipping City",
									"Shipping State",
									"Shipping Zip",
									"Shipping Phone",
									"Order Status",
									"Payment Status",
									"Order Date"
									);
                fputcsv($csv_file,$header_row,',','"');



                // Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
                foreach($getDetail as $rec)
                {

				$months = array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec') ;
				foreach($months as $key=>$val){ 
					if($rec['Order']['exp_month'] == $key){ $month = $val; }
				}
				$date =  $month.' '.$rec['Order']['exp_year'];
				
				if($rec['Order']['order_status'] == 1){ $orderStatus =  "Shipped"; }else if($rec['Order']['order_status'] == 2){ $orderStatus = "Cancelled"; }else{ $orderStatus =  "In Progress"; }
				
				if($rec['Order']['payment_status'] == 1){ $payStatus= "Paid"; }else{ $payStatus=  "Pending"; } 
				
                    $row = array(
                            
                        $rec['Order']['order_no'],
                        $rec['Order']['transaction_id'],
						$rec['Order']['amount'],
						$rec['Order']['name_on_card'],
						$rec['Order']['cc_number'],
						$date,
						$rec['Order']['card_type'],
						$rec['Order']['cvv'],
						$rec['Order']['billing_name'],
						$rec['Order']['billing_street_1'],
						$rec['Order']['billing_street_2'],
						$rec['Order']['billing_city'],
						$rec['Order']['billing_state'],
						$rec['Order']['billing_zip'],
						$rec['Order']['billing_phone'],
						$rec['Order']['shipping_name'],
						$rec['Order']['shipping_street_1'],
						$rec['Order']['shipping_street_2'],
						$rec['Order']['shipping_city'],
						$rec['Order']['shipping_state'],
						$rec['Order']['shipping_zip'],
						$rec['Order']['shipping_phone'],
						$orderStatus,
						$payStatus,
						date('M j, Y',strtotime($rec['Order']['created']))
                     
                    );

                    fputcsv($csv_file,$row,',','"');
                }

                fclose($csv_file); exit;
			}else{
				$csv_output .= "No Record Found..";
				$this->Session->setFlash("No record found for these dates, please try other date range.",'default',array('class'=>'alert alert-danger'));	
				$this->redirect(array('action' => 'index'));
			}
			
			$fileName = "orders";
			
			}
/******************************************************************/
/***************************************************************/

			if($report_type == '2')
			{
				$modelName = "Order";
				$getUserData = true;		
				$condition = "(".$modelName.".created BETWEEN '".$this->convertDataFormat($start_date)." 00:00:00' AND '".$this->convertDataFormat($end_Date)." 23:59:59')"; // get data from two dates
			
				$fileName = '';
				$this->loadModel('Order');
				
				$getDetail = array();
				
				$getDetail = $this->Order->find('all', array(											
											'conditions' => array($condition)));
				
			$csv_output='';
			if(!empty($getDetail))
			{
			
				ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large

                //create a file
                $filename = "products_".$start_date.".csv";
                $csv_file = fopen('php://output', 'w');

                header('Content-type: application/csv');
                header('Content-Disposition: attachment; filename="'.$filename.'"');

                // The column headings of your .csv file
                $header_row = array("Order No","Product Name","Cost per Product",'Shipping Charges',"Tax","Tax Amount","Total Cost");
                fputcsv($csv_file,$header_row,',','"');



                // Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
                foreach($getDetail['OrderDetail'] as $rec)
                {


			
                    $row = array(
                            
                        $rec['order_no'],
                        $rec['product_name'],
						$rec['per_product_cost'],
						$rec['shipping_cost'],
						$rec['tax'],
						$rec['tax_amt'],
						$rec['total_cost'],
						
                     
                    );

                    fputcsv($csv_file,$row,',','"');
                }

                fclose($csv_file); exit;
			}else{
				$csv_output .= "No Record Found..";
				$this->Session->setFlash("No record found for these dates, please try other date range.",'default',array('class'=>'alert alert-danger'));	
				$this->redirect(array('action' => 'index'));
			}
			
			
			}
			
		
		      
		}
		
		function admin_categoryReport(){
			
			#To get company Id
			$companyId = $this->Session->read('loggedUserInfo.company_id');
			if(isset($this->request->data) && !empty($this->request->data))
			{  //pr($this->request->data); die;
				$start_date = $this->request->data['Report']['start_date'];
				$end_date = $this->request->data['Report']['end_date'];
				$modelName = "Category";
				$getUserData = true;
				if($this->request->data['Report']['export_type'] ==0){
					$condition = " Category.is_deleted=0 AND Category.company_id = $companyId"; // get data from two dates
				}else{
					
					$condition = "(".$modelName.".created BETWEEN '".$this->convertDataFormat($start_date)." 00:00:00' AND '".$this->convertDataFormat($end_date)." 23:59:59' ) AND Category.is_deleted=0 AND Category.company_id = $companyId"; // get data from two dates
				}
				//$condition = "(".$modelName.".created BETWEEN '".$this->convertDataFormat($start_date)." 00:00:00' AND '".$this->convertDataFormat($end_date)." 23:59:59' ) AND is_deleted=0"; // get data from two dates
			
				$fileName = '';
				$this->loadModel('Category');
				
				$getDetail = array();
				$this->Category->bindModel(array('belongsTo'=>array(
        'Parent' => array(
            'className' => 'Category',
            'foreignKey' => 'parent_id'
        )
    )));
				$getDetail = $this->Category->find('all', array(											
											'conditions' => array($condition)));
				//echo "<pre>"; print_r($getDetail); die;
				$csv_output='';
				if(!empty($getDetail))
				{
				ini_set('max_execution_time', 600); //increase max_execution_time to 10 min if data set is very large

					//create a file
					$filename = "categories_".$start_date."_".$end_date.".csv";
					$csv_file = fopen('php://output', 'w');
	
					header('Content-type: application/csv');
					header('Content-Disposition: attachment; filename="'.$filename.'"');
	
					// The column headings of your .csv file
					$header_row = array("Category Name","Parent");
					fputcsv($csv_file,$header_row,',','"');
	
	
	
					// Each iteration of this while loop will be a row in your .csv file where each field corresponds to the heading of the column
					foreach($getDetail as $rec)
					{
	
						if($rec['Category']['parent_id'] == ""){ $parent= "Root"; }else{ $parent=$rec['Parent']['category'];}
				
						$row = array(								
							$rec['Category']['category'],
							$parent
						);
	
						fputcsv($csv_file,$row,',','"');
					}
	
					fclose($csv_file); exit;
				}else{
					$csv_output .= "No Record Found..";
					$this->Session->setFlash("No record found for these dates, please try other date range.",'default',array('class'=>'alert alert-danger'));	
					$this->redirect(array('action' => 'categoryReport'));
				}
			
			}
			$textAction =  '' ;			
			$this->set('navreports','class = "active"');			
			$this->set('action',$textAction);			
			$this->set('breadcrumb','Categories/Generate Report');
			
			
		}
		/* Convert date 01/02/2014 to 2014-02-01 Format */
        function convertDataFormat($date = null)
		{
			$dateArray =  explode('/', $date);			
			return $dateArray[2].'-'.$dateArray[1].'-'.$dateArray[0] ;			
		}
    
    }

?>