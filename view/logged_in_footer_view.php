<p> welcome <?php echo $user_name; ?> ! </p>
<p> logged in since: <?php echo $log_in_time; ?> </p>

<!--
<a href="/myApps/quizU/registration/index.php">My Portal</a>

<a href="<?php echo $user_portal;?>">My Portal</a>
-->

<form action="../registration/index.php" method="post">
<input type="hidden" name="action" value="send_logged_in_user_home">
<input type="submit" value="My Portal">
</form>
