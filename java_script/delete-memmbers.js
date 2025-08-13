import {display} from "./giveaway_list.js"
var deleteButton = document.getElementById('delete-all-btn');

deleteButton.addEventListener('click', function() {
    if (!confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
        return;
    }

    fetch('http://localhost/mylistapp/PHP/delete-memmbers.php', {
        method: 'POST',
        credentials: 'include'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
           display();
        } else {
            alert('Failed to delete memmbers: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});
