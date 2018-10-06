
<?php if($warehouse_slot_detail==NULL){?>
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Add warehouse Slot <small>create new category</small>
        </h1>
    </div>
</div> 
 <!-- /. ROW  -->
<div class="row">
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Insert warehouse Slot Information..
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-5">
                    <form role="form" method="post" action="<?php echo base_url();?>warehouse/add_warehouse_slot">
                        <div class="form-group">
                            <label>Slot Identifier</label>
                            <input class="form-control" placeholder = "Slot Identifier" name="slot_identifier" required>
                        </div>

                        <div class="form-group">
                            <label>Select Warehouse</label>
                            <select class="form-control" name="warehouse_id" required>
                                <?php foreach($warehouse_list as $value){?>
                                <option value="<?php echo $value->warehouse_id;?>"><?php echo $value->warehouse_name;?></option>
                                <?php }?>
                            </select>
                        </div>
                        

                        <div class="form-group">
                            <label>Slot Detail</label>
                            <textarea class="form-control" rows="2" name="description"></textarea>
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
                    <form role="form" method="post" action="<?php echo base_url();?>warehouse/update_warehouse_slot">
                        <input type="hidden"  name="warehouse_slot_id" value="<?php echo $warehouse_slot_detail->warehouse_slot_id; ?>" />
                        <div class="form-group">
                            <label>Slot Identifier</label>
                            <input class="form-control" placeholder = "Slot Identifier" name="slot_identifier" required value="<?php echo $warehouse_slot_detail->slot_identifier; ?>">
                        </div>

                        <div class="form-group">
                            <label>Select Warehouse</label>
                            <select class="form-control" name="warehouse_id" required>
                                <?php foreach($warehouse_list as $value){?>
                                <option value="<?php echo $value->warehouse_id;?>" <?php if($warehouse_slot_detail->warehouse_id == $value->warehouse_id ){ echo "selected"; }?>><?php echo $value->warehouse_name;?></option>
                                <?php }?>
                            </select>
                        </div>
                        

                        <div class="form-group">
                            <label>Slot Detail</label>
                            <textarea class="form-control" rows="2" name="description"><?php echo $warehouse_slot_detail->description; ?></textarea>
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