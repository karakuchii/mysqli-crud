<?php
	/* NON ESSENTIAL
	 * You can use this file to generate arrays of sample data
	 * use it for experimenting if you like. this is best used on a
	 * fresh set of tables as the category ID is being generated on
	 * the number of categories made in this file.
	 */

	/*
	 * Category table
	 * fields:
	  	id (Auto incrementing)
		name
		description	 
	 */

	$category_data=[];
	for($i=1; $i<=5; $i++){
		$category_data[] =[
			"name" => "Category {$i}",
			"description" => "This is a category"
		];
	}
	
	/*
	 * Content table
	 * fields:
	 	id (Auto incrementing)
		name
		body
		category_id
	 */
	$category_data=[];
	for($i=1; $i<=100; $i++){
		$category_data[] = [
			"name" => "Content {$i}",
			"body" => "This is a content item",
			"category_id" => rand(1,count($category_data))
		];
	}
