<?php
        if($permission->permission_view!=1){
            redirect('warehouse/','refresh');   
        }
 ?>

<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Warehouse Lists <small></small>
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                 warehouses are listed here..
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <label style="color:#F00"><?php if($this->session->userdata('deletion_error')!=NULL){ echo $this->session->userdata('deletion_error') ; $this->session->unset_userdata('deletion_error'); }?></label>
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Warehouse Name</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach($warehouse_list as $value){?>
                            <tr class="gradeA">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $value->warehouse_name; ?></td>
                                <td><?php echo $value->warehouse_location; ?></td>
                                <td class="center">
                                <?php if($permission->permission_edit==1){?>
                                <a href="<?php echo base_url();?>warehouse/index/<?php echo $value->warehouse_id;?>"> edit </a> | 
                                <?php }else{?>
                                <label style="color:#aea4a4; font-weight:normal;">edit</label>|
                                <?php }?>
                                <?php if($permission->permission_delete==1){?>
                                <a data-href="<?php echo base_url();?>warehouse/delete_warehouse/<?php echo $value->warehouse_id;?>" data-toggle="modal" data-target="#confirm-delete"> delete </a></td>
                                <?php }else{?>
                                <label style="color:#aea4a4; font-weight:normal;">delete</label>
                                <?php }?>
                            </tr>
                            <?php $i++;} ?>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        <!--End Advanced Tables -->
    </div>
</div>