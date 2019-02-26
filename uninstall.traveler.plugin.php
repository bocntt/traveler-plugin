<?php
require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );

global $wpdb;

function detete_traveler_visa_table_sql() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'traveler_visa';
  $sql = "DROP TABLE IF EXISTS ". $table_name . ";";
  return $sql;
}

function detete_traveler_insurance_table_sql() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'traveler_insurance';
  $sql = "DROP TABLE IF EXISTS ". $table_name . ";";
  return $sql;
}

// $wpdb->query( detete_traveler_visa_table_sql() );
// $wpdb->query( detete_traveler_insurance_table_sql() );

?>