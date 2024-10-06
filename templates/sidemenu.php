<div class="sidemenu">
	<ul>
		<?php 
			//retrieving all comments
			if(isset($connection)) {
				$query = "SELECT * FROM content_page";
				$retrieve_comments_query = mysqli_query($connection, $query);
				while($row = mysqli_fetch_assoc($retrieve_comments_query)) {
					$page_id = $row["page_id"];
					$name_page = $row["name_page"];
				?>
				<li><a href="?page_id=<?php echo $page_id?>"> <?php echo $name_page?></a>
				<?php } ?>
			<?php } else {
				ts_debug("No connection to the database.");
			} 
		?>
	</ul>
</div>

