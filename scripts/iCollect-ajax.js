

$(document).ready(function() {

    $("#username").keyup(function (e) {
        e.preventDefault();
        $.post("signupAjax", { username: $("#username").val()},
            function (result)
            {
                $("#ajax-name-result").text(result);
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

