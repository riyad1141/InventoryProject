<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Category</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category Name *</label>
                                <label for="categoryNameUpdate"></label><input type="text" class="form-control" id="categoryNameUpdate">
                                <label for="updateID"></label><input class="d-none" id="updateID">
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
        let response = await axios.post("/CategoryByID",{id:id});
        hideLoader();
        document.getElementById('categoryNameUpdate').value = response.data['name'];
    }

    async  function Update() {
        let CategoryName = document.getElementById('categoryNameUpdate').value;
        let UpdateId = document.getElementById('updateID').value;

        if (CategoryName.length === 0){
            errorToast('category Name is required')
        }else{
            document.getElementById('update-modal-close').click();
            showLoader();
            let response = await axios.post("/CategoryUpdate",{
                name:CategoryName,
                id:UpdateId
            });
            hideLoader();
            if (response.status === 200 && response.data === 1){
                document.getElementById('update-form').reset();
                successToast('Request Success');
                await getList()
            }else{
                errorToast('Request Failed');
            }
        }

    }



</script>
