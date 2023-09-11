<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-10 center-screen">
            <div class="card animated fadeIn w-100 p-3">
                <div class="card-body">
                    <h4>Sign Up</h4>
                    <hr/>
                    <div class="container-fluid m-0 p-0">
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <label>Email Address</label>
                                <label for="email"></label><input id="email" placeholder="User Email" class="form-control" type="email"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>First Name</label>
                                <label for="firstName"></label><input id="firstName" placeholder="First Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Last Name</label>
                                <label for="lastName"></label><input id="lastName" placeholder="Last Name" class="form-control" type="text"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Mobile Number</label>
                                <label for="mobile"></label><input id="mobile" placeholder="Mobile" class="form-control" type="number"/>
                            </div>
                            <div class="col-md-4 p-2">
                                <label>Password</label>
                                <label for="password"></label><input id="password" placeholder="User Password" class="form-control" type="password"/>
                            </div>
                        </div>
                        <div class="row m-0 p-0">
                            <div class="col-md-4 p-2">
                                <button onclick="onRegistration()" class="btn mt-3 w-100  bg-gradient-primary">Submit All</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

  async  function onRegistration () {
      let firstName = document.getElementById('firstName').value.trim();
      let lastName = document.getElementById('lastName').value.trim();
      let email = document.getElementById('email').value.trim();
      let mobile = document.getElementById('mobile').value.trim();
      let password = document.getElementById('password').value;

      if (!firstName) {
          errorToast('Please enter your first name');
      } else if (!lastName) {
          errorToast('Please enter your last name');
      } else if (!email) {
          errorToast('Please enter your email');
      } else if (!mobile) {
          errorToast('Please enter your mobile');
      } else if (!password) {
          errorToast('Please enter your password');
      } else {
          showLoader();
          try {
              let response = await axios.post("/UserRegistration", {
                  firstName: firstName,
                  lastName: lastName,
                  email: email,
                  mobile: mobile,
                  password: password
              });
              hideLoader();

              if (response.status === 200 && response.data.status === 'success') {
                  successToast('User Registration Successfully Completed');
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
