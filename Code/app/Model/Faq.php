<?php    
    class Faq extends AppModel {
        var $name = 'Faq';        
        public $validate = array(
            'title'=>array(                 
                'rule1' => array(
                    'required' => true,
                    'rule' => array('notEmpty'),
                    'message' => 'Please enter the question.'
                ),
                'rule2' => array(
                    'rule' => 'checkUnique',
                    'message'=>'Same question has been already entered.'
                )
            ), 
        
        'description' => array(
            'rule'    => 'notEmpty',
            'message' => 'Please enter the answer.'
        )
    );
        public function checkUnique(){
            App::uses('CakeSession', 'Model/Datasource');
            $companyId = CakeSession::read('loggedUserInfo.company_id');
        
			if(!empty($this->data['Faq']['id'])){
				$data = $this->find('first',array('conditions'=>array('Faq.title'=>$this->data['Faq']['title'],'Faq.id !='=>$this->data['Faq']['id'],'Faq.company_id'=> $companyId)));
			}else{
				$data = $this->find('first',array('conditions'=>array('Faq.title'=>$this->data['Faq']['title'],'Faq.company_id'=> $companyId)));    
			}
			
			if(!empty($data) && count($data) > 0){
				return false;
			}else{
				return true;
			}
		}
    }
?>