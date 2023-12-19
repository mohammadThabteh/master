document.addEventListener("DOMContentLoaded", function () {
  const userList = document.getElementById("userList");
  function createRow(event) {
    const row = document.createElement("tr");
    row.innerHTML = `
            <td>${event.event_id}</td>
            <td>${event.event_description}</td>
            <td>${event.event_category}</td>
            <td>${event.event_start}</td>
            <td>${event.event_end}</td>
            <td class="action-buttons">
                <button class="edit-button" onclick="updateEvent(${event.event_id})">Edit</button>
                <button class="delete-button" onclick="deleteEvent(${event.event_id})">Delete</button>
            </td>
        `;
    return row;
  }
  window.updateEvent = function (id) {
    // Redirect to the editUser.html page with the user ID
    window.location.href = `editEvent.html?id=${encodeURIComponent(id)}`;
  };
  fetch("http://localhost/masterpiece/event_crud/event_read.php")
    .then((response) => response.json())
    .then((data) => {
      data.forEach((event) => {
        const row = createRow(event);
        userList.appendChild(row);
      });
    })
    .catch((error) => {
      console.error("Error fetching user data:", error);
    });
});

const addUserForm = document.getElementById("addUserForm");
addUserForm.addEventListener("submit", function (event) {
  event.preventDefault();
  const userList = document.getElementById("userList");
  const event_start = document.getElementById("event_start").value;
  const event_end = document.getElementById("event_end").value;
  const event_description = document.getElementById("event_description").value;
  const event_max_guests = document.getElementById("event_max_guests").value;
  const event_category = document.getElementById("event_category").value;

  const newEvent = {
    event_start: event_start,
    event_end: event_end,
    event_description: event_description,
    event_max_guests: event_max_guests,
    event_category: event_category,
    event_image: "image.png",
  };

  // Call the API to add a new user
  fetch("http://localhost/masterpiece/event_crud/event_create.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(newEvent),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      alert("created successfully");
      window.location.reload();
    })
    .catch((error) => {
      console.error("Error adding user:", error);
      alert(error.message);
      window.location.reload();
    });
});

function updateEventHandler() {
  const event_start = document.getElementById("event_start").value;
  const event_description = document.getElementById("event_description").value;
  const event_max_guests = document.getElementById("event_max_guests").value;
  const event_category = document.getElementById("event_category").value;
  const searchParams = new URLSearchParams(window.location.search);
  const id = searchParams.get("id");

  const updateEvent = {
    event_id: id,
    event_start: event_start,
    event_description: event_description,
    event_max_guests: event_max_guests,
    event_category: event_category,
    event_image: "image.png",
  };
  console.log(JSON.stringify(updateEvent));

  fetch("http://localhost/masterpiece/event_crud/event_edit.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    headers: { Accept: "application/json" },
    body: JSON.stringify(updateEvent),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      alert(data.message);
      window.location.href = "http://127.0.0.1:5500/dashboard/events.html";
    })
    .catch((error) => {
      console.error("Error updating training:", error);
      alert(error.message);
    });
}

function deleteEvent(id) {
  console.log(id);
  fetch(`http://localhost/masterpiece/event_crud/event_delete.php`, {
    method: "DELETE",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ event_id: id }),
  })
    .then((response) => {
      if (response.ok) {
        return response.json();
      }
      throw new Error("Failed to delete event");
    })
    .then((data) => {
      console.log(data);
      // Remove the deleted user row from the table
      const deletedRow = document.querySelector(`[data-id="${id}"]`);
      if (deletedRow) {
        deletedRow.remove();
      }
      alert(data.message);
      window.location.reload();
    })
    .catch((error) => {
      console.error("Error deleting user:", error);
      alert("error deleting event");
    });
}
