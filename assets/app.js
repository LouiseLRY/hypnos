import './styles/app.scss';
import './bootstrap';
require('@fortawesome/fontawesome-free/css/all.min.css');


$(document).ready(function() {
    // you may need to change this code if you are not using Bootstrap Datepicker
    $('.js-datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });

    // Getting the suites according to the chosen establishment
    let establishment = $('#booking_establishment');
    // When establishment gets selected ...
    establishment.change(function() {
        // ... retrieve the corresponding form.
        let form = $(this).closest('form');
        // Simulate form data, but only include the selected establishment value.
        let data = {};
        data[establishment.attr('name')] = establishment.val();

        // Submit data via AJAX to the form's action path.
        $.ajax({
            url : form.attr('action'),
            type: form.attr('method'),
            data : data,
            complete: function(html) {
                $('#booking_suite').replaceWith(
                    $(html.responseText).find('#booking_suite')
                );
                let suiteSelect = document.querySelector('#booking_suite');

                // Getting the value of the option every time the user clicks to change it
                suiteSelect.addEventListener("change", function(){
                    let chosenSuite = suiteSelect.options[suiteSelect.selectedIndex].value;
                    // Sending that variable through a cookie
                    createCookie("suite", chosenSuite, "1")
                })
            }
        });

        //Creating the cookie to send the variable to the backend
        function createCookie(name, value, days) {
            let expires;

            if (days) {
                let date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            }
            else {
                expires = "";
            }

            document.cookie = escape(name) + "=" +
                escape(value) + expires + "; path=/";
        }
    });



});