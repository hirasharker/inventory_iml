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
                 Claims are listed here..
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                <label style="color:#F00"><?php if($this->session->userdata('deletion_error')!=NULL){ echo $this->session->userdata('deletion_error') ; $this->session->unset_userdata('deletion_error'); }?></label>
                    <table class="table table-striped table-bordered table-hover" id="datatable-buttons1">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Claim ID</th>
                                <th>Invoice No</th>
                                <th>Buyer Name</th>
                                <th>Part No</th>
                                <th>Item Name</th>
                                <th>Documents</th>
                                <th>Quantity</th>
                                <th>Types of Warranty</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach($warranty_claim_list as $value){?>
                            <tr class="gradeA">
                                <td><?php echo $i;?></td>
                                <td><?php echo $value->warranty_claim_id;?></td>
                                <td><a href="<?php echo base_url().'sales/index/'.$value->sales_id;?>" target="_blank"><?php echo $value->sales_id;?></a></td>
                                <td>
                                <?php 
                                    if($value->customer_type == 2){ 
                                        echo $value->customer_name; 
                                    } elseif ($value->customer_type == 1){
                                        echo $value->dealer_name; 
                                    }
                                ?></td>
                                <td><?php echo $value->part_no; ?></td>
                                <td><?php echo $value->item_name;?></td>
                                <td><a href="<?php echo base_url().'files/'.$value->document_path;?>" target="_blank"><img height="50px" width="50px" 
                                    src="<?php echo base_url().'files/'.$value->document_path;?>"></a></td>
                                <td class="center"><?php echo $value->quantity.' '.$value->unit;?></td>
                                <td class="center">
                                <?php foreach ($wc_type_list as $wt_value) {
                                    if($wt_value->warranty_claim_type_id == $value->warranty_claim_type_id){
                                        echo $wt_value->warranty_claim_type_name;
                                    }    
                                }?></td>
                                <td class="center">
                                <?php if($permission->permission_edit==1){?>
                                <a href="<?php echo base_url();?>warranty_claim/index/<?php echo $value->warranty_claim_id;?>"> edit </a> | 
                                <?php }else{?>
                                <label style="color:#aea4a4; font-weight:normal;">edit</label>|
                                <?php }?>
                                <?php if($permission->permission_delete==1){?>
                                <a data-href="<?php echo base_url();?>warranty_claim/delete_warranty_claim/<?php echo $value->warranty_claim_id;?>" data-toggle="modal" data-target="#confirm-delete"> delete </a>
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