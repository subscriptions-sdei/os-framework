<div class="collapse navbar-collapse navbar-ex1-collapse">    
    <ul class="nav navbar-nav side-nav">
        
        <?php  $links = $this -> requestAction(array('controller' => 'admins','action' => 'getAllLinks'));   ?>
        <?php //pr($this->params); ?>
        <?php foreach($links as $linkData){ /*echo $this->params['controller'].'--'.$this->params['action'];
        echo $linkData['Controller'].'||||||'.$linkData['Action'];*/
                if(($linkData['Controller'] == $this->params['controller']) && ($linkData['Action'] == $this->params['action'])){
                    $activeStatus ="active";
                }else{
                    $activeStatus =""; 
                }
                $action =str_replace("admin_","",$linkData['Action']);
                $name =str_replace("Manage","",$linkData['Name']);
        ?>
        <li class= "<?php echo $activeStatus; ?>">
        <?php echo $this->Html->link($this->Html->image("admin/table.png").' '.$name,array('controller'=> $linkData['Controller'],'action'=>$action),array('escape' =>false,$linkData['Name']));?>        
        </li>
        <?php } ?>
        <li <?php echo $activeStatus = isset($navreports) ? $navreports : '';?>>
        <?php echo $this->Html->link($this->Html->image("admin/table.png", array("alt" => "Create Webservices","title" => "Create Webservices")).'  Create Webservices','/SB',array('escape' =>false,'title' => 'Create Webservices'));?>        
        </li>
        <li <?php echo $activeStatus = isset($navreports) ? $navreports : '';?>>
        <?php echo $this->Html->link($this->Html->image("admin/table.png", array("alt" => "Send Message","title" => "Send Message")).'  Send Message','/admin/admins/sendMessage',array('escape' =>false,'title' => 'Send Message'));?>        
        </li>
      <!--  <li <?php echo $activeStatus = isset($navdashboard) ? $navdashboard : '';?>>        
        <?php echo $this->Html->link($this->Html->image("admin/Dashboard.png", array("alt" => "Dashboard","title" => "Dashboard")).'  Dashboard','/admin/admins/dashboard/',array('escape' =>false,'title' => 'Dashboard'));?></li>-->
        
      <!--  <li <?php echo $activeStatus = isset($navadmins) ? $navadmins : '';?>>
        <?php echo $this->Html->link($this->Html->image("admin/table.png", array("alt" => "Admins","title" => "Admins")).'  Admins','/admin/admins/',array('escape' =>false,'title' => 'Admins'));?>        
        </li>-->
        
        <!--<li <?php echo $activeStatus = isset($navusers) ? $navusers : '';?>>
        <?php echo $this->Html->link($this->Html->image("admin/table.png", array("alt" => "Users","title" => "Users")).'  Users','/admin/users/',array('escape' =>false,'title' => 'Users'));?>        
        </li>       
        <li <?php echo $activeStatus = isset($navcategory) ? $navcategory : '';?>>
        <?php echo $this->Html->link($this->Html->image("admin/table.png", array("alt" => "Categories","title" => "Categories")).'  Categories','/admin/categories/',array('escape' =>false,'title' => 'Categories'));?>        
        </li>
        <li <?php echo $activeStatus = isset($navitems) ? $navitems : '';?>>
        <?php echo $this->Html->link($this->Html->image("admin/table.png", array("alt" => "Products","title" => "Products")).'  Products','/admin/items/',array('escape' =>false,'title' => 'Products'));?>        
        </li>
        
        <li <?php echo $activeStatus = isset($navfaqs) ? $navfaqs : '';?>>
        <?php echo $this->Html->link($this->Html->image("admin/table.png", array("alt" => "Faqs","title" => "Faqs")).'  FAQs','/admin/faqs/',array('escape' =>false,'title' => 'Faqs'));?>        
        </li>
        
        <li <?php echo $activeStatus = isset($navstaticpages) ? $navstaticpages : '';?>>
        <?php echo $this->Html->link($this->Html->image("admin/table.png", array("alt" => "Contents","title" => "Contents")).'  Contents','/admin/staticpages/',array('escape' =>false,'title' => 'Contents'));?>        
        </li>        
        <li <?php echo $activeStatus = isset($navemailtemplate) ? $navemailtemplate : '';?>>
        <?php echo $this->Html->link($this->Html->image("admin/table.png", array("alt" => "Emailtemplate","title" => "Emailtemplate")).'  Email templates','/admin/emailtemplates/',array('escape' =>false,'title' => 'Emailtemplate'));?>        
        </li>
        <li <?php echo $activeStatus = isset($navNewsletter) ? $navNewsletter : '';?>>
        <?php echo $this->Html->link($this->Html->image("admin/table.png", array("alt" => "Newsletters","title" => "Newsletters")).'  Newsletters','/admin/admins/newsletters',array('escape' =>false,'title' => 'Newsletters'));?>        
        </li>
        <li <?php echo $activeStatus = isset($subscriptions) ? $subscriptions : '';?>>
        <?php echo $this->Html->link($this->Html->image("admin/table.png", array("alt" => "Subscription Plans","title" => "Subscription Plans")).'  Subscription Plans','/admin/subscriptions',array('escape' =>false,'title' => 'Subscription Plans'));?>        
        </li>
        <li <?php echo $activeStatus = isset($navNewsletter) ? $navNewsletter : '';?>>
        <?php echo $this->Html->link($this->Html->image("admin/table.png", array("alt" => "Orders","title" => "Orders")).'  Orders','/admin/admins/newsletters',array('escape' =>false,'title' => 'Orders'));?>        
        </li>
        <li <?php echo $activeStatus = isset($navNewsletter) ? $navNewsletter : '';?>>
        <?php echo $this->Html->link($this->Html->image("admin/table.png", array("alt" => "Roles and Permissions","title" => "Roles and Permissions")).'  Roles and Permissions','/admin/admins/index',array('escape' =>false,'title' => 'Roles and Permissions'));?>        
        </li>
        <li <?php echo $activeStatus = isset($navNewsletter) ? $navNewsletter : '';?>>
        <?php echo $this->Html->link($this->Html->image("admin/table.png", array("alt" => "Payment Gateway","title" => "Payment Gateway")).'  Roles and Permissions','/admin/admins/newsletters',array('escape' =>false,'title' => 'Payment Gateway'));?>        
        </li>
       <!-- <li <?php echo $activeStatus = isset($navreports) ? $navreports : '';?>>
        <?php echo $this->Html->link($this->Html->image("admin/table.png", array("alt" => "Reports","title" => "Reports")).'  Reports','/admin/reports',array('escape' =>false,'title' => 'Reports'));?>        
        </li>-->
        
        
    </ul>
    <ul class="nav navbar-nav navbar-right navbar-user">        
      <li class="dropdown user-dropdown"><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $loggedUserInfo['first_name'].' '.$loggedUserInfo['last_name'];?> <b class="caret"></b></a>              
        <ul class="dropdown-menu">
            
            <li>
            
            <?php echo $this->Html->link($this->Html->image("admin/user.png", array("alt" => "Profile","title" => "Profile")).'  Profile','/admin/admins/addedit/me',array('escape' =>false,'title' => 'Profile'));?>  
            
            </li>
            <li>
            
             <?php echo $this->Html->link($this->Html->image("admin/change-password.png", array("alt" => "Change Password","title" => "Change Password")).'  Change Password','/admin/admins/changepassword/',array('escape' =>false,'title' => 'Change Password'));?>
             
             
           </li>
            
            
            
            <li class="divider"></li>
            <li>
            
            <?php echo $this->Html->link($this->Html->image("admin/sign-out.png", array("alt" => "Logout","title" => "Logout")).'  Logout','/admin/admins/logout/',array('escape' =>false,'title' => 'Logout'));?>  
            </li>                
        </ul>
      </li>
    </ul>
</div><!-- /.navbar-collapse -->