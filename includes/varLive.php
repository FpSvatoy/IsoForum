<?php 
    function func_varLive($nameVar) {
        if(isset( $_POST["$nameVar"])&&$_POST["$nameVar"]!=''){
            return true;
        }else{
            return false;
        }
    }
    function func_sessionValue($nameVar) {
        if ((isset($_POST["$nameVar"]))){
            $_SESSION["$nameVar"]=$_POST["$nameVar"];
        }
    }
?>