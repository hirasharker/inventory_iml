<?php
        if($permission->permission_view!=1){
            redirect('sales_order/','refresh');   
        }
 ?>
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            sales_order records <small></small>
        </h1>
    </div>
</div> 
         <!-- /. ROW  -->
       
    <div class="row">
        <div class="col-md-12">
            <!-- Advanced Tables -->
            <div class="panel panel-default">
                <div class="panel-heading">
                     sales_order entries are listed here..
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Invoice No</th>
                                    <th>Dealer Name</th>
                                    <th>Customer Name</th>
                                    <th>Item Name</th>
                                    <th>Total Price</th>
                                    <th>sales_order date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $i=1; foreach($sales_order_list as $value){?>
                                <tr class="gradeA">
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $value->sales_order_id;?></td>
                                    <td><?php echo $value->dealer_name;?></td>
                                    <td><?php echo $value->customer_name;?></td>
                                    <td><?php echo $value->item_name;?></td>
                                    <td class="center"><?php echo $value->total_price;?></td>
                                    <td><?php echo $value->sales_order_date;?></td>
                                    <td class="center">
                                    <?php if($permission->permission_edit==1){?>
                                    <a href="<?php echo base_url();?>sales_order/index/<?php echo $value->sales_order_id;?>"> edit </a> | 
                                    <?php }else{?>
                                    <label style="color:#aea4a4; font-weight:normal;">edit</label>|
                                    <?php }?>
                                    <?php if($permission->permission_delete==1){?>
                                    <a data-href="<?php echo base_url();?>sales_order/delete_sales_order/<?php echo $value->sales_order_id;?>" data-toggle="modal" data-target="#confirm-delete"> delete </a> | <a href="<?php echo base_url();?>sales_order/print_sales_order/<?php echo $value->sales_order_id;?>" target="_blank"> Print </a>
                                    <?php }else{?>
                                    <label style="color:#aea4a4; font-weight:normal;">delete</label>
                                    <?php }?>
                                    </td>
                                </tr>
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
</div>