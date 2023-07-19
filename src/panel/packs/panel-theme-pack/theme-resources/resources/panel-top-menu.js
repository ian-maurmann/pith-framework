// Pith Panel - Top Menu
// ─────────────────────
//
// noinspection ES6ConvertVarToLetConst, UnnecessaryLocalVariableJS, UnnecessaryLocalVariableJS


// noinspection JSUnusedAssignment
if(typeof PithPanel === 'undefined' || PithPanel === null || PithPanel === false){
    var PithPanel = {};
}
if(typeof PithPanel.TopMenu === 'undefined' || PithPanel.TopMenu === null || PithPanel.TopMenu === false){
    PithPanel.TopMenu = {};
}

// Construct
PithPanel.TopMenu.construct = function(){
    let self = PithPanel.TopMenu;

    // Listen for events
    self.listen();
};

// Listen
PithPanel.TopMenu.listen = function(){
    let self = PithPanel.TopMenu;

    // Icon click events
    Ox.Event.delegate('[data-pith-panel-click-event="pith-panel.top-menu >>> on-sign-out-icon-click"]', 'click', self.handleOnSignOutClick);


    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(media_query_event) {
        let new_mode = media_query_event.matches ? "dark" : "light";
        let body     = $('body');

        body.attr('data-color-mode', new_mode);
    })
};

// Handle On Sign-Out Click
PithPanel.TopMenu.handleOnSignOutClick = function(element, event){
    let self = PithPanel.TopMenu;

    Swal.fire({
        html: 'Sign out?',
        heightAuto: false,
        iconHtml: '',

        showConfirmButton: true,
        showCancelButton: true,

        focusConfirm: false,
        focusCancel: false
    });
}


// Run Construct on page load
$(document).ready(function() {
    PithPanel.TopMenu.construct();
});