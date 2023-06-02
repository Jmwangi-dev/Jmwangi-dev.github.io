<style>
    #uni_modal .modal-footer{
        display:none !important;
    }
    #uni_modal .modal-body{
        height:80vh !important;
        overflow:auto !important;
    }
    .stepProgressBar {
    counter-reset: step;
    }
    .stepProgressBar li {
    list-style: none;
    display: inline-block;
    width: 18%;
    position: relative;
    text-align: center;
    cursor: pointer;
    }
    .stepProgressBar li:before {
    content: counter(step);
    counter-increment: step;
    width: 30px;
    height: 30px;
    line-height : 30px;
    border: 1px solid #ddd;
    border-radius: 100%;
    display: block;
    text-align: center;
    margin: 0 auto 10px auto;
    background-color: #fff;
    z-index : 1;
    position:relative;
    }
    .stepProgressBar li:after {
    content: "";
    position: absolute;
    width: 100%;
    height: 1px;
    background-color: rgb(var(--bs-primary-rgb));
    top: 15px;
    left: 50%;
    z-index : 0;
    }
    .stepProgressBar li:last-child:after {
    content: none;
    }
    .stepProgressBar li.active {
    color: var(--bs-primary);
    font-size:bolder;
    }
    .stepProgressBar li.active:before {
    border-color: var(--bs-primary);
    border:2px solid
    } 
    .stepProgressBar li.active:after,.stepProgressBar li.active ~ li:after {
    background-color: #ddd;
    }
    #tags-text:focus-visible{
        outline:unset;
    }
    #tags-text:empty:before{
        content: attr(placeholder);
        color: #d0d0d0;
    }
    #tags-text:focus-visible:before{
        content:none;
    }
    #tags-text:focus:before{
        content:none;
    }
    #tags-holder:focus-within{
        border-color: var(--bs-primary) !important;
    }
</style>
<form action="Actions.php" id="application-form" class="h-100" enctype="multipart/form-data">
    <input type="hidden" name="vacancy_id" value="<?php echo $_GET['id'] ?>">
<div class="container-fluid h-100">
    <div class="col-12 h-100 d-flex flex-column">
        <div class="container-fluid">
            <ul class="stepProgressBar">
                <li class="active">Step 1</li>
                <li>Step 2</li>
                <li>Step 3</li>
                <li>Step 4</li>
                <li>Step 5</li>
            </ul>
        </div>
        <div id="set-headers">
            <h3 class="set-title text-center" data-header="basic_info">Basic Information</h3>
            <h3 class="set-title text-center" style="display:none"  data-header="employment">Employment</h3>
            <h3 class="set-title text-center" style="display:none"  data-header="educational">Educational</h3>
            <h3 class="set-title text-center" style="display:none"  data-header="skills">Skills</h3>
            <h3 class="set-title text-center" style="display:none"  data-header="message">Why Should We Hire You?</h3>
        </div>
        <hr>
        <fieldset class="set-item flex-grow-1 h-100 overflow-auto mb-1" data-target="basic_info">
            <div class="row mx-0">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name" class="control-label">Full Name</label>
                        <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="gender" class="control-label">Gender</label>
                        <select name="gender" id="gender" class="form-select form-select-sm rounded-0" required>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dob" class="control-label">Date of Birth</label>
                        <input type="date" name="dob" id="dob" class="form-control form-control-sm rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="contact" class="control-label">Contact</label>
                        <input type="text" name="contact" id="contact" class="form-control form-control-sm rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control form-control-sm rounded-0" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="address" class="control-label">Address</label>
                        <textarea name="address" id="address" cols="30" rows="3" class="rounded-0 form-control form-control-sm" style="resize:none" required placeholder="Write here."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="summary" class="control-label">Tell us about your self</label>
                        <textarea name="summary" id="summary" cols="30" rows="4" class="rounded-0 form-control form-control-sm" style="resize:none" required placeholder="Write here."></textarea>
                    </div>
                </div>
            </div>
        </fieldset>
        <fieldset class="set-item flex-grow-1 h-100 overflow-auto mb-1" style="display:none" data-target="employment">
            <div class="row employment mx-0 border-bottom">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="company_name" class="control-label">Company Name</label>
                        <input type="text" name="company_name[]" id="company_name" class="form-control form-control-sm rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="from" class="control-label">From</label>
                        <input type="month" name="from[]" id="from" class="form-control form-control-sm rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="to" class="control-label">To</label>
                        <input type="month" name="to[]" id="to" class="form-control form-control-sm rounded-0" required>
                    </div>
                    <div class="form-check form-group form-switch">
                        <input class="form-check-input still_active" type="checkbox" name="still_active[]">
                        <label class="form-check-label">Employed till now?</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="position" class="control-label">Position</label>
                        <input type="text" name="position[]" id="position" class="form-control form-control-sm rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="brief_info" class="control-label">Brief Info of your work.</label>
                        <textarea name="brief_info[]" id="brief_info" cols="30" rows="3" class="rounded-0 form-control form-control-sm" style="resize:none" required placeholder="Write here."></textarea>
                    </div>
                    <div class="form-group d-flex justify-content-end py-1 w-100">
                        <div class="col-auto">
                            <button class="btn btn-sm btn-danger rounded-0" type="button" onclick="remove_employement($(this))"><i class="fa fa-trash"></i> Remove</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-2">
                <center>
                    <button class="btn btn-dark btn-sm btn-sm rounded-0" type="button" id="add_employment"><i class="fa fa-plus"></i> Add Employment</button>
                </center>
            </div>
        </fieldset>
        <fieldset class="set-item flex-grow-1 h-100 overflow-auto mb-1" style="display:none" data-target="educational">
            <div class="row educational mx-0 border-bottom">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="school_name" class="control-label">School Name</label>
                        <input type="text" name="school_name[]" id="school_name" class="form-control form-control-sm rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="school_from" class="control-label">From</label>
                        <input type="month" name="school_from[]" id="school_from" class="form-control form-control-sm rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="school_to" class="control-label">To</label>
                        <input type="month" name="school_to[]" id="school_to" class="form-control form-control-sm rounded-0" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="level" class="control-label">Level/Degree</label>
                        <input type="text" name="level[]" id="level" class="form-control form-control-sm rounded-0" required>
                    </div>
                    <div class="form-group">
                        <label for="school_address" class="control-label">Address</label>
                        <textarea name="school_address[]" id="school_address" cols="30" rows="3" class="rounded-0 form-control form-control-sm" style="resize:none" required placeholder="Write here."></textarea>
                    </div>
                    <div class="form-group d-flex justify-content-end py-1 w-100">
                        <div class="col-auto">
                            <button class="btn btn-sm btn-danger rounded-0" type="button" onclick="remove_education($(this))"><i class="fa fa-trash"></i> Remove</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-2">
                <center>
                    <button class="btn btn-dark btn-sm btn-sm rounded-0" type="button" id="add_education"><i class="fa fa-plus"></i> Add Education</button>
                </center>
            </div>
        </fieldset>
        <fieldset class="set-item flex-grow-1 h-100 overflow-auto mb-1" style="display:none" data-target="skills">
            <div class="form-group h-100">
                <div class="h-100 border roudned-2 p-2" id='tags-holder'>
                <span class='tags'></span>
                <span id="tags-text" contenteditable placeholder="Write your skills here"></span> 
                </div>
            </div>
        </fieldset>
        <fieldset class="set-item flex-grow-1 h-100 overflow-auto mb-1" style="display:none" data-target="message">
            <textarea name="message" id="message" cols="30" rows="10" class="form-control form-control-sm h-100" placeholder="Write you message here."></textarea>
        </fieldset>
        
        <div class="w-100 d-flex justify-content-between">
            <div class="col-auto">
                <button class="btn btn-primary btn-sm rounded-0" type="button" id="prev" disabled>Prev.</button>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary btn-sm rounded-0" type="button" id="next">Next</button>
                <button class="btn btn-primary btn-sm rounded-0" id="submit" style="display:none">Submit</button>
                <button class="btn btn-sm btn-dark rounded-0" type="button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
</form>
<script>
    function remove_employement(_this){
        var count = $('.employment').length
        if(count > 1){
            _this.closest('.employment').remove()
        }
    }
    function remove_education(_this){
        var count = $('.educational').length
        if(count > 1){
            _this.closest('.educational').remove()
        }
    }
$(function(){
    $('#add_employment').click(function(){
        var last_item = $('.set-item .employment').last()
        var cloned = last_item.clone()
        cloned.find('input, select, textarea').each(function(){
            $(this).removeClass('border-danger border-success')
            $(this).val('')
        })
        last_item.after(cloned)
        $(this).closest('fieldset').animate({scrollTop:$(this).offset().top},'fast')
        cloned.find('.still_active').change(function(){
            if($(this).is(":checked") === true){
                $(this).closest('.employment').find('input[name="to[]"]').val('').attr('readonly',true)
            }else{
                $(this).closest('.employment').find('input[name="to[]"]').attr('readonly',false)
            }
        })
    })
    $('#add_education').click(function(){
        var last_item = $('.set-item .educational').last()
        var cloned = last_item.clone()
        cloned.find('input, select, textarea').each(function(){
            $(this).removeClass('border-danger border-success')
            $(this).val('')
        })
        last_item.after(cloned)
        $(this).closest('fieldset').animate({scrollTop:$(this).offset().top},'fast')
    })
    $('.still_active').change(function(){
        if($(this).is(":checked") === true){
            $(this).closest('.employment').find('input[name="to[]"]').val('').attr('readonly',true)
        }else{
            $(this).closest('.employment').find('input[name="to[]"]').attr('readonly',false)
        }
    })
    $('input, select, textarea').on('input keydown change',function(){
        if($(this).val() != ''){
            $(this).removeClass('border-danger')  
            $(this).addClass('border-success')  
        }else{
            $(this).removeClass('border-success')  
            $(this).addClass('border-danger') 
        }
    })
    var fs_count= $('fieldset.set-item').length
    var afs = 0;
    function check_fields(){
        $('fieldset.set-item:visible').find('input[type="text"],input[type="number"],input[type="email"], select, textarea').each(function(){
            $(this).removeClass('border-danger')  
        })
        $('fieldset.set-item:visible').find('input[type="text"],input[type="number"],input[type="email"], select, textarea').each(function(){
            if($(this).val() == '')
            $(this).addClass('border-danger')  
        })
        if($('fieldset.set-item:visible .border-danger').length > 0){
            return false;
        }else{
            return true;
        }
    }
    $('#next').click(function(){
        if(!check_fields())
            return false;

        for(i = 0; i< fs_count; i++){
            var fs = $('fieldset.set-item').eq(i)
            if(fs.is(':visible') == true){
                afs = i+1
            }    
        }
        $('fieldset.set-item:visible').hide('slide',{direction:'left'},800)
        $('fieldset.set-item').eq(afs).show('slide',{direction:'right'},800)
        $('.set-title:visible').hide('slide',{direction:'left'},800)
        $('.set-title').eq(afs).show('slide',{direction:'right'},800)
        $('.stepProgressBar li').removeClass('active')
        $('.stepProgressBar li').eq(afs).addClass('active')
        if(afs > 0){
            $('#prev').attr('disabled',false)
        }
        if(afs == (fs_count -1)){
            $(this).hide()
            $('#submit').show()
        }
    })
    $('#prev').click(function(){
        if(!check_fields())
            return false;

        for(i = 0; i< fs_count; i++){
            var fs = $('fieldset.set-item').eq(i)
            if(fs.is(':visible') == true){
                afs = i-1
            }    
        }
        $('fieldset.set-item:visible').hide('slide',{direction:'right'},800)
        $('fieldset.set-item').eq(afs).show('slide',{direction:'left'},800)
        $('.set-title:visible').hide('slide',{direction:'right'},800)
        $('.set-title').eq(afs).show('slide',{direction:'left'},800)
        $('.stepProgressBar li').removeClass('active')
        $('.stepProgressBar li').eq(afs).addClass('active')
        if(afs == 0){
            $(this).attr('disabled',true)
        }
        $('#next').show()
        $('#submit').hide()
    })
    $('#tags-holder').on('focusin',function(){
        $('#tags-text').trigger('focus')
    })
    $('#tags-text').on('keypress',function(e){
        if(e.which == 44 ||e.which ==  13){
            e.preventDefault()
            create_skill()
        }
    })
    $('#tags-text').on('focusout',function(e){
        create_skill()
    })
    function create_skill(){
        var txt = $('#tags-text').text()
                txt = txt.replace(/,/gi,'')
            if(txt == '')
            return false;
            var input = $('<input type="hidden" name="skills[]">')
            input.val(txt)
            input.val(txt)
            var span = $("<span>")
                span.addClass('badge bg-success rounded-pill px-2 me-2 mb-2')
                span.text(txt)
                span.append(input)
            var btn = $("<span>")
                    btn.addClass('opacity-75 fs-6 fw-bold text-dark ms-3 fw-bold')
                    btn.text("x")
                    btn.css('cursor','pointer')
                span.append(btn)
            $('#tags-holder .tags').append(span)
            $('#tags-text').text('');
            btn.click(function(){
                $(this).parent().remove()
            })
    }
    $('#application-form').submit(function(e){
        e.preventDefault();
        $('#submit').attr('dasabled',true).text("Submitting Application...")
        var i = 0;
        $('.still_active').each(function(){
            $(this).attr('name','still_active['+i+']');
            i++;
        })
        $.ajax({
            url:"./Actions.php?a=save_application",
            method:"POST",
            data:$(this).serialize(),
            error:function(err){
                console.log(err)
                alert("An error occure please try again")
                $('#submit').attr('dasabled',false).text("Submit")
            },
            dataType:'json',
            success:function(resp){
                if(resp.status == 'success'){
                    uni_modal("success","success_message.php")
                }else{
                    alert("An error occure please try again")
                }
                $('#submit').attr('dasabled',false).text("Submit")
            }
        })
    })
})
</script>
