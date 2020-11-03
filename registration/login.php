<?php include '../view/header.php'; ?>

<div>
    <h1>The Login Page</h1>
</div>

<form action="../registration/index.php" method="post">

    <input type="hidden" name="action" value="login_user">
    username: <input type="text" name="user_name"><br>
    password: <input type="text" name="user_password"><br>
    
    <input type="submit" value="log in!">

</form>

<?php
if(isset($error_msg))
    if(strlen($error_msg) != 0)
        echo $error_msg;

?>



<?php include '../view/footer.php'; ?>