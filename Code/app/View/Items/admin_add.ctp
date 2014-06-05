<?php
   echo $this->Html->script('admin/admin_items');
   echo $this->Html->script('ckeditor/ckeditor');
?>
   
     <?php  echo $this->Form->create('Item', array('url' => array('controller' => 'items', 'action' => 'add'),'id'=>'itemsAdd','type' => 'file'));            
            echo $this->Form->hidden('Item.id',array('value'=>base64_encode($this->data['Item']['id'])));
            echo $this->Form->hidden('picCount',array('value' => $picLimit,'id'=>'totalpIcCount'));
        ?>
        
     <div class="row">
         <div class="col-lg-12">        
             <div class="col-lg-12">
                 <div class="form-group form-spacing">
                     <div class="col-lg-2 form-label">
                         <label>Product Name<span class="required"> * </span></label>
                     </div>
                     <div class="col-lg-5 form-box">                
                         <?php echo $this->Form->input('name',array('label' => false,'div' => false, 'placeholder' => 'Enter Name','class' => 'form-control','maxlength' => 55));?>
                     </div>
                     <div class="col-lg-5">
                       <!--blank div-->
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-lg-12">        
             <div class="col-lg-12">
                 <div class="form-group form-spacing">
                     <div class="col-lg-2 form-label">
                         <label>Product Code<span class="required"> * </span></label>
                     </div>
                     <div class="col-lg-5 form-box">                
                         <?php echo $this->Form->input('product_code',array('label' => false,'div' => false, 'placeholder' => 'Enter Product Code','class' => 'form-control','maxlength' => 55));?>
                     </div>
                     <div class="col-lg-5">
                       <!--blank div-->
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-lg-12">        
             <div class="col-lg-12">
                 <div class="form-group form-spacing">
                     <div class="col-lg-2 form-label">
                         <label>Category<span class="required"> * </span></label>
                     </div>
                     <div class="col-lg-5 form-box">
                     <?php foreach($categories as $key => $val){ 
                                 $opt[$key] = $val;
                                 $childopt = $this->Common->getCategory($key);

                                 if(!empty($childopt)){
                                    foreach($childopt as $key1 => $newopt){
                                       $opt[$key1] = '&nbsp;&nbsp;&nbsp;-'.$newopt;
                                    }
                                 }
                           }?>
                          <?php if(isset($this->request->data['ItemCategory']) && !empty($this->request->data['ItemCategory'])){
                                    foreach($this->request->data['ItemCategory'] as $selectcat){
                                       $selectedVal[] = $selectcat['category_id'];
                                    }
                                 }else{ $selectedVal[] =''; }   ?>
                         <?php echo $this->Form->input('ItemCategory.category_id',array('type'=>'select','multiple'=>true,'selected'=>$selectedVal,'options'=>$opt,'label' => false,'div' => false, 'empty' => 'Select Category','class' => 'form-control','escape'=>false));?>
                     </div>
                     <div class="col-lg-5">
                       <sub class="blue"> Click control to select multiple categories</sub>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="row">
         <div class="col-lg-12">        
             <div class="col-lg-12">
                 <div class="form-group form-spacing">
                     <div class="col-lg-2 form-label">
                         <label>Related Product</label>
                     </div>
                     <div class="col-lg-5 form-box">
                     
                          <?php if(isset($this->request->data['RelatedItem'])  && !empty($this->request->data['RelatedItem'])){
                                    foreach($this->request->data['RelatedItem'] as $selectProd){
                                       $selectedProduct[] = $selectProd['other_item_id'];
                                    }
                                 }else{ $selectedProduct =array(); }
                                 
                                 ?>
                         <?php echo $this->Form->input('RelatedItem.other_item_id',array('type'=>'select','multiple'=>true,'selected'=>$selectedProduct,'options'=>$relItems,'label' => false,'div' => false, 'empty' => 'Select Category','class' => 'form-control','escape'=>false));?>
                     </div>
                     <div class="col-lg-5">
                        <sub class="blue"> Click control to select multiple products</sub>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <div class="row">        
        <div class="col-lg-12">
            <div class="col-lg-12"> 
               <div class="form-group form-spacing">
                  <div class="col-lg-2 form-label">
                        <label>Description<span class="required"> * </span></label>
                  </div> 
                  <div class="col-lg-10 form-box">             
                        <?php echo $this->Form->input('description',array('label' => false,'div' => false, 'type' => 'textarea', 'placeholder' => 'Enter Description', 'escape' => false,'class' => 'form-control','class' => 'ckeditor'));?>
                  </div>
                      
               </div>
            </div>
         </div>
     </div>      
     <div class="row">
         <div class="col-lg-12">        
             <div class="col-lg-12">
                 <div class="form-group form-spacing">
                     <div class="col-lg-2 form-label">
                         <label>Unit Weight <span class="required">*</span></label>
                     </div>
                     <div class="col-lg-2 form-box">                
                         <?php echo $this->Form->input('product_weight',array('type'=>'text','label' => false,'div' => false, 'placeholder' => 'Enter Unit Weight','class' => 'form-control','maxlength' => 5));?>
                     </div>
                     <div class="col-lg-8"><span style="vertical-align: sub;">Kg</span>
                       <!--blank div-->
                     </div>
                 </div>
             </div>
         </div>
     </div>
      <div class="row">
         <div class="col-lg-12">        
             <div class="col-lg-12">
                 <div class="form-group form-spacing">
                     <div class="col-lg-2 form-label">
                         <label>Price ($) <span class="required">*</span></label>
                     </div>
                     <div class="col-lg-2 form-box">                
                         <?php echo $this->Form->input('price',array('type'=>'text','label' => false,'div' => false, 'placeholder' => 'Enter Price','class' => 'form-control number'));?>
                     </div>
                     <div class="col-lg-8">
                       <!--blank div-->
                     </div>
                 </div>
             </div>
         </div>
      </div>
       <div class="row">
         <div class="col-lg-12">        
             <div class="col-lg-12">
                 <div class="form-group form-spacing">
                     <div class="col-lg-2 form-label">
                         <label>Featured</label>
                     </div>
                     <div class="col-lg-5 form-box">
                        <label class="checkbox-inline"><?php if(isset($this->request->data['Item']['is_featured']) && $this->request->data['Item']['is_featured'] == 0){   $checked1= "";}else{ $checked1= "checked";} ?>
                         <?php echo $this->Form->input('is_featured',array('class '=>'checkbox-inline','label' => false,'div' => false,'type '=> 'checkbox','checked' => $checked1));?>
                        </label>
                     </div>
                     <div class="col-lg-5">
                       <!--blank div-->
                     </div>
                 </div>
             </div>
         </div>
      </div>
      <div class="row">
         <div class="col-lg-12">        
             <div class="col-lg-12">
                 <div class="form-group form-spacing">
                     <div class="col-lg-2 form-label">
                         <label>Activate</label>
                     </div>
                     <div class="col-lg-5 form-box">
                        <label class="checkbox-inline"><?php if(isset($this->request->data['Item']['status']) && $this->request->data['Item']['status'] == 0){  $checked= "";}else{  $checked= "checked";} ?>
                         <?php echo $this->Form->input('status',array('class '=>'checkbox-inline','label' => false,'div' => false,'type '=> 'checkbox','checked' => $checked));?>
                        </label>
                     </div>
                     <div class="col-lg-5">
                       <!--blank div-->
                     </div>
                 </div>
             </div>
         </div>
      </div>
      
      <div class="row">
         <div class="col-lg-12">        
             <div class="col-lg-12" id="mainimgcontainer">
                 <div class="form-group form-spacing">
                     <div class="col-lg-2 form-label">
                         <label>Image <!--<span class="required"> * </span>--></label>
                     </div>
                     <div class="col-lg-4 form-label"> 
                        <!--<div class=" btn btn-primary">-->
                             <!-- <span>Upload</span>--><?php //if($this->data['Item']['id'] == "" ){ $required ="required"; }else{ $required =""; } ?>
                              <?php echo $this->Form->input('ItemImage.image_name.0',array('label' => false,'div' => false, 'type' => 'file','style' => 'display:inline-block !important','class'=>"upload" ));?>
                        <!--</div>-->
                         <?php //echo $this->Form->input('ItemImage.image_name.0',array('label' => false,'div' => false, 'type' => 'file','style' => 'display:inline-block !important'));?>
                         
                         <?php echo $this->Html->link('Add More','javascript:void(0)',array('class'=>'addnewuploaderlink')); ?>
                         
                     </div>
                     <div class="col-lg-6" style="padding-bottom: 2px;">
                       <sub class="blue"> 1) Maximum 10 images can be uploaded <br/>2) Allowed file types: png, jpg, jpeg, gif</sub>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     
      <div id= "adduploader">
               
      </div> 
     
      <div class="row">
         <div class="col-lg-12">        
             <div class="col-lg-12">   
               <div class="form-group clearfix">
                  <span  ttlCount= "<?php echo count($this->data['ItemImage']); ?>" id= "oldpiccount"></span>
                  <div class="col-lg-2 form-label">
                         <label>&nbsp;</label>
                     </div>
                  <div class="col-lg-10 form-box" style="padding-top:10px;">
                   <?php $imgC = 0;
                     if(!empty($this->data['ItemImage'])) {
                        foreach($this->data['ItemImage'] as $val){
                           $imageName = 'items/thumb_small/'.$val['image'];                
                           if(file_exists(WWW_ROOT.'/img/'.$imageName) && !empty($val['image']))
                           {
                              echo "<div class='col-lg-3 padding_btm_20' id =div_image_".$val['id']." >". $this->Html->image($imageName, array("title" => $this->data['Item']['name'],'class'=>'deldivimg')).' '.$this->Html->link($this->Html->image('admin/delete.png'),'javascript:void(0)',array('itmId'=>$val['id'],'class'=>'deleteimgLnk imgverticaltop','escape'=>false))."</div>";
                           }
                        }
                       
                     }
                   ?>
                  </div>
               </div>            
            </div>
             <div class="col-lg-3"></div>
         </div>
     </div>
     
      <div class="col-lg-12 form-spacing">&nbsp;</div>
       
       <div class="col-lg-12">
           <div class="col-lg-12">
               <div class="col-lg-2">
                 <!--blank div-->
               </div>
               <div class="col-lg-10 form-box">
                   <?php echo $this->Form->button($buttonText, array('type' => 'submit','class' => 'btn btn-default'));?>
                    &nbsp;
                   <?php echo $this->Form->button('Reset', array('type' => 'reset','class' => 'btn btn-default'));?>
                   
               </div>
           </div>     
       </div>
      <div class="col-lg-12 form-spacing">&nbsp;</div>
     <?php echo $this->Form->end(); ?>
     </div>

     
     
     
     