if (document.title === "iCollect Signup" || document.title === "iCollect Login") {

    let form = document.getElementsByTagName("form");

    if (document.title === "iCollect Signup") {
        form[0].onsubmit = validateSignup;
        let username = document.getElementById("username").value;
        let email = document.getElementById("email").value;
        let err = document.createElement('span');
        function validateSignup() {
            let isValid = true;

            err.innerHTML = "";
            err.style.color = "red";
            document.body.appendChild(err);

            if (username === "") {
                err.innerHTML += "Username empty";
                isValid = false;
            }

            if (email === "") {
                err.innerHTML += "Email empty";
                isValid = false;
            }

            return isValid;
        }
    } /*else if (document.title === "iCollect Login") {
        form[0].onsubmit = validateLogin;
    }*/


}








