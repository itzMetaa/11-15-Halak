<?php
class adatbazis{
	public $servername = "localhost:3307";
	public $halname = "root";
	public $password = "";
	public $dbname = "halak";
	public $sql = NULL;
	public $result = NULL;
	public $row = NULL;
	
	public function __construct(){ self::kapcsolodas(); }
	public function __destruct(){ self::kapcsolatbontas(); }
	
	public function kapcsolodas(){
		$this->conn = new mysqli($this->servername, 
						   $this->halname, 
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
    
	public function hal_select(){
		$this->sql = "SELECT  
					hal_id ,  
					hal_nev ,    
					hal_raktaron ,  
					hal_tilalom ,  
					hal_utolso_fogas
				FROM  
					hal ";
		$this->result = $this->conn->query($this->sql);

		if ($this->result->num_rows > 0) {
			echo "<table>";
			echo "<tr>";
				echo "<td>ID</td>";
				echo "<td>Nev</td>";
				echo "<td>Del</td>";
				echo "<td>Tilalom</td>";
				echo "<td>Update</td>";
				echo "<td>JOG2</td>";
				echo "<td>$</td>";
			echo "</tr>";
			while($this->row = $this->result->fetch_assoc()) {
				echo "<tr>";
					echo "<td>" . $this->row["hal_id"]. "</td>";
					echo "<td>" . $this->row["hal_email"]. "</td>";
					echo "<td>";
					echo "<form method='POST'>
							<input type='hidden' name='action' value='cmd_delete_hal'>
							<input type='hidden' name='input_id' value='".$this->row["hal_id"]."'>
							<input type='submit' value='X'>
						 </form>";	
					echo "</td>";
					echo "<td>";
					echo "<form method='POST'>
							<input type='hidden' name='action' value='cmd_update_active'>
							<input type='hidden' name='input_id' value='".$this->row["hal_id"]."'>
							<input type='submit' value='ACT'>
						 </form>";
					echo "<form method='POST'>
							<input type='hidden' name='action' value='cmd_update_inactive'>
							<input type='hidden' name='input_id' value='".$this->row["hal_id"]."'>
							<input type='submit' value='INACT'>
						 </form>";						 
						echo "[" . $this->row["hal_activity"]. "]";
					echo "</td>";
					echo "<td>";
					echo "<form method='POST'>
							<input type='hidden' name='action' value='cmd_update_perm_hal'>
							<input type='hidden' name='input_id' value='".$this->row["hal_id"]."'>
							<input type='submit' value='hal'>
						 </form>";
					echo "<form method='POST'>
							<input type='hidden' name='action' value='cmd_update_perm_admin'>
							<input type='hidden' name='input_id' value='".$this->row["hal_id"]."'>
							<input type='submit' value='ADMIN'>
						 </form>";
						 echo "<form method='POST'>
							<input type='hidden' name='action' value='cmd_update_perm_moderator'>
							<input type='hidden' name='input_id' value='".$this->row["hal_id"]."'>
							<input type='submit' value='MODERATOR'>
						 </form>";						 
						 echo "[" . $this->row["hal_perm"]. "]";
					echo "</td>";
					echo "<td>";
						echo "<form method='POST'>";
							echo "<select name='input_hal_perm'
										  onchange='this.form.submit();'>";
								echo "<option value='hal' ".(($this->row["hal_perm"]=="hal")?" selected ":" ").">hal</option>";
								echo "<option value='admin' ".(($this->row["hal_perm"]=="admin")?" selected ":" ").">admin</option>";
								echo "<option value='moderator' ".(($this->row["hal_perm"]=="moderator")?" selected ":" ").">moderator</option>";
							echo "</select>";
							echo "<input type='hidden' name='action' value='cmd_update_perm_given'>";
							echo "<input type='hidden' name='input_id' value='".$this->row["hal_id"]."'>";	
						echo "</form>";
					echo "</td>";
					echo "<td>";
					echo "<form method='POST'>
							<input type='hidden' name='action' value='cmd_update_hal_plus100'>
							<input type='hidden' name='input_id' value='".$this->row["hal_id"]."'>
							<input type='submit' value='+100'>
						 </form>";
					echo "<form method='POST'>
							<input type='hidden' name='action' value='cmd_update_hal_minus100'>
							<input type='hidden' name='input_id' value='".$this->row["hal_id"]."'>
							<input type='submit' value='-100'>
						 </form>";						 
					echo $this->row["hal_credit"]. "</td>";
				echo "</tr>";
			}
			echo "</table>";
		} else {
			echo "Nincs felhasználó az adatbázisban!";
		}		
	}
	
	public function hal_insert($input_hal_halname,
							    $input_hal_password,
							    $input_hal_email,
							    $input_hal_perm,
							    $input_hal_activity){
		if($input_hal_halname=="") { return "<p>Sikertelen adatfelvétel, hiányzó felhasználónév!</p>"; }
		if($input_hal_password=="") { return "<p>Sikertelen adatfelvétel, hiányzó jelszó!</p>"; }
		$this->sql = "INSERT INTO 
						hals  
						(
							hal_halname ,    
							hal_password ,  
							hal_email ,  
							hal_perm ,  
							hal_activity  
						)
						VALUES
						(
						'$input_hal_halname',
						'$input_hal_password',
						'$input_hal_email',
						'$input_hal_perm',
						$input_hal_activity
						)
				";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres adatfelvétel!</p>";
		} else {
			return "<p>Sikertelen adatfelvétel!</p>";
		}
	}
	public function hal_delete($input_hal_id){
		if($input_hal_id=="") { return "<p>Sikertelen törlés, hiányzó azonosító!</p>"; }
		$this->sql = "DELETE FROM hals
					  WHERE hal_id	= $input_hal_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres törlés!</p>";
		} else {
			return "<p>Sikertelen törlés!</p>";
		}		
	}
	public function hal_update_active($input_hal_id){
		if($input_hal_id=="") { return "<p>Sikertelen aktiválás, hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						hals
					  SET
						hal_activity = 1
					  WHERE 
						hal_id	= $input_hal_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres aktiválás!</p>";
		} else {
			return "<p>Sikertelen aktiválás!</p>";
		}		
	}
	public function hal_update_inactive($input_hal_id){
		if($input_hal_id=="") { return "<p>Sikertelen inaktiválás, hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						hals
					  SET
						hal_activity = 0
					  WHERE 
						hal_id	= $input_hal_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres inaktiválás!</p>";
		} else {
			return "<p>Sikertelen inaktiválás!</p>";
		}		
	}
	public function hal_update_perm_hal($input_hal_id){
		if($input_hal_id=="") { return "<p>Sikertelen jog beállítás(hal), hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						hals
					  SET
						hal_perm = 'hal'
					  WHERE 
						hal_id	= $input_hal_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres jog beállítás(hal)!</p>";
		} else {
			return "<p>Sikertelen jog beállítás(hal)!</p>";
		}		
	}
	public function hal_update_perm_admin($input_hal_id){
		if($input_hal_id=="") { return "<p>Sikertelen jog beállítás(admin), hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						hals
					  SET
						hal_perm = 'admin'
					  WHERE 
						hal_id	= $input_hal_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres jog beállítás(admin)!</p>";
		} else {
			return "<p>Sikertelen jog beállítás(admin)!</p>";
		}		
	}
	public function hal_update_perm_moderator($input_hal_id){
		if($input_hal_id=="") { return "<p>Sikertelen jog beállítás(moderator), hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						hals
					  SET
						hal_perm = 'moderator'
					  WHERE 
						hal_id	= $input_hal_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres jog beállítás(moderator)!</p>";
		} else {
			return "<p>Sikertelen jog beállítás(moderator)!</p>";
		}		
	}
	
	public function hal_update_perm_given($input_hal_id, $input_hal_perm)
	{
		if ($input_hal_id == "") { return "<p>Sikertelen jog beállítás, hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						hals 
					  SET
						hal_perm = '$input_hal_perm'
					  WHERE
						hal_id = $input_hal_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres jog beállítás!</p>";
		} else {
			return "<p>Sikertelen jog beállítás!</p>";
		}
	}
	
	public function hal_update_plus100($input_hal_id){
		if($input_hal_id=="") { return "<p>Sikertelen credit növelés, hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						hals
					  SET
						hal_credit = (hal_credit+100)
					  WHERE 
						hal_id	= $input_hal_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres credit növelés!</p>";
		} else {
			return "<p>Sikertelen credit növelés!</p>";
		}		
	}	
	public function hal_update_minus100($input_hal_id){
		if($input_hal_id=="") { return "<p>Sikertelen credit csökkentés, hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						hals
					  SET
						hal_credit = (hal_credit-100)
					  WHERE 
						hal_id	= $input_hal_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres credit csökkentés!</p>";
		} else {
			return "<p>Sikertelen credit csökkentés!</p>";
		}		
	}	
	public function hal_update(){}
	

}

?>