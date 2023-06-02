<div class="my-5 pt-4">
    <div class="container">
        <div class="col-12">
            <div class="row mx-0 d-flex justify-content-cente mb-2">
                <div class="col-12">
                <div class="input-group mb-3">
                    <input type="text" id="search" class="form-control rounded-0" placeholder="Search Here" aria-label="Search Here" aria-describedby="basic-addon2" autocomplete="off">
                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-search"></i></span>
                </div>
                </div>
            </div>
            <div class="row mx-0 row-cols-1 row-cols-sm-1 row-cols-xl-3 gx-5 gy-3" id="vacancy_list">
                <?php
                $sql = "SELECT v.*,d.name as dept,dd.name as desg FROM `vacancy_list` v inner join `designation_list` dd on v.designation_id = dd.designation_id inner join `department_list` d on dd.department_id = d.department_id where v.status = 1 order by strftime('%s',date_created) asc";
                $qry = $conn->query($sql);
                $i = 0;
                while($row = $qry->fetchArray()):
                    $row['description'] = strip_tags(html_entity_decode($row['description']));
                    $hired = $conn->query("SELECT count(applicant_id) as `count` FROM `applicant_list` where  vacancy_id in (SELECT vacancy_id FROM vacancy_list where designation_id = '{$row['designation_id']}') and `status` = 2")->fetchArray()['count'];
                    $hired = $hired > 0 ? $hired : 0;
                ?>
                <div class="item col wow bounceInUp" data-wow-delay="<?php echo ($i > 0) ? $i:''; $i += .5; ?>s">
                    <div class="card shadow-sm ">
                        <div class="card-body ">
                            <h5 class="card-title mb-1"><?php echo $row['title'] ?></h5>
                            <hr class="bg-primary opacity-100">
                            <div class="lh-1 mb-2">
                                <small class="text-muted">Position: <span class="fw-bold"><?php echo $row['desg'] ?></span></small> <br>
                                <small class="text-muted">Dept.: <span class="fw-bold"><?php echo $row['dept'] ?></span></small>
                            </div>
                            <p class="truncate-3 fw-light fst-italic lh-1"><small><?php echo $row['description'] ?></small></p>
                            <div class="w-100 d-flex justify-content-between">
                                <div class="col-auto">
                                    <a href="./?page=view_vacancy&id=<?php echo $row['vacancy_id'] ?>" class="btn btn-sm btn-primary bg-gradient rounded-0 py-0">Read More</a>
                                </div>
                                <div>
                                <span class="text-muted me-2">Slot: </span><span class="badge bg-success rounded-circle"><?php echo $row['slots']-$hired ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>

            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#search').on('input',function(){
            var _search = $(this).val().toLowerCase()
            $('#vacancy_list .item').each(function(){
                var _text = $(this).text().toLowerCase()
                if(_text.includes(_search) == true){
                    $(this).toggle(true)
                }else{
                    $(this).toggle(false)
                }
            })
        })
    })
</script>