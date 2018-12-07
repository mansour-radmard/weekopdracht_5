<?php
include_once "../lib/config.php";

if(isset($_REQUEST['submit'])){

   $first_name = mysqli_real_escape_string($conn, $_REQUEST["first_name"]);
   $last_name = mysqli_real_escape_string($conn, $_REQUEST["last_name"]);
   $username = mysqli_real_escape_string($conn, $_REQUEST["username"]);
   $email = mysqli_real_escape_string($conn, $_REQUEST["email"]);
   $password = mysqli_real_escape_string($conn, $_REQUEST["password"]);
   $password2 = mysqli_real_escape_string($conn, $_REQUEST["password2"]);

   $sql_user = "SELECT * FROM users WHERE username = '$username'";
  	$sql_email = "SELECT * FROM users WHERE email = '$email'";
  	$res_user = mysqli_query($conn, $sql_user);
  	$res_email = mysqli_query($conn, $sql_email);

   // check if username and email already exists if so give error
  	if (mysqli_num_rows($res_user) > 0) {
  	   $username_error = "This username is already taken!";
   } else if (mysqli_num_rows($res_email) > 0) {
  	   $email_error = "This email address is already registered";
  	} else if ($password != $password2) {
      $password_error = "Your passwords do not match!"; // if passwords don't match give error
   } else {
      $query = "INSERT INTO users (`first_name`, `last_name`, `username`, `email`, `password`, `role`)
      VALUES ('$first_name', '$last_name', '$username', '$email', SHA1('$password'), 'user')";
      $result = mysqli_query($conn, $query);

      if ($result) {
         echo "inserted";
      } else {
         echo "Not inserted";
      }
  	}

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <!-- Important meta tags -->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Title -->
  <title>Blog</title>

  <!-- Favicon -->
  <link rel="shortcut icon" href="#">

  <!-- Google fonts -->
  <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:300i,400,400i,700,700i,800,800i|PT+Sans:400,700,700i" rel="stylesheet">

  <!-- Fontawesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" type="text/css" href="../../vendors/css/normalize.css">
  <link rel="stylesheet" type="text/css" href="../../public/css/style.css">
  <link rel="stylesheet" type="text/css" href="../../public/css/login.css">
  <link rel="stylesheet" type="text/css" href="../../public/css/queries.css">

</head>

<body>
<?php include "../includes/navbar.php"?>

<div class="container">
   <div class="row">
      <div class="col-md-7 offset-md-3">
         <form class="text-center border border-light p-5 border-custom" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <p class="h4 mb-4">Sign up</p>
            <div class="form-row mb-4">
              <div class="col">
                  <input type="text" id="first_name" name="first_name" class="form-control" placeholder="First name" value="<?php echo $first_name; ?>" required>
              </div>
              <div class="col">
                  <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Last name" value="<?php echo $last_name; ?>" required>
              </div>
            </div>
            <div <?php if (isset($username_error)): ?> class="form_error" <?php endif ?> >
               <input type="text" id="username" name="username" class="form-control mb-4" placeholder="Username" required>
               <?php if (isset($username_error)): ?>
                  <span><?php echo $username_error; ?></span>
               <?php endif ?>
            </div>
            <div <?php if (isset($email_error)): ?> class="form_error" <?php endif ?> >
               <input type="email" id="email" name="email" class="form-control mb-4" placeholder="E-mail" value="<?php echo $email; ?>" required>
               <?php if (isset($email_error)): ?>
                  <span><?php echo $email_error; ?></span>
               <?php endif ?>
            </div>
            <div <?php if (isset($password_error)): ?> class="form_error" <?php endif ?> >
               <input type="password" id="password" name="password" class="form-control mb-4" placeholder="Password" aria-describedby="defaultRegisterFormPasswordHelpBlock" required>
               <?php if (isset($password_error)): ?>
                  <span><?php echo $password_error; ?></span>
               <?php endif ?>
            </div>
               <small id="defaultRegisterFormPasswordHelpBlock" class="form-text text-muted mb-4">
                  Retype your password
               </small>
               <input type="password" id="password2" name="password2" class="form-control mb-4" placeholder="Password" aria-describedby="defaultRegisterFormPasswordHelpBlock" required>
                  <button class="btn btn-info my-4 btn-block" type="submit" name="submit">Sign up</button>
               <hr>
               <p>By clicking
                  <em>Sign up</em> you agree to our
                  <a href="" target="_blank">terms of service</a> and
                   <a href="" target="_blank">terms of service</a>.
               </p>
         </form>
      </div>
   </div>
</div>

<!-- JQuery -->
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<!-- Custom JS -->
<script src="resources/js/custom.js"></script>

</body>

</html>
