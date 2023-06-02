<?php
require_once("../DBConnection.php");
if(isset($_GET['id'])){
$qry = $conn->query("SELECT d.*,dd.name as dept FROM `designation_list` d inner join department_list dd on d.department_id = dd.department_id where d.designation_id = '{$_GET['id']}'");
    foreach($qry->fetchArray() as $k => $v){
        $$k = $v;
    }
}
?>
<style>
    #uni_modal .modal-footer{
        display:none !important;
    }
</style>
<div class="container-fluid">
    <div class="col-12">
        <div class="w-100 mb-1">
            <div class="fs-6"><b>Designation Name:</b></div>
            <div class="fs-5 ps-4"><?php echo isset($name) ? $name : '' ?></div>
        </div>
        <div class="w-100 mb-1">
            <div class="fs-6"><b>Deparment:</b></div>
            <div class="fs-5 ps-4"><?php echo isset($dept) ? $dept : '' ?></div>
        </div>
        <div class="w-100 mb-1">
            <div class="fs-6"><b>Description:</b></div>
            <div class="fs-6 ps-4 fw-light lh-1"><?php echo isset($description) ? $description : '' ?></div>
        </div>
        <div class="w-100 d-flex justify-content-end">
            <button class="btn btn-sm btn-dark rounded-0" type="button" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>