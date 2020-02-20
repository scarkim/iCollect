if (document.title === "iCollect Signup" || document.title === "iCollect Login") {

    let form = document.getElementsByTagName("form");

    if (document.title === "iCollect Signup") {

        let errUserName = document.getElementById("err-username");
        let errEmail = document.getElementById("err-email");
        let errPassword = document.getElementById("err-password");
        let errPassword2 = document.getElementById("err-password2");
        let errAcctType = document.getElementById("err-acct-type");

        errUserName.style.visibility = "hidden";
        errEmail.style.visibility = "hidden";
        errPassword.style.visibility = "hidden";
        errPassword2.style.visibility = "hidden";
        errAcctType.style.visibility = "hidden";
        form[0].onsubmit = validateSignup;


        function validateSignup() {
            errUserName.style.visibility = "hidden";
            errEmail.style.visibility = "hidden";
            errPassword.style.visibility = "hidden";
            errPassword2.style.visibility = "hidden";
            errAcctType.style.visibility = "hidden";

            let username = document.getElementById("username").value;
            let email = document.getElementById("email").value;
            let password = document.getElementById("password").value;
            let password2 = document.getElementById("password2").value;
            let acctType = document.getElementsByName("accountType");

            let isValid = true;

            if (username === "" || !username.match(/^[0-9a-zA-Z]+$/)) {
                    errUserName.style.visibility = "visible";
                    isValid = false;
            }

            if (password === "") {
                errPassword.style.visibility = "visible";
                isValid = false;
            } else if (password !== password2) {
                errPassword2.style.visibility = "visible";
                isValid = false;
            }

            if (email === "" || !email.match(/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/)) {
                errEmail.style.visibility = "visible";
                isValid = false;
            }

            for(let i = 0; i < acctType.length; i++) {
                if(acctType[i].value !== "0" && acctType[i].value !== "1") {
                    errAcctType.style.visibility = "visible";
                    isValid = false;
                }
            }

            return isValid;
        }
    } /*else if (document.title === "iCollect Login") {
        form[0].onsubmit = validateLogin;
    }*/


}








