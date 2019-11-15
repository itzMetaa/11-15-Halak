<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php 
    include("adatbazis.php");
?>
<form method="POST">
	<input type="hidden" name="action" value="cmd_felvetel">
	<input type="submit" value="Felvétel űrlap">
</form>
<?php
echo "<pre>"; var_dump($_REQUEST); echo "</pre>";
if(isset($_POST["action"]) and $_POST["action"]=="cmd_felvetel"){
	?>
	<form method="POST">
		Add meg a hal nevét: <br />
		<input type="text" name="input_hal_nev"><br />
		Add meg mennyi halad van: <br />
		<input type="text" name="input_hal_db"><br />
		Fogási tilalom alatt van-e a hal: <br />
        <select name="input_hal_tilalom">
			<option value='1'>Tilalom alatt</option>
			<option value='0'>Szabadon fogható</option>
		</select><br />		
		Add meg a legutolsó fogás dátumát: <br />	
		<input type="date" id="start" name="input_hal_utolso_fogas"
            value="2019-01-01"
            min="1999-01-01" max="2019-12-31">

		<input type="hidden" name="action" value="cmd_insert_hal">
		<input type="submit" value="Felvétel">
	</form>	
	<?php
}

if(isset($_POST["action"]) and $_POST["action"]=="cmd_insert_hal"){
	$hal_insert = new adatbazis();
	echo $hal_insert->hal_insert($_POST["input_hal_nev"],
							  $_POST["input_hal_db"],
							  $_POST["input_hal_tilalom"],
							  $_POST["input_hal_utolso_fogas"]
							  );
}
if(isset($_POST["action"]) and $_POST["action"]=="cmd_delete_hal"){
	$hal_delete = new adatbazis();
	echo $hal_delete->hal_delete($_POST["input_id"] );
}
if(isset($_POST["action"]) and $_POST["action"]=="hal_update_tilalom"){
	$hal_update_tilalom = new adatbazis();
	echo $hal_update_tilalom->hal_update_tilalom($_POST["input_id"] );
}
if(isset($_POST["action"]) and $_POST["action"]=="hal_update_szabad"){
	$hal_update_szabad = new adatbazis();
	echo $hal_update_szabad->hal_update_szabad($_POST["input_id"] );
}

$halak = new adatbazis();
$halak->hal_select();

?>

</body>
</html>