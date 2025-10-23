$( document ).ready(function() {
    
    validator = $("#mainmodule").validate({
            rules: {
                codiceScuola: {
                    required: true,
                    minlength: 10
                },
                password: {
                    required: true,
                    minlength: 8
                },
                password_again: {
                    equalTo: "#school-input-6"
                },
                numeroReferente: {
                    required: true,
                    minlength: 9
                }
              }            
        }); 
    });
