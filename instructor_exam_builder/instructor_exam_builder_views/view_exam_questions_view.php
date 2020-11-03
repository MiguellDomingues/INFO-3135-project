


<!--
    standalone view module that prints out an exam object:
        gets its data from either:
            an exam object from an instructor building an exam (SESSION_VAR)
                OR a db query on exam_id that fetchs all the questions and wraps the into a single exam object
    either way, the code will run an $exam var that contains a reference to an exam object
        
-->

    <?php 
    //$exam = get_SESSION_exam_object($instructor_id);
    //print other exam info here
    $exam_questions = $exam->get_exam_questions();
    //print # of questions

    foreach($exam_questions as $exam_question) : ?>

        <?php   
            $question = $exam_question->get_question();
            $anwsers = $exam_question->get_anwsers();
            $correct_anwser = $exam_question->get_correct_awnser();
        ?>

        <p> <?php echo $question ?> </p>
        
        <!-- 
            this code snippet simply bolds the correct answer using the correct answer index as all 5 answers are printed
        -->
        <?php 
        $i = 0;
        foreach($anwsers as $anwser) : 
        
            $bold_open = "";
            $bold_close = "";

            if($i == $correct_anwser)
            {
                $bold_open = "<b>";
                $bold_close = "</b>";
            }

            //treat this line as the html code sent to browser
            echo $bold_open.($i+1).": ".$anwser."<br>".$bold_close;

        $i++;
        endforeach;
        ?>

    <br>

    <?php endforeach;?>





