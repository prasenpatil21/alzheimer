<?php


 ?>
<?php get_header(); ?>
<div class="wrap" >
	<div id="primary" class="content-area">
		<table border="1">
			<tr>
				<th>Id</th>
				<th>Risk Factor Name</th>
			</tr>
			<?php
			global $wpdb;
			$sql="SELECT * FROM wp_products";
			$results = $wpdb->get_results($sql);
      echo "<pre>";
      print_r($results);
      echo "</pre>";
      // die;
       ?>
		</table
	</div>
</div>
