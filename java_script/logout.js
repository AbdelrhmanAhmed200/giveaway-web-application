document.getElementById('signout-button').addEventListener('click', () => {
      fetch('http://localhost/mylistapp/PHP/logout.php', {
        method: 'POST',
        credentials: 'include'
      })
       .then(response => {
    if (!response.ok) throw new Error('Network response was not ok');
    return response.text();
  })
      .then(() => {
    window.location.replace('../index.html');
      })
      .catch(console.error);
    });