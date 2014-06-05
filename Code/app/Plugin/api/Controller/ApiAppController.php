<?php 
        Class ApiAppController extends AppController{  
        
        public function before_filter(){
        
        } 
        
        function api_get_input() { 
          if( isset($GLOBALS["HTTP_RAW_POST_DATA"]) )
            return $GLOBALS["HTTP_RAW_POST_DATA"];
          else
            return 0;
        } 
        
        public function api_response_formatter( $model = null , $resource_method = null , $response_code = 0, $results = array() , $validation_errors = array() , $action_error = array() ){
          $codes_desc = array(
                          '100'=>'Success',
                          '101'=>'Input/Validation Error',
                          '102'=>'Invalid Access',
                          '103'=>'Data Not Found'
                        );
                        
          $response = array(
                        'response_code'=>$response_code,
                        'results'=>$results,
                        'action_error'=>$action_error,
                        'validation_errors'=>$validation_errors,
                        'model'=>$model,
                        'api'=>$resource_method,
                        'code_description'=>$codes_desc
                      );
        
          return $response;
        }
      
      }