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

    Ox.Event.delegate('[data-shared-ui-focus-event="shared-ui.new-user-signup-form >>> on-field-focus"]', 'focus', self.handleOnFieldFocus);
    Ox.Event.delegate('[data-shared-ui-blur-event="shared-ui.new-user-signup-form >>> on-field-blur"]', 'blur', self.handleOnFieldBlur);
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


// Run Construct on page load
$( document ).ready(function() {
    SharedUI.NewUserSignupForm.construct();
});