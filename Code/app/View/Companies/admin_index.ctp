    <?php    
        echo $this->Html->script('fancybox/jquery.fancybox');
        echo $this->Html->css('fancybox/jquery.fancybox');
		echo $this->Html->script('admin/admin_companies_list');
    ?>   
   
    <?php
        $recordExits = false;            
        if(isset($getData) && !empty($getData))
        {
           $recordExits = true;            
        }
        echo $this->Form->create('Search', array('url' => array('controller' => 'companies', 'action' => 'index'),'id'=>'userId','type'=>'get'));  ?>
		<?php echo $this->Form->hidden('alphabet_letter',array('id'=>'hiddenalpha')); ?>
        <div class="row padding_btm_20">
            <div class="col-lg-4">   
                 <?php echo $this->Form->input('keyword',array('value'=>$keyword,'label' => false,'div' => false, 'placeholder' => 'Keyword Search','class' => 'form-control','maxlength' => 55));?>
				 <span class="blue">(<b>Search by:</b>Company Name, Address)</span>
            </div>
           
            <div class="col-lg-4">                        
                <?php echo $this->Form->button('Search', array('type' => 'submit','class' => 'btn btn-default'));?>
				<?php echo $this->Html->link('List All',array('controller'=>'companies','action'=>'index'),array('class' => 'btn btn-default'));?>
            </div>
            <div class="col-lg-4">    
                <div class="addbutton">                
                    <?php echo $this->Html->link('Add New Company','/admin/companies/add',array('class' => 'icon-file-alt','title' => 'Add Company'));?>
                </div>
            </div>
        </div>
		<div class="row padding_btm_20"> 
			<ul class="letters clearfix">
				<li class="widthFirst"><span class="blue"><b>Alphabetic Search:</b></span></li>
				<?php
				foreach($alphabetArray as $alphabetArr)
				{
					if($alphabetArr == $alphakeyword){ $active = "activeAlpha"; }else{ $active = "";}
					echo "<li>";						
					echo $this->Html->link($alphabetArr,'javascript:void(0)',array('escape' =>false,'onClick'=>'alphaSearch(this)','class'=>$active));
					echo "</li>";
				}
				?>
			</ul>
		</div>
        <?php echo $this->Form->end(); ?>
		
    <div class="row">
        <div class="col-lg-4">                        
             <?php echo $this->Session->flash();?>   
        </div>            
    </div>
    
    <?php echo $this->Form->create('Company', array('url' => array('controller' => 'companies', 'action' => 'index'),'id'=>'CompanyFormId'));  ?>
    
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
                            <th class="th_checkbox"><?php echo "Logo"; ?></th>
                            <th><?php echo $this->Paginator->sort('name', 'Company Name'); ?></th>
                            <th ><?php echo "Company Phone No"; ?></th>
							<th><?php echo "Contact Person"; ?></th>
                            <th><?php echo "Contact email"; ?></th>
                            <th class="th_checkbox"><?php echo $this->Paginator->sort('created', 'Created'); ?> </th>                            
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
                            <td align="center"><input type="checkbox" name="checkboxes[]" class ="checkboxlist" value="<?php echo base64_encode($getData['Company']['id']);?>" ></td>     
                           <?php   $status = $getData['Company']['status'];
                                    $statusImg = ($getData['Company']['status'] == 1) ? 'active' : 'inactive';
                                    echo $this->Form->hidden('status',array('value'=>$status,'id'=>'statusHidden_'.$getData['Company']['id'])); ?>
                            <?php  $pid = $getData['Company']['id'];?>
                            <td align="center"><?php echo $this->Html->link($this->Html->image("admin/".$statusImg.".png", array("alt" => ucfirst($statusImg),"title" => ucfirst($statusImg))),'javascript:void(0)',array('escape'=>false,'id'=>'link_status_'.$getData['Company']['id'],'onclick'=>'setStatus('.$pid.')')) ; ?></td>
                            <td  align="center"><?php echo $this->Html->image($this->Common->getCompanyLogoThumb($getData['Company']['logo'],'thumb')); ?></td>
                            <td><?php echo $this->Html->link($getData['Company']['name'],"/admin/companies/add/".base64_encode($getData['Company']['id']),array('escape' =>false)); ?></td>
							<td align="center"><?php echo $getData['Company']['phone_no']; ?></td>
                            <td align="center"><?php echo $getData['Admin']['first_name'].' '.$getData['Admin']['last_name']; ?></td>
                            <td><?php echo $this->Html->link($getData['Admin']['email'],"mailto:".$getData['Admin']['email'],array());?></td>
							<td align="center"><?php echo date('M j, Y',strtotime($getData['Company']['created']));?></td>                            
                            <td align="center">
                            <?php
                                echo $this->Html->link($this->Html->image("admin/edit.png", array("alt" => "Edit","title" => "Edit")),"/admin/companies/add/".base64_encode($getData['Company']['id']),array('escape' =>false));
                                echo $this->Html->link($this->Html->image("admin/delete.png", array("alt" => "Edit","title" => "Delete")),"/admin/companies/delete/".base64_encode($getData['Company']['id']),array('escape' =>false),"Are you sure you wish to delete this company?");
								echo $this->Html->link($this->Html->image("admin/view.png", array("alt" => "Company Detail","title" => "Company Detail")),"/admin/companies/view/".base64_encode($getData['Company']['id']),array('escape' =>false,'class' => 'fancybox fancybox.ajax'));                                
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
					
                    
                 </div>
              
               <?php
                }else{ 
                    echo $this->element('admin/no_record_exists');
                } ?>
            </div>
        </div>         
    </div><!-- /.row -->
   <?php  echo $this->Form->end(); ?>