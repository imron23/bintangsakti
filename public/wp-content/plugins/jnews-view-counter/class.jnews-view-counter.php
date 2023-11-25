<?php
/**
 * @author : Jegtheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

JNews_View_Counter::getInstance();

/**
 * Class Theme JNews Option
 */
class JNews_View_Counter {

	/**
	 * @var JNews_View_Counter
	 */
	private static $instance;

	/**
	 * @var integer
	 */
	private $post_id;

	/**
	 * @return JNews_View_Counter
	 */
	public static function getInstance() {
		if ( null === static::$instance ) {
			static::$instance = new static();
		}
		return static::$instance;
	}

	/**
	 * JNews_View_Counter constructor.
	 */
	private function __construct() {
		add_action( 'template_redirect', array( $this, 'set_post_id' ) );
		add_action( 'wpmu_new_blog', array( $this, 'new_site_activation' ) );
		add_action( 'admin_init', array( $this, 'delete_post_init' ) );
		add_action( 'init', array( $this, 'upgrade_check' ) );

		// jnews view ajax
		add_action( 'jnews_ajax_views_handler', array( $this, 'jnews_views_ajax' ) );

		// Remove post/page prefetching!
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head' );

		add_action( 'wp_head', array( $this, 'first_load_action' ) );
		add_action( 'jnews_do_first_load_action', array( $this, 'view_counter' ), null, 2 );

		// add column views
		add_filter( 'manage_posts_columns', array( $this, 'jnews_views_column' ) );
		add_action( 'manage_posts_custom_column', array( $this, 'jnews_views_column_counter' ), 10, 2 );
	}

	public function view_counter( $response, $action ) {
		if ( in_array( 'view_counter', $action ) ) {
			$response['view_counter'] = $this->jnews_views_ajax();
		}

		return $response;
	}

	public function upgrade_check() {
		$this->upgrade_site();
	}

	private function upgrade_site() {
		// Get version
		$jnews_view_counter_ver = get_option( 'jnews_view_counter_ver' );
		$upgrade                = false;

		if ( ! $jnews_view_counter_ver ) {
			add_option( 'jnews_view_counter_ver', JNEWS_VIEW_COUNTER_VERSION );
			$upgrade = true;
		} elseif ( version_compare( $jnews_view_counter_ver, JNEWS_VIEW_COUNTER_VERSION, '<' ) ) {
			$upgrade = true;
		}

		if ( $upgrade ) {
			$this->upgrade();
		}
	}

	/**
	 * On plugin upgrade, performs a number of actions: update database tables structures (if needed),
	 * run the setup wizard (if needed), and some other checks.
	 *
	 * @global  object  $wpdb
	 */
	private function upgrade() {
		$now = $this->now();

		// Keep the upgrade process from running too many times
		if ( $jnews_view_counter_update = get_option( 'jnews_view_counter_update' ) ) {
			$from_time             = strtotime( $jnews_view_counter_update );
			$to_time               = strtotime( $now );
			$difference_in_minutes = round( abs( $to_time - $from_time ) / 60, 2 );

			// Upgrade flag is still valid, abort
			if ( $difference_in_minutes <= 15 ) {
				return;
			}
			// Upgrade flag expired, delete it and continue
			delete_option( 'jnews_view_counter_update' );
		}

		global $wpdb;

		// Upgrade flag
		add_option( 'jnews_view_counter_update', $now );

		// Set table name
		$prefix = $wpdb->prefix . 'popularposts';

		// Update data table structure and indexes
		$data_fields = $wpdb->get_results( "SHOW FIELDS FROM {$prefix}data;" );

		foreach ( $data_fields as $column ) {
			if ( 'day' === $column->Field ) {
				$wpdb->query( "ALTER TABLE {$prefix}data ALTER COLUMN day DROP DEFAULT;" );
			}

			if ( 'last_viewed' === $column->Field ) {
				$wpdb->query( "ALTER TABLE {$prefix}data ALTER COLUMN last_viewed DROP DEFAULT;" );
			}
		}

		// Update summary table structure and indexes
		$summary_fields = $wpdb->get_results( "SHOW FIELDS FROM {$prefix}summary;" );

		foreach ( $summary_fields as $column ) {
			if ( 'last_viewed' === $column->Field ) {
				$wpdb->query( "ALTER TABLE {$prefix}summary CHANGE last_viewed view_datetime datetime NOT NULL, ADD KEY view_datetime (view_datetime);" );
			}

			if ( 'view_date' === $column->Field ) {
				$wpdb->query( "ALTER TABLE {$prefix}summary ALTER COLUMN view_date DROP DEFAULT;" );
			}

			if ( 'view_datetime' === $column->Field ) {
				$wpdb->query( "ALTER TABLE {$prefix}summary ALTER COLUMN view_datetime DROP DEFAULT;" );
			}
		}

		$summary_indexes = $wpdb->get_results( "SHOW INDEX FROM {$prefix}summary;" );

		foreach ( $summary_indexes as $index ) {
			if ( 'ID_date' === $index->Key_name ) {
				$wpdb->query( "ALTER TABLE {$prefix}summary DROP INDEX ID_date;" );
			}

			if ( 'last_viewed' === $index->Key_name ) {
				$wpdb->query( "ALTER TABLE {$prefix}summary DROP INDEX last_viewed;" );
			}
		}

		// Validate the structure of the tables, create missing tables / fields if necessary
		$this->plugin_activation();

		// Check storage engine
		$storage_engine_data = $wpdb->get_var( "SELECT `ENGINE` FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA`='{$wpdb->dbname}' AND `TABLE_NAME`='{$prefix}data';" );

		if ( 'InnoDB' !== $storage_engine_data ) {
			$wpdb->query( "ALTER TABLE {$prefix}data ENGINE=InnoDB;" );
		}

		$storage_engine_summary = $wpdb->get_var( "SELECT `ENGINE` FROM `information_schema`.`TABLES` WHERE `TABLE_SCHEMA`='{$wpdb->dbname}' AND `TABLE_NAME`='{$prefix}summary';" );

		if ( 'InnoDB' !== $storage_engine_summary ) {
			$wpdb->query( "ALTER TABLE {$prefix}summary ENGINE=InnoDB;" );
		}

		// Update version
		update_option( 'jnews_view_counter_ver', JNEWS_VIEW_COUNTER_VERSION );
		// Remove upgrade flag
		delete_option( 'jnews_view_counter_update' );
	}

	/**
	 * Data Table
	 *
	 * @return string
	 */
	public function get_data_table() {
		global $wpdb;

		return $wpdb->prefix . JNEWS_VIEW_COUNTER_DB_DATA;
	}

	/**
	 * Summary Table
	 *
	 * @return string
	 */
	public function get_summary_table() {
		global $wpdb;

		return $wpdb->prefix . JNEWS_VIEW_COUNTER_DB_SUMMARY;
	}

	public function new_site_activation( $blog_id ) {

		if ( 1 !== did_action( 'wpmu_new_blog' ) ) {
			return;
		}

		// run activation for the new blog
		switch_to_blog( $blog_id );

		// check required table
		$this->plugin_activation();

		// switch back to current blog
		restore_current_blog();

	}

	/**
	 * Execute when Plugin Activated
	 */
	public function plugin_activation() {
		global $wpdb;

		$show_table = "SHOW TABLES LIKE '{$this->get_data_table()}'";

		if ( $this->get_data_table() != $wpdb->get_var( $show_table ) ) {
			$this->create_table();
		}
	}

	/**
	 * Create Required Table
	 */
	public function create_table() {
		global $wpdb;
		$charset_collate = '';

		if ( ! empty( $wpdb->charset ) ) {
			$charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset} ";
		}

		if ( ! empty( $wpdb->collate ) ) {
			$charset_collate .= "COLLATE {$wpdb->collate}";
		}

		$sql = '
        CREATE TABLE ' . $this->get_data_table() . " (
            postid bigint(20) NOT NULL,
            day datetime NOT NULL,
            last_viewed datetime NOT NULL,
            pageviews bigint(20) DEFAULT 1,
            PRIMARY KEY (postid)
        ) {$charset_collate} ENGINE=InnoDB;
        CREATE TABLE " . $this->get_summary_table() . " (
            ID bigint(20) NOT NULL AUTO_INCREMENT,
            postid bigint(20) NOT NULL,
            pageviews bigint(20) NOT NULL DEFAULT 1,
            view_date date NOT NULL,
            view_datetime datetime NOT NULL,
            PRIMARY KEY (ID),
            KEY postid (postid),
            KEY view_date (view_date),
            KEY view_datetime (view_datetime)
        ) {$charset_collate} ENGINE=InnoDB;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}

	public function delete_post_init() {
		if ( current_user_can( 'delete_posts' ) ) {
			add_action( 'delete_post', array( $this, 'delete_post_action' ), 10 );
		}
	}

	public function delete_post_action( $post_id ) {
		global $wpdb;

		if ( $wpdb->get_var( $wpdb->prepare( 'SELECT postid FROM ' . $this->get_data_table() . ' WHERE postid = %d', $post_id ) ) ) {
			$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $this->get_data_table() . ' WHERE postid = %d', $post_id ) );

			$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $this->get_summary_table() . ' WHERE postid = %d', $post_id ) );
		}

		return true;
	}


	/**
	 * Set Post ID
	 */
	public function set_post_id() {
		$trackable             = array();
		$registered_post_types = get_post_types( array( 'public' => true ), 'names' );

		foreach ( $registered_post_types as $post_type ) {
			$trackable[] = $post_type;
		}

		$trackable = apply_filters( 'jnews_trackable_post_types', $trackable );

		if ( is_singular( $trackable ) && ! is_front_page() && ! is_preview() && ! is_trackback() && ! is_feed() && ! is_robots() ) {
			global $post;
			$this->post_id = ( is_object( $post ) ) ? $post->ID : 0;
		} else {
			$this->post_id = 0;
		}
	}

	/**
	 * Print Ajax Header
	 */
	public function first_load_action() {
		if ( 0 != $this->post_id && get_post_type( $this->post_id ) === 'post' ) {
			do_action( 'jnews_push_first_load_action', 'view_counter' );
		}
	}

	/**
	 * Ajax View
	 */
	public function jnews_views_ajax() {
		if ( isset( $_POST['jnews_id'] ) && $this->is_numeric( $_POST['jnews_id'] ) ) {
			$post_ID = (int) sanitize_text_field( $_POST['jnews_id'] );

			$exec_time = 0;

			$start  = $this->microtime_float();
			$result = $this->update_views( $post_ID );
			$end    = $this->microtime_float();

			$exec_time += round( $end - $start, 6 );

			if ( $result ) {
				return ( 'JNews View Counter: OK. Execution time: ' . $exec_time . ' seconds' );
			}
		}
		return ( 'JNews View Counter: Oops, could not update the views count!' );
	}

	private function update_views( $id ) {
		global $wpdb;
		$wpdb->show_errors();

		// WPML support, get original post/page ID
		if ( defined( 'ICL_LANGUAGE_CODE' ) && function_exists( 'icl_object_id' ) ) {
			global $sitepress;
			if ( isset( $sitepress ) ) { // avoids a fatal error with Polylang
				$id = icl_object_id( $id, get_post_type( $id ), true, $sitepress->get_default_language() );
			} elseif ( function_exists( 'pll_default_language' ) ) { // adds Polylang support
				$id = icl_object_id( $id, get_post_type( $id ), true, pll_default_language() );
			}
		}

		$now     = $this->now();
		$curdate = $this->curdate();
		$views   = 1;

		// before updating views count
		if ( has_action( 'jnews_pre_update_views' ) ) {
			do_action( 'jnews_pre_update_views', $id, $views );
		}

		// Update all-time table
		$result1 = $wpdb->query(
			$wpdb->prepare(
				'INSERT INTO ' . $this->get_data_table() . "
            (postid, day, last_viewed, pageviews) VALUES (%d, %s, %s, %d)
            ON DUPLICATE KEY UPDATE pageviews = pageviews + %d, last_viewed = '%s';",
				$id,
				$now,
				$now,
				$views,
				$views,
				$now
			)
		);

		// Update range (summary) table
		$result2 = $wpdb->query(
			$wpdb->prepare(
				'INSERT INTO ' . $this->get_summary_table() . "
            (postid, pageviews, view_date, view_datetime) VALUES (%d, %d, %s, %s)
            ON DUPLICATE KEY UPDATE pageviews = pageviews + %d, view_datetime = '%s';",
				$id,
				$views,
				$curdate,
				$now,
				$views,
				$now
			)
		);

		if ( ! $result1 || ! $result2 ) {
			return false;
		}

		// after updating views count
		if ( has_action( 'jnews_post_update_views' ) ) {
			do_action( 'jnews_post_update_views', $id );
		}

		return true;
	}

	/**
	 * @return float
	 */
	private function microtime_float() {
		list( $msec, $sec ) = explode( ' ', microtime() );

		$microtime = (float) $msec + (float) $sec;
		return $microtime;
	}

	/**
	 * Checks for valid number
	 *
	 * @param   int number
	 * @return  bool
	 */
	private function is_numeric( $number ) {
		return ! empty( $number ) && is_numeric( $number ) && ( intval( $number ) == floatval( $number ) );
	}

	/**
	 * Returns server datetime
	 *
	 * @return  string
	 */
	private function curdate() {
		return gmdate( 'Y-m-d', ( time() + ( get_site_option( 'gmt_offset' ) * 3600 ) ) );
	}

	/**
	 * Returns mysql datetime
	 *
	 * @return  string
	 */
	private function now() {
		return current_time( 'mysql' );
	}


	/**
	 * Template tag - gets views count.
	 *
	 * @global  object  wpdb
	 * @param   int     id
	 * @param   string  range
	 * @param   bool    number_format
	 * @return  string
	 */
	public function get_views( $id = null, $range = null, $number_format = true ) {
		// have we got an id?
		if ( empty( $id ) || is_null( $id ) || ! is_numeric( $id ) ) {
			return '-1';
		} else {
			global $wpdb;

			if ( ! $range || 'all' == $range ) {
				$query = 'SELECT pageviews FROM ' . $this->get_data_table() . " WHERE postid = '{$id}'";
			} else {
				$interval = '';

				switch ( $range ) {
					case 'yesterday':
						$interval = '1 DAY';
						break;

					case 'daily':
						$interval = '1 DAY';
						break;

					case 'weekly':
						$interval = '1 WEEK';
						break;

					case 'monthly':
						$interval = '1 MONTH';
						break;

					default:
						$interval = '1 DAY';
						break;
				}

				$now = current_time( 'mysql' );

				$query = 'SELECT SUM(pageviews) FROM ' . $this->get_summary_table() . " WHERE postid = '{$id}' AND view_datetime > DATE_SUB('{$now}', INTERVAL {$interval}) LIMIT 1;";
			}

			$result = $wpdb->get_var( $query );

			if ( ! $result ) {
				return '0';
			}

			$number_format = apply_filters( 'jnews_view_counter_number_format', $number_format );

			return ( $number_format ) ? number_format_i18n( intval( $result ) ) : $result;
		}
	}


	/**
	 * Custom Query JNews. Add ability to receive Paging Parameter and Tag Parameter
	 *
	 * @param $instance
	 * @return array
	 */
	public function query( $instance ) {
		global $wpdb;
		$default = array(
			'limit'            => 10,
			'offset'           => 0,
			'paged'            => 1,
			'range'            => 'all',
			'freshness'        => false,
			'order_by'         => 'views',
			'post_type'        => 'post',
			'include_post'     => '',
			'exclude_post'     => '',
			'include_category' => '',
			'exclude_category' => '',
			'include_tag'      => '',
			'exclude_tag'      => '',
			'author'           => '',
			'post_format'      => '',
		);

		// parse instance values
		$instance = $this->merge_array_r(
			$default,
			$instance
		);

		$prefix  = $wpdb->prefix . 'popularposts';
		$fields  = "p.ID AS 'id', p.post_title AS 'title', p.post_date AS 'date', p.post_author AS 'uid'";
		$where   = 'WHERE 1 = 1';
		$orderby = '';
		$groupby = '';

		$limit = 'LIMIT ' . (int) $instance['offset'] . ", {$instance['limit']}";

		$now = $this->now();

		// post filters
		if ( $instance['freshness'] ) {
			switch ( $instance['range'] ) {
				case 'daily':
					$where .= " AND p.post_date > DATE_SUB('{$now}', INTERVAL 1 DAY) ";
					break;

				case 'weekly':
					$where .= " AND p.post_date > DATE_SUB('{$now}', INTERVAL 1 WEEK) ";
					break;

				case 'monthly':
					$where .= " AND p.post_date > DATE_SUB('{$now}', INTERVAL 1 MONTH) ";
					break;

				default:
					$where .= '';
					break;
			}
		}

		// * post type
		$where .= " AND p.post_type = '{$instance['post_type']}'";

		// * post include & exclude
		if ( ! empty( $instance['include_post'] ) ) {
			$where .= " AND p.ID IN ({$instance['include_post']})";
		}

		if ( ! empty( $instance['exclude_post'] ) ) {
			$where .= " AND p.ID NOT IN({$instance['exclude_post']})";
		}

		// * categories
		if ( $instance['include_category'] !== '' || $instance['exclude_category'] !== '' ) {
			if ( $instance['include_category'] !== '' && $instance['exclude_category'] == '' ) {
				$where .= " AND p.ID IN (
                    SELECT object_id
                    FROM {$wpdb->term_relationships} AS r
                         JOIN {$wpdb->term_taxonomy} AS x ON x.term_taxonomy_id = r.term_taxonomy_id
                    WHERE x.taxonomy = 'category' AND x.term_id IN({$instance['include_category']})
                    )";
			} elseif ( $instance['include_category'] === '' && $instance['exclude_category'] !== '' ) {
				$where .= " AND p.ID NOT IN (
                    SELECT object_id
                    FROM {$wpdb->term_relationships} AS r
                         JOIN {$wpdb->term_taxonomy} AS x ON x.term_taxonomy_id = r.term_taxonomy_id
                    WHERE x.taxonomy = 'category' AND x.term_id IN({$instance['exclude_category']})
                    )";
			} else { // mixed
				$where .= " AND p.ID IN (
                    SELECT object_id
                    FROM {$wpdb->term_relationships} AS r
                         JOIN {$wpdb->term_taxonomy} AS x ON x.term_taxonomy_id = r.term_taxonomy_id
                    WHERE x.taxonomy = 'category' AND x.term_id IN({$instance['include_category']}) AND x.term_id NOT IN({$instance['exclude_category']})
                    ) ";
			}
		}

		// * tag
		if ( $instance['include_tag'] !== '' || $instance['exclude_tag'] !== '' ) {
			if ( $instance['include_tag'] !== '' && $instance['exclude_tag'] == '' ) {
				$where .= " AND p.ID IN (
                    SELECT object_id
                    FROM {$wpdb->term_relationships} AS r
                         JOIN {$wpdb->term_taxonomy} AS x ON x.term_taxonomy_id = r.term_taxonomy_id
                    WHERE x.taxonomy = 'post_tag' AND x.term_id IN({$instance['include_tag']})
                    )";
			} elseif ( $instance['include_tag'] === '' && $instance['exclude_tag'] !== '' ) {
				$where .= " AND p.ID NOT IN (
                    SELECT object_id
                    FROM {$wpdb->term_relationships} AS r
                         JOIN {$wpdb->term_taxonomy} AS x ON x.term_taxonomy_id = r.term_taxonomy_id
                    WHERE x.taxonomy = 'post_tag' AND x.term_id IN({$instance['exclude_tag']})
                    )";
			} else { // mixed
				$where .= " AND p.ID IN (
                    SELECT object_id
                    FROM {$wpdb->term_relationships} AS r
                         JOIN {$wpdb->term_taxonomy} AS x ON x.term_taxonomy_id = r.term_taxonomy_id
                    WHERE x.taxonomy = 'post_tag' AND x.term_id IN({$instance['include_tag']}) AND x.term_id NOT IN({$instance['exclude_tag']})
                    ) ";
			}
		}

		// * authors
		if ( ! empty( $instance['author'] ) ) {
			$where .= " AND p.post_author IN({$instance['author']})";
		}

		if ( ! empty( $instance['post_format'] ) ) {
			$where .= " AND p.ID IN ( SELECT object_id FROM {$wpdb->term_relationships} r INNER JOIN {$wpdb->terms} t ON t.term_id = r.term_taxonomy_id WHERE t.name = '{$instance['post_format']}' ) ";
		}

		// * All-time range
		if ( 'all' == $instance['range'] ) {

			$fields .= ", p.comment_count AS 'comment_count'";

			// order by comments
			if ( 'comments' == $instance['order_by'] ) {

				$from    = "{$wpdb->posts} p";
				$where  .= ' AND p.comment_count > 0 ';
				$orderby = ' ORDER BY p.comment_count DESC';

			}
			// order by (avg) views
			else {

				$from = "{$prefix}data v LEFT JOIN {$wpdb->posts} p ON v.postid = p.ID";

				// order by views
				if ( 'views' == $instance['order_by'] ) {

					$fields .= ", v.pageviews AS 'pageviews'";
					$orderby = 'ORDER BY pageviews DESC';

				}
				// order by avg views
				elseif ( 'avg' == $instance['order_by'] ) {

					$fields .= ", ( v.pageviews/(IF ( DATEDIFF('{$now}', MIN(v.day)) > 0, DATEDIFF('{$now}', MIN(v.day)), 1) ) ) AS 'avg_views'";
					$groupby = 'GROUP BY v.postid';
					$orderby = 'ORDER BY avg_views DESC';

				}
			}
		} else { // CUSTOM RANGE

			switch ( $instance['range'] ) {
				case 'daily':
					$interval = '1 DAY';
					break;

				case 'weekly':
					$interval = '1 WEEK';
					break;

				case 'monthly':
					$interval = '1 MONTH';
					break;

				default:
					$interval = '1 DAY';
					break;
			}

			// order by comments
			if ( 'comments' == $instance['order_by'] ) {

				$fields .= ", COUNT(c.comment_post_ID) AS 'comment_count'";
				$from    = "{$wpdb->comments} c LEFT JOIN {$wpdb->posts} p ON c.comment_post_ID = p.ID";
				$where  .= " AND c.comment_date_gmt > DATE_SUB('{$now}', INTERVAL {$interval}) AND c.comment_approved = 1 ";
				$groupby = 'GROUP BY c.comment_post_ID';
				$orderby = 'ORDER BY comment_count DESC';

			}
			// ordered by views / avg
			else {

				$from    = "{$prefix}summary v LEFT JOIN {$wpdb->posts} p ON v.postid = p.ID";
				$where  .= " AND v.view_datetime > DATE_SUB('{$now}', INTERVAL {$interval}) ";
				$groupby = 'GROUP BY v.postid';

				// ordered by views
				if ( 'views' == $instance['order_by'] ) {

					$fields .= ", SUM(v.pageviews) AS 'pageviews'";
					$orderby = 'ORDER BY pageviews DESC';

				}
				// ordered by avg views
				elseif ( 'avg' == $instance['order_by'] ) {

					$fields .= ", ( SUM(v.pageviews)/(IF ( DATEDIFF('{$now}', DATE_SUB('{$now}', INTERVAL {$interval})) > 0, DATEDIFF('{$now}', DATE_SUB('{$now}', INTERVAL {$interval})), 1) ) ) AS 'avg_views' ";
					$orderby = 'ORDER BY avg_views DESC';

				}
			}
		}

		// List only published, non password-protected posts
		$where .= " AND p.post_password = '' AND p.post_status = 'publish'";

		// Build query
		$query = "SELECT {$fields} FROM {$from} {$where} {$groupby} {$orderby} {$limit};";
		$query = $wpdb->get_results( $query );

		if ( isset( $instance['no_found_rows'] ) && ! $instance['no_found_rows'] ) {
			$total_row = $wpdb->get_results( "SELECT COUNT(*) as total FROM {$from} {$where} {$groupby}" );
			$total_row = $groupby ? count( $total_row ) : $total_row[0]->total;
		} else {
			$total_row = 0;
		}

		$result_ids = array();

		foreach ( $query as $result ) {
			$result_ids[] = $this->get_translate_id( $result->id );
		}

		$all_post = get_posts(
			array(
				'post__in'  => $result_ids,
				'post_type' => 'post',
				'showposts' => empty( $result_ids ) ? $instance['limit'] : count( $result_ids ),
			)
		);

		$results = $this->arrange_index( $all_post, $result_ids );

		return array(
			'result' => $results,
			'total'  => $total_row,
		);
	}

	public function arrange_index( $result, $results_id ) {
		$new_result = array();

		foreach ( $results_id as $id ) {
			foreach ( $result as $post ) {
				if ( $id == $post->ID ) {
					$new_result[] = $post;
					break;
				}
			}
		}

		return $new_result;
	}

	public function get_translate_id( $post_id ) {
		if ( function_exists( 'pll_get_post' ) ) {
			$result_id = pll_get_post( $post_id, pll_current_language() );

			if ( $result_id ) {
				$post_id = $result_id;
			}
		} elseif ( defined( 'ICL_SITEPRESS_VERSION' ) ) {
			$post_id = icl_object_id( $post_id, 'post', true, ICL_LANGUAGE_CODE );
		}

		return $post_id;
	}

	/**
	 * Merges two associative arrays recursively
	 */
	private function merge_array_r( array &$array1, array &$array2 ) {

		$merged = $array1;

		foreach ( $array2 as $key => &$value ) {

			if ( is_array( $value ) && isset( $merged[ $key ] ) && is_array( $merged[ $key ] ) ) {
				$merged[ $key ] = $this->merge_array_r( $merged[ $key ], $value );
			} else {
				$merged[ $key ] = $value;
			}
		}

		return $merged;

	}

	/**
	 * Add column Views function
	 */
	public function jnews_views_column( $columns ) {
		if ( is_array( $columns ) && ! isset( $columns['view_count'] ) && get_post_type() === 'post' ) {
			$columns['view_count'] = esc_html__( 'Views', 'jnews' );
		}
		return $columns;
	}

	function jnews_views_column_counter( $column_name, $post_id ) {
		if ( $column_name == 'view_count' ) {
			$views = self::getInstance()->get_views( $post_id );
			echo ( esc_attr( $views ) );
		}
	}
}

/**
 * Get total View
 *
 * @param null $id
 * @param null $range
 * @param bool $number_format
 * @return string
 */
function jnews_get_views( $id = null, $range = null, $number_format = true ) {
	return JNews_View_Counter::getInstance()->get_views( $id, $range, $number_format );
}

/**
 * @param $instance
 * @return array
 */
function jnews_view_counter_query( $instance ) {
	return JNews_View_Counter::getInstance()->query( $instance );
}
