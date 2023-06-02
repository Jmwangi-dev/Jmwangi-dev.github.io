<style>
    #uni_modal .modal-header,#uni_modal .modal-footer{
        display:none !important;
    }
</style>
<div class="container-fluid py-4" id="success_modal">
    <p>Your Application was successfully submitted. We will reach on your given contact and email regarding to your application. Thank you.</p>
    <div class="w-100 d-flex justify-content-end">
        <button class="btn btn-sm btn-dark rounded-0" type="button" data-bs-dismiss="modal">Close</button>
    </div>
</div>
<script>
    $(function(){
        $('#uni_modal').on('hide.bs.modal',function(){
            if($(this).find('#success_modal').length >0){
                location.reload()
            }
        })
    })
</script>