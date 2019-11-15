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
			<option value='tilalom'>Tilalom alatt</option>
			<option value='foghato'>Szabadon fogható</option>
		</select><br />		
		Add meg a legutolsó fogás dátumát: <br />	
		<input type="date" id="start" name="trip-start"
            value="2019-01-01"
            min="1999-01-01" max="2019-12-31">

		<input type="hidden" name="action" value="cmd_insert_hal">
		<input type="submit" value="Felvétel">
	</form>	
	<?php
}

if(isset($_POST["action"]) and $_POST["action"]=="cmd_insert_user"){
	$user_insert = new adatbazis();
	echo $user_insert->user_insert($_POST["input_user_username"],
							  $_POST["input_user_password"],
							  $_POST["input_user_email"],
							  $_POST["input_user_perm"],
							  $_POST["input_user_activity"]
							  );
}
if(isset($_POST["action"]) and $_POST["action"]=="cmd_delete_user"){
	$user_delete = new adatbazis();
	echo $user_delete->user_delete($_POST["input_id"] );
}
if(isset($_POST["action"]) and $_POST["action"]=="cmd_update_active"){
	$user_update_active = new adatbazis();
	echo $user_update_active->user_update_active($_POST["input_id"] );
}
if(isset($_POST["action"]) and $_POST["action"]=="cmd_update_inactive"){
	$user_update_inactive = new adatbazis();
	echo $user_update_inactive->user_update_inactive($_POST["input_id"] );
}
if(isset($_POST["action"]) and $_POST["action"]=="cmd_update_perm_user"){
	$user_update_perm_user = new adatbazis();
	echo $user_update_perm_user->user_update_perm_user($_POST["input_id"] );
}
if(isset($_POST["action"]) and $_POST["action"]=="cmd_update_perm_admin"){
	$user_update_perm_admin = new adatbazis();
	echo $user_update_perm_admin->user_update_perm_admin($_POST["input_id"] );
}
if(isset($_POST["action"]) and $_POST["action"]=="cmd_update_perm_moderator"){
	$user_update_perm_moderator = new adatbazis();
	echo $user_update_perm_moderator->user_update_perm_moderator($_POST["input_id"] );
}
if(isset($_POST["action"]) and $_POST["action"]=="cmd_update_perm_given"){
	$user_update_perm_given = new adatbazis();
	echo $user_update_perm_given->user_update_perm_given($_POST["input_id"], $_POST["input_user_perm"]);
}
if(isset($_POST["action"]) and $_POST["action"]=="cmd_update_user_plus100"){
	$user_update_plus100 = new adatbazis();
	echo $user_update_plus100->user_update_plus100($_POST["input_id"]);
}
if(isset($_POST["action"]) and $_POST["action"]=="cmd_update_user_minus100"){
	$user_update_minus100 = new adatbazis();
	echo $user_update_minus100->user_update_minus100($_POST["input_id"]);
}
$halak = new adatbazis();
$halak->hal_select();

?>

</body>
</html>