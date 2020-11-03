
<?php include '../view/header.php'; ?>

<h1>VIEWING EXAM:</h1>
<p>---------------------------------------------------------------------------------</p>
<ul>

<?php view_exam_header($exam) ?>

<p>---------------------------------------------------------------------------------</p>

<?php view_exam_questions($exam) ?>

<p>---------------------------------------------------------------------------------</p>

<form action="index.php" method="post">
<input type="hidden" name="action" value="exam_manager_portal">
<input type="submit" value="back to portal!">
</form>


</ul>
<?php include '../view/footer.php'; ?>