<?php
global $table_name;

if ( !class_exists( 'visa_database' ) ) {
  wp_redirect ( home_url() );
}
$visa_database = visa_database::inst();

$page = isset( $_REQUEST['page'] ) ? trim( $_REQUEST['page'] ) : "";
$start = isset( $_REQUEST['start'] ) ? trim( $_REQUEST['start'] ) : 1;
$task = isset( $_REQUEST['task'] ) ? trim( $_REQUEST['task'] ) : "list";
$is_save = isset( $_REQUEST['is_save'] ) ? trim( $_REQUEST['is_save'] ) : 0;
$visa_id = isset( $_REQUEST['visa_id'] ) ? trim( $_REQUEST['visa_id'] ) : 0;
$action = isset( $_REQUEST['action'] ) ? trim( $_REQUEST['action'] ) : "";

$array_gender = array_gender();
$array_marital_status = array_marital_status();

if ( $task == "delete" or $action == "delete" ) {
  $list_visa_id = isset( $_REQUEST['visa'] ) ? $_REQUEST['visa'] : array();
  $visa_id = isset( $_REQUEST['visa_id'] ) ? $_REQUEST['visa_id'] : 0;
  if ( sizeof( $list_visa_id ) > 0 ) {
    foreach ( $list_visa_id as $visa_id ) {
      $visa_database->delete_visa( $visa_id );
    }
  }
  if ( $visa_id != 0 ) {
    $visa_database->delete_visa( $visa_id );
  }
  $task = 'list';
}

if ($task == 'edit' || $task == 'add') {
  $errors = array();
  $visa_data = array();
  if (isset($_POST['is_save']) && $_POST['is_save'] == 1) {
    $first_name = isset( $_POST['first_name'] ) ? trim( $_POST['first_name'] ) : "";
    $middle_name = isset( $_POST['middle_name'] ) ? trim( $_POST['middle_name'] ) : "";
    $last_name = isset( $_POST['last_name'] ) ? trim( $_POST['last_name'] ) : "";
    $birth_day = isset( $_POST['birth_day'] ) ? trim( $_POST['birth_day'] ) : "0000-00-00";
    $gender = isset( $_POST['gender'] ) ? trim( $_POST['gender'] ) : "";
    $email = isset( $_POST['email'] ) ? trim( $_POST['email'] ) : "";
    $place_of_birth = isset( $_POST['place_of_birth'] ) ? trim( $_POST['place_of_birth'] ) : "";
    $nationality = isset( $_POST['nationality'] ) ? trim( $_POST['nationality'] ) : "";
    $marital_status = isset( $_POST['marital_status'] ) ? trim( $_POST['marital_status'] ) : "";
    $father_first_name = isset( $_POST['father_first_name'] ) ? trim( $_POST['father_first_name'] ) : "";
    $father_last_name = isset( $_POST['father_last_name'] ) ? trim( $_POST['father_last_name'] ) : "";
    $father_birth_day = isset( $_POST['father_birth_day'] ) ? trim( $_POST['father_birth_day'] ) : "0000-00-00";
    $mother_first_name = isset( $_POST['mother_first_name'] ) ? trim( $_POST['mother_first_name'] ) : "";
    $mother_last_name = isset( $_POST['mother_last_name'] ) ? trim( $_POST['mother_last_name'] ) : "";
    $mother_birth_day = isset( $_POST['mother_birth_day'] ) ? trim( $_POST['mother_birth_day'] ) : "0000-00-00";
    $phone_no = isset( $_POST['phone_no'] ) ? trim( $_POST['phone_no'] ) : "";
    $phone_work_no = isset( $_POST['phone_work_no'] ) ? trim( $_POST['phone_work_no'] ) : "";
    $street_address = isset( $_POST['street_address'] ) ? trim( $_POST['street_address'] ) : "";
    $apartment_no = isset( $_POST['apartment_no'] ) ? trim( $_POST['apartment_no'] ) : "";
    $city = isset( $_POST['city'] ) ? trim( $_POST['city'] ) : "";
    $zip_code = isset( $_POST['zip_code'] ) ? trim( $_POST['zip_code'] ) : "";
    $country = isset( $_POST['country'] ) ? trim( $_POST['country'] ) : "";
    $visa_data['first_name'] = $first_name;
    $visa_data['middle_name'] = $middle_name;
    $visa_data['last_name'] = $last_name;
    $visa_data['birth_day'] = $birth_day;
    $visa_data['gender'] = $gender;
    $visa_data['email'] = $email;
    $visa_data['place_of_birth'] = $place_of_birth;
    $visa_data['nationality'] = $nationality;
    $visa_data['marital_status'] = $marital_status;
    $visa_data['father_first_name'] = $father_first_name;
    $visa_data['father_last_name'] = $father_last_name;
    $visa_data['father_birth_day'] = $father_birth_day;
    $visa_data['mother_first_name'] = $mother_first_name;
    $visa_data['mother_last_name'] = $mother_last_name;
    $visa_data['mother_birth_day'] = $mother_birth_day;
    $visa_data['phone_no'] = $phone_no;
    $visa_data['phone_work_no'] = $phone_work_no;
    $visa_data['street_address'] = $street_address;
    $visa_data['apartment_no'] = $apartment_no;
    $visa_data['city'] = $city;
    $visa_data['zip_code'] = $zip_code;
    $visa_data['country'] = $country;
    $visa_data['visa_id'] = $visa_id;
    if ($visa_id > 0) {
      $visa_database->update_visa($visa_data);
      $task = "list";
    }
  } else {
    if ($visa_id != 0) {
      $visa_data = $visa_database->get_visa_by_visa_id($visa_id);
    }
  }
}


if ( $task == "list" ) {
  $keyword = isset( $_REQUEST['keyword'] ) ? trim( $_REQUEST['keyword'] ) : "";
  $orderby = isset( $_REQUEST['orderby'] ) ? trim( $_REQUEST['orderby'] ) : "";
  $order = isset( $_REQUEST['order'] ) ? trim( $_REQUEST['order'] ) : "";
  if ($orderby == 'date') $orderby = 'date_added';
  $array_keyword['keyword'] = $keyword;
  $array_keyword['orderby'] = $orderby;
  $array_keyword['order'] = $order;
  $total_visa = $visa_database->get_total_visa( $array_keyword );
  $limit = 20;
  $offset = ($start - 1) * $limit;
  if ( $offset < 0) $offset = 0;
  $list_visa = $visa_database->get_all_visa( $array_keyword, $limit, $offset );
  $total = ceil( sizeof($list_visa) / $limit );

  global $wp_query;
  $paging = [];
  $paging[ 'base' ]    = admin_url( 'admin.php?page=manage_visa%_%' );
  $paging[ 'format' ]  = '&paged=%#%';
  $paging[ 'total' ]   = $total;
  $paging[ 'current' ] = $start;
  $order = ($order == 'ASC') ? 'DESC' : 'ASC';
?>
  <div class="wrap">
    <div id="icon-tools" class="icon32"></div>
    <h2><?php esc_html_e("Manage Visa", TRAVELER_PLUGIN_TEXTDOMAIN) ?></h2>
    <form id="posts-filter" action="<?php echo admin_url( 'admin.php?page=manage_visa' ) ?>"
      method="post">
      <?php wp_nonce_field() ?>
      <div class="tablenav top">
          <div class="alignleft actions bulkactions">
              <label for="bulk-action-selector-top"
                    class="screen-reader-text"><?php _e( 'Select bulk action', TRAVELER_PLUGIN_TEXTDOMAIN ) ?></label><select
                  name="action" id="bulk-action-selector-top">
                  <option value="-1" selected="selected"><?php _e( 'Bulk Actions', TRAVELER_PLUGIN_TEXTDOMAIN ) ?></option>
                  <option value="delete"><?php _e( 'Delete Permanently', TRAVELER_PLUGIN_TEXTDOMAIN ) ?></option>
              </select>
              <input type="submit" name="" id="doaction" class="button action"
                    value="<?php _e( 'Apply', TRAVELER_PLUGIN_TEXTDOMAIN ) ?>">
          </div>
          <div class="tablenav-pages">
              <span
                  class="displaying-num"><?php echo sprintf( _n( '%s item', '%s items', sizeof( $list_visa ) ), sizeof( $list_visa ), TRAVELER_PLUGIN_TEXTDOMAIN ) ?></span>
              <?php echo paginate_links( $paging ) ?>

          </div>
      </div>

      <table class="wp-list-table widefat fixed posts">
          <thead>
          <tr>
              <th class="manage-column column-cb check-column">
                  <label class="screen-reader-text"
                        for="cb-select-all-1"><?php _e( 'Select All', TRAVELER_PLUGIN_TEXTDOMAIN ) ?></label>
                  <input type="checkbox" id="cb-select-all-1">
              </th>

              <th class="manage-column column-primary sorted asc">
                <a href="<?php echo esc_url( admin_url("admin.php?page=manage_visa&orderby=first_name&order=$order") ) ?>">
                  <span><?php _e( 'First Name', TRAVELER_PLUGIN_TEXTDOMAIN ) ?></span>
                  <span class="sorting-indicator"></span>
                </a>
              </th>

              <th class="manage-column">
                  <?php _e( 'Last Name', TRAVELER_PLUGIN_TEXTDOMAIN ) ?>
              </th>
              <th class="manage-column">
                  <?php _e( 'Gender', TRAVELER_PLUGIN_TEXTDOMAIN ) ?>
              </th>
              <th class="manage-column">
                  <?php _e( 'Email', TRAVELER_PLUGIN_TEXTDOMAIN ) ?>
              </th>
              <th class="manage-column">
                <?php _e( "Phone Number", TRAVELER_PLUGIN_TEXTDOMAIN ) ?>
              </th>
              <th class="manage-column">
                <?php _e( "Country", TRAVELER_PLUGIN_TEXTDOMAIN ) ?>
              </th>
              <th class="manage-column column-date sortable desc">
                <a href="<?php echo esc_url( admin_url("admin.php?page=manage_visa&orderby=date&order=$order") ) ?>">
                  <span><?php _e( 'Date', TRAVELER_PLUGIN_TEXTDOMAIN ) ?></span>
                  <span class="sorting-indicator"></span>
                </a>
              </th>
          </tr>
          </thead>
          <tbody>
          <?php
            $i = 0;
            if ( !empty( $list_visa ) ) {
              foreach ( $list_visa as $item ) {
                $i++;
                $visa_id  = $item['visa_id'];
                $order_id = $visa_id;
                ?>
                <tr class="<?php if ( $i % 2 == 0 ) echo 'alternate'; ?>">
                    <th scope="row" class="check-column">
                        <input id="cb-select-39" type="checkbox" name="visa[]"
                              value="<?php echo esc_attr( $visa_id ) ?>">

                        <div class="locked-indicator"></div>
                    </th>
                    <td class="post-title page-title column-title">
                        <strong><a class="row-title"
                                  href="<?php echo admin_url( 'admin.php?page=manage_visa&task=edit&visa_id=' . $visa_id ); ?>"
                                  title=""><?php
                                    echo esc_html( $item['first_name'] );
                                ?></a></strong>

                        <div class="row-actions">
                            <a href="<?php echo admin_url( 'admin.php?page=manage_visa&task=edit&visa_id=' . $visa_id ); ?>"><?php _e( 'Edit', TRAVELER_PLUGIN_TEXTDOMAIN ) ?></a> |
                            <a href="<?php echo admin_url( 'admin.php?page=manage_visa&task=delete&visa_id=' . $visa_id ); ?>"><?php _e( 'Delete', TRAVELER_PLUGIN_TEXTDOMAIN ) ?></a>
                        </div>
                    </td>
                    <td class="post-title page-title column-title">
                      <?php
                        echo esc_html( $item['last_name'] );
                      ?>
                    </td>
                    <td class="post-title page-title column-title">
                      <?php
                        echo esc_html( $item['gender'] );
                      ?>
                    </td>
                    <td class="post-title page-title column-title">
                      <?php
                        echo esc_html( $item['email'] );
                      ?>
                    </td>
                    <td class="post-title page-title column-title">
                      <?php
                        echo esc_html( $item['phone_no'] );
                      ?>
                    </td>
                    <td class="post-title page-title column-title">
                      <?php
                        echo esc_html( $item['country'] );
                      ?>
                    </td>
                    <td class="date column-date">
                      <?php
                        echo esc_html( date( get_option('date_format'), strtotime($item['date_added']) ));
                      ?>
                    </td>
                </tr>
                <?php
              }
            }
          ?>
          </tbody>
      </table>
      <div class="tablenav bottom">
          <div class="tablenav-pages">
              <span
                  class="displaying-num"><?php echo sprintf( _n( '%s item', '%s items', sizeof( $list_visa ) ), sizeof( $list_visa ), TRAVELER_PLUGIN_TEXTDOMAIN ) ?></span>
              <?php echo paginate_links( $paging ) ?>
          </div>
      </div>
      <?php wp_reset_query(); ?>
  </form>
  </div>

<?php
} else {
  ?>
  <div class="wrap">
		<?php if ($visa_id > 0) { ?>
			<h2><?php _e( 'Edit VISA', TRAVELER_PLUGIN_TEXTDOMAIN ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add VISA', TRAVELER_PLUGIN_TEXTDOMAIN ) ?></h2>
		<?php } ?>
		<div id="post-body">
      <div id="post-body-content">
        <div class="postbox-container">
          <form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=manage_visa' ) ); ?>">
            <input type="hidden" id="is_save" name="is_save" value="1">
            <input type="hidden" id="visa_id" name="visa_id" value="<?php echo $visa_id; ?>">
            <?php if ($visa_id > 0) { ?>
              <input type="hidden" id="task" name="task" value="edit">
              <input type="hidden" id="start" name="start" value="<?php echo $start; ?>">
            <?php } else { ?>
              <input type="hidden" id="task" name="task" value="add">
              <input type="hidden" id="start" name="start" value="<?php echo $start; ?>">
            <?php } ?>
            <input type="hidden" id="table_name" name="table_name" value="<?php echo esc_attr( $table_name ); ?>">
            <div id="poststuff">
              <div class="postbox">
                <h3 class="hndle"><?php esc_html_e("Visa Information", TRAVELER_PLUGIN_TEXTDOMAIN) ?></h3>
                <div class="inside">
                <table class="form-table">
                  <tbody>
                    <tr>
                      <td><label for="first_name"><?php esc_html_e('First Name', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="first_name" id="first_name" value="<?php echo esc_attr( isset($visa_data['first_name']) ? $visa_data['first_name'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="middle_name"><?php esc_html_e('Middle Name', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="middle_name" id="middle_name" value="<?php echo esc_attr( isset($visa_data['middle_name']) ? $visa_data['middle_name'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="last_name"><?php esc_html_e('Last Name', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="last_name" id="last_name" value="<?php echo esc_attr( isset($visa_data['last_name']) ? $visa_data['last_name'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="birth_day"><?php esc_html_e('Birth Day', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text traveler_plugin_date" type="text" name="birth_day" id="birth_day" value="<?php echo esc_attr( isset($visa_data['birth_day']) ? date('m/d/Y', strtotime($visa_data['birth_day'])) : "" ); ?>" placeholder="<?php esc_attr_e("mm/dd/yyyy", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="gender"><?php esc_html_e('Gender', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <select name="gender" id="gender">
                          <?php foreach ($array_gender as $key => $value ) :?>
                            <option <?php echo esc_attr( (isset($visa_data['gender']) and $visa_data['gender'] == $key) ? " selected" : "" ); ?> value="<?php echo esc_attr($key) ?>"><?php echo esc_html($value); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><label for="email"><?php esc_html_e('Email', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text email" type="email" name="email" id="email" value="<?php echo esc_attr( isset($visa_data['email']) ? $visa_data['email'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="place_of_birth"><?php esc_html_e('Place of Birth', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="place_of_birth" id="place_of_birth" value="<?php echo esc_attr( isset($visa_data['place_of_birth']) ? $visa_data['place_of_birth'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="nationality"><?php esc_html_e('Nationality', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="nationality" id="nationality" value="<?php echo esc_attr( isset($visa_data['nationality']) ? $visa_data['nationality'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="marital_status"><?php esc_html_e('Marital Status', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <select name="marital_status" id="marital_status">
                          <?php foreach ($array_marital_status as $key => $value ) :?>
                            <option <?php echo esc_attr( (isset($visa_data['marital_status']) and $visa_data['marital_status'] == $key ) ? " selected" : "" ); ?> value="<?php echo esc_attr($key) ?>"><?php echo esc_html($value); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><label for="father_first_name"><?php esc_html_e('Father First Name', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="father_first_name" id="father_first_name" value="<?php echo esc_attr( isset($visa_data['father_first_name']) ? $visa_data['father_first_name'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="father_last_name"><?php esc_html_e('Father Last Name', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="father_last_name" id="father_last_name" value="<?php echo esc_attr( isset($visa_data['father_last_name']) ? $visa_data['father_last_name'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="mother_first_name"><?php esc_html_e('Mother First Name', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="mother_first_name" id="mother_first_name" value="<?php echo esc_attr( isset($visa_data['mother_first_name']) ? $visa_data['mother_first_name'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="mother_last_name"><?php esc_html_e('Mother Last Name', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="mother_last_name" id="mother_last_name" value="<?php echo esc_attr( isset($visa_data['mother_last_name']) ? $visa_data['mother_last_name'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="phone_no"><?php esc_html_e('Phone Number', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="number" name="phone_no" id="phone_no" value="<?php echo esc_attr( isset($visa_data['phone_no']) ? $visa_data['phone_no'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="phone_work_no"><?php esc_html_e('Phone Work Number', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="number" name="phone_work_no" id="phone_work_no" value="<?php echo esc_attr( isset($visa_data['phone_work_no']) ? $visa_data['phone_work_no'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="street_address"><?php esc_html_e('Street Address', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="street_address" id="street_address" value="<?php echo esc_attr( isset($visa_data['street_address']) ? $visa_data['street_address'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="apartment_no"><?php esc_html_e('Apartment No', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="" type="text" name="apartment_no" id="apartment_no" value="<?php echo esc_attr( isset($visa_data['apartment_no']) ? $visa_data['apartment_no'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="city"><?php esc_html_e('City', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="city" id="city" value="<?php echo esc_attr( isset($visa_data['city']) ? $visa_data['city'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="zip_code"><?php esc_html_e('Zip Code', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="" type="text" name="zip_code" id="zip_code" value="<?php echo esc_attr( isset($visa_data['zip_code']) ? $visa_data['zip_code'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="country"><?php esc_html_e('Country', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="country" id="country" value="<?php echo esc_attr( isset($visa_data['country']) ? $visa_data['country'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td colspan=2>
                        <button class="button button-primary"><?php esc_html_e("Save change", TRAVELER_PLUGIN_TEXTDOMAIN) ?></button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php
}
?>