document.addEventListener('DOMContentLoaded', () => {
    loadScreens();
});

function loadScreens() {
    fetch('getScreens.php')
        .then(response => response.json())
        .then(screens => {
            screens.forEach(screen => addScreenToList(screen.screen_name, screen.location, screen.screen_url));
        })
        .catch(error => console.error('Error:', error));
}

function addScreenToList(screenName, location, url) {
    const tableBody = document.querySelector('#usersTable tbody');

    const row = document.createElement('tr');

    const nameCell = document.createElement('td');
    const nameLink = document.createElement('a');
    nameLink.textContent = screenName;
    nameLink.href = url;
    nameLink.target = '_blank';
    nameCell.appendChild(nameLink);
    row.appendChild(nameCell);

    const locationCell = document.createElement('td');
    locationCell.textContent = location;
    row.appendChild(locationCell);

    const urlCell = document.createElement('td');
    const urlLink = document.createElement('a');
    urlLink.textContent = url;
    urlLink.href = url;
    urlLink.target = '_blank';
    urlCell.appendChild(urlLink);
    row.appendChild(urlCell);

    const deleteCell = document.createElement('td');
    const deleteButton = document.createElement('button');
    deleteButton.textContent = 'Delete';
    deleteButton.onclick = function() {
        row.remove();
        removeScreenFromDatabase(screenName);
    };
    deleteCell.appendChild(deleteButton);
    row.appendChild(deleteCell);

    tableBody.appendChild(row);
}

function removeScreenFromDatabase(screenName) {
    fetch('deleteScreen.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ screenName: screenName }),
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
    })
    .catch(error => console.error('Error:', error));
}
