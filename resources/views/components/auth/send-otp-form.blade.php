<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90  p-4">
                <div class="card-body">
                    <h4>EMAIL ADDRESS</h4>
                    <br/>
                    <label>Your email address</label>
                    <label for="email"></label><input id="email" placeholder="User Email" class="form-control" type="email"/>
                    <br/>
                    <button onclick="VerifyEmail()"  class="btn w-100 float-end bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

 async  function VerifyEmail () {
     let email = document.getElementById('email').value.trim();

     if (!email) {
         errorToast('Please enter your email');
     } else {
         showLoader();
         try {
             let response = await axios.post("/SendOtpCode", {
                 email: email
             });
             hideLoader();

             if (response.status === 200 && response.data.status === 'success') {
                 successToast(response.data.message);
                 sessionStorage.setItem('email', email);
                 setTimeout(function () {
                     window.location.href = "/VerifyOtpPage";
                 }, 1000);
             } else {
                 errorToast(response.data.message || 'An error occurred');
             }
         } catch (error) {
             hideLoader();
             errorToast('An error occurred');
             console.error('API Error:', error);
         }
     }
    }

</script>
