<?php
session_start();

include_once "../lib/config.php"; // Server and database configuration

$id = $_GET['id'];

$query = "SELECT first_name, last_name, email, username FROM users WHERE id = '$id'";

$result = mysqli_query($conn, $query);

// $row = mysqli_fetch_assoc($result);
//
// echo "<pre>";
// var_dump($row);
// die();

$resultCheck = mysqli_num_rows($result);

// $id = $_GET['id'];
// $query = "SELECT users.first_name, users.last_name, users.role, posts.id, posts.title,
//           posts.content, posts.user_id, posts.date, categories.name, comments.id as comment_id, comments.comment, comments.date
//           FROM posts
//           INNER JOIN
//           posts_categories ON posts.id = posts_categories.post_id
//           INNER JOIN comments ON posts.id = comments.post_id
//           INNER JOIN
//           categories ON posts_categories.category_id = categories.id
//           INNER JOIN
//           users ON posts.user_id = users.id
//           WHERE posts.id = '$id'";
//
// // perfoms the mysql query on databse with given database and server configuration
// $result = mysqli_query($conn, $query);
//
//
// $blogs = [];
//
// while ($row = $result->fetch_assoc()) {
//    $blogId = $row['id'];
//
//    if (array_key_exists($blogId, $blogs)) {
//          $blogs[$blogId]['comments'][$row['comment_id']] = $row['comment']; //comment -> [comment, date]
//       } else {
//          $blogs[$blogId] = $row;
//          $blogs[$blogId]['comments'][$row['comment_id']] = $row['comment'];
//       }
// }


// echo "<pre>";
// var_dump($blogs); die();
//
//
// $resultArr = mysqli_fetch_assoc($result);
//
// $row = mysqli_fetch_assoc($result);

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
  <link rel="stylesheet" type="text/css" href="../../public/css/queries.css">

</head>

<body>
  <!-- Navigation -->
<?php include "../includes/navbar.php";?>
  <!-- Page Content -->
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <h1 class="my-4">Blog / <small>CodeGorilla</small> </h1><button class="btn btn-primary btn-pri-custom" onclick="goUserpage(<?php echo $_SESSION['id'] ?>)">
           My Blogs <span class="badge badge-light"><i class="fas fa-home"></i></span></button>
        <h2 class="profile-title">Profile Of the blogger</h2>
        <div class="profile-card">
           <div class="container wrap">

        <div class="">
            <div class="well well-sm">

                    <div class="text-center pro-text">
                       <?php
                       if ($resultCheck > 0 ) {
                          while ($row = mysqli_fetch_assoc($result)) { ?>
                           <i class="fas fa-user-circle blogger-profile-avatar"></i>
                        <h4><?php echo $row['first_name'] . " " . $row['last_name']; ?></h4>
                        <p>
                            <i class="fas fa-envelope-square"></i> Email: <?php echo $row['email']; ?>
                            <br />
                            <i class="fas fa-user-check"></i> Username: <?php echo $row['username']; ?>
                            <br />
                        </p>
                    </div>
                    <?php
                 }
              }

                     ?>
            </div>
        </div>

</div>
        </div>
      </div>
      <div class="col-md-4 space-top">
         <?php include "../includes/welcome-msg.php";?>
         <?php include "../includes/search.php";?>
        <?php include "../includes/categories.php";?>
        <?php include "../includes/side-widget.php";?>
      </div>
    </div>
  </div>
<?php include "../includes/footer.php";?>

  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.0/tinymce.min.js"></script> -->

  <!-- Custom JS -->
  <script src="public/js/custom.js"></script>

  <!-- Ajax call function to delete a blog post-->
  <script>
    // Ajax call function, calls php delete script with the id of the post as a parameter in the function
   function deleteBlog(id) {
      if (confirm('Are you sure to delete this blog?')) {
        $.ajax({
         type: 'POST',
         url: 'resources/lib/delete_post.php',
         data: {
            delete_id: id
         }
        });
      }
      location.reload(); // reload the page after delete is completed
    }

    // Edit blog post function
    function editBlog(id, title, content) {
      $.ajax({
         type: 'POST',
         url: 'resources/views/edit.php',
         data: {
            edit_id: id,
            edit_title: title,
            edit_content: content
         }
      });
      window.location.href = 'resources/views/edit.php?edit_id=' + id;
    }

    function goUserpage(id) {
      $.ajax({
         type: 'POST',
         url: 'resources/views/user_page.php',
         data: {
         user_id: id,
         }
      });
      window.location.href = 'resources/views/user_page.php?user_id=' + id;
    }

   var clicks = 0
   function clickLike () {
     clicks++
     var likes = document.getElementById('like')
     likes.innerHTML = clicks
   }
   // var button = document.getElementById('like')
   // button.addEventListener('likeBtn', clickHandler)

   var clicksNo = 0
   function clickDislike () {
     clicksNo++
     var dislikes = document.getElementById('dislike')
     dislikes.innerHTML = clicksNo
   }
   // var button = document.getElementById('clickMe')
   // button.addEventListener('disBtn', clickHandler)

  </script>

</body>

</html>
