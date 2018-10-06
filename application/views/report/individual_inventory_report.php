<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Inventory Report <small>Individual Item</small>
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
   
<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                 Inventory Report for single item..
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-lg-6">
                        <form method="post" action="<?php echo base_url()?>inventory/individual_inventory_pdf" target="_blank">
                           <div class="form-group">
                                <label>Select Item</label>
                                <select class="form-control select-tag" id="itemId" name="item_id" required>
                                    <option value="">select</option>
                                <?php foreach($item_list as $value){?>
                                    <option value="<?php echo $value->item_id; ?>"><?php echo $value->part_no.' - '.$value->item_name;?></option>
                                <?php }?>
                                </select>
                            </div>

                           
                            <label>Select Date</label>
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6">
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="text" class="form-control" value="<?php echo date("Y/m/d");?>" id="datepicker" name="from_date" placeholder="From" required>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                    <label style="color:#F00;font-size:10px;"><?php echo form_error('from_date');?></label> 
                                </div>
                                <div class="form-group col-lg-6 col-md-6">
                                    <div class="input-group date" data-provide="datepicker">
                                        <input type="text" class="form-control" value="<?php echo date("Y/m/d");?>" id="datepicker2" name="to_date" placeholder="To" required>
                                        <div class="input-group-addon">
                                            <span class="glyphicon glyphicon-th"></span>
                                        </div>
                                    </div>
                                    <label style="color:#F00;font-size:10px;"><?php echo form_error('to_date');?></label> 
                                </div>
                            </div>
                           
                            <!-- <label>purchase Date</label>
                            <div class="input-group date" data-provide="datepicker">
                                <input type="text" class="form-control"  id="datepicker" name="purchase_date" required>
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div> -->
                            <!-- <label style="color:#F00;font-size:10px;"><?php echo form_error('purchase_date');?></label> -->
                            <br/>
                            <button type="button" class="btn btn-primary" id="search">Search</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                            <button type="submit" class="btn btn-default"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Pdf</button>

                        </form>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->
                <br/>

                <div class="table-responsive" id="table-container">
                    
                </div>
            </div>
        </div>
        <!--End Advanced Tables -->
    </div>
</div>
    <!-- /. ROW  -->

<script>
    // $(function(){
    //   $("#itemId").autocomplete({
    //     source: "<?php echo base_url();?>inventory/generate_item_name/"// path to the get_birds method
    //   });
    // });
</script>

<script>
        $( "#search" ).click(function() {
          // alert( "Handler for .click() called." );
            var itemId=document.getElementById('itemId').value;
            var fromDate=document.getElementById('datepicker').value;
            var toDate=document.getElementById('datepicker2').value;
            $.ajax({
                url: '<?php echo base_url();?>inventory/generate_individual_inventory_detail',
                type:'POST',
                dataType: 'json',
                data: {item_id : itemId, from_date : fromDate, to_date : toDate},
                success: function(output){
                    $("#table-container").html(output);
                } // End of success function of ajax form
            }); // End of ajax call
        });
      
</script>