<?php
include_once ("config.php");

if (isset($_POST["submit"])) {

   $first_name = mysqli_real_escape_string($conn, $_POST["first_name"]);
   $last_name = mysqli_real_escape_string($conn, $_POST["last_name"]);
   $username = mysqli_real_escape_string($conn, $_POST["username"]);
   $email = mysqli_real_escape_string($conn, $_POST["email"]);
   $password = mysqli_real_escape_string($conn, $_POST["password"]);

   $sql = "INSERT INTO users (`first_name`, `last_name`, `username`, `email`, `password`) VALUES ('$first_name', '$last_name', '$username', '$email', '$password')";

   $result = mysqli_query($conn, $sql);

   // var_dump($result);
   // exit();

   if($result) {
      echo "You have been signed up!";
   }
   else {
      echo "not inserted";
   }
}

?>
