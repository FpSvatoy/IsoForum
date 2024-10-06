<?php 
	if(!function_exists("ts_debug")) {
		function ts_debug($message) {
				echo "<br><i><strong>Debug info:</strong></i><br>";
				echo "<i>{$message}</i><br><br>";
			}
		}
    // Global mysql connection here. host    username psw   name db  .Открытие соединения с сервером
    $connection = mysqli_connect('localhost','root', '', 'isoForum');
    if($connection){
        #ts_debug("Database running. Processing data.");
    }
?>