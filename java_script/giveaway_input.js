import {display} from "./giveaway_list.js"
var form = document.getElementById("giveaway-form")
form.addEventListener("submit",function(event){
    event.preventDefault();
    var email =document.getElementById("email").value.trim();
    var fname =document.getElementById("fname").value.trim();
    var lname =document.getElementById("lname").value.trim();
    if(email ===""){
        alert("Email cannot be empty");
        return;
    }
    if (!email.includes("@") || !email.includes(".") ) {
        alert("Please enter a valid email");
        return;
    }
    if (fname ==="" || lname ==="") {
        alert("first name or last name is empty");
        return;
    }
    
    fetch("http://localhost/mylistapp/PHP/giveaway_input.php",{
        method : "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: `email=${encodeURIComponent(email)}&fname=${encodeURIComponent(fname)}&lname=${encodeURIComponent(lname)}`
    })
    .then(Response=>Response.json())
    .then(data=>{
        if (data.success) {
        alert("memmber add successful!"); 
        display();
         document.getElementById("email").value = "";
         document.getElementById("fname").value = "";
         document.getElementById("lname").value = "";
        
        }else{
             alert("memmber add failed: " + data.message);
        }
    })
    .catch(error => console.error("Error:", error));

})