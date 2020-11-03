
<?php

/*
plan:
- show all courses:
    - this shows all instructor courses. each course will have a button to enroll
        - this creates an entry in the registered_course_student table

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

echo "INSIDE OF STUDENT INDEX.PHP: ".$action;

$user = get_user_session();
$student_id = $user->get_user_ID();

if($action == 'student_portal')
{
    include('student_portal.php');
}
/*
I need to change this so it splits the courses into 2 groups:
    - courses this student is enrolled in
    - all other courses
    - i need to join the registered_course_student table with courses to get the course names
*/
else if($action == 'view_available_courses')
{
    
    $error_msg;
    $enrolled_courses = READ_enrolled_courses($student_id);
    $non_enrolled_courses = READ_non_enrolled_courses($student_id);

    include('student_views/view_all_courses_view.php');
}
else if($action == 'enroll_into_course')
{
    $course_num= filter_input(INPUT_POST, 'course_num');
    
    $error_msg;

    if(CREATE_registered_course_student($course_num, $student_id))
        $error_msg = 'successfully enrolled into course!';
    else
        $error_msg = 'error!';

    $enrolled_courses = READ_enrolled_courses($student_id);
    $non_enrolled_courses = READ_non_enrolled_courses($student_id);

    include("student_views/view_all_courses_view.php");

}
else if($action == 'unenroll_from_course')
{
    $course_num = filter_input(INPUT_POST, 'course_num');
    $error_num;

    if(DELETE_enrolled_course($course_num, $student_id))
        $error_msg = 'successfully dropped course!';
    else
        $error_msg = 'error!!';

    $enrolled_courses = READ_enrolled_courses($student_id);
    $non_enrolled_courses = READ_non_enrolled_courses($student_id);
    
    include("student_views/view_all_courses_view.php");
}
/*
viewing and taking exams:
    - first get a list of student courses, then for each student course:
            get the course id and instructor name
            match that course id with a list of exam_id's
            wrap everything into an object


*/
else if($action == 'view_available_course_exams')
{
   echo "viewing my exams!";
   $my_array = get_student_course_exams_array($student_id);
   include("student_views/student_course_exams_view.php");
}
/*
when a student is browsing available course exams and clicks on the take exam buttom:
    get the exam_id from the POST
    search the questions table and match the exam_id to the question_id's
    with that data, build an exam object that wraps the exam and questions
    dynamically build the exam!
        need to figure out:
            completed exams are stored inside of student_course_exam?
                this allows students and instructors to review exams

            how do we check for completed exams ie filter out completed exams ?
                im thinking query all the exams inside of student_course_exams/course_exam and filter the rows
                where student_course_exams.exam_id != course_exam.exam_id
                             
*/
else if($action == 'take_course_exam')
{
   $exam_id = filter_input(INPUT_POST, 'exam_id');
   $course_id = filter_input(INPUT_POST, 'course_id');

   $exam = build_exam_object_from_db($exam_id);
   
    echo "TAKING EXAM";
   /*
   when you take an exam, build the exam object with the student/course/exam id's
   and query for all the questions linked to that exam

   once the object is built, display the object to the view as a form of radio buttons and labels
   -FIND A WAY TO EASILY GRT DATA FROM THE HTML FORM FOR A VARIABLE NUMBER OF QUESTIONS-
   */
   include('student_views/student_taking_exam_view.php'); 
   //view_exam_questions($exam);
   //take_exam($exam);
   //include("student_views/student_taking_exam_view.php");
   
}
else if($action == 'mark_exam')
{
    echo "marking EXAM";
    $exam_id = filter_input(INPUT_POST, 'exam_id');
    $course_id = filter_input(INPUT_POST, 'course_id');

    $exam = build_exam_object_from_db($exam_id);
    /*
   $exam_id = filter_input(INPUT_POST, 'exam_id');
   $course_id = filter_input(INPUT_POST, 'course_id');
   $exam_grade = take_exam($student_id, $course_id, $exam_id);

   //echo "finished exam: ".$exam_id;
   //echo "for course num: ".$course_id;
   //echo "for student id: ".$student_id;

   if($exam_grade < 0) 
   {
       echo "FAILED TO INSERT EXAM INTO DB";
       exit();
   }
   
   include("student_views/student_exam_marked_view.php");
   */

  if ( isset( $_POST['question_answers'] ) )
  {
    //$question_answers = filter_input(INPUT_POST, 'question_answers');
    $question_answers = $_POST['question_answers'];
    //echo sizeOf(filter_input(INPUT_POST, 'question_answers'));
    //echo $question_answers;
    print_r($question_answers);
  }

  
 
  $exam_grade = mark_student_exam($question_answers, $exam);
  CREATE_completed_course_exam($exam_id, $student_id, $course_id, $exam_grade);

  include("student_views/student_exam_marked_view.php");

  //echo sizeOf($question_answers);
   
}
/*
reviewing exams:
    all student exams in the student_course_exam table are considered completed exams
        here they will be able to click to review exams:
            first search for the exam inside of student_course_exam using course_id and student_id

*/

else if($action == 'review_course_exam')
{
   $exam_id = filter_input(INPUT_POST, 'exam_id');
   echo "reviewing exam: ".$exam_id;
   
}






?>