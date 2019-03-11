<?php
require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

global $wpdb;

function create_traveler_visa_table_sql() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'traveler_visa';
  $sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
    `visa_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `first_name` varchar(250) NOT NULL,
    `middle_name` varchar(250) NOT NULL,
    `last_name` varchar(250) NOT NULL,
    `birth_day` date NOT NULL,
    `gender` varchar(250) NOT NULL,
    `email` varchar(250) NOT NULL,
    `place_of_birth` varchar(500) NOT NULL,
    `nationality` varchar(250) NOT NULL,
    `marital_status` varchar(250) NOT NULL,
    `father_first_name` varchar(250) NOT NULL,
    `father_last_name` varchar(250) NOT NULL,
    `father_birth_day` date NOT NULL,
    `mother_first_name` varchar(250) NOT NULL,
    `mother_last_name` varchar(250) NOT NULL,
    `mother_birth_day` date NOT NULL,
    `phone_no` varchar(250) NOT NULL,
    `phone_work_no` varchar(250) NOT NULL,
    `street_address` varchar(250) NOT NULL,
    `apartment_no` varchar(250) NOT NULL,
    `city` varchar(250) NOT NULL,
    `zip_code` varchar(250) NOT NULL,
    `country` varchar(250) NOT NULL,
    `date_added` datetime NOT NULL,
    PRIMARY KEY (`visa_id`),
    UNIQUE KEY `visa_id` (`visa_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
return $sql;
}

function create_traveler_insurance_table_sql() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'traveler_insurance';
  $sql = "CREATE TABLE IF NOT EXISTS ".$table_name." (
    `insurance_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `first_name` varchar(250) NOT NULL,
    `last_name` varchar(250) NOT NULL,
    `birth_day` date NOT NULL,
    `gender` varchar(250) NOT NULL,
    `address` varchar(250) NOT NULL,
    `phone_number` varchar(250) NOT NULL,
    `phone_work_number` varchar(250) NOT NULL,
    `department` varchar(250) NOT NULL,
    `email` varchar(250) NOT NULL,
    `role` varchar(250) NOT NULL,
    `number_partner` int NOT NULL,
    `number_vacation` int NOT NULL,
    `date_of_travel` date NOT NULL,
    `date_of_return` date NOT NULL,
    `region` varchar(250) NOT NULL,
    `country_to_visited` varchar(250) NOT NULL,
    `date_added` datetime NOT NULL,
    PRIMARY KEY (`insurance_id`),
    UNIQUE KEY `insurance_id` (`insurance_id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
return $sql;
}

dbDelta( create_traveler_visa_table_sql() );
dbDelta( create_traveler_insurance_table_sql() );

?>
