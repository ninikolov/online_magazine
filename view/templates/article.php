



 <?php
 if($Article == null) {
 	echo "<meta http-equiv='refresh' content='0;".ROOT."' >";
 }
	echo "<h2>" . $Article->getTitle () . "</h2>";
	echo "<p>" . $Article->getBody () . "</p>";
	
	?>