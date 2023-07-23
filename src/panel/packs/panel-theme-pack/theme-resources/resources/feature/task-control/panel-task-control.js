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
    Ox.Event.delegate('[data-pith-panel-click-event="pith-panel.task-control >>> run-task"]', 'click', self.handleOnRunTask);
};


// Handle On Button Click
PithPanel.TaskControl.handleOnButtonClick = function(element, event){
    let self = PithPanel.TaskControl;

    alert('You clicked the button!');
}


// Handle On Run Task
PithPanel.TaskControl.handleOnRunTask = function(element, event){
    let self   = PithPanel.TaskControl;
    let button = $(element);
    let row    = button.parent().closest('tr').first();
    let task   = row.attr('data-task');

    alert('Run task ' + task);
}


// Run Construct on page load
$(document).ready(function() {
    PithPanel.TaskControl.construct();
});