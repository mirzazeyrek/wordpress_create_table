# Wordpress Create Table 

A simple helper function for WordPress dbDelta function.

It prevents weird bugs such as;

Repetitive altering table operations due to case-insensitivity issues of dbDelta.

Repetitive re-creating index operations. 

Usage Example:
```
$table_name	= "ratings";

$table_columns = "id INT(6) UNSIGNED AUTO_INCREMENT,
 					rate tinyint(1) NOT NULL,
 					ticket_id bigint(20) NOT NULL,
 					response_id bigint(20) NOT NULL,
 					created_at TIMESTAMP";

$table_keys = "PRIMARY KEY (id),
 					KEY ratings_rate (rate),
 					UNIQUE KEY ratings_response_id (response_id)";

create_table($table_name, $table_columns, $table_keys);
```

Please feel free to share and contribute.

e-mail: mirzazeyrek (et) gmail.com
twitter: @sefendisi
