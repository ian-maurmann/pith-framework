//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// Login Form
// ──────────
//
// noinspection ES6ConvertVarToLetConst, UnnecessaryLocalVariableJS, JSUnusedAssignment
//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━


if(typeof SharedUI === 'undefined' || SharedUI === null || SharedUI === false){
    var SharedUI = {};
}


if(typeof SharedUI.LoginForm === 'undefined' || SharedUI.LoginForm === null || SharedUI.LoginForm === false){
    SharedUI.LoginForm = {};
}


// Construct
SharedUI.LoginForm.construct = function(){
    let self = SharedUI.LoginForm;

    // Listen for events
    self.listen();
}


// Listen
SharedUI.LoginForm.listen = function(){
    let self = SharedUI.LoginForm;

    // Password show/hide events
    Ox.Event.delegate('[data-shared-ui-click-event="shared-ui.login-form >>> on-password-eye-click"]', 'click', self.handleOnPasswordEyeClick);

    // Submit login form
    Ox.Event.delegate('[data-shared-ui-click-event="shared-ui.login-form >>> submit"]', 'click', self.handleOnSubmit);

    // On click forgot password link
    Ox.Event.delegate('[data-shared-ui-click-event="shared-ui.login-form >>> forgot-password"]', 'click', self.handleOnClickForgotPassword);

}


// Handle On Password-Eye Click
SharedUI.LoginForm.handleOnPasswordEyeClick = function(element, event){
    let self                   = SharedUI.LoginForm;
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

SharedUI.LoginForm.handleOnSubmit = function(element, event){
    //alert('login');

    let self              = SharedUI.LoginForm;
    let section           = $('[data-section="shared-ui-login-form"]').first();
    let form              = section.find('form').first();
    let username_field    = form.find('[data-section-item="username-field"]').first();
    let password_field    = form.find('[data-section-item="password-field"]').first();
    let username_input    = username_field.find('input[name="username"]').first();
    let password_input    = password_field.find('input[name="password"]').first();
    let username          = username_input.val();
    let password          = password_input.val();
    let has_username      = username.length > 0;
    let has_password      = password.length > 0;
    let is_password_valid = password.length > 9;

    if(!has_username){
        Swal.fire({
            icon: 'error',
            html: 'Username cannot be empty.'
        });
    }
    else if(!has_password){
        Swal.fire({
            icon: 'error',
            html: 'Password cannot be empty.'
        });
    }
    else if(!is_password_valid){
        Swal.fire({
            icon: 'error',
            html: 'Password is too short.'
        });
    }
    else{
        form.submit();
    }
}

SharedUI.LoginForm.handleOnClickForgotPassword = function(element, event){
    alert('forgot password');
}

// Run Construct on page load
$( document ).ready(function() {
    SharedUI.LoginForm.construct();
});