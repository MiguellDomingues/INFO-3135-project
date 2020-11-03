<?php include '../view/header.php'; ?>

<h1>Student Portal</h1>


<p>----------------------------------------------</p>

<form action="index.php" method="post">
<input type="hidden" name="action" value="view_available_courses">
<input type="submit" value="Manage My Courses!">
</form>

<form action="index.php" method="post">
<input type="hidden" name="action" value="view_available_course_exams">
<input type="submit" value="Manage My Course Exams!">
</form>


<p>----------------------------------------------</p>

<?php include '../view/footer.php'; ?>

<!-- $action = filter_input(INPUT_POST, 'action'); -->