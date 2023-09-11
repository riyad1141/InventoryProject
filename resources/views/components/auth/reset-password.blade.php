<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-6 center-screen">
            <div class="card animated fadeIn w-90 p-4">
                <div class="card-body">
                    <h4>SET NEW PASSWORD</h4>
                    <br/>
                    <label>New Password</label>
                    <label for="password"></label><input id="password" placeholder="New Password" class="form-control" type="password"/>
                    <br/>
                    <label>Confirm Password</label>
                    <label for="conformPassword"></label><input id="conformPassword" placeholder="Confirm Password" class="form-control" type="password"/>
                    <br/>
                    <button onclick="ResetPassword()" class="btn w-100 bg-gradient-primary">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

  async  function ResetPassword () {
      let password = document.getElementById('password').value;
      let confirmPassword = document.getElementById('conformPassword').value;

      if (!password) {
          errorToast('Please enter your password');
      } else if (!confirmPassword) {
          errorToast('Please enter your confirm password');
      } else if (password !== confirmPassword) {
          errorToast('Password and confirm password must match');
      } else {
          showLoader();
          try {
              let response = await axios.post("/PasswordReset", { password: password });
              hideLoader();

              if (response.status === 200 && response.data.status === 'success') {
                  successToast(response.data.message);
                  setTimeout(function () {
                      window.location.href = "/LoginPage";
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
