<?php

/*
BUILDING COURSE EXAMS PORTAL:
    2 sub-pages:
        - view all exams in bd split by 'owned by this instructor' and 'owned by other instructors'
            echo all the exam data (id/owner/name/creation date)
            the exams owned by this instructor will also list the different courses this exam is attached to
                obivously these will be courses taught by this instructor as well

            create exam: undecided on how to proceed with this: just straight build an exam, modify my exams
            or modify other instructors exams by copying it, giving it a new exam_id/exam_owner and giving all the copied questions new question_id's
                - for now just create empty exams to test student exam taking

            also undecided on exam deletion, or even modifying: if an instructor modifies his exam and its being used by another instructor for their courses,
            it screws everything. especially for deletion
                i think if an instructor wants to use another instructor exam, CREATE A COPY!

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

echo "INSIDE OF INSTRUCTOR_EXAM_BUILDER INDEX.PHP: ".$action;

$user = get_user_session();
$instructor_id = $user->get_user_ID();
$instructor_name = $user->get_user_name();



if($action == 'exam_builder_portal')
{
    include('instructor_exam_builder_portal.php');
}
/*
grab all the exams and list the instructor owned exams first then the non-instructor owned
- just use 2 seperate queries
    - each exam can be viewed and copied
    - instructor exams can be viewed and modified
        - if an exam is attached to any courses, then modifying an exam will create a copy
        - NO deleting exams if its attached to any courses
        - NEED A 'is_exam_attached_to_any_courses' function:
            - join exams and course exams on exam_id.

*/
else if($action == 'view_all_exams')
{   
    $my_array = get_exam_courses_array($instructor_id);
    $other_instructor_exams = READ_other_instructor_exams($instructor_id);
    
    include('instructor_exam_builder_views\view_all_exams_view.php');
}
else if($action == 'create_exam')
{
    /* 
        here we create tester blank exams, then test to ensure students of the instructor course can take them and those go into the completed exams
        table, where instructors can view them
    */
    echo "CREATING EXAM";

    $exam = get_SESSION_exam_object($instructor_id);
    echo "testing exam object: ".$exam->get_exam_owner();
    
    //fill up view exam object
    include('instructor_exam_builder_views\building_exam_view.php');
}
else if($action == 'view_exam')
{   
    echo "VIEWING EXAM";
    $exam_id = filter_input(INPUT_POST, 'exam_id');
    $exam = build_exam_object_from_db($exam_id);
    //$instructor_exams = READ_instructor_exams($instructor_id);
    //$other_instructor_exams = READ_other_instructor_exams($instructor_id);
    
    //include('instructor_exam_builder_views\view_all_exams_view.php');
    //view_exam($exam);
    //include('instructor_exam_builder_views\view_exam_questions_view.php'); 
    include('instructor_exam_builder_views\view_exam_view.php');
}
/*------------------------ALL EXAM BUILDER BUTTON ACTIONS GO HERE-------------------------------------------*/
else if($action == 'save_exam_to_db')
{   
    echo "SAVING THE EXAM";
    $exam_name = filter_input(INPUT_POST, 'exam_name');
    $exam = get_SESSION_exam_object($instructor_id);
    //for testing purposes, create a new exam object with instructor id and exam name and push into db
    //i also need to do some length checking as well
   // $exam_id = CREATE_exam($instructor_id,$exam_name);

    //echo "built exam! the id is ".$exam_id." the name is ".$exam_name;
    save_exam_object_to_db($exam, $instructor_id, $exam_name);
    delete_exam_object();
    //factor out this bit of code and put inside a seperate file
    $my_array = get_exam_courses_array($instructor_id);
    $other_instructor_exams = READ_other_instructor_exams($instructor_id);
    include('instructor_exam_builder_views\view_exam_view.php');
    //include('instructor_exam_builder_portal.php');
}
else if($action == 'abort_exam_building')
{
    echo "Aborting EXAM building";
    delete_exam_object();
    include('instructor_exam_builder_portal.php');
}
else if($action == 'push_exam_question')
{   
    $exam = get_SESSION_exam_object($instructor_id);
    
    $question = filter_input(INPUT_POST, 'exam_question');
    $anwser = filter_input(INPUT_POST, 'correct_anwser', FILTER_VALIDATE_INT);
    $anwser_array = get_array_anwsers();

    /*
    echo "TESTING THE DATA OF OUR QUESTION OBJECT: <br>";
    print_r($question);     
    echo"<br>"; 
    print_r($anwser); 
    echo"<br>"; 
    print_r($anwser_array); 
    echo"<br>"; 
    */

    //do some input validation/cleaning: make sure questions are not too large
    //this can be done with JS too. prob better
    $question_object = build_exam_question_object($question, $anwser, $anwser_array);
    $exam->add_question($question_object);
    //echo "num questions: ".$exam->get_num_questions(); 
    //include('instructor_exam_builder_views\view_exam_questions_view.php');
    include('instructor_exam_builder_views\building_exam_view.php');
   
}
else if($action == 'pop_exam_question')//delete question
{   
    
    
}
else if($action == 'change_exam_question')//change question
{   
    
    
}


?>