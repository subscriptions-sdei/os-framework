<?php 
        Class ItemsController extends ApiAppController{  
        
        public function before_filter(){ 
          $records = array();
          $validation_errors = array();
          $model = 'Item';
          $this->loadModel("Api.Item");
        } 
          
          public function api_add(){
                /*{"Item":{"id":"","picCount":"10","name":"test product25465","product_code":"3422","description":"

test description<\/p>\r\n","product_weight":"12","price":"11","is_featured":"1","status":"1"},"ItemCategory":{"category_id":["5","6"]},"RelatedItem":{"other_item_id":""}}


{"User":{"id":"","company_id":"","first_name":"","last_name":"","email":"","gender":"","username":"","password":"","image":"","address_1":"","address_2":"","country_id":"","state_id":"","city":"","zip":"","phone_no":"","status":"","is_deleted":"","created":"","modified":""}}
*/
                $this->loadModel('ItemCategory');
                $this->loadModel('RelatedItem');
            $records = array();
            $validation_errors = array();
            $input = $this->api_get_input();
            $this->request->data = json_decode($input,true);
            $input = json_decode($input,true);
            
            if(!empty($this->request->data)){ 
              $result = $this->Item->add($this->request->data);
              if( !empty($result) ){ 
                        $itemId = $result;
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
              }else{
                $validation_errors = $this->Item->validationErrors;
              }
            }
            
            $resource_method = "api_add";
            $response_code = 100;
            if( !empty($validation_errors) || empty($result) ){
              $response_code = 101;
            }
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'Item' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }  
          
          public function api_edit(){ 
            $records = array();
            $validation_errors = array();
            $input = $this->api_get_input();
            $this->request->data = json_decode($input,true);
            $input = json_decode($input,true);
            
            if(!empty($this->request->data)){
              $result = $this->Item->edit($this->request->data);
              if( !empty($result) ){ 
                 
              }else{
                $validation_errors = $this->Item->validationErrors;
              } 
            }
            
            $resource_method = "api_edit";
            $response_code = 100;
            if( !empty($validation_errors) || empty($result) ){
              $response_code = 101;
            }
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'Item' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }  
          
          public function api_view($id = null){  
            $records = array();
            $validation_errors = array();
            
            $response_code = 101;
            if ($this->Item->exists($id)) {
              $this->Item->recursive = 0;
              $records = $this->Item->getById($id);
              $response_code = 100;
            }
            
            $resource_method = "api_view";
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'Item' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }  
          
          public function api_delete($id = null){  
            $records = array();
            $validation_errors = array();
            
            $response_code = 101;
            if ($this->Item->exists($id)) {
              $this->Item->delete($id);
              $response_code = 100;
            }
            
            $resource_method = "api_delete";
            
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'Item' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }  
          
          public function api_index(){ 
            $records = array();
            $validation_errors = array();
            $this->Item->recursive = 0;
            $records = $this->Item->getAll();
            
            $resource_method = "api_index";
            $response_code = 100;
            if( !empty($validation_errors) ){
              $response_code = 101;
            }
            
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'Item' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }  
          
          public function api_getByQuery($query){ 
            $records = array();
            $validation_errors = array();
            
            $records = $this->Item->getByQuery($query);
            
            $resource_method = "api_getByQuery";
            $response_code = 100;
            if( !empty($validation_errors) ){
              $response_code = 101;
            }
            
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'Item' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }}