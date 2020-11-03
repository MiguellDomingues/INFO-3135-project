<?php include '../view/header.php'; ?>

<h1>MY COURSE EXAMS PORTAL</h1>
<p>----------------------------------------------</p>
<p> my course exams:</p>
<ul>

<?php foreach($my_array as $courses) : ?>
            <li>

            <?php 
                $course_name = $courses->get_course_name();
                $course_id = $courses->get_course_id();
                //$course_exams = $courses->get_course_exams();
                $pending_course_exams = $courses->get_pending_course_exams();
                $completed_course_exams = $courses->get_completed_course_exams();

                echo "<h1> course name:".$course_name."</br> course id: ".$course_id."</h1>"; 
                echo "<p> Pending Course Exams: ".sizeOf($pending_course_exams)."</p>";
                echo "<p> Completed Course Exams: ".sizeOf($completed_course_exams)."</p>";
            ?>
                    <p>------------------------pending exams------------------------------</p>
                        
                        <?php foreach($pending_course_exams as $pending_course_exam): ?>
                        
                            <?php echo "Course Exam ID:".$pending_course_exam['exam_id']." "; ?>

                            <form action="." method="post">
                                <input type="hidden" name="exam_id" value="<?php echo $pending_course_exam['exam_id']; ?>">
                                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                                <input type="hidden" name="action" value="take_course_exam"> 
                                <input type="submit" value="Take Exam Now!">
                            </form>  
                        
                        <?php endforeach; ?> 

                        <p>---------------------completed exams!----------------------------</p>

                        <?php foreach($completed_course_exams as $completed_course_exam): ?>
                        
                            <?php echo "Course Exam ID:".$completed_course_exam['exam_id']." "; ?>
                            <?php echo "Course Exam Grade:".$completed_course_exam['exam_grade']." "; ?>

                            <form action="." method="post">
                                <input type="hidden" name="exam_id" value="<?php echo $completed_course_exam['exam_id']; ?>">
                                <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
                                <input type="hidden" name="action" value="review_course_exam"> 
                                <input type="submit" value="Review this Exam!">
                            </form>  
                    
                        <?php endforeach; ?>
            </li>
            <?php endforeach; ?>
            
</ul>
<p>----------------------------------------------</p>
<p> completed course exams:
<p>----------------------------------------------</p>


<?php include '../view/footer.php'; ?>