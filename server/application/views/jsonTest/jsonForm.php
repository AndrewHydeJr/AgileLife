<html>
<head>
	
	<script>
		function submitClicked()
		{
			var frm = document.getElementById('jsonForm');
			var path = document.getElementById('path');

			frm.action = path.value;
			
		}
	</script>
</head>



<body>

<form action="" id="jsonForm" name="jsonForm" method="post" >
	<input type="text" id="path" name="path" size="70" />
	
	<br /><br />
	
	<textarea name="jsonData" rows="20" cols="65"></textarea>
	<br /><br />
	<input type="submit" value="post" onclick="submitClicked()" />
</form>

</body>
</html>