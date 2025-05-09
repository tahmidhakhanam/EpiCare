document.addEventListener('DOMContentLoaded', function () {
        
    //modal opens when user clicks send reminder
    var sendReminderBtn = document.getElementById("send-reminder");
    sendReminderBtn.addEventListener("click", function () {
    var sendReminderModal = new bootstrap.Modal(document.getElementById('sendReminderModal'));
        sendReminderModal.show();
    });

    //event listener for form submission
    var form = document.getElementById("reminderForm");
    form.addEventListener("submit", function (event) {
            
        // prevent default form submission
        event.preventDefault();

        //submit the form
        form.submit();
    });
});
       