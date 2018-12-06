<?php
session_start();
?>

<?php if($_SESSION['logged']) {?>
<div class="welcome-msg text-center label label-default">
   <h6><i class="far fa-check-circle"></i>Welcome <?php echo $_SESSION['first_name'] . " " .  $_SESSION['last_name']; ?></h6>
</div>
<?php
}
?>
