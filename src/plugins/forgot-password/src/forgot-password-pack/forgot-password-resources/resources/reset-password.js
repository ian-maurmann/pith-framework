//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// Reset Password Form
// ───────────────────
//
// noinspection ES6ConvertVarToLetConst, UnnecessaryLocalVariableJS, JSUnusedAssignment
//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━


if(typeof SharedUI === 'undefined' || SharedUI === null || SharedUI === false){
    var SharedUI = {};
}


if(typeof SharedUI.ResetPasswordForm === 'undefined' || SharedUI.ResetPasswordForm === null || SharedUI.ResetPasswordForm === false){
    SharedUI.ResetPasswordForm = {};
}


// Construct
SharedUI.ResetPasswordForm.construct = function(){
    let self = SharedUI.ResetPasswordForm;

    // Listen for events
    self.listen();

    // Check for token in URL
    self.checkForToken();
}


// Listen
SharedUI.ResetPasswordForm.listen = function(){
    let self = SharedUI.ResetPasswordForm;

    // Password show/hide events
    Ox.Event.delegate('[data-shared-ui-click-event="shared-ui.reset-password-form >>> on-password-eye-click"]', 'click', self.handleOnPasswordEyeClick);

    // Submit reset password form
    Ox.Event.delegate('[data-shared-ui-click-event="shared-ui.reset-password-form >>> submit"]', 'click', self.handleOnSubmit);
}


// Check for token
SharedUI.ResetPasswordForm.checkForToken = function(){
    let self              = SharedUI.ResetPasswordForm;
    let section           = $('[data-section="shared-ui-reset-password-form"]').first();
    let section_content   = section.find('[data-section-item="section-content"]').first();
    let notification_area = section.find('[data-section-item="section-notification"]').first();
    let missing_token_note = notification_area.find('[data-section-item="missing-token-message-note"]').first();
    let url_query_string  = window.location.search;
    let url_GET_parameters = new URLSearchParams(url_query_string);
    let token             = url_GET_parameters.get('token');
    let has_token         = token !== null && token.length > 0;

    self.reset_token = has_token ? token : '';

    if(!has_token){
        section_content.attr('data-show', 'no');
        missing_token_note.attr('data-show', 'yes');
        notification_area.attr('data-show', 'yes');
    }
}


// Handle On Password-Eye Click
SharedUI.ResetPasswordForm.handleOnPasswordEyeClick = function(element, event){
    let self                   = SharedUI.ResetPasswordForm;
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


SharedUI.ResetPasswordForm.handleOnSubmit = function(element, event){
    let self                     = SharedUI.ResetPasswordForm;
    let section                  = $('[data-section="shared-ui-reset-password-form"]').first();
    let section_content          = section.find('[data-section-item="section-content"]').first();
    let section_loading_screen   = section.find('[data-section-item="section-loading"]').first();
    let notification_area        = section.find('[data-section-item="section-notification"]').first();
    let success_message          = notification_area.find('[data-section-item="success-message-note"]').first();
    let form                     = section.find('form').first();
    let password_field           = form.find('[data-section-item="password-field"]').first();
    let confirm_password_field   = form.find('[data-section-item="confirm-password-field"]').first();
    let password_input           = password_field.find('input[name="new_password"]').first();
    let confirm_password_input   = confirm_password_field.find('input[name="confirm_new_password"]').first();
    let new_password             = password_input.val();
    let confirm_new_password     = confirm_password_input.val();
    let has_password             = new_password.length > 0;
    let has_confirm_password     = confirm_new_password.length > 0;
    let is_password_valid        = new_password.length > 9;
    let do_passwords_match       = new_password === confirm_new_password;
    let token                    = self.reset_token || '';
    let has_token                = token.length > 0;
    let login_page_url           = typeof PITH_APP_DEFAULT_LOGIN_PAGE_URL_PATH !== 'undefined' ? PITH_APP_DEFAULT_LOGIN_PAGE_URL_PATH : '/1111/1111/demo/login';

    // Prefer PHP-rendered login link href when available
    let back_to_login_link = section.find('[data-section-item="back-to-login-link"]').first();
    if(back_to_login_link.length){
        let href = back_to_login_link.attr('href');
        if(href && href.length){
            login_page_url = href;
        }
    }

    if(!has_token){
        Swal.fire({
            icon: 'error',
            html: 'This reset link is missing or invalid. Please request a new password reset.',
            heightAuto: false
        });
    }
    else if(!has_password){
        Swal.fire({
            icon: 'error',
            html: 'Password cannot be empty.',
            heightAuto: false
        });
    }
    else if(!has_confirm_password){
        Swal.fire({
            icon: 'error',
            html: 'Confirm password cannot be empty.',
            heightAuto: false
        });
    }
    else if(!do_passwords_match){
        Swal.fire({
            icon: 'error',
            html: 'Password and confirm password must match.',
            heightAuto: false
        });
    }
    else if(!is_password_valid){
        Swal.fire({
            icon: 'error',
            html: 'Password is too short. Use at least 10 characters.',
            heightAuto: false
        });
    }
    else{
        // Show loading
        section_content.attr('data-show', 'no');
        section_loading_screen.css('opacity', 0.0);
        section_loading_screen.attr('data-show', 'yes');
        section_loading_screen.animate({ opacity: 1.0}, 200);

        let request_fields = {
            token: token,
            new_password: new_password,
            confirm_new_password: confirm_new_password
        };

        let jqxhr = $.post( "/ajax/user-system/reset-password", request_fields, function() {
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
                        success_message.attr('data-show', 'yes');
                        notification_area.attr('data-show', 'yes');

                        Swal.fire({
                            icon: 'success',
                            html: 'Your password has been updated.',
                            confirmButtonText: 'Go to Login',
                            heightAuto: false
                        }).then(function() {
                            window.location.href = login_page_url;
                        });
                    }
                    else{
                        section_content.css('opacity', 0.0);
                        section_content.attr('data-show', 'yes');
                        section_content.animate({ opacity: 1.0},600, function(){
                            Swal.fire({
                                icon: 'error',
                                html: 'This reset link is invalid or has expired. Please request a new password reset.',
                                heightAuto: false
                            });
                        });
                    }
                });
            }
            else{
                section_loading_screen.animate({ opacity: 0.0},600, function() {
                    section_loading_screen.attr('data-show', 'no');
                    section_content.css('opacity', 0.0);
                    section_content.attr('data-show', 'yes');
                    section_content.animate({ opacity: 1.0},600, function(){
                        Swal.fire({
                            icon: 'error',
                            html: 'Encountered a problem updating the password.',
                            heightAuto: false
                        });
                    });
                });
            }
        }).fail(function() {
            section_loading_screen.animate({ opacity: 0.0},600, function() {
                section_loading_screen.attr('data-show', 'no');
                section_content.css('opacity', 0.0);
                section_content.attr('data-show', 'yes');
                section_content.animate({ opacity: 1.0},600, function(){
                    Swal.fire({
                        icon: 'error',
                        html: 'Encountered a problem updating the password.',
                        heightAuto: false
                    });
                });
            });
        });
    }
}


// Run Construct on page load
$( document ).ready(function() {
    SharedUI.ResetPasswordForm.construct();
});
