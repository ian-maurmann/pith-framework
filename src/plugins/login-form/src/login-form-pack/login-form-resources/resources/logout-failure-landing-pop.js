//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// Logout Failure Landing Pop
// ──────────────────────────
//
// noinspection ES6ConvertVarToLetConst, UnnecessaryLocalVariableJS, JSUnusedAssignment
//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━


if(typeof SharedUI === 'undefined' || SharedUI === null || SharedUI === false){
    var SharedUI = {};
}


if(typeof SharedUI.LogoutFailureLandingPop === 'undefined' || SharedUI.LogoutFailureLandingPop === null || SharedUI.LogoutFailureLandingPop === false){
    SharedUI.LogoutFailureLandingPop = {};
}


// Construct
SharedUI.LogoutFailureLandingPop.construct = function(){
    let self = SharedUI.LogoutFailureLandingPop;

    // Listen for events
    self.listen();

    // Check for failed login
    self.checkForFailedLogout();
}


// Listen
SharedUI.LogoutFailureLandingPop.listen = function(){
    let self = SharedUI.LogoutFailureLandingPop;

    // Do nothing for now.

}

// Check for successful logout
SharedUI.LogoutFailureLandingPop.checkForFailedLogout = function(){
    let self               = SharedUI.LogoutFailureLandingPop;
    let url_query_string   = window.location.search;
    let url_GET_parameters = new URLSearchParams(url_query_string);
    let has_GET_logged_out = url_GET_parameters.has('logged-out');
    let has_failed_logout  = has_GET_logged_out && (url_GET_parameters.get('logged-out') === 'no');

    if(has_failed_logout){
        // Display error pop-up
        Swal.fire({
            icon: 'error',
            html: 'Failed to log out.<br> <br> Please sign-out again'
        });
    }
}

// Run Construct on page load
$( document ).ready(function() {
    SharedUI.LogoutFailureLandingPop.construct();
});