<?php
include_once "config.php";

// the id of the topic
$idComment = $_GET['idComment'];
$id = $_GET['id'];

$query = "DELETE FROM comments WHERE id='$idComment'";

$result = mysqli_query($conn, $query);


// Check if the post was deleted, if not give error
if ($result) {
header('Location: ../views/blog.php?id='.$_GET['id']  );
}
