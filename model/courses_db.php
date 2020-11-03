<?php



/*
    -all db calls involving courses

    -i might unlink all the dbs from helper_functions file and let each section of the app
    define its own db's to call. i dont think instructor or student functions require any use of 
    registration db
*/

function READ_instructor_courses($instructor_id)
{
    global $db;
    $query = 'SELECT * FROM instructor_course
              WHERE instructor_id = :instructor_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':instructor_id', $instructor_id);
    $statement->execute();
    $courses = $statement->fetchAll();
    $statement->closeCursor();
    return $courses;    
}

function DELETE_instructor_course($instructor_id, $course_num)
{
    global $db;

    $query = 'DELETE FROM instructor_course
              WHERE instructor_id = :instructor_id
              AND course_num = :course_num';

    $statement = $db->prepare($query);
    $statement->bindValue(':instructor_id', $instructor_id);
    $statement->bindValue(':course_num', $course_num);
    $result = $statement->execute();
    $statement->fetchAll();
    $statement->closeCursor();
    return $result;

}


function READ_courses()
{
    global $db;
    $query = 'SELECT * FROM instructor_course
              ORDER BY course_name';
    $statement = $db->prepare($query);
    $statement->execute();
    $courses = $statement->fetchAll();
    $statement->closeCursor();
    return $courses;    
}

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

function CREATE_registered_course_student($course_num, $student_id)
{
    global $db;
    $query = 'INSERT INTO registered_course_student(course_num, student_id)
              VALUES (:course_num, :student_id)';
    $statement = $db->prepare($query);
    $statement->bindValue(':course_num', $course_num);
    $statement->bindValue(':student_id', $student_id);
    $success = $statement->execute();
    $statement->closeCursor();
    return $success;
}




function READ_registered_course_students()
{
    global $db;
    $query = 'SELECT * FROM registered_course_student
              ORDER BY course_num';
    $statement = $db->prepare($query);
    $statement->execute();
    $courses = $statement->fetchAll();
    $statement->closeCursor();
    return $courses; 
}

/*
SELECT Orders.OrderID, Customers.CustomerName, Shippers.ShipperName
FROM ((Orders
INNER JOIN Customers ON Orders.CustomerID = Customers.CustomerID)
INNER JOIN Shippers ON Orders.ShipperID = Shippers.ShipperID);
*/

/*


*/

function READ_instructor_course_students($course_num)
{
    global $db;
    $query = 'SELECT student.user_name, registered_course_student.course_num
              FROM student
              INNER JOIN registered_course_student
              ON registered_course_student.student_id = student.student_id
              AND registered_course_student.course_num = :course_num';
              
    $statement = $db->prepare($query);
    $statement->bindValue(':course_num', $course_num);
    $statement->execute();
    $students = $statement->fetchAll();
    $statement->closeCursor();
    return $students; 
}

/*
SELECT Orders.OrderID, Customers.CustomerName, Orders.OrderDate
FROM Orders
INNER JOIN Customers
ON Orders.CustomerID=Customers.CustomerID;

SELECT * FROM instructor_course
              WHERE instructor_id = :instructor_id


'SELECT registered_course_student.student_id, instructor_course.course_name
FROM registered_course_student
INNER JOIN instructor_course
ON registered_course_student.course_num = instructor_course.course_num
AND registered_course_student.student_id = :student_id';

SELECT registered_course_student.student_id, instructor_course.course_name, instructor_course.course_num
              FROM registered_course_student
              INNER JOIN instructor_course
              ON registered_course_student.course_num = instructor_course.course_num
              AND registered_course_student.student_id = :student_id

SELECT course_num, course_name FROM instructor_course
              WHERE course_num IN
             (SELECT course_num FROM registered_course_student 
              WHERE registered_course_student.student_id = 16)
              */

function READ_enrolled_courses($student_id)
{
    global $db;

    $query = 'SELECT course_num, course_name FROM instructor_course
              WHERE course_num IN
             (SELECT course_num FROM registered_course_student 
              WHERE registered_course_student.student_id = :student_id)';

    $statement = $db->prepare($query);
    $statement->bindValue(':student_id', $student_id);
    $statement->execute();
    $courses = $statement->fetchAll();
    $statement->closeCursor();
    return $courses; 
}

/*
get all courses this student is NOT enrolled in ie:
    - get set of course numbers with associated student id
    - get set of course numbers with non-associated student id
    - get complement of those 2 sets

    WHERE instructor_id = :instructor_id'

SELECT * FROM Customers
WHERE Country IN (SELECT Country FROM Suppliers);

'SELECT student_id, course_num FROM registered_course_student
WHERE course_num NOT IN 
(SELECT student_id, course_num FROM registered_course_student 
 WHERE instructor_id != :instructor_id)';


);

*/


/*
function READ_non_enrolled_courses($student_id)
{
    global $db;

    $query = 'SELECT registered_course_student.student_id, instructor_course.course_name
              FROM registered_course_student
              RIGHT JOIN instructor_course
              ON registered_course_student.course_num = instructor_course.course_num
              AND registered_course_student.student_id = :student_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':student_id', $student_id);
    $statement->execute();
    $courses = $statement->fetchAll();
    $statement->closeCursor();
    return $courses; 
}


  SELECT course_num, student_id FROM registered_course_student 
  WHERE registered_course_student.student_id != 17
  AND course_num NOT IN(SELECT course_num FROM registered_course_student WHERE registered_course_student.student_id = 17)




    SELECT course_num FROM instructor_course
              WHERE course_num NOT IN
              (SELECT course_num FROM registered_course_student 
              WHERE registered_course_student.student_id = 16)
              
*/

function READ_non_enrolled_courses($student_id)
{
    global $db;

    $query = 'SELECT course_num, course_name FROM instructor_course
              WHERE course_num NOT IN
             (SELECT course_num FROM registered_course_student 
              WHERE registered_course_student.student_id = :student_id)';

    $statement = $db->prepare($query);
    $statement->bindValue(':student_id', $student_id);
    $statement->execute();
    $courses = $statement->fetchAll();
    $statement->closeCursor();
    return $courses; 
}

/*
DELETE FROM Customers WHERE CustomerName='Alfreds Futterkiste';

DELETE FROM registered_course_student 
WHERE course_num = :course_num

DELETE FROM `registered_course_student` WHERE `registered_course_student`.`student_id` = 16 AND `registered_course_student`.`course_num` = 14


*/

function DELETE_enrolled_course($course_num, $student_id)
{
    global $db;

    $query = 'DELETE FROM registered_course_student 
              WHERE course_num = :course_num
              AND student_id = :student_id';

    $statement = $db->prepare($query);
    $statement->bindValue(':course_num', $course_num);
    $statement->bindValue(':student_id', $student_id);
    $result = $statement->execute();
    $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}



?>
