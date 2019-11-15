<?php
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<form method="POST">
	<input type="hidden" name="action" value="cmd_felvetel">
	<input type="submit" value="Felvétel űrlap">
</form>
<?php
echo "<pre>"; var_dump($_REQUEST); echo "</pre>";
if(isset($_POST["action"]) and $_POST["action"]=="cmd_felvetel"){
	?>
	<form method="POST">
		Add meg a felhasználóneved: <br />
		<input type="text" name="input_user_username"><br />
		Add meg a jelszavad: <br />
		<input type="password" name="input_user_password"><br />
		Add meg a emailed: <br />
		<input type="email" name="input_user_email"><br />		
		Add meg a jogosultság: <br />	
		<select name="input_user_perm">
			<option value='user'>user</option>
			<option value='admin'>admin</option>
			<option value='moderator'>moderator</option>
		</select><br />	
		Add meg a aktivitást: <br />	
		<select name="input_user_activity">
			<option value='1'>Aktív</option>
			<option value='0' selected>Inaktív</option>
		</select><br />	
		<input type="hidden" name="action" value="cmd_insert_user">
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
$user_select = new adatbazis();
$user_select->user_select();

?>

</body>
</html>