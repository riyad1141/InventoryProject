<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 animated fadeIn col-lg-6 center-screen">
            <div class="card w-90  p-4">
                <div class="card-body">
                    <h4>SIGN IN</h4>
                    <br/>
                    <label for="email"></label><input id="email" placeholder="User Email" class="form-control" type="email"/>
                    <br/>
                    <label for="password"></label><input id="password" placeholder="User Password" class="form-control" type="password"/>
                    <br/>
                    <button onclick="SubmitLogin()" class="btn w-100 bg-gradient-primary">Next</button>
                    <hr/>
                    <div class="float-end mt-3">
                        <span>
                            <a class="text-center ms-3 h6" href="{{url('/RegistrationPage')}}">Sign Up </a>
                            <span class="ms-1">|</span>
                            <a class="text-center ms-3 h6" href="{{url('/SendOtpPage')}}">Forget Password</a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

 async   function SubmitLogin () {
     let email = document.getElementById('email').value.trim();
     let password = document.getElementById('password').value;

     if (!email) {
         errorToast('Please enter your email');
     } else if (!password) {
         errorToast('Please enter your password');
     } else {
         showLoader();
         try {
             let response = await axios.post("/UserLogin", {
                 email: email,
                 password: password
             });
             hideLoader();

             if (response.status === 200 && response.data.status === 'success') {
                 successToast('User Login Successfully Completed');
                 setTimeout(function () {
                     window.location.href = "/DashboardPage";
                 }, 1000);
             } else {
                 errorToast(response.data.message || 'Invalid Email or password');
             }
         } catch (error) {
             hideLoader();
             errorToast('An error occurred');
             console.error('API Error:', error);
         }
     }
    }

</script>
