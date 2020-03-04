

$(document).ready(function() {

    $("#username").keyup(function (e) {
        e.preventDefault();
        $.post("model/ajax-username-check.php", { username: $("#username").val(), title: document.title},
            function (result)
            {
                $("#ajax-name-result").text(result);
            }
        );
    });

    $("#email").keyup(function (e) {
        e.preventDefault();
        $.post("model/ajax-username-check.php", { email: $("#email").val(), title: document.title},
            function (result)
            {
                $("#ajax-email-result").text(result);
            }
        );
    });
});

