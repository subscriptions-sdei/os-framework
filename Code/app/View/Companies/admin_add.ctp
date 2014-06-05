   <?php
   echo $this->Html->script('admin/admin_companies');?>    
     
   <div class="row">
      <?php echo $this->Form->create(null, array('url' => array('controller' => 'companies', 'action' => 'add'),'id'=>'addCompany','type'=>'file'));              
            echo $this->Form->hidden('Company.id',array('value'=>base64_encode($this->data['Company']['id'])));
            echo $this->Form->hidden('Admin.id',array('value'=>base64_encode($this->data['Admin']['id'])));
            echo $this->Form->hidden('CompanySubscription.id',array('value'=>base64_encode($this->data['CompanySubscription']['id'])));
            if(isset($this->data['Company']['logo']) && $this->data['Company']['logo'] !="") { $oldpic =$this->data['Company']['logo']; }else{ $oldpic = ""; }
            echo $this->Form->hidden('old_pic',array('value'=>$oldpic));
      ?>
         <div class="col-lg-8">
           <div class="col-lg-12"><h3><u>Company Information</u></h3></div>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Name<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('name',array('label' => false,'div' => false, 'placeholder' => 'Company Name','class' => 'form-control','maxlength' => 55));?>
                  </div>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Address <span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('address',array('label' => false,'div' => false, 'placeholder' => 'Address 1','class' => 'form-control','maxlength' => 80));?>
                  </div>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Address 2</label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('address_1',array('label' => false,'div' => false, 'placeholder' => 'Address 2','class' => 'form-control','maxlength' => 80));?>
                  </div>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Country<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php
                            echo $this->Form->input('country_id',array('options'=>$country,'div'=>false,'label'=>false,'class'=>'form-control','empty'=>'Select Country')); ?>
							<section id="stateloader" class="loader_img_state" style="display:none;"><?php echo $this->Html->image('ajax-loader.gif'); ?></section>
                  </div>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>State<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->hidden('hidden_state_val',array('value'=>$this->request->data['Company']['state_id'],'id'=>'hiddenCompanyState'));
                            echo $this->Form->input('state_id',array('options'=>array(),'div'=>false,'label'=>false,'class'=>'form-control','empty'=>'Select State / Province','rel'=>(!empty($this->request->data['Company']['state_id']) ? $this->request->data['Company']['state_id'] : ''))); ?>
                  </div>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>City<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('city',array('label' => false,'div' => false, 'placeholder' => 'City','class' => 'form-control','maxlength' => 55));?>
                  </div>
               </div>
            </div>
         
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Zip<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('zip',array('type'=>'text','label' => false,'div' => false, 'placeholder' => 'Zip','class' => 'form-control','maxlength' => 15));?>
                  </div>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Phone No.<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('phone_no',array('label' => false,'div' => false, 'placeholder' => 'Phone Number','class' => 'form-control','maxlength' => 12));?>
                  </div>
               </div>
            </div>
           
            <?php if(isset($this->data['Company']['id']) && $this->data['Company']['id'] != ""){ $class= "";}else{ $class= "required"; }?>
            <div class="row">
                <div class="col-lg-12">        
                    <div class="col-lg-12" id="mainimgcontainer">
                        <div class="form-group form-spacing">
                            <div class="col-lg-4 form-label">
                                <label>Logo<?php if($class != ""){  ?><span class="required"> * </span><?php } ?></label>
                            </div>
                            <div class="col-lg-4 form-label">
                               
                                     <?php echo $this->Form->input('logo',array('label' => false,'div' => false, 'type' => 'file','style' => 'display:inline-block !important','class'=>"upload $class" ));?>
       
                            </div>
                            <div class="col-lg-4" style="padding-bottom: 2px;">
                              <sub class="blue">1) Allowed file types: png, jpg, jpeg, gif <br/> 2) Minimum image upload size should be 100px x 100px</sub>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">        
                    <div class="col-lg-12">   
                      <div class="form-group clearfix">
                         
                         <div class="col-lg-4 form-label">
                                <label>&nbsp;</label>
                            </div>
                         <div class="col-lg-8 form-box" style="padding-top:10px;">
                          <?php $imgC = 0;
                            if(!empty($this->data['Company'])) {
                              
                                  $imageName = 'logo/thumb/'.$this->data['Company']['logo'];                
                                  if(file_exists(WWW_ROOT.'/img/'.$imageName) && !empty($this->data['Company']['logo']))
                                  {
                                     echo "<div class='col-lg-3 padding_btm_20' >". $this->Html->image($imageName, array('class'=>'deldivimg'))."</div>";
                                  }
                               
                              
                            }
                          ?>
                         </div>
                      </div>            
                   </div>
                    <div class="col-lg-3"></div>
                </div>
            </div>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Subscription Plan<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('CompanySubscription.subscription_id',array('type'=>'select','options'=>$subscriptionPlans,'label' => false,'div' => false, 'empty' => 'Select Plan','class' => 'form-control','escape'=>false));?>
                  </div>
               </div>
            </div>
            
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label"> 
                     <label>Activate</label>
                  </div>
                  <div class="col-lg-8 form-box">  
                     <label class="checkbox-inline"><?php if(isset($this->request->data['Company']['status']) && $this->request->data['Company']['status'] == 0){  $checked= "";}else{  $checked= "checked";} ?>
                        <?php echo $this->Form->input('status',array('label' => false,'div' => false,'type '=> 'checkbox', 'checked' => $checked));?>
                     </label>
                  </div>
               </div>
            </div>
            
             <div class="col-lg-12"><h3><u>Contact Information</u></h3></div>
           
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>First Name<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('Admin.first_name',array('label' => false,'div' => false, 'placeholder' => 'First Name','class' => 'form-control','maxlength' => 55,'readonly' => ''));?>
                  </div>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Last Name<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('Admin.last_name',array('label' => false,'div' => false, 'placeholder' => 'Last Name','class' => 'form-control','maxlength' => 55,'readonly' => ''));?>
                  </div>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Email<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('Admin.email',array('label' => false,'div' => false, 'placeholder' => 'Email','class' => 'form-control','maxlength' => 55,'readonly' => ''));?>
                  </div>
               </div>
            </div>
            <?php if($this->request->data['Company']['id'] == ""){ ?>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Password<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('Admin.password',array('type'=>'password','label' => false,'div' => false, 'placeholder' => 'Password','class' => 'form-control','maxlength' => 55,'readonly' => ''));?>
                  </div>
               </div>
            </div>
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Password<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('Admin.confirmpassword',array('type'=>'password','label' => false,'div' => false, 'placeholder' => 'Password','class' => 'form-control','maxlength' => 55,'readonly' => ''));?>
                  </div>
               </div>
            </div>
            <?php } ?>         
                        
            <div class="col-lg-12">
               <div class="form-group form-spacing">
                  <div class="col-lg-4 form-label">
                     <label>Phone No.<span class="required"> * </span></label>
                  </div>
                  <div class="col-lg-8 form-box">                
                     <?php echo $this->Form->input('Admin.phone',array('label' => false,'div' => false, 'placeholder' => 'Phone Number','class' => 'form-control','maxlength' => 12));?>
                  </div>
               </div>
            </div>
            
            <div class="col-lg-12 form-spacing">
               <div class="col-lg-4"><!--blank Div--></div>
               <div class="col-lg-8 form-box">
                 <?php echo $this->Form->button($buttonText, array('type' => 'submit','class' => 'btn btn-default'));?>
                 &nbsp;
                 <?php echo $this->Form->button('Reset', array('type' => 'reset','class' => 'btn btn-default'));?>                 
               </div>
            </div>
         </div>   
      <?php echo $this->Form->end(); ?>           
   </div><!-- /.row -->
