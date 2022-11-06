<?php
	include_once("Model.php");
	class Content extends Model
	{
		public function __construct(mysqli $db)
		{
			parent::__construct($db); // Call parent constructor
			// Set vars unique to this class
			$this->table_name = "content";
			$this->id_field = "id";

			// content is a child of category, and the category the content is in is tracked by the category_id column in the content table
			$this->parent_id_field = "category_id";
		}
	}