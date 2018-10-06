<div class="row">
        <div class="col-md-12">
            <h1 class="page-header">
                Backup <small></small>
            </h1>
        </div>
    </div> 
     <!-- /. ROW  -->
   
<div class="row">
    <div class="col-md-12">
        <!-- Advanced Tables -->
        <div class="panel panel-default">
            <div class="panel-heading">
                 Take backup of your database!
            </div>
            <div class="panel-body">

                <div class="row">
                    <div class="col-lg-6">
                        <form method="post" action="<?php echo base_url()?>utility/get_backup" target="_blank">
                                <div class="form-group">
                                    <label>File Name</label>
                                    <input id="file-name" class="form-control" placeholder = "Type file name here" name="file_name" type="text">
                                </div>

                            <br/>
                            <button type="submit" class="btn btn-primary" id="backup"><i class="fa fa-file-o" aria-hidden="true"></i> Backup</button>
                            <button type="reset" class="btn btn-default">Reset</button>
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



<script type="text/javascript">
function selectFolder(e) {
    var theFiles = e.target.files;
    var relativePath = theFiles[0].webkitRelativePath;
    var folder = relativePath.split("/");
    alert(folder[0]);
}
</script>