<?php 
        Class CategoriesController extends ApiAppController{  
        
        public function before_filter(){ 
          $records = array();
          $validation_errors = array();
          $model = 'Category';
          $this->loadModel("Api.Category");
        } 
          
          public function api_add(){ 
            $records = array();
            $validation_errors = array();
            $input = $this->api_get_input();
            $this->request->data = json_decode($input,true);
            $input = json_decode($input,true);
            
            if(!empty($this->request->data)){
              $result = $this->Category->add($this->request->data);
              if( !empty($result) ){ 
                 
              }else{
                $validation_errors = $this->Category->validationErrors;
              }
            }
            
            $resource_method = "api_add";
            $response_code = 100;
            if( !empty($validation_errors) || empty($result) ){
              $response_code = 101;
            }
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'Category' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }  
          
          public function api_edit(){ 
            $records = array();
            $validation_errors = array();
            $input = $this->api_get_input();
            $this->request->data = json_decode($input,true);
            $input = json_decode($input,true);
            
            if(!empty($this->request->data)){
              $result = $this->Category->edit($this->request->data);
              if( !empty($result) ){ 
                 
              }else{
                $validation_errors = $this->Category->validationErrors;
              } 
            }
            
            $resource_method = "api_edit";
            $response_code = 100;
            if( !empty($validation_errors) || empty($result) ){
              $response_code = 101;
            }
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'Category' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }  
          
          public function api_view($id = null){  
            $records = array();
            $validation_errors = array();
            
            $response_code = 101;
            if ($this->Category->exists($id)) {
              $this->Category->recursive = 0;
              $records = $this->Category->getById($id);
              $response_code = 100;
            }
            
            $resource_method = "api_view";
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'Category' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }  
          
          public function api_delete($id = null){  
            $records = array();
            $validation_errors = array();
            
            $response_code = 101;
            if ($this->Category->exists($id)) {
              $this->Category->delete($id);
              $response_code = 100;
            }
            
            $resource_method = "api_delete";
            
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'Category' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }  
          
          public function api_index(){ 
            $records = array();
            $validation_errors = array();
            $this->Category->recursive = 0;
            $records = $this->Category->getAll();
            
            $resource_method = "api_index";
            $response_code = 100;
            if( !empty($validation_errors) ){
              $response_code = 101;
            }
            
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'Category' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }  
          
          public function api_getByQuery($query){ 
            $records = array();
            $validation_errors = array();
            
            $records = $this->Category->getByQuery($query);
            
            $resource_method = "api_getByQuery";
            $response_code = 100;
            if( !empty($validation_errors) ){
              $response_code = 101;
            }
            
            header("content-type:application/json");
            echo json_encode($this->api_response_formatter( 'Category' , $resource_method , $response_code , $records , $validation_errors ));
            exit; 
          }}