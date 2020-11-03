<?php include '../view/header.php'; ?>

<?php view_exam_header($exam); ?>

<form action="." method="post">

<?php 
    $exam_questions = $exam->get_exam_questions();
    $question_number = 0;
    $quote_char = '"';
?>


    <?php foreach($exam_questions as $exam_question) : ?>

        <?php   
            $question = $exam_question->get_question();
            $anwsers = $exam_question->get_anwsers();
        ?>

        <p> <?php echo ($question_number + 1).": ".$question ?> </p>
        
        <div>
       
            <?php 
            $answer_number = 0;
            foreach($anwsers as $anwser) : 
        
                echo ($answer_number+1).":"."<input type=".$quote_char."radio".$quote_char." 
                     name=".$quote_char."question_answers[".$question_number."]".$quote_char." 
                     value=".$quote_char."".$answer_number."".$quote_char." checked>".$anwser."<br>";
            // echo $anwser."<br>";
            $answer_number++; 
            endforeach;
            ?>

        </div>

    <br>

    <?php 
    $question_number++;
    endforeach;
    ?>
<!--
<input type="hidden" name="action" value="mark_exam"> 
<input type="submit" value="check">
-->
    <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">   
    <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">  
    <input type="hidden" name="action" value="mark_exam"> 
    <input type="submit" value="Mark the Exam!">
</form>



<?php include '../view/footer.php'; ?>