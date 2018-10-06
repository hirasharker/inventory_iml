<?php if($vendor==NULL){?>
<div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Add Vendor <small>add new supplier's information..</small>
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
              <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Insert Vendor's Information..
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-5">
                                    <form role="form" method="post" action="<?php echo base_url();?>purchase/add_vendor">
                                        <div class="form-group">
                                            <label>Vendor's Name</label>
                                            <input class="form-control" placeholder = "Vendor's Name" name="vendor_name" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" rows="2" name="address" required></textarea>
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

<?php }else{?>
<div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Edit Vendor
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
              <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Change Vendor's Information..
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-5">
                                    <form role="form" method="post" action="<?php echo base_url();?>purchase/update_vendor/<?php echo $vendor->vendor_id;?>">
                                        <div class="form-group">
                                            <label>Vendor's Name</label>
                                            <input class="form-control" placeholder = "Vendor's Name" name="vendor_name" value="<?php echo $vendor->vendor_name;?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" rows="2" name="address" required><?php echo $vendor->address;?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input class="form-control" placeholder = "Phone" name="phone_no" value="<?php echo $vendor->phone_no;?>" required>
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