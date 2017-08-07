<?php
/**
 * Contains all security sniff errors.
 *
 * @package wp-tide-test-plugin
 */

/**
 * Class WP_Query.
 */
class WP_Query {

	/**
	 * WP_Query constructor.
	 */
	public function __construct() {
		global $wpdb;

		$post_query = "SELECT ID, post_content, post_name, post_title, DATE_FORMAT(post_date, '%%Y/%%m/%%d %%H:%%i') AS post_date
                            FROM {$wpdb->posts}
                            WHERE post_status = 'publish' and post_type = %s
                            ORDER BY post_date DESC";

		$posts = $wpdb->get_results( $wpdb->prepare( $post_query, 'test' ), ARRAY_A );
		wp_cache_set( 'omniture.posts', $posts );

		$this->create_database();
	}

	/**
	 * Create database.
	 *
	 * @return bool
	 */
	public function create_database() {
		$conn = new mysqli( DB_HOST, DB_USER, DB_PASSWORD );
		$conn = new MYSQLI( DB_HOST, DB_USER, DB_PASSWORD );
		$conn = new MySqli( DB_HOST, DB_USER, DB_PASSWORD );
		$conn = new PDO( DB_HOST, DB_USER, DB_PASSWORD );
		$conn = new PDOStatement( DB_HOST, DB_USER, DB_PASSWORD );

		$link = maxdb_connect( 'localhost', 'MONA', 'RED', 'DEMODB' );

		if ( ! $link ) {
			printf( "Can't connect to localhost. Error: %s\n", maxdb_connect_error() );
			exit();
		}

		maxdb_report( MAXDB_REPORT_OFF );
		maxdb_query( $link, 'DROP TABLE mycustomer' );
		maxdb_report( MAXDB_REPORT_ERROR );

		/* Insert rows */
		maxdb_query( $link, 'CREATE TABLE mycustomer AS SELECT * from hotel.customer' );
		printf( "Affected rows (INSERT): %d\n", maxdb_affected_rows( $link ) );

		maxdb_query( $link, 'ALTER TABLE mycustomer ADD Status int default 0' );

		/* update rows */
		maxdb_query( $link, 'UPDATE mycustomer SET Status=1 WHERE cno > 50' );
		printf( "Affected rows (UPDATE): %d\n", maxdb_affected_rows( $link ) );

		/* delete rows */
		maxdb_query( $link, 'DELETE FROM mycustomer WHERE cno < 50' );
		printf( "Affected rows (DELETE): %d\n", maxdb_affected_rows( $link ) );

		/* select all rows */
		$result = maxdb_query( $link, 'SELECT title FROM mycustomer' );
		printf( "Affected rows (SELECT): %d\n", maxdb_affected_rows( $link ) );

		maxdb_free_result( $result );

		/* Delete table Language */
		maxdb_query( $link, 'DROP TABLE mycustomer' );

		/* close connection */
		maxdb_close( $link );

		// Select the database as DB_NAME.
		$database_selected = mysqli_select_db( $conn, DB_NAME );

		// If we are not able to select DB_NAME database ( if database DB_NAME does not exist ) Only then create a new database.
		if ( ! $database_selected ) {
			$sql = 'CREATE DATABASE $database_name';
			$result = $conn->query( $sql );
			if ( $result ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Connect to database.
	 *
	 * @return mysqli
	 */
	public function wp_connect_to_database() {
		$conn = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
		return $conn;
	}

	/**
	 * Escape Data.
	 *
	 * @param string $value Value.
	 * @return mixed
	 */
	public function escape_data( $value ) {
		$conn = $this->wp_connect_to_database();
		$conn->real_escape_string( $value );
		return $value;
	}

	/**
	 * Insert data.
	 *
	 * @return bool|object
	 */
	public function insert_data() {
		$conn = new mysqli( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME );
		$sql = 'INSERT INTO $table_name ( $fields ) VALUES ( $values )';

		$result = $conn->query( $sql );

		if ( $result ) {
			return true;
		} else {
			return $conn->error;
		}
	}

	/**
	 * Create table.
	 *
	 * @param string $sql SQL.
	 * @return bool
	 */
	public function create_table( $sql ) {
		$conn = $this->wp_connect_to_database();
		$result = $conn->query( $sql );
		return true;
	}
}

$test_wpdb = new WP_Query();

/**
 * Get title.
 *
 * @return bool
 */
function switch_to_blog() {
	return false;
}