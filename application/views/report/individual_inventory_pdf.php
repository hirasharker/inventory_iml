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
                <label>Opening Stock : <?php echo $opening_purchase_quantity-$opening_sales_quantity;?></label>
                <br/>
                <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                    <thead>
                        <tr>
                            <th class="text-center">Purchase</th>
                            <th class="text-center">Sales</th>
                            <th class="text-center">Closing Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="gradeA">
                            <td>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($purchase_data as $value){?>
                                        <tr class="gradeA">
                                            <td><?php echo $value->purchase_date;?></td>
                                            <td><?php echo $value->quantity;?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Customer</th>
                                            <th class="text-center">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($sales_data as $value){?>
                                        <tr class="gradeA">
                                            <td><?php echo $value->sales_date;?></td>
                                            <td><?php echo $value->customer_name;?></td>
                                            <td><?php echo $value->quantity;?></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Rate</th>
                                            <th class="text-center">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <tr class="gradeA">
                                            <td><?php echo $stock;?></td>
                                            <td><?php echo $item_rate;?></td>
                                            <td><?php echo $stock*$item_rate;?></td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

