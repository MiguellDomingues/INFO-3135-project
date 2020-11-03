<?php

require('../helper_func_lib/helper_functions.php');


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) 
{
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'ERROR NO ACTION';
    }
}  

echo "INSIDE OF INSTRUCTOR INDEX.PHP: ".$action;

$user = get_user_session();

if($action == 'instructor_portal')
{
    include('instructor_portal.php');
}
else if($action == 'show_create_course_view')
{
    $courses = READ_courses();
    include('instructor_views/create_instructor_course_view.php');

}

 /*
    make it so all courses displays above so instructor does not create duplicate courses
    check if course_name exists in db
        if not, create a new course with instructor_id as FK
    when successful, run this action again OR go back to portal OR go to the course display
    */

else if($action == 'create_course')
{
    $course_name= filter_input(INPUT_POST, 'course_name');
    $instructor_id = $user->get_user_ID();
    $error_msg;
    
    /*
    wrap this in a method that checks length constraints
    set it inside db maybe
    */
    if(strlen($course_name) != 0 && CREATE_instructor_course($course_name, $instructor_id))
        $error_msg = "success";
    else
        $error_msg = "error. no duplicate or empty course names!";
    
    $courses = READ_courses();
    include('instructor_views/create_instructor_course_view.php');
}
else if($action == 'view_my_courses')
{
    $instructor_id = $user->get_user_ID();
    $instructor_name = $user->get_user_name();
    $courses = READ_instructor_courses($instructor_id);
    include('instructor_views\instructor_courses_view.php');
}

/*

getting instructor course students seperated by course:
    first query the course nums for instructor courses READ_instructor_courses($instructor_id):
    
    foreach course num and course name:
            query the registered students table by course_num and display them all

*/



else if($action == 'view_my_course_students')
{
    $instructor_id = $user->get_user_ID();
    $instructor_name = $user->get_user_name();
    $my_array = get_instructor_students_array($instructor_id);

    include('instructor_views\course_student_view.php');

}
else if($action == 'delete_course')
{
    $course_num = filter_input(INPUT_POST, 'course_num');
    $instructor_id = $user->get_user_ID();
    $instructor_name = $user->get_user_name();
    
    DELETE_instructor_course($instructor_id, $course_num);

    $courses = READ_instructor_courses($instructor_id);

    include('instructor_views\instructor_courses_view.php');
}

else if($action == 'exam_manager_portal')
{
   

    include('instructor_views\instructor_courses_view.php');
}



?>