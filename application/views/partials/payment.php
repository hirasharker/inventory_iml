<?php if($payment==NULL){?>
<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Add Payment <small>add new payment entry</small>
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Insert payment Information..
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5">
                        <form role="form" method="post" action="<?php echo base_url();?>payment/add_payment">
                            <label>Purchase Id</label>

                            <div class="form-group input-group">
                             
                                <span class="input-group-addon">&#x9f3;</span>
                                <input type="text" class="form-control" id="purchase_id" name="purchase_id" value="<?php echo set_value('purchase_id'); ?>" required>
                                <span class="input-group-addon">.00</span>
                            </div>

                            <label>Paid Amount</label>

                            <div class="form-group input-group">
                             
                                <span class="input-group-addon">&#x9f3;</span>
                                <input type="text" class="form-control" name="paid_amount" value="<?php echo set_value('paid_amount'); ?>" required>
                                <span class="input-group-addon">.00</span>
                            </div>
                           
                            <br/>
                            
                           <!--  <div class="form-group">
                                <label>Date</label>
                                <input id="datepicker" class="form-control">
                            </div> -->
                            <label>Payment Date</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" class="form-control"  id="datepicker" name="payment_date" value="<?php echo set_value('payment_date'); ?>" required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                            <label style="color:#F00;font-size:10px;"><?php echo form_error('payment_date');?></label>
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


<?php }else{?>
<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Edit Payment
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Change payment Information..
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5">
                        <form role="form" method="post" action="<?php echo base_url();?>payment/update_payment/<?php echo $payment->payment_id?>">
                            <label>Purchase Id</label>

                            <div class="form-group input-group">
                             
                                <span class="input-group-addon">&#x9f3;</span>
                                <input type="text" class="form-control" id="purchase_id" name="purchase_id" value="<?php echo $payment->purchase_id; ?>">
                                <span class="input-group-addon">.00</span>
                            </div>
                            

                            <label>Paid Amount</label>

                            <div class="form-group input-group">
                             
                                <span class="input-group-addon">&#x9f3;</span>
                                <input type="text" class="form-control" name="paid_amount" value="<?php echo $payment->paid_amount;?>">
                                <span class="input-group-addon">.00</span>
                            </div>
                           
                            <br/>
                            
                           <!--  <div class="form-group">
                                <label>Date</label>
                                <input id="datepicker" class="form-control">
                            </div> -->
                            <label>Payment Date</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" class="form-control"  id="datepicker" name="payment_date" value="<?php echo $payment->payment_date;?>">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                            <label style="color:#F00;font-size:10px;"><?php echo form_error('payment_date');?></label>
                            <br/>
                            </br>
                            <button type="update" class="btn btn-primary">Save</button>
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
<?php }?>

<script>
    $(function(){
      $("#purchase_id").autocomplete({
        source: "<?php echo base_url();?>payment/generate_purchase_id/"// path to the get_birds method
      });
    });
</script>