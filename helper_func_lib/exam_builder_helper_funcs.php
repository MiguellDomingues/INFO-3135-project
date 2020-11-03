<?php

define("MIN_QUESTION_LENGTH", 1);
define("MAX_QUESTION_LENGTH", 300);

define("MIN_ANSWER_LENGTH", 1);
define("MAX_ANSWER_LENGTH", 150);

define("MIN_NUMBER_QUESTIONS", 5);
define("MAX_NUMBER_QUESTIONS", 50);

class exam
{
    /*
    additional data:
        exam_score, used for student viewing??
    */
    var $exam_id;
    var $exam_name;
    var $exam_owner;
    var $creation_date;

    //indexed array of questions objects
    var $exam_questions = array();

    public function __construct ($exam_owner)
    {
        $this->exam_owner = $exam_owner;  
    }

    function get_exam_id()  { return $this->exam_id; }
    function get_exam_name()  { return $this->exam_name; }
    function get_exam_owner()  { return $this->exam_owner; }
    function get_creation_date()  { return $this->creation_date; }
    function get_exam_questions()  { return $this->exam_questions; }
    function get_num_questions()    { return sizeOf($this->exam_questions); }


    function set_exam_id($exam_id)  
    { 
        $this->exam_id = $exam_id; 
    }

    function set_exam_name($exam_name)  
    { 
        $this->exam_name = $exam_name; 
    }

    function set_exam_owner($exam_owner)  
    {
         $this->exam_owner = $exam_owner; 
    }

    function set_creation_date($creation_date)  
    { 
        $this->creation_date = $creation_date; 
    }

    function set_questions($exam_questions)  
    { 
        $this->exam_questions = $exam_questions;  
    }

    function add_question($exam_question)  
    { 
        array_push($this->exam_questions, $exam_question);
    }

    function delete_question($index)  
    { 
        /* add code for deleting an exam question using an array index*/
    }

 
    /* need to figure out a way to modify questions */

}

/* i need to be able to modify exam questions, but do it later */
class exam_question
{
    //long string containing question
    var $question;
    //array of 5 strings
    var $anwsers;
    //array index
    var $correct_answer;

    public function __construct ($question, $anwsers, $correct_answer)
    {
        $this->question = $question;    
        $this->anwsers = $anwsers; 
        $this->correct_answer = $correct_answer;
    }

    function get_question()  { return $this->question; }
    function get_anwsers()  { return $this->anwsers; }
    function get_correct_awnser()  { return $this->correct_answer; }


}

class exam_courses
{
    var $exam_id;
    var $exam_name;
    var $exam_owner;
    var $creation_date;

    var $courses;
    
    public function __construct ($exam_id, $exam_name, $exam_owner, $creation_date, $courses)
    {
        $this->exam_id = $exam_id;
        $this->exam_name = $exam_name;
        $this->exam_owner = $exam_owner;
        $this->creation_date = $creation_date;
        $this->courses = $courses;
    }

    function get_exam_id()  { return $this->exam_id; }
    function get_exam_name()  { return $this->exam_name; }
    function get_exam_owner()  { return $this->exam_owner; }
    function get_creation_date()  { return $this->creation_date; }
    function get_courses()  { return $this->courses; }
    
}

/*
    for each instructor exam, get the exam info and courses that have that exam attached, wrap it inside an object and add it to an array
    return an array of exam_course objects
*/
function get_exam_courses_array($instructor_id)
{
    $instructor_exams = READ_instructor_exams($instructor_id);
   
    $my_array = array();
    
    foreach($instructor_exams as $instructor_exam) 
    { 
        $exam_id = $instructor_exam['exam_id'];
        $exam_name = $instructor_exam['exam_name'];
        $exam_owner = $instructor_exam['exam_owner'];
        $creation_date = $instructor_exam['creation_date'];
        $courses = READ_exam_courses($exam_id);

        array_push($my_array, new exam_courses($exam_id, $exam_name, $exam_owner, $creation_date, $courses));
    }

    return $my_array;
}

/*
init an empty exam object
first check if the session is set
*/
function get_SESSION_exam_object($exam_owner)
{
    $exam_object = null;

    if(isset($_SESSION))
    {
        //echo "testing session vars";
        
        if(!isset($_SESSION['exam_under_construction']))
        {
            $exam_object = $_SESSION['exam_under_construction'] = new exam($exam_owner);
            //echo "CREATING A NEW EXAM OBJECT";
        }
        else
        {
            $exam_object = $_SESSION['exam_under_construction'];
            //echo $exam_object->get_exam_owner();
        }
    }
    else
    {
        echo "ERROR session is NOT set!";
        exit();
    }

    return $exam_object;
}

function delete_exam_object()
{
    unset($_SESSION['exam_under_construction']); 
    //$exam = null;
}

function get_array_anwsers()
{
    $my_array = array(filter_input(INPUT_POST, 'exam_solution_1'),
                      filter_input(INPUT_POST, 'exam_solution_2'),
                      filter_input(INPUT_POST, 'exam_solution_3'),
                      filter_input(INPUT_POST, 'exam_solution_4'),
                      filter_input(INPUT_POST, 'exam_solution_5'));

    return $my_array;
}

/*
note that there isnt any validation on length or anything, so this could blow up
ie the DB can hold 300 chars in a question and 150 in an answer
    also, should also prevent exams with no questions getting pushed into db
    have a minimum and maximun # of questions
*/
function build_exam_question_object($question, $anwser, $anwser_array)
{
    $question_object = new exam_question($question, $anwser_array, $anwser);
    return $question_object;
}

function save_exam_object_to_db($exam, $exam_owner, $exam_name)
{
    /*
    here we decompose the exam object into db calls
        - a single exam id and exam owner
            - each exam will have multiple rows in question table
            - ensure you were checking the lengths on questions/answers since the db is capped at 300/150
            - make sure you UNSET the exam_builder session var when the db save is SUCESSFULL
    */
    $exam_questions = $exam->get_exam_questions();
    $exam_id = CREATE_exam($exam_owner,$exam_name); 

    foreach($exam_questions as $exam_question) 
    { 
        $answer_array = $exam_question->get_anwsers();

        CREATE_exam_question($exam_id, 
        $exam_question->get_question(), 
        $answer_array[0], 
        $answer_array[1], 
        $answer_array[2], 
        $answer_array[3], 
        $answer_array[4], 
        $exam_question->get_correct_awnser());
    }



}

function build_exam_object_from_db($exam_id)
{
    //first get some raw exam object data such as exam_owner, name, and creation date
    //then use another function to grab and build the array of questions, attach it to the exam
    //return the exam
    $db_exam = READ_exam($exam_id);
    $exam = new exam($db_exam[0]['exam_owner']);
    $exam->set_exam_id($exam_id);
    $exam->set_exam_name($db_exam[0]['exam_name']); 
    $exam->set_creation_date($db_exam[0]['creation_date']); 
    $exam->set_questions(get_exam_questions_from_db($exam_id));

    return $exam;
    
}


function get_exam_questions_from_db($exam_id)
{
    //first get some raw exam object data such as exam_owner, name, and creation date
    //then use another function to grab and build the array of questions, attach it to the exam
    //return the exam

    $exam_questions = array();
    $db_exam_questions = READ_exam_questions($exam_id);

    foreach($db_exam_questions as $db_exam_question) 
    { 
        $question = $db_exam_question['question'];

        $answers = array(5);

        $answers[0] = $db_exam_question['answer_1'];
        $answers[1] = $db_exam_question['answer_2'];
        $answers[2] = $db_exam_question['answer_3'];
        $answers[3] = $db_exam_question['answer_4'];
        $answers[4] = $db_exam_question['answer_5'];

        $answer_index = $db_exam_question['answer_index'];

        array_push($exam_questions, new exam_question($question, $answers, $answer_index ));
    }

    return $exam_questions;

}

function view_exam_questions($exam)
{
    if($exam instanceof exam)
        include('..\instructor_exam_builder\instructor_exam_builder_views\view_exam_questions_view.php'); 
    else
        echo 'ERROR! $exam is not a reference to an exam object!';
}

function view_exam_header($exam)
{
    if($exam instanceof exam)
        include('..\instructor_exam_builder\instructor_exam_builder_views\view_exam_header_view.php'); 
    else
        echo 'ERROR! $exam is not a reference to an exam object!';
}

//construct ($question, $anwsers, $correct_answer)

/*
function replace_spaces_in_string($question)
{
    $question = str_replace('/(?:\r\n|\r|\n)/g', '<br>', $question);
    return $question;  
}
*/



?>