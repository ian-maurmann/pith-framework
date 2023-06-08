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

    // Callout events
    Ox.Event.delegate('[data-shared-ui-focus-event="shared-ui.new-user-signup-form >>> on-field-focus"]', 'focus', self.handleOnFieldFocus);
    Ox.Event.delegate('[data-shared-ui-blur-event="shared-ui.new-user-signup-form >>> on-field-blur"]', 'blur', self.handleOnFieldBlur);

    // Password show/hide events
    Ox.Event.delegate('[data-shared-ui-click-event="shared-ui.new-user-signup-form >>> on-password-eye-click"]', 'click', self.handleOnPasswordEyeClick);
}


// Handle On Field Focus
SharedUI.NewUserSignupForm.handleOnFieldFocus = function(element, event){
    let self    = SharedUI.NewUserSignupForm;
    let textbox = $(element);
    let field   = textbox.parent();
    let callout = field.find('[data-section-item-type="field-callout"]').first();

    // Show the callout
    callout.attr('data-show', 'yes');
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


// Run Construct on page load
$( document ).ready(function() {
    SharedUI.NewUserSignupForm.construct();
});