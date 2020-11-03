<?php include '../view/header.php'; ?>

<h1>AVAILABLE COURSES FOR ENROLLMENT</h1>
<p>----------------------------------------------</p>

<ul>
           
            <?php foreach($non_enrolled_courses as $non_enrolled_course) : ?>
            <li> 
                    <form action="." method="post">

                    <input type="hidden" name="action" value="enroll_into_course">   

                    <input type="hidden" name="course_num" value="<?php echo $non_enrolled_course['course_num']; ?>">

                    <?php  echo "Course Name:".$non_enrolled_course['course_name']."</br>";  ?>
                    <?php  echo "course id:".$non_enrolled_course['course_num']."</br>";  ?>

                    <input type="submit" value="Enroll!">

                    </form>  
            </li>
            <?php endforeach; ?>
</ul>

<h1>ENROLLED COURSES</h1>    
<p>----------------------------------------------</p>

<ul>
            <!-- display links for all categories -->
            <?php foreach($enrolled_courses as $enrolled_course) : ?>
            <li>
                <form action="." method="post">
                <input type="hidden" name="action" value="unenroll_from_course">   

                    <input type="hidden" name="course_num" value="<?php echo $enrolled_course['course_num']; ?>">

                    <?php  echo "Course Name:".$enrolled_course['course_name']."</br>";  ?>
                    <?php  echo "Course Num:".$enrolled_course['course_num']."</br>";  ?>
                    

                    <input type="submit" value="Unenroll!">
                </form>        
            </li>
            <?php endforeach; ?>
        </ul>

 
<p>----------------------------------------------</p>


<?php
if(isset($error_msg))
    echo $error_msg;
  
?>

<?php include '../view/footer.php'; ?>