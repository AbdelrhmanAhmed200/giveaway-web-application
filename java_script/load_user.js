

export var load_data = function load_data() {
    fetch('http://localhost/mylistapp/PHP/load_user.php',{ credentials: "include" })
    .then(Response =>Response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('username').textContent = data.user.name;
            document.getElementById('email').textContent = data.user.email;
        
            
        }else{
            alert("Not logged in!");
            window.location.href = 'http://localhost/mylistapp/index.html';
        }
    })
    .catch(err => console.error(err));
    
}
load_data()
