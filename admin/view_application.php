<?php
require_once("../DBConnection.php");
if(isset($_GET['id'])){
    $qry = $conn->query("SELECT a.*,d.name as dept,dd.name as desg FROM `applicant_list` a inner join vacancy_list v on a.vacancy_id = v.vacancy_id inner join `designation_list` dd on v.designation_id = dd.designation_id inner join `department_list` d on dd.department_id = d.department_id where a.applicant_id = '{$_GET['id']}'");
    foreach($qry->fetchArray() as $k => $v){
        $$k = $v;
    }
    $message = str_replace(array("\n\r","\n"),"<br/>",$message);
    $summary = str_replace(array("\n\r","\n"),"<br/>",$summary);
}
?>
<div class="container">
    <div class="w-100 d-flex mb-2">
        <h5 class="card-title fw-bold wow flex-grow-1">Applied for <?php echo $dept." - ".$desg ?></h5>
        <div class="col-auto">
            <button class="btn btn-success rounded-0" id="print">Print</button>
        </div>
    </div>
    <div class="card shodow-lg">
        <div class="card body" id="outprint">
            <style>
                .strikeBg{
                    text-align:center;
                    display:flex;
                    justify-content:center;
                    align-items:center;
                }
                .strikeBg:before{
                    content:"";
                    flex-grow:1;
                    border-bottom:2px solid var(--bs-primary);
                    margin-right:5px;
                    margin-top:5px;
                }
                .strikeBg:after{
                    content:"";
                    flex-grow:1;
                    border-bottom:2px solid var(--bs-primary);
                    margin-left:5px;
                    margin-top:5px;
                }
                #cv h1,#cv h2,#cv h3,#cv h4,#cv h5
                {
                    font-family:Brush Script MT, Brush Script Std, cursive;
                    font-style:italic
                }            
            </style>
            <div class="col-12" id="cv">
                <div class="row mx-0">
                    <div class="col-4 pt-5 bg-dark text-light bg-gradient">
                        <div class="w-100 mb-3 mt-5">
                            <span class="me-2 text-light py-1 px-2 fs-6 bg-primary bg-gradient rounded-circle"><i class="fa fa-envelope"></i></span>
                            <span><?php echo $email ?></span>
                        </div>
                        <div class="w-100 mb-3">
                            <span class="me-2 text-light py-1 px-2 fs-6 bg-primary bg-gradient rounded-circle"><i class="fa fa-phone"></i></span>
                            <span><?php echo $contact ?></span>
                        </div>
                        <div class="w-100 mb-3">
                            <span class="me-2 text-light py-1 px-2 fs-6 bg-primary bg-gradient rounded-circle"><i class="fa fa-venus-mars"></i></span>
                            <span><?php echo $gender ?></span>
                        </div>
                        <div class="w-100 mb-3">
                            <span class="me-2 text-light py-1 px-2 fs-6 bg-primary bg-gradient rounded-circle"><i class="fa fa-calendar-day"></i></span>
                            <span><?php echo date("F d, Y",strtotime($dob)) ?></span>
                        </div>
                        <div class="w-100 mb-3">
                            <span class="me-2 text-light py-1 px-2 fs-6 bg-primary bg-gradient rounded-circle"><i class="fa fa-map-marked-alt"></i></span>
                            <span><?php echo $address ?></span>
                        </div>
                        <div class="mt-3">
                            <h3 class="strikeBg">Skills</h3>
                            <div class="my-2">
                                <?php 
                                $skills = $conn->query("SELECT * FROM skills where applicant_id = '{$applicant_id}'");
                                while($row= $skills->fetchArray()):
                                ?>
                                <div class="bg-primary bg-bradient px-2 rounded-pill my-2"><?php echo $row['skill'] ?></div>
                                <?php endwhile; ?>
                            </div>
                 
                        </div>
                        <div class="mt-3">
                            <h3 class="strikeBg">Certificate</h3>
                            <?php
                            if (isset($_GET['id'])) {
                                $applicant_id = $_GET['id'];
                                $certificates = [];
                                $query = $conn->query("SELECT * FROM certificate WHERE applicant_id = '{$applicant_id}'");
                                while ($row = $query->fetchArray(SQLITE3_ASSOC)) {
                                    $certificates[] = $row;
                                }
                            }
                            ?>
                            <?php if (!empty($certificates)): ?>
                                <?php foreach ($certificates as $certificate): ?>
                                    <div class="my-2">
                                        <a href="<?php echo $certificate['file_path']; ?>" target="_blank"><?php echo $certificate['name']; ?></a>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted">No certificates submitted</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="lh-1">
                            <h1 class="text-center m-0"><?php echo $name ?></h1>
                            <center><span class="text-muted"><small>Applying for <?php echo $desg ?> Position of <b><?php echo $dept ?></b></small></span></center>
                        </div>
                        <div class="mt-5">
                            <h3 class="strikeBg">Profile</h3>
                            <p class="lh-1"><?php echo $summary ?></p>
                        </div>
                        
                        <div class="mt-4">
                            <h3 class="strikeBg">Experience</h3>
                            <?php 
                                $employment = $conn->query("SELECT * FROM employment where applicant_id = '{$applicant_id}'");
                                while($row= $employment->fetchArray()):
                            ?>
                            <div class='lh-1 my-2'>
                                <div class="fs-5 fw-bold"><?php echo $row['position'] ?></div>
                                <div class="text-muted w-100 d-flex">
                                    <div class="col-auto me-2">
                                        <i class="fa fa-building"></i> <small><?php echo $row['company_name'] ?></small>
                                    </div>
                                    <div class="col-auto">
                                        <small><?php echo date("M Y",strtotime($row['from']))." - ".($row['still_active'] == 1 ? "Present" : date("M Y",strtotime($row['to']))) ?></small>
                                    </div>
                                </div>
                                <p><?php echo $row['brief_info'] ?></p>
                            </div>
                            <?php endwhile; ?>
                        </div>

                        <div class="mt-4">
                            <h3 class="strikeBg">Education</h3>
                            <?php 
                                $education = $conn->query("SELECT * FROM educational where applicant_id = '{$applicant_id}'");
                                while($row= $education->fetchArray()):
                            ?>
                            <div class='lh-1 my-2'>
                                <div class="fs-5 fw-bold"><?php echo $row['level'] ?></div>
                                <div class="text-muted">
                                    <span class="fa fa-school me-2"></span> <span><?php echo $row['school_name'] ?></span>
                                    <span class="ms-2"><small><?php echo date("M Y",strtotime($row['from']))." - ".date("M Y",strtotime($row['to'])) ?></small></span>
                                </div>
                                <p class="mt-1"><i class="fa fa-map-marker me-2"></i><?php echo $row['school_address'] ?></p>
                            </div>
                            <?php endwhile; ?>
                        </div>

                        <div class="mt-5">
                            <h3 class="strikeBg">Why should you Hire Me?</h3>
                            <p class="lh-1"><?php echo $message ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#print').click(function(){
            var h = $('head').clone()
            var p = $('#outprint').clone()
            var el = $('<div>')
            el.append(h)
            el.append(p.html())
            var nw = window.open("","","width=900,height=900")
                nw.document.write(el.html())
                nw.document.close()
                setTimeout(() => {
                    nw.print()
                    setTimeout(() => {
                        nw.close()
                    }, 150);
                }, 200);
        })
    })
</script>
