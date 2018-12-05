<?php
include_once ("config.php");

if(isset($_POST['submit'])) {

   $comment = mysqli_real_escape_string($conn, $_POST["comment"]);
   $id = $_POST["id"];
   $user_name = $_POST["user_name"];

   $sql = "INSERT INTO comments (`comment`, `user`, `post_id`) VALUES ('$comment', '$user_name', '$id')";

   $result = mysqli_query($conn, $sql);

   if ($result) {
      header('Location: ../views/blog.php?id='.$_POST['id']);
   } else {
      echo "not inserted";
   }
}

?>
