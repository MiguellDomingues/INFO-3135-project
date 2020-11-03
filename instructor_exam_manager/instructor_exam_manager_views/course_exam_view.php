
    <?php include '../view/header.php'; ?>

<h1>MY COURSE EXAMS PORTAL</h1>
<p>----------------------------------------------</p>
<p>instructor <?php echo $instructor_name; ?> course exams:</p>
<ul>
    <!-- THIS IS THE HEADER OF EVERY COURSE THIS INSTRUCTOR TEACHES 

            FOR EACH COURSE THIS INSTRUCTOR TEACHES...-->
            <?php foreach($my_array as $courses) : ?>
            <li>
            <h1>
            <?php 
                $course_name = $courses->get_course_name();
                $course_id = $courses->get_course_id();
                $course_exams = $courses->get_course_exams();
                $exams = $courses->get_exams();

                echo "<h1> course name:".$course_name."</br> course id: ".$course_id."</h1>"; 
                echo "<p> Course Exams: ".sizeOf($course_exams)."</p>";
                echo "<p> total Exams: ".sizeOf($exams)."</p>";
            ?>
            </h1>

            <!--THIS IS THE CODE FOR THE DROPDOWN MENU CONTAINING EXAMS TO ATTACH TO COURSES.  
            I NEED SOME CHECKER CODE THAT DISABLES THE BUTTON WHEN THERES NO COURSES LEFT TO ATTACH
            -->
                    <form action="." method="post">
                            <input type="hidden" name="action" value="attach_course_exam"> 
                            <input type="hidden" name="course_num" value="<?php echo $course_id; ?>">
                            <select name="selected_exam">

                            <!--
                            PUT EVERY EXAM NOT! ATTACHED TO THIS COURSE INSIDE THE DROPDOWN MENU  -->
                            <?php foreach($exams as $exam) : ?>

                                    <option value="<?php echo $exam['exam_id'] ?>"> 
                                        Exam Name: <?php echo $exam['exam_name'] ?> 
                                        Exam Owner: <?php echo $exam['exam_owner'] ?> 
                                    </option>

                            <?php endforeach;?>

                            </select>

                            <input type="submit" value="Add a New Exam for this course!" <?php if(sizeOf($exams) == 0 )echo "disabled"; ?>>
                    </form>  
                <!--    END OF DROPDOWN MENU SECTION  -->
              
                    



                        <!-- THIS IS THE SECTION THAT LISTS EVERY COURSE EXAM ATTACHED TO A COURSE. THERE SHOULD NOT BE DUPLICATE COURSE INSIDE OF HERE
                        AND THE DROPDOWN MENU FOR THIS COURSE
                        
                        .. LIST COURSE EXAMS FOR THE COURSE -->
                        <?php foreach($course_exams as $course_exam): ?>
                        
                            <?php echo "Course Exam ID:".$course_exam['exam_id']." "; ?>
                            <?php echo "Course Exam Name:".$course_exam['exam_name']." "; ?>
                            <?php echo "Course Exam Owner:".$course_exam['exam_owner']." "; ?>
                        
                            <!-- BUTTON THAT UNATTACHES COURSE EXAMS -->
                            <form action="." method="post">
                                <input type="hidden" name="exam_id" value="<?php echo $course_exam['exam_id']; ?>">
                                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                                <input type="hidden" name="action" value="remove_course_exam"> 
                                <input type="submit" value="Remove exam from the course!">
                            </form>  

                           <!-- BUTTON THAT VIEWS A COURSE EXAM -->
                            <form action="." method="post">
                                <input type="hidden" name="exam_id" value="<?php echo $course_exam['exam_id']; ?>">
                                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                                <input type="hidden" name="action" value="view_course_exam"> 
                                <input type="submit" value="View Exam!">
                            </form>  
                            
                        
                        <?php endforeach; ?> 
                        <!-- END OF COURSE EXAMS SECTION -->
            </li>
            <?php endforeach; ?>
            <!-- END OF LISTING EVERY INSTRUCTOR COURSE -->
</ul>
  
<p>----------------------------------------------</p>

<?php include '../view/footer.php'; ?>


