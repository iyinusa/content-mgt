    <div class="rightside">
        <div class="page-head">
            <h1>Document Category</h1>
            <ol class="breadcrumb">
                <li>You are here:</li>
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Document Category</li>
            </ol>
        </div>

        <div class="content">
            <div class="row">
                <div class="col-xs-4">
                    <?php
						$all_dept = '';
						if(!empty($alldept)){
							foreach($alldept as $dept){
								if(!empty($e_dept_id)){
									if($e_dept_id == $dept->id){
										$g_sel = 'selected="selected"';
									} else {$g_sel = '';}
								} else {$g_sel = '';}
								
								$all_dept .= '<option value="'.$dept->id.'" '.$g_sel.'>'.$dept->name.'</optionn>';	
							}
						}
					?>
					
					<?php echo form_open_multipart('category'); ?>
                        <div class="box">
                            <div class="box-title">
                                <i class="fa fa-upload"></i>
                                <h3>New Category</h3>
                                <div class="pull-right box-toolbar">
                                    <a href="#" class="btn btn-link btn-xs remove-box"><i class="fa fa-times"></i></a>
                                </div>          
                            </div>
                            <div class="box-body">
                                <?php if(!empty($err_msg)){echo $err_msg;} ?>
                                <div class="form-group">
                                    <input type="hidden" name="cat_id" value="<?php if(!empty($e_id)){echo $e_id;} ?>" />
                                    <label>Department</label>
                                    <select name="dept_id" class="form-control">
                                        <option>...Select Department</option>
                                        <?php echo $all_dept; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Category</label>
                                    <input type="text" name="name" placeholder="Category Name" class="form-control" value="<?php if(!empty($e_name)){echo $e_name;} ?>" required="required" />
                                </div>
                            </div>
                            <div class="box-footer clearfix">
                                <button type="submit" name="submit" class="pull-left btn btn-success">Update Record <i class="fa fa-arrow-circle-right"></i></button>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
                
                
                <div class="col-xs-8">
                    <div class="box">
                        <div class="box-title">
                            <i class="fa fa-upload"></i>
                            <h3>Catgory Report</h3>
                            <div class="pull-right box-toolbar">
                                <a href="#" class="btn btn-link btn-xs remove-box"><i class="fa fa-times"></i></a>
                            </div>          
                        </div>
                        <div class="box-body">
                            <?php
								$dir_list = '';
								if(!empty($allup)){
									foreach($allup as $up){
										//get department name
										$dept_name = '';
										$gdept = $this->user->query_rec_single('id', $up->dept_id, 'bz_department');
										if(!empty($gdept)){
											foreach($gdept as $gd){
												$dept_name = $gd->name;
											}
										}
										
										$dir_list .= '
											<tr>
												<td>'.$dept_name.'</td>
												<td>'.$up->name.'</td>
												<td>
													<a href="'.base_url().'category?edit='.$up->id.'" class="btn btn-primary btn"><i class="fa fa-pencil"></i> Edit</a>
													<a href="'.base_url().'category?del='.$up->id.'" class="btn btn-danger btn"><i class="fa fa-times"></i> Delete</a>
												</td>
											</tr>
										';	
									}
								}
							?>	
                            
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>DEPARTMENT</th>
                                        <th>CATEGORY</th>
                                        <th width="150">MANAGE</th>
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