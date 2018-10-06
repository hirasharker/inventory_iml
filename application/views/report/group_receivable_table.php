<div class="table-responsive">
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