<?php include '../view/header.php'; ?>

<h1>CREATE COURSE</h1>
<p>----------------------------------------------</p>
<p>instructor <?php echo $instructor_name; ?> courses:</p>
<ul>
            <?php foreach($courses as $course) : ?>
            <li>
                <form action="." method="post">

                    <input type="hidden" name="action" value="delete_course">   

                    <input type="hidden" name="course_num" value="<?php echo $course['course_num']; ?>">

                    <?php             

                        echo "Instructor ID:".$course['instructor_id']." ";
                        echo "Course Name:".$course['course_name']." "; 
                   
                    ?>

                    <input type="submit" value="Delete Course!">

                </form>  
            </li>
            <?php endforeach; ?>
        </ul>
  
<p>----------------------------------------------</p>

<?php include '../view/footer.php'; ?>