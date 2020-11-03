<?php



function CREATE_completed_course_exam($exam_id, $student_id, $course_num, $exam_grade)
{
    global $db;
    $query = 'INSERT INTO completed_student_course_exam (exam_id, student_id, course_num, exam_grade)
              VALUES (:exam_id, :student_id, :course_num, :exam_grade)';
    $statement = $db->prepare($query);
    $statement->bindValue(':exam_id', $exam_id);
    $statement->bindValue(':student_id', $student_id);
    $statement->bindValue(':course_num', $course_num);
    $statement->bindValue(':exam_grade', $exam_grade);
    $result = $statement->execute();
    $statement->fetchAll();
    $statement->closeCursor();   
    return $result;
}

/*
this query returns all exams that have been attached to a specific course #
*/
function READ_instructor_course_exams($course_num)
{
    global $db;

    $query = 'SELECT *
    FROM exam
    INNER JOIN course_exam
    ON course_exam.exam_id = exam.exam_id
    AND course_exam.course_num = :course_num';
              
    $statement = $db->prepare($query);
    $statement->bindValue(':course_num', $course_num);
    $statement->execute();
    $exams = $statement->fetchAll();
    $statement->closeCursor();
    return $exams; 
}

/*
get completed course exams for student
    - simply grab rows from completed exam table matching student id and course num
*/


function READ_completed_course_exams($student_id, $course_num)
{
    global $db;

    $query = 'SELECT *
              FROM completed_student_course_exam
              where course_num = :course_num
              and student_id = :student_id';
              
    $statement = $db->prepare($query);
    $statement->bindValue(':student_id', $student_id);
    $statement->bindValue(':course_num', $course_num);
    $statement->execute();
    $exams = $statement->fetchAll();
    $statement->closeCursor();
    return $exams; 
}

/*
get pending course exams for student
    - first get exam_id's filtered by student id and course number from completed exam table
        - this essentually returns all completed student course exams
    - then get all course exam info from course exam table MINUS the results from inner query
*/

function READ_pending_course_exams($student_id, $course_num)
{
    global $db;

    $query = 'SELECT course_exam.exam_id, course_exam.course_num
              FROM course_exam
              where course_num = :course_num
              and exam_id NOT IN 
             (SELECT exam_id FROM completed_student_course_exam
              WHERE student_id = :student_id
              AND course_num = :course_num)';
              
    $statement = $db->prepare($query);
    $statement->bindValue(':student_id', $student_id);
    $statement->bindValue(':course_num', $course_num);
    $statement->execute();
    $exams = $statement->fetchAll();
    $statement->closeCursor();
    return $exams; 
}








?>