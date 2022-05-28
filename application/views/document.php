    <div class="rightside">
        <div class="page-head">
            <h1>Documents</h1>
            <ol class="breadcrumb">
                <li>You are here:</li>
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Documents</li>
            </ol>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-xs-12">
                    <?php
						$all_cat = '';
						if(!empty($allcat)){
							foreach($allcat as $cat){
								if(!empty($e_cat_id)){
									if($e_cat_id == $cat->id){
										$g_sel = 'selected="selected"';
									} else {$g_sel = '';}
								} else {$g_sel = '';}
								
								$d_name = '';
								$adept = $this->user->query_rec_single('id', $cat->dept_id, 'bz_department');
								if(!empty($adept)){
									foreach($adept as $ad){
										$d_name = $ad->name;
									}
								}
								
								$all_cat .= '<option value="'.$cat->id.'" '.$g_sel.'>'.$d_name.' ('.$cat->name.')</optionn>';	
							}
						}
					?>
					
					<?php echo form_open_multipart('documents'); ?>
                        <div class="box">
                            <div class="box-title">
                                <i class="fa fa-upload"></i>
                                <h3>New Document</h3>
                                <div class="pull-right box-toolbar">
                                    <a href="#" class="btn btn-link btn-xs remove-box"><i class="fa fa-times"></i></a>
                                </div>          
                            </div>
                            <div class="box-body">
                                <?php if(!empty($err_msg)){echo $err_msg;} ?>
                                <div class="form-group">
                                    <input type="hidden" name="doc_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
                                    <label>Category</label>
                                    <select name="cat_id" class="form-control">
                                        <option>...Select Category</option>
                                        <?php echo $all_cat; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Document Name</label>
                                    <input type="text" name="name" placeholder="Document Name" class="form-control" value="<?php if(!empty($e_name)){echo $e_name;} ?>" required="required" />
                                </div>
                                <div class="form-group">
                                    <label>Details</label>
                                    <textarea name="details" class="form-control"><?php if(!empty($e_details)){echo $e_details;} ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Document</label>
									<?php if(!empty($e_path)){ ?>
                                    
                                    <?php } ?>
                                    <input type="file" name="doc" placeholder="Upload Document" class="form-control" />
                                    <input type="hidden" name="doc_path" value="<?php if(!empty($e_path)){echo $e_path;} ?>" />
                                    <input type="hidden" name="doc_size" value="<?php if(!empty($e_size)){echo $e_size;} ?>" />
                                    <input type="hidden" name="doc_type" value="<?php if(!empty($e_type)){echo $e_type;} ?>" />
                                </div>
                                <div class="form-group">
                                    <label>Password Document</label>
                                    <input type="text" name="item" placeholder="Do not want to protect? Leave empty" class="form-control" value="<?php if(!empty($e_item)){echo $e_item;} ?>" />
                                </div>
                            </div>
                            <div class="box-footer clearfix">
                                <button type="submit" name="submit" class="pull-left btn btn-success">Update Record <i class="fa fa-arrow-circle-right"></i></button>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
                
                
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-title">
                            <i class="fa fa-upload"></i>
                            <h3>Document Report</h3>
                            <div class="pull-right box-toolbar">
                                <a href="#" class="btn btn-link btn-xs remove-box"><i class="fa fa-times"></i></a>
                            </div>          
                        </div>
                        <div class="box-body">
                            <?php
								$dir_list = '';
								if(!empty($allup)){
									foreach($allup as $up){
										//get category and department name
										$cat_name = '';
										$dept_name = '';
										$gcat = $this->user->query_rec_single('id', $up->cat_id, 'bz_category');
										if(!empty($gcat)){
											foreach($gcat as $gc){
												$cat_name = $gc->name;
												
												$gdept = $this->user->query_rec_single('id', $gc->dept_id, 'bz_department');
												if(!empty($gdept)){
													foreach($gdept as $gd){
														$dept_name = $gd->name;
													}
												}
											}
										}
										
										$list = '
											<tr>
												<td>'.$up->name.'</td>
												<td>'.$cat_name.', <b>'.$dept_name.'</b></td>
												<td><span class="label label-success">'.strtoupper($up->type).'</span></td>
												<td>'.number_format(($up->size/1024),2).'KB</td>
												<td>
													<a href="'.base_url().'documents?edit='.$up->id.'" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit Document"><i class="fa fa-pencil"></i></a>
													<a href="'.base_url().'documents/view?id='.$up->id.'" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" title="View Document"><i class="fa fa-eye"></i></a>
													<a href="'.base_url().'documents?del='.$up->id.'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="Delete Document"><i class="fa fa-times"></i></a>
												</td>
											</tr>
										';
										
										if($role == 'Admin'){
											$dir_list .= $list;
										} else {
											//get department ID from Cat ID
											$get_dept_id = '';
											$getdept = $this->user->query_rec_single('id', $up->cat_id, 'bz_category');
											if(!empty($getdept)){
												foreach($getdept as $gd){
													$get_dept_id = $gd->dept_id;	
												}
											}
											
											if($dept_id == $get_dept_id){
												$dir_list .= $list;
											}
										}
										
										$list = '';		
									}
								}
							?>	
                            
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>DOCUMENT</th>
                                        <th>DEPARTMENT</th>
                                        <th>FORMAT</th>
                                        <th>SIZE</th>
                                        <th width="130">MANAGE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php echo $dir_list; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>