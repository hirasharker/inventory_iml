<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            User List<small></small>
        </h1>
    </div>
</div> 
         <!-- /. ROW  -->
       
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     This report is only available for Administrators!
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>User Name</th>
                                    <th>Email Id</th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($this->session->userdata('user_id')==2){?>
                                <?php $i=1; foreach($result as $value){?>
                                <tr class="even gradeA">
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $value->user_name; ?></td>
                                    <td><?php echo $value->email_address; ?></td>
                                    <td class="center"><?php if($value->user_type==1){echo "Administrator";}else if($value->user_type==2){echo "Standard user";}else{echo "Guest";}; ?></td>
                                    <!-- <td class="center"><a href="<?php echo base_url();?>user/index/<?php echo $value->user_id; ?>"> edit </a> | <a data-href="<?php echo base_url();?>user/delete_user/<?php echo $value->user_id;?>" data-toggle="modal" data-target="#confirm-delete"> delete </a> |<a href="<?php echo base_url();?>user/permission/<?php echo $value->user_id; ?>"> permission </a></td> -->
                                    <td class="center"><a href="<?php echo base_url();?>user/index/<?php echo $value->user_id; ?>"> edit </a> | <a href="<?php echo base_url();?>user/permission/<?php echo $value->user_id; ?>"> permission </a></td>
                                </tr>
                                <?php $i++;}?>
                                <?php }else{ $i=1; foreach($result as $value){ if($value->user_id!=2){?>
                                <tr class="even gradeA">
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $value->user_name; ?></td>
                                    <td><?php echo $value->email_address; ?></td>
                                    <td class="center"><?php if($value->user_type==1){echo "Administrator";}else if($value->user_type==2){echo "Standard user";}else{echo "Guest";}; ?></td>
                                    <!-- <td class="center"><a href="<?php echo base_url();?>user/index/<?php echo $value->user_id; ?>"> edit </a> | <a data-href="<?php echo base_url();?>user/delete_user/<?php echo $value->user_id;?>" data-toggle="modal" data-target="#confirm-delete"> delete </a> |<a href="<?php echo base_url();?>user/permission/<?php echo $value->user_id; ?>"> permission </a></td> -->
                                    <td class="center"><a href="<?php echo base_url();?>user/index/<?php echo $value->user_id; ?>"> edit </a> | <a href="<?php echo base_url();?>user/permission/<?php echo $value->user_id; ?>"> permission </a></td>
                                </tr>
                                <?php } $i++;}?>
                                <?php }?>
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