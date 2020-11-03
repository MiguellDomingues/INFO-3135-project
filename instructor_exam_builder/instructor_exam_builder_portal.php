<?php include '../view/header.php'; ?>

<h1>Instructor Exam Builder Portal</h1>

links for instructor exam functions go HERE

<p>---------here we show our courses and course exams-----------</p>

<form action="index.php" method="post">
<input type="hidden" name="action" value="create_exam">
<input type="submit" value="build a new exam!">
</form>

<p>-------------------------here we create a course exam-------------------</p>
<form action="index.php" method="post">
<input type="hidden" name="action" value="view_all_exams">
<input type="submit" value="view my exams!">
</form>
<p>----------------------------------------------</p>


<?php include '../view/footer.php'; ?>