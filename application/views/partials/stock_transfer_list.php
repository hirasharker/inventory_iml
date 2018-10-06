
<?php
        if($permission->permission_view!=1){
            redirect('purchase/','refresh');   
        }
 ?>
<div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Purchase records <small></small>
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             purchase entries are listed here..
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Transfer ID</th>
                                            <th>Transferred From</th>
                                            <th>Transferred To</th>
                                            <th>Transfer date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach($stock_transfer_list as $value){?>
                                        <tr class="gradeA">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $value->stock_transfer_id;?></td>
                                            <td>
                                            <?php foreach($warehouse_list as $w_value){ if($w_value->warehouse_id == $value->previous_warehouse_id){?>
                                                <?php echo $w_value->warehouse_name;?>
                                            <?php } }?>
                                            </td>
                                            <td>
                                            <?php foreach($warehouse_list as $w_value){ if($w_value->warehouse_id == $value->current_warehouse_id){?>
                                                <?php echo $w_value->warehouse_name;?>
                                            <?php } }?>
                                            </td>
                                            <td><?php echo $value->stock_transfer_date;?></td>
                                            <td class="center">
                                            <?php if($permission->permission_edit==1){?>
                                            <a href="<?php echo base_url();?>stock_transfer/index/<?php echo $value->stock_transfer_id;?>"> edit </a> | 
                                            <?php }else{?>
                                            <label style="color:#aea4a4; font-weight:normal;">edit</label>|
                                            <?php }?>
                                            <?php if($permission->permission_delete==1){?>
                                            <a data-href="<?php echo base_url();?>stock_transfer/delete_stock_transfer/<?php echo $value->stock_transfer_id;?>" data-toggle="modal" data-target="#confirm-delete"> delete </a>
                                            <?php }else{?>
                                            <label style="color:#aea4a4; font-weight:normal;">delete</label>
                                            <?php }?>
                                            </td>
                                        </tr>
                                        <?php $i++; }?>
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