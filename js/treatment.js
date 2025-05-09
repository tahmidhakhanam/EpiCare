document.addEventListener('DOMContentLoaded', function () {
        
    //modal opens when add treatment is clicked 
    var addTreatmentBtn = document.getElementById("addTreatment");
    addTreatmentBtn.addEventListener("click", function () {
    var addTreatmentModal = new bootstrap.Modal(document.getElementById('addTreatmentModal'));
        addTreatmentModal.show();
    });

    //event listener for form submission
    var form = document.getElementById("treatmentForm");
    form.addEventListener("submit", function (event) {
            
        //prevent default form submission
        event.preventDefault();

        //submit the form
        form.submit();
    });
});
       

