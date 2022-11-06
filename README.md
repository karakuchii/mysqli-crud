# Simple MySqli CRUD Database Class

This is a PHP 7+ project that contains a few classes to demonstrate a simple mysqli class that can perform CRUD opperations with relative ease. The classes have basic parent/child relationship support.

Most of the code is in classes/Model.php. I have added comments throughout the code to try and explain whats going on.

index.php has a lot of example code in it to try show how you might use the code in a project.

**Example Notes**

The concept of the data model used for this example is basic parent child relationship. Categories & Content

A Category can have many Content items and a Content item must belong to one category.

Both Category & Content extend the Model class.


## Installation
Put the contents of the src folder in a folder in web root directory of your server.

You will need to change the credentials in config.php to match your database.

Then, you will need to first set up the tables in your database using the table.sql file in the SQL folder or by using the SQL code below:
```sql
-- Category table
DROP TABLE IF EXISTS category;
CREATE TABLE category (
                          id int(11) NOT NULL,
                          name varchar(255) NOT NULL,
                          description text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE category
    ADD PRIMARY KEY (id);

ALTER TABLE category
    MODIFY id int(11) NOT NULL AUTO_INCREMENT;


-- ****************************************
-- Content table
DROP TABLE IF EXISTS content;
CREATE TABLE content (
                         id int(11) NOT NULL,
                         name varchar(255) NOT NULL,
                         body text NOT NULL,
                         category_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE content
    ADD PRIMARY KEY (id);

ALTER TABLE content
    MODIFY id int(11) NOT NULL AUTO_INCREMENT;

```



## Usage
After setting up the tables and modifying the config.php file you can test it by navigating to the index.php file of the project.

It will create a category and add a couple of content items and then update them and delete one of them. All this should be output to the screen. you can run index.php as many times as you like it will just keep adding data to the tables.

## License
[MIT](https://choosealicense.com/licenses/mit/)