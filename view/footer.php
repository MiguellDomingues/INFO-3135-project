<footer>
<p>-----------------------start of footer-------------------------------------------</p>
<?php


/*
my intention with the header/footer is to have the header show a tool bar for logged in users
that show user data and other functions. the footer will have a link for a user to get back to
the user portal, which is the home page for students/instructors to access the various functions
this is controlled by the session vars being set or not

*/
if(isset($_SESSION['logged_in_user']))
{
  
    echo "session is set </br>";

   
    
    echo sizeOf($_SESSION);

    $user_name = $_SESSION['logged_in_user']->get_user_name();
    $user_ID = $_SESSION['logged_in_user']->get_user_ID();
    $user_type = $_SESSION['logged_in_user']->get_user_type();
    $user_portal = $_SESSION['logged_in_user']->get_user_portal();
    $log_in_time = $_SESSION['log_in_time'];

  
   
    include("logged_in_footer_view.php");

}
else
{
    echo "session is not set";
    echo '<a href="/myApps/quizU/">Main Page</a>';
    echo '<a href="/myApps/quizU/registration/login.php">Login</a>';
    echo '<a href="/myApps/quizU/registration/register.php">Register</a>';
}

?>
    <p class="copyright">
        &copy; <?php echo date("Y"); ?> QuizU footer
    </p>
    <p>-----------------------end of footer-------------------------------------------</p>
</footer>
</body>
</html>