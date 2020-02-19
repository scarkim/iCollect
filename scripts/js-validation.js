if (document.title === "iCollect Signup" || document.title === "iCollect Login") {

    let form = document.getElementsByTagName("form");

    if (document.title === "iCollect Signup") {

        let errUserName = document.getElementById("err-username");
        let errEmail = document.getElementById("err-email");
        errUserName.style.visibility = "hidden";
        errEmail.style.visibility = "hidden";
        form[0].onsubmit = validateSignup;


        function validateSignup() {
            errUserName.style.visibility = "hidden";
            errEmail.style.visibility = "hidden";
            let username = document.getElementById("username").value;
            let email = document.getElementById("email").value;
            let isValid = true;

            if (username === "") {
                errUserName.style.visibility = "visible";
                isValid = false;
            }

            if (email === "") {
                errEmail.style.visibility = "visible";
                isValid = false;
            }

            return isValid;
        }
    } /*else if (document.title === "iCollect Login") {
        form[0].onsubmit = validateLogin;
    }*/


}








