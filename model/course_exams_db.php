<?php



/*
SELECT exam.exam_id, course_exam.course_num
              FROM exam
              INNER JOIN course_exam
              ON course_exam.exam_id = exam.exam_id
              AND course_exam.course_num = :course_num

*/


/*
$query = 'SELECT course_num, course_name FROM instructor_course
              WHERE course_num NOT IN
             (SELECT course_num FROM registered_course_student 
              WHERE registered_course_student.student_id = :student_id)';

              $query = 'SELECT * FROM exam
              WHERE exam_id NOT IN
             (SELECT exam_id FROM course_exam
              WHERE course_exam.exam_id = exam.exam_id
              AND course_exam.course_num = :course_num)';
*/
//get the exams in exam bank that ARE NOT course exams
function READ_unattached_exams($course_num)
{
    global $db;

    $query = 'SELECT * FROM exam
              WHERE exam_id NOT IN
            (SELECT exam_id FROM course_exam
            WHERE course_exam.exam_id = exam.exam_id
            AND course_exam.course_num = :course_num)';
              
    $statement = $db->prepare($query);
    $statement->bindValue(':course_num', $course_num);
    $statement->execute();
    $exams = $statement->fetchAll();
    $statement->closeCursor();
    return $exams; 

}



function READ_course_exam($exam_id, $course_num)
{
    global $db;

    $query = 'SELECT * FROM course_exam
              WHERE course_exam.exam_id = :exam_id
              AND course_exam.course_num = :course_num';
              
    $statement = $db->prepare($query);
    $statement->bindValue(':exam_id', $exam_id);
    $statement->bindValue(':course_num', $course_num);
    $statement->execute();
    $exam = $statement->fetchAll();
    $statement->closeCursor();
    return $exam; 
}

/*
get a single exam that is attached to the course, and grab/echo all its data

  $query = 'SELECT course_num, course_name FROM instructor_course
              WHERE course_num NOT IN
             (SELECT course_num FROM registered_course_student 
              WHERE registered_course_student.student_id = :student_id)';


               $query = 'SELECT exam.exam_id, course_exam.course_num
    FROM exam
    INNER JOIN course_exam
    ON course_exam.exam_id = exam.exam_id
    AND course_exam.course_num = :course_num';
*/



/*
ONLY instructors should be able to delete exams:
    
*/

function DELETE_course_exam($exam_id, $course_num)
{
    global $db;

    $query = 'DELETE FROM course_exam
              WHERE exam_id = :exam_id
              AND course_num = :course_num';

    $statement = $db->prepare($query);
    $statement->bindValue(':exam_id', $exam_id);
    $statement->bindValue(':course_num', $course_num);
    $result = $statement->execute();
    $statement->fetchAll();
    $statement->closeCursor();
    return $result;

}

/*
INSERT INTO exam ()
VALUES ()
*/



/*
exam_id is the id of a previously created exam, OR an exam the instructor just created
*/
function CREATE_course_exam($course_num, $exam_id)
{
    global $db;
    $query = 'INSERT INTO course_exam (exam_id, course_num)
              VALUES (:exam_id, :course_num)';

    $statement = $db->prepare($query);
    $statement->bindValue(':course_num', $course_num);
    $statement->bindValue(':exam_id', $exam_id);
    $success = $statement->execute();
    $statement->closeCursor();
    return $success;
}

/*
function CREATE_instructor_course($course_name, $instructor_id)
{
    global $db;
    $query = 'INSERT INTO instructor_course (course_name, instructor_id)
              VALUES (:course_name, :instructor_id)';
    $statement = $db->prepare($query);
    $statement->bindValue(':course_name', $course_name);
    $statement->bindValue(':instructor_id', $instructor_id);
    $success = $statement->execute();
    $statement->closeCursor();
    return $success;
}
*/


?>