<?php    
    class Category extends AppModel {
        var $name = 'Category';        
                
        public $validate = array(
        'category' => array(
            'notEmpty'=>array(
                'required'=>true,
                'rule' => array('notEmpty'),
                'message' => 'Category name can not be blank.'
            ),
            'rule1' => array(
                'required' => true,
                'rule' => array('checkUnique'),
                'message' => 'Category name already in use.'
            )
        )
        );
        
    public function checkUnique(){
        App::uses('CakeSession', 'Model/Datasource');
        $companyId = CakeSession::read('loggedUserInfo.company_id');
        
        if(!empty($this->data['Category']['id'])){
            $data = $this->find('first',array('conditions'=>array('Category.category'=>$this->data['Category']['category'],'Category.id !='=>$this->data['Category']['id'],'Category.company_id'=> $companyId)));
        }else{
            $data = $this->find('first',array('conditions'=>array('Category.category'=>$this->data['Category']['category'],'Category.company_id'=> $companyId)));    
        }
        
        if(!empty($data) && count($data) > 0){
            return false;
        }else{
            return true;
        }
    }   
        
    }
?>