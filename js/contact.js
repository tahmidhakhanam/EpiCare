document.addEventListener('DOMContentLoaded', function () {
        
        //modal opens when user clocks add treatment
        var addContactBtn = document.getElementById("addContact");
        addContactBtn.addEventListener("click", function () {
        var addContactModal = new bootstrap.Modal(document.getElementById('addContactModal'));
            addContactModal.show();
        });
    
        //event listener for the form submission
        var form = document.getElementById("contactForm");
        form.addEventListener("submit", function (event) {
                
            //prevent default form submission
            event.preventDefault();
    
            //sbmit the form
            form.submit();
        });
    });