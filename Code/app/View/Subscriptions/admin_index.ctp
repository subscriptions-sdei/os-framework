    <?php    
        echo $this->Html->script('fancybox/jquery.fancybox');
        echo $this->Html->css('fancybox/jquery.fancybox');
		echo $this->Html->script('admin/admin_user_list');
		echo $this->Html->script('admin/admin_subscriptions');
    ?>   
   
    <?php
        $recordExits = false;            
        if(isset($getData) && !empty($getData))
        {
           $recordExits = true;            
        }
        echo $this->Form->create('Search', array('url' => array('controller' => 'subscriptions', 'action' => 'index'),'id'=>'userId','type'=>'get'));  ?>
		
        <div class="row padding_btm_20">
            <div class="col-lg-4">   
                 <?php echo $this->Form->input('keyword',array('value'=>$keyword, 'label' => false,'div' => false, 'placeholder' => 'Keyword Search','class' => 'form-control','maxlength' => 55));?>
				 <span class="blue">(<b>Search by:</b>Plan Name)</span>
            </div>
           
            <div class="col-lg-4">                        
                <?php echo $this->Form->button('Search', array('type' => 'submit','class' => 'btn btn-default'));?>
				<?php echo $this->Html->link('List All',array('controller'=>'subscriptions','action'=>'index'),array('class' => 'btn btn-default'));?>
            </div>
            <div class="col-lg-4">    
                <div class="addbutton">                
                    <?php echo $this->Html->link('Add New Subscription Plan','/admin/subscriptions/add',array('class' => 'icon-file-alt','title' => 'Add New Subscription Plan'));?>
                </div>
            </div>
        </div>		
        <?php echo $this->Form->end(); ?>
		
    <div class="row">
        <div class="col-lg-4">                        
             <?php echo $this->Session->flash();?>   
        </div>            
    </div>
    
    <?php echo $this->Form->create('Subscription', array('url' => array('controller' => 'subscriptions', 'action' => 'index'),'id'=>'UserFormId'));  ?>
    
    <div class="row">
        <div class="col-lg-12">            
            <div class="table-responsive">               
                 
                <?php if($recordExits)
                { ?>
                <table class="table table-bordered table-hover table-striped tablesorter">
                    <thead>
                        <tr>
                            <th class="th_checkbox"><input type="checkbox" class="checkall"></th>
							<th class="th_checkbox"><?php echo $this->Paginator->sort('status', 'Status'); ?> </th>
                            <th><?php echo $this->Paginator->sort('Subscription.name', 'Plan Name'); ?></th>
                            <th><?php echo $this->Paginator->sort('Subscription.frequency', 'Frequency'); ?></th>
                            <th><?php echo $this->Paginator->sort('Subscription.amount', 'Amount'); ?></th>                            
                            <th class="th_checkbox"><?php echo $this->Paginator->sort('created', 'Created'); ?> </th>                            
                            <th class="th_checkbox">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="dyntable">
                        <?php
                        $i = 0;
                        $frequencyArray = array('1'=>'Weekly','2'=>'Monthly','3'=>'Yearly');
                        foreach($getData as $key => $getData)
                        {
                            $class = ($i%2 == 0) ? ' class="active"' : '';
                            ?>
                        <tr <?php echo $class;?>>
                            <td align="center"><input type="checkbox" name="checkboxes[]" class ="checkboxlist" value="<?php echo base64_encode($getData['Subscription']['id']);?>" ></td>     
                           <?php   $status = $getData['Subscription']['status'];
                                    $statusImg = ($getData['Subscription']['status'] == 1) ? 'active' : 'inactive';
                                    echo $this->Form->hidden('status',array('value'=>$status,'id'=>'statusHidden_'.$getData['Subscription']['id'])); ?>
                            <?php  $pid = $getData['Subscription']['id'];?>
                            <td align="center"><?php echo $this->Html->link($this->Html->image("admin/".$statusImg.".png", array("alt" => ucfirst($statusImg),"title" => ucfirst($statusImg))),'javascript:void(0)',array('escape'=>false,'id'=>'link_status_'.$getData['Subscription']['id'],'onclick'=>'setStatus('.$pid.')')) ; ?></td>
                            <td><?php echo ucwords($getData['Subscription']['name']); ?></td>
                            <td><?php $freqIndex = $getData['Subscription']['frequency'];
										$currFreq = $frequencyArray[$freqIndex];
										echo $currFreq; ?>
							</td>
                            <td><?php echo '$'.$getData['Subscription']['amount']; ?></td>
                            
                            <td align="center"><?php echo date('M j, Y',strtotime($getData['Subscription']['created']));?></td>                            
                            <td align="center">
                            <?php
                                echo $this->Html->link($this->Html->image("admin/edit.png", array("alt" => "Edit","title" => "Edit")),"/admin/subscriptions/add/".base64_encode($getData['Subscription']['id']),array('escape' =>false));
                                echo $this->Html->link($this->Html->image("admin/delete.png", array("alt" => "Edit","title" => "Delete")),"/admin/subscriptions/delete/".base64_encode($getData['Subscription']['id']),array('escape' =>false),"Are you sure you wish to delete this subscription plan?");
								echo $this->Html->link($this->Html->image("admin/view.png", array("alt" => " Detail","title" => "Detail")),"/admin/subscriptions/view/".base64_encode($getData['Subscription']['id']),array('escape' =>false,'class' => 'fancybox fancybox.ajax'));                                
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
                        {
                            echo $this->element('admin/operation');  // Active/ Inactive/ Delete
                        }
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
                     <div class="col-lg-2"> <?php echo $this->Html->image("admin/edit.png"). " Edit"; ?> </div>
                     <div class="col-lg-2"> <?php echo $this->Html->image("admin/active.png"). " Active"; ?> </div>
                     <div class="col-lg-2"> <?php echo $this->Html->image("admin/inactive.png"). " Inactive"; ?> </div>
                     <div class="col-lg-2"> <?php echo $this->Html->image("admin/view.png"). " View"; ?> </div>
					 <div class="col-lg-2"> &nbsp;</div>
					 <!--<div class="col-lg-2"> <?php echo $this->Html->image("admin/male.png"). " Male"; ?> </div>
					 <div class="col-lg-2"> <?php echo $this->Html->image("admin/female.png"). " Female"; ?> </div>-->
                    
                 </div>
              
               <?php
                }else{ 
                    echo $this->element('admin/no_record_exists');
                } ?>
            </div>
        </div>         
    </div><!-- /.row -->
   <?php  echo $this->Form->end(); ?>