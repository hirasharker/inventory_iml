<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Payables <small></small>
        </h1>
    </div>
</div> 
 <!-- /. ROW  -->
   
<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                 <!-- purchase entries are listed here.. -->
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Purchase Invoice</th>
                                <th>Payment Id</th>
                                <th>Vendor's Name</th>
                                <th>Date</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i=1; $balance = 0; foreach($purchase_list as $value){$balance = $value->total_price;?>
                            <tr class="gradeA">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $value->purchase_id;?></td>
                                <td>---</td>
                                <td><?php echo $value->vendor_name;?></td>
                                <td><?php echo $value->purchase_date;?></td>
                                <td>---</td>
                                <td><?php echo $value->total_price; ?></td>
                                <td class="center"><?php echo $balance; ?></td>
                            </tr>
                                <?php foreach($payment_list as $pmt_value){?>
                                <?php if($value->purchase_id == $pmt_value->purchase_id){ $i++; ?>
                                <tr class="gradeA">
                                    <td><?php echo $i; ?></td>
                                    <td>---</td>
                                    <td><?php echo $pmt_value->payment_id;?></td>
                                    <td><?php echo $pmt_value->vendor_name;?></td>
                                    <td><?php echo $pmt_value->payment_date;?></td>
                                    <td><?php echo $pmt_value->paid_amount;?></td>
                                    <td>---</td>
                                    <td class="center"><?php echo $balance - $pmt_value->paid_amount;?></td>
                                </tr>
                                <?php }}?>
                            <?php $i++; }?>
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        <!--End Advanced Tables -->
    </div>
</div>
    <!-- /. ROW  -->
