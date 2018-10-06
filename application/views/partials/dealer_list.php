<?php
        if($permission->permission_view!=1){
            redirect('dealer/','refresh');   
        }
 ?>

<div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Dealer's List <small></small>
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Dealers are listed here..
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="datatable-buttons1">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Dealer Code</th>
                                            <th>Dealer Name</th>
                                            <th>Dealer Category</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach($dealer_list as $value){?>
                                        <tr class="gradeA">
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $value->dealer_id;?></td>
                                            <td><?php echo $value->dealer_name;?></td>
                                            <td><?php echo $value->dealer_category;?></td>
                                            <td><?php echo $value->present_address;?></td>
                                            <td class="center"><?php echo $value->phone_no;?></td>
                                            <td class="center">
                                            <?php if($permission->permission_edit==1){?>
                                            <a href="<?php echo base_url();?>dealer/index/<?php echo $value->dealer_id;?>"> edit </a> | 
                                            <?php }else{?>
                                            <label style="color:#aea4a4; font-weight:normal;">edit</label>|
                                            <?php }?>
                                            <?php if($permission->permission_delete==1){?>
                                            <a data-href="<?php echo base_url();?>dealer/delete_dealer/<?php echo $value->dealer_id;?>" data-toggle="modal" data-target="#confirm-delete"> delete </a></td>
                                            <?php }else{?>
                                            <label style="color:#aea4a4; font-weight:normal;">delete</label>
                                            <?php }?>
                                        </tr>
                                        <?php $i++;}?>
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
                <!-- /. ROW  -->
        </div>