<?php if($dealer_detail==NULL){?>
<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Add dealer <small>add new dealer's information..</small>
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Insert dealer's Information..
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5">
                        <form role="form" method="post" action="<?php echo base_url();?>dealer/add_dealer">
                            <div class="form-group">
                                <label>Dealer's Name</label>
                                <input class="form-control" placeholder = "Dealer's Name" name="dealer_name">
                            </div>
                            <div class="form-group">
                                <label>Dealer Category</label>
                                <select class="form-control" name="dealer_category" required>
                                    <option value="3S">3S</option>
                                    <option value="2S">2S</option>
                                    <option value="1S">1S</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" rows="2" name="present_address" required></textarea>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input class="form-control" placeholder = "Phone" name="phone_no" required>
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
                Edit dealer
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Change dealer's Information..
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5">
                        <form role="form" method="post" action="<?php echo base_url();?>dealer/update_dealer">
                            <input type="hidden" name="dealer_id" value="<?php echo $dealer_detail->dealer_id; ?>" />
                            <div class="form-group">
                                <label>Dealer Code</label>
                                <input class="form-control" value="<?php echo $dealer_detail->dealer_id; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>Dealer's Name</label>
                                <input class="form-control" placeholder = "Dealer's Name" name="dealer_name" value="<?php echo $dealer_detail->dealer_name; ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Dealer Category</label>
                                <select class="form-control" name="dealer_category" required>
                                    <option value="3S" <?php if($dealer_detail->dealer_category == "3S"){ echo "selected"; }?> >3S</option>
                                    <option value="2S" <?php if($dealer_detail->dealer_category == "2S"){ echo "selected"; }?> >2S</option>
                                    <option value="1S" <?php if($dealer_detail->dealer_category == "1S"){ echo "selected"; }?> >1S</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <textarea class="form-control" rows="2" name="present_address" required><?php echo $dealer_detail->present_address; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input class="form-control" placeholder = "Phone" name="phone_no" value="<?php echo $dealer_detail->phone_no; ?>" required>
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