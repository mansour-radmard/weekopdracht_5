<?php
session_start();
include_once "../lib/config.php";

$query = "SELECT * FROM users ORDER BY id ASC";

$result = mysqli_query($conn, $query);

// Check number of rows received from SQLiteDatabase
$resultCheck = mysqli_num_rows($result);
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
<?php include "../includes/navbar.php"?>
  <!-- Page Content -->
   <div class="container">
      <div class="row">
         <div class="col-md-8">
            <h1 class="my-4">Blog / <small>CodeGorilla / Bloggers</small>
            </h1><button class="btn btn-primary btn-pri-custom" onclick="goUserpage(<?php echo $_SESSION['id'] ?>)">My Blogs <span class="badge badge-light"><i class="fas fa-home"></i></span></button>
            <div>
               <h1><i class="fas fa-user bloggers-icon"></i>BLOGGERS</h1>
               <div>
               <?php
                  // If number of rows are bigger than 0
                  if ($resultCheck > 0) {
                      while ($row = mysqli_fetch_assoc($result)) { ?>
                     <ul>
                        <li> <a href="/weekopdracht_5/blog/resources/views/blogger_profile.php?id=<?php echo $row['id'];?>"><?php echo $row['first_name'] ." ". $row['last_name']; ?> </a></li>
                     </ul>
                     <?php
                     }
                  }
               ?>
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
  <!-- Custom JS -->
  <script src="public/js/custom.js"></script>

  <!-- Ajax call function to delete a blog post-->
  <script>
    // Ajax call function, calls php delete script with the id of the post as a parameter in the function
    function deleteBlog(id) {
      if (confirm('Are you sure to delete this blog?')) {
        $.ajax({
          type: 'POST',
          url: '/weekopdracht_5/blog/resources/lib/delete_post.php',
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
        url: '/weekopdracht_5/blog/resources/views/edit.php',
        data: {
          edit_id: id,
          edit_title: title,
          edit_content: content
        }
      });

      window.location.href = '/weekopdracht_5/blog/resources/views/edit.php?edit_id=' + id;
    }

    // User page function
    function goUserpage(id) {
      $.ajax({
         type: 'POST',
         url: '/weekopdracht_5/blog/resources/views/user_page.php',
         data: {
         user_id: id,
         }
      });
      window.location.href = '/weekopdracht_5/blog/resources/views/user_page.php?user_id=' + id;
    }

  </script>

</body>

</html>
