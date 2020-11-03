<?php

class student_course_exams
{
    var $instructor_name;
    var $course_name;
    var $course_id;

    var $pending_course_exams;
    var $completed_course_exams;
    
    public function __construct ($course_name, $course_id, $pending_course_exams, $completed_course_exams)
    {
        $this->course_name = $course_name;
        $this->course_id = $course_id;
        $this->pending_course_exams = $pending_course_exams;
        $this->completed_course_exams = $completed_course_exams;
    }

    function get_course_name()  { return $this->course_name; }
    function get_course_id()  { return $this->course_id; }
    function get_instructor_name()  { return $this->instructor_name; }

    function get_pending_course_exams()  { return $this->pending_course_exams; }
    function get_completed_course_exams()  { return $this->completed_course_exams; }
    
    
}

/*
for each instructor course, get the course name, id and course_exams:
    first query for the instructor courses 

    for each instructor course:
         query course_exam for matching course_nums to get an array of course_exams
         wrap course name, course id, and the array of course exams into an object

*/
function get_student_course_exams_array($student_id)
{
    $courses = READ_enrolled_courses($student_id);

    $my_array = array();
    
    foreach($courses as $course) 
    { 
        $course_num = $course['course_num'];
        $course_name = $course['course_name'];

        $pending_course_exams = READ_pending_course_exams($student_id, $course_num);
        $completed_course_exams = READ_completed_course_exams($student_id, $course_num);

        //$course_exams =  READ_instructor_course_exams($course_num);

        //if(sizeOf($course_exams) != 0)
            array_push($my_array, new student_course_exams($course_name, $course_num, $pending_course_exams, $completed_course_exams));
    }

    return $my_array;
}

/*
tester method that randomizes a test score and creates an entry into the db with it
just use it to test completed exam viewing

function take_exam($student_id, $course_num, $exam_id)
{
    $exam_grade = rand(0,100);
    if(!CREATE_completed_course_exam($exam_id, $student_id, $course_num, $exam_grade)) $exam_grade = -1;
    return $exam_grade;
}
*/

function take_exam($exam)
{
   
        if($exam instanceof exam)
        {
            $exam_id = $exam->get_exam_id();
            include('student_views/student_taking_exam_view.php'); 
        }
        else
            echo 'ERROR! $exam is not a reference to an exam object!';
    
}

/* 
mark student exam:
take the submitted exam questions and the original exam and compare student answers with submitted answers
in 2 parallel arrays
*/
function mark_student_exam($student_exam, $exam)
{
    $current_mark = 0;
    $exam_questions = $exam->get_exam_questions();

    
    for($i=0;$i<sizeOf($exam_questions);$i++)
    {
        $right_answer = $exam_questions[$i]->get_correct_awnser();
        $student_answer = $student_exam[$i];

        echo "question: ".($i+1)."</br>";
        echo "right answer: ".$right_answer."</br>";
        echo "students answer: ".$student_answer."</br>";
        echo "</br>";

        if($student_answer == $right_answer)
            $current_mark++;
    } 


    return $current_mark;
}


?>