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
    let self     = PithPanel.TaskControl;
    let button   = $(element);
    let row      = button.parent().closest('tr').first();
    let task     = row.attr('data-task');
    let task_url = row.attr('data-task-url');

    //alert('Run task ' + task);

    Swal.fire({
        html: '<pre><code>' + task + '</code></pre><br> Run task?',
        heightAuto: false,
        iconHtml: '',

        showConfirmButton: true,
        showCancelButton: true,

        focusConfirm: false,
        focusCancel: false
    }).then((result) => {
        if (result.isConfirmed) {
            self.runTask(task, task_url);
        }
    });
}

// Run Task
PithPanel.TaskControl.runTask = function(task, task_url){
    let self                     = PithPanel.TaskControl;
    let section                  = $('[data-section="task-control"]');
    let cli_display_div          = section.find('[data-section-item="cli-display"]').first();
    let cli_display_pre_element  = cli_display_div.find('pre').first();
    let cli_display_code_element = cli_display_pre_element.find('code').first();

    // Make an ajax request
    let jqxhr = $.get( task_url, {}, function() {
        // Do nothing for now
    }).done(function(data) {
        let stringified_data = JSON.stringify(data);
        //alert( "done" );
        //alert(stringified_data);

        cli_display_code_element.append(task + '<br>' + data +'<br><br>▶️ ');
    }).fail(function() {
        //alert( "error" );
    }).always(function() {
        //alert( "finished" );
    });
}


// Run Construct on page load
$(document).ready(function() {
    PithPanel.TaskControl.construct();
});