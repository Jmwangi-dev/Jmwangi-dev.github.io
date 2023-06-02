
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Application List</h3>
    </div>
    <div class="card-body">
        <table class="table table-hover table-striped table-bordered">
            <colgroup>
                <col width="5%">
                <col width="25%">
                <col width="25%">
                <col width="15%">
                <col width="15%">
                <col width="15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="text-center p-0">#</th>
                    <th class="text-center p-0">Department/Position</th>
                    <th class="text-center p-0">Applicant Name</th>
                    <th class="text-center p-0">Contact/Email</th>
                    <th class="text-center p-0">Status</th>
                    <th class="text-center p-0">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sql = "SELECT a.*,d.name as dept,dd.name as desg FROM `applicant_list` a inner join vacancy_list v on a.vacancy_id = v.vacancy_id inner join `designation_list` dd on v.designation_id = dd.designation_id inner join `department_list` d on dd.department_id = d.department_id order by strftime('%s',a.date_created) asc";
                $qry = $conn->query($sql);
                $i = 1;
                    while($row = $qry->fetchArray()):
                ?>
                <tr>
                    <td class="text-center p-0"><?php echo $i++; ?></td>
                    <td class="py-0 px-1">
                        <div class="fs-6 lh-1 my-1">
                            <span class=""><?php echo $row['dept'] ?></span> <br>
                            <span class=""><?php echo $row['desg'] ?></span>
                        </div>
                    </td>
                    <td class="py-0 px-1"><?php echo ($row['name']) ?></td>
                    <td class="py-0 px-1">
                        <div class="fs-6 lh-1">
                            <span class=""><small><?php echo $row['contact'] ?></small></span> <br>
                            <span class=""><small><?php echo $row['email'] ?></small></span>
                        </div>
                    </td>
                    <td class="py-0 px-1 text-center">
                        <?php 
                        if($row['status'] == 1){
                            echo  '<span class="py-1 px-3 badge rounded-pill bg-secondary"><small>Pending</small></span>';
                        }else if($row['status'] == 2){
                            echo  '<span class="py-1 px-3 badge rounded-pill bg-success"><small>Hired</small></span>';
                        }else{
                            echo  '<span class="py-1 px-3 badge rounded-pill bg-danger"><small>Failed</small></span>';

                        }
                        ?>
                    </td>
                    <td class="text-center py-0 px-1">
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle btn-sm rounded-0 py-0" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <li><a class="dropdown-item view_data" data-id = '<?php echo $row['applicant_id'] ?>' href="./?page=view_application&id=<?php echo $row['applicant_id'] ?>">View Details</a></li>
                            <li><a class="dropdown-item update_status" data-id = '<?php echo $row['applicant_id'] ?>' data-name = '<?php echo $row['name'] ?>' href="javascript:void(0)">Update Status</a></li>
                            <li><a class="dropdown-item delete_data" data-id = '<?php echo $row['applicant_id'] ?>' data-name = '<?php echo $row['name'] ?>' href="javascript:void(0)">Delete</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
               
            </tbody>
        </table>
    </div>
</div>
<script>
    $(function(){
        $('.view_data').click(function(){
            uni_modal('Vacancy Details',"view_vacancy.php?id="+$(this).attr('data-id'),'large')
        })
        $('.update_status').click(function(){
            uni_modal('Update Application Status',"update_status.php?id="+$(this).attr('data-id'))
        })
        $('.delete_data').click(function(){
            _conf("Are you sure to delete the Application of <b>"+$(this).attr('data-name')+"</b>?",'delete_data',[$(this).attr('data-id')])
        })
        $('table td,table th').addClass('align-middle')
        $('table').dataTable({
            columnDefs: [
                { orderable: false, targets:3 }
            ]
        })
    })
    function delete_data($id){
        $('#confirm_modal button').attr('disabled',true)
        $.ajax({
            url:'./../Actions.php?a=delete_applicant',
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