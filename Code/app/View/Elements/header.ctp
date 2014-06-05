
<section class="container">
        	<section class="logo">
              <?php echo $this->Html->link($this->Html->image("frontend/logo.png", array("alt" => "Ritzy","title" => "Ritzy")),array('controller'=>'homes','action'=>'index'),array('escape' =>false));?>
              
              </section>
            <section class="searchspace">
              <?php echo $this->Html->image("frontend/spacer.png", array("width" => "208","height" => "1"));?>
              </section>
            <a href="#" class="menulinks">Menu</a>
            <!--Navigation Start-->
            <nav>
            	<ul class="menu">
                	<li>
						<?php echo $this->Html->link('<span class="menuicon feedicon"></span>Feed',array('controller'=>'feeds','action'=>'index'),array('escape' =>false, 'class' => 'active'));?>
					</li>
                    <li class="dropdown "><a data-toggle="dropdown" class="dropdown-toggle"  href="javascript:void(0);"><span class="menuicon shopicon"></span>Shop</a>
                       <?php echo $this->element('front/sub_menu_top'); ?>
                    </li>
                    <li><?php echo $this->Html->link('<span class="menuicon sellicon"></span>Sell',array('controller'=>'items','action'=>'my_items'),array('escape'=>false)); ?></li>
                    <li><a href="#"><span class="menuicon newsicon"></span>News</a></li>
                </ul>
            </nav>
            <!--Navigation Closed-->
            
            <section class="headerright dropdown pull-right">
            	<a data-toggle="dropdown" class="username dropdown-toggle" href="#"><span class="userpic">
                <?php $sessionData = $this->Session->read('UserInfo'); if($sessionData) { 
                  echo $this->Html->image($this->Common->getUserPicThumb($sessionData['image'],"thumb_small"), array("alt" => "user_pic","title" => "user_pic",'class' => 'roundpic','style'=>'width:30px;'));
                ?> 
                
                </span><?php echo $sessionData['username']; ?></a>
                <?php } ?>
                <ul class="dropdown-menu">
                	<!--<li><a href="#"><span>My Closet</span></a></li>
                    <li><a href="#"><span>My Likes</span></a></li>
                    <li class="divider"></li>
                    <li><a href="#"><span>Orders</span></a></li>
                    <li><a href="#"><span>Settings</span></a></li>-->
                    <li>
                     
                     <?php if($sessionData) {                                   
                                   echo $this->Html->link('<span>My Closet</span>',"/closets/index/".$this->Common->stringConvertSpaceToUscore($sessionData['username']),array('escape' =>false));
																	 echo $this->Html->link('<span>My Likes</span>',"/closets/myLikes/",array('escape' =>false));
                                   echo $this->Html->link('<span>My Followers</span>',"/closets/followers/",array('escape' =>false));
                                   echo $this->Html->link('<span>My Followings</span>',"/closets/followings/",array('escape' =>false));
																	 
																	 echo $this->Html->link('<span>Settings</span>',"/users/edit_profile/",array('escape' =>false));
                                   
																	 
								   echo $this->Html->link('<span>Logout</span>',"/users/logout/",array('escape' =>false));
                            }else{ echo $this->Html->link('<span>Login</span>',"/users/login/",array('escape' =>false)); }?>
                     
                    </li>
                    <li class="divider"></li>
                    <li><?php echo $this->Html->link('<span>About</span>','/about',array('title' => 'About us','escape'=>false));?></li>
                   <li> <?php echo $this->Html->link('<span>FAQs</span>','/faqs',array('title' => 'FAQs','escape'=>false));?></li>
                   <li> <?php echo $this->Html->link('<span>Contact</span>','/contact',array('title' => 'contact','escape'=>false));?></li>
                   <li><?php echo $this->Html->link('<span>Terms</span>','/terms',array('title' => 'Terms','escape'=>false));?></li>
                   
                    <li><?php echo $this->Html->link('<span>Blog</span>','/blog',array('title' => 'Blog','escape'=>false,'target'=>'_blank'));?></li>
               </ul>
            </section>
			
			
			<?php echo $this->Form->create('Search', array('url' => array('controller' => 'search', 'action' => 'index'),'id'=>'SearchPageId','type' => 'get')); ?>
        		<!--<input type="text" name="textfield"  onfocus="if (this.value == 'Search') {this.value=''}" onblur="if(this.value == '') { this.value='Search'}" value="Search" />-->
            <section class="searchwidget">
					 <?php
					 echo $this->Form->input('query',array('escape' => false ,'value' => $search = (isset($searchValue) && !empty($searchValue)) ? $searchValue : 'Search', 'label' => false,'div' => false, 'class' => 'searchtextfield fullwidth','maxlength' => 30,'id' => 'topSearchDivId'));
					 ?>	

            
			
			
			<?php echo $this->Form->button('Submit', array('type' => 'submit','class' => 'searchbutton', 'onclick' => 'javascript: return submitSearchForm();'));?>
			
            </section>
			
			<?php echo $this->Form->end(); ?>
            
        </section>

		

 
