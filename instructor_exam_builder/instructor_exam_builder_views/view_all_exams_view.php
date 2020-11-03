
    <?php include '../view/header.php'; ?>

<h1>QUIZU EXAM BANK PORTAL</h1>
<p>----------------------------------------------</p>
<p>instructor <?php echo $instructor_name; ?> course exams:</p>
<ul>
<h2>MY EXAMS:</h2>

<!-- THIS IS THE HEADER OF EVERY EXAM OWNED BY THIS INSTRUCTOR
THAT IS ATTACHED TO A COURSE...-->

    <!-- FOR EVERY EXAM OWNED BY THIS INSTRUCTOR -->
    <?php foreach($my_array as $instructor_exams) : ?>
        <li>
            <h1>
                <?php 

                    $exam_id = $instructor_exams->get_exam_id();
                    $exam_name = $instructor_exams->get_exam_name();
                    $exam_owner = $instructor_exams->get_exam_owner();
                    $creation_date = $instructor_exams->get_creation_date();
                    $courses = $instructor_exams->get_courses();

                    echo "<h1> Exam name:".$exam_name."</br> exam id: ".$exam_id."</h1>"; 
                    echo "<h1> Exam owner:".$exam_owner."</br> creation date: ".$creation_date."</h1>"; 
                    echo "<p> courses attached to this exam: ".sizeOf($courses)."</p>";
                
                ?>

                        <form action="." method="post">
                            <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
                            <input type="hidden" name="action" value="view_exam"> 
                            <input type="submit" value="View Exam!">
                        </form>  

                        <form action="." method="post">
                            <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
                            <input type="hidden" name="action" value="change_exam"> 
                            <input type="submit" value="Change Exam!">
                        </form>  

            </h1>
                        
                    <!-- FOR EACH EXAM, LIST ALL COURSE INFO..-->
                    <?php foreach($courses as $course): ?>
                        
                        <?php 

                        $bold_open = "";
                        $bold_close = "";

                        //IF THE COURSE IS A COURSE TAUGHT BY THIS INSTRUCTOR, WE BOLD THE TEXT
                        if($course['instructor_id'] === $instructor_id)
                        {
                            $bold_open = "<b>";
                            $bold_close = "</b>";
                        }
                        
                        echo $bold_open;
                        echo "Course Number:".$course['course_num']." "; 
                        echo "Course Name:".$course['course_name']." "; 
                        echo "Course Instructor:".$course['instructor_id']."</br>"; 
                        echo $bold_close;
                        
                        ?>

                        
                    <?php endforeach; ?> 
                    <!-- ...END OF EXAM COURSES INFO-->
            </li>
            <?php endforeach; ?>
            <!-- END OF LISTING EVERY INSTRUCTOR EXAM -->

<h2>--------------------------------------OTHER INSTRUCTOR EXAMS:-------------------------------------------------</h2>

    <!-- INSTRUCTORS SHOULD NOT BE ABLE TO SEE COURSES LINKED TO EXAMS THEY DONT OWN, SO JUST LIST OTHER INSTRUCTOR EXAMS -->
    <?php foreach($other_instructor_exams as $other_instructor_exam): ?>
                        
        <?php 
            echo "Exam ID:".$other_instructor_exam['exam_id']." "; 
            echo "Exam Owner:".$other_instructor_exam['exam_owner']." "; 
            echo "Exam Name:".$other_instructor_exam['exam_name']." "; 
            echo "Exam Creation Date:".$other_instructor_exam['creation_date']." "; 
        ?>
                
        <form action="." method="post">
            <input type="hidden" name="exam_id" value="<?php echo $other_instructor_exam['exam_id']; ?>">
            <input type="hidden" name="action" value="view_exam"> 
            <input type="submit" value="View Exam!">
        </form>  
                                    
    <?php endforeach; ?> 
    <!-- END OF LISTING OTHER INSTRUCTOR EXAMS -->



</ul>
<?php include '../view/footer.php'; ?>

