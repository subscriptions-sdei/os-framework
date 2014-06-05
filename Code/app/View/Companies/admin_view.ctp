<section class="fancy_container">    
    <div class="fancy_contain">
        <h4 class="poph2backgrnd"><?php echo "Company Details";?></h4>
    </div>
    <section class="fancy_contain">
        <span><?php echo $this->Html->image($this->Common->getCompanyLogoThumb($getData['Company']['logo'],'thumb')); ?></span>
    </section>
    <section class="fancy_contain">
        <label>Company Name</label>
        <span><?php echo $getData['Company']['name']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Address</label>
        <span><?php echo $getData['Company']['address']; ?></span>
    </section>
    <?php if($getData['Company']['address_2'] != ""){ ?>
    <section class="fancy_contain">
        <label>Address 2</label>
        <span><?php echo $getData['Company']['address_2']; ?></span>
    </section>
    <?php } ?>
    <section class="fancy_contain">
        <label>Country</label>
        <span><?php echo $getData['Country']['name']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>State</label>
        <span><?php echo $getData['State']['name']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>City</label>
        <span><?php echo $getData['Company']['city']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Zip</label>
        <span><?php echo $getData['Company']['zip']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Phone No.</label>
        <span><?php echo $getData['Company']['phone_no']; ?></span>
    </section>
    <div class="fancy_contain">
        <h4 class="poph2backgrnd"><?php echo "Contact Details";?></h4>
    </div>
    <section class="fancy_contain">
        <label>Name</label>
        <span><?php echo $getData['Admin']['first_name'].' '.$getData['Admin']['last_name']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Phone</label>
        <span><?php echo $getData['Admin']['phone']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Email</label>
        <span><?php echo $getData['Admin']['email']; ?></span>
    </section> 
    <div class="fancy_contain">
        <h4 class="poph2backgrnd"><?php echo "Subscription Details";?></h4>
    </div>
    <section class="fancy_contain">
        <label>Plan Name</label>
        <span><?php echo $getData['CompanySubscription']['Subscription']['name']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Plan Duration</label>
        <span><?php
                            $frequencyArray = array('1'=>'Weekly','2'=>'Monthly','3'=>'Yearly');
                            $freqIndex = $getData['CompanySubscription']['Subscription']['frequency'];
                       echo     $currFreq = $frequencyArray[$freqIndex];
                        ?></span>
    </section> 


</section>
<script type="text/javascript">
$(document).ready(function(){
$(".fancy_container section:even").css("background-color", "#dedede");
$(".fancy_container section:odd").css("background-color", "#ffffff");
 

});
</script>