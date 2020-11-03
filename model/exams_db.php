<?php


function CREATE_exam($exam_owner,$exam_name)
{
    global $db;
    $query = 'INSERT INTO exam (exam_owner, exam_name)
              VALUES (:exam_owner, :exam_name)';

    $statement = $db->prepare($query);
    $statement->bindValue(':exam_owner', $exam_owner);
    $statement->bindValue(':exam_name', $exam_name);
    $statement->execute();
    $new_exam_id = $db->lastInsertId();
    $statement->closeCursor();
    return $new_exam_id;
}

function READ_exams()
{
    global $db;

    $query = 'SELECT * FROM exam';
              
    $statement = $db->prepare($query);
    $statement->execute();
    $exams = $statement->fetchAll();
    $statement->closeCursor();
    return $exams; 

}

function READ_instructor_exams($instructor_id)
{
    global $db;

    $query = 'SELECT * FROM exam
    WHERE exam_owner = :instructor_id';
              
    $statement = $db->prepare($query);
    $statement->bindValue(':instructor_id', $instructor_id);
    $statement->execute();
    $exams = $statement->fetchAll();
    $statement->closeCursor();
    return $exams; 

}

/*
get all the course info for courses that have this exam attached
*/

function READ_exam_courses($exam_id)
{
    global $db;

    $query = 'SELECT course_num, course_name, instructor_id
              FROM instructor_course
              WHERE instructor_course.course_num IN
              (SELECT course_num
               FROM course_exam
               WHERE course_exam.exam_id = :exam_id)';
              
    $statement = $db->prepare($query);
    $statement->bindValue(':exam_id', $exam_id);
    $statement->execute();
    $exam_courses = $statement->fetchAll();
    $statement->closeCursor();
    return $exam_courses; 

}

/*
get all exams that WERE NOT created by this instructor
*/

function READ_other_instructor_exams($instructor_id)
{
    global $db;

    $query = 'SELECT * FROM exam
    WHERE exam_owner != :instructor_id';
              
    $statement = $db->prepare($query);
    $statement->bindValue(':instructor_id', $instructor_id);
    $statement->execute();
    $exams = $statement->fetchAll();
    $statement->closeCursor();
    return $exams; 

}


/*
get a single exam that is inside the exam table
*/

function READ_exam($exam_id)
{
    global $db;

    $query = 'SELECT * FROM exam
              WHERE exam_id = :exam_id';
              
    $statement = $db->prepare($query);
    $statement->bindValue(':exam_id', $exam_id);
    $statement->execute();
    $exam = $statement->fetchAll();
    $statement->closeCursor();
    return $exam; 

}

function CREATE_exam_question($exam_id, 
                              $question, 
                              $answer_1, 
                              $answer_2, 
                              $answer_3, 
                              $answer_4, 
                              $answer_5, 
                              $answer_index)
{
    global $db;
    $query = 'INSERT INTO exam_question (exam_id, 
                                         question, 
                                         answer_1,	
                                         answer_2,	
                                         answer_3,	
                                         answer_4,	
                                         answer_5,	
                                         answer_index)

                                VALUES (:exam_id, 
                                        :question, 
                                        :answer_1,	
                                        :answer_2,	
                                        :answer_3,	
                                        :answer_4,	
                                        :answer_5,	
                                        :answer_index)';

    $statement = $db->prepare($query);
    $statement->bindValue(':exam_id', $exam_id);
    $statement->bindValue(':question', $question);
    $statement->bindValue(':answer_1', $answer_1);
    $statement->bindValue(':answer_2', $answer_2);
    $statement->bindValue(':answer_3', $answer_3);
    $statement->bindValue(':answer_4', $answer_4);
    $statement->bindValue(':answer_5', $answer_5);
    $statement->bindValue(':answer_index', $answer_index);
    $statement->execute();
    $statement->fetchAll();
    $statement->closeCursor();  
}

function READ_exam_questions($exam_id)
{
    global $db;

    $query = 'SELECT * FROM exam_question
              WHERE exam_id = :exam_id';
              
    $statement = $db->prepare($query);
    $statement->bindValue(':exam_id', $exam_id);
    $statement->execute();
    $exam_questions = $statement->fetchAll();
    $statement->closeCursor();
    return $exam_questions; 
}


?>