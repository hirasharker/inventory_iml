<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventory Group Report by Hira Sharker</title>
    <!-- Bootstrap Styles-->
    <link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <!-- <link href="<?php echo base_url();?>assets/css/font-awesome.css" rel="stylesheet" /> -->
    <!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css"> -->
        <!-- Custom Styles-->
    <!-- <link href="<?php echo base_url();?>assets/css/custom-styles.css" rel="stylesheet" /> -->
 
</head>
<body>
    <div id="wrapper">
        <div id="page-wrapper" >
            <div class="row">
                <table class="table table-striped table-bordered table-hover text-center" >
                    <thead>
                        <tr>
                            <th class="text-center" colspan="2">Item Detail</th>
                            <th class="text-center">Purchase</th>
                            <th class="text-center">Sales</th>
                            <th class="text-center" colspan="3">Closing Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="gradeA">
                            <th class="text-center">Item ID</th>
                            <th class="text-center">Item Name</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Rate</th>
                            <th class="text-center">Value</th>
                        </tr>

                       <?php foreach($item_data as $i_value){?>
                        <tr class="gradeA">
                            
                            <td class="text-center"><?php echo $i_value->item_id?></td>

                            <td class="text-center"><?php echo $i_value->item_name?></td>
                            
                            <?php $purchase_quantity = 0; foreach($purchase_data as $p_value){ if($p_value->item_id == $i_value->item_id){
                                $purchase_quantity  =   $p_value->purchase_quantity;
                            } }?>

                            <td class="text-center"><?php echo $purchase_quantity;?></td>
                           
                            <?php $sales_quantity = 0; foreach($sales_data as $s_value){if($i_value->item_id == $s_value->item_id){
                                $sales_quantity     =   $s_value->sales_quantity;  
                            }}?>

                            <td><?php echo $sales_quantity; ?></td>

                            <?php $purchase_quantity = 0; $sales_quantity= 0;
                                foreach($total_purchase_quantity as $p_value){
                                    if($i_value->item_id == $p_value->item_id){ $purchase_quantity = $p_value->total_purchase_quantity;}
                                }
                                foreach($total_sales_quantity as $s_value){
                                    if($i_value->item_id == $s_value->item_id){ $sales_quantity = $s_value->total_sales_quantity;}
                                }
                            ?>

                            <td class="text-center"><?php echo $stock = $purchase_quantity-$sales_quantity?></td>
                           
                            <td class="text-center"><?php echo $i_value->item_price;?></td>
                            <td class="text-center"><?php echo $i_value->item_price * $stock;?></td>
                        </tr>
                        <?php }?> 
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</body>

<script>
      
     
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>


</html>





