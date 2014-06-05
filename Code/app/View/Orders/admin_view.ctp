<section class="fancy_container">    
    <?php if(isset($getData) && !empty($getData)) { 
        
        $billing= "";
        $billing .= (isset($getData['Order']['billing_name']) && !empty($getData['Order']['billing_name'])) ? "<section class='fancy_contain'><label>Customer Name</label><span>".$getData['Order']['billing_name'].'</span></section>' : '';
        $billing .= (isset($getData['Order']['billing_street_1']) && !empty($getData['Order']['billing_street_1'])) ? "<section class='fancy_contain'><label>Street 1</label><span>".$getData['Order']['billing_street_1'].'</span></section>' : '';
        $billing .= (isset($getData['Order']['billing_street_2']) && !empty($getData['Order']['billing_street_2'])) ? "<section class='fancy_contain'><label>Street 2</label><span>".$getData['Order']['billing_street_2'].'</span></section>' : '';
        $billing .= (isset($getData['Order']['billing_city']) && !empty($getData['Order']['billing_city'])) ? "<section class='fancy_contain'><label>City</label><span>".$getData['Order']['billing_city'].'</span></section>' : '';
        $billing .= (isset($getData['Order']['billing_state']) && !empty($getData['Order']['billing_state'])) ? "<section class='fancy_contain'><label>State</label><span>".$getData['Order']['billing_state'].'</span></section>' : '';
        $billing .= (isset($getData['Order']['billing_zip']) && !empty($getData['Order']['billing_zip'])) ? "<section class='fancy_contain'><label>Zip</label><span>".$getData['Order']['billing_zip'].'</span></section>' : '';
        $billing .= (isset($getData['Order']['billing_phone']) && !empty($getData['Order']['billing_phone'])) ? "<section class='fancy_contain'><label>Phone</label><span>".$getData['Order']['billing_phone'].'</span></section>' : '';
        
        
        $shipping= "";
        $shipping .= (isset($getData['Order']['shipping_name']) && !empty($getData['Order']['shipping_name'])) ? "<section class='fancy_contain'><label>Customer Name</label><span>".$getData['Order']['shipping_name'].'</span></section>' : '';
        $shipping .= (isset($getData['Order']['shipping_street_1']) && !empty($getData['Order']['shipping_street_1'])) ? "<section class='fancy_contain'><label>Street 1</label><span>".$getData['Order']['shipping_street_1'].'</span></section>' : '';
        $shipping .= (isset($getData['Order']['shipping_street_2']) && !empty($getData['Order']['shipping_street_2'])) ? "<section class='fancy_contain'><label>Street 2</label><span>".$getData['Order']['shipping_street_2'].'</span></section>' : '';
        $shipping .= (isset($getData['Order']['shipping_city']) && !empty($getData['Order']['shipping_city'])) ? "<section class='fancy_contain'><label>City</label><span>".$getData['Order']['shipping_city'].'</span></section>' : '';
        $shipping .= (isset($getData['Order']['shipping_state']) && !empty($getData['Order']['shipping_state'])) ? "<section class='fancy_contain'><label>State</label><span>".$getData['Order']['shipping_state'].'</span></section>' : '';
        $shipping .= (isset($getData['Order']['shipping_zip']) && !empty($getData['Order']['shipping_zip'])) ? "<section class='fancy_contain'><label>Zip</label><span>".$getData['Order']['shipping_zip'].'</span></section>' : '';
        $shipping .= (isset($getData['Order']['shipping_phone']) && !empty($getData['Order']['shipping_phone'])) ? "<section class='fancy_contain'><label>Phone</label><span>".$getData['Order']['shipping_phone'].'</span></section>' : '';
        
        
    ?>
      

    <div class="fancy_contain">
        
        <h4 class="poph2backgrnd"><?php echo 'Billing Details';?></h4>        
    </div>
    
        <?php echo $billing; ?>
    
    <div class="fancy_contain">
        <h4 class="poph2backgrnd" ><?php echo 'Shipping Details';?></h4>        
    </div>
     
        <?php echo $shipping; ?>
    
     <div class="fancy_contain">
        <h4 class="poph2backgrnd"><?php echo 'Payment Details';?></h4>        
    </div>
    <section class="fancy_contain">
        <label>Name on Card</label>
        <span><?php echo $getData['Order']['name_on_card']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Card Number</label>
        <span><?php echo $getData['Order']['cc_number']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Expiration</label>
        <span>
        <?php $months = array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec') ?>
        <?php foreach($months as $key=>$val){ 
            if($getData['Order']['exp_month'] == $key){ $month = $val; }
        }
        echo $month.' '.$getData['Order']['exp_year']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Card Type</label>
        <span><?php echo $getData['Order']['card_type']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>CVV</label>
        <span><?php echo $getData['Order']['cvv']; ?></span>
    </section>
        

     
     
     
     
    <?php }else{ ?> 
        <section class="fancy_contain">
            <label></label>
            <span>No Record Found</span>
        </section>    
    <?php }?>
</section>
<script type="text/javascript">
$(document).ready(function(){
$(".fancy_container section:even").css("background-color", "#dedede");
$(".fancy_container section:odd").css("background-color", "#ffffff");
 

});
</script>