<?php
if ( !function_exists( 'st_form_register_insurance' ) ) {
  function st_form_register_insurance($attr, $content = false) {
    $attr = shortcode_atts([
      'title' => '',
    ], $attr);

    require TRAVELER_PLUGIN_DIR . './common.php';
    $array_gender = array_gender();
    $array_role = array_role();
    require( TRAVELER_PLUGIN_TEMPLATE_DIR . "insurance/insurance.php" );
  }
  add_shortcode( 'st_form_register_insurance', 'st_form_register_insurance' );
}
?>