<?php    
    class Order extends AppModel {
        var $name = 'Order';      
        

        /*
        * Defining Relationships
        */
        public $hasMany = array(
            'OrderDetail' => array(
                'className' => 'OrderDetail'
            )
        );
    }
    
?>
