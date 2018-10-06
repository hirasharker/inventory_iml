<div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Edit Company <small>change company information..</small>
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
              <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Change company Information..
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-5">
                                    <form role="form" method="post" action="<?php echo base_url();?>company/update_company">
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <input class="form-control" placeholder = "Company Name" name="company_name" value="<?php echo $company->company_name;?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" rows="2" name="address" required><?php echo $company->address;?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input class="form-control" placeholder = "Phone" name="phone" value="<?php echo $company->phone;?>" required>
                                        </div>
                                        
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