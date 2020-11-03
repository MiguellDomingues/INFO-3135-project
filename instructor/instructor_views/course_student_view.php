
    <?php include '../view/header.php'; ?>

<h1>MY COURSE STUDENTS</h1>
<p>----------------------------------------------</p>
<p>instructor <?php echo $instructor_name; ?> course students:</p>
<ul>
            <?php foreach($my_array as $course_name => $course_students) : ?>
            <li>
            <?php 
                echo "<h1>".$course_name."</h1>"; 
                echo "<p> Course Students: ".sizeOf($course_students)."</p>"; 
            ?>

                    <?php             
                        foreach($course_students as $course_student)
                            echo " ".$course_student['user_name']."</br>";          
                    ?>     
            </li>
            <?php endforeach; ?>
</ul>
  
<p>----------------------------------------------</p>

<?php include '../view/footer.php'; ?>