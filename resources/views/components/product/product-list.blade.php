<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            <div class="card px-5 py-5">
                <div class="row justify-content-between ">
                    <div class="align-items-center col">
                        <h4>Product</h4>
                    </div>
                    <div class="align-items-center col">
                        <button data-bs-toggle="modal" data-bs-target="#create-modal" class="float-end btn m-0 btn-sm bg-gradient-primary">Create</button>
                    </div>
                </div>
                <hr class="bg-dark "/>
                <table class="table" id="tableData">
                    <thead>
                    <tr class="bg-light">
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Unit</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="tableList">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>

    getList();

    async  function getList () {
        showLoader();
        let response = await axios.get("/ProductList");
        hideLoader();

        let tableData = $('#tableData');
        let tableList = $('#tableList');

        tableData.DataTable().destroy();
        tableList.empty();


        response.data.forEach(function (item,index) {
            let row = `<tr>
            <td><img src="${item['image_url']}" alt="" class="w-15 h-auto"></td>
            <td>${item['name']}</td>
            <td>${item['price']}</td>
            <td>${item['unit']}</td>
            <td>
            <button data-id="${item['id']}" data-path="${item['image_url']}" class="btn btn-sm btn-outline-success editBtn">Edit</button>
            <button data-id="${item['id']}" data-path="${item['image_url']}" class="btn btn-sm btn-outline-danger deleteBtn">Delete</button>
           </td>
</tr>
            `
            tableList.append(row);
        });


        $('.editBtn').on('click', async function () {
            let id = $(this).data('id');
            let file_path = $(this).data('path');
            await FillUpUpdateForm(id, file_path)
            $('#update-modal').modal('show');
        });


        $('.deleteBtn').on('click',function () {
            let id = $(this).data('id');
            let file_path = $(this).data('path');
            $('#delete-modal').modal('show');
            $('#deleteID').val(id);
            $('#deleteFilePath').val(file_path);
        });

        new DataTable('#tableData',{
            order:[[0,'desc']],
            lengthMenu:[5,10,15,20,30]
        });



    }


</script>
