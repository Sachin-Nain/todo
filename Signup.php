<?php include("./controller/signup_validation.php"); ?>
<?php include "./view/header.php" ?>

<?php if ($same_email == 1) { ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Sorry,</strong> This email already exists. Try Signup using another email.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php } else if ($no_error == 1) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Congratulations,</strong> You have successfully created an account.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } else if ($password_error == 1) { ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Sorry,</strong> Both Passwords did not match.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
<?php } ?>

<div class="container my-4">
  <form action="Signup.php" method="post">
    <div class="mb-3">
      <label for="uname" class="form-label">User Name</label>
      <input type="text" class="form-control" id="uname" name="uname" aria-describedby="emailHelp" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email address</label>
      <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
      <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" id="password" name="password" required autocomplete>
    </div>
    <div class="mb-3">
      <label for="cpassword" class="form-label">Confirm Password</label>
      <input type="password" class="form-control" id="cpassword" name="cpassword" required autocomplete>
      <div id="emailHelp" class="form-text">Please make sure your password match.</div>
    </div>
    <button type="submit" class="btn btn-primary">Signup</button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>