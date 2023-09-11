<div class="modal" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Customer</h5>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <label for="customerName"></label><input type="text" class="form-control" id="customerName">
                                <label class="form-label">Customer Email *</label>
                                <label for="customerEmail"></label><input type="text" class="form-control" id="customerEmail">
                                <label class="form-label">Customer Mobile *</label>
                                <label for="customerMobile"></label><input type="text" class="form-control" id="customerMobile">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn btn-sm  btn-success" >Save</button>
            </div>
        </div>
    </div>
</div>
<script>

    async function Save () {
        let customerName = document.getElementById('customerName').value;
        let customerEmail = document.getElementById('customerEmail').value;
        let customerMobile = document.getElementById('customerMobile').value;


        if (customerName.length === 0){
            errorToast('Customer Name is Required');
        }else  if (customerEmail.length === 0){
            errorToast('Customer email is Required');
        }else  if (customerMobile.length === 0){
            errorToast('Customer mobile is Required');
        }else{
            document.getElementById('modal-close').click();
            showLoader();
            let response = await axios.post("/CustomerCreate",{
                name:customerName,
                email:customerEmail,
                mobile:customerMobile
            });
            hideLoader();
            if (response.status === 200){
                successToast('Customer Created successfully Completed');
                document.getElementById('save-form').reset();
                await getList();
            }else{
                errorToast('Request Was Fail');
            }
        }
    }
</script>
