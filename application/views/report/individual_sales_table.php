<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
        
        <tbody>
        <tr>
          <td colspan="5" style="margin:0 !important; padding:0 !important;">
            <table class="table table-striped table-bordered table-hover">
               <thead>
                  <tr>
                      <th rowspan="2" style="vertical-align:middle; text-align:center;">Date</th>
                      <th colspan="4" style="vertical-align:middle; text-align:center;">Sales</th>
                  </tr>
                  <tr>
                      <th style="vertical-align:middle; text-align:center;">Product</th>
                      <th style="vertical-align:middle; text-align:center;">Qty</th>
                      <th style="vertical-align:middle; text-align:center;">Rate</th>
                      <th style="vertical-align:middle; text-align:center;">Amount</th>
                  </tr>
              </thead>
             <?php foreach($sales as $s_value){?>
               <tr style="margin:0;padding:0;">
                  <td style="vertical-align:middle; text-align:center;"><?php echo $s_value->sales_date;?></td>
                  <td style="vertical-align:middle; text-align:center;"><?php echo $s_value->item_name;?></td>
                  <td style="vertical-align:middle; text-align:center;"><?php echo $s_value->quantity?></td>
                  <td style="vertical-align:middle; text-align:center;"><?php echo $s_value->item_rate;?></td>
                  <td style="vertical-align:middle; text-align:center;"><?php echo $s_value->item_rate*$s_value->quantity;?></td>
               </tr>
            <?php }?>
          </table>
           
          </td>
          <td colspan="3" style="margin:0 !important; padding:0 !important;">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                  <th colspan="2" style="vertical-align:middle; text-align:center;">Payment</th>
                  <th rowspan="2" style="vertical-align:middle; text-align:center;">Balance</th>
              </tr>
              <tr>
                  <th style="vertical-align:middle; text-align:center;">Date</th>
                  <th style="vertical-align:middle; text-align:center;">Amount</th>
              </tr>
            </thead>
            <?php $i=0; foreach($payments as $p_value){?>
               <tr style="margin:0;padding:0;">
                  <td style="vertical-align:middle; text-align:center;"><?php echo $p_value->money_receipt_date;?></td>
                  <td style="vertical-align:middle; text-align:center;"><?php echo $p_value->received_amount;?></td>
                  <td><?php if($i == 0 ){ echo $balance; } ?></td>
               </tr>
            <?php $i++; }?>
            </table>
          </td>
          
        </tr>
       
        </tbody>
    </table>
</div>