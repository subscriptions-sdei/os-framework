<?php Class Category extends AppModel{ 
        var $name = 'Category';
        var $validate = array (
  'id' => 
  array (
    'numeric' => 
    array (
      'rule' => 'numeric',
      'message' => 'numeric rule error.',
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
  'category' => 
  array (
    'numeric' => 
    array (
      'rule' => 'numeric',
      'message' => 'numeric rule error.',
      'last' => true,
    ),
  ),
  'parent_id' => 
  array (
    'alphanumeric' => 
    array (
      'rule' => 'alphanumeric',
      'message' => 'alphanumeric rule error.',
      'last' => true,
    ),
  ),
  'status' => 
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
            if(isset($request_data["Category"]["id"])){
              if($this->save($request_data)){ 
                return $request_data["Category"]["id"]; 
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