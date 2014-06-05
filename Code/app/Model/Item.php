<?php    
    class Item extends AppModel {
        var $name = 'Item';        
        public $validate = array(
                                
								'name' => array(
													'notEmpty'=>array(
														'required'=>true,
														'rule' => array('notEmpty'),
														'message' => 'Please enter name.'
													),
													'rule1' => array(
														'required' => true,
														'rule' => array('checkUniqueName'),
														'message' => 'Product name already in use.'
													)
												),
								'product_code' => array(
													'notEmpty'=>array(
														'required'=>true,
														'rule' => array('notEmpty'),
														'message' => 'Please enter product code.'
													),
													'rule1' => array(
														'required' => true,
														'rule' => array('checkUnique'),
														'message' => 'Product code already in use.'
													)
												),
//								'category_id' => array(
//                                                    'rule'    => 'notEmpty',
//                                                    'message' => 'Please select category.'
//                                                ),
								'price' => array(
                                                    'rule'    => 'notEmpty',
                                                    'message' => 'Please enter price of product.'
                                                ),
								'product_weight' => array(
                                                    'rule'    => 'notEmpty',
                                                    'message' => 'Please enter weight of product.'
                                                ),
								'description' => array(
                                                    'rule'    => 'notEmpty',
                                                    'message' => 'Please enter description.'
                                                )
								
                                );
        public function deletebyid($id){
            if($this->delete($id)){
                return true;
            }else{
                return false;
            }
            
        }
    /*
    * Defining Relationships
    */
    public $belongsTo = array(
        //'Category' => array(
        //    'className' => 'Category',
        //    'fields'    => array('id','category')
        //),
		'User' =>array(
			'className' => 'User'
		),
    );
	// Check for unique product code
		public function checkUnique(){
			App::uses('CakeSession', 'Model/Datasource');
			$companyId = CakeSession::read('loggedUserInfo.company_id');
			
			if(!empty($this->data['Item']['id'])){
				$data = $this->find('first',array('conditions'=>array('Item.product_code'=>$this->data['Item']['product_code'],'Item.id !='=>$this->data['Item']['id'],'Item.company_id'=> $companyId)));
			}else{
				$data = $this->find('first',array('conditions'=>array('Item.product_code'=>$this->data['Item']['product_code'],'Item.company_id'=> $companyId)));    
			}
			
			if(!empty($data) && count($data) > 0){
				return false;
			}else{
				return true;
			}
		}
    
	// Check for unique product code
		public function checkUniqueName(){
			if(!empty($this->data['Item']['id'])){
				$data = $this->find('first',array('conditions'=>array('Item.name'=>$this->data['Item']['name'],'Item.id !='=>$this->data['Item']['id'])));
			}else{
				$data = $this->find('first',array('conditions'=>array('Item.name'=>$this->data['Item']['name'])));    
			}
			
			if(!empty($data) && count($data) > 0){
				return false;
			}else{
				return true;
			}
		}
    }

    
?>
