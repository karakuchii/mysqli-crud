<?php
	include_once("Model.php");
	class Category extends Model
	{
		public function __construct(mysqli $db)
		{
			parent::__construct($db); // Call parent constructor
			// Set vars unique to this class
			$this->table_name = "category";
			$this->id_field = "id";

		}
	}