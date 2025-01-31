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
        add_option( 'pbb_db_version', self::$DATABASE_VERSION );
    }

    /**
     * Drop the database table.
     *
     * @return void
     * @since 1.0.0
     */
    public static function dropDB () {
        global $wpdb;

        $table_name = $wpdb->prefix . self::$SUBSCRIBERS_TABLE;
        $sql = "DROP TABLE IF EXISTS $table_name;";
        $wpdb->query($sql);

        delete_option( 'pbb_db_version' );
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
     * @return array
     * @since 1.0.0
     */
    public static function getDB ($table, $where = '', $limit = 0, $count = false) {
        global $wpdb;

        $table_name = $wpdb->prefix . $table;
        $sql = "SELECT * FROM $table_name";

        if ($count) {
            $sql = "SELECT COUNT(*) FROM $table_name";
        }
        if ($where) {
            $sql .= " WHERE $where";
        }
        if ($limit) {
            $sql .= " LIMIT $limit";
        }

        return $wpdb->get_results($sql);
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