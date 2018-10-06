<?php if($warranty_claim==NULL){?>
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Add Warranty Claim <small>create new claim</small>
        </h1>
    </div>
</div> 
 <!-- /. ROW  -->
<div class="row">
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Insert warranty claim Information..
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-5">
                    <form role="form" method="post" action="<?php echo base_url();?>warranty_claim/add_warranty_claim" enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Sales Invoice</label>
                            <select class="form-control select-tag" name="sales_id" required id="sales-id">
                                <option value="">Select Invoice</option>
                                <?php foreach($sales_list as $value){?>
                                <option value="<?php echo $value->sales_id;?>" ><?php echo $value->sales_id;?></option>
                                <?php }?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Select Item</label>
                            <select class="form-control select-tag" name="item_id" required id="item" required>
                                <?php foreach($item_list as $value){?>
                                <!-- <option value="<?php echo $value->item_id;?>"><?php echo $value->part_no.' - '.$value->item_name;?></option> -->
                                <?php }?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Serial No</label>
                            <input class="form-control" placeholder = "Serial No" name="item_serial_no" required>
                        </div>

                        

                        <div class="form-group">
                            <label>Type of Claim</label>
                            <select class="form-control" name="warranty_claim_type_id" required>
                                <?php foreach($wc_type_list as $value){?>
                                <option value="<?php echo $value->warranty_claim_type_id;?>"><?php echo $value->warranty_claim_type_name;?></option>
                                <?php }?>
                            </select>
                        </div>


                        <div class="form-group">
                          <label>Upload Document </label>
                            <input type="file" class="form-control" name="document_path">
                        </div>

                        <div class="form-group">
                            <label>Buyer Complain</label>
                            <textarea class="form-control" rows="2" name="buyer_complain" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Observation & Analysis</label>
                            <textarea class="form-control" rows="2" name="observation_note" required></textarea>
                        </div>

                        <label>Quantity</label>
                        <div class="form-group input-group">
                            <input id="quantity" type="number" class="form-control" name="quantity" value="0" min="0">
                            <span class="input-group-addon"></span>
                        </div>


                        <label>Date of Claim</label>
                        <div class="input-group date" data-provide="datepicker">
                            <input type="text" class="form-control"  id="datepicker" name="warranty_claim_date" required >
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>

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

<script type="text/javascript">
    $( "#sales-id" ).change(function() {
    // alert( "Handler for .change() called.");

      var salesId = $('#sales-id option:selected').val();

      if($('#item').val()!="NULL"){
          $('#item').empty();
      }

      $.ajax({
          type: "POST",
          url: "<?php echo base_url()?>warranty_claim/ajax_get_item_list_by_sales_id/",
          data: { 'sales_id': salesId  },
          success: function(data){
              // Parse the returned json data
              var opts = $.parseJSON(data);
              // Use jQuery's each to iterate over the opts value
              $('#item').append('<option value="">Select Item</option>');

              $.each(opts, function(i, d) {
                  // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
                  $('#item').append('<option value="' + d.item_id + '" data-quantity = "'+ d.sales_quantity +'">' +d.part_no+"-"+ d.item_name + '</option>');

              });
            }
        });
    }); // warehouseId.change...............

    $('#item').change(function() {
        var quantity    =   $(this).find(':selected').attr('data-quantity');

        $('#quantity').attr("max",quantity);
    });
</script>

<?php } else {?>

<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Edit Warranty Claim <small>edit claim</small>
        </h1>
    </div>
</div> 
 <!-- /. ROW  -->
<div class="row">
<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Change warranty claim Information..
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-5">
                    <form role="form" method="post" action="<?php echo base_url();?>warranty_claim/update_warranty_claim" enctype="multipart/form-data">
                        <input type="hidden" value="<?php echo $warranty_claim->warranty_claim_id; ?>" name="warranty_claim_id">
                        <div class="form-group">
                            <label>Sales Invoice</label>
                            <select class="form-control select-tag" name="sales_id" required id="sales-id">
                                <option value="">Select Invoice</option>
                                <?php foreach($sales_list as $value){?>
                                <option value="<?php echo $value->sales_id;?>" <?php echo ($warranty_claim->sales_id == $value->sales_id ? 'selected' : '');?> ><?php echo $value->sales_id;?></option>
                                <?php }?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Select Item</label>
                            <select class="form-control select-tag" name="item_id" required id="item" required>
                                <?php foreach($item_list as $value){?>
                                <option value="<?php echo $value->item_id;?>" <?php echo ($warranty_claim->item_id == $value->item_id ? 'selected' : '');?> ><?php echo $value->part_no.' - '.$value->item_name;?></option>
                                <?php }?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Serial No</label>
                            <input class="form-control" placeholder = "Serial No" name="item_serial_no" value="<?php echo $warranty_claim->item_serial_no; ?>" required>
                        </div>

                        

                        <div class="form-group">
                            <label>Type of Claim</label>
                            <select class="form-control" name="warranty_claim_type_id" required>
                                <?php foreach($wc_type_list as $value){?>
                                <option value="<?php echo $value->warranty_claim_type_id;?>" <?php echo ($warranty_claim->warranty_claim_type_id == $value->warranty_claim_type_id ? 'selected' : '');?> ><?php echo $value->warranty_claim_type_name;?></option>
                                <?php }?>
                            </select>
                        </div>


                        <div class="form-group">
                            <label>Upload Document </label>
                            
                            <input type="file" class="form-control" name="document_path">
                            <img src="<?php echo base_url().'files/'.$warranty_claim->document_path;?>" width="50px" height="50px">

                        </div>

                        <div class="form-group">
                            <label>Buyer Complain</label>
                            <textarea class="form-control" rows="2" name="buyer_complain" required><?php echo $warranty_claim->buyer_complain; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label>Observation & Analysis</label>
                            <textarea class="form-control" rows="2" name="observation_note" required><?php echo $warranty_claim->observation_note; ?></textarea>
                        </div>

                        <label>Quantity</label>
                        <div class="form-group input-group">
                            <input id="quantity" type="number" class="form-control" name="quantity" value="<?php echo $warranty_claim->quantity; ?>" min="0">
                            <span class="input-group-addon"></span>
                        </div>


                        <label>Date of Claim</label>
                        <div class="input-group date" data-provide="datepicker">
                            <input type="text" class="form-control"  id="datepicker" name="warranty_claim_date" required value="<?php echo $warranty_claim->warranty_claim_date; ?>">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>

                        </br>
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

<script type="text/javascript">
    $( "#sales-id" ).change(function() {
    // alert( "Handler for .change() called.");

      var salesId = $('#sales-id option:selected').val();

      if($('#item').val()!="NULL"){
          $('#item').empty();
      }

      $.ajax({
          type: "POST",
          url: "<?php echo base_url()?>warranty_claim/ajax_get_item_list_by_sales_id/",
          data: { 'sales_id': salesId  },
          success: function(data){
              // Parse the returned json data
              var opts = $.parseJSON(data);
              // Use jQuery's each to iterate over the opts value
              $('#item').append('<option value="">Select Item</option>');

              $.each(opts, function(i, d) {
                  // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
                  $('#item').append('<option value="' + d.item_id + '" data-quantity = "'+ d.quantity +'">' +d.part_no+"-"+ d.item_name + '</option>');

              });
            }
        });
    }); // warehouseId.change...............

    $('#item').change(function() {
        var quantity    =   $(this).find(':selected').attr('data-quantity');

        $('#quantity').attr("max",quantity);
    });
</script>
<?php }?>