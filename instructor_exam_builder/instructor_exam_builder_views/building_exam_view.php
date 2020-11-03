
    <?php include '../view/header.php'; ?>

<h1>QUIZU EXAM BANK PORTAL</h1>
<p>----------------------------------------------</p>
<ul>

<!--
BUILDING AN EXAM:
    when we first build an exam, instantiate an empty exam object and bind it to the session variable
    as a user stays on this page and adds questions, add those questions to the exam 
    loop the current exam questions and add remove/modify questions
    at the end of the loop, add an empty question box
        user has to click 'save' on the question box to send it to the server and update the object

    put a SAVE EXAM or DELETE EXAM buttons that push exam object to db or unset the exam object var, respectively
-->

<p> PRINT THE SAVED QUESTIONS HERE </p>

<!-- 
    here we run the same function that reads and prints an exam object 
    <?php 
        //include('instructor_exam_builder_views\view_exam_questions_view.php'); 
        view_exam_questions($exam);
    ?>

-->
 
<p>---------------------------------------------------------------------------------</p>

<!-- html form code to input a question. make sure you have some input validation
a MC question consists of: 
    - a string question
    - 5 string awnsers
    - a correct awnser 

    a button that pushes the question to the server, wraps it inside a question object , and adds it to the exam object
    list of questions

-->


<form action="." method="post">

    <input type="hidden" name="action" value="push_exam_question"> 

        Question:
        <br> 
        <textarea rows="4" cols="50" name="exam_question"></textarea>
        <br>

        <input type="radio" name="correct_anwser" value="0" checked>1: <input type="text" name="exam_solution_1"><br>
        <input type="radio" name="correct_anwser" value="1">2: <input type="text" name="exam_solution_2"><br>
        <input type="radio" name="correct_anwser" value="2">3: <input type="text" name="exam_solution_3"><br> 
        <input type="radio" name="correct_anwser" value="3">4: <input type="text" name="exam_solution_4"><br> 
        <input type="radio" name="correct_anwser" value="4">5: <input type="text" name="exam_solution_5"><br> 

    <input type="submit" value="Save Question!">

</form>



<p>----------------------------------------------------------------------------------</p>
<!-- 
put the results on deletes, changes, and additions in here 
if theres errors, inform user of the type of error
use exceptions perhaps?
-->

<p>---------------------------------------------------------------------------------</p>

<form action="." method="post">
    <input type="hidden" name="action" value="save_exam_to_db"> 
    Exam Name: <input type="text" name="exam_name"><br>
    <input type="submit" value="Save Exam!">
</form>  

<form action="." method="post">
    <input type="hidden" name="action" value="abort_exam_building"> 
    <input type="submit" value="Cancel Building Exam!">
</form>  

</ul>
<?php include '../view/footer.php'; ?>
