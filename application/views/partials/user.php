
<?php if($result==NULL){?>
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Add User <small>create new user</small>
        </h1>
    </div>
</div> 
     <!-- /. ROW  -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Insert User's Information..
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5">
                        <form role="form" method="post" action="<?php echo base_url();?>user/add_user">
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" class="form-control" placeholder = "User Name" name="user_name" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder = "Password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="text" class="form-control" placeholder = "Email Address" name="email_address">
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input class="form-control" placeholder = "Phone no" name="phone_no">
                            </div>
                            <div class="form-group">
                                <label>Select Type</label>
                                <select class="form-control" name="user_type">
                                    <option value="1">Administrator</option>
                                    <option value="2">Standard</option>
                                    <option value="3">Guest</option>
                                </select>
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
            Edit User 
        </h1>
    </div>
</div> 
     <!-- /. ROW  -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Update User's Information..
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5">
                        <form role="form" method="post" action="<?php echo base_url();?>user/update_user/<?php echo $result->user_id;?>">
                            <div class="form-group">
                                <label>User Name</label>
                                <input type="text" class="form-control" placeholder = "User Name" name="user_name" required value="<?php echo $result->user_name?>">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" placeholder = "Password" name="password" required>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="text" class="form-control" placeholder = "Email Address" name="email_address" value="<?php echo $result->email_address?>">
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input class="form-control" placeholder = "Phone no" name="phone_no" value="<?php echo $result->phone?>">
                            </div>
                            <div class="form-group">
                                <label>Select Type</label>
                                <select class="form-control" name="user_type">
                                    <option <?php if($result->user_type==1){ echo "selected";}?> value="1">Administrator</option>
                                    <option <?php if($result->user_type==2){ echo "selected";}?> value="2">Standard</option>
                                    <option <?php if($result->user_type==3){ echo "selected";}?> value="3">Guest</option>
                                </select>
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