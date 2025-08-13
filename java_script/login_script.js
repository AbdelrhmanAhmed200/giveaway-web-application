var form = document.getElementById("login_form")
form.addEventListener("submit",function(event){
    event.preventDefault();
    var email =document.getElementById("email").value;
    var PASS =document.getElementById("password").value;
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
    fetch("http://localhost/mylistapp/PHP/login.php",{
        method : "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(PASS)}` 
    })
    .then(Response=>Response.json())
    .then(data=>{
        if (data.success) {
        alert("Login successful!"); 
         window.location.href = "http://localhost/mylistapp/HTML/giveaway.html";
        }else{
             alert("Login failed: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
})