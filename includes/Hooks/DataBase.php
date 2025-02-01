<?php
namespace FormBizz\Hooks;

defined('ABSPATH') || exit;

class DataBase {
	use \FormBizz\Traits\Singleton;

    private static $SUBSCRIBERS_TABLE = 'formbizz_submissions';
    private static $DATABASE_VERSION = '1.0.0';
    /**
     * Create the database table.
     *
     * @return void
     * @since 1.0.0
     */
    public static function createDB () {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        // Create the subscribers table
        $table_name = $wpdb->prefix . self::$SUBSCRIBERS_TABLE;
        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id BIGINT(20) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            message TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );

        // Save the database version
        add_option( 'formbizz_db_version', self::$DATABASE_VERSION );
    }

    /**
	 * Drop the database table.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function dropDB() {
		global $wpdb;

		$table_name = $wpdb->prefix . self::$SUBSCRIBERS_TABLE;
		
		// phpcs:disable WordPress.DB.PreparedSQL.NotPrepared
		$sql = "DROP TABLE IF EXISTS $table_name;";
		$wpdb->query($sql);
		// phpcs:enable WordPress.DB.PreparedSQL.NotPrepared

		delete_option('formbizz_db_version');
	}

    /**
     * Insert into database table.
     *
     * @return bool
     * @since 1.0.0
     */
    public static function insertDB ($table, $data) {
        global $wpdb;

        $table_name = $wpdb->prefix . $table;
        $wpdb->insert($table_name, $data);
        return $wpdb->insert_id;
    }

    /**
	 * Get data from database table.
	 *
	 * @param string       $table  Table name (without prefix).
	 * @param array|string $where  Associative array for WHERE conditions or raw SQL (use with caution).
	 * @param int          $limit  Limit for the number of records.
	 * @param bool         $count  Whether to return a count of records.
	 * @return array|int
	 * @since 1.0.0
	 */
	public static function getDB($table, $where = [], $limit = 0, $count = false) {
		global $wpdb;

		$table_name = $wpdb->prefix . $table;
		$sql = $count ? "SELECT COUNT(*) FROM $table_name" : "SELECT * FROM $table_name";
		$query_args = [];

		// Handling WHERE conditions
		if (!empty($where) && is_array($where)) {
			$where_clauses = [];
			foreach ($where as $column => $value) {
				$where_clauses[] = "$column = %s";
				$query_args[] = $value;
			}
			$sql .= ' WHERE ' . implode(' AND ', $where_clauses);
		}

		// Handling LIMIT
		if ($limit > 0) {
			$sql .= " LIMIT %d";
			$query_args[] = $limit;
		}

		// phpcs:disable WordPress.DB.PreparedSQL.NotPrepared
		// Prepare the SQL query
		$prepared_sql = $wpdb->prepare($sql, ...$query_args);

		// phpcs:disable WordPress.DB.PreparedSQL.NotPrepared
		return $count ? $wpdb->get_var($prepared_sql) : $wpdb->get_results($prepared_sql);
	}

    /**
     * Update data in database table.
     *
     * @param string $table
     * @param array $data
     * @param array $where
     * @return bool
     * @since 1.0.0
     */
    public static function updateDB ($table, $data, $where) {
        global $wpdb;

        $table_name = $wpdb->prefix . $table;
        return $wpdb->update($table_name, $data, $where);
    }

    /**
     * Delete data from database table.
     *
     * @param string $table
     * @param int|array $id
     * @param string $where
     * @return bool
     * @since 1.0.0
     */
    public static function deleteDB ($table, $id) {
        global $wpdb;

        if(!isset($id)) {
            return false;
        }

        // If id is array then delete multiple rows and if id is integer then delete single row
        $table_name = $wpdb->prefix . $table;
        if (is_array($id)) {
            $ids = implode(',', $id);
            $sql = "DELETE FROM $table_name WHERE id IN ($ids)";
        } else {
            $sql = "DELETE FROM $table_name WHERE id = $id";
        }

        return $wpdb->query($sql);   
    }
}