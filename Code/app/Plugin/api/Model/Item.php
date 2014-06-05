<?php Class Item extends AppModel{ 
        var $name = 'Item';
        var $validate = array (
  
  'unique_id' => 
  array (
    'alphanumeric' => 
    array (
      'rule' => 'alphanumeric',
      'message' => 'alphanumeric rule error.',
      'last' => true,
    ),
  ),
  'company_id' => 
  array (
    'numeric' => 
    array (
      'rule' => 'numeric',
      'message' => 'numeric rule error.',
      'last' => true,
    ),
  ),
  'added_by' => 
  array (
    'numeric' => 
    array (
      'rule' => 'numeric',
      'message' => 'numeric rule error.',
      'last' => true,
    ),
  ),
  'name' => 
  array (
    'alphanumeric' => 
    array (
      'rule' => 'alphanumeric',
      'message' => 'alphanumeric rule error.',
      'last' => true,
    ),
  ),
  'price' => 
  array (
    'money' => 
    array (
      'rule' => 'money',
      'message' => 'money rule error.',
      'last' => true,
    ),
  ),
); 
          
          function add($request_data){ 
            if(isset($request_data) && !empty($request_data)){
              if($this->save($request_data)){ 
                return $this->getLastInsertId(); 
              }else{
               
              }
            }
           // return 0; 
          }  
          
          function edit($request_data){ 
            if(isset($request_data["Item"]["id"])){
              if($this->save($request_data)){ 
                return $request_data["Item"]["id"]; 
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