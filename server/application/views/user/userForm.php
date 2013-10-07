<?
	/*echo form_open('save/user');
	echo form_input('path', 'foo');
	echo form_submit('mysubmit', 'Submit Post!');
	echo form_clos();	*/
?>

<form action="http://agileLife/save/user" method="post" >
	<input type="text" name="path" size="70" />
	
	<br /><br />
	
	<textarea name="jsonBody" rows="35" cols="65"></textarea>
	<br /><br />
	<input type="submit" value="post"  />
</form>



<!--
<html>
<body>



<form action="http://agilelife/index.php/save/user" method="post" enctype="text/plain"  >
	<input type="text" name="path" size="100" value="foo" />
	<br /><br />

	<textarea name="jsonBody" rows="35" cols="65">
		
	</textarea>
	<br />
	<input type="submit" />

</form>
</body>
</html>
-->