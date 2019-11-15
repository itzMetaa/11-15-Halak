<?php
class adatbazis{
	public $servername = "localhost:3306";
	public $username = "root";
	public $password = "";
	public $dbname = "adattar";
	public $sql = NULL;
	public $result = NULL;
	public $row = NULL;
	
	public function __construct(){ self::kapcsolodas(); }
	public function __destruct(){ self::kapcsolatbontas(); }
	
	public function kapcsolodas(){
		$this->conn = new mysqli($this->servername, 
						   $this->username, 
						   $this->password, 
						   $this->dbname);
		if ($this->conn->connect_error) {
			die("Connection failed: " . $this->conn->connect_error);
		}
		$this->conn->query("SET NAMES 'UTF8'");
	}
	public function kapcsolatbontas(){
		$this->conn->close();
	}
	public function user_select(){
		$this->sql = "SELECT  
					user_id ,  
					user_username ,    
					user_email ,  
					user_perm ,  
					user_activity  ,
					user_credit
				FROM  
					users ";
		$this->result = $this->conn->query($this->sql);

		if ($this->result->num_rows > 0) {
			echo "<table>";
			echo "<tr>";
				echo "<td>ID</td>";
				echo "<td>@</td>";
				echo "<td>DEL</td>";
				echo "<td>ACT</td>";
				echo "<td>JOG</td>";
				echo "<td>JOG2</td>";
				echo "<td>$</td>";
			echo "</tr>";
			while($this->row = $this->result->fetch_assoc()) {
				echo "<tr>";
					echo "<td>" . $this->row["user_id"]. "</td>";
					echo "<td>" . $this->row["user_email"]. "</td>";
					echo "<td>";
					echo "<form method='POST'>
							<input type='hidden' name='action' value='cmd_delete_user'>
							<input type='hidden' name='input_id' value='".$this->row["user_id"]."'>
							<input type='submit' value='X'>
						 </form>";	
					echo "</td>";
					echo "<td>";
					echo "<form method='POST'>
							<input type='hidden' name='action' value='cmd_update_active'>
							<input type='hidden' name='input_id' value='".$this->row["user_id"]."'>
							<input type='submit' value='ACT'>
						 </form>";
					echo "<form method='POST'>
							<input type='hidden' name='action' value='cmd_update_inactive'>
							<input type='hidden' name='input_id' value='".$this->row["user_id"]."'>
							<input type='submit' value='INACT'>
						 </form>";						 
						echo "[" . $this->row["user_activity"]. "]";
					echo "</td>";
					echo "<td>";
					echo "<form method='POST'>
							<input type='hidden' name='action' value='cmd_update_perm_user'>
							<input type='hidden' name='input_id' value='".$this->row["user_id"]."'>
							<input type='submit' value='USER'>
						 </form>";
					echo "<form method='POST'>
							<input type='hidden' name='action' value='cmd_update_perm_admin'>
							<input type='hidden' name='input_id' value='".$this->row["user_id"]."'>
							<input type='submit' value='ADMIN'>
						 </form>";
						 echo "<form method='POST'>
							<input type='hidden' name='action' value='cmd_update_perm_moderator'>
							<input type='hidden' name='input_id' value='".$this->row["user_id"]."'>
							<input type='submit' value='MODERATOR'>
						 </form>";						 
						 echo "[" . $this->row["user_perm"]. "]";
					echo "</td>";
					echo "<td>";
						echo "<form method='POST'>";
							echo "<select name='input_user_perm'
										  onchange='this.form.submit();'>";
								echo "<option value='user' ".(($this->row["user_perm"]=="user")?" selected ":" ").">user</option>";
								echo "<option value='admin' ".(($this->row["user_perm"]=="admin")?" selected ":" ").">admin</option>";
								echo "<option value='moderator' ".(($this->row["user_perm"]=="moderator")?" selected ":" ").">moderator</option>";
							echo "</select>";
							echo "<input type='hidden' name='action' value='cmd_update_perm_given'>";
							echo "<input type='hidden' name='input_id' value='".$this->row["user_id"]."'>";	
						echo "</form>";
					echo "</td>";
					echo "<td>";
					echo "<form method='POST'>
							<input type='hidden' name='action' value='cmd_update_user_plus100'>
							<input type='hidden' name='input_id' value='".$this->row["user_id"]."'>
							<input type='submit' value='+100'>
						 </form>";
					echo "<form method='POST'>
							<input type='hidden' name='action' value='cmd_update_user_minus100'>
							<input type='hidden' name='input_id' value='".$this->row["user_id"]."'>
							<input type='submit' value='-100'>
						 </form>";						 
					echo $this->row["user_credit"]. "</td>";
				echo "</tr>";
			}
			echo "</table>";
		} else {
			echo "Nincs felhasználó az adatbázisban!";
		}		
	}
	
	public function user_insert($input_user_username,
							    $input_user_password,
							    $input_user_email,
							    $input_user_perm,
							    $input_user_activity){
		if($input_user_username=="") { return "<p>Sikertelen adatfelvétel, hiányzó felhasználónév!</p>"; }
		if($input_user_password=="") { return "<p>Sikertelen adatfelvétel, hiányzó jelszó!</p>"; }
		$this->sql = "INSERT INTO 
						users  
						(
							user_username ,    
							user_password ,  
							user_email ,  
							user_perm ,  
							user_activity  
						)
						VALUES
						(
						'$input_user_username',
						'$input_user_password',
						'$input_user_email',
						'$input_user_perm',
						$input_user_activity
						)
				";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres adatfelvétel!</p>";
		} else {
			return "<p>Sikertelen adatfelvétel!</p>";
		}
	}
	public function user_delete($input_user_id){
		if($input_user_id=="") { return "<p>Sikertelen törlés, hiányzó azonosító!</p>"; }
		$this->sql = "DELETE FROM users
					  WHERE user_id	= $input_user_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres törlés!</p>";
		} else {
			return "<p>Sikertelen törlés!</p>";
		}		
	}
	public function user_update_active($input_user_id){
		if($input_user_id=="") { return "<p>Sikertelen aktiválás, hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						users
					  SET
						user_activity = 1
					  WHERE 
						user_id	= $input_user_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres aktiválás!</p>";
		} else {
			return "<p>Sikertelen aktiválás!</p>";
		}		
	}
	public function user_update_inactive($input_user_id){
		if($input_user_id=="") { return "<p>Sikertelen inaktiválás, hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						users
					  SET
						user_activity = 0
					  WHERE 
						user_id	= $input_user_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres inaktiválás!</p>";
		} else {
			return "<p>Sikertelen inaktiválás!</p>";
		}		
	}
	public function user_update_perm_user($input_user_id){
		if($input_user_id=="") { return "<p>Sikertelen jog beállítás(user), hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						users
					  SET
						user_perm = 'user'
					  WHERE 
						user_id	= $input_user_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres jog beállítás(user)!</p>";
		} else {
			return "<p>Sikertelen jog beállítás(user)!</p>";
		}		
	}
	public function user_update_perm_admin($input_user_id){
		if($input_user_id=="") { return "<p>Sikertelen jog beállítás(admin), hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						users
					  SET
						user_perm = 'admin'
					  WHERE 
						user_id	= $input_user_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres jog beállítás(admin)!</p>";
		} else {
			return "<p>Sikertelen jog beállítás(admin)!</p>";
		}		
	}
	public function user_update_perm_moderator($input_user_id){
		if($input_user_id=="") { return "<p>Sikertelen jog beállítás(moderator), hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						users
					  SET
						user_perm = 'moderator'
					  WHERE 
						user_id	= $input_user_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres jog beállítás(moderator)!</p>";
		} else {
			return "<p>Sikertelen jog beállítás(moderator)!</p>";
		}		
	}
	
	public function user_update_perm_given($input_user_id, $input_user_perm)
	{
		if ($input_user_id == "") { return "<p>Sikertelen jog beállítás, hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						users 
					  SET
						user_perm = '$input_user_perm'
					  WHERE
						user_id = $input_user_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres jog beállítás!</p>";
		} else {
			return "<p>Sikertelen jog beállítás!</p>";
		}
	}
	
	public function user_update_plus100($input_user_id){
		if($input_user_id=="") { return "<p>Sikertelen credit növelés, hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						users
					  SET
						user_credit = (user_credit+100)
					  WHERE 
						user_id	= $input_user_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres credit növelés!</p>";
		} else {
			return "<p>Sikertelen credit növelés!</p>";
		}		
	}	
	public function user_update_minus100($input_user_id){
		if($input_user_id=="") { return "<p>Sikertelen credit csökkentés, hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						users
					  SET
						user_credit = (user_credit-100)
					  WHERE 
						user_id	= $input_user_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres credit csökkentés!</p>";
		} else {
			return "<p>Sikertelen credit csökkentés!</p>";
		}		
	}	
	public function user_update(){}
	

}

?>