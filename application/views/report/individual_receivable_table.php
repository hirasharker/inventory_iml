<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
            <tr>
                <th>SL</th>
                <th>Invoice No</th>
                <th>Money Receipt No</th>
                <th>Customer Name</th>
                <th>Date</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; $balance = 0; foreach($sales_data as $value){$balance = $value->total_price;?>
            <tr class="gradeA">
                <td><?php echo $i; ?></td>
                <td><a href="<?php echo base_url().'sales/sales_invoice/'.$value->sales_id;?>" target="_blank"><?php echo $value->sales_id;?></a></td>
                <td>---</td>
                <td>
                <?php if($value->customer_id!=0){?>
                    <a href="<?php echo base_url().'customer/index/'.$value->customer_id;?>" target="_blank"><?php echo $value->customer_name;?></a>
                <?php }?>
                <?php if($value->dealer_id!=0){?>
                    <a href="<?php echo base_url().'dealer/index/'.$value->dealer_id;?>" target="_blank"><?php echo $value->dealer_name;?></a>
                <?php }?>
                </td>
                <td><?php echo $value->sales_date;?></td>
                <td><?php echo $value->total_price;?></td>
                <td>---</td>
                <td class="center"><?php echo $balance;?></td>
            </tr>
                <?php foreach($money_receipt_data as $mr_value){?>
                <?php if($value->customer_id == $mr_value->customer_id || $value->dealer_id == $mr_value->dealer_id){ $i++; ?>
                <tr class="gradeA">
                    <td><?php echo $i; ?></td>
                    <td>---</td>
                    <td><a href="<?php echo base_url().'money_receipt/index/'.$mr_value->money_receipt_id;?>" target="_blank"><?php echo $mr_value->money_receipt_id;?></td>
                    <td>
                    <?php if($value->customer_id!=0){?>
                        <a href="<?php echo base_url().'customer/index/'.$value->customer_id;?>" target="_blank"><?php echo $value->customer_name;?></a>
                    <?php }?>
                    <?php if($value->dealer_id!=0){?>
                        <a href="<?php echo base_url().'dealer/index/'.$value->dealer_id;?>" target="_blank"><?php echo $value->dealer_name;?></a>
                    <?php }?>
                    </td>
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