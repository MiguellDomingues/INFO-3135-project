<p>-----------EXAM IN PROGRESS-------------</p>


<!--
<form method="post">
    <?php
    //for($i=1;$i<=5;$i++)
   // {
        ?>
        <div class="well well-sm well-primary">
            <input type="hidden" name="ques"/>Questions?
        </div>
        <div class="well well-sm">
            <div class="radio">
                <label>
                <input type="radio" name="optradio[<?//php echo $i; ?>]" value="a">Option 1</label>
            </div>
            <div class="radio">
                <label>
                <input type="radio" name="optradio[<?//php echo $i; ?>]" value="b">Option 2</label>
            </div>
            <div class="radio">
                <label>
                <input type="radio" name="optradio[<?//php echo $i; ?>]" value="c">Option 3</label>
            </div>
        </div>
        <?php
    //}
    ?>
    <button type="submit" class="btn btn-success" name="submit">Finish</button>
</form>
-->

<form action="." method="post">

<?php 
  
    $exam_questions = $exam->get_exam_questions();
    $question_number = 0;
    $quote_char = '"';


    foreach($exam_questions as $exam_question) : ?>

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
    <input type="hidden" name="action" value="mark_exam"> 
    <input type="submit" value="Mark the Exam!">
</form>


   


    <!--


if ( isset( $_POST['diameters'] ) )
{
    echo '<table>';
    foreach ( $_POST['diameters'] as $diam )
    {
        // here you have access to $diam['top'] and $diam['bottom']
        echo '<tr>';
        echo '  <td>', $diam['top'], '</td>';
        echo '  <td>', $diam['bottom'], '</td>';
        echo '</tr>';
    }
    echo '</table>';

-->