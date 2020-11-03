<?php include '../view/header.php'; ?>

<h1>Instructor Exam Manager Portal</h1>

links for instructor exam functions go HERE
<p>---------here we show our courses and course exams-----------</p>

<form action="index.php" method="post">
<input type="hidden" name="action" value="view_course_exams">
<input type="submit" value="view course exams!">
</form>

<p>-------------------------here we create a course exam-------------------</p>
<form action="index.php" method="post">
<input type="hidden" name="action" value="create_course_exam">
<input type="submit" value="create a course exam!">
</form>
<p>----------------------------------------------</p>


<?php include '../view/footer.php'; ?>