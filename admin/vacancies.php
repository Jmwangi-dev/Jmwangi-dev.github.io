
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h3 class="card-title">Vacancy List</h3>
        <div class="card-tools align-middle">
            <button class="btn btn-dark btn-sm py-1 rounded-0" type="button" id="create_new">Add New</button>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover table-striped table-bordered">
            <colgroup>
                <col width="5%">
                <col width="25%">
                <col width="25%">
                <col width="7.5%">
                <col width="7.5%">
                <col width="15%">
                <col width="15%">
            </colgroup>
            <thead>
                <tr>
                    <th class="text-center p-0">#</th>
                    <th class="text-center p-0">Department/Position</th>
                    <th class="text-center p-0">Information</th>
                    <th class="text-center p-0">Slot</th>
                    <th class="text-center p-0">Hired</th>
                    <th class="text-center p-0">Status</th>
                    <th class="text-center p-0">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $sql = "SELECT v.*,d.name as dept,dd.name as desg FROM `vacancy_list` v inner join `designation_list` dd on v.designation_id = dd.designation_id inner join `department_list` d on dd.department_id = d.department_id order by strftime('%s',date_created) asc";
                $qry = $conn->query($sql);
                $i = 1;
                    while($row = $qry->fetchArray()):
                        $row['description'] = strip_tags(html_entity_decode($row['description']));
                    $hired = $conn->query("SELECT count(applicant_id) as `count` FROM `applicant_list` where  vacancy_id in (SELECT vacancy_id FROM vacancy_list where designation_id = '{$row['designation_id']}') and `status` = 2")->fetchArray()['count'];
                    $hired = $hired > 0 ? $hired : 0;
                ?>
                <tr>
                    <td class="text-center p-0"><?php echo $i++; ?></td>
                    <td class="py-0 px-1">
                        <div class="fs-6 lh-1 my-1">
                            <span class=""><?php echo $row['dept'] ?></span> <br>
                            <span class=""><?php echo $row['desg'] ?></span>
                        </div>
                    </td>
                    <td class="py-0 px-1">
                        <div class="fs-6 lh-1">
                            <span class="fw-bold"><?php echo $row['title'] ?></span><br>
                            <p class="fw-lighter truncate-1 m-0"><?php echo $row['description'] ?></p>
                        </div>
                    </td>
                    <td class="py-0 px-1 text-end"><?php echo number_format($row['slots']) ?></td>
                    <td class="py-0 px-1 text-end"><?php echo number_format($hired) ?></td>
                    <td class="py-0 px-1 text-center">
                        <?php 
                        if($row['status'] == 1){
                            echo  '<span class="py-1 px-3 badge rounded-pill bg-success"><small>Active</small></span>';
                        }else{
                            echo  '<span class="py-1 px-3 badge rounded-pill bg-danger"><small>Inactive</small></span>';

                        }
                        ?>
                    </td>
                    <td class="text-center py-0 px-1">
                        <div class="btn-group" role="group">
                            <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle btn-sm rounded-0 py-0" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <li><a class="dropdown-item view_data" data-id = '<?php echo $row['vacancy_id'] ?>' href="javascript:void(0)">View Details</a></li>
                            <li><a class="dropdown-item edit_data" data-id = '<?php echo $row['vacancy_id'] ?>' href="javascript:void(0)">Edit</a></li>
                            <li><a class="dropdown-item delete_data" data-id = '<?php echo $row['vacancy_id'] ?>' data-name = '<?php echo $row['title'] ?>' href="javascript:void(0)">Delete</a></li>
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
        $('#create_new').click(function(){
            uni_modal('Add New Vacancy',"manage_vacancy.php",'large')
        })
        $('.edit_data').click(function(){
            uni_modal('Edit Vacancy Details',"manage_vacancy.php?id="+$(this).attr('data-id'),'large')
        })
        $('.view_data').click(function(){
            uni_modal('Vacancy Details',"view_vacancy.php?id="+$(this).attr('data-id'),'large')
        })
        $('.delete_data').click(function(){
            _conf("Are you sure to delete <b>"+$(this).attr('data-name')+"</b> from Vacancy List?",'delete_data',[$(this).attr('data-id')])
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
            url:'./../Actions.php?a=delete_vacancy',
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