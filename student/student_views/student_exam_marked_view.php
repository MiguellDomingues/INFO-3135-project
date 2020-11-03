<?php include '../view/header.php'; ?>

<h1>EXAM COMPLETE</h1>

<?php
   echo "exam ID: ".$exam_id;
   echo "course NUM: ".$course_id;
   echo "student ID: ".$student_id;
?>

<p>exam complete! your grade was <?php echo $exam_grade ?>%!</p>
<p>the exam has been saved! you can review anytime when viewing your courses!<p>




<?php include '../view/footer.php'; ?>