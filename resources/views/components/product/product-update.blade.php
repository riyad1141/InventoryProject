<div class="modal" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">


                                <label class="form-label">Category</label>
                                <label for="productCategoryUpdate"></label><select type="text" class="form-control form-select" id="productCategoryUpdate">
                                    <option value="">Select Category</option>
                                </select>

                                <label class="form-label">Name</label>
                                <label for="productNameUpdate"></label><input type="text" class="form-control" id="productNameUpdate">
                                <label class="form-label">Price</label>
                                <label for="productPriceUpdate"></label><input type="text" class="form-control" id="productPriceUpdate">
                                <label class="form-label">Unit</label>
                                <label for="productUnitUpdate"></label><input type="text" class="form-control" id="productUnitUpdate">
                                <br/>
                                <img class="w-15" id="oldImg" src="{{asset('images/default.jpg')}}" alt=""/>
                                <br/>
                                <label class="form-label">Image</label>
                                <input oninput="oldImg.src=window.URL.createObjectURL(this.files[0])"  type="file" class="form-control" id="productImgUpdate">

                                <label for="updateID"></label><input type="text" class="d-none" id="updateID">
                                <label for="filePath"></label><input type="text" class="d-none" id="filePath">


                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="update-modal-close" class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="update()" id="update-btn" class="btn btn-sm btn-success" >Update</button>
            </div>

        </div>
    </div>
</div>

<script>

    async  function UpdateFillCategoryDropDown() {
        let response = await axios.get("/CategoryList");
        response.data.forEach(function (item) {
            let option = `
            <option value="${item['id']}">${item['name']}</option>
            `
            $('#productCategoryUpdate').append(option);
        });
    }

    async  function FillUpUpdateForm (id,file_path) {
        document.getElementById('updateID').value = id;
        document.getElementById('filePath').value = file_path;
        document.getElementById('oldImg').src = file_path;
        showLoader();
        await UpdateFillCategoryDropDown();
        let response = await axios.post("/ProductById",{id:id});
        hideLoader();

        document.getElementById('productNameUpdate').value = response.data['name'];
        document.getElementById('productPriceUpdate').value = response.data['price'];
        document.getElementById('productUnitUpdate').value = response.data['unit'];
        document.getElementById('productCategoryUpdate').value = response.data['category_id'];

    }


    async function update () {
        let productNameUpdate = document.getElementById('productNameUpdate').value;
        let productPriceUpdate = document.getElementById('productPriceUpdate').value;
        let productUnitUpdate = document.getElementById('productUnitUpdate').value;
        let productCategoryUpdate = document.getElementById('productCategoryUpdate').value;
        let updateID = document.getElementById('updateID').value;
        let filePath = document.getElementById('filePath').value;
        let productImgUpdate = document.getElementById('productImgUpdate').files[0];

        if (productNameUpdate.length === 0){
            errorToast('productNameUpdate is required');
        }else  if (productPriceUpdate.length === 0){
            errorToast('productPriceUpdate is required');
        }else  if (productUnitUpdate.length === 0){
            errorToast('productUnitUpdate is required');
        }else  if (productCategoryUpdate.length === 0){
            errorToast('productCategoryUpdate is required');
        }else{
            document.getElementById('update-modal-close').click();

            let formData = new FormData();
            formData.append('name',productNameUpdate);
            formData.append('price',productPriceUpdate);
            formData.append('unit',productUnitUpdate);
            formData.append('category_id',productCategoryUpdate);
            formData.append('image',productImgUpdate);
            formData.append('id',updateID);
            formData.append('file_path',filePath);

            const config = {
                headers:{
                    'content-type': 'multipart/form-data'
                }
            }

            showLoader();
            let response = await axios.post("/UpdateProduct",formData,config);
            hideLoader();
            if (response.status === 200 && response.data === 1){
                successToast('Successfully update Completed');
                document.getElementById('update-form').reset();
                await getList();
            }else{
                errorToast('Request Fail Please try again');
            }

        }

    }
</script>
