$('#getReport').on('submit', processReport);

function processReport(e) {
    e.stopPropagation();
    e.preventDefault();
    runAjax()
    console.log($('#getReport').serialize())
}

function runAjax() {
    $.ajax({
        url: '/getReport',
        type: 'POST',
        data: $('#getReport').serialize(),
        success: function(data, textStatus, jqXHR) {

            //console.log(data)
            /*if(typeof data.error === 'undefined') {
                // Success so call function to process the form
                submitForm(event, data);
            }
            else {
                // Handle errors here
                console.log('ERRORS: ' + data.error);
            }*/
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // Handle errors here
            console.log('ERRORS: ' + textStatus);
            // STOP LOADING SPINNER
        }
    });
}