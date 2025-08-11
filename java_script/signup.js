var form = document.getElementById("sign_up_form")
form.addEventListener("submit",function(event){
    event.preventDefault();
    var email =document.getElementById("email").value;
    var PASS =document.getElementById("password").value;
    var username =document.getElementById("username").value;
    username =username.trim()
    if(email ===""){
        alert("Email cannot be empty");
        return;
    }
    if (!email.includes("@") || !email.includes(".") ) {
        alert("Please enter a valid email");
        return;
    }
    if (PASS ==="") {
        alert("password cannot be empty");
        return;
    }
    if (PASS.length <8) {
        alert("password less than 8 letters")
        return;
    }
    if (username==="") {
        alert("enter user name");
        return;
    }
    fetch("http://localhost/mylistapp/PHP/signup.php",{
        method : "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(PASS)}&username=${encodeURIComponent(username)}`
    })
    .then(Response=>Response.json())
    .then(data=>{
        if (data.success) {
        alert("sign up successful!"); 
         window.location.href = "http://localhost/mylistapp/HTML/index.html";
        }else{
             alert("sign up failed: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));

})