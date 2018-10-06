
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
                                            <th>Purchase Inv. No</th>
                                            <th>Item Name</th>
                                            <th>Purchase Price</th>
                                            <th>Discount</th>
                                            <th>Purchase date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach($purchase_list as $value){?>
                                        <tr class="gradeA">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $value->purchase_id;?></td>
                                            <td><?php echo $value->item_name;?></td>
                                            <td><?php echo $value->total_price;?></td>
                                            <td><?php echo $value->purchase_discount;?>%</td>
                                            <td><?php echo $value->purchase_date;?></td>
                                            <td class="center">
                                            <?php if($permission->permission_edit==1){?>
                                            <a href="<?php echo base_url();?>purchase/index/<?php echo $value->purchase_id;?>"> edit </a> | 
                                            <?php }else{?>
                                            <label style="color:#aea4a4; font-weight:normal;">edit</label>|
                                            <?php }?>
                                            <?php if($permission->permission_delete==1){?>
                                            <a data-href="<?php echo base_url();?>purchase/delete_purchase/<?php echo $value->purchase_id;?>" data-toggle="modal" data-target="#confirm-delete"> delete </a>
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