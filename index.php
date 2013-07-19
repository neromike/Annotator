<?php include("check_login.php"); ?>
<?php include("header.php"); ?>

<?php
$error = "";
if (isset($_POST['PMID_add'])) {
	$fname = "annotation/" . $_POST['PMID_add'] . ".csv";
	if (file_exists($fname)) {
		$error = "PMID exists";
	} else {
		$fh = fopen($fname, "w");
	}
}
if (isset($_GET['pmid_delete'])) {
	unlink("annotation/" . $_GET['pmid_delete'] . ".csv");
}
?>

<style>
table {
	background-color: white;
	border:solid 0px grey;
}
.paper_table th { background-color: #BBB; }
.paper_table td {
	background-color: #DDD;
	padding-left: 10px;
	padding-right: 10px;
	text-align: center;
}
#add_paper {
	text-align: left;
}
</style>

<table width="100%">
	<tr>
		<td>
			<h1>Paper List</h1>
			<br />
		</td>
		<td align="right" style="font-size:12px;">
			Logged in as <em><?php echo $user; ?></em>
			<br />
			<a href="logout.php">Log out</a>
		</td>
	</tr>
</table>

<div id="add_paper">
	<form action="index.php" method="POST">
		Add a paper
		<input name="PMID_add" type="text" placeholder="PMID" <?php if (isset($fname)) { echo "value='" . $_POST['PMID_add'] . "' "; } ?>/>
		<input type="submit" value="Add" />
	</form>
	<?php
	if ($error == "PMID exists") {
		echo $_POST['PMID_add'] . " is already on the paper queue.";
	}
	?>
</div>

<table class="paper_table">
	<tr>
		<th>PMID</th>
		<!--<th>PDF</th>-->
		<th>Status</th>
		<th>Annotator</th>
		<th>Reviewer</th>
		<th>Action(s)</th>
	</tr>
	
	<?php
	$pmid_list = scandir("annotation");
	foreach ($pmid_list as $pmid_item) {
		if (($pmid_item != '.') && ($pmid_item != '..')) {
			$pmid_item = str_replace(".csv","",$pmid_item);
			
			echo '<tr>';
			
			echo '<td>';
			echo '<a href="http://www.ncbi.nlm.nih.gov/pubmed/' . $pmid_item . '" target="blank">';
			echo $pmid_item;
			echo '</a>';
			echo '</td>';
		
			//echo '<td>None, <a>upload one</a></td>';
		
			echo '<td>open</td>';
		
			echo '<td>N/A</td>';
			
			echo '<td>N/A</td>';
			
			echo '<td>';
			
			echo '<a href="annotate.php?pmid='. $pmid_item . '">annotate</a>';
			echo "&nbsp;";
			echo '<a href="index.php?pmid_delete=' . $pmid_item . '">delete</a>';
			
			echo '</td>';
			
			echo '</tr>';
		}
	}
	?>
	
	
</table>

<?php include("footer.php"); ?>