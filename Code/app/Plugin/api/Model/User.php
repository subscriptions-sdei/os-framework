<?php Class User extends AppModel{ 
        var $name = 'User';
        var $validate = array (
  'company_id' => 
  array (
    'numeric' => 
    array (
      'rule' => 'numeric',
      'message' => 'numeric rule error.',
      'last' => true,
    ),
  ),
  'first_name' => 
  array (
    'alphanumeric' => 
    array (
      'rule' => 'alphanumeric',
      'message' => 'alphanumeric rule error.',
      'last' => true,
    ),
    'notempty' => 
    array (
      'rule' => 'notempty',
      'message' => 'notempty rule error.',
      'last' => true,
    ),
  ),
  'last_name' => 
  array (
    'notempty' => 
    array (
      'rule' => 'notempty',
      'message' => 'notempty rule error.',
      'last' => true,
    ),
  ),
  'email' => 
  array (
    'email' => 
    array (
      'rule' => 'email',
      'message' => 'email rule error.',
      'last' => true,
    ),
    'notempty' => 
    array (
      'rule' => 'notempty',
      'message' => 'notempty rule error.',
      'last' => true,
    ),
  ),
  'password' => 
  array (
    'notempty' => 
    array (
      'rule' => 'notempty',
      'message' => 'notempty rule error.',
      'last' => true,
    ),
  ),
  //'image' => 
  //array (
  //  'extension' => 
  //  array (
  //    'rule' => 'extension',
  //    'message' => 'extension rule error.',
  //    'last' => true,
  //  ),
  //),
  'address_1' => 
  array (
    'notempty' => 
    array (
      'rule' => 'notempty',
      'message' => 'notempty rule error.',
      'last' => true,
    ),
  ),
  'country_id' => 
  array (
    'notempty' => 
    array (
      'rule' => 'notempty',
      'message' => 'notempty rule error.',
      'last' => true,
    ),
    'numeric' => 
    array (
      'rule' => 'numeric',
      'message' => 'numeric rule error.',
      'last' => true,
    ),
  ),
  'state_id' => 
  array (
    'notempty' => 
    array (
      'rule' => 'notempty',
      'message' => 'notempty rule error.',
      'last' => true,
    ),
    'numeric' => 
    array (
      'rule' => 'numeric',
      'message' => 'numeric rule error.',
      'last' => true,
    ),
  ),
  'zip' => 
  array (
    'numeric' => 
    array (
      'rule' => 'numeric',
      'message' => 'numeric rule error.',
      'last' => true,
    ),
  ),
  'phone_no' => 
  array (
    'numeric' => 
    array (
      'rule' => 'numeric',
      'message' => 'numeric rule error.',
      'last' => true,
    ),
  ),
); 
          
          function add($request_data){ 
            if(isset($request_data) && !empty($request_data)){
              if($this->save($request_data)){ 
                return $this->getLastInsertId(); 
              }
            }
            return 0; 
          }  
          
          function edit($request_data){ 
            if(isset($request_data["User"]["id"])){
              if($this->save($request_data)){ 
                return $request_data["User"]["id"]; 
              } 
               
            }
            return 0; 
          } 
          
          function getById( $id = null ){  
            $records = array();
            if( !empty($id) ){
              $records = $this->findById($id);
            }
            return $records; 
          }  
          
          function getAll(){ 
            $records = $this->find("all"); 
            return $records; 
          }  
          
          function getByQuery($query){ 
            $records = $this->query($query); 
            return $records; 
          }}