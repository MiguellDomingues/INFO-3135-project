<?php

/*
if im going to have a single php page 'course_exam_view' be called after i update exams so much, i need to always call get_course_exams_arrays
factor the include and the function call into a single function call update_course_exam_view. cleaner code.

*/

require('../helper_func_lib/helper_functions.php');


$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) 
{
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'ERROR NO ACTION';
    }
}  

echo "INSIDE OF INSTRUCTOR_EXAM_MANAGER INDEX.PHP: ".$action;

$user = get_user_session();
$instructor_id = $user->get_user_ID();
$instructor_name = $user->get_user_name();



/*
    when the user clicks on view course exams, the page will show a list of instructor courses:
        for each course, show a list of course exams, and a add exam buttom
            for each course exam, show 2 buttons:
                    modify this cours exam
                    delete this course exam


        RIGHT NOW THIS SHOWS COURSE ID'S INSTEAD OF COURSE NAMES FOR EXAMS
        MODIFY QUERY TO SHOW COURSE NAMES
*/
if($action == 'exam_manager_portal')
{
    update_course_exam_view($instructor_id, $instructor_name);
}


/*
when the user clicks to create course exams:
    pass it the course_number
        first create a new exam entry in db
            get the exam id of that new entry
            make a new course_exam entry with the course_id and exam_id

for now we will be creating essentually blank exams to test exam binding/unbinding to courses, and to test
students viewing there course exams for courses they registered for.
*/
else if($action == 'attach_course_exam')
{
    $course_num = filter_input(INPUT_POST, 'course_num');
    $selected_exam_id = $_POST['selected_exam'];  

    echo "INSIDE ATTACH_COURSE: ".$course_num." and ".$selected_exam_id;
  
    if(!CREATE_course_exam($course_num, $selected_exam_id))
    {
        echo "ERROR! FAILED TO ATTACH COURSE INSIDE OF attach_course_exam ACTION! ".$selected_exam_id;
        
    }

   update_course_exam_view($instructor_id, $instructor_name);
}
else if($action == 'view_course_exam')
{
    $course_id = filter_input(INPUT_POST, 'course_id');
    $exam_id = filter_input(INPUT_POST, 'exam_id');
    
   echo "VIEWING course exam: ";
   echo "course_id: ".$course_id;
   echo "exam_id: ".$exam_id;

   $exam = build_exam_object_from_db($exam_id);

   include('instructor_exam_manager_views\course_exam_exam_view.php');
   

   //update_course_exam_view($instructor_id, $instructor_name);
}
else if($action == 'remove_course_exam')
{
    $exam_id = filter_input(INPUT_POST, 'exam_id');
    $course_id = filter_input(INPUT_POST, 'course_id');

   echo "remove course exam: ";
   echo " exam id ".$exam_id;
   echo " course id ".$course_id;

   if(!DELETE_course_exam($exam_id, $course_id))
   {
       echo "ERROR! FAILED TO DELETE INSIDE OF delete_course_exam ACTION!";
       exit();
   }

   update_course_exam_view($instructor_id, $instructor_name);
   
}






/*
else if($action == 'modify_course_exam')
{
    $exam_id = filter_input(INPUT_POST, 'exam_id');
   echo "modify course exam".$exam_id."the instructor id is: ".$instructor_id;

   update_course_exam_view($instructor_id, $instructor_name);
}

*/



?>