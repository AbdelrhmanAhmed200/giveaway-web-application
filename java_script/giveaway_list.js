export var display = function loadParticipants() {
    fetch('http://localhost/mylistapp/PHP/giveaway_list.php')
        .then(res => res.json())
        .then(data => {
            let list = document.getElementById('participant-list');
            list.innerHTML = '';
            data.forEach(person => {
                let li = document.createElement('li');
                li.classList.add('list-group-item', 'mb-2', 'p-3');
                li.style.backgroundColor = '#f8f9fa';
                li.style.border = '1px solid #ddd';
                li.style.borderRadius = '8px';
                li.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';
                li.innerHTML = `
                    <strong style="color:#333;">${person.fname} ${person.lname}</strong>
                    <br>
                    <span style="color:#777; font-size: 0.9em;">${person.email}</span>
                `;
                list.appendChild(li);
            });
        })
        .catch(err => console.error('Error loading participants:', err));
}
