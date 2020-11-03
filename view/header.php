<!DOCTYPE html>
<html>

<head>
    <title>QuizU</title>
    <link rel="stylesheet" type="text/css" href="/myApps/quizU/main.css">
          
</head>

<!-- the body section -->
<body>
<p>-----------------------start of header-------------------------------------------</p>
<?php



if(isset($_SESSION['logged_in_user']))
{
    echo "session is set"."<br>";
    echo "in header: "."the session has ".sizeOf($_SESSION)." vars"."<br>";
    
   $user_name = $_SESSION['logged_in_user']->get_user_name();
    $user_ID = $_SESSION['logged_in_user']->get_user_ID();
    $user_type = $_SESSION['logged_in_user']->get_user_type();

    if(isset($_SESSION['exam_under_construction'])) echo "currently have an exam under construction"."<br>";
    
    include("logged_in_header_view.php");
    
}
else
{
    echo "session is not set";

}
    
?>
<p>-----------------------end of header-------------------------------------------</p>
<header><h1>QuizU header</h1></header>

