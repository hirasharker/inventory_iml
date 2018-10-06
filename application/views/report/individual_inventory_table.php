

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