    <?php    
        echo $this->Html->script('fancybox/jquery.fancybox');
        echo $this->Html->css('fancybox/jquery.fancybox');    
    ?>
	
   	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('.fancybox').fancybox({
                maxWidth	: 750,
                maxHeight	: 1000,
                fitToView	: false,
                width		: '70%',
                height		: '90%',
                autoSize	: false,
                closeClick	: false,
                openEffect	: 'none',
                closeEffect	: 'none'
            });
		});
	
	</script>

<?php
echo $this->Html->css('editable/jquery-ui-1.10.1.custom');
echo  $this->Html->css('editable/jqueryui-editable');
echo $this->Html->script('editable/jquery-ui-1.10.1.custom.min');
echo $this->Html->script('editable/jqueryui-editable');
           ?>

<script>
$(function(){
   
    $('.options_gender').editable({
        source: [
              {value: '0', text: 'In Progress'},
              {value: '1', text: 'Shipped'},
              {value: '2', text: 'Cancelled'},
	      
           ],
			      
    success: function(response,newValue) { 
		if(newValue == "1" || newValue =="2") { setTimeout(function() {
    getDestroy(); 
     
}, 1000); /*$('.options_gender').editable("destroy");*/ }
		//if(newValue=="2") { alert("test"); }
		

    }
		
		
    });
function getDestroy(){
		$('.options_gender').editable("destroy"); }
	

});
</script>

    <?php
        $recordExits = false;
        
        if(isset($getData) && !empty($getData))
        {
           $recordExits = true;            
        }    
        echo $this->Form->create('Search', array('url' => array('controller' => 'orders', 'action' => 'index'),'id'=>'brandId','type'=>'get'));  ?>
        <div class="row padding_btm_20">
            <div class="col-lg-4">   
                 <?php echo $this->Form->input('keyword',array('value'=>$keyword,'label' => false,'div' => false, 'placeholder' => 'Search','class' => 'form-control','maxlength' => 55));?>
				 <span class="blue">(<b>Search by:</b>Transaction ID, User Name, Email, Order No)</span>
            </div>
            
            <div class="col-lg-4">                        
                <?php echo $this->Form->button('Search', array('type' => 'submit','class' => 'btn btn-default'));?>
				<?php echo $this->Html->link('List All',array('controller'=>'orders','action'=>'index'),array('class' => 'btn btn-default'));?>
            </div>
            <div class="col-lg-4">    
                <div class="addbutton">                
                  <?php echo $this->Html->link('Generate Reports',array('controller'=>'reports','action'=>'index'),array('class' => 'btn btn-default'));?>
                </div>
            </div>
        </div>
        <?php echo $this->Form->end();    
    ?>
    
    <div class="row">
        <div class="col-lg-4">                        
             <?php echo $this->Session->flash();?>   
        </div>            
    </div>
    
    <?php echo $this->Form->create('Order', array('url' => array('controller' => 'orders', 'action' => 'index'),'id'=>'orderFormId'));  ?>
    
    <div class="row">
        <div class="col-lg-12">            
            <div class="table-responsive">               
                 
                <?php if($recordExits)
                { ?>
                <table class="table table-bordered table-hover table-striped tablesorter">
                    <thead>
                        <tr>
							<th class="th_checkbox"><input type="checkbox" class="checkall"></th>
                            <th class="th_checkbox">Order No</th>
							<th class="th_checkbox">Customer Name</th>
                            <th class="th_checkbox">Email</th>
							<th class="th_checkbox">Price</th>
							<th class="th_checkbox">Payment Status</th>
                            <th class="th_checkbox">Order Status</th>
							<th class="th_checkbox">Transaction ID</th>
                            <th class="th_checkbox"><?php echo $this->Paginator->sort('created', 'Order Date'); ?> </th>
                            <th class="th_checkbox">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="dyntable">
                        <?php
                        $i = 0;
                        
                        foreach($getData as $key => $getData)
                        {
                            $class = ($i%2 == 0) ? ' class="active"' : '';
                            ?>
                        <tr <?php echo $class;?>>
						<td align="center"><input type="checkbox" name="checkboxes[]" class ="checkboxlist" value="<?php echo base64_encode($getData['Order']['id']);?>" ></td> 
						<td align="center"><?php echo $this->Html->link($getData['Order']['order_no'],array('controller'=>'orders','action'=>'invoice',base64_encode($getData['Order']['id'])),array('escape' =>false,'class' => 'fancybox fancybox.ajax')); ?></td>
						<td align="center"><?php echo $this->Html->link($getData['Order']['billing_name'],array('controller'=>'orders','action'=>'view',base64_encode($getData['Order']['id'])),array('escape' =>false,'class' => 'fancybox fancybox.ajax')); ?></td>
						<td align="center"><?php echo $this->Html->link($getData['Order']['billing_email'],"mailto:".$getData['Order']['billing_email'],array());?></td>
						<td align="center"><?php echo '$ '.$getData['Order']['amount'];?></td>
						<td align="center"><?php if($getData['Order']['payment_status'] == 1){ echo "Paid"; }else{ echo "Pending"; } ?></td>
						<!--<td align="center"><?php if($getData['Order']['order_status'] == 1){ echo "Shipped"; }else if($getData['Order']['order_status'] == 2){ echo "Cancelled"; }else{ echo "In Progress"; } ?></td>-->
						<td><?php if($getData['Order']['order_status'] == 0){ ?><a href="#" class="options_gender" id= "<?php echo $getData['Order']['id'];?>" data-value="<?php echo $getData['Order']['order_status'];?>" data-type="select" data-pk="<?php echo $getData['Order']['id']; ?>" data-url="/admin/orders/changeStatus/" data-original-title="Select options"> <?php if($getData['Order']['order_status'] == 1){ echo "Shipped"; }else if($getData['Order']['order_status'] == 2){ echo "Cancelled"; }else{ echo "In Progress"; } ?></a> <?php }else if($getData['Order']['order_status'] == 2){ echo "Cancelled"; }else{ echo "Shipped"; }  ?></td>
                        <td align="center"><?php if($getData['Order']['transaction_id'] !=""){ echo $getData['Order']['transaction_id']; }else {echo "NA"; }?></td>
						
						<td align="center"><?php echo date('M j, Y',strtotime($getData['Order']['created']));?></td>                                                       
						<td align="center">
						<?php
							//echo $this->Html->link($this->Html->image("admin/view.png", array("alt" => "Reports","title" => "Reports")),"/admin/reports/index/",array('escape' =>false,'class' => ''));
							echo $this->Html->link($this->Html->image("admin/delete.png", array("alt" => "Edit","title" => "Delete")),"/admin/orders/delete/".base64_encode($getData['Order']['id']),array('escape' =>false),"Are you sure you wish to delete this order?");
						?>
						
						</td>                    
                        </tr>
                        <?php
                            $i++;
                        } ?>
                    </tbody>
                    
                </table>
                <div class="row oprdiv">
                  <div class="col-lg-12 actiondivinr"> 
                     <?php
                        if($recordExits)
                        { ?>
                            <div class="row">
								<div class="col-lg-2">   
									<?php echo $this->Form->input('delete', array('label' => false,'div' => false,'options' => array('1'=>'Delete'),'class' => 'form-control','id' => 'statusId','empty'=>'-Select Action-'));?>      
								</div>
								<div class="col-lg-2">   
									<?php echo $this->Form->button('Submit', array('type' => 'submit','class' => 'btn btn-default disabled','id' => 'operationId'));?>
								</div>
							</div> 
                    <?php     }
                     ?>
                    </div>
                 </div>
                <div class="row">
                                      
                     <div class="col-lg-12"> <?php
                        if($this->Paginator->param('pageCount') > 1)
                        {
                            echo $this->element('admin/pagination');                 
                        }
                        ?>
                     </div>
                 </div>
                <div class="row padding_btm_20 ">
                     <div class="col-lg-2">   
                          LEGENDS:                        
                     </div>
                     <div class="col-lg-2"><?php echo $this->Html->image("admin/delete.png"). " Delete &nbsp;"; ?></div>                 
					
                    
                 </div>
              
               <?php
                }else{ 
                    echo $this->element('admin/no_record_exists');
                } ?>
            </div>
        </div>         
    </div><!-- /.row -->
   <?php  echo $this->Form->end(); ?>
