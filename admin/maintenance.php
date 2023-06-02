
<div class="card h-100 d-flex flex-column">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Maintenance</h3>
        <div class="card-tools align-middle">
            <!-- <button class="btn btn-dark btn-sm py-1 rounded-0" type="button" id="create_new">Add New</button> -->
        </div>
    </div>
    <div class="card-body flex-grow-1">
        <div class="col-12 h-100">
            <div class="row h-100">
                <div class="col-md-6 h-100 d-flex flex-column">
                    <div class="w-100 d-flex border-bottom border-dark py-1 mb-1">
                        <div class="fs-5 col-auto flex-grow-1"><b>Department List</b></div>
                        <div class="col-auto flex-grow-0 d-flex justify-content-end">
                            <a href="javascript:void(0)" id="new_department" class="btn btn-dark btn-sm bg-gradient rounded-2" title="Add Department"><span class="fa fa-plus"></span></a>
                        </div>
                    </div>
                    <div class="h-100 overflow-auto border rounded-1 border-dark">
                        <ul class="list-group">
                            <?php 
                            $cat_qry = $conn->query("SELECT * FROM `department_list` order by `name` asc");
                            while($row = $cat_qry->fetchArray()):
                            ?>
                            <li class="list-group-item d-flex">
                                <div class="col-auto flex-grow-1">
                                    <?php echo $row['name'] ?>
                                </div>
                                <div class="col-auto d-flex justify-content-end">
                                    <a href="javascript:void(0)" class="view_department btn btn-sm btn-info text-light bg-gradient py-0 px-1 me-1" title="View Department Details" data-id="<?php echo $row['department_id'] ?>" ><span class="fa fa-th-list"></span></a>
                                    <a href="javascript:void(0)" class="edit_department btn btn-sm btn-primary bg-gradient py-0 px-1 me-1" title="Edit Department Details" data-id="<?php echo $row['department_id'] ?>"  data-name="<?php echo $row['name'] ?>"><span class="fa fa-edit"></span></a>
                                    <a href="javascript:void(0)" class="delete_department btn btn-sm btn-danger bg-gradient py-0 px-1" title="Delete Department" data-id="<?php echo $row['department_id'] ?>"  data-name="<?php echo $row['name'] ?>"><span class="fa fa-trash"></span></a>
                                </div>
                            </li>
                            <?php endwhile; ?>
                            <?php if(!$cat_qry->fetchArray()): ?>
                                <li class="list-group-item text-center">No data listed yet.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 h-100 d-flex flex-column">
                    <div class="w-100 d-flex border-bottom border-dark py-1 mb-1">
                        <div class="fs-5 col-auto flex-grow-1"><b>Designation List</b></div>
                        <div class="col-auto flex-grow-0 d-flex justify-content-end">
                            <a href="javascript:void(0)" id="new_designation" class="btn btn-dark btn-sm bg-gradient rounded-2" title="Add Designation"><span class="fa fa-plus"></span></a>
                        </div>
                    </div>
                    <div class="h-100 overflow-auto border rounded-1 border-dark">
                        <ul class="list-group">
                            <?php 
                            $cat_qry = $conn->query("SELECT * FROM `designation_list` order by `name` asc");
                            while($row = $cat_qry->fetchArray()):
                            ?>
                            <li class="list-group-item d-flex">
                                <div class="col-auto flex-grow-1">
                                    <?php echo $row['name'] ?>
                                </div>
                                <div class="col-auto d-flex justify-content-end">
                                    <a href="javascript:void(0)" class="view_designation btn btn-sm btn-info text-light bg-gradient py-0 px-1 me-1" title="View Designation Details" data-id="<?php echo $row['designation_id'] ?>" ><span class="fa fa-th-list"></span></a>
                                    <a href="javascript:void(0)" class="edit_designation btn btn-sm btn-primary bg-gradient py-0 px-1 me-1" title="Edit Designation Details" data-id="<?php echo $row['designation_id'] ?>"  data-name="<?php echo $row['name'] ?>"><span class="fa fa-edit"></span></a>
                                    <a href="javascript:void(0)" class="delete_designation btn btn-sm btn-danger bg-gradient py-0 px-1" title="Delete Designation" data-id="<?php echo $row['designation_id'] ?>"  data-name="<?php echo $row['name'] ?>"><span class="fa fa-trash"></span></a>
                                </div>
                            </li>
                            <?php endwhile; ?>
                            <?php if(!$cat_qry->fetchArray()): ?>
                                <li class="list-group-item text-center">No data listed yet.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        // department Functions
        $('#new_department').click(function(){
            uni_modal('Add New Department',"manage_department.php")
        })
        $('.edit_department').click(function(){
            uni_modal('Edit Department Details',"manage_department.php?id="+$(this).attr('data-id'))
        })
        $('.view_department').click(function(){
            uni_modal('Department Details',"view_department.php?id="+$(this).attr('data-id'))
        })
        $('.delete_department').click(function(){
            _conf("Are you sure to delete <b>"+$(this).attr('data-name')+"</b> from Department List?",'delete_department',[$(this).attr('data-id')])
        })

        // Designation Functions
        $('#new_designation').click(function(){
            uni_modal('Add New Designation',"manage_designation.php")
        })
        $('.edit_designation').click(function(){
            uni_modal('Edit Designation Details',"manage_designation.php?id="+$(this).attr('data-id'))
        })
        $('.view_designation').click(function(){
            uni_modal('Designation Details',"view_designation.php?id="+$(this).attr('data-id'))
        })
        $('.delete_designation').click(function(){
            _conf("Are you sure to delete <b>"+$(this).attr('data-name')+"</b> from Designation List?",'delete_designation',[$(this).attr('data-id')])
        })
    })
    function delete_department($id){
        $('#confirm_modal button').attr('disabled',true)
        $.ajax({
            url:'./../Actions.php?a=delete_department',
            method:'POST',
            data:{id:$id},
            dataType:'JSON',
            error:err=>{
                console.log(err)
                alert("An error occurred.")
                $('#confirm_modal button').attr('disabled',false)
            },
            success:function(resp){
                if(resp.status == 'success'){
                    location.reload()
                }else{
                    alert("An error occurred.")
                    $('#confirm_modal button').attr('disabled',false)
                }
            }
        })
    }
    function delete_designation($id){
        $('#confirm_modal button').attr('disabled',true)
        $.ajax({
            url:'./../Actions.php?a=delete_designation',
            method:'POST',
            data:{id:$id},
            dataType:'JSON',
            error:err=>{
                console.log(err)
                alert("An error occurred.")
                $('#confirm_modal button').attr('disabled',false)
            },
            success:function(resp){
                if(resp.status == 'success'){
                    location.reload()
                }else{
                    alert("An error occurred.")
                    $('#confirm_modal button').attr('disabled',false)
                }
            }
        })
    }
</script>