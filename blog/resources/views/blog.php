<?php
session_start();

include_once "../lib/config.php"; // Server and database configuration

$id = $_GET['id'];
$query = "SELECT users.first_name, users.last_name, users.role, posts.id, posts.title,
          posts.content, posts.user_id, posts.date, categories.name, comments.id as comment_id, comments.comment, comments.date
          FROM posts
          INNER JOIN
          posts_categories ON posts.id = posts_categories.post_id
          INNER JOIN comments ON posts.id = comments.post_id
          INNER JOIN
          categories ON posts_categories.category_id = categories.id
          INNER JOIN
          users ON posts.user_id = users.id
          WHERE posts.id = '$id'";

// perfoms the mysql query on databse with given database and server configuration
$result = mysqli_query($conn, $query);


$blogs = [];

while ($row = $result->fetch_assoc()) {
   $blogId = $row['id'];

   if (array_key_exists($blogId, $blogs)) {
         $blogs[$blogId]['comments'][$row['comment_id']] = $row['comment']; //comment -> [comment, date]
      } else {
         $blogs[$blogId] = $row;
         $blogs[$blogId]['comments'][$row['comment_id']] = $row['comment'];
      }
}


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
        <h1 class="my-4">Blog / <small>CodeGorilla</small> </h1><button class="btn btn-primary btn-pri-custom" onclick="goUserpage(<?php echo $_SESSION['id'] ?>)">My Blogs <span class="badge badge-light"><i class="fas fa-home"></i></span></button>
         <div class="card mb-4 blog-body-no-border">
            <img class="card-img-top" src="http://placehold.it/750x300" alt="Card image cap">
            <div class="card-body card-body-padding">
               <div class="row">
                  <div class="col-md-7">
                     <?php foreach($blogs as $value) { ?>
                     <h2 class="card-title card-title-blog"><?php echo $value['title']; ?></h2>

                  </div>
                  <div class="col-md-5">
                     <ul class="blog-share">
                        <li>Share:</i></li>
                        <li><i class="fab fa-facebook-f"></i></li>
                        <li><i class="fab fa-twitter"></i></li>
                        <li><i class="fab fa-whatsapp"></i></li>
                        <li><i class="fab fa-google-plus-g"></i></li>
                        <li><i class="fas fa-envelope-square"></i></li>
                        <li><i class="fas fa-print"></i></li>
                     </ul>
                  </div>
                  <div class="col-md-12">
                     <div class="border-title"></div>
                  </div>
               </div>
               <div class="card-details text-muted">

                 Posted on <?php echo $value['date']; ?> <span class="blog-auth">by: <?php echo $value['first_name'] . " " . $value['last_name']; ?></span>

               </div>

               <div class="category"> Topic: <?php echo $value['name']; ?></div>


               <p class="card-text"><?php echo $value['content']; ?></p>

            </div>

            <div class="card-footer text-muted card-footer-custom">
               Author: <?php echo $value['first_name'] . " " . $value['last_name']; ?>

            </div>
         </div>
      </div>
      <div class="col-md-4 space-top">
         <div class="card my-4">
           <h5 class="card-header">Search</h5>
            <div class="card-body">
               <div class="input-group">
                 <input type="text" class="form-control" placeholder="Search for...">
                 <span class="input-group-btn">
                   <button class="btn btn-secondary" type="button">Go!</button>
                 </span>
               </div>
            </div>
         </div>
        <?php include "../includes/categories.php";?>
        <?php include "../includes/side-widget.php";?>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8">
         <div class="title" id="comments">
               <i class="far fa-comment-alt"></i> <h3>Comments Area</h3>
         </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-8" align="center">
         <div class="media-area">
            <div class="media">
               <a class="pull-left" href="#paper-kit">
                  <!-- <div class="avatar">
                  <img class="media-object" src="assets/img/faces/clem-onojeghuo-2.jpg" alt="..."/>
                  </div> -->
               </a>
               <div class="media-body">
                  <hr data-brackets-id="12673">
                  <ul data-brackets-id="12674" id="sortable" class="list-unstyled ui-sortable">
                      <!-- <strong class="pull-left primary-font text-center">Guest</strong>
                      <small class="pull-right text-muted">
                         <span class="glyphicon glyphicon-time text-center"></span>Sep 11, 11:53 AM</small> -->
                      </br>
                         <?php foreach ($value['comments'] as $com) { ?>
                            <div class="comment-box text-center">
                            <small class="pull-right text-muted">
                               <strong class="pull-left primary-font text-center">Guest</strong>
                               <span class="glyphicon glyphicon-time text-center"></span>Sep 11, 11:53 AM</small><span class="pull-right" style="float: right"><i class="fas fa-trash-alt"></i></span>
                                <li class="ui-state-default text-center"><?php echo $com; ?></li><br />
                                <div style="float: left;">
                                   <i style="margin-right: 3rem;"><a onclick="clickLike()"><i class="far fa-thumbs-up"></a></i><span class="thumbs-up-int" id="like">0</span></i><a onclick="clickDislike">
                                      <i class="far fa-thumbs-down"></i></a><span class="thumbs-down-int" id="dislike">0</span>
                                </div>
                            </div>
                            </br>

                      <?php
                     }
                      ?>


                      </br>
                  </ul>
               <!-- <div class="pull-right">
                  <h6 class="text-muted">Sep 11, 11:53 AM</h6>
               </div> -->

                  <!-- <span class="text-muted">Guest wrote:</span>
                  <p class="blog-comments"></p> -->

               <div class="media media-post">
                  <form class="blog-form" action="../lib/send_comment.php" method="POST">
                     <input name="id" value="<?php echo $id; ?>" hidden>
                     <div class="media-body">
                        <textarea class="form-control" placeholder="Write a nice comment or leave this blog..." rows="4" name="comment"></textarea>
                           <div class="media-footer">
                              <a href=""><button class="btn btn-info pull-right" type="submit" name="submit">Comment</button></a>
                           </div>
                     </div>
                  </form>
            <?php
         }
         ?>
               </div> <!-- end media-post -->
               </div>
            </div> <!-- end media -->
         </div>

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
