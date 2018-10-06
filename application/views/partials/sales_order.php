<?php if($sales_order==NULL){?>
<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Add Sales Order <small>add new Sales Order entry..</small>
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Insert Sales Order Information...
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-9">
                       <?php echo form_open('sales_order/add_sales_order');?>
                       <!-- <form role="form" method="get" action="#"> -->

                            <div class="form-group">
                                <label>Type of Customer</label>
                                <select class="form-control" name="customer_type" id="customerType">
                                    <option value="">Select Type</option>
                                    <option value="1">Dealer</option>
                                    <option value="2">Regular Customer</option>
                                </select>
                            </div>

                            <div class="form-group" id="customer" style="display:none">
                                <label>Select Customer</label>
                                <select class="form-control select-tag" name="customer_id" id="customerId" style="width: 100% !important;">
                                    <option value="">select customer</option>
                                    <?php foreach($customer_list as $value){?>
                                    <option value="<?php echo $value->customer_id; ?>"><?php echo $value->customer_name;?></option>
                                <?php }?>
                                </select>
                            </div>

                            <div class="form-group" id="dealer" style="display:none">
                                <label>Select Dealer</label>
                                <select class="form-control select-tag" name="dealer_id" id="dealerId" style="width: 100% !important;">
                                    <option value="">select dealer</option>
                                    <?php foreach($dealer_list as $value){?>
                                    <option value="<?php echo $value->dealer_id; ?>"><?php echo $value->dealer_name;?></option>
                                <?php }?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Select Warehouse</label>
                                <select class="form-control" name="warehouse_id" id="warehouseId">
                                    <option value="">Select Warehouse</option>
                                    <?php foreach($warehouse_list as $value){?>
                                    <option value="<?php echo $value->warehouse_id; ?>"><?php echo $value->warehouse_name;?></option>
                                <?php }?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Select Item</label>
                                <select class="form-control select-tag" id="item" name="item_id">
                                    <option value="0">select</option>
                               <!--  <?php foreach($item_list as $value){?>
                                    <option value="<?php echo $value->item_id; ?>" quantity="<?php echo $value->quantity;?>"><?php echo $value->item_name;?></option>
                                <?php }?> -->
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
                            <div class="col-lg-12" id="item-summary">
                                
                            </div>

                            

                            <div class="form-group" id="discount-div">
                                <label>Discount (%)</label>
                                <input class="form-control discount" placeholder = "Discount" id="discount" name="sales_order_discount" type="number" step=".01" min="0" max="100">
                            </div>
                            <label>sales_order Date</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" class="form-control"  id="datepicker" name="sales_order_date" required >
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                            <label style="color:#F00;font-size:10px;"><?php echo form_error('sales_order_date');?></label>
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
        $( "#item" ).change(function() {
          // alert( "Handler for .change() called."+this.value);
          // var itemName = $('#item option:selected').text();
          var element = $(this).find('option:selected'); 
          var itemName = element.attr("itemName");

          var itemPrice = $(this).find('option:selected').attr('itemPrice');
          var stockQuantity = $(this).find('option:selected').attr('stockQuantity');
          count = document.getElementById('count').value;
          if(count == 0){
            var itemHeader  = '<div class="col-lg-12" style="margin-bottom: 10px;border-bottom: 2px solid #09192a;" id="itemHeader">'
            +'<div class="col-lg-4"><label class="lblItem">Name</label></div>'
            +'<div class="col-lg-2"><label class="lblItem">Price</label></div>'
            +'<div class="col-lg-2"><label class="lblItem"></label></div>'
            +'<div class="col-lg-2"><label class="lblItem">QTY</label></div>'
            +'<div class="col-lg-1"><label class="lblItem">Stock</label></div>'
            +'</div>';
            
            $('#create').append(itemHeader);
          }


          if(count == 0){
            var itemSummary  = '<div class="col-lg-12" style="margin-top: 10px;border-top: 1px dotted #09192a;" id="itemSummary">'
           
            +'<div class="col-lg-2"><label class="lblItem">Sub Total</label></div>'
            +'<div class="col-lg-1"><input style="background: rgba(0,0,0,0); border : none;" type="text" disabled id="sub-total" value="0"/></div>'
            +'<div class="col-lg-2"><label class="lblItem">Discount</label></div>'
            +'<div class="col-lg-1"><input style="background: rgba(0,0,0,0); border : none;" type="text" disabled id="discount-summary" value="0"/></div>'
             +'<div class="col-lg-2"><label class="lblItem">Total Price</label></div>'
            +'<div class="col-lg-1"><input style="background: rgba(0,0,0,0); border : none;" type="text" disabled id="total-price" value="0"/></div>'
            +'</div>';
            
            $('#item-summary').append(itemSummary);
          }


          var val = $('#item option:selected').val();
              if(val!=0){
                $.ajax({
                      url: '<?php echo base_url();?>sales_order/ajax_count_item',
                      type:'POST',
                      dataType: 'json',
                      data: {count : count},
                      success: function(error_message){
                              $('#quantity-error').html(error_message);
                          } // End of success function of ajax form
                }); // End of ajax call
                
                // alert(quantity);

                count++;
                var code = '<div class="col-lg-12" style="margin-bottom: 10px"><div class="col-lg-4"><label class="lblItem">'
                +itemName+'</label><input class="form-control item-id" type="hidden" name="item_id[]" value="'+this.value+'">'
                +'<input class="form-control" type="hidden" name="item_name[]" value="'+itemName+'">'
                +'</div><div class="col-lg-2">'
                +'<input class="form-control item-price" placeholder = "Price" name="sales_order_price[]" value="'+itemPrice+'" required type="hidden" >'
                +'<label>MRP '+itemPrice+'/-</label></div>'
                +'<div class="col-lg-2">'
                +'<input class="form-control stock-quantity" type="hidden" value="'+stockQuantity+'">'
                +'<input class="form-control" placeholder = "Discount" name="discount[]" required value="0" type="hidden"></div>'
                +'<input class="col-lg-2 qty" placeholder = "QTY" name="quantity[]" required><div class="col-lg-1"><label>('+stockQuantity+')</label></div>'
                +'<a href="" class="col-lg-1 remove"><i class="fa fa-times fa-lg text-danger" aria-hidden="true"></i></a></div>';

                if(this.value != 0){
                     $('#create').append(code);
                        document.getElementById('count').value = count;
                }

                $("#item option[value='"+this.value+"']").remove();
            }
          
        });


        $( "#customerType" ).change(function() {
          // alert( "Handler for .change() called."+this.value);
          var val = $('#customerType option:selected').val();8
          if(val == 1){
            $( "#dealer" ).show( 500 );
            $( "#customer" ).hide( 500 );
            $( "#customerId" ).val("");
          }else if (val == 2){
            $( "#customer" ).show( 500 );
            $( "#dealer" ).hide( 500 );
            $( "#dealerId" ).val("");
          }else {
            $( "#customer" ).hide( 500 );
            $( "#dealer" ).hide( 500 );
            $( "#customerId" ).val("");
            $( "#dealerId" ).val("");
          }

        });



         $( "#warehouseId" ).change(function() {
          // alert( "Handler for .change() called.");

          var warehouseId = $('#warehouseId option:selected').val();
          
          if($('#item').val()!="NULL"){
              $('#item').empty();
          }

          $('#create').empty();

          $('#create').append('<div id="quantity-error"></div><input type="hidden" id="count" value="0" name="count">');

          $.ajax({
              type: "POST",
              url: "<?php echo base_url()?>sales_order/get_item_by_warehouse_id/",
              data: { 'warehouseId': warehouseId  },
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


       $('#create').on('click', '.remove', function(e){ //Once remove button is clicked
            e.preventDefault();
             var itemName = $(this).parent('div').find(".lblItem").text();
             var itemPrice = $(this).parent('div').find(".item-price").val();
             var itemId = $(this).parent('div').find('.item-id').val();
             var stockQuantity = $(this).parent('div').find('.stock-quantity').val();

             count--;
             document.getElementById('count').value = count;
            $('#item').append('<option value="'+itemId+'" itemName ="'+itemName+'" itemPrice="'+itemPrice+'" stockQuantity="'+stockQuantity+'">'+itemName+'</option>');
            $(this).parent('div').remove(); //Remove field html
            if(count == 0){
              $('#itemHeader').remove();
            }


            //-----AJAX FOR ADJUSTING SUBTOTAL
            var salesOrderPrice = $('input[name="sales_order_price[]"]').map(function(){ 
                  return this.value; 
              }).get();

              var qty = $('input[name="quantity[]"]').map(function(){ 
                  return this.value; 
              }).get();

              $.ajax({
                  type: 'POST',
                  url: '<?php echo base_url()?>sales_order/ajax_get_order_total_with_discount/',
                  data: {
                      'sales_order_price[]': salesOrderPrice,
                      'quantity[]': qty,
                      // other data
                  },
                  success: function(data){
                      // Parse the returned json data
                      var resultSummary = $.parseJSON(data);
                      console.log(resultSummary);
                     document.getElementById('sub-total').value = resultSummary.sub_total;
                     document.getElementById('discount-summary').value = resultSummary.discount;
                     document.getElementById('total-price').value = resultSummary.total_price;
                  }
              });     //-----END AJAX FOR ADJUSTING SUBTOTAL

        });




        //-----AJAX FOR ADJUSTING SUBTOTAL
       $('#create').on('keyup', '.qty', function(e){ //Once remove button is clicked
          
                var salesOrderPrice = $('input[name="sales_order_price[]"]').map(function(){ 
                    return this.value; 
                }).get();

                var qty = $('input[name="quantity[]"]').map(function(){ 
                    return this.value; 
                }).get();

                var discount = document.getElementById('discount').value;

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url()?>sales_order/ajax_get_order_total_with_discount/',
                    data: {
                        'sales_order_price[]': salesOrderPrice,
                        'quantity[]': qty,
                        'discount' : discount,
                        // other data
                    },
                    success: function(data){
                        // Parse the returned json data
                        var resultSummary = $.parseJSON(data);
                        console.log(resultSummary);
                       document.getElementById('sub-total').value = resultSummary.sub_total;
                       document.getElementById('discount-summary').value = resultSummary.discount;
                       document.getElementById('total-price').value = resultSummary.total_price;
                    }
                });


          });
        //-----END AJAX FOR ADJUSTING SUBTOTAL


        //-----AJAX FOR ADJUSTING SUBTOTAL  with DISCOUNT
       $('#discount-div').on('keyup', '.discount', function(e){ //Once remove button is clicked
          
                var salesOrderPrice = $('input[name="sales_order_price[]"]').map(function(){ 
                    return this.value; 
                }).get();

                var qty = $('input[name="quantity[]"]').map(function(){ 
                    return this.value; 
                }).get();

                var discount = document.getElementById('discount').value;

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url()?>sales_order/ajax_get_order_total_with_discount/',
                    data: {
                        'sales_order_price[]': salesOrderPrice,
                        'quantity[]': qty,
                        'discount': discount,
                        // other data
                    },
                    success: function(data){
                        // Parse the returned json data
                        var resultSummary = $.parseJSON(data);
                        console.log(resultSummary);
                       document.getElementById('sub-total').value = resultSummary.sub_total;
                       document.getElementById('discount-summary').value = resultSummary.discount;
                       document.getElementById('total-price').value = resultSummary.total_price;
                    }
                });


          });
        //-----END AJAX FOR ADJUSTING SUBTOTAL

           
</script>

<?php }else{ ?>





<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Edit Sales Order 
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Change Sales Order Information..
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-9">
                        <form role="form" method="post" action="<?php echo base_url();?>sales_order/update_sales_order/<?php echo $sales_order->sales_order_id;?>">

                            <div class="form-group">
                                <label>Type of Customer</label>
                                <select class="form-control" name="customer_type" id="customerType">
                                    <option value="">Select Type</option>
                                    <option value="1" <?php if($sales_order->customer_type==1){echo "selected";}?>>Dealer Sale</option>
                                    <option value="2" <?php if($sales_order->customer_type==2){echo "selected";}?>>Regular Customer</option>
                                </select>
                            </div>

                            <div class="form-group" id="customer" style="display:none">
                                <label>Select Customer</label>
                                <select class="form-control" name="customer_id" id="customerId">
                                    <option value="">select customer</option>
                                    <?php foreach($customer_list as $value){?>
                                    <option <?php if($sales_order->customer_id==$value->customer_id){ echo "selected";}?> value="<?php echo $value->customer_id; ?>"><?php echo $value->customer_name;?></option>
                                    <?php }?>
                                </select>
                            </div>

                            <div class="form-group" id="dealer" style="display:none">
                                <label>Select Dealer</label>
                                <select class="form-control" name="dealer_id" id="dealerId">
                                    <option value="">select dealer</option>
                                    <?php foreach($dealer_list as $value){?>
                                    <option <?php if($sales_order->dealer_id==$value->dealer_id){ echo "selected";}?> value="<?php echo $value->dealer_id; ?>"><?php echo $value->dealer_name;?></option>
                                <?php }?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Select Warehouse</label>
                                <select class="form-control" name="warehouse_id" id="warehouseId">
                                    <option value="">Select Warehouse</option>
                                    <?php foreach($warehouse_list as $value){?>
                                    <option <?php if($sales_order->warehouse_id==$value->warehouse_id){ echo "selected";}?>  value="<?php echo $value->warehouse_id; ?>" ><?php echo $value->warehouse_name;?></option>
                                <?php }?>
                                </select>
                            </div>


                            <div class="form-group">
                                <label>Select Item</label>
                                <select class="form-control select-tag" id="item" name="item_id">
                                    <option>select</option>
                                <?php foreach($item_list as $value){?>
                                    <option value="<?php echo $value->item_id; ?>" itemName="<?php echo $value->item_name;?>" stockQuantity="<?php echo $value->quantity; ?>"><?php echo $value->item_name;?></option>
                                <?php }?>
                                </select>
                            </div>
                            <?php if($error_content!=NULL){?>
                            <?php for($i=0; $i<$error_content; $i++){?>
                            <label style="color:#F00;font-size:10px;"><?php echo form_error('quantity['.$i.']');?> </label>
                            <?php }}?>
                            <div class="col-lg-12" id="create">
                            <label style="color:#F00;font-size:10px;"><?php echo form_error('sales_order_price[]');?></label>
                            <br/>
                                <input type="hidden" id="count" value="0" name="count">
                            </div>
                            <div class="col-lg-12" id="item-summary">
                                
                            </div>

                           
                            <div class="form-group" id="discount-div">
                                <label>Discount (%)</label>
                                <input class="form-control discount" placeholder = "Discount" id="discount" value="<?php echo $sales_order->overall_discount;?>" name="sales_order_discount" type="number" step=".01" min="0" max="100">
                            </div>
                            <label>sales_order Date</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" class="form-control"  id="datepicker" name="sales_order_date" value="<?php echo $sales_order->sales_order_date;?>" required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                            <label style="color:#F00;font-size:10px;"><?php echo form_error('sales_order_date');?></label>
                            <br/>
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


<script>
    var itemSummary  = '<div class="col-lg-12" style="margin-top: 10px;border-top: 1px dotted #09192a;" id="itemSummary">'
           
                      +'<div class="col-lg-2"><label class="lblItem">Sub Total</label></div>'
                      +'<div class="col-lg-1"><input style="background: rgba(0,0,0,0); border : none;" type="text" disabled id="sub-total" value="0"/></div>'
                      +'<div class="col-lg-2"><label class="lblItem">Discount</label></div>'
                      +'<div class="col-lg-1"><input style="background: rgba(0,0,0,0); border : none;" type="text" disabled id="discount-summary" value="0"/></div>'
                       +'<div class="col-lg-2"><label class="lblItem">Total Price</label></div>'
                      +'<div class="col-lg-1"><input style="background: rgba(0,0,0,0); border : none;" type="text" disabled id="total-price" value="0"/></div>'
                      +'</div>';
                      
    
    $('#item-summary').append(itemSummary);

    <?php foreach($sales_order_detail as $value){?>
        // alert(<?php echo json_encode($value->item_name);?>);
        // alert( "Handler for .change() called."+this.value);
        var itemName = <?php echo json_encode($value->item_name);?>;
        var itemPrice = <?php echo json_encode($value->item_price);?>;
        count = document.getElementById('count').value;
        if(count == 0){
            var itemHeader  = '<div class="col-lg-12" style="margin-bottom: 10px;border-bottom: 2px solid #09192a;" id="itemHeader">'
            +'<div class="col-lg-4"><label class="lblItem">Name</label></div>'
            +'<div class="col-lg-2"><label class="lblItem">Price</label></div>'
            +'<div class="col-lg-2"><label class="lblItem"></label></div>'
            +'<div class="col-lg-2"><label class="lblItem">QTY</label></div>'
            +'<div class="col-lg-1"><label class="lblItem">Stock</label></div>'
            +'</div>';
            
            $('#create').append(itemHeader);
        }

        count++;
        var code = '<div class="col-lg-12" style="margin-bottom: 10px"><div class="col-lg-4"><label class="lblItem">'
        +itemName+'</label><input class="form-control item-id" type="hidden" name="item_id[]" value="'+<?php echo json_encode($value->item_id);?>+'">'
        +'<input class="form-control" type="hidden" name="item_name[]" value="'+itemName+'">'
        +'</div><div class="col-lg-2">'
        +'<input class="form-control" placeholder = "Price" name="sales_order_price[]" value="'+itemPrice+'" required type="hidden">'
        +'<label>MRP '+itemPrice+'/-</label>'
        +'</div><div class="col-lg-2">'
        +'<input class="form-control" placeholder = "Disc" name="discount[]" value="'+<?php echo json_encode($value->individual_discount);?>+'" type="hidden"></div>'
        +'<div class="col-lg-2">'
        +'<input class="form-control stock-quantity" type="hidden" value="'+<?php echo json_encode($value->stock_quantity+$value->quantity);?>+'">'
        +'<input class="form-control qty" type="number" min="1" max="'+<?php echo json_encode($value->stock_quantity+$value->quantity);?>+'" placeholder = "QTY" name="quantity[]" value="'+<?php echo json_encode($value->quantity);?>+'" required></div>'
        +'<div class="col-lg-1"><label>('+<?php echo json_encode($value->stock_quantity + $value->quantity );?>+')</label></div>'
        +'<a href="" class="col-lg-1 remove"><i class="fa fa-times fa-lg text-danger" aria-hidden="true"></i></a></div>';

        $('#create').append(code);
        document.getElementById('count').value = count;

        $("#item option[value='"+<?php echo json_encode($value->item_id);?>+"']").remove();
    <?php } ?>  
      
</script>

<script>
        $( "#item" ).change(function() {
          // alert( "Handler for .change() called."+this.value);
          // var itemName = $('#item option:selected').text();
          var element = $(this).find('option:selected'); 
          var itemName = element.attr("itemName");

          var stockQuantity = $(this).find('option:selected').attr('stockQuantity');
          count = document.getElementById('count').value;
          if(count == 0){
            var itemHeader  = '<div class="col-lg-12" style="margin-bottom: 10px;border-bottom: 2px solid #09192a;" id="itemHeader">'
            +'<div class="col-lg-4"><label class="lblItem">Name</label></div>'
            +'<div class="col-lg-2"><label class="lblItem">Price</label></div>'
            +'<div class="col-lg-2"><label class="lblItem"></label></div>'
            +'<div class="col-lg-2"><label class="lblItem">QTY</label></div>'
            +'<div class="col-lg-1"><label class="lblItem">Stock</label></div>'
            +'</div>';
            
            $('#create').append(itemHeader);
          }

          if(count == 0){
            var itemSummary  = '<div class="col-lg-12" style="margin-top: 10px;border-top: 1px dotted #09192a;" id="itemSummary">'
           
            +'<div class="col-lg-2"><label class="lblItem">Sub Total</label></div>'
            +'<div class="col-lg-1"><input style="background: rgba(0,0,0,0); border : none;" type="text" disabled id="sub-total" value="0"/></div>'
            +'<div class="col-lg-2"><label class="lblItem">Discount</label></div>'
            +'<div class="col-lg-1"><input style="background: rgba(0,0,0,0); border : none;" type="text" disabled id="discount-summary" value="0"/></div>'
             +'<div class="col-lg-2"><label class="lblItem">Total Price</label></div>'
            +'<div class="col-lg-1"><input style="background: rgba(0,0,0,0); border : none;" type="text" disabled id="total-price" value="0"/></div>'
            +'</div>';
            
            $('#item-summary').append(itemSummary);
          }

          var val = $('#item option:selected').val();
              if(val!=0){
                count++;
                var code = '<div class="col-lg-12" style="margin-bottom: 10px"><div class="col-lg-4"><label class="lblItem">'
                +itemName+'</label><input class="form-control item-id" type="hidden" name="item_id[]" value="'+this.value+'">'
                +'<input class="form-control" type="hidden" name="item_name[]" value="'+itemName+'">'
                +'</div><div class="col-lg-2">'
                +'<input class="form-control item-price" placeholder = "Price" name="sales_order_price[]" value="'+itemPrice+'" required type="hidden" >'
                +'<label>MRP '+itemPrice+'/-</label></div>'
                +'<div class="col-lg-2">'
                +'<input class="form-control" placeholder = "Discount" name="discount[]" required value="0" type="hidden"></div>'
                +'<div class="col-lg-2">'
                +'<input class="form-control stock-quantity" type="hidden" value="'+stockQuantity+'">'
                +'<input class="form-control qty" placeholder = "QTY" name="quantity[]" required value="0" type="number" max="'+stockQuantity+'"></div>'
                +'<div class="col-lg-1"><label>('+stockQuantity+')</label></div>'
                +'<a href="" class="col-lg-1 remove"><i class="fa fa-times fa-lg text-danger" aria-hidden="true"></i></a></div>';

                      $('#create').append(code);
                        document.getElementById('count').value = count;

                $("#item option[value='"+this.value+"']").remove();
              }
        });


        
        var customerType = $('#customerType option:selected').val();

        if(customerType == 1){
            $( "#dealer" ).show( 500 );
            $( "#customer" ).hide( 500 );
            $( "#customerId" ).val("");
          }else if (customerType == 2){
            $( "#customer" ).show( 500 );
            $( "#dealer" ).hide( 500 );
            $( "#dealerId" ).val("");
          }else {
            $( "#customer" ).hide( 500 );
            $( "#dealer" ).hide( 500 );
            $( "#customerId" ).val("");
            $( "#dealerId" ).val("");
        }
        
        $( "#customerType" ).change(function() {
          // alert( "Handler for .change() called."+this.value);
          var val = $('#customerType option:selected').val();
          if(val == 1){
            $( "#dealer" ).show( 500 );
            $( "#customer" ).hide( 500 );
            $( "#customerId" ).val("");
          }else if (val == 2){
            $( "#customer" ).show( 500 );
            $( "#dealer" ).hide( 500 );
            $( "#dealerId" ).val("");
          }else {
            $( "#customer" ).hide( 500 );
            $( "#dealer" ).hide( 500 );
            $( "#customerId" ).val("");
            $( "#dealerId" ).val("");
          }

        });



         $( "#warehouseId" ).change(function() {
          // alert( "Handler for .change() called.");

          var warehouseId = $('#warehouseId option:selected').val();
          
          if($('#item').val()!="NULL"){
              $('#item').empty();
          }

          $('#create').empty();

          $('#create').append('<div id="quantity-error"></div><input type="hidden" id="count" value="0" name="count">');

          $.ajax({
              type: "POST",
              url: "<?php echo base_url()?>sales_order/get_item_by_warehouse_id/",
              data: { 'warehouseId': warehouseId  },
              success: function(data){
                  // Parse the returned json data
                  var opts = $.parseJSON(data);
                  // Use jQuery's each to iterate over the opts value
                  $('#item').append('<option value="">Select Item</option>');

                  $.each(opts, function(i, d) {
                      // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
                      $('#item').append('<option itemName="' + d.item_name + '" value="' + d.item_id + '" quantity = "'+ d.quantity +'" itemPrice = "'+d.item_price+'">' +d.part_no+"-"+ d.item_name + '</option>');

                  });
              }
          });


        });



       $('#create').on('click', '.remove', function(e){ //Once remove button is clicked
            e.preventDefault();
             var itemName = $(this).parent('div').find(".lblItem").text();
             var itemId = $(this).parent('div').find('.item-id').val();
             var itemPrice = $(this).parent('div').find(".item-price").val();
             var stockQuantity = $(this).parent('div').find(".stock-quantity").val();

            count--;
            document.getElementById('count').value = count;
            $('#item').append('<option value="'+itemId+'" stockQuantity="'+stockQuantity+'" itemPrice="'+itemPrice+'" itemName="'+itemName+'">'+itemName+'</option>');
            $(this).parent('div').remove(); //Remove field html
            if(count == 0){
              $('#itemHeader').remove();
              $('#itemSummary').remove();
            }
             //-----AJAX FOR ADJUSTING SUBTOTAL
            var salesOrderPrice = $('input[name="sales_order_price[]"]').map(function(){ 
                return this.value; 
            }).get();

            var qty = $('input[name="quantity[]"]').map(function(){ 
                return this.value; 
            }).get();

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url()?>sales_order/ajax_get_order_total_with_discount/',
                data: {
                    'sales_order_price[]': salesOrderPrice,
                    'quantity[]': qty,
                    // other data
                },
                success: function(data){
                    // Parse the returned json data
                    var resultSummary = $.parseJSON(data);
                    console.log(resultSummary);
                   document.getElementById('sub-total').value = resultSummary.sub_total;
                   document.getElementById('discount-summary').value = resultSummary.discount;
                   document.getElementById('total-price').value = resultSummary.total_price;
                }
            });     //-----END AJAX FOR ADJUSTING SUBTOTAL

        });


         //-----AJAX FOR ADJUSTING SUBTOTAL
       $('#create').on('keyup', '.qty', function(e){ //Once remove button is clicked
          
                var salesOrderPrice = $('input[name="sales_order_price[]"]').map(function(){ 
                    return this.value; 
                }).get();

                var qty = $('input[name="quantity[]"]').map(function(){ 
                    return this.value; 
                }).get();

                var discount = document.getElementById('discount').value;

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url()?>sales_order/ajax_get_order_total_with_discount/',
                    data: {
                        'sales_order_price[]': salesOrderPrice,
                        'quantity[]': qty,
                        'discount' : discount,
                        // other data
                    },
                    success: function(data){
                        // Parse the returned json data
                        var resultSummary = $.parseJSON(data);
                        console.log(resultSummary);
                       document.getElementById('sub-total').value = resultSummary.sub_total;
                       document.getElementById('discount-summary').value = resultSummary.discount;
                       document.getElementById('total-price').value = resultSummary.total_price;
                    }
                });


          });
        //-----END AJAX FOR ADJUSTING SUBTOTAL


        //-----AJAX FOR ADJUSTING SUBTOTAL  with DISCOUNT
       $('#discount-div').on('keyup', '.discount', function(e){ //Once remove button is clicked
          
                var salesOrderPrice = $('input[name="sales_order_price[]"]').map(function(){ 
                    return this.value; 
                }).get();

                var qty = $('input[name="quantity[]"]').map(function(){ 
                    return this.value; 
                }).get();

                var discount = document.getElementById('discount').value;

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url()?>sales_order/ajax_get_order_total_with_discount/',
                    data: {
                        'sales_order_price[]': salesOrderPrice,
                        'quantity[]': qty,
                        'discount': discount,
                        // other data
                    },
                    success: function(data){
                        // Parse the returned json data
                        var resultSummary = $.parseJSON(data);
                        console.log(resultSummary);
                       document.getElementById('sub-total').value = resultSummary.sub_total;
                       document.getElementById('discount-summary').value = resultSummary.discount;
                       document.getElementById('total-price').value = resultSummary.total_price;
                    }
                });


          });
        //-----END AJAX FOR ADJUSTING SUBTOTAL

</script>


<?php } ?>