// Pith Panel - Task Control
// ─────────────────────────
//
// noinspection ES6ConvertVarToLetConst, UnnecessaryLocalVariableJS, UnnecessaryLocalVariableJS


// noinspection JSUnusedAssignment
if(typeof PithPanel === 'undefined' || PithPanel === null || PithPanel === false){
    var PithPanel = {};
}
if(typeof PithPanel.TaskControl === 'undefined' || PithPanel.TaskControl === null || PithPanel.TaskControl === false){
    PithPanel.TaskControl = {};
}


// Construct
PithPanel.TaskControl.construct = function(){
    let self = PithPanel.TaskControl;

    // Listen for events
    self.listen();
};


// Listen
PithPanel.TaskControl.listen = function(){
    let self = PithPanel.TaskControl;

    Ox.Event.delegate('[data-pith-panel-click-event="pith-panel.task-control >>> on-button-click"]', 'click', self.handleOnButtonClick);
};


// Handle On Button Click
PithPanel.TaskControl.handleOnButtonClick = function(element, event){
    let self = PithPanel.TaskControl;

    alert('You clicked the button!');
}


// Run Construct on page load
$(document).ready(function() {
    PithPanel.TaskControl.construct();
});