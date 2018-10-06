<?php
        if($permission->permission_allow!=1){
            redirect('dashboard/','refresh');   
        }
 ?>
<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Warranty Claim Approval Section <small></small>
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
   
<div class="row">
    <div class="col-md-12 col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Basic Tabs
            </div>
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#waiting-list" data-toggle="tab">Waiting for Approval</a>
                    </li>
                    <li class=""><a href="#approved-list" data-toggle="tab">Approved</a>
                    </li>
                    <li class=""><a href="#denied-list" data-toggle="tab">Denied</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade active in" id="waiting-list">
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
                                            <?php $i=1; foreach($waiting_list as $value){?>
                                            
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
                                                <?php if($permission->permission_allow==1){?>
                                                <form class="form" method="post" action="<?php echo base_url().'warranty_claim/approve_warranty_claim/';?>">
                                                    <input type="hidden" name="warranty_claim_id" value="<?php echo $value->warranty_claim_id;?>">
                                                    <a href="#" class="approve"> approve </a>
                                                </form>
                                                <?php }else{?>
                                                <label style="color:#aea4a4; font-weight:normal;">approve</label>
                                                <?php }?>
                                                <?php if($permission->permission_allow==1){?>
                                                | <a class="deny" data-id="<?php echo $value->warranty_claim_id;?>" data-href="<?php echo base_url();?>warranty_claim/deny_warranty_claim/<?php echo $value->warranty_claim_id;?>" data-toggle="modal" data-target="#confirm-deny"> deny </a>
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
                    <div class="tab-pane fade" id="approved-list">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Approved Claims are listed here..
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
                                            <?php $i=1; foreach($approved_list as $value){?>
                                            
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
                    <div class="tab-pane fade" id="denied-list">
                        <!-- Advanced Tables -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Denied Claims are listed here..
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
                                                <th>Comment</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i=1; foreach($denied_list as $value){?>
                                            
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
                                                <td><?php
                                                    switch ($value->approval_status) {
                                                        case '-1':
                                                             echo $value->comment_1; 
                                                            break;
                                                         case '-2':
                                                             echo $value->comment_2; 
                                                            break;
                                                         case '-3':
                                                             echo $value->comment_3; 
                                                            break;
                                                        default:
                                                            # code...
                                                            break;
                                                    }
                                                ?></td>
                                                <td class="center">
                                                <?php if($permission->permission_allow==1){?>
                                                <form class="form" method="post" action="<?php echo base_url().'warranty_claim/approve_warranty_claim/';?>">
                                                    <input type="hidden" name="warranty_claim_id" value="<?php echo $value->warranty_claim_id;?>">
                                                    <a href="#" class="approve"> approve </a> | 
                                                </form>
                                                <?php }else{?>
                                                <label style="color:#aea4a4; font-weight:normal;">approve</label>|
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
            </div>
        </div>
    </div>
</div>
    <!-- /. ROW  -->
</div>

<!-- Modal Deny       -->
<div class="modal fade" id="confirm-deny" role="dialog">
  <div class="modal-dialog modal-sm">
  
    <!-- Modal content-->
    <div class="modal-content">
    <form method="post" action="<?php echo base_url();?>warranty_claim/deny_warranty_claim/">
        <input type="hidden" name="warranty_claim_id" id="denied-claim-id" />
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Do you want to deny?</h4>
        </div>
        <div class="modal-body">
            <label>Reason for Denial?</label>
            <textarea name="comment"></textarea>
        </div>
          
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <!-- <a class="btn btn-danger btn-ok" type="submit">Deny</a> -->
            <input class="btn btn-danger" type="submit" value="Deny" />
        </div>
    </form>
    </div>
    
  </div>
</div>
<!-- Modal Deny End -->

<script type="text/javascript">
    $(document).ready( function () {
       
    });

    $( ".approve" ).click(function( event ) {
      var form = $(this).parent('form:first');
      form.submit();
    });

    $(".deny").click(function(){
        var warrantyClaimId     =   $(this).data('id');
        document.getElementById('denied-claim-id').value = warrantyClaimId;
    });


</script>