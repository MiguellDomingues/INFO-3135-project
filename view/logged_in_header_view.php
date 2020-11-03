<ul>
  <li>user name = <?php echo $user_name; ?></li>
  <li>user ID = <?php echo $user_ID; ?> </li>
  <li>user type = <?php echo $user_type; ?></li>
</ul>

<form action="../registration/index.php" method="post">
<input type="hidden" name="action" value="logout_user">
<input type="submit" value="log out!">
</form>






