<?php include '../view/header.php'; ?>

<h1>Instructor Portal</h1>

links for instructor functions go HERE
<p>----------------------------------------------</p>

<form action="index.php" method="post">
<input type="hidden" name="action" value="show_create_course_view">
<input type="submit" value="create a new course!">
</form>

<form action="index.php" method="post">
<input type="hidden" name="action" value="view_my_courses">
<input type="submit" value="view my courses!">
</form>

<form action="index.php" method="post">
<input type="hidden" name="action" value="view_my_course_students">
<input type="submit" value="view my course students!">
</form>

<form action="../instructor_exam_manager/index.php" method="post">
<input type="hidden" name="action" value="exam_manager_portal">
<input type="submit" value="Manage my Course Exams!">
</form>


<form action="../instructor_exam_builder/index.php" method="post">
<input type="hidden" name="action" value="exam_builder_portal">
<input type="submit" value="Create, View, and Modify my Exams!">
</form>




<p>----------------------------------------------</p>


<?php include '../view/footer.php'; ?>