//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// New User Signup Form
// ────────────────────
//
// noinspection ES6ConvertVarToLetConst --- Ignore var here.
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
    Ox.Event.delegate('[data-shared-ui-input-event="shared-ui.new-user-signup-form >>> on-email-address-field-input"]', 'input', self.handleOnEmailAddressFieldInput);
    Ox.Event.delegate('[data-shared-ui-input-event="shared-ui.new-user-signup-form >>> on-birthday-field-input"]', 'input', self.handleOnBirthdayFieldInput);
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

SharedUI.NewUserSignupForm.isValidEmailAddress = function(given_email_address){
    let expression = /\S+@\S+\.\S+/;
    return expression.test(given_email_address);
}


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



// Handle On Field Focus
SharedUI.NewUserSignupForm.handleOnFieldFocus = function(element, event){
    let self    = SharedUI.NewUserSignupForm;
    let textbox = $(element);
    let field   = textbox.parent();
    let callout = field.find('[data-section-item-type="field-callout"]').first();

    // Show the callout
    callout.attr('data-show', 'yes');

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


// Run Construct on page load
$( document ).ready(function() {
    SharedUI.NewUserSignupForm.construct();
});