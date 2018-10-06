<?php if($purchase==NULL){?>
<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Add purchase invoice <small>add new purchase entry..</small>
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
  <div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Insert purchase Information..
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <?php echo form_open_multipart('purchase/add_purchase');?>
                        <!-- <form role="form" method="post" action="<?php echo base_url();?>purchase/add_purchase"> -->
                            <div class="form-group">
                                <label>Invoice No</label>
                                <input class="form-control" placeholder = "Invoice No" name="purchase_id" required type="number" maxlength="9">
                            </div>

                            <div class="form-group">
                                <label>Add Item</label>
                                <select class="form-control" id="itemInsertionMode" name="item_insertion_mode" >
                                    <option value="1">Manual Entry</option>
                                    <option value="2">Upload List</option>
                                </select>
                            </div>

                            <div class="form-group" id="manuallyAddItem">
                                <label>Select Item</label>
                                <select class="form-control select-tag" id="item" name="item_id" >
                                    <option value="">select</option>
                                <?php foreach($item_list as $value){?>
                                    <option value="<?php echo $value->item_id; ?>" itemName="<?php echo $value->item_name;?>"><?php echo $value->part_no." - ".$value->item_name;?></option>
                                <?php }?>
                                </select>
                            </div>

                            <div class="form-group" id="uploadItem" style="display:none;">
                                <label>Upload List</label>
                                <input type="file" class="form-control" placeholder="" name="purchase_list">
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
                                <label>Select vendor</label>
                                <select class="form-control" name="vendor_id">
                                    <?php foreach($vendor_list as $value){?>
                                    <option value="<?php echo $value->vendor_id; ?>"><?php echo $value->vendor_name;?></option>
                                <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select warehouse</label>
                                <select class="form-control" name="warehouse_id">
                                    <?php foreach($warehouse_list as $value){?>
                                    <option value="<?php echo $value->warehouse_id; ?>"><?php echo $value->warehouse_name;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Discount (%)</label>
                                <input class="form-control" placeholder = "Discount" name="purchase_discount" type="number" step=".01" min="0" max="100">
                            </div>
                            <label>purchase Date</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" class="form-control"  id="datepicker" name="purchase_date" required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                            <label style="color:#F00;font-size:10px;"><?php echo form_error('purchase_date');?></label>
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
         
                count = document.getElementById('count').value;
                if(count == 0){
                    var itemHeader  = '<div class="col-lg-12" style="margin-bottom: 10px;border-bottom: 2px solid #09192a;" id="itemHeader">'
                    +'<div class="col-lg-4"><label class="lblItem">Name</label></div>'
                    +'<div class="col-lg-4"><label class="lblItem">Price</label></div>'
                    +'<div class="col-lg-3"><label class="lblItem">QTY</label></div>'
                    +'</div>';
                    
                    $('#create').append(itemHeader);
                  }
                // var itemName = $('#item option:selected').text();
                var element = $(this).find('option:selected'); 
                var itemName = element.attr("itemName");
                var val = $('#item option:selected').val();
                // alert(val);
                if(val!=''){
                      $.ajax({
                            url: '<?php echo base_url();?>purchase/ajax_count_item',
                            type:'POST',
                            dataType: 'json',
                            data: {count : count},
                            success: function(error_message){
                                    $('#quantity-error').html(error_message);
                                } // End of success function of ajax form
                      }); // End of ajax call
                      count++;
                      var code = '<div class="col-lg-12" style="margin-bottom: 10px"><div class="col-lg-4"><label class="lblItem">'
                      +itemName+'</label><input class="form-control item-id" type="hidden" name="item_id[]" value="'+this.value+'">'
                      +'<input class="form-control" type="hidden" name="item_name[]" value="'+itemName+'">'
                      +'</div><div class="col-lg-4">'
                      +'<input class="form-control" placeholder = "Price" name="purchase_price[]" required></div><div class="col-lg-3">'
                      +'<input class="form-control" placeholder = "QTY" name="quantity[]" required></div>'
                      +'<a href="" class="col-lg-1 remove"><i class="fa fa-times fa-lg text-danger" aria-hidden="true"></i></a></div>';
                            $('#create').append(code);
                              document.getElementById('count').value = count;
                      $("#item option[value='"+this.value+"']").remove();
              }
          
        });

       $('#create').on('click', '.remove', function(e){ //Once remove button is clicked
            e.preventDefault();
             var itemName = $(this).parent('div').find(".lblItem").text();
             var itemId = $(this).parent('div').find('.item-id').val();
             // alert(itemId);
             count--;
             document.getElementById('count').value = count;
            $('#item').append('<option value="'+itemId+'">'+itemName+'</option>');
            $(this).parent('div').remove(); //Remove field html

            if(count == 0){
              $('#itemHeader').remove();
            }

        });

       $( "#itemInsertionMode" ).change(function() {
          // alert( "Handler for .change() called."+this.value);
          var val = $('#itemInsertionMode option:selected').val();
          if(val == 1){
            $( "#manuallyAddItem" ).show( 500 );
            $( "#uploadItem" ).hide( 500 );
          }else if (val == 2){
            $( "#uploadItem" ).show( 500 );
            $( "#manuallyAddItem" ).hide( 500 );
          }else {
            $( "#uploadItem" ).hide( 500 );
            $( "#manuallyAddItem" ).hide( 500 );
          }

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
                        <form role="form" method="post" action="<?php echo base_url();?>purchase/update_purchase/<?php echo $purchase->purchase_id;?>">

                         <!-- <form role="form" method="get" action="#"> -->
                            <div class="form-group">
                                <label>Invoice No</label>
                                <input class="form-control" placeholder = "Invoice No" name="purchase_id" required type="number" value="<?php echo $purchase->purchase_id; ?>" style="disabled: true;" maxlength="9">
                            </div>
                            <div class="form-group">
                                <label>Select Item</label>
                                <select class="form-control select-tag" id="item" name="item_id">
                                    <option>select</option>
                                <?php foreach($item_list as $value){?>
                                    <option value="<?php echo $value->item_id; ?>" itemName="<?php echo $value->item_name;?>"><?php echo $value->item_name;?></option>
                                <?php }?>
                                </select>
                            </div>
                            <?php if($error_content!=NULL){?>
                            <?php for($i=0; $i<$error_content; $i++){?>
                            <label style="color:#F00;font-size:10px;"><?php echo form_error('quantity['.$i.']');?> </label>
                            <?php }}?>
                            <div class="col-lg-12" id="create">
                            <label style="color:#F00;font-size:10px;"><?php echo form_error('purchase_price[]');?></label>
                            <br/>
                                <input type="hidden" id="count" value="0" name="count">
                            </div>

                            <div class="form-group">
                                <label>Select vendor</label>
                                <select class="form-control" name="vendor_id">
                                    <?php foreach($vendor_list as $value){?>
                                    <option <?php if($purchase->vendor_id==$value->vendor_id){ echo "selected";}?> value="<?php echo $value->vendor_id; ?>"><?php echo $value->vendor_name;?></option>
                                <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Select warehouse</label>
                                <select class="form-control" name="warehouse_id">
                                    <?php foreach($warehouse_list as $value){?>
                                    <option <?php if($purchase->warehouse_id==$value->warehouse_id){ echo "selected";}?> value="<?php echo $value->warehouse_id; ?>"><?php echo $value->warehouse_name;?></option>
                                <?php }?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Discount (%)</label>
                                <input class="form-control" placeholder = "Discount" name="purchase_discount" type="number" step=".01" min="0" max="100" value="<?php echo $purchase->purchase_discount;?>">
                            </div>
                            <label>purchase Date</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" class="form-control"  id="datepicker" name="purchase_date" value="<?php echo $purchase->purchase_date;?>" required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                            <label style="color:#F00;font-size:10px;"><?php echo form_error('purchase_date');?></label>
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
    <?php foreach($purchase_detail as $value){?>
        // alert(<?php echo json_encode($value->item_name);?>);
        // alert( "Handler for .change() called."+this.value);
        var itemName = <?php echo json_encode($value->item_name);?>;
        count = document.getElementById('count').value;

        if(count == 0){
            var itemHeader  = '<div class="col-lg-12" style="margin-bottom: 10px;border-bottom: 2px solid #09192a;" id="itemHeader">'
            +'<div class="col-lg-4"><label class="lblItem">Name</label></div>'
            +'<div class="col-lg-4"><label class="lblItem">Price</label></div>'
            +'<div class="col-lg-3"><label class="lblItem">QTY</label></div>'
            +'</div>';
            
            $('#create').append(itemHeader);
          }

        count++;
        var code = '<div class="col-lg-12" style="margin-bottom: 10px"><div class="col-lg-4"><label class="lblItem">'
        +itemName+'</label><input class="form-control item-id" type="hidden" name="item_id[]" value="'+<?php echo json_encode($value->item_id);?>+'">'
        +'<input class="form-control" type="hidden" name="item_name[]" value="'+itemName+'">'
        +'</div><div class="col-lg-4">'
        +'<input class="form-control" placeholder = "Price" name="purchase_price[]" value="'+<?php echo json_encode($value->purchase_price);?>+'" required></div><div class="col-lg-3">'
        +'<input class="form-control" placeholder = "QTY" name="quantity[]" value="'+<?php echo json_encode($value->quantity);?>+'" required></div>'
        +'<a href="" class="col-lg-1 remove"><i class="fa fa-times fa-lg text-danger" aria-hidden="true"></i></a></div>';

        $('#create').append(code);
        document.getElementById('count').value = count;

        $("#item option[value='"+<?php echo json_encode($value->item_id);?>+"']").remove();
    <?php } ?>  
      
</script>

<script>
        $( "#item" ).change(function() {
          // alert( "Handler for .change() called."+this.value);
          var element = $(this).find('option:selected'); 
          var itemName = element.attr("itemName");

          // var itemName = $('#item option:selected').text();
          count = document.getElementById('count').value;

          if(count == 0){
            var itemHeader  = '<div class="col-lg-12" style="margin-bottom: 10px;border-bottom: 2px solid #09192a;" id="itemHeader">'
            +'<div class="col-lg-4"><label class="lblItem">Name</label></div>'
            +'<div class="col-lg-4"><label class="lblItem">Price</label></div>'
            +'<div class="col-lg-3"><label class="lblItem">QTY</label></div>'
            +'</div>';
            
            $('#create').append(itemHeader);
          }

          var val = $('#item option:selected').val();
          if(val!=0){
            count++;
            var code = '<div class="col-lg-12" style="margin-bottom: 10px"><div class="col-lg-4"><label class="lblItem">'
            +itemName+'</label><input class="form-control item-id" type="hidden" name="item_id[]" value="'+this.value+'">'
            +'<input class="form-control" type="hidden" name="item_name[]" value="'+itemName+'">'
            +'</div><div class="col-lg-4">'
            +'<input class="form-control" placeholder = "Price" name="purchase_price[]" required></div><div class="col-lg-3">'
            +'<input class="form-control" placeholder = "QTY" name="quantity[]" required></div>'
            +'<a href="" class="col-lg-1 remove"><i class="fa fa-times fa-lg text-danger" aria-hidden="true"></i></a></div>';

                  $('#create').append(code);
                    document.getElementById('count').value = count;

            $("#item option[value='"+this.value+"']").remove();

        }
          
        });

       $('#create').on('click', '.remove', function(e){ //Once remove button is clicked
            e.preventDefault();
             var itemName = $(this).parent('div').find(".lblItem").text();
             var itemId = $(this).parent('div').find('.item-id').val();
             // alert(itemId);
             count--;
             document.getElementById('count').value = count;
            $('#item').append('<option value="'+itemId+'">'+itemName+'</option>');
            $(this).parent('div').remove(); //Remove field html

            if(count == 0){
              $('#itemHeader').remove();
            }
        });

</script>


<?php } ?>