<?php
/**
 * Plugin Name: Traveler Plugin
 * Version: 1.0
 * Author: Traveler
 * Plugin URI: #
 * Description: Traveler Plugin
 */
if ( !defined( 'ABSPATH' ) ) {
  die( '-1' );
}

if ( !defined( 'TRAVELER_PLUGIN_TEXTDOMAIN' ) ) {
  define( 'TRAVELER_PLUGIN_TEXTDOMAIN', 'traveler-plugin' );
}

if ( !defined( 'TRAVELER_PLUGIN_DIR' ) ) {
  define( 'TRAVELER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if ( !defined( 'TRAVELER_PLUGIN_TEMPLATE_DIR' ) ) {
  define( 'TRAVELER_PLUGIN_TEMPLATE_DIR', plugin_dir_path( __FILE__ ) . 'templates/' );
}

if ( !defined( 'TRAVELER_PLUGIN_URI' ) ) {
  define( 'TRAVELER_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
}

if ( !function_exists( 'traveler_plugin_map_shortcode' ) ) {
  function traveler_plugin_map_shortcode() {
    vc_map(array(
      "name"            => __( "ST Form Register Visa" , TRAVELER_PLUGIN_TEXTDOMAIN ) ,
      "base"            => "st_form_register_visa" ,
      "content_element" => true ,
      "icon"            => "icon-st" ,
      "category"        => 'Shinetheme' ,
      'show_settings_on_create' => false,
      'params'=>array(
        [
          "type"        => "textfield",
          "heading"     => __( "Title", TRAVELER_PLUGIN_TEXTDOMAIN ),
          "param_name"  => "title",
          "description" => "",
        ],
        // array(
        //     'type' => 'textfield',
        //     'heading' => esc_html__('There is no option in this element', TRAVELER_PLUGIN_TEXTDOMAIN),
        //     'param_name' => 'description_field',
        //     'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
        // )
      )
    ));
    vc_map(array(
      "name"            => __( "ST Form Register Insurance" , TRAVELER_PLUGIN_TEXTDOMAIN ) ,
      "base"            => "st_form_register_insurance" ,
      "content_element" => true ,
      "icon"            => "icon-st" ,
      "category"        => 'Shinetheme' ,
      'show_settings_on_create' => false,
      'params'=>array(
        [
          "type"        => "textfield",
          "heading"     => __( "Title", TRAVELER_PLUGIN_TEXTDOMAIN ),
          "param_name"  => "title",
          "description" => "",
        ],
        // array(
        //     'type' => 'textfield',
        //     'heading' => esc_html__('There is no option in this element', TRAVELER_PLUGIN_TEXTDOMAIN),
        //     'param_name' => 'description_field',
        //     'edit_field_class' => 'vc_column vc_col-sm-12 st_vc_hidden_input'
        // )
      )
    ));
  }
  add_action( 'vc_before_init', 'traveler_plugin_map_shortcode' );
}

if ( is_admin() ) {
  require_once( TRAVELER_PLUGIN_DIR . "common.php" );
  require_once( TRAVELER_PLUGIN_DIR . "admin/index.php" );
  if ( !function_exists( 'traveler_plugin_admin_menu' ) ) {
    function traveler_plugin_admin_menu() {
      add_menu_page("Traveler Plugin", "Traveler Plugin", "manage_options", 'manage_visa', 'manage_visa', '');
      add_submenu_page('manage_visa', "Manage Visa", "Manage Visa", 'manage_options', 'manage_visa', 'manage_visa');
      add_submenu_page('manage_visa', "Manage Insurance", "Manage Insurance", 'manage_options', 'manage_insurance', 'manage_insurance');
    }
  }
  add_action( 'admin_menu', 'traveler_plugin_admin_menu' );
}

function traveler_plugin_script() {
  wp_enqueue_script( 'traveler-plugin-js', TRAVELER_PLUGIN_URI . 'traveler-plugin.js', [ 'jquery', 'jquery-ui-datepicker' ], null, true );
}
add_action('wp_enqueue_scripts', 'traveler_plugin_script');

if (is_admin()) {
  function traveler_plugin_admin_script() {
    wp_enqueue_style( 'traveler-plugin-jquery-ui.theme.min.css', TRAVELER_PLUGIN_URI. '/jquery-ui.min.css' );
    wp_enqueue_script( 'traveler-plugin-admin-js', TRAVELER_PLUGIN_URI . 'traveler-plugin-admin.js', [ 'jquery', 'jquery-ui-datepicker' ], null, true );
  }
  add_action('admin_enqueue_scripts', 'traveler_plugin_admin_script');
}

require_once( TRAVELER_PLUGIN_DIR . "enduser/index.php");

if ( !function_exists( 'traveler_plugin_install' ) ) {
  function traveler_plugin_install() {
    if ( is_admin() ) {
      require_once( TRAVELER_PLUGIN_DIR . "install.traveler.plugin.php" );
    }
  }
}
register_activation_hook(__FILE__, 'traveler_plugin_install');

if ( !function_exists( 'traveler_plugin_uninstall' ) ) {
  function traveler_plugin_uninstall() {
    if ( is_admin() ) {
      require_once( TRAVELER_PLUGIN_DIR . "uninstall.traveler.plugin.php" );
    }
  }
}
register_deactivation_hook(__FILE__, 'traveler_plugin_uninstall');

// ajax register visa form
if ( !function_exists( 'traveler_plugin_register_visa_form_ajax' ) ) {
  function traveler_plugin_register_visa_form_ajax() {
    require_once( TRAVELER_PLUGIN_DIR . "common.php" );
    $validate = true;
    $errors = [];
    if (!$_POST['register_visa'] || ! wp_verify_nonce( $_POST['register_visa'], 'traveler_register_visa_action' )) {
      die('Failed security check');
    }

    $data = isset( $_POST) ? $_POST : array();
    foreach ($_POST as $key => $value) {
      $form_data[$key] = trim($value);
    }
    if (!isset($form_data['first_name']) || strlen($form_data['first_name']) == 0) $errors['first_name'] = __('First Name is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['last_name']) || strlen($form_data['last_name']) == 0) $errors['last_name'] = __('First Name is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['birth_day']) || strlen($form_data['birth_day']) == 0) $errors['birth_day'] = __('Birthday is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!validateDateTime($form_data['birth_day'])) $errors['birth_day'] = __('Birthday is not date', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['email']) || strlen($form_data['email']) == 0) $errors['email'] = __('Email is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!validateEmail($form_data['email'])) $errors['email'] = __('Email is incorrect', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['gender']) || strlen($form_data['gender']) == 0) $errors['gender'] = __('Gender is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['nationality']) || strlen($form_data['nationality']) == 0) $errors['nationality'] = __('Nationality is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['phone_no']) || strlen($form_data['phone_no']) == 0) $errors['phone_no'] = __('Phone No. is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['street_address']) || strlen($form_data['street_address']) == 0) $errors['street_address'] = __('Street Address is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['apartment_no']) || strlen($form_data['apartment_no']) == 0) $errors['apartment_no'] = __('Apartment No. is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['city']) || strlen($form_data['city']) == 0) $errors['city'] = __('City is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['country']) || strlen($form_data['country']) == 0) $errors['country'] = __('Country is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if ( sizeof($errors) > 0) $validate = false;
    if ( $validate && sizeof($errors) == 0 ) {
      require_once( TRAVELER_PLUGIN_DIR . "enduser/visa/visa_database.php" );
      $visa_database = user_visa_database::inst();
      $visa_database->insert_visa($form_data);
      $return = [
        'status' => true,
        'redirect' => home_url('/')
      ];
    } else {
      $return = [
          'status'  => false,
          'message' => $errors
      ];
    }
    echo json_encode( $return );
    die;
  }
  add_action( 'wp_ajax_register_visa_form_direct_submit', 'traveler_plugin_register_visa_form_ajax');
  add_action( 'wp_ajax_nopriv_register_visa_form_direct_submit', 'traveler_plugin_register_visa_form_ajax' );
}

// ajax register insurance form
if ( !function_exists( 'traveler_plugin_register_insurance_form_ajax' ) ) {
  function traveler_plugin_register_insurance_form_ajax() {
    require_once( TRAVELER_PLUGIN_DIR . "common.php" );
    $validate = true;
    $errors = [];
    if ( ! isset($_POST['register_insurance']) || ! wp_verify_nonce( $_POST['register_insurance'], 'traveler_register_insurance_action')) {
      die('Failed security check');
    }
    $data = isset( $_POST) ? $_POST : array();
    foreach ($_POST as $key => $value) {
      $form_data[$key] = trim($value);
    }
    if (!isset($form_data['first_name']) || strlen($form_data['first_name']) == 0) $errors['first_name'] = __('First Name is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['last_name']) || strlen($form_data['last_name']) == 0) $errors['last_name'] = __('First Name is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['birth_day']) || strlen($form_data['birth_day']) == 0) $errors['birth_day'] = __('Birthday is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!validateDateTime($form_data['birth_day'])) $errors['birth_day'] = __('Birthday is not date', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['email']) || strlen($form_data['email']) == 0) $errors['email'] = __('Email is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!validateEmail($form_data['email'])) $errors['email'] = __('Email is incorrect', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['gender']) || strlen($form_data['gender']) == 0) $errors['gender'] = __('Gender is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['address']) || strlen($form_data['address']) == 0) $errors['address'] = __('Address is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['phone_number']) || strlen($form_data['phone_number']) == 0) $errors['phone_number'] = __('Phone No. is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['date_of_travel']) || strlen($form_data['date_of_travel']) == 0) $errors['date_of_travel'] = __('Date of Travel is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!validateDateTime($form_data['date_of_travel'])) $errors['date_of_travel'] = __('Date of Travel is not date', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['date_of_return']) || strlen($form_data['date_of_return']) == 0) $errors['date_of_return'] = __('Date of return is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!validateDateTime($form_data['date_of_return'])) $errors['date_of_return'] = __('Date of return is not date', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['region']) || strlen($form_data['region']) == 0) $errors['region'] = __('Region is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if (!isset($form_data['country_to_visited']) || strlen($form_data['country_to_visited']) == 0) $errors['country_to_visited'] = __('Date of return is required', TRAVELER_PLUGIN_TEXTDOMAIN);
    if ( sizeof($errors) > 0) $validate = false;
    if ( $validate && sizeof($errors) == 0 ) {
      require_once( TRAVELER_PLUGIN_DIR . "enduser/insurance/insurance_database.php" );
      $insurance_database = user_insurance_database::inst();
      $insurance_database->insert_insurance($form_data);
      $return = [
        'status' => true,
        'redirect' => home_url('/')
      ];
    } else {
      $return = [
          'status'  => false,
          'message' => $errors
      ];
    }
    echo json_encode( $return );
    die();
  }
  add_action( 'wp_ajax_register_insurance_form_direct_submit', 'traveler_plugin_register_insurance_form_ajax');
  add_action( 'wp_ajax_nopriv_register_insurance_form_direct_submit', 'traveler_plugin_register_insurance_form_ajax' );
}
?>