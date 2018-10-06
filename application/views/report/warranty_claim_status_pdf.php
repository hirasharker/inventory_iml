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
                <table class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                    <thead>
                        <tr>
                            <th class="text-center">Claim ID</th>
                            <th class="text-center">Invoice No</th>
                            <th class="text-center">Customer Name</th>
                            <th class="text-center">Item Name</th>
                            <th class="text-center">Buyer Complain</th>
                            <th class="text-center">Analysis</th>
                            <th class="text-center">Claim Date</th>
                            <th class="text-center">Sales Date</th>
                            <th class="text-center">Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($warranty_claim_status_list as $wc_value){?>
                        <tr class="gradeA">
                            <td><?php echo $wc_value->warranty_claim_id; ?></td>
                            <td><?php echo $wc_value->sales_id; ?></td>
                            <td>
                            <?php
                            if($wc_value->customer_id != ''){
                                echo $wc_value->customer_name; 
                            }
                            
                            if($wc_value->dealer_id != ''){
                                echo $wc_value->dealer_name; 
                            }
                            ?>
                            </td>
                            <td><?php echo $wc_value->item_name; ?></td>
                            <td><?php echo $wc_value->buyer_complain; ?></td>
                            <td><?php echo $wc_value->observation_note; ?></td>
                            <td><?php echo $wc_value->warranty_claim_date; ?></td>
                            <td><?php echo $wc_value->sales_date; ?></td>
                            <td>
                            <?php
                            if($wc_value->comment_1 != '') {
                                echo $wc_value->comment_1; 
                            }

                            if($wc_value->comment_2 != '') {
                                echo $wc_value->comment_2; 
                            }

                            if($wc_value->comment_3 != '') {
                                echo $wc_value->comment_3; 
                            }
                            ?>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

