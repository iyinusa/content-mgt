    <div class="rightside">
        <div class="page-head">
            <h1>Document</h1>
            <ol class="breadcrumb">
                <li>You are here:</li>
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Document</li>
            </ol>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-lg-12">
                	<?php if(!empty($err_msg)){echo $err_msg;} ?>
					<?php if($protected == TRUE){ ?>
                    	<?php echo form_open_multipart('documents/view?id='.$id); ?>
                        	<div class="form-group">
                                <label>Password To Unlock</label>
                                <input type="text" name="password" placeholder="Document Password" class="form-control" required="required" />
                            </div>
                            <div class="box-footer clearfix">
                                <button type="submit" name="submit" class="pull-left btn btn-success">Verify <i class="fa fa-key"></i></button>
                            </div>
                        <?php echo form_close(); ?>
                    <?php } else { ?>
                    	<?php echo form_open_multipart('documents/view?id='.$id); ?>
                        <div class="col-lg-12">
                        	<div class="col-lg-6">
                            	<h1><?php echo $name; ?></h1>
                                <h3 class="text-muted"><?php echo $details; ?></h3>
                                <?php echo number_format($size/1024,2).'KB'; ?> | <?php echo strtoupper($type); ?><br /><br />
                                <a href="<?php echo base_url('uploads/'.$path); ?>" target="_blank" class="btn btn-success">DOWNLOAD DOCUMENT <i class="fa fa-download"></i></a>
                            </div>
                            
                            <?php if($this->session->userdata('itc_user_centre') == $dept_id || $role == 'Admin'){ ?>
                            <div class="col-lg-6 bg-info">
                            	<h1>Share Document</h1>
                                <?php
									$all_cat = '';
									if(!empty($allcat)){
										foreach($allcat as $cat){
											if(!empty($e_cat_id)){
												if($e_cat_id == $cat->id){
													$g_sel = 'selected="selected"';
												} else {$g_sel = '';}
											} else {$g_sel = '';}
											
											$d_id = 0;
											$d_name = '';
											$adept = $this->user->query_rec_single('id', $cat->dept_id, 'bz_department');
											if(!empty($adept)){
												foreach($adept as $ad){
													$d_id = $ad->id;
													$d_name = $ad->name;
												}
											}
											
											$all_cat .= '<option value="'.$d_id.'" '.$g_sel.'>'.$d_name.' ('.$cat->name.')</optionn>';	
										}
									}
								?>
                                <div class="form-group">
                                    <label>Category</label>
                                    <select name="cat_id" class="form-control">
                                        <option>...Select Category</option>
                                        <?php echo $all_cat; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                	<label>Permisions</label>
                                    <input type="checkbox" name="permission[]" value="r" /> Read 
                                    <input type="checkbox" name="permission[]" value="w" /> Write 
                                    <input type="checkbox" name="permission[]" value="d" /> Delete 
                                </div>
                                <div class="box-footer clearfix">
                                    <button type="submit" name="submit" class="pull-left btn btn-success">Share Now <i class="fa fa-share"></i></button><br /><br />
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        
                        <div class="col-lg-12">&nbsp;</div>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-12">
                                    <div class="col-lg-12 bg-warning">
                                        <h3>Users Online Status</h3>
                                        <?php
                                            $users = $this->user->query_rec('bz_user');
                                            if(!empty($users)){
                                                foreach($users as $us){
                                                    if($us->status == 1){$status = '<small class="label label-success"> </small>';} else {$status = '<small class="label label-danger"> </small>';}
                                                    
                                                    echo '<span class="text-muted">'.$status.'&nbsp;'.$us->firstname.' '.$us->lastname.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>';	
                                                }
                                            }
                                        ?>
                                        <div class="col-lg-12">&nbsp;</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr style="border:1px solid #ddd;" />
                        
                        <h1>Remarks</h1>
                        <hr style="border:1px solid #ddd;" />
                        
                        <div class="col-lg-12">
                        	<?php
								if(!empty($allcom)){
									foreach($allcom as $com){
										//get username
										$username = '';
										$guser = $this->user->query_rec_single('user_id', $com->user_id,'bz_user');
										if(!empty($guser)){
											foreach($guser as $us){
												$username = $us->firstname. ' '. $us->lastname;	
											}
										}
										
										echo '
											<div class="alert alert-info">
												<div class="text-muted">'.$username.'</div><br />
												'.$com->comment.'
											</div>
										';
									}
								}
							?>
                            <div class="form-group">
                                <textarea name="comment" class="form-control"></textarea>
                            </div>
                            
                            <div class="box-footer clearfix">
                                    <button type="submit" name="submit" class="pull-left btn btn-success">Comment <i class="fa fa-comment"></i></button><br /><br />
                             </div>
                        </div>
                        <?php echo form_close(); ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>