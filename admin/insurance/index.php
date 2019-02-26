<?php
global $table_name;

if ( !class_exists( 'insurance_database' ) ) {
  wp_redirect ( home_url() );
}
$insurance_database = insurance_database::inst();

$page = isset( $_REQUEST['page'] ) ? trim( $_REQUEST['page'] ) : "";
$start = isset( $_REQUEST['start'] ) ? trim( $_REQUEST['start'] ) : 1;
$task = isset( $_REQUEST['task'] ) ? trim( $_REQUEST['task'] ) : "list";
$is_save = isset( $_REQUEST['is_save'] ) ? trim( $_REQUEST['is_save'] ) : 0;
$insurance_id = isset( $_REQUEST['insurance_id'] ) ? trim( $_REQUEST['insurance_id'] ) : 0;
$action = isset( $_REQUEST['action'] ) ? trim( $_REQUEST['action'] ) : "";

$array_gender = array_gender();
$array_marital_status = array_marital_status();

if ( $task == "delete" or $action == "delete" ) {
  $list_insurance_id = isset( $_REQUEST['insurance'] ) ? $_REQUEST['insurance'] : array();
  $insurance_id = isset( $_REQUEST['insurance_id'] ) ? $_REQUEST['insurance_id'] : 0;
  if ( sizeof( $list_insurance_id ) > 0 ) {
    foreach ( $list_insurance_id as $insurance_id ) {
      $insurance_database->delete_insurance( $insurance_id );
    }
  }
  if ( $insurance_id != 0 ) {
    $insurance_database->delete_insurance( $insurance_id );
  }
  $task = 'list';
}

if ($task == 'edit' || $task == 'add') {
  $errors = array();
  $insurance_data = array();
  if (isset($_POST['is_save']) && $_POST['is_save'] == 1) {
    $first_name = isset( $_POST['first_name'] ) ? trim( $_POST['first_name'] ) : "";
    $last_name = isset( $_POST['last_name'] ) ? trim( $_POST['last_name'] ) : "";
    $birth_day = isset( $_POST['birth_day'] ) ? trim( $_POST['birth_day'] ) : "0000-00-00";
    $gender = isset( $_POST['gender'] ) ? trim( $_POST['gender'] ) : "";
    $address = isset( $_POST['address'] ) ? trim( $_POST['address'] ) : "";
    $phone_number = isset( $_POST['phone_number'] ) ? trim( $_POST['phone_number'] ) : "";
    $phone_work_number = isset( $_POST['phone_work_number'] ) ? trim( $_POST['phone_work_number'] ) : "";
    $department = isset( $_POST['department'] ) ? trim( $_POST['department'] ) : "";
    $email = isset( $_POST['email'] ) ? trim( $_POST['email'] ) : "";
    $role = isset( $_POST['role'] ) ? trim( $_POST['role'] ) : "";
    $number_partner = isset( $_POST['number_partner'] ) ? trim( $_POST['number_partner'] ) : "";
    $number_vacation = isset( $_POST['number_vacation'] ) ? trim( $_POST['number_vacation'] ) : "";
    $date_of_travel = isset( $_POST['date_of_travel'] ) ? trim( $_POST['date_of_travel'] ) : "0000-00-00";
    $date_of_return = isset( $_POST['date_of_return'] ) ? trim( $_POST['date_of_return'] ) : "";
    $region = isset( $_POST['region'] ) ? trim( $_POST['region'] ) : "";
    $country_to_visited = isset( $_POST['country_to_visited'] ) ? trim( $_POST['country_to_visited'] ) : "";
    $insurance_data['first_name'] = $first_name;
    $insurance_data['last_name'] = $last_name;
    $insurance_data['birth_day'] = $birth_day;
    $insurance_data['gender'] = $gender;
    $insurance_data['address'] = $address;
    $insurance_data['phone_number'] = $phone_number;
    $insurance_data['phone_work_number'] = $phone_work_number;
    $insurance_data['department'] = $department;
    $insurance_data['email'] = $email;
    $insurance_data['role'] = $role;
    $insurance_data['number_partner'] = $number_partner;
    $insurance_data['number_vacation'] = $number_vacation;
    $insurance_data['date_of_travel'] = $date_of_travel;
    $insurance_data['date_of_return'] = $date_of_return;
    $insurance_data['region'] = $region;
    $insurance_data['country_to_visited'] = $country_to_visited;
    $insurance_data['insurance_id'] = $insurance_id;
    if ($insurance_id > 0) {
      $insurance_database->update_insurance($insurance_data);
      $task = "list";
    }
  } else {
    if ($insurance_id != 0) {
      $insurance_data = $insurance_database->get_insurance_by_insurance_id($insurance_id);
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
  $total_insurance = $insurance_database->get_total_insurance( $array_keyword );
  $limit = 20;
  $offset = ($start - 1) * $limit;
  if ( $offset < 0) $offset = 0;
  $list_insurance = $insurance_database->get_all_insurance( $array_keyword, $limit, $offset );
  $total = ceil( sizeof($list_insurance) / $limit );

  global $wp_query;
  $paging = [];
  $paging[ 'base' ]    = admin_url( 'admin.php?page=manage_insurance%_%' );
  $paging[ 'format' ]  = '&paged=%#%';
  $paging[ 'total' ]   = $total;
  $paging[ 'current' ] = $start;
  $order = ($order == 'ASC') ? 'DESC' : 'ASC';
?>
  <div class="wrap">
    <div id="icon-tools" class="icon32"></div>
    <h2><?php esc_html_e("Manage Insurance", TRAVELER_PLUGIN_TEXTDOMAIN) ?></h2>
    <form id="posts-filter" action="<?php echo admin_url( 'admin.php?page=manage_insurance' ) ?>"
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
                  class="displaying-num"><?php echo sprintf( _n( '%s item', '%s items', sizeof( $list_insurance ) ), sizeof( $list_insurance ), TRAVELER_PLUGIN_TEXTDOMAIN ) ?></span>
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
                <a href="<?php echo esc_url( admin_url("admin.php?page=manage_insurance&orderby=first_name&order=$order") ) ?>">
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
                <?php _e( "Region", TRAVELER_PLUGIN_TEXTDOMAIN ) ?>
              </th>
              <th class="manage-column column-date sortable desc">
                <a href="<?php echo esc_url( admin_url("admin.php?page=manage_insurance&orderby=date&order=$order") ) ?>">
                  <span><?php _e( 'Date', TRAVELER_PLUGIN_TEXTDOMAIN ) ?></span>
                  <span class="sorting-indicator"></span>
                </a>
              </th>
          </tr>
          </thead>
          <tbody>
          <?php
            $i = 0;
            if ( !empty( $list_insurance ) ) {
              foreach ( $list_insurance as $item ) {
                $i++;
                $insurance_id  = $item['insurance_id'];
                $order_id = $insurance_id;
                ?>
                <tr class="<?php if ( $i % 2 == 0 ) echo 'alternate'; ?>">
                    <th scope="row" class="check-column">
                        <input id="cb-select-39" type="checkbox" name="insurance[]"
                              value="<?php echo esc_attr( $insurance_id ) ?>">

                        <div class="locked-indicator"></div>
                    </th>
                    <td class="post-title page-title column-title">
                        <strong><a class="row-title"
                                  href="<?php echo admin_url( 'admin.php?page=manage_insurance&task=edit&insurance_id=' . $insurance_id ); ?>"
                                  title=""><?php
                                    echo esc_html( $item['first_name'] );
                                ?></a></strong>

                        <div class="row-actions">
                            <a href="<?php echo admin_url( 'admin.php?page=manage_insurance&task=edit&insurance_id=' . $insurance_id ); ?>"><?php _e( 'Edit', TRAVELER_PLUGIN_TEXTDOMAIN ) ?></a> |
                            <a href="<?php echo admin_url( 'admin.php?page=manage_insurance&task=delete&insurance_id=' . $insurance_id ); ?>"><?php _e( 'Delete', TRAVELER_PLUGIN_TEXTDOMAIN ) ?></a>
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
                        echo esc_html( $item['phone_number'] );
                      ?>
                    </td>
                    <td class="post-title page-title column-title">
                      <?php
                        echo esc_html( $item['region'] );
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
                  class="displaying-num"><?php echo sprintf( _n( '%s item', '%s items', sizeof( $list_insurance ) ), sizeof( $list_insurance ), TRAVELER_PLUGIN_TEXTDOMAIN ) ?></span>
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
		<?php if ($insurance_id > 0) { ?>
			<h2><?php _e( 'Edit Insurance', TRAVELER_PLUGIN_TEXTDOMAIN ) ?></h2>
		<?php } else { ?>
			<h2><?php _e( 'Add Insurance', TRAVELER_PLUGIN_TEXTDOMAIN ) ?></h2>
		<?php } ?>
		<div id="post-body">
      <div id="post-body-content">
        <div class="postbox-container">
          <form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=manage_insurance' ) ); ?>">
            <input type="hidden" id="is_save" name="is_save" value="1">
            <input type="hidden" id="insurance_id" name="insurance_id" value="<?php echo $insurance_id; ?>">
            <?php if ($insurance_id > 0) { ?>
              <input type="hidden" id="task" name="task" value="edit">
              <input type="hidden" id="start" name="start" value="<?php echo $start; ?>">
            <?php } else { ?>
              <input type="hidden" id="task" name="task" value="add">
              <input type="hidden" id="start" name="start" value="<?php echo $start; ?>">
            <?php } ?>
            <input type="hidden" id="table_name" name="table_name" value="<?php echo esc_attr( $table_name ); ?>">
            <div id="poststuff">
              <div class="postbox">
                <h3 class="hndle"><?php esc_html_e("Register Insurance Information", TRAVELER_PLUGIN_TEXTDOMAIN) ?></h3>
                <div class="inside">
                <table class="form-table">
                  <tbody>
                    <tr>
                      <td><label for="first_name"><?php esc_html_e('First Name', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="first_name" id="first_name" value="<?php echo esc_attr( isset($insurance_data['first_name']) ? $insurance_data['first_name'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="last_name"><?php esc_html_e('Last Name', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="last_name" id="last_name" value="<?php echo esc_attr( isset($insurance_data['last_name']) ? $insurance_data['last_name'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="birth_day"><?php esc_html_e('Birth Day', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text traveler_plugin_date" type="text" name="birth_day" id="birth_day" value="<?php echo esc_attr( isset($insurance_data['birth_day']) ? $insurance_data['birth_day'] : "" ); ?>" placeholder="<?php esc_attr_e("mm/dd/yyyy", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="gender"><?php esc_html_e('Gender', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <select name="gender" id="gender">
                          <?php foreach ($array_gender as $key => $value ) :?>
                            <option <?php echo esc_attr( (isset($insurance_data['gender']) and $insurance_data['gender'] == $key) ? " selected" : "" ); ?> value="<?php echo esc_attr($key) ?>"><?php echo esc_html($value); ?></option>
                          <?php endforeach; ?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td><label for="address"><?php esc_html_e('Address', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text address" type="text" name="address" id="address" value="<?php echo esc_attr( isset($insurance_data['address']) ? $insurance_data['address'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="phone_number"><?php esc_html_e('Phone number', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="phone_number" id="phone_number" value="<?php echo esc_attr( isset($insurance_data['phone_number']) ? $insurance_data['phone_number'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="phone_work_number"><?php esc_html_e('Phone work number', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="phone_work_number" id="phone_work_number" value="<?php echo esc_attr( isset($insurance_data['phone_work_number']) ? $insurance_data['phone_work_number'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="department"><?php esc_html_e('Department', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="department" id="department" value="<?php echo esc_attr( isset($insurance_data['department']) ? $insurance_data['department'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="email"><?php esc_html_e('Email', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text email" type="text" name="email" id="email" value="<?php echo esc_attr( isset($insurance_data['email']) ? $insurance_data['email'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="role"><?php esc_html_e('Role', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="role" id="role" value="<?php echo esc_attr( isset($insurance_data['role']) ? $insurance_data['role'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="number_partner"><?php esc_html_e('Number Partner', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="number" name="number_partner" id="number_partner" value="<?php echo esc_attr( isset($insurance_data['number_partner']) ? $insurance_data['number_partner'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="number_vacation"><?php esc_html_e('Number vacation', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="number" name="number_vacation" id="number_vacation" value="<?php echo esc_attr( isset($insurance_data['number_vacation']) ? $insurance_data['number_vacation'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="date_of_travel"><?php esc_html_e('Date of travel', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text traveler_plugin_date" type="text" name="date_of_travel" id="date_of_travel" value="<?php echo esc_attr( isset($insurance_data['date_of_travel']) ? $insurance_data['date_of_travel'] : "" ); ?>" placeholder="<?php esc_attr_e("mm/dd/yyyy", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="date_of_return"><?php esc_html_e('Date of return', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text traveler_plugin_date" type="text" name="date_of_return" id="date_of_return" value="<?php echo esc_attr( isset($insurance_data['date_of_return']) ? $insurance_data['date_of_return'] : "" ); ?>" placeholder="<?php esc_attr_e("mm/dd/yyyy", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="region"><?php esc_html_e('Region', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="region" id="region" value="<?php echo esc_attr( isset($insurance_data['region']) ? $insurance_data['region'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td><label for="country_to_visited"><?php esc_html_e('Country to be visited', TRAVELER_PLUGIN_TEXTDOMAIN ); ?></label></td>
                      <td>
                        <input class="regular-text" type="text" name="country_to_visited" id="country_to_visited" value="<?php echo esc_attr( isset($insurance_data['country_to_visited']) ? $insurance_data['country_to_visited'] : "" ); ?>">
                      </td>
                    </tr>
                    <tr>
                      <td colspan=2>
                        <button class="button button-primary"><?php esc_html_e('Save change', TRAVELER_PLUGIN_TEXTDOMAIN)?></button>
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