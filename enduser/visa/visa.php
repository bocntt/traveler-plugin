<?php
if ( !function_exists( 'st_form_register_visa' ) ) {
  function st_form_register_visa($attr, $content = false) {
    $attr = shortcode_atts([
      'title' => '',
    ], $attr);

    require TRAVELER_PLUGIN_DIR . './common.php';
    $array_marital_status = array_marital_status();
    $array_gender = array_gender();
    require( TRAVELER_PLUGIN_TEMPLATE_DIR . "visa/visa.php" );
  }
  add_shortcode( 'st_form_register_visa', 'st_form_register_visa' );
}
?>