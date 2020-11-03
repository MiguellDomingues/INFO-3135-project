<?php

define("MIN_USERNAME_LENGTH", 1);
define("MIN_PASSWORD_LENGTH", 1);

define("STUDENT_USER", "student_user");
define("INSTRUCTOR_USER", "instructor_user");

define("STUDENT_USER_PORTAL", "../student/index.php");
define("INSTRUCTOR_USER_PORTAL", "../instructor/index.php");



define("MAX_USERNAME_LENGTH", 25);
define("MAX_PASSWORD_LENGTH", 15);

require('../model/database.php');
require('../model/registration_db.php');
require('../model/courses_db.php');
require('../model/course_exams_db.php');
require('../model/exams_db.php');
require('../model/student_exams_db.php');


//get functions called inside exam builder module
require('exam_manager_helper_funcs.php');
require('exam_builder_helper_funcs.php');
require('student_helper_funcs.php');

function get_user_session()
{
    session_start();

    if(!isset($_SESSION['logged_in_user']))
    {
        echo 'ERROR! SESSION NOT SET';
        exit;
    }

    return $_SESSION['logged_in_user'];
}


/*
gets all the students that belong to each instructor course. invovles 2 db querys and a join:
    first get a list of courses from this instructor
        FOREACH of those courses, do another db query joining the course_id with registered_course_student tables course_id

this is essentually a double join, using php code to simplify it instead of having a giant sql statement
later i will clean it up and do it in a single sql query, but for now its functioning

*/
function get_instructor_students_array($instructor_id)
{
    $courses = READ_instructor_courses($instructor_id);

    $my_array = array();
    
    foreach($courses as $course) 
    { 
        $course_num = $course['course_num'];
        $course_students = READ_instructor_course_students($course_num);
        $my_array[$course['course_name']] = $course_students;        
    }

    return $my_array;
}

function movePage($num,$url)
{
    static $http = array (
        100 => "HTTP/1.1 100 Continue",
        101 => "HTTP/1.1 101 Switching Protocols",
        200 => "HTTP/1.1 200 OK",
        201 => "HTTP/1.1 201 Created",
        202 => "HTTP/1.1 202 Accepted",
        203 => "HTTP/1.1 203 Non-Authoritative Information",
        204 => "HTTP/1.1 204 No Content",
        205 => "HTTP/1.1 205 Reset Content",
        206 => "HTTP/1.1 206 Partial Content",
        300 => "HTTP/1.1 300 Multiple Choices",
        301 => "HTTP/1.1 301 Moved Permanently",
        302 => "HTTP/1.1 302 Found",
        303 => "HTTP/1.1 303 See Other",
        304 => "HTTP/1.1 304 Not Modified",
        305 => "HTTP/1.1 305 Use Proxy",
        307 => "HTTP/1.1 307 Temporary Redirect",
        400 => "HTTP/1.1 400 Bad Request",
        401 => "HTTP/1.1 401 Unauthorized",
        402 => "HTTP/1.1 402 Payment Required",
        403 => "HTTP/1.1 403 Forbidden",
        404 => "HTTP/1.1 404 Not Found",
        405 => "HTTP/1.1 405 Method Not Allowed",
        406 => "HTTP/1.1 406 Not Acceptable",
        407 => "HTTP/1.1 407 Proxy Authentication Required",
        408 => "HTTP/1.1 408 Request Time-out",
        409 => "HTTP/1.1 409 Conflict",
        410 => "HTTP/1.1 410 Gone",
        411 => "HTTP/1.1 411 Length Required",
        412 => "HTTP/1.1 412 Precondition Failed",
        413 => "HTTP/1.1 413 Request Entity Too Large",
        414 => "HTTP/1.1 414 Request-URI Too Large",
        415 => "HTTP/1.1 415 Unsupported Media Type",
        416 => "HTTP/1.1 416 Requested range not satisfiable",
        417 => "HTTP/1.1 417 Expectation Failed",
        500 => "HTTP/1.1 500 Internal Server Error",
        501 => "HTTP/1.1 501 Not Implemented",
        502 => "HTTP/1.1 502 Bad Gateway",
        503 => "HTTP/1.1 503 Service Unavailable",
        504 => "HTTP/1.1 504 Gateway Time-out"
    );
    header($http[$num]);
    header ("Location: $url");
 }

 function get_user_PUT_action($user)
 {
     if(strcmp($user->get_user_type(), STUDENT_USER) == 0) 
        return '?action=student_portal';
     else 
        return '?action=instructor_portal';
 }
 

/*
wrapper class for a logged in user
*/
class logged_in_user
{
    var $user_name;
    var $ID;
    var $user_type;
    var $user_portal;
    

    public function __construct ($user_name, $ID, $user_type, $user_portal)
    {
        $this->user_name = $user_name;
        $this->ID = $ID;
        $this->user_type = $user_type;
        $this->user_portal = $user_portal;
    }

    function get_user_name() { return $this->user_name; }
    function get_user_ID() { return $this->ID; }
    function get_user_type() { return $this->user_type; }
    function get_user_portal() { return $this->user_portal; }

}


/*
validate the user name/password length as defined by the above constants
also check for valid user_type just in case
return an appropriate error message on fail
if there was no fail the error message is an empty string
*/

function validate_user_credentials($user_name, $user_password, $user_type)
{
    $error_msg = "";

    if(!user_name_within_len($user_name))
        $error_msg =  $error_msg."user name invalid length. must be between 6 and 26 chars <br/>";
    if(!user_password_within_len($user_password))
        $error_msg =  $error_msg."user password invalid length. must be between 3 and 16 characters <br/>";
    if(!user_type_valid($user_type))
        $error_msg =  $error_msg."user type invalid. <br/>";
    if(user_name_exists($user_name))
        $error_msg = $error_msg."user name already exists! <br/>";

    return $error_msg;         
}

/*
wrapper functions to clearify obscure boolean conditionals
*/

function user_name_exists($user_name) {return (sizeOf(validate_username($user_name)) == 1);}
function user_name_within_len($user_name){return (strlen($user_name) >= MIN_USERNAME_LENGTH) && (strlen($user_name) <= MAX_USERNAME_LENGTH);}
function user_password_within_len($password){return (strlen($password) >= MIN_PASSWORD_LENGTH) && (strlen($password) <= MAX_PASSWORD_LENGTH);}
function user_credentials_valid($error_msg){return (strlen($error_msg) == 0);}
function user_type_valid($user_type){ return is_student_user($user_type) || is_instructor_user($user_type); }
function is_student_user($user_type){ return (strcmp($user_type, STUDENT_USER) == 0); }
function is_instructor_user($user_type){ return (strcmp($user_type, INSTRUCTOR_USER) == 0); }


/*
if a users username, password, and user type are valid, create appropriate entries in registered_user/student/instructor
tables
*/
function create_user_account($user_name, $password, $user_type)
{
    create_user($user_name, $password);

    if(is_student_user($user_type))
        create_student($user_name);
    else if(is_instructor_user($user_type))
        create_instructor($user_name);
        

}
/*
check if user name/password exists inside of registered_user table
    does not exist: return error message
else
    if user name exists, pass it to another function to get the user. this can be cleaned up with 
    an sql union or join. works right now.
*/
function validate_user($user_name, $password)
{
    $user = validate_credentials($user_name, $password);

    if(sizeOf($user) == 1)
        return get_user_info($user_name);
   
        
      assert(sizeOf($user) != 1);
      return NULL;
}

/*
check the student and instructor db's for what kind of user the logged on user is;
    if the user_name that was in registered_user matches the user_name in student: 
        return a student user object
    if the user_name that was in registered_user matches the user_name in instructor: 
        return an instructor user object
once i aquire better knowledge of using sql within php, ill clean this code up a bit by using a union
*/

function get_user_info($user_name)
{
    if(sizeOf($user = get_student($user_name)) == 1)
        return new logged_in_user($user_name, $user[0]['student_id'], STUDENT_USER, STUDENT_USER_PORTAL);
    if(sizeOf($user = get_instructor($user_name)) == 1)
        return new logged_in_user($user_name, $user[0]['instructor_id'], INSTRUCTOR_USER, INSTRUCTOR_USER_PORTAL);

    return NULL;
}

/*
start a session and assign the user object to the $_SESSION var
*/
function start_session($logged_in_user)
{
    if(isset($_SESSION))
        end_session();

    session_start();
    $_SESSION['logged_in_user'] = $logged_in_user;
    $_SESSION['log_in_time'] =  date("h:i:sa")." PST";
}

/*
destroy and unset all $_SESSION vars
*/
function end_session()
{
    session_start();
    session_unset();
    session_destroy();
}

?>