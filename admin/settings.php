<?php
require_once("../DBConnection.php");
?>
<h3><span class="fas fa-cogs"></span> Settings</h3>
<hr>
<div class="col-md-7">
    <form action="" id="settings-form">
        <div class="form-group">
            <label for="welcome" class="control-label">Welcome Content</label>
            <textarea name="welcome" id="welcome" cols="30" rows="3" class="form-control rounded-0 summernote" data-placeholder="Write the content here." data-height="40vh" required><?php echo is_file('../welcome.html') ? file_get_contents('../welcome.html') : '' ?></textarea>
        </div>
        <div class="form-group">
            <label for="about" class="control-label">About Content</label>
            <textarea name="about" id="about" cols="30" rows="3" class="form-control rounded-0 summernote" data-placeholder="Write the content here." data-height="40vh" required><?php echo is_file('../about.html') ? file_get_contents('../about.html') : '' ?></textarea>
        </div>
        <div class="form-group d-flex w-100 justify-content-end">
            <button class="btn btn-sm btn-primary rounded-0 my-1">Update</button>
        </div>
    </form>
</div>

<script>
    $(function(){
        $('#settings-form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            _this.find('button').attr('disabled',true)
            _this.find('button[type="submit"]').text('submitting form...')
            $.ajax({
                url:'./../Actions.php?a=save_settings',
                method:'POST',
                data:$(this).serialize(),
                dataType:'JSON',
                error:err=>{
                    console.log(err)
                    _el.addClass('alert alert-danger')
                    _el.text("An error occurred.")
                    _this.prepend(_el)
                    _el.show('slow')
                     _this.find('button').attr('disabled',false)
                     _this.find('button[type="submit"]').text('Save')
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        _el.addClass('alert alert-success')
                    }else{
                        _el.addClass('alert alert-danger')
                    }
                    _el.text(resp.msg)

                    _el.hide()
                    _this.prepend(_el)
                    _el.show('slow')
                     _this.find('button').attr('disabled',false)
                     _this.find('button[type="submit"]').text('Save')
                },
                complete:()=>{
                    $('#page-container').animate({scrollTop:0},'fast')

                }
            })
        })
    })
</script>