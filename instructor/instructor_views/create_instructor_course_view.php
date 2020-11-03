<?php include '../view/header.php'; ?>

<h1>CREATE COURSE</h1>
<p>----------------------------------------------</p>
<p>current courses:</p>
<ul>
            <!-- display links for all categories -->
            <?php 
            
            foreach($courses as $course) : 
                
            ?>
            
            <li>
                <?php 
                
                   // echo "instID:".$course['instructor_id']." ";
                    echo "Course Name:".$course['course_name']." "; 
                   // echo "course_num".$course['course_num']." ";  
                 ?>
                    
                </a>
            </li>
            <?php endforeach; ?>
        </ul>

links for instructor functions go HERE
<p>----------------------------------------------</p>

<form action="index.php" method="post">

    <input type="hidden" name="action" value="create_course">
    course name: <input type="text" name="course_name"><br>
    <input type="submit">

</form>

<?php
if(isset($error_msg))
    echo $error_msg;
  
?>

<p>----------------------------------------------</p>


<?php include '../view/footer.php'; ?>