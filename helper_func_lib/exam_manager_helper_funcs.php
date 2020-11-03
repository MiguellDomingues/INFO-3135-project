<?php

/*
get a list of instructor course id's, than for each id, join it to course_exam table to get exams for each course

*/

class course_exams
{
    var $course_name;
    var $course_id;
    var $course_exams;
    var $instructor_id;
    var $exams;
    
    public function __construct ($course_name, $course_id, $course_exams, $exams)
    {
        $this->course_name = $course_name;
        $this->course_id = $course_id;
        $this->course_exams = $course_exams;
        $this->exams = $exams;
    }

    /*
    public function __construct ($course_name, $course_id, $course_exams, $instructor_id)
    {
        $this->course_name = $course_name;
        $this->course_id = $course_id;
        $this->course_exams = $course_exams;
        $this->instructor_id = $instructor_id;
    }
    */

    function get_course_name()  { return $this->course_name; }
    function get_course_id()  { return $this->course_id; }
    function get_course_exams()  { return $this->course_exams; }
    function get_exams()  { return $this->exams; }
    
}

/*
for each instructor course, get the course name, id and course_exams:
    first query for the instructor courses 

    for each instructor course:
         query course_exam for matching course_nums to get an array of course_exams
         wrap course name, course id, and the array of course exams into an object

*/
function get_course_exams_array($instructor_id)
{
    $courses = READ_instructor_courses($instructor_id);

    $my_array = array();
    
    foreach($courses as $course) 
    { 
        $course_num = $course['course_num'];
        $course_name = $course['course_name'];
        $course_exams =  READ_instructor_course_exams($course_num);
        $exams = READ_unattached_exams($course_num);
        array_push($my_array, new course_exams($course_name, $course_num, $course_exams, $exams));
    }

    return $my_array;
}

/*
i should sort the array of exam courses by num of courses so the list does not look so disjointed

*/
function update_course_exam_view($instructor_id, $instructor_name)
{
    $my_array = get_course_exams_array($instructor_id);
    include('instructor_exam_manager_views\course_exam_view.php');
}

/*
function does_course_exam_exist($exam_id, $course_num)
{
    return (sizeOf(READ_course_exam($exam_id, $course_num)) != 0);
}
*/



?>