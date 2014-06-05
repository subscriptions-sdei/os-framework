    <!DOCTYPE html>
    <html lang="en">
        <head>
            <?php $logoData  = $this -> requestAction(array('controller' => 'settings','action' => 'getlogodata'));
                    if($logoData =="No Logo"){
                        $logoLink = "No Logo";
                        $logoimage = "logo/thumb/no_pic.png";
                    }else{
                        $logoLink = $logoData['Company']['name'];
                        $logoimage = "logo/thumb/".$logoData['Company']['logo'];
                    }
            ?>
            <?php echo $this->Html->charset('UTF-8'); ?>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="description" content="">
            <meta name="author" content="">  
            <title>Plugin Project - Admin </title>
            <?php
                echo $this->Html->css('admin/bootstrap'); 
                echo $this->Html->css('admin/sb-admin');
                echo $this->Html->css('admin/backend');     
                echo $this->Html->css('admin/font/css/font-awesome.min');
                echo $this->Html->css('admin/custom_admin');   
                echo $this->Html->script('jquery.min');
                echo $this->Html->script('admin/bootstrap');
                echo $this->Html->script('jquery-1.7.2.min');
                echo $this->Html->script('jquery.validate');
                echo $this->Html->script('admin/general');
                
            ?>
           
        </head>
        <body>          
            <div id="wrapper" class="wrapper">
              
                <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">        
                    <div class="navbar-header">        
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                         <div class="logoimg"> <?php echo $this->Html->image($logoimage);?></div> 
                            <?php echo $this->Html->link($logoLink,'/admin',array('class' => 'navbar-brand logotxt','title' => $logoLink));?>
                    </div>
                    <?php echo $this->element('admin/navigation'); ?>
                </nav>
                <div id="page-wrapper">
                    <!-- Bread Crumb -->
                    <div class="row">
                        <div class="col-lg-12">            
                            <ol class="breadcrumb">
                                <?php     $shrLowerFlag =0;                            
                                $breadcrumbArray =  explode('/',$breadcrumb ); 
                                $breadcrumbArray1 = $breadcrumbArray;
                                //THis code finds a values in array and replaces it with other(Here items is being replaced with products)
                                if($this->params['controller'] == "items"){
                                    $breadcrumbArray1 = array_replace($breadcrumbArray,
                                        array_fill_keys(
                                            array_keys($breadcrumbArray, "Items"),"Products"
                                        )
                                    );
                                }
                                if($this->params['controller'] == "staticpages"){
                                    $breadcrumbArray1 = array_replace($breadcrumbArray,
                                        array_fill_keys(
                                            array_keys($breadcrumbArray, "Staticpages"),"Contents"
                                        )
                                    );
                                }
                                if($this->params['controller'] == "subscriptions"){
                                    $breadcrumbArray1 = array_replace($breadcrumbArray,
                                        array_fill_keys(
                                            array_keys($breadcrumbArray, "Subscriptions"),"Subscription Plans"
                                        )
                                    );
                                }
                                if($this->params['controller'] == "emailtemplates"){
                                    $breadcrumbArray1 = array_replace($breadcrumbArray,
                                        array_fill_keys(
                                            array_keys($breadcrumbArray, "emailtemplates"),"Email Templates"
                                        )
                                    );
                                }
                                if($this->params['controller'] == "faqs"){
                                    $breadcrumbArray1 = array_replace($breadcrumbArray,
                                        array_fill_keys(
                                            array_keys($breadcrumbArray, "Faqs"),"FAQs"
                                        )
                                    );
                                }
                                if($this->params['controller'] == "admins" && ($this->params['action'] =="admin_newsletters" || $this->params['action'] =="admin_add_newsletter" || $this->params['action'] =="admin_send_newsletter")){
                                    
                                    $breadcrumbArray = array_replace($breadcrumbArray,
                                        array_fill_keys(
                                            array_keys($breadcrumbArray, "Newsletters"),"admins/newsletters"
                                        )
                                    );
                                }
                                
                                if($this->params['controller'] == "admins" && ($this->params['action'] =="admin_add_template")){
                                    
                                    $breadcrumbArray = array_replace($breadcrumbArray,
                                        array_fill_keys(
                                            array_keys($breadcrumbArray, "Newsletters"),"admins/newsletters"
                                        )
                                    );
                                    $breadcrumbArray = array_replace($breadcrumbArray,
                                        array_fill_keys(
                                            array_keys($breadcrumbArray, "Newsletter Templates"),"admins/newsletterTemplate"
                                        )
                                    );
                                }
                                if($this->params['controller'] == "admins" && ($this->params['action'] =="admin_settings")){
                                    
                                    $breadcrumbArray = array_replace($breadcrumbArray,
                                        array_fill_keys(
                                            array_keys($breadcrumbArray, "Settings"),"admins/settings"
                                        )
                                    );
                                   
                                }
                                if($this->params['controller'] == "admins" && ($this->params['action'] =="admin_addRole" || $this->params['action'] =="admin_listRoles" ||  $this->params['action'] =="admin_permissions")){
                                    
                                    $breadcrumbArray = array_replace($breadcrumbArray,
                                        array_fill_keys(
                                            array_keys($breadcrumbArray, "Roles And Permissions"),"admins/listRoles"
                                        )
                                    );
                                   
                                }
                                 if($this->params['controller'] == "settings" && ($this->params['action'] =="admin_css" )){
                                    
                                    $breadcrumbArray = array_replace($breadcrumbArray,
                                        array_fill_keys(
                                            array_keys($breadcrumbArray, "UI Settings"),"settings/css"
                                        )
                                    );
                                   
                                }
                                for($i = 0 ; $i < count($breadcrumbArray);$i++)
                                {  $shrLowerFlag =1;
                                    if($i == count($breadcrumbArray)-1 )
                                    {
                                       echo "<li class='active'><i class='icon-file-alt'></i>". $breadcrumbArray1[count($breadcrumbArray) -1] ."</li>";
                                    }else{
                                        if( $shrLowerFlag == 1){
                                            echo "<li>".$this->Html->link($breadcrumbArray1[$i],'/admin/'.$breadcrumbArray[$i].'/',array('class' => 'icon-file-alt','title' => $breadcrumbArray[$i] ))."</li>";
                                        }else{
                                             echo "<li>".$this->Html->link($breadcrumbArray1[$i],'/admin/'.strtolower($breadcrumbArray[$i]).'/',array('class' => 'icon-file-alt','title' => $breadcrumbArray[$i] ))."</li>";
                                        }
                                       
                                    }
                                    $shrLowerFlag =0;
                                }
                                ?>
                        </div>
                    <!-- Bread Crumb -->
                    </div>
                    <?php echo $this->fetch('content'); ?>                    
                </div><!-- /#page-wrapper -->
                <div class="push"></div>
            </div><!-- /#wrapper -->
            <?php echo $this->element('admin/footer'); ?>
            <script type="text/javascript">
                jQuery('#flashMessage').delay(5000).fadeOut('slow');
                jQuery('#SearchKeyword').on('blur',function(){
                //function checkSpecialChar(){
                    var keyword=$(this).val();
                 //   var iChars = "!#$%^*()+=-[]\\\';,.{}|\":<>?";
                    var iChars = "';,.{}|<>";
                    var count=keyword.length;
                    for (var i = 0; i < count; i++) {
                
                      if (iChars.indexOf(keyword.charAt(i)) != -1) {
                      alert ("Special Characters are not allowed in search.\nPlease remove them and try again.");
                      return false;
                      }
                
                    }
                
                });

          
            </script>
         </body>
    </html>