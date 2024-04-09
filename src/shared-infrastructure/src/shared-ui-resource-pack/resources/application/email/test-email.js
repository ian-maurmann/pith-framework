// Test Email
// ----------



function sendTestEmail(){
    $.ajax({
        method: "POST",
        url: "/1111/1111/demo/send-test-email-endpoint"
    })
        .done(function(message) {
            console.log(message)
            alert( "Data Saved: " + JSON.stringify(message));
        });
}