//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// Forgot Password Form
// ────────────────────
//
// noinspection ES6ConvertVarToLetConst, UnnecessaryLocalVariableJS, JSUnusedAssignment
//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━


if(typeof SharedUI === 'undefined' || SharedUI === null || SharedUI === false){
    var SharedUI = {};
}


if(typeof SharedUI.ForgotPasswordForm === 'undefined' || SharedUI.ForgotPasswordForm === null || SharedUI.ForgotPasswordForm === false){
    SharedUI.ForgotPasswordForm = {};
}


// Construct
SharedUI.ForgotPasswordForm.construct = function(){
    let self = SharedUI.ForgotPasswordForm;

    // Listen for events
    self.listen();
}


// Listen
SharedUI.ForgotPasswordForm.listen = function(){
    let self = SharedUI.ForgotPasswordForm;

    // Submit forgot password form
    Ox.Event.delegate('[data-shared-ui-click-event="shared-ui.forgot-password-form >>> submit"]', 'click', self.handleOnSubmit);
}


// Is Valid Email Address
SharedUI.ForgotPasswordForm.isValidEmailAddress = function(given_email_address){
    let expression = /\S+@\S+\.\S+/;
    return expression.test(given_email_address);
}


SharedUI.ForgotPasswordForm.handleOnSubmit = function(element, event){
    let self                   = SharedUI.ForgotPasswordForm;
    let section                = $('[data-section="shared-ui-forgot-password-form"]').first();
    let section_content        = section.find('[data-section-item="section-content"]').first();
    let section_loading_screen = section.find('[data-section-item="section-loading"]').first();
    let notification_area      = section.find('[data-section-item="section-notification"]').first();
    let success_message        = notification_area.find('[data-section-item="success-message-note"]').first();
    let form                   = section.find('form').first();
    let email_address_field    = form.find('[data-section-item="email-address-field"]').first();
    let email_address_input    = email_address_field.find('input[name="email_address"]').first();
    let email_address          = email_address_input.val();
    let has_email_address      = email_address.length > 0;
    let is_email_valid         = self.isValidEmailAddress(email_address);

    if(!has_email_address){
        Swal.fire({
            icon: 'error',
            html: 'Email address cannot be empty.',
            heightAuto: false
        });
    }
    else if(!is_email_valid){
        Swal.fire({
            icon: 'error',
            html: 'The email address needs to be formatted correctly.',
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
            email_address: email_address
        };

        let jqxhr = $.post( "/ajax/user-system/request-password-reset", request_fields, function() {
            // Do nothing for now
        }).done(function(data) {
            let message_status     = data.hasOwnProperty('message_status') ? data.message_status : 'error';
            let is_message_success = message_status === 'success';

            if(is_message_success){
                section_loading_screen.animate({ opacity: 0.0},600, function() {
                    section_loading_screen.attr('data-show', 'no');

                    // Always show the generic success message (anti-enumeration)
                    success_message.attr('data-show', 'yes');
                    notification_area.attr('data-show', 'yes');

                    Swal.fire({
                        icon: 'success',
                        html: 'If an account exists for that email address, a password reset link has been sent.',
                        heightAuto: false
                    });
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
                            html: 'Encountered a problem requesting a password reset.',
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
                        html: 'Encountered a problem requesting a password reset.',
                        heightAuto: false
                    });
                });
            });
        });
    }
}


// Run Construct on page load
$( document ).ready(function() {
    SharedUI.ForgotPasswordForm.construct();
});
