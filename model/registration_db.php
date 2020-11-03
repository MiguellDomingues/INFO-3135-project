<?php
/*
i think i need to redesign the registration system. its workable for now;
    - the issue is if i want to delete student or instructor users, the corresponding registered_user user_name row
    dont want to delete.
*/

/* REGISTRATION PROCESS

check for valid minimum user_name AND password length
    - return appropriate error message

    check for user_name exists in registered_user db:
        for not: 
            create appropriate entry in registration_table
            check for STUDENT or INSTRUCTOR user
                add a row to the appropriate user table and add the user_name as an FK
                to that user table
                take user to log in page with registration success message


*/

/*
sql notes:
   - have foreign key constraints on instructor and student for cascading deletes on the user_name;
            - this means deleting a user_name in registered user will delete the matching row inside of
            student or instructor table

            - the reserve does NOT happen; deleteing a student or instructor row does NOT cascade delete the
            cooresponding user_name

*/

/* LOGIN PROCESS
need to:
    confirm a log in and MATCHING password

    algo: 
    
    query for user_name:
            if found:   
                get matching password
                    match password in db to password user logged in with
                        if no match:
                            return error
                        if match:
                            grab a student/instructor PK from respective table and return
                            log in success message
            if no found:
                return error
        
    no check for login credentials using sizeof($db_query). if it isnt 1, then login fail     

register a user 
    - create a user_name/password AND a matching student/instructor entry in one of those tables
*/

/*
how to fetch query results with php:
successful queries return a 2d array of rows/columns;
    - the row is indexed with an int 0-n
    - a column value is an associative array indexed with the column name

!even if a query only returns a single result, its still stored into a 2d array
!to check for query success, use sizeOf(binded query variable name). a value of 0 means no returned results

use the following code to access a single row:
    - (binded query variable name)[index]['column name'];
    - ie: $user[0]['username']

use the following code to iterate through all returned rows in a query:

foreach ($(query return var) as $(holder var for each row)):
    echo $(holder var)['(column_name1']; 
    echo $(holder var)['(column_name2']; 
    echo $(holder var)['(column_nameN'];   
endforeach; 

ie:

$users = db_query();

foreach ($users as $user):
    echo $user['user_name']; 
    echo $user['password'];
    echo $user['registration_date'];
endforeach; 




*/

/*
function add_product($category_id, $code, $name, $price) {
    global $db;
    $query = 'INSERT INTO products
                 (productName, listPrice)
              VALUES
                 (:name, :price)';
    $statement = $db->prepare($query);
    $statement->bindValue(':category_id', $category_id);
    $statement->bindValue(':code', $code);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':price', $price);
    $statement->execute();
    $statement->closeCursor();
*/




function create_user($user_name, $password)
{
    global $db;
    $query = 'INSERT INTO registered_user (user_name, password)
              VALUES (:user_name, :password)';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_name', $user_name);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $statement->fetchAll();
    $statement->closeCursor();   
}

function create_student($user_name)
{
    global $db;
    $query = 'INSERT INTO student (user_name)
              VALUES (:user_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_name', $user_name);
    $statement->execute();
    $statement->fetchAll();
    $statement->closeCursor();   
}

function create_instructor($user_name)
{
    global $db;
    $query = 'INSERT INTO instructor (user_name)
              VALUES (:user_name)';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_name', $user_name);
    $statement->execute();
    $statement->fetchAll();
    $statement->closeCursor();   

}

function validate_credentials($user_name, $password) 
{
    global $db;
    $query = 'SELECT * FROM registered_user
              WHERE user_name = :user_name
              AND password = :password';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_name', $user_name);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $user = $statement->fetchAll();
    $statement->closeCursor();
    return $user;    
}

function validate_username($user_name)
{
    global $db;
    $query = 'SELECT * FROM registered_user
              WHERE user_name = :user_name';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_name', $user_name);
    $statement->execute();
    $user = $statement->fetchAll();
    $statement->closeCursor();
    return $user;    
}

function get_student($user_name)
{
    global $db;
    $query = 'SELECT * FROM student
              WHERE user_name = :user_name';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_name', $user_name);
    $statement->execute();
    $user = $statement->fetchAll();
    $statement->closeCursor();
    return $user;    
}

function get_instructor($user_name)
{
    global $db;
    $query = 'SELECT * FROM instructor
              WHERE user_name = :user_name';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_name', $user_name);
    $statement->execute();
    $user = $statement->fetchAll();
    $statement->closeCursor();
    return $user;    
}

/*
SELECT user_name FROM student
UNION ALL
SELECT user_name FROM instructor


'SELECT user_name, 'student' as Source
FROM student
WHERE user_name = :user_name 
UNION ALL
SELECT user_name, 'instructor' as Source
FROM instructor
WHERE user_name = :user_name';

SELECT expression1, expression2, ... expression_n
FROM tables
[WHERE conditions]
UNION
SELECT expression1, expression2, ... expression_n
FROM tables
[WHERE conditions];
*/

/*
 $query = 'SELECT user_name = :user_name, students as Source
    FROM student
    WHERE user_name = :user_name 
    UNION ALL
    SELECT user_name = :user_name, instructors as Source
    FROM instructor
    WHERE user_name = :user_name';
*/


function get_logged_in_user($user_name)
{
    global $db;
    $query = 'SELECT user_name = :user_name, students as Source
    FROM student
    WHERE user_name = :user_name 
    UNION ALL
    SELECT user_name = :user_name, instructors as Source
    FROM instructor
    WHERE user_name = :user_name';

    $statement = $db->prepare($query);
    $statement->bindValue(':user_name', $user_name);
    $statement->execute();
    $user = $statement->fetchAll();
    $statement->closeCursor();
    return $user;    

}

?>