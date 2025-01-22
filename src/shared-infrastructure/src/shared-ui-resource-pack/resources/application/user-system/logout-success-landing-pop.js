//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// Logout Success Landing Pop
// ──────────────────────────
//
// noinspection ES6ConvertVarToLetConst, UnnecessaryLocalVariableJS, JSUnusedAssignment
//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━


if(typeof SharedUI === 'undefined' || SharedUI === null || SharedUI === false){
    var SharedUI = {};
}


if(typeof SharedUI.LogoutSuccessLandingPop === 'undefined' || SharedUI.LogoutSuccessLandingPop === null || SharedUI.LogoutSuccessLandingPop === false){
    SharedUI.LogoutSuccessLandingPop = {};
}


// Construct
SharedUI.LogoutSuccessLandingPop.construct = function(){
    let self = SharedUI.LogoutSuccessLandingPop;

    // Listen for events
    self.listen();

    // Check for failed login
    self.checkForSuccessfulLogout();
}


// Listen
SharedUI.LogoutSuccessLandingPop.listen = function(){
    let self = SharedUI.LogoutSuccessLandingPop;

    // Do nothing for now.

}

// Check for successful logout
SharedUI.LogoutSuccessLandingPop.checkForSuccessfulLogout = function(){
    let self               = SharedUI.LogoutSuccessLandingPop;
    let url_query_string   = window.location.search;
    let url_GET_parameters = new URLSearchParams(url_query_string);
    let has_GET_logged_out = url_GET_parameters.has('logged-out');
    let has_successful_logout = has_GET_logged_out && (url_GET_parameters.get('logged-out') === 'yes');

    if(has_successful_logout){
        // Display pop-up
        Swal.fire({
            icon: 'success',
            html: 'Logged out.'
        });
    }
}

// Run Construct on page load
$( document ).ready(function() {
    SharedUI.LogoutSuccessLandingPop.construct();
});