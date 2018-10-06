/*------------------------------------------------------
    Author : Hira Sharker
---------------------------------------------------------  */

$( "#customerType" ).change(function() {
  resetForm();
  var val = $('#customerType option:selected').val();
  if(val == 1){
    $( "#dealer" ).show( 500 );
    $( "#customer" ).hide( 500 );
    $( "#salesOrderId" ).hide(500);
    $( "#customerId" ).val("");
    $( "#orderId" ).val("");
  }else if (val == 2){
    $( "#customer" ).show( 500 );
    $( "#dealer" ).hide( 500 );
    $( "#salesOrderId" ).hide(500);
    $( "#dealerId" ).val("");
    $( "#orderId" ).val("");
  }else if (val == 4){
    $( "#salesOrderId" ).show(500);
  }else {
    $( "#customer" ).hide( 500 );
    $( "#dealer" ).hide( 500 );
    $( "#salesOrderId" ).hide(500);
    $( "#customerId" ).val("");
    $( "#dealerId" ).val("");
  }
}); // customerType.change..........

$("#salesAgainstOrder").click( function(){
  if( $(this).is(':checked') ) {
    $('#customerType').val('');
    $('#customerType').prop('disabled',true);
    resetForm();
    disableInputFields();
    $( "#salesOrderId" ).show(500);
  }else {
    $('#customerType').val('');
    $('#customerType').prop('disabled',false);
    resetForm();
  }
   

});


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
        var code = '<div class="col-lg-12" style="margin-bottom: 10px"><div class="col-lg-4"><label class="lblItem">'
        +itemName+'</label><input class="form-control item-id" type="hidden" name="item_id[]" value="'+this.value+'">'
        +'<input class="form-control" type="hidden" name="item_name[]" value="'+itemName+'">'
        +'</div><div class="col-lg-2">'
        +'<input class="form-control item-price" placeholder = "Price" name="sales_price[]" value="'+itemPrice+'" required type="hidden" >'
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
  
}); //item.change..............



$( "#orderId" ).change(function() {
  // alert( "Handler for .change() called.");
  var orderId = $('#orderId option:selected').val();
  if(orderId != ''){

    count = document.getElementById('count').value;

    $('#create').empty();

    $('#create').append('<div id="quantity-error"></div><input type="hidden" id="count" value="0" name="count">');

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

    getSalesOrder(orderId);
    getSalesOrderDetail(orderId);

   
  }else {
    resetForm();
    disableInputFields();
     $('#salesOrderId').show("500");
  }

}); //orderId.change................



$( ".reset" ).click(function() {
  resetForm();
});






function processSalesOrder(salesOrder){
  $('#warehouseId').val(salesOrder.warehouse_id);
  $('#discount').val(salesOrder.overall_discount);
  $( "#orderDateContainer" ).show( 500 );
  $('#orderDate').val(salesOrder.sales_order_date);
  if(salesOrder.customer_id!= "0"){
    $('#customerId').val(salesOrder.customer_id);
    $('#customerId').trigger('change');
    $( "#customer" ).show( 500 );
  }else{
    $( "#customer" ).hide( 500 );
    $('#customerId').val("0");
    $('#customerId').trigger('change');
  }
  if(salesOrder.dealer_id!= "0"){
    $( "#dealer" ).show( 500 );
    $('#dealerId').val(salesOrder.dealer_id);
    $('#dealerId').trigger('change');
  }else{
    $( "#dealer" ).hide( 500 );
    $('#dealerId').val("0");
    $('#dealerId').trigger('change');
  }
  $('#sub-total').val(salesOrder.total_price);
 
}
function resetForm(){
  setDefaultValue();
  enableInputFields();
}

function disableInputFields(){
  $('#warehouseId').prop('disabled',true);
  $('#discount').prop('readonly',true);
  $('#orderDate').prop('disabled',true);
  $('#customerId').prop('disabled',true);
  $('#dealerId').prop('disabled',true);
  $('#item').prop('disabled',true);
}

function enableInputFields(){
  $('#warehouseId').prop('disabled',false);
  $('#discount').prop('readonly',false);
  $('#customerId').prop('disabled',false);
  $('#dealerId').prop('disabled',false);
  $('#item').prop('disabled',false);
}

function setDefaultValue (){
  $('#orderId').val('');
  // $('#orderId').trigger('change');
  $('#warehouseId').val('');
  $('#discount').val('0');
  $('#datepicker').val('');
  $('#customerId').val('0');
  $('#customerId').trigger('change');
  $('#dealerId').val('0');
  $('#dealerId').trigger('change');
  $('#item').val('0');
  $("#customer").hide( 500 );
  $("#dealer").hide( 500 );
  $("#salesOrderId").hide( 500 );
  $("#orderDateContainer").hide( 500 );

  $('#create').empty();

  $('#create').append('<div id="quantity-error"></div><input type="hidden" id="count" value="0" name="count">');

  $('#itemSummary').remove();
}






