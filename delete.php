<?php
require_once "config.php";
$id=$_REQUEST['id'];
$query = "DELETE FROM new_record WHERE id=$id";
$result = mysqli_query($db,$query) or die ( mysqli_error($db));
header("Location: view.php");
exit();
?>