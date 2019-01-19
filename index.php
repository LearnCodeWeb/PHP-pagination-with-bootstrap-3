<?php include_once('config.php'); include_once('paginator.class.php'); ?>
<!DOCTYPE html>
<html>
<head>
<title>Pagination with bootstrap</title>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css" />
</head>
<body>
	<div class="container">
	<hr>
	<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>" class="form-inline">
		<select name="tb1" onchange="submit()" class="form-control">
			<option>Please select a continent</option>
			<?php
				$qry	=	mysql_query('SELECT DISTINCT continentName FROM countries ORDER BY continentName ASC');
				while($row = mysql_fetch_assoc($qry)) {
					echo "<option";
					if(isset($_REQUEST['tb1']) and $_REQUEST['tb1']==$row['continentName']) echo ' selected="selected"';
					echo ">{$row['continentName']}</option>\n";
				}
			?>
		</select>
	</form>
	<hr>
	<?php
	if(isset($_REQUEST['tb1'])) {
		$condition		=	"";
		if(isset($_GET['tb1']) and $_GET['tb1']!="")
		{
			$condition		.=	" AND continentName='".$_GET['tb1']."'";
		}
		
		$qryStr		=	"SELECT * FROM countries WHERE 1 ".$condition." ORDER BY countryName ASC"; 
		$country	=	mysql_query($qryStr);
		$count		=	mysql_num_rows($country);
		
		$pages = new Paginator($count,9);
		echo '<div class="col-sm-6">';
		echo '<nav aria-label="Page navigation"><ul class="pagination">';
		echo $pages->display_pages();
		echo '</ul></nav>';
		echo '</div>';
		echo '<div class="col-sm-6 text-right">';
		echo "<span class=\"form-inline\">".$pages->display_jump_menu().$pages->display_items_per_page()."</span>";
		echo '</div>';
		echo '<div class="clearfix"></div>';
		$limit	= $pages->limit_start.','.$pages->limit_end;
		$qry =	mysql_query($qryStr.' LIMIT '.$limit);
	}
	?>
	<table class="table table-bordered table-striped table-hover">
		<thead>
			<tr class="bg-primary">
				<th>Sr#</th>
				<th>Country Name</th>
				<th>ID</th>
				<th>Country Code</th>
				<th>Currency Code</th>
				<th>Capital</th>
			</tr>
		</thead>
		<tbody>
			<?php 
				$n	=	1;
				while($val=mysql_fetch_assoc($qry)){ 
			?>
			<tr>
				<td><?php echo $n++; ?></td>
				<td><?php echo $val['countryName']; ?></td>
				<td><?php echo $val['id']; ?></td>
				<td><?php echo $val['countryCode']; ?></td>
				<td><?php echo $val['currencyCode']; ?></td>
				<td><?php echo $val['capital']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	<?php
		echo '<div class="col-sm-6">';
		echo '<nav aria-label="Page navigation"><ul class="pagination">';
		echo $pages->display_pages();
		echo '</ul></nav>';
		echo '</div>';
		echo '<div class="col-sm-6 text-right">';
		echo "<p class=\"label label-default\">Page: $pages->current_page of $pages->num_pages</p>\n";
		echo '</div>';
		echo '<div class="clearfix"></div><hr>';
		echo "<p class=\"code\">SELECT * FROM table LIMIT $pages->limit_start,$pages->limit_end (retrieve records $pages->limit_start-".($pages->limit_start+$pages->limit_end)." from table - $pages->total_items item total / $pages->items_per_page items per page)";
	?>
			
	</div> <!--/.container-->
	<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
</html>