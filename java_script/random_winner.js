document.getElementById("random-btn").addEventListener("click", () => {
    fetch("http://localhost/mylistapp/PHP/random_winner.php")
        .then(res => res.json())
        .then(winner => {
            if (winner.error) {
                alert(winner.error);
            } else {
                alert(`🎉 Winner: ${winner.fname} ${winner.lname} (${winner.email}) 🎉`);
            }
        })
        .catch(err => console.error("Error choosing winner:", err));
});
