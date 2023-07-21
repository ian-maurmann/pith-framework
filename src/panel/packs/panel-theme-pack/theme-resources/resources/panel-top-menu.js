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
    Ox.Event.delegate('[data-pith-panel-click-event="pith-panel.top-menu >>> on-menu-icon-click"]', 'click', self.handleOnMenuClick);

    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', function(media_query_event) {
        let new_mode = media_query_event.matches ? "dark" : "light";
        let body     = $('body');

        body.attr('data-color-mode', new_mode);
    })
};

// Handle On Menu Click
PithPanel.TopMenu.handleOnMenuClick = function(element, event){
    let self                = PithPanel.TopMenu;
    let body                = $('body');
    let side_menu           = $('body > aside');
    let side_menu_state     = side_menu.attr('data-panel-slideout-menu-state');
    let is_side_menu_open   = side_menu_state === 'slid-out';
    let is_side_menu_closed = side_menu_state === 'slid-in';

    if(is_side_menu_open){
        // Set state to is sliding in
        side_menu.attr('data-panel-slideout-menu-state', 'sliding-in');

        // Animate the slide-left off of the screen
        side_menu.animate(
        {"left": '-=210%'},
        {
            easing: 'swing',
            duration: 600,
            complete: function(){
                // After the animation ends, Set the state to is slid in
                side_menu.attr('data-panel-slideout-menu-state', 'slid-in');
                }
            }
        );
    }
    else if(is_side_menu_closed){
        // Set the in-line CSS to outside the left-hand side of the screen
        side_menu.css('left', '-210%');

        // Set state to is sliding out
        side_menu.attr('data-panel-slideout-menu-state', 'sliding-out');

        // Animate the slide-right onto the screen
        side_menu.animate(
            {"left": '0'},
            {
                easing: 'swing',
                duration: 600,
                complete: function(){
                    // After the animation ends, Set the state to is slid out
                    side_menu.attr('data-panel-slideout-menu-state', 'slid-out');
                }
            }
        );
    }

}

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