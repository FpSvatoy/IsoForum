	<?php include "includes/header.php"; ?>
		<div class="wrapperOther">
			<?php include "templates/sidemenu.php"; ?>
			<div class="content">
				<?php 
					//retrieving all comments
					if(isset($connection)) {
						$page_id = $_GET["page_id"];
						if(!(isset($page_id))) {
							header("Location: index.php?page_id=1");
						}
						$query = "SELECT * FROM content_page WHERE page_id = {$page_id}";
						$retrieve_comments_query = mysqli_query($connection, $query);
						$row  = mysqli_fetch_assoc($retrieve_comments_query);
						$content = $row['content'];
						echo $content; 
					} else {
						ts_debug("No connection to the database.");
					} 
				?>
				<?php include "templates/comments.php"; ?>
			</div>
		</div>
	<?php include "includes/footer.php"; ?>