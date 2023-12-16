document.addEventListener('DOMContentLoaded', function() { 
    const userList = document.getElementById('userList')
    function createRow(user) {
        const row = document.createElement('tr');
        row.setAttribute('data-id', user.id);
        row.innerHTML = `
            <td>${user.username}</td>
            <td>${user.role_id}</td>
            <td>${user.email}</td>
            <td class="action-buttons">
                <button class="edit-button" onclick="editUser(${user.id})">Edit</button>
                <button class="delete-button" onclick="deleteUser(${user.id})">Delete</button>
            </td>
        `;
        return row;
    }
    window.editUser = function(id) {
        // Redirect to the editUser.html page with the user ID
        window.location.href = `editUser.html?id=${encodeURIComponent(id)}`;

    };
    fetch('http://localhost/masterpiece/userCrud/user_read.php')
        .then(response => response.json())
        .then(data => {
            data.forEach(user => {
                const row = createRow(user);
                userList.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching user data:', error));
})

const addUserForm = document.getElementById('addUserForm');
addUserForm.addEventListener('submit', function(event) {
    event.preventDefault();

    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const role = document.getElementById('role_id').value;

    const newUser = {
        username: username,
        email: email,
        role_id: role
    };

    // Call the API to add a new user
    fetch('http://localhost/masterpiece/userCrud/user_add.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(newUser)
    })
    .then(response => response.json())
    .then(data => {
        console.log(data)
        const row = createRow(data)
        userList.appendChild(row)
        alert('added successfully')
        window.location.reload();
    })
    .catch(error => console.error('Error adding user:', error));
        alert('error adding user:', error)
        window.location.reload();
        addUserForm.reset();
})
 
function updateUser() {
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    const searchParams = new URLSearchParams(window.location.search);
    const user_id = searchParams.get('id');
    
    const formData = {
        id: user_id,
        username, 
        email,
        password
    }
    
    fetch("http://localhost/masterpiece/userCrud/user_edit.php",{
        method: "PUT",
        headers: {'Content-Type': 'application/json' },
        body: JSON.stringify(formData),
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        throw new Error('Failed to update');
    })
    .then(data => {
        console.log(data);
        alert('Updated successfully')
        window.location.reload();
    })
    .catch(error => console.error('Error updating user:', error));
    alert('Could not update');
    window.location.href = 'http://127.0.0.1:5500/dashboard/dashboard.html';

}

function deleteUser (id) {
    console.log(id)
    // Call the API to delete the user
    fetch(`http://localhost/masterpiece/userCrud/user_delete.php`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({id}),
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        throw new Error('Failed to delete user');
    })
    .then(data => {
        console.log(data);
        // Remove the deleted user row from the table
        const deletedRow = document.querySelector(`[data-id="${id}"]`);
        if (deletedRow) {
            deletedRow.remove();
        }
        alert('Deleted successfully')
        window.location.reload();
    })
    .catch(error => console.error('Error deleting user:', error));
        alert('Deleted successfully')
        window.location.reload();
}
