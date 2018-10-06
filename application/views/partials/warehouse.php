
<?php if($warehouse_detail==NULL){?>
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Add warehouse <small>create new category</small>
        </h1>
    </div>
</div> 
 <!-- /. ROW  -->
<div class="row">
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Insert warehouse Information..
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-5">
                    <form role="form" method="post" action="<?php echo base_url();?>warehouse/add_warehouse">
                        <div class="form-group">
                            <label>warehouse Name</label>
                            <input class="form-control" placeholder = "warehouse Name" name="warehouse_name" required>
                        </div>
                        

                        <div class="form-group">
                            <label>Location</label>
                            <textarea class="form-control" rows="2" name="warehouse_location"></textarea>
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
            Edit warehouse
        </h1>
    </div>
</div> 
 <!-- /. ROW  -->
<div class="row">
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Change warehouse Information..
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-5">
                    <form role="form" method="post" action="<?php echo base_url();?>warehouse/update_warehouse/<?php echo $warehouse_detail->warehouse_id;?>">
                        <div class="form-group">
                            <label>Warehouse Name</label>
                            <input class="form-control" placeholder = "warehouse Name" name="warehouse_name" value="<?php echo $warehouse_detail->warehouse_name;?>">
                        </div>
                        

                        <div class="form-group">
                            <label>Location</label>
                            <textarea class="form-control" rows="2" name="warehouse_location"><?php echo $warehouse_detail->warehouse_location;?></textarea>
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