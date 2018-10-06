<?php if($stock_transfer==NULL){?>
<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Add Transfer <small>initiate item transfer..</small>
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Insert transfer Information..
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-10">
                        <?php echo form_open('stock_transfer/add_stock_transfer');?>
                        <!-- <form role="form" method="post" action="<?php echo base_url();?>purchase/add_purchase"> -->


                            <div class="form-group">
                                <label>Transferred From</label>
                                <select class="form-control" name="previous_warehouse_id" id="previous_warehouse" required>
                                    <option value="">Select Warehouse</option>
                                    <?php foreach($warehouse_list as $value){?>
                                    <option value="<?php echo $value->warehouse_id; ?>"><?php echo $value->warehouse_name;?></option>
                                <?php }?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Transferred To</label>
                                <select class="form-control" name="current_warehouse_id" id="current_warehouse" required>
                                   
                                </select>
                            </div>


                            <div class="form-group">
                                <label>Select Item</label>
                                <select class="form-control select-tag" id="item" name="item_id">
                                    <option value="0">select</option>
                                
                                </select>
                            </div>
                            <?php if($error_content!=NULL){?>
                            <?php for($i=0; $i<$error_content; $i++){?>
                            <label style="color:#F00;font-size:10px;"><?php echo form_error('quantity['.$i.']');?> </label>
                            <?php }}?>
                            <div class="col-lg-12" id="create">
                                <div id="quantity-error">
                                </div>
                                <input type="hidden" id="count" value="0" name="count">
                            </div>

                            <div class="form-group">
                                <label>Transfer Date</label>
                                <div class="input-group date" data-provide="datepicker">
                                    <input type="text" class="form-control"  id="datepicker" name="stock_transfer_date" required>
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                            <label style="color:#F00;font-size:10px;"><?php echo form_error('stock_transfer_date');?></label>
                            <br/>
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


<script>
        
        $( "#previous_warehouse" ).change(function() {
          // alert( "Handler for .change() called.");

          if($('#current_warehouse').val()!="NULL"){
              $('#current_warehouse').empty();
          }

          var previousWarehouseId = $('#previous_warehouse option:selected').val();
          $.ajax({
              type: "POST",
              url: "<?php echo base_url()?>stock_transfer/get_warehouse_list_without_previous_warehouse/",
              data: { 'previousWarehouseId': previousWarehouseId  },
              success: function(data){
                  // Parse the returned json data
                  var opts = $.parseJSON(data);
                  // Use jQuery's each to iterate over the opts value
                  $('#current_warehouse').append('<option value="">Select Warehouse</option>');

                  $.each(opts, function(i, d) {
                      // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
                      $('#current_warehouse').append('<option value="' + d.warehouse_id + '">' + d.warehouse_name + '</option>');

                  });
              }
          });


          
         
          if($('#item').val()!="NULL"){
              $('#item').empty();
          }

          $('#create').empty();

          $('#create').append('<div id="quantity-error"></div><input type="hidden" id="count" value="0" name="count">');

          $.ajax({
              type: "POST",
              url: "<?php echo base_url()?>sales/get_item_by_warehouse_id/",
              data: { 'warehouseId': previousWarehouseId  },
              success: function(data){
                  // Parse the returned json data
                  var opts = $.parseJSON(data);
                  // Use jQuery's each to iterate over the opts value
                  $('#item').append('<option value="">Select Item</option>');

                  $.each(opts, function(i, d) {
                      // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
                      $('#item').append('<option itemName="' + d.item_name + '" value="' + d.item_id + '" stockQuantity = "'+ d.quantity +'" itemPrice = "'+d.item_price+'">' +d.part_no+"-"+ d.item_name + '</option>');

                  });
                }
            });
        


        });



         $( "#item" ).change(function() {
          // alert( "Handler for .change() called."+this.value);
          var itemName = $('#item option:selected').text();
          var quantity = $(this).find('option:selected').attr('stockQuantity');
          count = document.getElementById('count').value;
          if(count == 0){
            var itemHeader  = '<div class="col-lg-12" style="margin-bottom: 10px;border-bottom: 2px solid #09192a;" id="itemHeader">'
            +'<div class="col-lg-4"><label class="lblItem">Name</label></div>'
            +'<div class="col-lg-2"><label class="lblItem"></label></div>'
            +'<div class="col-lg-3"><label class="lblItem">QTY</label></div>'
            +'<div class="col-lg-1"><label class="lblItem">Stock</label></div>'
            +'</div>';
            
            $('#create').append(itemHeader);
          }
          var val = $('#item option:selected').val();
              if(val!=0){
                $.ajax({
                      url: '<?php echo base_url();?>sales/ajax_count_item',
                      type:'POST',
                      dataType: 'json',
                      data: {count : count},
                      success: function(error_message){
                              $('#quantity-error').html(error_message);
                          } // End of success function of ajax form
                }); // End of ajax call
                
                // alert(quantity);

                count++;
                var code = '<div class="col-lg-12" style="margin-bottom: 10px"><div class="col-lg-5"><label class="lblItem">'
                +itemName+'</label><input class="form-control item-id" type="hidden" name="item_id[]" value="'+this.value+'">'
                +'<input class="form-control" type="hidden" name="item_name[]" value="'+itemName+'">'
                +'</div>'
                +'<div class="col-lg-4">'
                +'<input class="form-control" placeholder = "QTY" name="quantity[]" required></div><div class="col-lg-2"><label class="quantity">('+quantity+')</label></div>'
                +'<a href="" class="col-lg-1 remove"><i class="fa fa-times fa-lg text-danger" aria-hidden="true"></i></a></div>';

                if(this.value != 0){
                     $('#create').append(code);
                        document.getElementById('count').value = count;
                }
                     

                $("#item option[value='"+this.value+"']").remove();
            }
          
        });

       $('#create').on('click', '.remove', function(e){ //Once remove button is clicked
            e.preventDefault();
             var itemName = $(this).parent('div').find(".lblItem").text();
             var itemId = $(this).parent('div').find('.item-id').val();
             var quantity = $(this).parent('div').find('.quantity').text();
             // alert(itemId);
             count--;
             document.getElementById('count').value = count;
            $('#item').append('<option quantity= "'+quantity+'"" value="'+itemId+'">'+itemName+'</option>');
            $(this).parent('div').remove(); //Remove field html

        });

</script>

<?php }else{ ?>

<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Edit purchase 
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Change purchase Information..
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <?php echo form_open('stock_transfer/add_stock_transfer');?>
                        <!-- <form role="form" method="post" action="<?php echo base_url();?>purchase/add_purchase"> -->


                            <div class="form-group">
                                <label>Transferred From</label>
                                <select class="form-control" name="previous_warehouse_id" id="previous_warehouse" required>
                                    <option value="">Select Warehouse</option>
                                    <?php foreach($warehouse_list as $value){?>
                                    <option value="<?php echo $value->warehouse_id; ?>"><?php echo $value->warehouse_name;?></option>
                                <?php }?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Transferred To</label>
                                <select class="form-control" name="current_warehouse_id" id="current_warehouse" required>
                                   
                                </select>
                            </div>


                            <div class="form-group">
                                <label>Select Item</label>
                                <select class="form-control" id="item" name="item_id">
                                    <option value="0">select</option>
                                
                                </select>
                            </div>
                            <?php if($error_content!=NULL){?>
                            <?php for($i=0; $i<$error_content; $i++){?>
                            <label style="color:#F00;font-size:10px;"><?php echo form_error('quantity['.$i.']');?> </label>
                            <?php }}?>
                            <div class="col-lg-12" id="create">
                                <div id="quantity-error">
                                </div>
                                <input type="hidden" id="count" value="0" name="count">
                            </div>

                            <div class="form-group">
                                <label>Transfer Date</label>
                                <div class="input-group date" data-provide="datepicker">
                                    <input type="text" class="form-control"  id="datepicker" name="stock_transfer_date" required>
                                    <div class="input-group-addon">
                                        <span class="glyphicon glyphicon-th"></span>
                                    </div>
                                </div>
                            </div>
                            <label style="color:#F00;font-size:10px;"><?php echo form_error('stock_transfer_date');?></label>
                            <br/>
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


<script>
    <?php foreach($stock_transfer_detail as $value){?>
        // alert(<?php echo json_encode($value->item_name);?>);
        // alert( "Handler for .change() called."+this.value);
        var itemName = <?php echo json_encode($value->item_name);?>;
        count = document.getElementById('count').value;

        count++;
        var code = '<div class="col-lg-12" style="margin-bottom: 10px"><div class="col-lg-4"><label class="lblItem">'
        +itemName+'</label><input class="form-control item-id" type="hidden" name="item_id[]" value="'+<?php echo json_encode($value->item_id);?>+'">'
        +'<input class="form-control" type="hidden" name="item_name[]" value="'+itemName+'">'
        +'</div><div class="col-lg-3">'
        +'<input class="form-control" placeholder = "QTY" name="quantity[]" value="'+<?php echo json_encode($value->quantity);?>+'" required></div>'
        +'<a href="" class="col-lg-1 remove"><i class="fa fa-times fa-lg text-danger" aria-hidden="true"></i></a></div>';

        $('#create').append(code);
        document.getElementById('count').value = count;

        $("#item option[value='"+<?php echo json_encode($value->item_id);?>+"']").remove();
    <?php } ?>  
      
</script>




<script>
        $( "#previous_warehouse" ).change(function() {
          // alert( "Handler for .change() called.");

          if($('#current_warehouse').val()!="NULL"){
              $('#current_warehouse').empty();
          }

          var previousWarehouseId = $('#previous_warehouse option:selected').val();
          $.ajax({
              type: "POST",
              url: "<?php echo base_url()?>stock_transfer/get_warehouse_list_without_previous_warehouse/",
              data: { 'previousWarehouseId': previousWarehouseId  },
              success: function(data){
                  // Parse the returned json data
                  var opts = $.parseJSON(data);
                  // Use jQuery's each to iterate over the opts value
                  $('#current_warehouse').append('<option value="">Select Warehouse</option>');

                  $.each(opts, function(i, d) {
                      // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
                      $('#current_warehouse').append('<option value="' + d.warehouse_id + '">' + d.warehouse_name + '</option>');

                  });
              }
          });


          
          if($('#item').val()!="NULL"){
              $('#item').empty();
          }

          $('#create').empty();

          $('#create').append('<div id="quantity-error"></div><input type="hidden" id="count" value="0" name="count">');

          $.ajax({
              type: "POST",
              url: "<?php echo base_url()?>stock_transfer/get_item_by_warehouse_id/",
              data: { 'warehouseId': previousWarehouseId  },
              success: function(data){
                  // Parse the returned json data
                  var opts = $.parseJSON(data);
                  // Use jQuery's each to iterate over the opts value
                  $('#item').append('<option value="">Select Item</option>');

                  $.each(opts, function(i, d) {
                      // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
                      $('#item').append('<option value="' + d.item_id + '" quantity = "'+ d.quantity +'">' + d.item_name + '</option>');

                  });
              }
          });


        });



         $( "#item" ).change(function() {
          // alert( "Handler for .change() called."+this.value);
          var itemName = $('#item option:selected').text();
          var quantity = $(this).find('option:selected').attr('quantity');
          count = document.getElementById('count').value;
          var val = $('#item option:selected').val();
              if(val!=0){
                $.ajax({
                      url: '<?php echo base_url();?>sales/ajax_count_item',
                      type:'POST',
                      dataType: 'json',
                      data: {count : count},
                      success: function(error_message){
                              $('#quantity-error').html(error_message);
                          } // End of success function of ajax form
                }); // End of ajax call
                
                // alert(quantity);

                count++;
                var code = '<div class="col-lg-12" style="margin-bottom: 10px"><div class="col-lg-5"><label class="lblItem">'
                +itemName+'</label><input class="form-control item-id" type="hidden" name="item_id[]" value="'+this.value+'">'
                +'<input class="form-control" type="hidden" name="item_name[]" value="'+itemName+'">'
                +'</div>'
                +'<div class="col-lg-4">'
                +'<input class="form-control" placeholder = "QTY" name="quantity[]" required></div><div class="col-lg-1"><label class="quantity">'+quantity+'</label></div>'
                +'<a href="" class="col-lg-1 remove"><i class="fa fa-times fa-lg text-danger" aria-hidden="true"></i></a></div>';

                if(this.value != 0){
                     $('#create').append(code);
                        document.getElementById('count').value = count;
                }
                     

                $("#item option[value='"+this.value+"']").remove();
            }
          
        });

       $('#create').on('click', '.remove', function(e){ //Once remove button is clicked
            e.preventDefault();
             var itemName = $(this).parent('div').find(".lblItem").text();
             var itemId = $(this).parent('div').find('.item-id').val();
             var quantity = $(this).parent('div').find('.quantity').text();
             // alert(itemId);
             count--;
             document.getElementById('count').value = count;
            $('#item').append('<option quantity= "'+quantity+'"" value="'+itemId+'">'+itemName+'</option>');
            $(this).parent('div').remove(); //Remove field html

        });

</script>


<?php } ?>