<?php if($item==NULL){?>
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Add Item <small>create new Item</small>
        </h1>
    </div>
</div> 
 <!-- /. ROW  -->
<div class="row">
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Insert Item Information..
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-5">
                    <form role="form" method="post" action="<?php echo base_url();?>item/add_item">
                        <div class="form-group">
                            <label>Item Name</label>
                            <input class="form-control" placeholder = "Item Name" name="item_name" required>
                        </div>

                        <div class="form-group">
                            <label>Part No</label>
                            <input class="form-control" placeholder = "Part No" name="part_no" required>
                        </div>

                        <div class="form-group">
                            <label>Parent Group</label>
                            <select class="form-control" name="group_id" required>
                                <?php foreach($group_list as $value){?>
                                <option value="<?php echo $value->group_id;?>"><?php echo $value->group_name;?></option>
                                <?php }?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="2" name="description"></textarea>
                        </div>

                        
                        <div class="form-group">
                            <label>Unit</label>
                            <input class="form-control" placeholder = "eg. pack, galeon, litter" name="unit" required>
                        </div>

                        <label>Price</label>
                        <div class="form-group input-group">
                            <span class="input-group-addon">&#x9f3;</span>
                            <input type="number" min="0" class="form-control" name="item_price" required>
                            <span class="input-group-addon">.00</span>
                        </div>

                        <label>Product Life</label>
                        <div class="form-group input-group">
                            <input type="number" class="form-control" name="product_life" value="0" min="0">
                            <span class="input-group-addon">days</span>
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

<?php } else {?>

<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Edit Item
        </h1>
    </div>
</div> 
 <!-- /. ROW  -->
<div class="row">
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Change Item Information..
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-5">
                    <form role="form" method="post" action="<?php echo base_url();?>item/update_item/<?php echo $item->item_id;?>">
                        <div class="form-group">
                            <label>Item Name</label>
                            <input class="form-control" placeholder = "Item Name" name="item_name" required value="<?php echo $item->item_name;?>">
                        </div>

                        <div class="form-group">
                            <label>Part No</label>
                            <input class="form-control" placeholder = "Part No" name="part_no" required value="<?php echo $item->part_no;?>">
                        </div>

                        <div class="form-group">
                            <label>Parent Group</label>
                            <select class="form-control" name="group_id" required>
                                <?php foreach($group_list as $value){?>
                                <option <?php if($item->group_id==$value->group_id){ echo "selected";}?> value="<?php echo $value->group_id;?>"><?php echo $value->group_name;?></option>
                                <?php }?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" rows="2" name="description" ><?php echo $item->description;?></textarea>
                        </div>

                       <!--  <label>Price</label>
                        <div class="form-group input-group">
                            <span class="input-group-addon">&#x9f3;</span>
                            <input type="text" class="form-control">
                            <span class="input-group-addon">.00</span>
                        </div> -->
                        <div class="form-group">
                            <label>Unit</label>
                            <input class="form-control" placeholder = "eg. pack, galeon, litter" name="unit" required value="<?php echo $item->unit;?>">
                        </div>

                        <label>Price</label>
                        <div class="form-group input-group">
                            <span class="input-group-addon">&#x9f3;</span>
                            <input type="number" min="0" class="form-control" name="item_price" required value="<?php echo $item->item_price;?>">
                            <span class="input-group-addon">.00</span>
                        </div>

                        <label>Product Life</label>
                        <div class="form-group input-group">
                            <input type="number" min="0" class="form-control" name="product_life" value="<?php echo $item->product_life;?>">
                            <span class="input-group-addon">days</span>
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