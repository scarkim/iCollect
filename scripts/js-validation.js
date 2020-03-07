if (document.title === "iCollect Signup" ||
    document.title === "iCollect Login" ||
    document.title === "Create Collection") {

    let form = document.getElementsByTagName("form");
    if (document.title === "iCollect Signup" ||
        document.title === "iCollect Login") {
        let errUserName = document.getElementById("err-username");
        let errPassword = document.getElementById("err-password");

        errUserName.style.visibility = "hidden";
        errPassword.style.visibility = "hidden";

        if (document.title === "iCollect Signup") {

            let errEmail = document.getElementById("err-email");
            let errPassword2 = document.getElementById("err-password2");
            let errAcctType = document.getElementById("err-acct-type");

            errEmail.style.visibility = "hidden";
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
                let password = document.getElementById("password").value;
                let email = document.getElementById("email").value;
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
        } else if (document.title === "iCollect Login") {
            form[0].onsubmit = validateLogin;

            function validateLogin() {

                errUserName.style.visibility = "hidden";
                errPassword.style.visibility = "hidden";

                let username = document.getElementById("username").value;
                let password = document.getElementById("password").value;

                let isValid = true;

                if (username === "" || !username.match(/^[0-9a-zA-Z]+$/)) {
                    errUserName.style.visibility = "visible";
                    isValid = false;
                }

                if (password === "") {
                    errPassword.style.visibility = "visible";
                    isValid = false;
                }

                return isValid;
            }
        }
    } else if (document.title === "Create Collection") {

        form[0].onsubmit = validateCollection;

        let collectionTitleErr = document.getElementById("collectionTitleErr");
        let collectionDescriptionErr = document.getElementById("collectionDescriptionErr");

        function validateCollection() {


            let username = document.getElementById("loginName").value;
            let password = document.getElementById("password").value;

            let collectionTitle = document.getElementById("title").value;
            let collectionDescription = document.getElementById("description").value;

            collectionTitleErr.innerText = "";
            collectionDescriptionErr.innerText = "";


            let isValid = true;

            if (collectionTitle === "") {
                collectionTitleErr.innerText = "Must have a title";
                isValid = false;
            } else if (collectionTitle.length > 50){
                collectionTitleErr.innerText = "Must be less than 50";
                isValid = false;
            } else if (!collectionTitle.match(/^[^<>#@$%^*|]+$/)){
                collectionTitleErr.innerText = "No special characters";
                isValid = false;
            }

            if (collectionDescription.length > 200){
                collectionDescriptionErr.innerText = "Must be less than 200";
                isValid = false;
            } else if (!collectionDescription.match(/^[^<>#@$%^*|]+$/)){
                collectionDescriptionErr.innerText = "No special characters";
                isValid = false;
            }

            return isValid;
        }
    }
}








