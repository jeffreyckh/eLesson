function validate() {
    var username = document.forms["regForm"]["username"].value;
    var password = document.forms["regForm"]["password"].value;
    var repassword = document.forms["regForm"]["RepeatPassword"].value;
    var name = document.forms["regForm"]["name"].value;
    var email = document.forms["regForm"]["email"].value;
    var position = document.forms["regForm"]["position"].value;
    if (username==null || username=="" || password ==null || password == "" ||
    		repassword == null || repassword == "" || name == null || name == "" ||
    		email== null || email = "" || position ==null || position =="") {
        alert("All field are required!!!");
        return false;
    }