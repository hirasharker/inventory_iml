<?php if($money_receipt==NULL){?>
<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Add Money Receipt <small>add new money receipt entry</small>
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Insert money receipt Information..
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5">
                        <form role="form" method="post" action="<?php echo base_url();?>money_receipt/add_money_receipt">
                            

                            <div class="form-group">
                                <label>Type of Payment</label>
                                <select class="form-control" name="payment_mode" id="paymentMode">
                                    <option value="2">Select Mode</option>
                                    <option value="0">Advance Against Sales Order</option>
                                    <option value="1">Payment Against Sales Invoice</option>
                                </select>
                            </div>



                            <div class="form-group sales-order-id" style="display:none;">
                                <label>Sales Order No</label>
                                <input type="text" class="form-control" id="salesOrderId" name="sales_order_id" value="<?php echo set_value('sales_order_id'); ?>">
                            </div>

                            <div class="form-group sales-id" style="display:none;">
                                <label>Invoice No</label>
                                <input type="text" class="form-control" id="salesId" name="sales_id" value="<?php echo set_value('sales_id'); ?>">
                            </div>

                            

                            <label>Received Amount</label>

                            <div class="form-group input-group">
                             
                                <span class="input-group-addon">&#x9f3;</span>
                                <input type="text" class="form-control" name="received_amount" value="<?php echo set_value('received_amount'); ?>" required>
                                <span class="input-group-addon">.00</span>
                            </div>
                           
                            <br/>
                            
                           <!--  <div class="form-group">
                                <label>Date</label>
                                <input id="datepicker" class="form-control">
                            </div> -->
                            <label>Receipt Date</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" class="form-control"  id="datepicker" name="money_receipt_date" value="<?php echo set_value('money_receipt_date'); ?>" required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                            <label style="color:#F00;font-size:10px;"><?php echo form_error('money_receipt_date');?></label>
                            <br/>
                            </br>
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </form>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

<script type="text/javascript">
    $( "#paymentMode" ).change(function() {
          // alert( "Handler for .change() called."+this.value);
          var val = $('#paymentMode option:selected').val();
          if(val == 0){
            $( ".sales-order-id" ).show( 500 );
            $( ".sales-id" ).hide( 500 );
            $( "#salesId" ).val("");
          }else if (val == 1){
            $( ".sales-id" ).show( 500 );
            $( ".sales-order-id" ).hide( 500 );
            $( "#salesOrderId" ).val("");
          }else if(val== 2){
            $( ".sales-id" ).hide( 500 );
            $( ".sales-order-id" ).hide( 500 );
            $( "#salesId" ).val("");
            $( "#salesOrderId" ).val("");
          }
    });
</script>
<?php }else{?>
<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Edit Money Receipt <small>edit money receipt</small>
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Change money receipt Information..
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5">
                        <form role="form" method="post" action="<?php echo base_url();?>money_receipt/update_money_receipt">
                            <input type="hidden" name="money_receipt_id" value="<?php echo $money_receipt->money_receipt_id;?>">

                            <div class="form-group">
                                <label>Type of Payment</label>
                                <select class="form-control" name="payment_mode" id="paymentMode">
                                    <option value="2">Select Mode</option>
                                    <option value="0" <?php if($money_receipt->payment_mode == 0){echo "selected";}?>>Advance Against Sales Order</option>
                                    <option value="1" <?php if($money_receipt->payment_mode == 1){echo "selected";}?>>Payment Against Sales Invoice</option>
                                </select>
                            </div>



                            <div class="form-group sales-order-id" style="display:none;">
                                <label>Sales Order No</label>
                                <input type="text" class="form-control" id="salesOrderId" name="sales_order_id" value="<?php echo $money_receipt->sales_order_id; ?>">
                            </div>

                            <div class="form-group sales-id" style="display:none;">
                                <label>Invoice No</label>
                                <input type="text" class="form-control" id="salesId" name="sales_id" value="<?php echo $money_receipt->sales_id; ?>">
                            </div>

                            

                            <label>Received Amount</label>

                            <div class="form-group input-group">
                             
                                <span class="input-group-addon">&#x9f3;</span>
                                <input type="text" class="form-control" name="received_amount" value="<?php echo $money_receipt->received_amount; ?>" required>
                                <span class="input-group-addon">.00</span>
                            </div>
                           
                            <br/>
                            
                           <!--  <div class="form-group">
                                <label>Date</label>
                                <input id="datepicker" class="form-control">
                            </div> -->
                            <label>Receipt Date</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" class="form-control"  id="datepicker" name="money_receipt_date" value="<?php echo $money_receipt->money_receipt_date; ?>" required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                            <label style="color:#F00;font-size:10px;"><?php echo form_error('money_receipt_date');?></label>
                            <br/>
                            </br>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </form>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

<script type="text/javascript">
    <?php if($money_receipt->payment_mode == 0){?>
        $( ".sales-order-id" ).show( 500 );
        $( ".sales-id" ).hide( 500 );
        $( "#salesId" ).val("");
    <?php }?>

    <?php if($money_receipt->payment_mode == 1){?>
        $( ".sales-id" ).show( 500 );
        $( ".sales-order-id" ).hide( 500 );
        $( "#salesOrderId" ).val("");
    <?php }?>

    $( "#paymentMode" ).change(function() {
          // alert( "Handler for .change() called."+this.value);
          var val = $('#paymentMode option:selected').val();
          if(val == 0){
            $( ".sales-order-id" ).show( 500 );
            $( ".sales-id" ).hide( 500 );
            $( "#salesId" ).val("");
          }else if (val == 1){
            $( ".sales-id" ).show( 500 );
            $( ".sales-order-id" ).hide( 500 );
            $( "#salesOrderId" ).val("");
          }else if(val== 2){
            $( ".sales-id" ).hide( 500 );
            $( ".sales-order-id" ).hide( 500 );
            $( "#salesId" ).val("");
            $( "#salesOrderId" ).val("");
          }
    });
</script>
<?php }?>
<script>
    $(function(){
      $("#salesId").autocomplete({
        source: "<?php echo base_url();?>sales/generate_sales_id/"// path to the get_birds method
      });

      $("#salesOrderId").autocomplete({
        source: "<?php echo base_url();?>sales_order/generate_sales_order_id/"// path to the get_birds method
      });

    });
</script>