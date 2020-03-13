

$(document).ready(function() {

    $("#username").keyup(function (e) {
        e.preventDefault();
        $("#ajax-name-unavailable").text("");
        $("#ajax-name-available").text("");
        $.post("signupAjax", { username: $("#username").val()},
            function (result)
            {


                if(result === "Username taken" || result === "alpha-numeric only") {
                    $("#ajax-name-unavailable").text(result);
                } else {
                    $("#ajax-name-available").text(result);
                }

            }
        );
    });

    $("#email").keyup(function (e) {
        e.preventDefault();
        $("#ajax-email-unavailable").text("");
        $("#ajax-email-available").text("");

        $.post("signupAjax", { email: $("#email").val()},
            function (result)
            {
                if(result === "Email taken" || result === "Invalid email") {
                    $("#ajax-email-unavailable").text(result);
                } else {
                    $("#ajax-email-available").text(result);
                }

            }
        );
    });
});

