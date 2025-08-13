var deleteButton = document.getElementById('delete-account-button');

deleteButton.addEventListener('click', function() {
    if (!confirm("Are you sure you want to delete your account? This action cannot be undone.")) {
        return;
    }

    fetch('http://localhost/mylistapp/PHP/delecte_acc.php', {
        method: 'POST',
        credentials: 'include'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            window.location.href = 'http://localhost/mylistapp/index.html';
        } else {
            alert('Failed to delete account: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});
