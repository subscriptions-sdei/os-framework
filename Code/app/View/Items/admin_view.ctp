<section class="fancy_container">    
    <section class="fancy_contain">
        <h2 class="poph2backgrnd"><?php echo "Product Detail";?></h2>
    </section>
    <section class="fancy_contain">
        <label>Product Name</label>
        <span><?php echo $data['Item']['name']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Product Code</label>
        <span><?php echo $data['Item']['product_code']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Category</label>
        <span><?php foreach($data['ItemCategory'] as $cat){ echo ucwords($cat['Category']['category']).", "; } ?></span>
    </section>
    <section class="fancy_contain">
        <label>Related Product</label>
        <span><?php if(!empty($data['RelatedItem'])){ foreach($data['RelatedItem'] as $prod){ echo ucwords($prod['Item']['name']).", "; } }else{ echo "NA"; } ?></span>
    </section>
    <section class="fancy_contain">
        <label>Description</label>
        <span><?php echo $data['Item']['description']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Unit Weight<sup>(Kg)</sup></label>
        <span><?php echo $data['Item']['product_weight']; ?></span>
    </section>
    <section class="fancy_contain">
        <label>Price<sup>($)</sup></label>
        <span><?php echo $data['Item']['price']; ?></span>
    </section>   
     <section class="fancy_contain">
        <label style="width:100%;">Product Pics:</label>
       <?php 
        if(!empty($data['ItemImage'])) {
           foreach($data['ItemImage'] as $val){
              $imageName = 'items/thumb_small/'.$val['image'];                
              if(file_exists(WWW_ROOT.'/img/'.$imageName) && !empty($val['image']))
              {
                 echo "<div class='picfancydiv'>". $this->Html->image($imageName, array("title" => $data['Item']['name'],'style'=>'padding:2px;'))."</div>";
              }
           }
          
        }
        ?>  
    </section>
     
</section>
    

        
      

     
     
     
     