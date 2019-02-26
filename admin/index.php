<?php
function manage_visa() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'traveler_visa';
  require_once( TRAVELER_PLUGIN_DIR . 'admin/visa/visa_database.php' );
  require_once( TRAVELER_PLUGIN_DIR . 'admin/visa/index.php' );
}

function manage_insurance() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'traveler_insurance';
  require_once( TRAVELER_PLUGIN_DIR . 'admin/insurance/insurance_database.php' );
  require_once( TRAVELER_PLUGIN_DIR . 'admin/insurance/index.php' );
}
?>