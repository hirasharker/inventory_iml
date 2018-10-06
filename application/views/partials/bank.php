<?php if($bank_detail==NULL){?>
<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Add Bank <small>add new bank's information..</small>
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Insert bank's Information..
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5">
                        <form role="form" method="post" action="<?php echo base_url();?>bank/add_bank">
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input class="form-control" placeholder = "Bank Name" name="bank_name" required>
                            </div>

                            <div class="form-group">
                                <label>Bank Code</label>
                                <input class="form-control" placeholder = "Bank Code" name="bank_code" required>
                            </div>
                            
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" rows="2" name="address"></textarea>
                            </div>
                            
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
<?php }else {?>
<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Edit bank
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Change bank's Information..
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5">
                        <form role="form" method="post" action="<?php echo base_url();?>bank/update_bank">
                            <input type="hidden" name="bank_id" value="<?php echo $bank_detail->bank_id; ?>" />
                            <div class="form-group">
                                <label>bank's Name</label>
                                <input class="form-control" placeholder = "Bank Name" name="bank_name" value="<?php echo $bank_detail->bank_name; ?>">
                            </div>

                            <div class="form-group">
                                <label>Bank Code</label>
                                <input class="form-control" placeholder = "Bank Code" name="bank_code" value="<?php echo $bank_detail->bank_code; ?>">
                            </div>

                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" rows="2" name="address"><?php echo $bank_detail->address; ?></textarea>
                            </div>
                            
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
<?php }?>