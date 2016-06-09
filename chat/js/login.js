/*!
 * Login Authentication
 *
 * Handles and routes login process
 *
 * author: ryan icasiano
 * date: 01-12-2011
 */
$(document).ready(function() {
    //submit login event
    $("form#loginform").submit(function(){
        //username is not filled out
        if ($("#username").val() == "") {
            $("#trap_error").html("Username must be filled out.");
        }
        //password is not filled out
        else if ($("#password").val() == "") {
            $("#trap_error").html("Password must be filled out.");
        }
        else
        {
            //ajax post to backend authentication
            $.post("index.php/login/authenticate",{
                username: $("#username").val(),
                password: $("#password").val()
            }, function(data){
                //login successful
                if (data == 1){
                   window.location.replace("index.php/login/successful");
                }
                //authentication is unsuccessful
                else{
                    $("#trap_error").html("Invalid username/password.");
                }
            });
            //clear fields
            $("#username").val("");
            $("#password").val("");
        }
        return false;
    });
});