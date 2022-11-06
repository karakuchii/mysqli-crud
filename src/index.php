<?php
	/*
	 * File shows various examples of how to use the database classes
	 *
	 */


	function heading($text){
		echo "<h2>".$text."</h2>";
	}

	function print_array($array){
		echo '<pre>'.print_r($array,true).'</pre>';
	}
	include_once("config.php"); // <-- contains database connection stores in $link

	include_once("classes/Category.php");
	include_once("classes/Content.php");

	$category = new Category($link);
	$content = new Content($link);



	// Set up a category to save, array has database column names as keys.
	$category_values = [
		"name" => "Test Category",
		"description" => "This is a test category"
	];

	//save the category to the DB
	$category_id = $category->save($category_values);

	heading("Category Created");
	// print the category.
	print_array($category->fetch_by_id($category_id));


	// Update category values
	$category_values = [
		"name" => "Test Category Updated",
		"description" => "This is a test category, and it has been updated!"
	];

	// Save u"pdated values to DB, passing the $project_id triggers the update functionality
	$rows_affected = $category->save($category_values,$category_id);
	heading("Category Updated: ". $rows_affected);

	print_array($category->fetch_by_id($category_id));

	// Set up a content item to save, array has database column names as keys. using the category id that we just created
	$content_values = [
		"name" => "Content Item",
		"body" => "This is a content item",
		"category_id" => $category_id
	];


	//save the  content item to the DB
	$content_id = $content->save($content_values);

	heading("Saved content item with id: ".$content_id);
	print_array($content->fetch_by_id($content_id));

	// let's make another content item in the same category
	// Set up a content item to save, array has database column names as keys. using the category id that we just created
	$content_values = [
		"name" => "Content Item 2",
		"body" => "This is a content item",
		"category_id" => $category_id
	];

	//save the  content item to the DB
	$content_id = $content->save($content_values);

	heading("List of content items for Category $category_id");
	// Show content items with new category
	$collection = $content->fetch_by_parent_id($category_id);
	print_array($collection);



	// let's update the body of both content items in the same category:

	heading("Updating content items for Category $category_id");
	$new_content = ["body" => "Ahhh all the same now."];
	$updated_rows = $content->update_by_parent_id($category_id,$new_content);

	heading("Updated  $updated_rows content items");

	heading("List of content items for Category $category_id");
	// Show content items with new category
	$collection = $content->fetch_by_parent_id($category_id);
	print_array($collection);

	heading("Deleting content item $content_id");
	$deleted_rows = $content->delete($content_id);

	heading("Deleted $deleted_rows content item");

	$collection = $content->fetch_by_parent_id($category_id);
	print_array($collection);