$j(function( $ ){
    $j("#contact-submit").click(function(e) {
        e.preventDefault();
        
        var name = $('#inputName').val();
        var email = $('#inputEmail').val();
        var message = $('#inputMessage').val();

        if(name.length > 0 && email.length > 0 && message.length > 0) {
            $j.ajax({
                type: "POST",
                url: "/ajax/contact.php",
                dataType: 'text',
                data: {
                    name: name,
                    email: email,
                    message: message
                },
                beforeSend: function() {
                    document.getElementById('contact-load').innerHTML = 
                    `<button type="submit" id="contact-submit" class="btn btn-primary btn-lg" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>`;
                },
                success: function(result) {
                    document.getElementById('contact-load').innerHTML = 
                    `<button type="submit" id="contact-submit" class="btn btn-primary btn-lg">
                        Submit
                    </button>
                    <div class="alert alert-success" role="alert">
                        Thankyou for reaching out, we will get back in touch shortly.
                    </div>`;
                },
                error: function(result) {
                    alert('Invalid Response');
                    document.getElementById('contact-load').innerHTML = 
                    `<button type="submit" id="contact-submit" class="btn btn-primary btn-lg">
                        Submit
                    </button>`;
                }
            });
        } else {
            alert('Please fill in all fields to proceed.');
        }
    });
});