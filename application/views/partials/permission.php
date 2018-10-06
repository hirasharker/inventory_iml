<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Permission for <?php echo $result->user_name;?> <small></small>
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
   
<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                 Set permission for <?php echo $result->user_name;?>
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-lg-6">
                        <form method="post" action="<?php echo base_url()?>user/update_user_permission/<?php echo $result->user_id;?>" target="_blank">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" >
                                    <!-- <thead>
                                        <tr>
                                            <th>Module Name</th>
                                            <th>View</th>
                                            <th>Add</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead> -->
                                    <tbody>
                                    <?php foreach($permission as $value){?>
                                        
                                        <tr class="even gradeA">
                                            <input type="hidden" class="permission_id" name="permission_id[]" value="<?php echo $value->permission_id;?>">
                                            <input type="hidden" class="module_name" name="module_name[]" value="<?php echo $value->module_name;?>">
                                            <td><?php echo $value->module_name;?></td>
                                            <?php if($value->module_type!='utility'){?>
                                            <td>
                                                <label class="checkbox-inline">
                                                    <input name="permission_view[]" value="1" class="view" type="checkbox" <?php if($value->permission_view==1){echo 'checked';}?>>View
                                                </label>
                                            </td>
                                            <?php }else{?>
                                            <td>
                                                <label class="checkbox-inline">
                                                    <input name="permission_allow[]" value="1" class="allow" type="checkbox" <?php if($value->permission_allow==1){echo 'checked';}?>>Allow
                                                </label>
                                            </td>
                                            <?php } ?>
                                            <?php if($value->module_type=='form'){?>
                                            <td>
                                                <label class="checkbox-inline">
                                                    <input name="permission_add[]" value="1" class="add" type="checkbox" <?php if($value->permission_add==1){echo 'checked';}?>>Add
                                                </label>
                                            </td>
                                            <td class="center">
                                                <label class="checkbox-inline">
                                                    <input name="permission_edit[]" value="1" class="edit" type="checkbox" <?php if($value->permission_edit==1){echo 'checked';}?>>Edit
                                                </label>
                                            </td>
                                            <td class="center">
                                                <label class="checkbox-inline">
                                                    <input name="permission_delete[]" value="1" class="delete" type="checkbox" <?php if($value->permission_delete==1){echo 'checked';}?>>Delete
                                                </label>
                                            </td>
                                            
                                            <?php }?>
                                        </tr>
                                    <?php }?>
                                    </tbody>
                                </table>
                            </div>
                                
                            
                            <!-- <div class="form-group">
                                <label class="col-lg-3">Reports </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox">View
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox">Add
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox">Edit
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox">Delete
                                </label>
                            </div> -->
                            <br/>
                            <!-- <button type="submit" class="btn btn-primary" id="update"><i class="fa fa-file-o" aria-hidden="true"></i> Update</button> -->
                            <!-- <button type="reset" class="btn btn-default">Reset</button> -->
                        </form>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->
                <br/>

               
            </div>
        </div>
        <!--End Advanced Tables -->
    </div>
</div>
    <!-- /. ROW  -->
<div id="table-container">
    
</div>

<script>
     $( ".allow" ).click(function() {

        var checkedValue;

        if($(this).prop('checked')){
            checkedValue = 1;
        }else{
            checkedValue = 0;
        }

        var permissionId = $(this).closest('tr').find('.permission_id').val();

        $.ajax({
            url: '<?php echo base_url();?>user/update_user_allow_permission',
            type:'POST',
            dataType: 'json',
            data: {permission_id : permissionId, checked_value : checkedValue},
            success: function(output){
                $("#table-container").append(output);
            } // End of success function of ajax form
        }); // End of ajax call

    });


    $( ".view" ).click(function() {

        var checkedValue;

        if($(this).prop('checked')){
            checkedValue = 1;
        }else{
            checkedValue = 0;
        }

        var permissionId = $(this).closest('tr').find('.permission_id').val();

        $.ajax({
            url: '<?php echo base_url();?>user/update_user_view_permission',
            type:'POST',
            dataType: 'json',
            data: {permission_id : permissionId, checked_value : checkedValue},
            success: function(output){
                $("#table-container").append(output);
            } // End of success function of ajax form
        }); // End of ajax call

        // $(this).closest('tr').find('.add').prop('checked', false);
        $(this).closest('tr').find('.edit').prop('checked', false);
        $(this).closest('tr').find('.delete').prop('checked', false);
    });

    $( ".add" ).click(function() {

        var checkedValue;

        if($(this).prop('checked')){
            checkedValue = 1;
        }else{
            checkedValue = 0;
        }

        var permissionId = $(this).closest('tr').find('.permission_id').val();

        $.ajax({
            url: '<?php echo base_url();?>user/update_user_add_permission',
            type:'POST',
            dataType: 'json',
            data: {permission_id : permissionId, checked_value : checkedValue},
            success: function(output){
                $("#table-container").append(output);
            } // End of success function of ajax form
        }); // End of ajax call

        // $(this).closest('tr').find('.view').prop('checked', true);
          

    });

    $( ".edit" ).click(function() {

        var checkedValue;

        if($(this).prop('checked')){
            checkedValue = 1;
        }else{
            checkedValue = 0;
        }

        var permissionId = $(this).closest('tr').find('.permission_id').val();

        $.ajax({
            url: '<?php echo base_url();?>user/update_user_edit_permission',
            type:'POST',
            dataType: 'json',
            data: {permission_id : permissionId, checked_value : checkedValue},
            success: function(output){
                $("#table-container").append(output);
            } // End of success function of ajax form
        }); // End of ajax call

        $(this).closest('tr').find('.view').prop('checked', true);
          
         var val = $(this).closest('tr').find('.view').val();

    });
    $( ".delete" ).click(function() {

        var checkedValue;

        if($(this).prop('checked')){
            checkedValue = 1;
        }else{
            checkedValue = 0;
        }

        var permissionId = $(this).closest('tr').find('.permission_id').val();

        $.ajax({
            url: '<?php echo base_url();?>user/update_user_delete_permission',
            type:'POST',
            dataType: 'json',
            data: {permission_id : permissionId, checked_value : checkedValue},
            success: function(output){
                $("#table-container").append(output);
            } // End of success function of ajax form
        }); // End of ajax call


        $(this).closest('tr').find('.view').prop('checked', true);
          
         var val = $(this).closest('tr').find('.view').val();

    });
    
</script>



<script type="text/javascript">
function selectFolder(e) {
    var theFiles = e.target.files;
    var relativePath = theFiles[0].webkitRelativePath;
    var folder = relativePath.split("/");
    alert(folder[0]);
}
</script>