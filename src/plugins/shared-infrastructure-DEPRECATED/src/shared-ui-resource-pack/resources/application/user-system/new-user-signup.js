//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// New User Signup Form
// ────────────────────
//
// noinspection ES6ConvertVarToLetConst, UnnecessaryLocalVariableJS, UnnecessaryLocalVariableJS
//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━


// noinspection JSUnusedAssignment
if(typeof SharedUI === 'undefined' || SharedUI === null || SharedUI === false){
    var SharedUI = {};
}


if(typeof SharedUI.NewUserSignupForm === 'undefined' || SharedUI.NewUserSignupForm === null || SharedUI.NewUserSignupForm === false){
    SharedUI.NewUserSignupForm = {};
}


// Construct
SharedUI.NewUserSignupForm.construct = function(){
    let self = SharedUI.NewUserSignupForm;

    // Set properties
    self.is_first_username_search = true;
    self.is_first_callout_pop     = true;

    // Listen for events
    self.listen();
}


// Listen
SharedUI.NewUserSignupForm.listen = function(){
    let self = SharedUI.NewUserSignupForm;

    // Field focus/blur events
    Ox.Event.delegate('[data-shared-ui-focus-event="shared-ui.new-user-signup-form >>> on-field-focus"]', 'focus', self.handleOnFieldFocus);
    Ox.Event.delegate('[data-shared-ui-blur-event="shared-ui.new-user-signup-form >>> on-field-blur"]', 'blur', self.handleOnFieldBlur);

    // Password show/hide events
    Ox.Event.delegate('[data-shared-ui-click-event="shared-ui.new-user-signup-form >>> on-password-eye-click"]', 'click', self.handleOnPasswordEyeClick);

    // Events while typing in fields
    Ox.Event.delegate('[data-shared-ui-input-event="shared-ui.new-user-signup-form >>> on-username-field-input"]', 'input', self.handleOnUsernameFieldInput);
    Ox.Event.delegate('[data-shared-ui-input-event="shared-ui.new-user-signup-form >>> on-email-address-field-input"]', 'input', self.handleOnEmailAddressFieldInput);
    Ox.Event.delegate('[data-shared-ui-input-event="shared-ui.new-user-signup-form >>> on-birthday-field-input"]', 'input', self.handleOnBirthdayFieldInput);
    Ox.Event.delegate('[data-shared-ui-input-event="shared-ui.new-user-signup-form >>> on-password-field-input"]', 'input', self.handleOnPasswordFieldInput);
    Ox.Event.delegate('[data-shared-ui-input-event="shared-ui.new-user-signup-form >>> on-confirm-password-field-input"]', 'input', self.handleOnConfirmPasswordFieldInput);

    // Events on button click
    Ox.Event.delegate('[data-shared-ui-click-event="shared-ui.new-user-signup-form >>> on-click-check-username-availability-button"]', 'click', self.handleOnClickCheckUsernameAvailabilityButton);
    Ox.Event.delegate('[data-shared-ui-click-event="shared-ui.new-user-signup-form >>> submit"]', 'click', self.handleOnSubmit);
}


// Refresh Field Validity Icon
SharedUI.NewUserSignupForm.refreshFieldValidityIcon = function(field_element){
    let self                = SharedUI.NewUserSignupForm;
    let field               = $(field_element);
    let validity_icon       = field.find('[data-section-item-type="field-icon-after"]').first();
    let display_as_valid_yn = field.attr('data-display-as-valid');
    let display_as_valid    = display_as_valid_yn === 'yes';
    let is_valid            = display_as_valid;

    if(is_valid){
        // Change ex to check
        validity_icon.removeClass('bi-x-lg');
        validity_icon.addClass('bi-check-lg');

        // Change color to green
        validity_icon.attr('data-ox-text-color', 'tw-green-500')
    }
    else{
        // Change check to ex
        validity_icon.removeClass('bi-check-lg');
        validity_icon.addClass('bi-x-lg');

        // Change color to red
        validity_icon.attr('data-ox-text-color', 'tw-red-500');
    }

    // Show the validity icon
    validity_icon.attr('data-show', 'yes');
}

// Is Valid Email Address
SharedUI.NewUserSignupForm.isValidEmailAddress = function(given_email_address){
    let expression = /\S+@\S+\.\S+/;
    return expression.test(given_email_address);
}

// Is Valid Birthday
SharedUI.NewUserSignupForm.isValidBirthday = function(given_date_string){
    let self               = SharedUI.NewUserSignupForm;
    let is_valid           = false;
    let input_mask_utility = SharedUI.InputMaskUtility;
    let date_number_chars  = input_mask_utility.filterToAllowedChars(given_date_string, '0123456789');
    let is_date_filled     = date_number_chars.length === 8;
    let is_too_new         = false;
    let year_exists        = false;
    let month_exists       = false;
    let day_exists         = false;

    // Check year
    if(is_date_filled){
        let year_chars       = date_number_chars.slice(-4);
        let year_int         = parseInt(year_chars);
        let current_year_int = Number(new Date().getFullYear());
        let year_19_ago_int  = current_year_int - 19;

        year_exists = year_int >= 1900 && year_int <= current_year_int;

        if(!year_exists){
            self.changeBirthdayRightIcon(true, 'bad year');
            return false;
        }

        is_too_new = year_int > year_19_ago_int;

        if(is_too_new){
            self.changeBirthdayRightIcon(true, 'too young');
            return false;
        }

        let month_chars = date_number_chars.substring(0,2);
        let month_int   = parseInt(month_chars);

        month_exists = month_int > 0 && month_int < 13;

        if(!month_exists){
            self.changeBirthdayRightIcon(true, 'bad month');
            return false;
        }

        // Check day
        let day_chars          = date_number_chars.substring(2,4);
        let day_int            = parseInt(day_chars);
        let max_days_in_months = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        let max_day_in_months  = max_days_in_months[month_int - 1];

        day_exists = day_int > 0 && day_int <= max_day_in_months;

        if(!day_exists){
            self.changeBirthdayRightIcon(true, 'bad day');
            return false;
        }
    }

    is_valid = is_date_filled && !is_too_new && month_exists && day_exists;

    // Change icon
    self.changeBirthdayRightIcon(false);

    // Return true if valid, false if invalid
    return is_valid;
}

// Change Birthday Right Icon
SharedUI.NewUserSignupForm.changeBirthdayRightIcon = function(show= false, reason= ''){
    let section             = $('[data-section="shared-ui-new-user-signup-form"]');
    let form                = section.find('[data-section-item-type="form"]').first();
    let birthday_field      = form.find('[data-section-item="date-of-birth-field"]').first();
    let birthday_right_icon = birthday_field.find('[data-section-item-type="field-icon-right"]').first();

    if(show){
        // Select icon by the reason
        if(reason === 'too young'){
            birthday_right_icon.removeClass('bi-calendar-x');
            birthday_right_icon.removeClass('bi-x-lg');
            birthday_right_icon.addClass('bi-arrow-bar-down');
        }
        else if(reason === 'bad month'){
            birthday_right_icon.removeClass('bi-arrow-bar-down');
            birthday_right_icon.removeClass('bi-x-lg');
            birthday_right_icon.addClass('bi-calendar-x');
        }
        else if(reason === 'bad day'){
            birthday_right_icon.removeClass('bi-arrow-bar-down');
            birthday_right_icon.removeClass('bi-x-lg');
            birthday_right_icon.addClass('bi-calendar-x');
        }
        else if(reason === 'bad year'){
            birthday_right_icon.removeClass('bi-arrow-bar-down');
            birthday_right_icon.removeClass('bi-x-lg');
            birthday_right_icon.addClass('bi-calendar-x');
        }

        // Change color to red
        birthday_right_icon.attr('data-ox-text-color', 'tw-red-500');

        // Show the icon
        birthday_right_icon.attr('data-show', 'yes');
    }
    else{
        // Hide the icon
        birthday_right_icon.attr('data-show', 'no');
    }
}


// Is Valid Password To Use
SharedUI.NewUserSignupForm.isValidPasswordToUse = function(given_password_string){
    let is_valid               = false;
    let is_too_short           = given_password_string.length < 10;
    let password_no_whitespace = given_password_string.replace(/\s+/g, '');
    let has_whitespace         = given_password_string.length !== password_no_whitespace.length;
    let has_comma              = given_password_string.includes(',');

    // Check if valid
    is_valid = !is_too_short && !has_whitespace && !has_comma;

    // Return true if valid, false if invalid
    return is_valid;
}



// Is Valid Confirm Password Text
SharedUI.NewUserSignupForm.isValidConfirmPasswordText = function(given_confirm_password_string){
    let section         = $('[data-section="shared-ui-new-user-signup-form"]');
    let form            = section.find('[data-section-item-type="form"]').first();
    let password_field  = form.find('[data-section-item="password-field"]').first();
    let password_input  = password_field.find('[data-section-item="password-input"]').first();
    let password_string = password_input.val();
    let is_empty        = !(password_string.length > 0);

    // Check if valid
    let is_valid = !is_empty && (given_confirm_password_string === password_string);

    // Return true if valid, false if invalid
    return is_valid;
}



// Handle On Field Focus
SharedUI.NewUserSignupForm.handleOnFieldFocus = function(element, event){
    let self    = SharedUI.NewUserSignupForm;
    let textbox = $(element);
    let field   = textbox.parent();
    let callout = field.find('[data-section-item-type="field-callout"]').first();

    // Show the callout
    if(self.is_first_callout_pop){
        callout.css('opacity', 0.0);
        callout.attr('data-show', 'yes');
        callout.animate({ opacity: 1.0},1000, function(){});

        self.is_first_callout_pop = false;
    }
    else{
        callout.css('opacity', 1.0);
        callout.attr('data-show', 'yes');
    }


    // Refresh the validity icon
    self.refreshFieldValidityIcon(field);
}


// Handle On Field Blur
SharedUI.NewUserSignupForm.handleOnFieldBlur = function(element, event){
    let self    = SharedUI.NewUserSignupForm;
    let textbox = $(element);
    let field   = textbox.parent();
    let callout = field.find('[data-section-item-type="field-callout"]').first();

    // Hide the callout
    //callout.animate({ opacity: 0.0},180, function(){
    //    callout.attr('data-show', 'no');
    //});
    callout.attr('data-show', 'no');
}


// Handle On Password-Eye Click
SharedUI.NewUserSignupForm.handleOnPasswordEyeClick = function(element, event){
    let self                   = SharedUI.NewUserSignupForm;
    let eye                    = $(element);
    let field                  = eye.parent().closest('[data-section-item-type="field"]');
    let form                   = field.parent().closest('[data-section-item-type="form"]');
    let show_form_passwords_yn = form.attr('data-form-show-passwords');
    let show_form_passwords    = show_form_passwords_yn === 'yes';
    let eyes                   = form.find('[data-section-item-role="password-eye"]');
    let password_input         = form.find('[data-section-item="password-input"]').first();
    let confirm_password_input = form.find('[data-section-item="confirm-password-input"]').first();

    // Toggle Eyes
    if(show_form_passwords){
        // Hide passwords:

        // Remove slashes from the eye icons
        eyes.removeClass('bi-eye-slash');
        eyes.addClass('bi-eye');

        // Change the password input types
        password_input.attr('type', 'password');
        confirm_password_input.attr('type', 'password');

        // Change the form's show-passwords value
        form.attr('data-form-show-passwords', 'no');
    }
    else{
        // Show passwords:

        // Add slashes to the eye icons
        eyes.removeClass('bi-eye');
        eyes.addClass('bi-eye-slash');

        // Change the password input types
        password_input.attr('type', 'text');
        confirm_password_input.attr('type', 'text');

        // Change the form's show-passwords value
        form.attr('data-form-show-passwords', 'yes');
    }
}

// Handle On Email Address Field Input
SharedUI.NewUserSignupForm.handleOnEmailAddressFieldInput = function(element, event){
    let self     = SharedUI.NewUserSignupForm;
    let textbox  = $(element);
    let field    = textbox.parent().closest('[data-section-item-type="field"]');
    let text     = textbox.val();
    let is_valid = self.isValidEmailAddress(text);

    if(is_valid){
        field.attr('data-display-as-valid', 'yes');
    }
    else{
        field.attr('data-display-as-valid', 'no');
    }

    // Refresh the validity icon
    self.refreshFieldValidityIcon(field);
}

// Handle On Birthday Field Input
SharedUI.NewUserSignupForm.handleOnBirthdayFieldInput = function(element, event){
    let self     = SharedUI.NewUserSignupForm;
    let textbox  = $(element);
    let field    = textbox.parent().closest('[data-section-item-type="field"]');
    let text     = textbox.val();
    let is_valid = self.isValidBirthday(text);

    if(is_valid){
        field.attr('data-display-as-valid', 'yes');
    }
    else{
        field.attr('data-display-as-valid', 'no');
    }

    // Refresh the validity icon
    self.refreshFieldValidityIcon(field);
}

// Handle On Password Field Input
SharedUI.NewUserSignupForm.handleOnPasswordFieldInput = function(element, event){
    let self     = SharedUI.NewUserSignupForm;
    let textbox  = $(element);
    let field    = textbox.parent().closest('[data-section-item-type="field"]');
    let text     = textbox.val();
    let is_valid = self.isValidPasswordToUse(text);

    if(is_valid){
        field.attr('data-display-as-valid', 'yes');
    }
    else{
        field.attr('data-display-as-valid', 'no');
    }

    // Refresh the validity icon
    self.refreshFieldValidityIcon(field);

    // Re-run validation on confirm password field
    self.triggerHandleOnConfirmPasswordFieldInput();
}



// Handle On Confirm Password Field Input
SharedUI.NewUserSignupForm.handleOnConfirmPasswordFieldInput = function(element, event){
    let self     = SharedUI.NewUserSignupForm;
    let textbox  = $(element);
    let field    = textbox.parent().closest('[data-section-item-type="field"]');
    let text     = textbox.val();
    let is_valid = self.isValidConfirmPasswordText(text);

    if(is_valid){
        field.attr('data-display-as-valid', 'yes');
    }
    else{
        field.attr('data-display-as-valid', 'no');
    }

    // Refresh the validity icon
    self.refreshFieldValidityIcon(field);
}


// Trigger Handle On Confirm Password Field Input
SharedUI.NewUserSignupForm.triggerHandleOnConfirmPasswordFieldInput = function(){
    let self                   = SharedUI.NewUserSignupForm;
    let section                = $('[data-section="shared-ui-new-user-signup-form"]');
    let form                   = section.find('[data-section-item-type="form"]').first();
    let confirm_password_field = form.find('[data-section-item="confirm-password-field"]').first();
    let confirm_password_input = confirm_password_field.find('[data-section-item="confirm-password-input"]').first();

    // Trigger event
    self.handleOnConfirmPasswordFieldInput(confirm_password_input, null);
}

// Handle On Username Field Input
SharedUI.NewUserSignupForm.handleOnUsernameFieldInput = function(element, event){
    let self                       = SharedUI.NewUserSignupForm;
    let textbox                    = $(element);
    let field                      = textbox.parent().closest('[data-section-item-type="field"]');
    let text                       = textbox.val();
    let is_valid                   = false;
    let is_empty                   = text.length < 1;
    let section                    = $('[data-section="shared-ui-new-user-signup-form"]');
    let form                       = section.find('[data-section-item-type="form"]').first();
    let lookup_area                = form.find('[data-section-item="username-availability-lookup-area"]').first();
    let text_checking_availability = lookup_area.find('[data-section-item="username-availability-text-checking-availability"]');
    let text_username_unavailable  = lookup_area.find('[data-section-item="username-availability-text-username-unavailable"]');
    let text_username_available    = lookup_area.find('[data-section-item="username-availability-text-username-available"]');
    let text_username_bad_format   = lookup_area.find('[data-section-item="username-availability-text-incorrect-format"]');
    let text_username_reserved     = lookup_area.find('[data-section-item="username-availability-text-name-reserved"]');

    let mask = self.getMaskedUsername(text);
    textbox.val(mask);

    is_empty = mask.length < 1;

    if(is_empty){
        // self.removeRightIconFromUsernameField();

        // self.hideUsernameAvailabilityLookupArea();
    }
    else{
        // self.addHourglassToUsernameField();

        self.showUsernameAvailabilityLookupArea();

        text_checking_availability.animate({ opacity: 0.0},600, function(){});
        text_username_unavailable.animate({ opacity: 0.0},600, function(){});
        text_username_available.animate({ opacity: 0.0},600, function(){});
        text_username_bad_format.animate({ opacity: 0.0},600, function(){});
        text_username_reserved.animate({ opacity: 0.0},600, function(){});
    }


    if(is_valid){
        field.attr('data-display-as-valid', 'yes');
    }
    else{
        field.attr('data-display-as-valid', 'no');
    }

    // Refresh the validity icon
    self.refreshFieldValidityIcon(field);
}

SharedUI.NewUserSignupForm.addHourglassToUsernameField = function(){
    let self                = SharedUI.NewUserSignupForm;
    let section             = $('[data-section="shared-ui-new-user-signup-form"]');
    let form                = section.find('[data-section-item-type="form"]').first();
    let username_field      = form.find('[data-section-item="username-field"]').first();
    let username_right_icon = username_field.find('[data-section-item-type="field-icon-right"]').first();

    // Swap icon
    username_right_icon.removeClass('bi-x-lg');
    username_right_icon.addClass('bi');
    username_right_icon.addClass('bi-hourglass-split');

    // Change color
    username_right_icon.attr('data-ox-text-color', 'tw-slate-400');

    // Show
    username_right_icon.attr('data-show', 'yes');
}


SharedUI.NewUserSignupForm.removeRightIconFromUsernameField = function(){
    let self                = SharedUI.NewUserSignupForm;
    let section             = $('[data-section="shared-ui-new-user-signup-form"]');
    let form                = section.find('[data-section-item-type="form"]').first();
    let username_field      = form.find('[data-section-item="username-field"]').first();
    let username_right_icon = username_field.find('[data-section-item-type="field-icon-right"]').first();

    // Hide
    username_right_icon.attr('data-show', 'no');
}

SharedUI.NewUserSignupForm.showUsernameAvailabilityLookupArea = function(){
    let self        = SharedUI.NewUserSignupForm;
    let section     = $('[data-section="shared-ui-new-user-signup-form"]');
    let form        = section.find('[data-section-item-type="form"]').first();
    let lookup_area = form.find('[data-section-item="username-availability-lookup-area"]').first();

    self.is_first_username_search = true;

    // Show
    lookup_area.slideDown( 400, function() {
        lookup_area.animate({ opacity: 1.0 }, 600);
    });

}

SharedUI.NewUserSignupForm.hideUsernameAvailabilityLookupArea = function(){
    let self                       = SharedUI.NewUserSignupForm;
    let section                    = $('[data-section="shared-ui-new-user-signup-form"]');
    let form                       = section.find('[data-section-item-type="form"]').first();
    let lookup_area                = form.find('[data-section-item="username-availability-lookup-area"]').first();
    let text_checking_availability = lookup_area.find('[data-section-item="username-availability-text-checking-availability"]');
    let text_username_unavailable  = lookup_area.find('[data-section-item="username-availability-text-username-unavailable"]');
    let text_username_available    = lookup_area.find('[data-section-item="username-availability-text-username-available"]');
    let text_username_bad_format   = lookup_area.find('[data-section-item="username-availability-text-incorrect-format"]');
    let text_username_reserved     = lookup_area.find('[data-section-item="username-availability-text-name-reserved"]');

    // Hide
    lookup_area.animate({ opacity: 0.0},600, function(){
        lookup_area.slideUp( 400, function() {
            // Hide labels
            text_checking_availability.attr('data-show', 'no');
            text_username_unavailable.attr('data-show', 'no');
            text_username_available.attr('data-show', 'no');
            text_username_bad_format.attr('data-show', 'no');
            text_username_reserved.attr('data-show', 'no');
        });
    });
}


// Handle On Click Check Username Availability Button
SharedUI.NewUserSignupForm.handleOnClickCheckUsernameAvailabilityButton = function(element, event){
    let self                       = SharedUI.NewUserSignupForm;
    let button_div                 = $(element);
    let section                    = $('[data-section="shared-ui-new-user-signup-form"]');
    let form                       = section.find('[data-section-item-type="form"]').first();
    let lookup_area                = form.find('[data-section-item="username-availability-lookup-area"]').first();
    let text_checking_availability = lookup_area.find('[data-section-item="username-availability-text-checking-availability"]');
    let text_username_unavailable  = lookup_area.find('[data-section-item="username-availability-text-username-unavailable"]');
    let text_username_available    = lookup_area.find('[data-section-item="username-availability-text-username-available"]');
    let text_username_bad_format   = lookup_area.find('[data-section-item="username-availability-text-incorrect-format"]');
    let text_username_reserved     = lookup_area.find('[data-section-item="username-availability-text-name-reserved"]');
    let username_field             = form.find('[data-section-item="username-field"]').first();
    let username_input             = username_field.find('input[type="text"]').first();
    let given_username             = username_input.val();
    let starting_delay             = self.is_first_username_search ? 0 : 605

    if(self.is_first_username_search){
        text_checking_availability.css('opacity', 0.0);
        text_username_unavailable.css('opacity', 0.0);
        text_username_available.css('opacity', 0.0);
        text_username_bad_format.css('opacity', 0.0);
        text_username_reserved.css('opacity', 0.0);
    }
    else{
        text_checking_availability.animate({ opacity: 0.0},600, function(){});
        text_username_unavailable.animate({ opacity: 0.0},600, function(){});
        text_username_available.animate({ opacity: 0.0},600, function(){});
        text_username_bad_format.animate({ opacity: 0.0},600, function(){});
        text_username_reserved.animate({ opacity: 0.0},600, function(){});
    }


    setTimeout(() => {
        self.is_first_username_search = false

        self.addHourglassToUsernameField();

        // Hide labels
        text_checking_availability.attr('data-show', 'no');
        text_username_unavailable.attr('data-show', 'no');
        text_username_available.attr('data-show', 'no');
        text_username_bad_format.attr('data-show', 'no');
        text_username_reserved.attr('data-show', 'no');

        // Show checking availability
        text_checking_availability.css('opacity', 0.0);
        text_checking_availability.attr('data-show', 'yes');
        text_checking_availability.animate({ opacity: 1.0},600, function(){
            // Make an ajax request
            let jqxhr = $.post( "/ajax/user-system/is-username-available", { username: given_username}, function() {
                // Do nothing for now
            }).done(function(data) {
                text_checking_availability.animate({ opacity: 0.0},600, function(){
                    self.removeRightIconFromUsernameField();

                    let message_status     = data.hasOwnProperty('message_status') ? data.message_status : 'error';
                    let is_message_success = message_status === 'success';

                    if(is_message_success){
                        // Get the dataset
                        let dataset = data.hasOwnProperty('data') ? data.data : {};

                        // Get info
                        let is_username_available_yn = dataset.hasOwnProperty('is_available') ? dataset.is_available : 'no';
                        let is_username_available    = is_username_available_yn === 'yes';
                        let fail_reason              = dataset.hasOwnProperty('fail_reason') ? dataset.fail_reason : '';

                        if(is_username_available){
                            // Hide text labels
                            text_checking_availability.attr('data-show', 'no');
                            text_username_unavailable.attr('data-show', 'no');
                            text_username_available.attr('data-show', 'no');
                            text_username_bad_format.attr('data-show', 'no');
                            text_username_reserved.attr('data-show', 'no');

                            // Show username available text label
                            text_username_available.css('opacity', 0.0);
                            text_username_available.attr('data-show', 'yes');
                            text_username_available.animate({ opacity: 1.0},600, function(){
                                // Mark as valid
                                username_field.attr('data-display-as-valid', 'yes');

                                // Refresh the validity icon
                                self.refreshFieldValidityIcon(username_field);

                                setTimeout(() => {
                                    self.hideUsernameAvailabilityLookupArea();
                                }, 600);
                            });
                        }
                        else{
                            // Hide text labels
                            text_checking_availability.attr('data-show', 'no');
                            text_username_unavailable.attr('data-show', 'no');
                            text_username_available.attr('data-show', 'no');
                            text_username_bad_format.attr('data-show', 'no');
                            text_username_reserved.attr('data-show', 'no');



                            if(
                                fail_reason === 'incorrect-format'
                                || fail_reason === 'starts-with-underscore'
                                || fail_reason === 'ends-with-underscore'
                                || fail_reason === 'has-double-underscore'
                            ){
                                text_username_bad_format.html('Incorrect format.');
                                if(fail_reason === 'starts-with-underscore'){
                                    text_username_bad_format.html('Cannot start<br> with underscore.');
                                }
                                if(fail_reason === 'ends-with-underscore'){
                                    text_username_bad_format.html('Cannot end<br> with underscore.');
                                }
                                if(fail_reason === 'has-double-underscore'){
                                    text_username_bad_format.html('Cannot have<br> double-underscore.');
                                }

                                text_username_bad_format.css('opacity', 0.0);
                                text_username_bad_format.attr('data-show', 'yes');
                                text_username_bad_format.animate({ opacity: 1.0},600, function(){
                                    // do nothing for now
                                });
                            }
                            else if(fail_reason === 'reserved-name' || fail_reason === 'reserved-name-with-number'){
                                text_username_reserved.html('Reserved name.');
                                if(fail_reason === 'reserved-name-with-number'){
                                    text_username_reserved.html('Reserved name<br> with number.');
                                }

                                text_username_reserved.css('opacity', 0.0);
                                text_username_reserved.attr('data-show', 'yes');
                                text_username_reserved.animate({ opacity: 1.0},600, function(){
                                    // do nothing for now
                                });
                            }
                            else{
                                text_username_unavailable.css('opacity', 0.0);
                                text_username_unavailable.attr('data-show', 'yes');
                                text_username_unavailable.animate({ opacity: 1.0},600, function(){
                                    // do nothing for now
                                });
                            }
                        }
                    }
                });
            }).fail(function() {
                //alert( "error" );
            }).always(function() {
                //alert( "finished" );
            });
        });
    }, starting_delay);
}


// Handle On Submit
SharedUI.NewUserSignupForm.handleOnSubmit = function(element, event){
    let self                               = SharedUI.NewUserSignupForm;
    let button_div                         = $(element);
    let section                            = $('[data-section="shared-ui-new-user-signup-form"]');
    let section_content                    = section.find('[data-section-item="section-content"]').first();
    let section_loading_screen             = section.find('[data-section-item="section-loading"]').first();
    let form                               = section.find('[data-section-item-type="form"]').first();
    let username_field                     = form.find('[data-section-item="username-field"]').first();
    let email_address_field                = form.find('[data-section-item="email-address-field"]').first();
    let birthday_field                     = form.find('[data-section-item="date-of-birth-field"]').first();
    let password_field                     = form.find('[data-section-item="password-field"]').first();
    let confirm_password_field             = form.find('[data-section-item="confirm-password-field"]').first();
    let is_username_field_valid_yn         = username_field.attr('data-display-as-valid');
    let is_email_address_field_valid_yn    = email_address_field.attr('data-display-as-valid');
    let is_birthday_field_valid_yn         = birthday_field.attr('data-display-as-valid');
    let is_password_field_valid_yn         = password_field.attr('data-display-as-valid');
    let is_confirm_password_field_valid_yn = confirm_password_field.attr('data-display-as-valid');
    let is_username_field_valid            = is_username_field_valid_yn === 'yes';
    let is_email_address_field_valid       = is_email_address_field_valid_yn === 'yes';
    let is_birthday_field_valid            = is_birthday_field_valid_yn === 'yes';
    let is_password_field_valid            = is_password_field_valid_yn === 'yes';
    let is_confirm_password_field_valid    = is_confirm_password_field_valid_yn === 'yes';

    if(!is_username_field_valid){
        Swal.fire({
            icon: 'error',
            html: 'The username needs be valid and available.',
            heightAuto: false
        });
    }
    else if(!is_email_address_field_valid){
        Swal.fire({
            icon: 'error',
            html: 'The email address needs to be formatted correctly.',
            heightAuto: false
        });
    }
    else if(!is_birthday_field_valid){
        Swal.fire({
            icon: 'error',
            html: 'Verify that birth date is in the correct format.',
            heightAuto: false
        });
    }
    else if(!is_password_field_valid){
        Swal.fire({
            icon: 'error',
            html: 'New password must be 10 characters or longer.',
            heightAuto: false
        });
    }
    else if(!is_confirm_password_field_valid){
        Swal.fire({
            icon: 'error',
            html: 'The password and password confirmation must match!',
            heightAuto: false
        });
    }
    else{
        section_content.animate({ opacity: 0.0},600, function(){
            section_content.attr('data-show', 'no');

            section_loading_screen.css('opacity', 0.0);
            section_loading_screen.attr('data-show', 'yes');
            section_loading_screen.animate({ opacity: 1.0},600, function(){
                self.requestUserCreation();
            });
        });
    }
}


// Get Masked Username
SharedUI.NewUserSignupForm.getMaskedUsername = function(given_username){
    let filtered_string = '';
    let given_string = given_username;
    let allowed_special = '_';

    // Filter to allowed chars
    for (let i = 0; i < given_string.length; i++) {
        let is_allowed = false;
        let current_char = given_string.charAt(i);

        is_allowed = (allowed_special.indexOf(current_char) !== -1);
        if(!is_allowed) {
            is_allowed = current_char.match(/\p{Lu}|\p{Ll}|\p{Lt}|\p{Lm}|\p{Lo}|\p{Nd}|\p{Nl}/gu) !== null;
        }

        if(is_allowed){
            filtered_string += current_char;
        }
    }

    // Return the filtered string
    return filtered_string;
}



SharedUI.NewUserSignupForm.getUserCreationData = function(){
    let self                   = SharedUI.NewUserSignupForm;
    let section                = $('[data-section="shared-ui-new-user-signup-form"]');
    let form                   = section.find('[data-section-item-type="form"]').first();
    let username_field         = form.find('[data-section-item="username-field"]').first();
    let email_address_field    = form.find('[data-section-item="email-address-field"]').first();
    let birthday_field         = form.find('[data-section-item="date-of-birth-field"]').first();
    let password_field         = form.find('[data-section-item="password-field"]').first();
    let confirm_password_field = form.find('[data-section-item="confirm-password-field"]').first();
    let username_input         = username_field.find('input[type="text"]').first();
    let email_address_input    = email_address_field.find('input[type="text"]').first();
    let birthday_input         = birthday_field.find('input[type="text"]').first();
    let password_input         = password_field.find('[data-section-item="password-input"]').first();
    let confirm_password_input = confirm_password_field.find('[data-section-item="confirm-password-input"]').first();
    let username               = username_input.val();
    let email_address          = email_address_input.val();
    let birthday               = birthday_input.val();
    let password               = password_input.val();
    let confirm_password       = confirm_password_input.val();
    let birthday_yyyy_mm_dd    = self.mmddyyyy_to_yyyymmdd(birthday);
    let user_creation_fields   = {};

    user_creation_fields = {
        'username'                 : username,
        'email_address'            : email_address,
        'date_of_birth_yyyy_mm_dd' : birthday_yyyy_mm_dd,
        'new_password'             : password,
        'confirm_new_password'     : confirm_password
    }

    return user_creation_fields;
}

SharedUI.NewUserSignupForm.mmddyyyy_to_yyyymmdd = function(date_as_mm_dd_yyyy){
    let mm_dd_yyyy_no_whitespace = date_as_mm_dd_yyyy.replace(/\s+/g, '');
    let year_yyyy                = mm_dd_yyyy_no_whitespace.substring(6);
    let month_mm                 = mm_dd_yyyy_no_whitespace.substring(0,2);
    let day_dd                   = mm_dd_yyyy_no_whitespace.substring(3,5);
    let date_yyyy_mm_dd          = year_yyyy + '-' + month_mm + '-' + day_dd;

    return date_yyyy_mm_dd;
}


SharedUI.NewUserSignupForm.requestUserCreation = function(){
    let self                   = SharedUI.NewUserSignupForm;
    let section                = $('[data-section="shared-ui-new-user-signup-form"]');
    let section_content        = section.find('[data-section-item="section-content"]').first();
    let section_loading_screen = section.find('[data-section-item="section-loading"]').first();
    let user_creation_fields   = self.getUserCreationData();
    let success_loading_area   = section.find('[data-section-item="success-page-loading-area"]').first();
    let success_loading_form   = success_loading_area.find('form').first();

    // Make an ajax request
    let jqxhr = $.post( "/ajax/user-system/create-new-user", user_creation_fields, function() {
        // Do nothing for now
    }).done(function(data) {
        let message_status     = data.hasOwnProperty('message_status') ? data.message_status : 'error';
        let is_message_success = message_status === 'success';

        if(is_message_success){
            section_loading_screen.animate({ opacity: 0.0},600, function() {
                section_loading_screen.attr('data-show', 'no');

                let action_status     = data.hasOwnProperty('action_status') ? data.action_status : 'error';
                let is_action_success = action_status === 'success';

                if(is_action_success){
                    Swal.fire({
                        icon: 'success',
                        html: 'New account successfully created.',
                        confirmButtonText: 'Continue',
                        heightAuto: false
                    }).then(function(isConfirm) {
                        success_loading_form.submit();
                    });
                }
                else{
                    section_content.css('opacity', 0.0);
                    section_content.attr('data-show', 'yes');
                    section_content.animate({ opacity: 1.0},600, function(){
                        Swal.fire({
                            icon: 'error',
                            html: 'Encountered a problem creating user.',
                            heightAuto: false
                        });
                    });
                }
            });
        }
    }).fail(function() {
        //alert( "error" );
    }).always(function() {
        //alert( "finished" );
    });
}

// Run Construct on page load
$( document ).ready(function() {
    SharedUI.NewUserSignupForm.construct();
});