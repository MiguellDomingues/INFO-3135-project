
<?php 

require('../helper_func_lib/helper_functions.php');


/*
register_user: 
    action when user attempts to create user name and password
    needs a DB check for the user name:
        if user name exists OR user_name/password is too long/short: 
            return error message and return to registration page
        else
            make a db entry and redirect user based on what kind of user they are

- need actions for:
    register_success
        - show a success page
    register_fail
        - show failure message, reason, and return to registration page
    login_success
        - go to the appropriate user menu
    login_fail
        - error message and return to login page




*/

$action = filter_input(INPUT_POST, 'action');

  /*
    get the user name, password, and selection box option

    if user name or password is too short
        - registration fail. return to registration page with appropriate fail message (user name too short)
    if user name not available
        - registration fail. return to registration page with appropriate fail message (user name in use)

    if the user name is available in db
        - registration sucess page, link to log in page

    */
  
if ($action == 'register_user') 
{
    $user_name = filter_input(INPUT_POST, 'user_name');
    $user_password = filter_input(INPUT_POST, 'user_password');
    $user_type = $_POST['user_type'];  

    $error_msg = validate_user_credentials($user_name, $user_password, $user_type);

    if(!user_credentials_valid($error_msg))
        include('register.php'); //if theres an error
    else
    {
        create_user_account($user_name, $user_password, $user_type);
        $error_msg = "registration success!";
        include('login.php');  
    }
} 
  /*
    get the user name, password, and attempt to log on;

    if user name and password is correct:
        - return the users info wrapped inside a User object
        - start a user session
        - link the user object to the session variable
        - go to the appropriate user portal
       
    if credentials are incorrect:
        - return to login page with error msg
    */
else if($action == 'login_user')
{
    $user_name = filter_input(INPUT_POST, 'user_name');
    $user_password = filter_input(INPUT_POST, 'user_password');
    $error_msg;

    $user = validate_user($user_name, $user_password);
    
    if($user != NULL) 
    {
        start_session($user);
        $PUT_ACTION = get_user_PUT_action($user);
        $url = $user->get_user_portal().$PUT_ACTION;
        movePage($num,$url);
        exit;
    }   
    else   
    {
        $error_msg = "login failed. invalid credentials ";
        include('login.php');
    }
   
}
/*
destroy the current user session and send user back to home page
*/
else if($action == 'logout_user')
{
    
    end_session(); 
    echo "logout";
    include("../index.php");
   
}
/*
restart the session (for some reason the session stops when the user clicks to go back to
their respective student/instructor index.php) and return to the student or instructor user portals
*/
else if($action == 'send_logged_in_user_home')
{
    session_start();
    $user = $_SESSION['logged_in_user'];
    $PUT_ACTION = get_user_PUT_action($user);
    $url = $user->get_user_portal().$PUT_ACTION;  
    movePage($num,$url);
    exit;
}


?>