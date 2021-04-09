$j(function( $ ){
    $j("#btn-reset").click(function(e) {
        e.preventDefault();
        
        var email = $('#reset-email').val();

        if(email.length > 0) {
            $j.ajax({
                type: "POST",
                url: "/ajax/reset.php",
                dataType: 'text',
                data: {
                    email: email
                },
                beforeSend: function() {
                    document.getElementById('btn-container').innerHTML = 
                    `<button type="submit" id="btn-reset" class="btn btn-primary btn-lg" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>`;
                },
                success: function(result) {
                    var res = JSON.parse(result);
                    if(res.success) {
                        document.getElementById('btn-container').innerHTML = 
                        `<button id="btn-reset" type="submit" class="btn btn-primary btn-lg">Send Reset Link</button>
                        <div class="alert alert-success" role="alert">
                            We have sent you an email with instructions on how to reset your password.
                        </div>`;
                    } else {
                        document.getElementById('btn-container').innerHTML = 
                        `<button id="btn-reset" type="submit" class="btn btn-primary btn-lg">Send Reset Link</button>
                        <div class="alert alert-danger" role="alert">
                        ` + res.output + `
                        </div>`;
                    }
                },
                error: function(result) {
                    var res = JSON.parse(result);
                    document.getElementById('btn-container').innerHTML = 
                    `<button id="btn-reset" type="submit" class="btn btn-primary btn-lg">Send Reset Link</button>
                    <div class="alert alert-danger" role="alert">
                    ` + res.output + `
                    </div>`;
                }
            });
        } else {
            alert('Please fill in all fields to proceed.');
        }
    });

    $j("#btn-change").click(function(e) {
        e.preventDefault();
        
        var pass = $('#inputPass').val();
        var passConfirm = $('#inputPassConfirm').val();

        if(pass.length > 0 && passConfirm.length > 0) {
            $j.ajax({
                type: "POST",
                url: "/ajax/changepass.php",
                dataType: 'text',
                data: {
                    pass: pass,
                    passConfirm: passConfirm,
                    token: findGetParameter('key')
                },
                beforeSend: function() {
                    document.getElementById('btn-container').innerHTML = 
                    `<button type="submit" id="btn-reset" class="btn btn-primary btn-lg" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>`;
                },
                success: function(result) {
                    var res = JSON.parse(result);
                    if(res.success) {
                        document.getElementById('btn-container').innerHTML = 
                        `<button id="btn-reset" type="submit" class="btn btn-primary btn-lg">Update Password</button>
                        <div class="alert alert-success" role="alert">
                        ` + res.output + `
                        </div>`;
                    } else {
                        document.getElementById('btn-container').innerHTML = 
                        `<button id="btn-reset" type="submit" class="btn btn-primary btn-lg">Update Password</button>
                        <div class="alert alert-danger" role="alert">
                        ` + res.output + `
                        </div>`;
                    }
                },
                error: function(result) {
                    var res = JSON.parse(result);
                    document.getElementById('btn-container').innerHTML = 
                    `<button id="btn-reset" type="submit" class="btn btn-primary btn-lg">Update Password</button>
                    <div class="alert alert-danger" role="alert">
                    ` + res.output + `
                    </div>`;
                }
            });
        } else {
            alert('Please fill in all fields to proceed.');
        }
    }); 

    function findGetParameter(parameterName) {
        var result = null,
            tmp = [];
        var items = location.search.substr(1).split("&");
        for (var index = 0; index < items.length; index++) {
            tmp = items[index].split("=");
            if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        }
        return result;
    }
});