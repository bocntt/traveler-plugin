<div class="container">
  <div class="row">
    <div class="col-md-offset-2 col-md-8">
      <div class="row row-wrap">
        <h3><?php echo $attr['title']; ?></h3>
        <div class="entry-content">
          <form onsubmit="return false" id="register-visa-form" method="post" action="">
            <input type="hidden" name="action" value="register_visa_form_submit">
            <?php wp_nonce_field( 'traveler_register_visa_action', 'register_visa' ); ?>
            <div class="clearfix">
              <div class="row">
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="first_name"><?php esc_attr_e("First Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                    <input type="text" class="form-control required" value="" name="first_name" id="first_name" placeholder="<?php esc_attr_e("First Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="middle_name"><?php esc_attr_e("Middle Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                    <input type="text" class="form-control" value="" name="middle_name" id="middle_name" placeholder="<?php esc_attr_e("Middle Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label for="last_name"><?php esc_attr_e("Last Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                    <input type="text" class="form-control required" value="" name="last_name" id="last_name" placeholder="<?php esc_attr_e("Last Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="birth_day"><?php esc_attr_e("Birthday", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <input type="text" class="form-control required traveler_plugin_date" value="" name="birth_day" id="birth_day" placeholder="<?php esc_attr_e("Birthday", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="gender"><?php esc_attr_e("Gender", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <select name="gender" id="gender" class="form-control required">
                        <?php foreach ($array_gender as $key => $value ) :?>
                          <option <?php echo esc_attr( (isset($visa_data['gender']) and $visa_data['gender'] == $key) ? " selected" : "" ); ?> value="<?php echo esc_attr($key) ?>"><?php echo esc_html($value); ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="email"><?php esc_attr_e("Email", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <input type="text" class="form-control required" value="" name="email" id="email" placeholder="<?php esc_attr_e("Email", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="place_of_birth"><?php esc_attr_e("Place of Birth", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <input type="text" class="form-control" value="" name="place_of_birth" id="place_of_birth" placeholder="<?php esc_attr_e("Place of Birth", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="nationality"><?php esc_attr_e("Nationality", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <input type="text" class="form-control required" value="" name="nationality" id="nationality" placeholder="<?php esc_attr_e("Nationality", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="marital_status"><?php esc_attr_e("Marital Status", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <select name="marital_status" id="marital_status" class="form-control">
                        <?php foreach ($array_marital_status as $key => $value ) :?>
                          <option <?php echo esc_attr( (isset($visa_data['marital_status']) and $visa_data['marital_status'] == $key ) ? " selected" : "" ); ?> value="<?php echo esc_attr($key) ?>"><?php echo esc_html($value); ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="father_first_name"><?php esc_attr_e("Father First Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <input type="text" class="form-control" value="" name="father_first_name" id="father_first_name" placeholder="<?php esc_attr_e("Father First Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="father_last_name"><?php esc_attr_e("Father Last Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <input type="text" class="form-control" value="" name="father_last_name" id="father_last_name" placeholder="<?php esc_attr_e("Father Last Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="mother_first_name"><?php esc_attr_e("Mother First Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <input type="text" class="form-control" value="" name="mother_first_name" id="mother_first_name" placeholder="<?php esc_attr_e("Mother First Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="mother_last_name"><?php esc_attr_e("Mother Last Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <input type="text" class="form-control" value="" name="mother_last_name" id="mother_last_name" placeholder="<?php esc_attr_e("Mother Last Name", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="phone_no"><?php esc_attr_e("Phone No.", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <input type="text" class="form-control required" value="" name="phone_no" id="phone_no" placeholder="<?php esc_attr_e("Phone No.", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="phone_work_no"><?php esc_attr_e("Phone Work No.", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <input type="text" class="form-control" value="" name="phone_work_no" id="phone_work_no" placeholder="<?php esc_attr_e("Phone Work No.", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="street_address"><?php esc_attr_e("Street Address", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <input type="text" class="form-control required" value="" name="street_address" id="street_address" placeholder="<?php esc_attr_e("Street Address", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="apartment_no"><?php esc_attr_e("Apartment No.", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <input type="text" class="form-control required" value="" name="apartment_no" id="apartment_no" placeholder="<?php esc_attr_e("Apartment No.", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="city"><?php esc_attr_e("City", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <input type="text" class="form-control required" value="" name="city" id="city" placeholder="<?php esc_attr_e("City", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="zip_code"><?php esc_attr_e("Zipcode", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <input type="text" class="form-control" value="" name="zip_code" id="zip_code" placeholder="<?php esc_attr_e("Zipcode", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                      <label for="country"><?php esc_attr_e("Country", TRAVELER_PLUGIN_TEXTDOMAIN) ?></label>
                      <input type="text" class="form-control required" value="" name="country" id="country" placeholder="<?php esc_attr_e("Country", TRAVELER_PLUGIN_TEXTDOMAIN) ?>">
                    </div>
                </div>
                <div class="col-sm-6">
                </div>
              </div>
              <div class="alert form_alert hidden"></div>
              <a href="#" onclick="return false" class="btn btn-primary btn-register-visa-submit btn-st-big "><?php _e( 'Submit', ST_TEXTDOMAIN ) ?></a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>