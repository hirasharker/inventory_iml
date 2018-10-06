<?php
        if($permission->permission_view!=1){
            redirect('sales/money_receipt/','refresh');   
        }
 ?>
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Money Receipt records <small></small>
        </h1>
    </div>
</div> 
 <!-- /. ROW  -->
   
<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                 Money Receipt entries are listed here..
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Receipt Id</th>
                                <th>Invoice No</th>
                                <th>Debtor's Name</th>
                                <th>Received Amount</th>
                                <th>Received date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; foreach($money_receipt_list as $value){?>
                            <tr class="gradeA">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $value->money_receipt_id;?></td>
                                <td><?php echo $value->sales_id;?></td>
                                <td><?php if($value->customer_name!=NULL){echo $value->customer_name;}else{ echo $value->dealer_name;} ?></td>
                                <td class="center"><?php echo $value->received_amount;?></td>
                                <td><?php echo $value->money_receipt_date;?></td>
                                <td class="center">
                                <?php if($permission->permission_edit==1){?>
                                <a href="<?php echo base_url();?>money_receipt/index/<?php echo $value->money_receipt_id;?>"> edit </a> | 
                                <?php }else{?>
                                <label style="color:#aea4a4; font-weight:normal;">edit</label>|
                                <?php }?>
                                <?php if($permission->permission_delete==1){?>
                                <a data-href="<?php echo base_url();?>money_receipt/delete_money_receipt/<?php echo $value->money_receipt_id;?>" data-toggle="modal" data-target="#confirm-delete"> delete </a>
                                <?php }else{?>
                                <label style="color:#aea4a4; font-weight:normal;">delete</label>
                                <?php }?>
                                <form method="post" action="<?php echo base_url();?>money_receipt/print_money_receipt/" target="_blank" style="float: left;">
                                <input type="hidden" name="money_receipt_id" value="<?php echo $value->money_receipt_id; ?>" />
                                <?php if($permission->permission_view==1){?>
                                <a class="print-money-receipt" href="#"><i class="fa fa-print"></i> </a> | 
                                <?php }else{?>
                                <label style="color:#aea4a4; font-weight:normal;">print</label>
                                <?php }?>
                                </form>
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
<script type="text/javascript">
    $(document).ready( function () {
       
    });

    $( ".print-money-receipt" ).click(function( event ) {
      var form = $(this).parent('form:first');
      form.submit();
    });

</script>