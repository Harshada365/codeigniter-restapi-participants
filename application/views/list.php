<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
	<title>Eduvanz</title>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
</head>
<body>
	<h1>Participants Listing</h1>
	<br>
	<table id="participants">
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Age</th>
				<th>DOB</th>
				<th>Profession</th>
				<th>Locality</th>
				<th>No. of guests</th>
				<th>Address</th>
			</tr>
		</thead>
	</table>

	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#participants').dataTable({
				serverSide: true,
				ajax: '<?php echo base_url('participant/load_data'); ?>'
			});
		});
	</script>
</body>
</html>