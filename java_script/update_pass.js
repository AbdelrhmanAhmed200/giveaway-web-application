var form = document.getElementById("update-password-form");
form.addEventListener("submit",function(event){
    event.preventDefault()
    var current_password = document.getElementById("current-password").value.trim();
    var new_password  = document.getElementById("new-password").value.trim();

    if (current_password==="") {
        alert("enter your password");
        return;
    }
    if(new_password===""){
         alert("enter your new password");
         return;
    }
    if (new_password.length<8) {
        alert("password less than 8 letters")
        return;
        
    }

    fetch("http://localhost/mylistapp/PHP/update_pass.php",{
        method : "POST",
        headers:{"Content-Type": "application/x-www-form-urlencoded"},
        credentials: "include",
        body: `current_password=${encodeURIComponent(current_password)}&new_password=${encodeURIComponent(new_password)}`
    })
    .then(response=>response.json())
    .then(data=>{
        if (data.success) {
            alert("new password set successful")
            window.location.href="../index.html";
            
        }else{
             alert("sign up failed: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
})