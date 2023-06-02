<h3>Welcome to OLAGO STAFFING SOLUTION</h3>
<hr>
<div class="col-12">
    <div class="row gx-3 row-cols-4">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="w-100 d-flex align-items-center">
                        <div class="col-auto pe-1">
                            <span class="fa fa-search fs-3 text-primary"></span>
                        </div>
                        <div class="col-auto flex-grow-1">
                            <div class="fs-5"><b>Vacancies</b></div>
                            <div class="fs-6 text-end fw-bold">
                                <?php 
                                $vacancy = $conn->query("SELECT count(vacancy_id) as `count` FROM `vacancy_list` ")->fetchArray()['count'];
                                echo $vacancy > 0 ? number_format($vacancy) : 0 ;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="w-100 d-flex align-items-center">
                        <div class="col-auto pe-1">
                            <span class="fa fa-users fs-3 text-dark"></span>
                        </div>
                        <div class="col-auto flex-grow-1">
                            <div class="fs-5"><b>Pending Applicants</b></div>
                            <div class="fs-6 text-end fw-bold">
                                <?php 
                                $applicants = $conn->query("SELECT count(applicant_id) as `count` FROM `applicant_list` where status = 1 ")->fetchArray()['count'];
                                echo $applicants > 0 ? number_format($applicants) : 0 ;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="w-100 d-flex align-items-center">
                        <div class="col-auto pe-1">
                            <span class="fa fa-users fs-3 text-success"></span>
                        </div>
                        <div class="col-auto flex-grow-1">
                            <div class="fs-5"><b>Hired Applicants</b></div>
                            <div class="fs-6 text-end fw-bold">
                                <?php 
                                $applicants = $conn->query("SELECT count(applicant_id) as `count` FROM `applicant_list` where status = 2 ")->fetchArray()['count'];
                                echo $applicants > 0 ? number_format($applicants) : 0 ;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="w-100 d-flex align-items-center">
                        <div class="col-auto pe-1">
                            <span class="fa fa-users fs-3 text-danger"></span>
                        </div>
                        <div class="col-auto flex-grow-1">
                            <div class="fs-5"><b>Failed Applicants</b></div>
                            <div class="fs-6 text-end fw-bold">
                                <?php 
                                $applicants = $conn->query("SELECT count(applicant_id) as `count` FROM `applicant_list` where status = 3 ")->fetchArray()['count'];
                                echo $applicants > 0 ? number_format($applicants) : 0 ;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.restock').click(function(){
            uni_modal('Add New Stock for <span class="text-primary">'+$(this).attr('data-name')+"</span>","manage_stock.php?pid="+$(this).attr('data-pid'))
        })
        $('table#inventory').dataTable()
    })
</script>