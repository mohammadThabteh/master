document.addEventListener("DOMContentLoaded", function () {
  fetch("http://localhost/masterpiece/trainigCrud/training_read.php")
    .then((response) => response.json())
    .then((data) => {
      const userList = document.getElementById("userList");
      data.forEach((training) => {
        const row = document.createElement("tr");
        row.innerHTML = `
                    <td>${training.name}</td>
                    <td>${training.description}</td>
                    <td>${training.price}</td>
                    <td class="action-buttons">
                    <button class="edit-button" onclick="editTraining(${training.training_id})">Edit</button>
                    <button class="delete-button" onclick="deleteTraining(${training.training_id})">Delete</button>
                    </td>
                `;
        userList.appendChild(row);
      });
    })
    .catch((error) => console.error("Error fetching data:", error));
});

window.editTraining = function (id) {
  window.location.href = `editTraining.html?id=${encodeURIComponent(id)}`;
};

const addUserForm = document.getElementById("addUserForm");
addUserForm.addEventListener("submit", function (event) {
  event.preventDefault(); // Prevent the default form submission
  const name = document.getElementById("name").value;
  const description = document.getElementById("description").value;
  const price = document.getElementById("price").value;

  const newTraining = {
    name: name,
    description: description,
    price: price,
    image: "training.png",
  };
  console.log(newTraining);

  fetch("http://localhost/masterpiece/trainigCrud/training_creat.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(newTraining),
  })
    .then((response) => {
      let res = response.json();
      console.log(res);
      return res;
    })
    .then((data) => {
      console.log(data);
      const userList = document.getElementById("userList");
      const newRow = createRow(data); // Assuming the response contains the new training data
      userList.appendChild(newRow);
      addUserForm.reset();
      alert("Training created successfully");
      window.location.reload();
    })
    .catch((error) => {
      console.error("Error adding new training:", error);
      alert("error creating new training");
    });
});

function editTraining(trainingId) {
  const name = document.getElementById("name").value;
  const description = document.getElementById("description").value;
  const price = document.getElementById("price").value;

  const updatedTraining = {
    training_id: trainingId,
    name: name,
    description: description,
    price: price,
  };

  fetch("http://localhost/masterpiece/trainigCrud/training_edite.php", {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(updatedTraining),
  })
    .then((response) => response.json())
    .then((data) => {
      const userList = document.getElementById("userList");
      const existingRow = userList.querySelector(`tr[data-id="${trainingId}"]`);
      if (existingRow) {
        existingRow.innerHTML = `
                  <td>${data.name}</td>
                  <td>${data.description}</td>
                  <td>${data.price}</td>
                  <td>
                      <button class="edit-button" onclick="editTraining(${data.id})">Edit</button>
                      <button class="delete-button" onclick="deleteTraining(${data.id})">Delete</button>
                  </td>
              `;
      }
      addUserForm.reset();
      addUserForm.removeEventListener("submit", updatedTraining);
    })
    .catch((error) => {
      console.error("Error updating training:", error);
      alert(error.message);
    });
}
function deleteTraining(trainingId) {
  console.log(trainingId);
  fetch(`http://localhost/masterpiece/trainigCrud/trainig_delete.php`, {
    method: "DELETE",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ training_id: trainingId }),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      const userList = document.getElementById("userList");
      const existingRow = userList.querySelector(`tr[data-id="${trainingId}"]`);
      if (existingRow) {
        existingRow.remove();
      }
      alert("Training deleted successfully");
      window.location.reload();
    })
    .catch((error) => {
      console.error("Error deleting training:", error);
      alert(error.message);
    });
}
