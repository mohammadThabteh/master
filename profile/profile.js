const isLoggedIn = sessionStorage.getItem('isLoggedIn');
var userId = sessionStorage.getItem('USER_ID');
if (isLoggedIn === 'true') {
  fetch("http://localhost/masterpiece/userCrud/user_read.php",{
    method: "POST",
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({id: userId}) 

  })
  .then(response => response.json())
  .then(data => {
    document.getElementById('username-display').innerText = data.username;
    document.getElementById('email-display').innerText = data.email;
    document.getElementById('role-display').innerText = data.role_id == "1" ? "Admin" : "User";
  })
  .catch(error => console.error('Error fetching user data:', error));

}
var userId = sessionStorage.getItem('USER_ID');
const userList = document.getElementById('userList');
const bookingList = document.getElementById('bookingList');

function createRow(pet) {
    const row = document.createElement('tr');
    row.setAttribute('data-id', pet.id); 
    row.innerHTML = `
        <td>${pet.name}</td>
        <td>${pet.age}</td>
        <td>${pet.created_at}</td>
        <td class="action-buttons">
            <button class="delete-button" onclick="deletePet(${pet.id, userId})">Delete</button>
        </td>
    `;
    return row;
}

fetch('http://localhost/masterpiece/usersPet/user_petNames.php', {
    method: "POST",
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ user_id: userId })  // Make sure to send an object with a property named "userId"
})
    .then(response => response.json())
    .then(data => {
        data.forEach(pet => {
            const row = createRow(pet);
            userList.appendChild(row);
        });
    })
    .catch(error => console.error('Error fetching user data:', error));

 function deletePet(id, user_id){
  fetch('http://localhost/masterpiece/pet_profile/delete.php', {
    method: "POST",
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id: id, user_id: user_id})  // Make sure to send an object with a property named "userId"
})
    .then(response => response.json())
    .then(data => {
      console.log(data);
      const deletedRow = document.querySelector(`[data-id="${id}"]`);
      if (deletedRow) {
          deletedRow.remove();
      }
      window.location.reload()
    })
    .catch(error => console.error('Error fetching user data:', error));

 }





 function createTrainingRow(training) {
  const row = document.createElement('tr');
  row.setAttribute('data-id', training.id); 
  row.innerHTML = `
      <td>${training.animal_name}</td>
      <td>${training.training_name}</td>
      <td>${training.training_date}</td>
      <td>${training.price}</td>
      <td>${training.description}</td>
      <td class="action-buttons">
      </td>
  `;
  return row;
}
console.log(userId);
fetch('http://localhost/masterpiece/trainigCrud/user&animalData.php', {
    method: "POST",
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ user_id: userId })  // Make sure to send an object with a property named "userId"
})
    .then(response => response.json())
    .then(data => {
        data.forEach(training => {
            const row = createTrainingRow(training);
            bookingList.appendChild(row);
        });
    })
    .catch(error => console.error('Error fetching user data:', error));








