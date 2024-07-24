document.addEventListener('DOMContentLoaded', function () {
    function loadUsers() {
        fetch('getUsers.php')
            .then(response => response.json())
            .then(users => {
                const usersTable = document.getElementById('usersTable').getElementsByTagName('tbody')[0];
                usersTable.innerHTML = '';
                users.forEach(user => {
                    const row = usersTable.insertRow();
                    const usernameCell = row.insertCell(0);
                    const emailCell = row.insertCell(1);
                    const roleCell = row.insertCell(2);
                    const deleteCell = row.insertCell(3);

                    usernameCell.textContent = user.username;
                    emailCell.textContent = user.email;

                    const roleSelect = document.createElement('select');
                    roleSelect.classList.add('role-select');
                    roleSelect.dataset.id = user.id;

                    const roles = ['admin', 'sub', 'user'];
                    roles.forEach(role => {
                        const option = document.createElement('option');
                        option.value = role;
                        option.textContent = role.charAt(0).toUpperCase() + role.slice(1);
                        if (user.role === role) {
                            option.selected = true;
                        }
                        roleSelect.appendChild(option);
                    });

                    roleSelect.addEventListener('change', function () {
                        updateRole(user.id, this.value);
                    });

                    roleCell.appendChild(roleSelect);

                    const deleteBtn = document.createElement('a');
                    deleteBtn.textContent = 'Delete';
                    deleteBtn.href = `deleteUser.php?id=${user.id}`;
                    deleteBtn.className = 'delete-link';
                    deleteBtn.addEventListener('click', function (e) {
                        e.preventDefault();
                        deleteUser(user.id);
                    });

                    deleteCell.appendChild(deleteBtn);
                });
            })
            .catch(error => console.error('Error loading users:', error));
    }

    function updateRole(userId, newRole) {
        fetch('updateRole.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: userId, role: newRole })
        })
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                console.log('Role updated successfully');
            } else {
                console.error('Error updating role:', result.message);
            }
        })
        .catch(error => console.error('Error updating role:', error));
    }

    function deleteUser(userId) {
        fetch(`deleteUser.php?id=${userId}`, { method: 'GET' })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    loadUsers();
                } else {
                    console.error('Error deleting user:', result.message);
                }
            })
            .catch(error => console.error('Error deleting user:', error));
    }

    loadUsers();
});

function goBack() {
    window.history.back();
}
