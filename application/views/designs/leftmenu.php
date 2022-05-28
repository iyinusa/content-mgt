<?php
	if($page_act == 'setup'){$setup_active = 'active';}else{$setup_active = '';}
	if($page_act == 'profile'){$profile_active = 'active';}else{$profile_active = '';}
	if($page_act == 'document'){$document_active = 'active';}else{$document_active = '';}
	if($page_act == 'share'){$share_active = 'active';}else{$share_active = '';}
?>

<!-- wrapper -->
<div class="wrapper">
    <div class="leftside">
        <div class="sidebar">
            <ul class="sidebar-menu">
                <li class="title">Navigation</li>
                
                <li class="<?php echo $setup_active; ?> sub-nav">
                    <a href="javascript:;">
                        <i class="fa fa-home"></i> <span>Setup</span>
                    </a>
                    <ul class="sub-menu">
                    	<?php if($this->session->userdata('itc_user_role') == 'Admin'){ ?>
                        <li><a href="<?php echo base_url(); ?>departments">Departments</a></li>
                        <?php } ?>
                        <li><a href="<?php echo base_url(); ?>category">Document Category</a></li>
                    </ul>
                </li>
                
                <!--<li class="<?php echo $profile_active; ?>">
                    <a href="<?php echo base_url(); ?>profile">
                        <i class="fa fa-user"></i> <span>My Profile</span>
                    </a>
                </li>-->
                <li class="<?php echo $document_active; ?>">
                    <a href="<?php echo base_url(); ?>documents">
                        <i class="fa fa-file"></i> <span>Documents</span>
                    </a>
                </li>
                <li class="<?php echo $share_active; ?>">
                    <a href="<?php echo base_url(); ?>share">
                        <i class="fa fa-share"></i> <span>Share Documents</span>
                    </a>
                </li>
            </ul>
         </div>
    </div>