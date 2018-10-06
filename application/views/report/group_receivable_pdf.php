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
                            <th>SL</th>
                            <th>Sales Order No</th>
                            <th>Invoice No</th>
                            <th>Money Receipt No</th>
                            <th>Dealer</th>
                            <th>Customer</th>
                            <th>Date</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; $balance = 0; foreach($sales as $value){$balance = $value->total_price;?>
                        <tr class="gradeA">
                            <td><?php echo $i; ?></td>
                            <td><?php echo $value->sales_order_id; ?></td>
                            <td><?php echo $value->sales_id;?></td>
                            <td>---</td>
                            <td><?php echo $value->dealer_name; ?></td>
                            <td><?php echo $value->customer_name;?></td>
                            <td><?php echo $value->sales_date;?></td>
                            <td><?php echo $value->total_price;?></td>
                            <td>---</td>
                            <td class="center"><?php echo $balance;?></td>
                        </tr>
                            <?php foreach($money_receipt as $mr_value){?>
                            <?php if($value->sales_id == $mr_value->sales_id || $value->sales_order_id == $mr_value->sales_order_id){ $i++; ?>
                            <tr class="gradeA">
                                <td><?php echo $i; ?></td>
                                <td>---</td>
                                <td>---</td>
                                <td><?php echo $mr_value->money_receipt_id;?></td>
                                <td><?php echo $mr_value->dealer_name;?></td>
                                <td><?php echo $mr_value->customer_name;?></td>
                                <td><?php echo $mr_value->money_receipt_date;?></td>
                                <td>---</td>
                                <td><?php echo $mr_value->received_amount;?></td>
                                <td class="center"><?php echo $balance = $balance - $mr_value->received_amount;?></td>
                            </tr>
                            <?php }}?>
                        <?php $i++; }?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</body>

<script>
      
     
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>


</html>





