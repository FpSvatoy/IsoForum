<!-- Проверка возможности получения комментариев -->
<?php
    if(isset($_GET['page_id'])) $page_id = $_GET['page_id'];
    else if (isset($_POST['page_id'])) $page_id = $_POST['page_id'];
    else  {
        ts_debug("Page id is missing! Cannot retrieve comments!");
        die();
    }
?>

<!-- Предварительная обработка данных формы комментария (если они есть), 
чтобы отобразить их без дополнительного обновления страницы. -->
<?php
session_start();
    if(isset($_POST['submit'])) {
        if(isset($connection)) {        
            $page_id = $_POST["page_id"];
            $fresh_comment_author_id = $_POST["author_id"];
            $fresh_reply_to = $_POST["reply_to"];
            $fresh_comment_text = $_POST["comment_text"];

            // недостаточно передать в MySQL значение null — результатом будет 0
            // чтобы получить фактический ноль, нам вообще не нужно ничего передавать
            // в бд по умолчанию в поле reply_to будет внесено значение null.
if (empty($fresh_reply_to)) {
    $insert_query = "INSERT INTO comment ( `page_id`, `author_id`, `text` )";
    $insert_query .= "VALUE('{$page_id}', '{$fresh_comment_author_id}', '{$fresh_comment_text}')";
} else {
    $insert_query = "INSERT INTO comment ( `page_id`, `author_id`, `reply_to`, `text` )";
    $insert_query .= "VALUE('{$page_id}', '{$fresh_comment_author_id}', '{$fresh_reply_to}', '{$fresh_comment_text}')";
}
            $comment_creation_result = mysqli_query($connection, $insert_query);
            if(!$comment_creation_result) {
                echo "Unable to post a comment, sorry, database error.<br>";
                echo "The error is: ". mysqli_error($connection);
            }
        }
    }

?>

<!-- Блок для написания комментариев  -->
<div class="comments">
    <h3>Комментарии</h3>
    <?php 
    //проверка на права доступа, если прав не достаточно, т.е. пользователь не зашел в ЛК,
    //то у него будет отсутствовать возможность написать комментарий
        
        if(isset($_SESSION["auth_user"])){
			$nowAuthUser = $_SESSION["auth_user"];
            $query = "SELECT user_group FROM user WHERE `login` = '{$nowAuthUser}'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $user_group = $row['user_group'];
            #$user_group = 0;
        }else{
            $user_group = '0';
        }
        if($user_group > 0) {

    ?>
    <a href="<?php echo explode('?', $_SERVER['REQUEST_URI'])[0] . '?page_id=' . $page_id . '&add_comment=-1#comment-form';?>">
        Написать комментарий
    </a>
    <?php } ?>
	<hr>

    <?php 
        //получение всех комментариев
        if(isset($connection)) {
            $query = "SELECT * FROM comment WHERE page_id = {$page_id}";
            $retrieve_comments_query = mysqli_query($connection, $query);
            //в цикле проходимся по каждому комментарию
            while($row = mysqli_fetch_assoc($retrieve_comments_query)) {
                $comment_id = $row["comment_id"];
                $comment_author_id = $row["author_id"];
                $reply_to = $row["reply_to"];
                $comment_text = $row["text"];
                //получаем имя пользователя текущего комментария по айди пользователя
                $author_query = "SELECT name FROM user WHERE user_id = {$comment_author_id} LIMIT 1";
                $retrieve_author_query = mysqli_query($connection, $author_query);
                $comment_author_name = mysqli_fetch_assoc($retrieve_author_query)["name"];
                //reply_to - комментарий на который отвечает текущий комментарий
                //если это ответ на какой либо коммент, то нам надо получить имя пользователя того комментария, на который текущий комментарий отвечает.
                if(!empty($reply_to)) {
                    // комментарии хранят только идентификатор reply_to, author_id можно получить здесь
                    $replyto_author_id_query = "SELECT author_id FROM comment WHERE comment_id = {$reply_to} LIMIT 1";
                    $retrieve_reply_author_query = mysqli_query($connection, $replyto_author_id_query);
                    $reply_comment_author_id = mysqli_fetch_assoc($retrieve_reply_author_query)["author_id"];

                    // получение имя автора ответа по author_id полученному ранее
                    $replyto_author_name = "SELECT name FROM user WHERE user_id = {$reply_comment_author_id} LIMIT 1";
                    $retrieve_reply_author_name_query = mysqli_query($connection, $replyto_author_name);
                    $reply_comment_author_name = mysqli_fetch_assoc($retrieve_reply_author_name_query)["name"];
                }
            ?>

                <!-- Формирование и вывод текущего комментария - start -->
                <div id="comment-<?php echo $comment_id; ?>" class="single-comment">
                    <?php if( !is_null( $reply_to ) ) { ?>
                        <div class="comment-reply">
                            <div class="comment-author"><?php echo $comment_author_name; ?></div>
                            <span>отвечает на <a href="#comment-<?php echo $reply_to; ?>">комментарий</a></span>
                            <div class="comment-author"><?php echo $reply_comment_author_name; ?></div>
                        </div>
                    <?php } else { ?>
                        <div class="comment-author"><?php echo $comment_author_name; ?></div>
                    <?php } ?>
                    <div class="comment-text"><?php echo $comment_text; ?></div>
                    <?php if($user_group > 0) {?>
                    <a href="<?php echo explode('?', $_SERVER['REQUEST_URI'])[0] . '?page_id=' . $page_id . '&add_comment=' . $comment_id;?>" class="comment-reply-button">Ответить</a>
                    <?php } 
                    if($user_group > 1){ ?>
                     <a href="<?php echo '../server/remove.php'. '?page_id=' . $page_id . '&remove_comment=' . $comment_id ;?>" class="comment-reply-button">Удалить</a>
                    <?php }?>
                </div>
                <!-- Вывод текущего комментария - end -->
            <?php } ?>

            <?php 
            
            #echo "add_comment prestent :" . (isset($_GET["add_comment"]) . "<br>"); 
            #echo "submit absent :" . (!isset($_POST['submit']) . "<br>"); 
            ?>
            <!-- Форма нового комментария(либо коммент к страницы/либо ответ на чей либо коммент - не важно. Все тут) -->
            <!-- Т.е. тут потом формируется URL строка, которая в начале кода у нас обрабатывается и добавляется в БД-->
            <?php if(isset($_GET["add_comment"]) and !isset($_POST['submit'])) { ?>
                <form id="comment-form" action="" method="POST">
                        <label for="comment_text">Введите текст комментария:</label>
                        <textarea type="text" name="comment_text"></textarea>
                        <!-- 
                            Это скрытое поле важно, поскольку оно сохраняет идентификатор страницы и возвращает нас на ту же страницу.
                            Запрос POST удаляет все строки запроса, поэтому он не вернется на ту же страницу, если ?page_id
                            отсутствует в URL-адресе страницы
                        -->
                        <input type="hidden" name="page_id" value="<?php echo $page_id;?>"> 
                        <!--TODO: Замена author_id актуальным id пользователя из Session -->
                        <?php
                            $login = $_SESSION["auth_user"];
                            $query = "SELECT user_id FROM user WHERE login = '{$login}' LIMIT 1";
                            $retrieve_current_user_id = mysqli_query($connection, $query);
                            $current_user_id = mysqli_fetch_assoc($retrieve_current_user_id)["user_id"];
                        ?>
                        <input type="hidden" name="author_id" value="<?php echo $current_user_id;?>">
                        <input type="hidden" name="reply_to" value="<?php echo  $_GET["add_comment"] == -1 ? "" :  $_GET["add_comment"]; ?>">
                        <?php if($_GET["add_comment"] != -1) {?>
                        <div class="comment-reply">
                            <input type="submit" value="Отправить" name="submit">
                            <span> вы отвечаете на <a href="#">комментарий</a> </span>  
                            <?php
                                $reply_to = $_GET["add_comment"];
                                // это должна быть функция, но неважно.. 
                                // комментарии хранят только идентификатор, его можно получить здесь
                                $replyto_author_id_query = "SELECT author_id FROM comment WHERE comment_id = '{$reply_to}' LIMIT 1";
                                $retrieve_reply_author_query = mysqli_query($connection, $replyto_author_id_query);
                                $reply_comment_author_id = mysqli_fetch_assoc($retrieve_reply_author_query)["author_id"];

                                // получение имя автора ответа по идентификатору
                                $replyto_author_name = "SELECT name FROM user WHERE user_id = {$reply_comment_author_id} LIMIT 1";
                                $retrieve_reply_author_name_query = mysqli_query($connection, $replyto_author_name);
                                $reply_comment_author_name = mysqli_fetch_assoc($retrieve_reply_author_name_query)["name"];
                            ?>
                            <div class="comment-author"> <?php echo $reply_comment_author_name; ?> </div>
                        </div>
                        <?php }else {?>
                            <input type="submit" value="Отправить" name="submit">
                        <?php } ?>
                </form>
            <?php } ?>

        <?php } else {
            ts_debug("No connection to the database.");
        } 
    ?>
</div>