import { load_data}  from "./load_user.js";
var form = document.getElementById("edit-username-form");
form.addEventListener("submit",function(event){
    event.preventDefault();
    var username= document.getElementById("new-username").value.trim();
   
    if(username ===""){
        alert("enter valid user name");
        return;
    }

    fetch("http://localhost/mylistapp/PHP/update_uname.php",{
        method : "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: `username=${encodeURIComponent(username)}` 
    })
    .then(Response=>Response.json())
    .then(data=>{
        if (data.success) {
        alert("update success"); 
        load_data();
        document.getElementById("new-username").value = "";
         
        }else{
             alert("Login failed: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));
})