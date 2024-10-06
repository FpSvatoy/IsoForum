<?php 
    include "../includes/db.php";
    $delete_comment = $_GET["remove_comment"];
    $page_id = $_GET["page_id"];
    $querylogin = "DELETE FROM comment WHERE comment_id = '{$delete_comment}'";
	$checklog = mysqli_query($connection, $querylogin);
    header('Location: ../index.php?page_id='.$page_id);
?>