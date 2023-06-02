<?php
require_once("./DBConnection.php");
if(isset($_GET['id'])){
$qry = $conn->query("SELECT v.*,d.name as dept,dd.name as desg FROM `vacancy_list` v inner join `designation_list` dd on v.designation_id = dd.designation_id inner join `department_list` d on dd.department_id = d.department_id where v.vacancy_id = '{$_GET['id']}'");
    foreach($qry->fetchArray() as $k => $v){
        $$k = $v;
    }
    $description = html_entity_decode($description);
}
$hired = $conn->query("SELECT count(applicant_id) as `count` FROM `applicant_list` where  vacancy_id in (SELECT vacancy_id FROM vacancy_list where designation_id = '{$designation_id}') and `status` = 2")->fetchArray()['count'];
$hired = $hired > 0 ? $hired : 0;
?>
<div class="container py-3 mt-5">
    <div class="card shodow-lg">
        <div class="card-header bg-primary bg-gradient text-light">
            <h5 class="card-title fw-bold wow"><?php echo $title ?></h5>
        </div>
        <div class="card body">
            <div class="col-12">
                <div class="container-fluid">
                    <div class="row mx-0">
                        <div class="col-md-6 wow slideInLeft">
                            <div class="w-100 mb-1">
                                <div class="fs-6 text-muted"><b>Department:</b></div>
                                <div class="fs-5 ps-4"><?php echo isset($dept) ? $dept : '' ?></div>
                            </div>
                            <div class="w-100 mb-1">
                                <div class="fs-6 text-muted"><b>Designation:</b></div>
                                <div class="fs-5 ps-4"><?php echo isset($desg) ? $desg : '' ?></div>
                            </div>
                        </div>
                        <div class="col-md-6 wow slideInRight">
                            <div class="w-100 mb-1">
                                <div class="fs-6 text-muted"><b>Slots:</b></div>
                                <div class="fs-5 ps-4"><span class="badge bg-success rounded-pill"><?php echo isset($slots) ? number_format($slots - $hired) : '' ?></span></div>
                            </div>
                            <div class="w-100 my-2 pt-3">
                                <button class="btn btn-primary bg-gradient rounded-0 px-4" type="button" id="apply_now">Apply Now</button>
                            </div>
                        </div>
                    </div>
                    
                    <hr class="bg-primary opacity-100 wow">
                    <div class="w-100 mb-1 wow bounceInUp">
                        <div class="fs-6 ps-4"><?php echo isset($description) ? $description : '' ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#apply_now').click(function(){
            uni_modal("Application Form","application.php?id=<?php echo $vacancy_id ?>",'large')
        })
    })
</script>