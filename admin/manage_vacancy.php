<?php
require_once("../DBConnection.php");
if(isset($_GET['id'])){
$qry = $conn->query("SELECT * FROM `vacancy_list` where vacancy_id = '{$_GET['id']}'");
    foreach($qry->fetchArray() as $k => $v){
        $$k = $v;
    }
}
?>
<div class="container-fluid">
    <form action="" id="Vacancy-form">
        <input type="hidden" name="id" value="<?php echo isset($vacancy_id) ? $vacancy_id : '' ?>">
        <div class="col-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title" class="control-label">Vacancy Title</label>
                        <input type="text" name="title" autofocus id="title" required class="form-control form-control-sm rounded-0" value="<?php echo isset($title) ? $title : '' ?>">
                    </div>
                    <div class="form-group">
                        <label for="designation_id" class="control-label">Designation</label>
                        <select name="designation_id" id="designation_id" class="form-select form-select-sm rounded-0" required>
                            <option <?php echo (!isset($designation_id)) ? 'selected' : '' ?> disabled>Please Select Here</option>
                            <?php
                            $designation = $conn->query("SELECT dd.*,(d.name || '-' ||dd.`name`) as info_name FROM designation_list dd inner join department_list d on dd.department_id = d.department_id order by `info_name` asc");
                            while($row= $designation->fetchArray()):
                            ?>
                                <option value="<?php echo $row['designation_id'] ?>" <?php echo (isset($designation_id) && $designation_id == $row['designation_id'] ) ? 'selected' : '' ?>><?php echo $row['info_name'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="slot" class="control-label">Slots</label>
                        <input type="number" min="1" name="slots"  id="slots" required class="form-control form-control-sm rounded-0 text-end" value="<?php echo isset($slot) ? $slot : 1 ?>">
                    </div>
                    <div class="form-group">
                        <label for="status" class="control-label">Status</label>
                        <select name="status" id="status" class="form-select form-select-sm rounded-0" required>
                            <option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?php echo isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="description" class="control-label">Description</label>
                        <textarea name="description" id="description" cols="30" rows="3" class="form-control rounded-0 summernote" data-placeholder="Write the description here." data-height="40vh" required><?php echo isset($description) ? $description : '' ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $(function(){
        $('#Vacancy-form').submit(function(e){
            e.preventDefault();
            $('.pop_msg').remove()
            var _this = $(this)
            var _el = $('<div>')
                _el.addClass('pop_msg')
            $('#uni_modal button').attr('disabled',true)
            $('#uni_modal button[type="submit"]').text('submitting form...')
            $.ajax({
                url:'./../Actions.php?a=save_vacancy',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error:err=>{
                    console.log(err)
                    _el.addClass('alert alert-danger')
                    _el.text("An error occurred.")
                    _this.prepend(_el)
                    _el.show('slow')
                     $('#uni_modal button').attr('disabled',false)
                     $('#uni_modal button[type="submit"]').text('Save')
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        _el.addClass('alert alert-success')
                        $('#uni_modal').on('hide.bs.modal',function(){
                            location.reload()
                        })
                        if("<?php echo isset($vacancy_id) ?>" != 1)
                        _this.get(0).reset();
                    }else{
                        _el.addClass('alert alert-danger')
                    }
                    _el.text(resp.msg)

                    _el.hide()
                    _this.prepend(_el)
                    _el.show('slow')
                     $('#uni_modal button').attr('disabled',false)
                     $('#uni_modal button[type="submit"]').text('Save')
                }
            })
        })
    })
</script>