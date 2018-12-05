<?php
session_start();
?>

<?php if($_SESSION['logged']) {?>
<div class="text-center welcome-msg">
   <h6>Welcome</h6>
   <h6><i class="far fa-check-circle"></i><?php echo $_SESSION['first_name'] . " " .  $_SESSION['last_name']; ?></h6>
</div>
<?php
}
?>
