<?php include '../view/header.php'; ?>

<h1>The Register Page</h1>

<form action="index.php" method="post">

    <input type="hidden" name="action" value="register_user">
    username: <input type="text" name="user_name"><br>
    password: <input type="text" name="user_password"><br>
    register as:

    <select name="user_type">
        <option value="student_user">Student</option>
        <option value="instructor_user">Instructor</option>
   </select>

    <input type="submit">

</form>

<?php
if(isset($error_msg))
    echo "error:".$error_msg;
  
?>


<?php include '../view/footer.php'; ?>