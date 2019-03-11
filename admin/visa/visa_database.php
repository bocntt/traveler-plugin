<?php
if ( !class_exists( 'visa_database' ) ) {
  class visa_database
  {
    protected static $_inst;

    var $table_name = "traveler_visa";

    function get_table_name() {
      return $this->table_name;
    }

    function set_table_name( $table_name ) {
      $this->table_name = $table_name;
    }

    function get_total_visa( $array_keywords = array() ) {
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

    function get_all_visa( $array_keywords = array(), $limit = 0, $offet = 0 ) {
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

    function get_visa_by_visa_id( $visa_id = 0) {
      global $wpdb;
      $table_name = $wpdb->prefix . $this->get_table_name();
      if ( $visa_id == 0) {
        return array();
      } else {
        $sql = "SELECT * FROM " . $table_name;
        $sql .= " WHERE visa_id = '" . $visa_id . "'";
        $result = $wpdb->get_row($sql, ARRAY_A);
        return $result;
      }
    }

    function insert_visa( $item_obj ) {
      global $wpdb;
      $table_name = $wpdb->prefix . $this->get_table_name();
      $first_name = isset( $item_obj['first_name'] ) ? trim( $item_obj['first_name'] ) : "";
      $middle_name = isset( $item_obj['middle_name'] ) ? trim( $item_obj['middle_name'] ) : "";
      $last_name = isset( $item_obj['last_name'] ) ? trim( $item_obj['last_name'] ) : "";
      $birth_day = isset( $item_obj['birth_day'] ) ? date('Y-m-d', strtotime(trim( $item_obj['birth_day'] ))) : "0000-00-00";
      $gender = isset( $item_obj['gender'] ) ? trim( $item_obj['gender'] ) : "";
      $email = isset( $item_obj['email'] ) ? trim( $item_obj['email'] ) : "";
      $place_of_birth = isset( $item_obj['place_of_birth'] ) ? trim( $item_obj['place_of_birth'] ) : "";
      $nationality = isset( $item_obj['nationality'] ) ? trim( $item_obj['nationality'] ) : "";
      $marital_status = isset( $item_obj['marital_status'] ) ? trim( $item_obj['marital_status'] ) : "";
      $father_first_name = isset( $item_obj['father_first_name'] ) ? trim( $item_obj['father_first_name'] ) : "";
      $father_last_name = isset( $item_obj['father_last_name'] ) ? trim( $item_obj['father_last_name'] ) : "";
      $father_birth_day = isset( $item_obj['father_birth_day'] ) ? trim( $item_obj['father_birth_day'] ) : "0000-00-00";
      $mother_first_name = isset( $item_obj['mother_first_name'] ) ? trim( $item_obj['mother_first_name'] ) : "";
      $mother_last_name = isset( $item_obj['mother_last_name'] ) ? trim( $item_obj['mother_last_name'] ) : "";
      $mother_birth_day = isset( $item_obj['mother_birth_day'] ) ? trim( $item_obj['mother_birth_day'] ) : "0000-00-00";
      $phone_no = isset( $item_obj['phone_no'] ) ? trim( $item_obj['phone_no'] ) : "";
      $phone_work_no = isset( $item_obj['phone_work_no'] ) ? trim( $item_obj['phone_work_no'] ) : "";
      $street_address = isset( $item_obj['street_address'] ) ? trim( $item_obj['street_address'] ) : "";
      $apartment_no = isset( $item_obj['apartment_no'] ) ? trim( $item_obj['apartment_no'] ) : "";
      $city = isset( $item_obj['city'] ) ? trim( $item_obj['city'] ) : "";
      $zip_code = isset( $item_obj['zip_code'] ) ? trim( $item_obj['zip_code'] ) : "";
      $country = isset( $item_obj['country'] ) ? trim( $item_obj['country'] ) : "";

      $sql = "INSERT INTO ".$table_name."(first_name, middle_name, last_name, birth_day, gender, email, place_of_birth, nationality, marital_status, father_first_name, father_last_name, mother_first_name, mother_last_name, phone_no, phone_work_no, street_address, apartment_no, city, zip_code, country, date_added) " .
				" VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', NOW())";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$first_name,
						$middle_name,
						$last_name,
						$birth_day,
            $gender,
            $email,
            $place_of_birth,
            $nationality,
            $marital_status,
            $father_first_name,
            $father_last_name,
            $mother_first_name,
            $mother_last_name,
            $phone_no,
            $phone_work_no,
            $street_address,
            $apartment_no,
            $city,
            $zip_code,
            $country
					)
				)
			);
    }

    function update_visa( $item_obj ) {
      global $wpdb;
      $table_name = $wpdb->prefix . $this->get_table_name();
      $visa_id = isset( $item_obj['visa_id'] ) ? (int) trim( $item_obj['visa_id'] ) : 0;
      $first_name = isset( $item_obj['first_name'] ) ? trim( $item_obj['first_name'] ) : "";
      $middle_name = isset( $item_obj['middle_name'] ) ? trim( $item_obj['middle_name'] ) : "";
      $last_name = isset( $item_obj['last_name'] ) ? trim( $item_obj['last_name'] ) : "";
      $birth_day = isset( $item_obj['birth_day'] ) ? date('Y-m-d', strtotime(trim( $item_obj['birth_day'] ))) : "0000-00-00";
      $gender = isset( $item_obj['gender'] ) ? trim( $item_obj['gender'] ) : "";
      $email = isset( $item_obj['email'] ) ? trim( $item_obj['email'] ) : "";
      $place_of_birth = isset( $item_obj['place_of_birth'] ) ? trim( $item_obj['place_of_birth'] ) : "";
      $nationality = isset( $item_obj['nationality'] ) ? trim( $item_obj['nationality'] ) : "";
      $marital_status = isset( $item_obj['marital_status'] ) ? trim( $item_obj['marital_status'] ) : "";
      $father_first_name = isset( $item_obj['father_first_name'] ) ? trim( $item_obj['father_first_name'] ) : "";
      $father_last_name = isset( $item_obj['father_last_name'] ) ? trim( $item_obj['father_last_name'] ) : "";
      $mother_first_name = isset( $item_obj['mother_first_name'] ) ? trim( $item_obj['mother_first_name'] ) : "";
      $mother_last_name = isset( $item_obj['mother_last_name'] ) ? trim( $item_obj['mother_last_name'] ) : "";
      $phone_no = isset( $item_obj['phone_no'] ) ? trim( $item_obj['phone_no'] ) : "";
      $phone_work_no = isset( $item_obj['phone_work_no'] ) ? trim( $item_obj['phone_work_no'] ) : "";
      $street_address = isset( $item_obj['street_address'] ) ? trim( $item_obj['street_address'] ) : "";
      $apartment_no = isset( $item_obj['apartment_no'] ) ? trim( $item_obj['apartment_no'] ) : "";
      $city = isset( $item_obj['city'] ) ? trim( $item_obj['city'] ) : "";
      $zip_code = isset( $item_obj['zip_code'] ) ? trim( $item_obj['zip_code'] ) : "";
      $country = isset( $item_obj['country'] ) ? trim( $item_obj['country'] ) : "";

      $sql = "UPDATE ".$table_name." SET first_name = '%s', ".
                    "middle_name = '%s', ".
                    "last_name = '%s', ".
                    "birth_day = '%s', ".
                    "gender = '%s', ".
                    "email = '%s', ".
                    "place_of_birth = '%s', ".
                    "nationality = '%s', ".
                    "marital_status = '%s', ".
                    "father_first_name = '%s', ".
                    "father_last_name = '%s', ".
                    "mother_first_name = '%s', ".
                    "mother_last_name = '%s', ".
                    "phone_no = '%s', ".
                    "phone_work_no = '%s', ".
                    "street_address = '%s', ".
                    "apartment_no = '%s', ".
                    "city = '%s', ".
                    "zip_code = '%s', ".
                    "country = '%s' ".
                    " WHERE visa_id  = '%d' ";
			$wpdb->query(
				$wpdb->prepare(
					$sql,
					array(
						$first_name,
						$middle_name,
						$last_name,
						$birth_day,
            $gender,
            $email,
            $place_of_birth,
            $nationality,
            $marital_status,
            $father_first_name,
            $father_last_name,
            $mother_first_name,
            $mother_last_name,
            $phone_no,
            $phone_work_no,
            $street_address,
            $apartment_no,
            $city,
            $zip_code,
            $country,
            $visa_id
					)
				)
			);
    }

    function delete_visa( $visa_id = 0 ) {
      global $wpdb;
      $table_name = $wpdb->prefix . $this->get_table_name();
      if ( $visa_id > 0 ) {
        $sql = "DELETE FROM ". $table_name ." WHERE visa_id = '%d' ";
        $wpdb->query(
          $wpdb->prepare(
            $sql,
            $visa_id
          )
        );
      }
    }

    public static function inst() {
      if ( !self::$_inst) {
        self::$_inst = new self();
      }
      return self::$_inst;
    }
  }
  visa_database::inst();
}
?>