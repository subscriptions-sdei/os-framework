<?php    
    class User extends AppModel {
        var $name = 'User';      
        
        public $validate = array(
        'first_name' => array(
            'rule1' => array(
                'rule' => 'notEmpty',                
                'message'    => 'Please enter first name.'                
            ),
            'rule2' => array(
                'rule' => 'alphaNumeric',                
                'message'    => 'Only characters and numbers are allowed.'
            )
        ),        
        'last_name' => array(
            'rule'    => 'notEmpty',
            'message' => 'Please enter last name.'
        ),
        'gender' => array(
            'rule'    => 'notEmpty',
            'message' => 'Please select gender.'
        ),        
        'email' => array(
            'email' => array(
                'rule' => 'email',                
                'message'    => 'Please enter a valid email address.'                
            ),
            'rule1' => array(
                'rule' => 'checkUnique',                
                'message'    => 'Email already exists.'
            )
        ),       
        'password' => array(
            'rule'    => array('minLength', '6'),
            'message' => 'Please enter at least 6 characters.'
        ),
        'address_1' => array(
            'rule'    => 'notEmpty',
            'message' => 'Please enter valid address.'
        ),
        'city' => array(
            'rule'    => 'notEmpty',
            'message' => 'Please enter city.'
        ),
        'country_id' => array(
            'rule'    => 'notEmpty',
            'message' => 'Please select a country.'
        ),
        'state_id' => array(
            'rule'    => 'notEmpty',
            'message' => 'Please select a state.'
        ),
        'zip' => array(
            'rule'    => 'notEmpty',
            'message' => 'Please enter zipcode.'
        ),
        'phone_n0' => array(
            'rule'    => 'notEmpty',
            'message' => 'Please enter phone no.'
        ),
        
    );
        
        public function checkUnique(){
            if(!empty($this->data['User']['id'])){
                $data = $this->find('first',array('conditions'=>array('User.email'=>$this->data['User']['email'],'User.id !='=>$this->data['User']['id'])));
            }else{
                $data = $this->find('first',array('conditions'=>array('User.email'=>$this->data['User']['email'])));    
            }
            
            if(!empty($data) && count($data) > 0){
                return false;
            }else{
                return true;
            }
        }
        /*
        * Defining Relationships
        */
        public $belongsTo = array(
            'Country' => array(
                'className' => 'Country',
                'fields'    => array('id','name')
            ),
            'State' => array(
                'className' => 'State',
                'fields'    => array('id','name')
            )
        );
    }
    
?>
