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
			echo "</tr>";
			while($this->row = $this->result->fetch_assoc()) {
				echo "<tr>";
					echo "<td>" . $this->row["hal_id"]. "</td>";
                    echo "<td>" . $this->row["hal_nev"]. "</td>";
                    //
					echo "<td>";
					echo "<form method='POST'>
							<input type='hidden' name='action' value='cmd_delete_hal'>
							<input type='hidden' name='input_id' value='".$this->row["hal_id"]."'>
							<input type='submit' value='X'>
						 </form>";	
					echo "</td>";
					echo "<td>";
					echo "<form method='POST'>
							<input type='hidden' name='action' value='hal_update_tilalom'>
							<input type='hidden' name='input_id' value='".$this->row["hal_id"]."'>
							<input type='submit' value='Tilalom'>
						 </form>";
					echo "<form method='POST'>
							<input type='hidden' name='action' value='hal_update_szabad'>
							<input type='hidden' name='input_id' value='".$this->row["hal_id"]."'>
							<input type='submit' value='Szabad'>
						 </form>";						 
						echo "[" . $this->row["hal_tilalom"]. "]";
                    echo "</td>";
                    //
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
						 echo "[" . $this->row["hal_tilalom"]. "]";
					echo "</td>";
				echo "</tr>";
			}
			echo "</table>";
		} else {
			echo "Nincs felhasználó az adatbázisban!";
		}		
	}
	
	public function hal_insert($input_hal_nev,
							    $input_hal_raktaron,
							    $input_hal_tilalom,
							    $input_hal_utolso_fogas){
		if($input_hal_nev=="") { return "<p>Sikertelen adatfelvétel, hiányzó halnév!</p>"; }
		if($input_hal_utolso_fogas=="") { return "<p>Sikertelen adatfelvétel, hiányzó utolsó fogás!</p>"; }
		$this->sql = "INSERT INTO 
						hal
						(
							hal_nev ,    
							hal_raktaron ,  
							hal_tilalom ,  
							hal_utolso_fogas
						)
						VALUES
						(
						'$input_hal_nev',
						$input_hal_raktaron,
						$input_hal_tilalom,
						'$input_hal_utolso_fogas'
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
		$this->sql = "DELETE FROM hal
					  WHERE hal_id	= $input_hal_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres törlés!</p>";
		} else {
			return "<p>Sikertelen törlés!</p>";
		}		
	}
	public function hal_update_tilalom($input_hal_id){
		if($input_hal_id=="") { return "<p>Sikertelen változtatás, hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						hal
					  SET
						hal_tilalom = 1
					  WHERE 
						hal_id	= $input_hal_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres változtatás!</p>";
		} else {
			return "<p>Sikertelen változtatás!</p>";
		}		
	}
	public function hal_update_szabad($input_hal_id){
		if($input_hal_id=="") { return "<p>Sikertelen változtatás, hiányzó azonosító!</p>"; }
		$this->sql = "UPDATE 
						hal
					  SET
                        hal_tilalom = 0
					  WHERE 
						hal_id	= $input_hal_id";
		if($this->conn->query($this->sql)){
			return "<p>Sikeres változtatás!</p>";
		} else {
			return "<p>Sikertelen változtatás!</p>";
		}		
	}
	
	public function hal_update(){}
	

}

?>