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

        let output = self.convertCliEscapesToHtml(data);

        cli_display_code_element.append(task + '<br>' + output +'<br><br>▶️ ');
    }).fail(function() {
        //alert( "error" );
    }).always(function() {
        //alert( "finished" );
    });
}


// Run Task
PithPanel.TaskControl.convertCliEscapesToHtml = function(cli_string){
    let self = PithPanel.TaskControl;

    let reset = "\033[0m";

    let styles = [
        {name: 'fg_dark_black', sequence: "\033[30m"},
        {name: 'fg_dark_red', sequence: "\033[31m"},
        {name: 'fg_dark_green', sequence: "\033[32m"},
        {name: 'fg_dark_yellow', sequence: "\033[33m"},
        {name: 'fg_dark_blue', sequence: "\033[34m"},
        {name: 'fg_dark_magenta', sequence: "\033[35m"},
        {name: 'fg_dark_cyan', sequence: "\033[36m"},
        {name: 'fg_dark_white', sequence: "\033[37m"},

        {name: 'bg_dark_black', sequence: "\033[40m"},
        {name: 'bg_dark_red', sequence: "\033[41m"},
        {name: 'bg_dark_green', sequence: "\033[42m"},
        {name: 'bg_dark_yellow', sequence: "\033[43m"},
        {name: 'bg_dark_blue', sequence: "\033[44m"},
        {name: 'bg_dark_magenta', sequence: "\033[45m"},
        {name: 'bg_dark_cyan', sequence: "\033[46m"},
        {name: 'bg_dark_white', sequence: "\033[47m"},

        {name: 'fg_bright_black', sequence: "\033[90m"},
        {name: 'fg_bright_red', sequence: "\033[91m"},
        {name: 'fg_bright_green', sequence: "\033[92m"},
        {name: 'fg_bright_yellow', sequence: "\033[93m"},
        {name: 'fg_bright_blue', sequence: "\033[94m"},
        {name: 'fg_bright_magenta', sequence: "\033[95m"},
        {name: 'fg_bright_cyan', sequence: "\033[96m"},
        {name: 'fg_bright_white', sequence: "\033[97m"},

        {name: 'bg_bright_black', sequence: "\033[100m"},
        {name: 'bg_bright_red', sequence: "\033[101m"},
        {name: 'bg_bright_green', sequence: "\033[102m"},
        {name: 'bg_bright_yellow', sequence: "\033[103m"},
        {name: 'bg_bright_blue', sequence: "\033[104m"},
        {name: 'bg_bright_magenta', sequence: "\033[105m"},
        {name: 'bg_bright_cyan', sequence: "\033[106m"},
        {name: 'bg_bright_white', sequence: "\033[107m"}
    ];

    $.each(styles, function( style_index, style) {
        let style_name     = style.name;
        let style_sequence = style.sequence;
        let same           = false
        do{
            let cli_string_before = cli_string;
            cli_string = self.do_format(cli_string, style_sequence, style_name, reset);
            same = cli_string === cli_string_before;
        }while(!same)

    });

    cli_string  = cli_string.replaceAll(reset, '');

    return cli_string;
}

PithPanel.TaskControl.do_format = function(cli_string, escape_sequence, escape_sequence_name, reset) {
    let self            = PithPanel.TaskControl;
    let new_cli_string  = cli_string;
    let sandwich        = self.string_between_strings(escape_sequence, reset, cli_string);
    let sandwich_exists = sandwich.length > 0;

    if(sandwich_exists){
        let replace_text     = escape_sequence + sandwich;
        let replacement_text = '<span data-cli-format="' + escape_sequence_name + '">' + sandwich + '</span>';

        new_cli_string  = cli_string.replace(replace_text, replacement_text);
    }

    return new_cli_string;

}

// string_between_strings
// See: https://lage.us/Javascript-Get-String-Between-Strings.html
PithPanel.TaskControl.string_between_strings = function(startStr, endStr, str) {
    pos = str.indexOf(startStr) + startStr.length;
    return str.substring(pos, str.indexOf(endStr, pos));
}


// Run Construct on page load
$(document).ready(function() {
    PithPanel.TaskControl.construct();
});