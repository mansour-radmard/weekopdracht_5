<?php
   require_once("nbbc.php");
   $bbcode = new BBCode;

   if(isset($_POST['zoek'])){
      $zoekbalk = $_POST['zoekbalk'];
      $con=mysqli_connect("localhost","root","","blog2");
      $sql = "SELECT * FROM post WHERE title LIKE '%$zoekbalk%'";
      $query=mysqli_query($con, $sql);
      $rowcount=mysqli_num_rows($query);
      echo $rowcount;
      if($rowcount ==0){
           echo "<h3>Geen resultaat!</h3>";
      } else {
      while($row=mysqli_fetch_assoc($query)) {
           if(!isset($_SESSION['username'])) {
               //true al ingelogd
               ?>
               <h3><?php echo $row['title']; ?></h3>
               <?php echo $row['content']; ?>
               <?php
           } else {
               ?>
               <h3>author: <?php echo $row['author']; ?></h3>
               <h3><?php echo $row['title']; ?></h3>
               <?php echo $row['content']; ?>
               <?php
           }
      }
      }
   }
   ?>
