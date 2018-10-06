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
                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        
                        <tr>
                            <th style="vertical-align:middle; text-align:center;">Date</th>
                            <th style="vertical-align:middle; text-align:center;">Customer</th>
                            <th style="vertical-align:middle; text-align:center;">Product</th>
                            <th style="vertical-align:middle; text-align:center;">Qty</th>
                            <th style="vertical-align:middle; text-align:center;">Rate</th>
                            <th style="vertical-align:middle; text-align:center;">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($sales as $s_value){?>
                       <tr>
                          <td style="vertical-align:middle; text-align:center;"><?php echo $s_value->sales_date;?></td>
                          <td style="vertical-align:middle; text-align:center;"><?php echo $s_value->customer_name;?></td>
                          <td style="vertical-align:middle; text-align:center;"><?php echo $s_value->item_name;?></td>
                          <td style="vertical-align:middle; text-align:center;"><?php echo $s_value->quantity?></td>
                          <td style="vertical-align:middle; text-align:center;"><?php echo $s_value->item_rate;?></td>
                          <td style="vertical-align:middle; text-align:center;"><?php echo $s_value->item_rate*$s_value->quantity;?></td>
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





