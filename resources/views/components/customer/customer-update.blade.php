<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Customer</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Customer Name *</label>
                                <label for="customerNameUpdate"></label><input type="text" class="form-control" id="customerNameUpdate">
                                <label class="form-label">Customer Email *</label>
                                <label for="customerEmailUpdate"></label><input type="text" class="form-control" id="customerEmailUpdate">
                                <label class="form-label">Customer Mobile *</label>
                                <label for="customerMobileUpdate"></label><input type="text" class="form-control" id="customerMobileUpdate">
                                <label for="updateID"></label><input type="text" class="d-none" id="updateID">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="update-modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Update()" id="update-btn" class="btn btn-sm  btn-success" >Update</button>
            </div>
        </div>
    </div>
</div>

<script>

    async  function FillUpUpdateForm(id) {
        document.getElementById('updateID').value = id;
        showLoader();
        let response = await axios.post("/CustomerById",{id:id});
        hideLoader();
        document.getElementById('customerNameUpdate').value = response.data['name'];
        document.getElementById('customerEmailUpdate').value = response.data['email'];
        document.getElementById('customerMobileUpdate').value = response.data['mobile'];
    }

    async   function Update() {
        let customerName = document.getElementById('customerNameUpdate').value;
        let customerEmail = document.getElementById('customerEmailUpdate').value;
        let customerMobile = document.getElementById('customerMobileUpdate').value;
        let updateID = document.getElementById('updateID').value;

        if (customerName.length === 0){
            errorToast('Customer Name is Required');
        }else  if (customerEmail.length === 0){
            errorToast('Customer email is Required');
        }else  if (customerMobile.length === 0){
            errorToast('Customer mobile is Required');
        }else{
            document.getElementById('update-modal-close').click();
            showLoader();
            let response = await axios.post("/CustomerUpdate",{
                name:customerName,
                email:customerEmail,
                mobile:customerMobile,
                id:updateID
            });
            hideLoader();
            if (response.status === 200){
                successToast('Update is Successful');
                document.getElementById('update-form').reset();
                await getList();
            }else{
                errorToast('Request Fail');
            }
        }

    }





</script>
