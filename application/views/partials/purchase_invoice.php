<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    
    <title>Editable Invoice</title>
    
    <link rel='stylesheet' type='text/css' href='<?php echo base_url();?>assets/invoice_css/style.css' />
    <link rel='stylesheet' type='text/css' href='<?php echo base_url();?>assets/invoice_css/print.css' media="print" />
    

</head>

<body>

    <div id="page-wrap">

        <div id="header" >INVOICE</div>
        
        <div id="new">
                <table class="header" border="0">
                 <tr>
                     <td>
                         Sold to :<br/>
            <p id="address"><strong><?php echo 'Customer Name '.'<br/>'; ?></strong>
<?php echo 'Customer_address'.'<br/>'.'Address Line2'.'<br/>'.'Phone: ';?>
</p>
                     </td>
                     
                     <td width="400px">
            
                     </td>
                     <td>
            <p id="address"><?php echo 'Contact Address'?></p>
                     </td>
                 </tr>
                 <tr>
                     <td>
                         <br/>
                         Bill to :
                     </td>
                 </tr>
                 
                
                 <tr>
                        <p> <strong><?php echo 'Billing Address';?></strong>
                            <?php echo 'Address Line 1'.'<br/>'.'City'.'-'.'City'.', '.'Country'.'<br/>'.'Phone: ';?>
                        </p>
                     </td>
                     
                     <td width="400px">
            
                     </td>
                     
                     
                 </tr>
               
                 
             </table>

            <div id="logo">

              <img id="image" src="<?php echo base_url()?>image/<?php echo 'LOGO';?>" alt="logo" width="200px" height="80px" />
            </div>
        
        </div>
        
        <div style="clear:both"></div>
         <p id="customer-title"><?php echo 'Customer Name';?><br/>
c/o <?php echo 'Customer Name' ;?><br/></p>
        <div id="customer">

           

            
                    
             <table id="meta">
                <tr>
                    <td class="meta-head">Invoice #</td>
                    <td><p>000<?php echo 'Invoice No';?></p></td>
                </tr>
                <tr>

                    <td class="meta-head">Date</td>
                    <td><p id="date"><?php echo date('F').' '.date('d');?> <?php echo date('Y');?></p></td>
                </tr>
                <tr>
                    <td class="meta-head">Amount Due</td>
                    <td><div class="due">Tk. <?php echo 'Order Total';?></div></td>
                </tr>

            </table>
        
        </div>
        
        <table id="items">
        
          <tr>
              <th>Item</th>
              <th>Description</th>
              <th>Unit Cost</th>
              <th>Quantity</th>
              <th>Price</th>
          </tr>
          <tr class="item-row">
              <td class="item-name"><p><?php echo 'Item Name';?></p><a class="delete"  title="Remove row"></a></td>
              <td class="description"><p><?php echo trim('Description').'(SN: 0000'.'SN'.')'; ?></p></td>
              <td><p class="cost">Tk. <?php echo 'product price';?></p></td>
              <td><p class="qty"><?php echo 'quantity'?></p></td>
              <td><span class="price">Tk. <?php echo 'Price'?></span></td>
          </tr>
          
          <tr id="hiderow">
            <td colspan="5"><a id="addrow" href="<?php echo base_url();?>" title=""><?php echo base_url();?></a></td>
          </tr>
          
          <tr>
              <td colspan="2" class="blank"> </td>
              <td colspan="2" class="total-line">Subtotal</td>
              <td class="total-value"><div id="subtotal">Tk. 'Subtotal';?></div></td>
          </tr>
          <tr>

              <td colspan="2" class="blank"> </td>
              <td colspan="2" class="total-line">Total</td>
              <td class="total-value"><div id="total">Tk. <?php echo 'Total';?></div></td>
          </tr>
          <tr>
              <td colspan="2" class="blank"> </td>
              <td colspan="2" class="total-line">Amount Paid</td>

              <td class="total-value"><p id="paid">Tk. 0.00</p></td>
          </tr>
          <tr>
              <td colspan="2" class="blank"> </td>
              <td colspan="2" class="total-line balance">Balance Due</td>
              <td class="total-value balance"><div class="due">Tk. <?php echo 'Order Total';?></div></td>
          </tr>
        
        </table>
        
        <div id="terms">
          <h5>Terms</h5>
          <p>To return sold item you have to bring this invoice or remember invoice no within 30 days.</p>
        </div>
    
    </div>
    
</body>

</html>