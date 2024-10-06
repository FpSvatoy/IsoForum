<?php
function findAllCategories() {
    include "includes/db.php";
    // fetch all categories
    $query = "SELECT * FROM user";
    $select_user = mysqli_query($connection, $query);
    while($row = mysqli_fetch_array($select_user)) {
        $user_id = $row["user_id"];
        $nickname = $row["nickname"];
        $user_group = $row["user_group"];
        $queryGrName = "SELECT group_name FROM user_group WHERE `group_id` = '{$user_group}'";
        $select_GrName = mysqli_query($connection, $queryGrName);
        $capability_assoc = mysqli_fetch_assoc($select_GrName);
        $capability = $capability_assoc["group_name"];
        echo "<tr>";
        echo "<td>{$nickname}</td>";
        echo "<td>{$capability}</td>";
        echo "<td><a href='lk.php?edit={$user_id}'>Edit</a></td>";
    }
}
?>
