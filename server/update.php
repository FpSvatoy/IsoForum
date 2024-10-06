<?php 
    include "../includes/db.php";
    if(isset($_POST["btn_update"])){
        var_dump($_POST);
        $newcapability = $_POST["newcapability"];
        $nickname = $_POST["nickname"];
        $update_id = $_POST["user_id"];
        $query = "UPDATE user SET `user_group` = '{$newcapability}', `nickname` = '{$nickname}' WHERE user_id = '{$update_id}' ";
        $update_category_query = mysqli_query($connection, $query);
        if(!$update_category_query) {
            die("query failed ". mysqli_error($connection));
        } else {
            header('Location: ../lk.php');
        }
    }else{
        echo "error";
    }
?>