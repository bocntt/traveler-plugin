<div class="container">
  <div class="row">
    <div class="col-md-offset-2 col-md-8">
      <div class="row row-wrap">
        <h3><?php echo $attr['title']; ?></h3>
        <div class="entry-content">
          <form onsubmit="return false" id="register-insurance-form" method="post" action="">
            <input type="hidden" name="action" value="register_insurance_form_submit">
            <?php wp_nonce_field('traveler_register_insurance_action', 'register_insurance'); ?>
            <div class="clearfix">
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="first_name"><?php esc_attr_e("First Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                    <input type="text" class="form-control required" value="" name="first_name" id="first_name" placeholder="<?php esc_attr_e("First Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="last_name"><?php esc_attr_e("Last Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                    <input type="text" class="form-control required" value="" name="last_name" id="last_name" placeholder="<?php esc_attr_e("Last Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                    <div class="form-group" data-date-format="mm/dd/yyyy">
                      <label for="birth_day"><?php esc_attr_e("Birthday", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <input type="text" class="form-control required traveler_plugin_date" value="" name="birth_day" id="birth_day" placeholder="<?php esc_attr_e("mm/dd/yyyy", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="gender"><?php esc_attr_e("Gender", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <select name="gender" id="gender" class="form-control required">
                        <?php foreach ($array_gender as $key => $value ) :?>
                          <option <?php echo esc_attr( (isset($insurance_data['gender']) and $insurance_data['gender'] == $key) ? " selected" : "" ); ?> value="<?php echo esc_attr($key) ?>"><?php echo esc_html($value); ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="address"><?php esc_attr_e("Address", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                    <input type="text" class="form-control required" value="" name="address" id="address" placeholder="<?php esc_attr_e("Address", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="phone_number"><?php esc_attr_e("Phone number", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                    <input type="text" class="form-control required" value="" name="phone_number" id="phone_number" placeholder="<?php esc_attr_e("Phone number", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="phone_work_number"><?php esc_attr_e("Phone work number", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                    <input type="text" class="form-control required" value="" name="phone_work_number" id="phone_work_number" placeholder="<?php esc_attr_e("Phone work number", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="email"><?php esc_attr_e("Email", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                    <input type="text" class="form-control required" value="" name="email" id="email" placeholder="<?php esc_attr_e("Email", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="department"><?php esc_attr_e("Department", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                    <input type="text" class="form-control" value="" name="department" id="department" placeholder="<?php esc_attr_e("Department", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="role"><?php esc_attr_e("Role", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                    <select name="role" id="role" class="form-control">
                      <option value="-1"><?php esc_html_e('Select Role', TRAVELER_PLUGIN_TEXTDOMAIN) ?></option>
                      <?php foreach ($array_role as $key => $value ) :?>
                        <option <?php echo esc_attr( (isset($insurance_data['role']) and $insurance_data['role'] == $key) ? " selected" : "" ); ?> value="<?php echo esc_attr($key) ?>"><?php echo esc_html($value); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="number_partner"><?php esc_attr_e("Partner and/or children accompanying (number of)", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                    <input type="text" class="form-control" value="" name="number_partner" id="number_partner">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="number_vacation"><?php esc_attr_e("Number of days as vacation (if any)", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                    <input type="text" class="form-control" value="" name="number_vacation" id="number_vacation" placeholder="<?php esc_attr_e("Vacation", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group" data-date-format="mm/dd/yyyy">
                    <label for="date_of_travel"><?php esc_attr_e("Date of Travel", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                    <input type="text" class="form-control required traveler_plugin_date" value="" name="date_of_travel" id="date_of_travel" placeholder="<?php esc_attr_e("mm/dd/yyyy", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group" data-date-format="mm/dd/yyyy">
                    <label for="date_of_return"><?php esc_attr_e("Date of return", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                    <input type="text" class="form-control required traveler_plugin_date" value="" name="date_of_return" id="date_of_return" placeholder="<?php esc_attr_e("mm/dd/yyyy", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="region"><?php esc_attr_e("Region", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                    <input type="text" class="form-control required" value="" name="region" id="region" placeholder="<?php esc_attr_e("Region", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="country_to_visited"><?php esc_attr_e("Country to be visited", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                    <input type="text" class="form-control required" value="" name="country_to_visited" id="country_to_visited" placeholder="<?php esc_attr_e("Country to be visited", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                  </div>
                </div>
              </div>
              <div class="alert form_alert hidden"></div>
              <a href="#" onclick="return false" class="btn btn-primary btn-register-insurance-submit btn-st-big "><?php _e( 'Submit', ST_TEXTDOMAIN ) ?></a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>