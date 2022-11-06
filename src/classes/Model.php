<?php

	abstract class Model
	{
		protected mysqli $db; // Link to the DB
		protected string $table_name; // name of the table in DB
		protected string $id_field; // primary key for the table
		protected string $parent_id_field; // column name of the parents ID

		public function __construct(mysqli $db_link)
		{
			$this->db = $db_link;
			$this->table_name = "";
			$this->id_field = "";
			$this->parent_id_field = null;
		}

		// Will insert or update depending on if an ID is passed or not
		function save(array $values, int $id=null){
			if(is_null($id)){
				return $this->insert($values);
			}else{
				return $this->update($id,$values);
			}
		}

		// get all records in the table
		public function fetch(){
			$query = "SELECT * 
					FROM {$this->table_name}";

			$stmt = $this->db->prepare($query);

			$stmt->execute();
			$result = $stmt->get_result(); // get the mysqli result
			$data =  $result->fetch_all(MYSQLI_ASSOC);
			$result->free_result();

			if($stmt->rowCount() > 0){
				$return_value = $data;
			}else{
				$return_value = [];
			}
			$result->free_result();

			return $return_value;
		}

		//get record by primary key
		public function fetch_by_id(int $id){
			$query = "SELECT * 
					FROM {$this->table_name}
					WHERE {$this->id_field} = ?";

			$stmt = $this->db->prepare($query);
			$stmt->bind_param('s',$id);
			$stmt->execute();
			$result = $stmt->get_result(); // get the mysqli result
			$data =  $result->fetch_all(MYSQLI_ASSOC);

			if($result->num_rows > 0){
				$return_value = $data[0];
			}else{
				$return_value = [];
			}
			$result->free_result();

			return $return_value;
		}

		// get all records that share the same parent id
		public function fetch_by_parent_id(int $id){
			if(!is_null($this->parent_id_field)){ // check that this type has a parent field

				$query = "SELECT * 
						FROM {$this->table_name}
						WHERE {$this->parent_id_field} = ?";

				$stmt = $this->db->prepare($query);
				$stmt->bind_param('s',$id);
				$stmt->execute();
				$result = $stmt->get_result(); // get the mysqli result
				$data =  $result->fetch_all(MYSQLI_ASSOC);

				if($result->num_rows > 0){
					$return_value = $data;
				}else{
					$return_value = [];
				}
				$result->free_result();

				return $return_value;
			}else{
				return [];
			}
		}

		// Insert values into the table, $values must be an array that has keys that match database column names
		protected function insert(array $values){

			// FUN FACT: Insert statements can use the SET syntax just like the Update syntax (this is only applicable when using MySQL or MariaDB)
			$query = "INSERT INTO {$this->table_name} SET ";

			$mysqli_bind = ""; //contains all the s required
			foreach ($values as $key => $value){
				$query.= "{$key} = ?,";
				$mysqli_bind .="s";
			}

			$query = rtrim($query,","); // remove the comma from last value to avoid SQL snytax error

			$stmt = $this->db->prepare($query);
			// ... unpacks an array and passes it to function as arguments. array_values returns an array of values without keys.
			$stmt->bind_param($mysqli_bind,...array_values($values));

			if($stmt->execute()){
				return $stmt->insert_id;

			}else{
				return false;
			}
		}

		// Update values in the table that have the id passed, $values must be an array that has keys that match database column names
		protected function update($id,$values, $use_parent_id= false){

			$query = "UPDATE  {$this->table_name}
					 SET ";

			$mysqli_bind = "";
			foreach ($values as $key => $value){
				$query.= "{$key} = ?,";
				$mysqli_bind .="s";
			}

			$query = rtrim($query,","); // remove the comma from last value to avoid SQL snytax error

			if($use_parent_id){
				// Where clause so the update statement only applies to records that match the parent id passed
				$query.= " WHERE {$this->parent_id_field} = ?";
			}else{
				// Where clause so the update statement only applies to record that match the id passed
				$query.= " WHERE {$this->id_field} = ?";
			}

			$mysqli_bind.="s";

			// we put the id in the values array so, it can be passed using ... unpack in the bind_param statement
			$values["id"] = $id;

			$stmt = $this->db->prepare($query);
			// ... unpacks an array and passes it to function as arguments. array_values returns an array of values without keys.
			$stmt->bind_param($mysqli_bind,...array_values($values));

			if($stmt->execute()){
				return $this->db->affected_rows;
			}else{
				return false;
			}

		}

		// Update all records that have parent id
		public function update_by_parent_id(int $parent_id, array $values){
			return $this->update($parent_id,$values, true);
		}

		public function delete(int $id){

			$query = "DELETE FROM  {$this->table_name}
                     WHERE {$this->id_field} = ?";

			$stmt = $this->db->prepare($query);
			$stmt->bind_param('s',$id);
			if($stmt->execute()){
				return $this->db->affected_rows;
			}else{
				return false;
			}

		}

		// Delete all records that have a parent id
		public function delete_by_parent_id(int $parent_id){
			if(!is_null($this->parent_id_field)) { // check that this type has a parent field
				$query = "DELETE FROM  {$this->table_name}
						 WHERE {$this->parent_id_field} = ?";

				$stmt = $this->db->prepare($query);
				$stmt->bind_param('s',$parent_id);

				if ($stmt->execute()) {
					return $this->db->affected_rows;
				} else {
					return false;
				}
			}else{
				return false;
			}
		}

	}