<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inventory Management by Hira Sharker</title>
    <!-- Bootstrap Styles-->
     <!-- FontAwesome Styles-->
    <link href="<?php echo base_url();?>assets/css/font-awesome.css" rel="stylesheet" />
        <!-- Custom Styles-->
    <link href="<?php echo base_url();?>assets/invoice_css/custom.css" rel="stylesheet" />
     <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
    <div id="wrapper">
      <h2>Sales Invoice</h2>
      <div id="header">
        <div class="left">
          <table border="0">
            <tr>
              <th rowspan="6" style="vertical-align:top;">Party Name: </th>
              <th style="padding-left: 10px; text-align: left;"><?php echo $customer->customer_name;?> </th>
            </tr>
            <tr>
              <td style="padding-left: 10px; text-align: left;"><?php echo $customer->address;?></td>
            </tr>
            <!-- <tr>
              <td style="padding-left: 10px; text-align: left;">Chittagong.</td>
            </tr> -->
            <tr>
              <td style="padding-left: 10px; text-align: left;">Phone: <?php echo $customer->phone_no;?></td>
            </tr>
          </table>
        </div>
        <div class="right">
          <table border="0">
            <tr>
              <td >Date: </td>
              <td style="padding-left: 10px;"><?php echo $sales->sales_date;?></td>
            </tr>
            <tr>
              <td>Invoice No:</td>
              <td style="padding-left: 10px;">Sl#000<?php echo $sales->sales_id;?></td>
            </tr>
          </table>
        </div>
      </div><!-- header -->
      <div id="content">
        <table>
          <tr>
            <th>SL #</th>
            <th>Name of the Item</th>
            <th>Quantity/Unit</th>
            <th>Rate<br/>(in BDT)</th>
            <th>Unit</th>
            <th>Disc./Unit <br/>(in BDT)</th>
            <th>Amount <br/>(in BDT)</th>
          </tr>
        <?php $i=1; $discount=0; foreach($sales_detail as $value){?>
          <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $value->item_name;?></td>
            <td><?php echo $value->quantity;?></td>
            <td><?php echo $value->sales_price;?></td>
            <td>Pcs</td>
            <td><?php echo $value->individual_discount;?></td>
            <td><?php echo ($value->sales_price*$value->quantity)-$value->individual_discount;?></td>
          </tr>
        <?php $i++;  $discount += $value->individual_discount;}?>
          
          <tr>
            <td colspan="2" style="text-align: right;"><b>Sub Total:</b></td>
            <td style="text-align: right;"><b><?php echo $sales->total_quantity;?> pcs</b></td>
            <td colspan="2" style="text-align: right;"><b>Dis.Amt.:</b></td>
            <td style="text-align: right;"><b><?php echo $discount;?></b></td>
            <td><b><?php echo $sales->sub_total;?></b></td>
          </tr>
          <tr>
            <td style="border-right: none"></td>
            <td style="text-align: right; width: 39.88%; border-left: none;"><b>Add &amp; Total:</b></td>
            <td  colspan="4" style="text-align: right; width: 42.3%">Sales Discount  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sales->overall_discount;?>%</td>
            <td  style="text-align: right;"><?php echo $sales->sub_total*$sales->overall_discount*.01;?></td>
          </tr>
          <tr>
            <td style="border-right: none"></td>
            <td style="text-align: right; width: 39.88%; border-left: none; border-right:none;"><b>Invoice Total:</b></td>
            <td  colspan="5" style="text-align: right; width: 53.24%; border-left: none;"><b><?php echo $sales->total_price;?></b></td>
          </tr>
        </table>
      </div>
      <div id="footer">
        <p>Amount Chargeable (in word): (in BDT) <?php echo $total_in_words;?> Only.</p>
        <table width="100%">
          <tr>
            <td style="width : 25%">Narration</td>
            <td style="width : 45%; text-align: right;">Total Current Bal: as on Dt <?php date_default_timezone_set('Asia/Dhaka'); echo date('jS \, F Y h:i:s');?>  &nbsp;&nbsp;&nbsp;</td>
            <td style="text-align: right; width:30%"><b><?php echo $balance?></b>&nbsp; Dr</td>
          </tr>
          <tr>
            <td colspan="2" style="width : 70%; padding-bottom: .4in; padding-top: .2in;"><b>For&nbsp;<?php echo $sales->customer_name;?></b></td>
            <td style="width : 30%; text-align: right;"><b>for My Company Limited</b></td>
          </tr>
        </table>
        <table width="100%">
           <tr>
            <td style="width : 15%; text-align: left; border-top: 2px solid #000;"><b>Customer Signature</b></td>
            <td style="width : 70%; color: #FFF">..........................................................................</td>
            <td style="width : 15%; text-align: center; border-top: 2px solid #000;">Authorised Signature</td>
          </tr>
        </table>
        <p>Declaration: SOLD GOODS ARE NOT TAKEN BACK, NB: THE PAYMENT BY CHEQUE ONLY</p>
      </div>
    </div><!-- wrapper -->
</body>

</html>