<?php 
        Class UsersController extends ApiAppController{  
        
        public function before_filter(){ 
          $records = array();
          $validation_errors = array();
          $model = 'User';
          $this->loadModel("Api.User");
        } 
          
          public function api_add(){ 
            $records = array();
            $validation_errors = array();
            $input = $this->api_get_input();
            $this->request->data = json_decode($input,true);
            $input = json_decode($input,true);
            
            if(!empty($this->request->data)){
              $result = $this->User->add($this->request->data);
              if( !empty($result) ){ 
                 
              }else{
                $validation_errors = $this->User->validationErrors;
              }
            }
            
            $resource_method = "api_add";
            $response_code = 100;
            if( !empty($validation_errors) || empty($result) ){
              $response_code = 101;
            }
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'User' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }  
          
          public function api_edit(){ 
            $records = array();
            $validation_errors = array();
            $input = $this->api_get_input();
            $this->request->data = json_decode($input,true);
            $input = json_decode($input,true);
            
            if(!empty($this->request->data)){
              $result = $this->User->edit($this->request->data);
              if( !empty($result) ){ 
                 
              }else{
                $validation_errors = $this->User->validationErrors;
              } 
            }
            
            $resource_method = "api_edit";
            $response_code = 100;
            if( !empty($validation_errors) || empty($result) ){
              $response_code = 101;
            }
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'User' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }  
          
          public function api_view($id = null){  
            $records = array();
            $validation_errors = array();
            
            $response_code = 101;
            if ($this->User->exists($id)) {
              $this->User->recursive = 0;
              $records = $this->User->getById($id);
              $response_code = 100;
            }
            
            $resource_method = "api_view";
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'User' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }  
          
          public function api_delete($id = null){  
            $records = array();
            $validation_errors = array();
            
            $response_code = 101;
            if ($this->User->exists($id)) {
              $this->User->delete($id);
              $response_code = 100;
            }
            
            $resource_method = "api_delete";
            
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'User' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }  
          
          public function api_index(){ 
            $records = array();
            $validation_errors = array();
            $this->User->recursive = 0;
            $records = $this->User->getAll();
            
            $resource_method = "api_index";
            $response_code = 100;
            if( !empty($validation_errors) ){
              $response_code = 101;
            }
            
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'User' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }  
          
          public function api_getByQuery($query){ 
            $records = array();
            $validation_errors = array();
            
            $records = $this->User->getByQuery($query);
            
            $resource_method = "api_getByQuery";
            $response_code = 100;
            if( !empty($validation_errors) ){
              $response_code = 101;
            }
            
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'User' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }}