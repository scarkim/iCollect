

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
        $.post("signupAjax", { email: $("#email").val()},
            function (result)
            {
                $("#ajax-email-result").text(result);
            }
        );
    });
});

