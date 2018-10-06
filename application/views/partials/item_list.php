<?php
        if($permission->permission_view!=1){
            redirect('item/','refresh');   
        }
 ?>
<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Item Lists <small></small>
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
   
<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                 Items are listed here..
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                <label style="color:#F00"><?php if($this->session->userdata('deletion_error')!=NULL){ echo $this->session->userdata('deletion_error') ; $this->session->unset_userdata('deletion_error'); }?></label>
                    <table class="table table-striped table-bordered table-hover" id="datatable-buttons1">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Item ID</th>
                                <th>Part No</th>
                                <th>Item Name</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th>Flawed Qty</th>
                                <th>Rate</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach($item_list as $value){?>
                            <tr class="gradeA">
                                <td><?php echo $i;?></td>
                                <td><?php echo $value->item_id;?></td>
                                <td><?php echo $value->part_no; ?></td>
                                <td><?php echo $value->item_name;?></td>
                                <td><?php echo $value->unit; ?></td>
                                <td class="center"><?php echo $value->quantity.' '.$value->unit;?></td>
                                <td class="center"><?php echo $value->broken_quantity.' '.$value->unit;?></td>
                                <td class="center"><?php echo $value->item_price;?></td>
                                <td class="center">
                                <?php if($permission->permission_edit==1){?>
                                <a href="<?php echo base_url();?>item/index/<?php echo $value->item_id;?>"> edit </a> | 
                                <?php }else{?>
                                <label style="color:#aea4a4; font-weight:normal;">edit</label>|
                                <?php }?>
                                <?php if($permission->permission_delete==1){?>
                                <a data-href="<?php echo base_url();?>item/delete_item/<?php echo $value->item_id;?>" data-toggle="modal" data-target="#confirm-delete"> delete </a>
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

<script type="text/javascript">
     $(document).ready( function () {
       
    });
</script>