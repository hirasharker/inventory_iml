<table class="table table-striped table-bordered table-hover text-center" id="datatable-buttons1">
    <thead>
        <tr>
            <th class="text-center">Claim ID</th>
            <th class="text-center">Invoice No</th>
            <th class="text-center">Customer Name</th>
            <th class="text-center">Item Name</th>
            <th class="text-center">Type of Warranty</th>
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
            <td>
            <?php 
            foreach ($warranty_claim_type_list as $wt_value) {
               if($wt_value->warranty_claim_type_id == $wc_value->warranty_claim_type_id){
                echo $wt_value->warranty_claim_type_name;
               }
            }
            ?>
            </td>
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