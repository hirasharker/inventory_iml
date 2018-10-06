<?php
        if($permission->permission_view!=1){
            redirect('sales/customer/','refresh');   
        }
 ?>

<div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Customer's List <small></small>
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
               
            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Customers are listed here..
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="datatable-buttons1">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Customer Code</th>
                                            <th>Customer Name</th>
                                            <th>Type of Customer</th>
                                            <th>Category</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i=1; foreach($customer_list as $value){?>
                                        <tr class="gradeA">
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $value->customer_id;?></td>
                                            <td><?php echo $value->customer_name;?></td>
                                            <td>
                                                <?php
                                                    switch ($value->customer_type) {
                                                        case '1':
                                                            echo "Dealer";
                                                            break;
                                                        case '2':
                                                            echo "Regular Customer";
                                                            break;
                                                        case '3':
                                                            echo "Annonymus";
                                                            break;
                                                        default:
                                                            break;
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $value->customer_category; ?></td>
                                            <td><?php echo $value->address;?></td>
                                            <td class="center"><?php echo $value->phone_no;?></td>
                                            <td class="center">
                                            <?php if($permission->permission_edit==1){?>
                                            <a href="<?php echo base_url();?>customer/customer/<?php echo $value->customer_id;?>"> edit </a> | 
                                            <?php }else{?>
                                            <label style="color:#aea4a4; font-weight:normal;">edit</label>|
                                            <?php }?>
                                            <?php if($permission->permission_delete==1){?>
                                            <a data-href="<?php echo base_url();?>customer/delete_customer/<?php echo $value->customer_id;?>" data-toggle="modal" data-target="#confirm-delete"> delete </a></td>
                                            <?php }else{?>
                                            <label style="color:#aea4a4; font-weight:normal;">delete</label>
                                            <?php }?>
                                        </tr>
                                        <?php $i++;}?>
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