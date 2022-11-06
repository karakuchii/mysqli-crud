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
