<?php
        if($permission->permission_view!=1){
            redirect('payment/','refresh');   
        }
 ?>
<div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Payment records <small></small>
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Payment entries are listed here..
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Payment Id</th>
                                            <th>Creditor's Name</th>
                                            <th>Paid Amount</th>
                                            <th>payment date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach($payment_list as $value){?>
                                        <tr class="gradeA">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $value->payment_id;?></td>
                                            <td><?php echo $value->vendor_name;?></td>
                                            <td class="center"><?php echo $value->paid_amount;?></td>
                                            <td><?php echo $value->payment_date;?></td>
                                            <td class="center">
                                            <?php if($permission->permission_edit==1){?>
                                            <a href="<?php echo base_url();?>payment/index/<?php echo $value->payment_id;?>"> edit </a> | 
                                            <?php }else{?>
                                            <label style="color:#aea4a4; font-weight:normal;">edit</label>|
                                            <?php }?>
                                            <?php if($permission->permission_delete==1){?>
                                            <a data-href="<?php echo base_url();?>payment/delete_payment/<?php echo $value->payment_id;?>" data-toggle="modal" data-target="#confirm-delete"> delete </a>
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