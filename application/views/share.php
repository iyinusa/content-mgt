    <div class="rightside">
        <div class="page-head">
            <h1>Share Documents</h1>
            <ol class="breadcrumb">
                <li>You are here:</li>
                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                <li class="active">Share Documents</li>
            </ol>
        </div>

        <div class="content">
            <div class="row">
               <div class="col-xs-12">
                    <div class="box">
                        <div class="box-title">
                            <i class="fa fa-upload"></i>
                            <h3>Share Documents</h3>
                            <div class="pull-right box-toolbar">
                                <a href="#" class="btn btn-link btn-xs remove-box"><i class="fa fa-times"></i></a>
                            </div>          
                        </div>
                        <div class="box-body">
                            <?php
								$dir_list = '';
								if(!empty($allup)){
									foreach($allup as $up){
										//get shared document details
										$doc_id = $up->doc_id;
										$from_dept = $up->from_dept;
										$rights = $up->rights;
										
										//get permissions
										$p_read = '';
										$p_write = '';
										$p_delete = '';
										$token = explode('|', $rights);
										$token_count = count($token);
										for($i=0; $i<$token_count-1; $i++){
											if($i==0){$p_read = $token[0];}
											if($i==1){$p_write = $token[1];}
											if($i==2){$p_delete = $token[2];}
										}
										
										//get category and department name
										$cat_id = '';
										$cat_name = '';
										$dept_name = '';
										$doc_name = '';
										$doc_size = '';
										$doc_type = '';
										$gdoc = $this->user->query_rec_single('id', $doc_id, 'bz_document');
										if(!empty($gdoc)){
											foreach($gdoc as $gdoc){
												$cat_id = $gdoc->cat_id;
												$doc_name = $gdoc->name;
												$doc_size = $gdoc->size;
												$doc_type = $gdoc->type;
											}
										}
										
										$gcat = $this->user->query_rec_single('id', $cat_id, 'bz_category');
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
										
										if($p_read == 'r' || $role == 'Admin'){$read = '<a href="'.base_url().'documents/view?id='.$doc_id.'" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="bottom" title="View Document"><i class="fa fa-eye"></i></a>';} else {$read = '';}
										
										if($p_write == 'w' || $role == 'Admin'){$write = '<a href="'.base_url().'documents?edit='.$doc_id.'" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="bottom" title="Edit Document"><i class="fa fa-pencil"></i></a>';} else {$write = '';}
										
										if($p_delete == 'd' || $role == 'Admin'){$delete = '<a href="'.base_url().'documents?del='.$doc_id.'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="bottom" title="Delete Document"><i class="fa fa-times"></i></a>';} else {$delete = '';}
										
										$dir_list .= '
											<tr>
												<td>'.$doc_name.'</td>
												<td>'.$cat_name.', <b>'.$dept_name.'</b></td>
												<td><span class="label label-success">'.strtoupper($doc_type).'</span></td>
												<td>'.number_format(($doc_size/1024),2).'KB</td>
												<td>
													<span class="label label-default">'.$p_read.'</span>
													<span class="label label-success">'.$p_write.'</span>
													<span class="label label-warning">'.$p_delete.'</span>
												</td>
												<td>
													'.$write.'
													'.$read.'
													'.$delete.'
												</td>
											</tr>
										';	
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
                                        <th>RIGHTS</th>
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