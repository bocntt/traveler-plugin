<?php
if ( !class_exists( 'user_insurance_database' ) ) {
  class user_insurance_database
  {
    protected static $_inst;

    var $table_name = "traveler_insurance";

    function get_table_name() {
      return $this->table_name;
    }

    function get_total_insurance( $array_keywords = array() ) {
      global $wpdb;
      $keyword = isset( $array_keywords['keyword'] ) ? $array_keywords['keyword'] : "";
      $keyword = strtolower( trim( $keyword ) );
      $table_name = $wpdb->prefix . $this->table_name;
      if ( strlen( $table_name ) == 0 ) {
        return 0;
      } else {
        $sql = "SELECT COUNT(visa_id) FROM " . $table_name;
        $sql .= " WHERE 1=1";
        if ( strlen( $keyword ) > 0 ) {
          $sql .= " AND ((LOWER(first_name) LIKE '%".$keyword."%') OR (LOWER(last_name) LIKE '%".$keyword."%'))";
        }
        $total_answer = $wpdb->get_var( $sql );
        return $total_answer;
      }
    }

    function get_all_insurance( $array_keywords = array(), $limit = 0, $offet = 0 ) {
      global $wpdb;
      $keyword = isset( $array_keywords['keyword'] ) ? $array_keywords['keyword'] : '';
      $keyword = strtolower( trim( $keyword ) );
      $orderby = isset( $array_keywords['orderby'] ) ? $array_keywords['orderby'] : '';
      $order = isset( $array_keywords['order'] ) ? $array_keywords['order'] : 'ASC';
      $table_name = $wpdb->prefix . $this->get_table_name();
      if ( strlen( $table_name ) == 0) {
        return array();
      } else {
        $sql = "SELECT * FROM " . $table_name;
        $sql .= " WHERE 1=1";
        if ( strlen( $keyword ) > 0 ) {
          $sql .= " AND ( LOWER(first_name) LIKE '%". $keyword ."' OR LOWER(last_name) LIKE '%". $keyword ."' )";
        }
        if ( strlen( $orderby ) > 0 ) {
          $sql .= " ORDER BY LOWER(". $orderby.") " . $order;
        }
        if ( $limit > 0 && $offet >= 0 ) {
          $sql .= " LIMIT " . $limit . " OFFSET " . $offet;
        }
        $list_results = $wpdb->get_results($sql, ARRAY_A);
        return $list_results;
      }
    }

    function insert_insurance( $item_obj ) {
      global $wpdb;
      $table_name = $wpdb->prefix . $this->get_table_name();
      $first_name = isset( $item_obj['first_name'] ) ? trim( $item_obj['first_name'] ) : "";
      $last_name = isset( $item_obj['last_name'] ) ? trim( $item_obj['last_name'] ) : "";
      $birth_day = isset( $item_obj['birth_day'] ) ? date('Y-m-d', strtotime(trim( $item_obj['birth_day'] ))) : "0000-00-00";
      $gender = isset( $item_obj['gender'] ) ? trim( $item_obj['gender'] ) : "";
      $address = isset( $item_obj['address'] ) ? trim( $item_obj['address'] ) : "";
      $phone_number = isset( $item_obj['phone_number'] ) ? trim( $item_obj['phone_number'] ) : "";
      $phone_work_number = isset( $item_obj['phone_work_number'] ) ? trim( $item_obj['phone_work_number'] ) : "";
      $department = isset( $item_obj['department'] ) ? trim( $item_obj['department'] ) : "";
      $email = isset( $item_obj['email'] ) ? trim( $item_obj['email'] ) : "";
      $role = isset( $item_obj['role'] ) ? trim( $item_obj['role'] ) : "";
      $number_partner = isset( $item_obj['number_partner'] ) ? (int) trim( $item_obj['number_partner'] ) : "";
      $number_vacation = isset( $item_obj['number_vacation'] ) ? (int) trim( $item_obj['number_vacation'] ) : "";
      $date_of_travel = isset( $item_obj['date_of_travel'] ) ? date('Y-m-d', strtotime(trim( $item_obj['date_of_travel'] ))) : "";
      $date_of_return = isset( $item_obj['date_of_return'] ) ? date('Y-m-d', strtotime(trim( $item_obj['date_of_return'] ))) : "";
      $region = isset( $item_obj['region'] ) ? trim( $item_obj['region'] ) : "";
      $country_to_visited = isset( $item_obj['country_to_visited'] ) ? trim( $item_obj['country_to_visited'] ) : "";

      $sql = "INSERT INTO ".$table_name."(first_name, last_name, birth_day, gender, address, phone_number, phone_work_number, department, email, role, number_partner, number_vacation, date_of_travel, date_of_return, region, country_to_visited, date_added) " .
				" VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%s', '%s', '%s', '%s', NOW())";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$first_name,
						$last_name,
						$birth_day,
            $gender,
            $address,
            $phone_number,
            $phone_work_number,
            $department,
            $email,
            $role,
            $number_partner,
            $number_vacation,
            $date_of_travel,
            $date_of_return,
            $region,
            $country_to_visited
					)
				)
			);
    }

    public static function inst() {
      if ( !self::$_inst) {
        self::$_inst = new self();
      }
      return self::$_inst;
    }
  }
  user_insurance_database::inst();
}
?>