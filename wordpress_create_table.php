	/**
	 * Prevents unnecessary re-creating index and repetitive altering table operations when using WordPress dbDelta function
	 *
	 * Usage Example:
	 *
	 * $table_name		= "ratings";
	 *
	 * $table_columns 	= "id INT(6) UNSIGNED AUTO_INCREMENT,
	 * 					rate tinyint(1) NOT NULL,
	 * 					ticket_id bigint(20) NOT NULL,
	 * 					response_id bigint(20) NOT NULL,
	 * 					created_at TIMESTAMP";
	 *
	 * $table_keys 		= "PRIMARY KEY (id),
	 * 					KEY ratings_rate (rate),
	 * 					UNIQUE KEY ratings_response_id (response_id)";
	 *
	 * create_table($table_name, $table_columns, $table_keys);
	 *
	 * Things that need to be considered when using dbDelta function :
	 *
	 * You must put each field on its own line in your SQL statement.
	 * You must have two spaces between the words PRIMARY KEY and the definition of your primary key.
	 * You must use the key word KEY rather than its synonym INDEX and you must include at least one KEY.
	 * You must not use any apostrophes or backticks around field names.
	 * Field types must be all lowercase.
	 * SQL keywords, like CREATE TABLE and UPDATE, must be uppercase.
	 * You must specify the length of all fields that accept a length parameter. int(11), for example.
	 *
	 * Further information can be found on here:
	 *
	 * http://codex.wordpress.org/Creating_Tables_with_Plugins
	 *
	 * @param $table_name
	 * @param $table_columns
	 * @param null $table_keys
	 * @param null $charset_collate
	 * @version 1.0.1
	 * @author Ugur Mirza Zeyrek
	 */
	static function create_table($table_name, $table_columns, $table_keys = null, $db_prefix = true, $charset_collate = null) {
		global $wpdb;

		if($charset_collate == null)
			$charset_collate = $wpdb->get_charset_collate();
		$table_name = ($db_prefix) ? $wpdb->prefix.$table_name : $table_name;
		$table_columns = strtolower($table_columns);

		if($table_keys)
			$table_keys =  ", $table_keys";

		$table_structure = "( $table_columns $table_keys )";

		$search_array = array();
		$replace_array = array();

		$search_array[] = "`";
		$replace_array[] = "";

		$table_structure = str_replace($search_array,$replace_array,$table_structure);

		$sql = "CREATE TABLE $table_name $table_structure $charset_collate;";

		// Rather than executing an SQL query directly, we'll use the dbDelta function in wp-admin/includes/upgrade.php (we'll have to load this file, as it is not loaded by default)
		require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

		// The dbDelta function examines the current table structure, compares it to the desired table structure, and either adds or modifies the table as necessary
		return dbDelta($sql);
	}
