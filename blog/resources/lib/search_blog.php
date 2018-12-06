<?php
session_start();
include_once "config.php";

   if(isset($_POST['submit'])){

      $search = $_POST['search'];

      $sql = "SELECT users.first_name, users.last_name, users.role, posts.id, posts.title,
                posts.content, posts.user_id, posts.date, categories.name
                FROM posts
                INNER JOIN
                posts_categories ON posts.id = posts_categories.post_id
                INNER JOIN
                categories ON posts_categories.category_id = categories.id
                INNER JOIN
                users on posts.user_id = users.id
                WHERE content LIKE '%$search%'";

      $result = mysqli_query($conn, $sql);

      $resultCheck = mysqli_num_rows($result);



      if($result == 0) {
         echo "<h3>No result found!</h3>";
      } else {
         while($row=mysqli_fetch_assoc($query)) {

            if(!isset($_SESSION['username'])) {
               ?>
               <h3><?php echo $row['title']; ?></h3>
               <?php echo $row['content']; ?>
               <?php echo $row['id']; ?>
               <?php
            } else {
               ?>
               <h3>author: <?php echo $row['username']; ?></h3>
               <h3><?php echo $row['title']; ?></h3>
               <?php echo $row['content']; ?>
               <?php
            }
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
     <link rel="stylesheet" type="text/css" href="../../public/css/queries.css">

   </head>

   <body>
     <!-- Navigation -->
   <?php include "../includes/navbar.php";?>
     <!-- Page Content -->
     <div class="container">
       <div class="row">
         <div class="col-md-8">
           <h1 class="my-4">Blog / <small>CodeGorilla</small> </h1><button class="btn btn-primary btn-pri-custom" onclick="goUserpage(<?php echo $_SESSION['id'] ?>)">My Blogs <span class="badge badge-light"><i class="fas fa-home"></i></span></button>

   <?php
      if ($resultCheck > 0) {
         while ($row = mysqli_fetch_assoc($result)) { ?>
          <div class="card mb-4">
            <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">
            <div class="card-body">
            <h2 class="card-title"><?php echo $row['title']; ?></h2>
               <div class="card-details text-muted">
                 Posted on <?php echo $row['date']; ?>
               </div>
               <div class="category"> Topic: <?php echo $row['name']; ?>


                  <div class="badge badge-pill badge-info"> </div>
               </div>
               <p class="card-text"><?php echo $row['content']; ?></p>
               <a href="weekopdracht_5/blog/resources/views/blog.php?id=<?php echo $row['id'];?>">READ MORE</a>
             </div>
             <div class="card-footer text-muted">
               Author:  <?php echo $row['first_name'] . " " . $row['last_name']; ?>
             </div>
          </div>
   <?php
}
}
?>

         </div>
         <div class="col-md-4 space-top">
            <?php include "../includes/welcome-msg.php";?>
           <div class="card my-4">
             <h5 class="card-header">Search</h5>
             <div class="card-body">
               <div class="input-group">
                  <form action="resources/lib/search_blog.php" method="POST">
                 <input type="text" class="form-control" placeholder="Search for..." name="search">
                 <span class="input-group-btn">
                   <button type="submit" class="btn btn-secondary" name="submit">Go!</button>
                   </form>
                 </span>
               </div>
             </div>
           </div>
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
