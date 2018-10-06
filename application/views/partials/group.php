
<?php if($group==NULL){?>
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Add Group <small>create new category</small>
        </h1>
    </div>
</div> 
 <!-- /. ROW  -->
<div class="row">
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Insert Group Information..
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-5">
                    <form role="form" method="post" action="<?php echo base_url();?>group/add_group">
                        <div class="form-group">
                            <label>Group Name</label>
                            <input class="form-control" placeholder = "Group Name" name="group_name" required>
                        </div>
                        <div class="form-group">
                            <label>Parent Group</label>
                            <select class="form-control" name="parent_id">
                                <option value="0">Select</option>
                                <?php foreach($group_list as $value){?>
                                <option value="<?php echo $value->group_id;?>"><?php echo $value->group_name?></option>
                                <?php }?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
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
            Edit Group
        </h1>
    </div>
</div> 
 <!-- /. ROW  -->
<div class="row">
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Change Group Information..
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-5">
                    <form role="form" method="post" action="<?php echo base_url();?>group/update_group/<?php echo $group->group_id;?>">
                        <div class="form-group">
                            <label>Group Name</label>
                            <input class="form-control" placeholder = "Group Name" name="group_name" value="<?php echo $group->group_name;?>">
                        </div>
                        <div class="form-group">
                            <label>Parent Group</label>
                            <select class="form-control" name="parent_id">
                                <option value="0">Select</option>
                                <?php foreach($group_list as $value){ ?>

                                <?php if($value->group_id != $group->group_id){?>
                                <option <?php if($group->parent_id==$value->group_id){ echo "selected";}?> value="<?php echo $value->group_id;?>"><?php echo $value->group_name;?></option>
                                <?php }?>
                                <?php }?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="2" name="description"><?php echo $group->description;?></textarea>
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