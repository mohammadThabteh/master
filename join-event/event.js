var user_id = sessionStorage.getItem("USER_ID");
document.addEventListener("DOMContentLoaded", function () {
  fetch(`http://localhost/masterpiece/event_crud/event_read.php`, {
    method: "GET",
    headers: { "Content-Type": "application/json" },
  })
    .then((response) => response.json())
    .then((data) => {
      displayAcceptedCards(data);
      return data;
    })
    .then((data) => {
      fetch("http://localhost/masterpiece/event_crud/showEventUser.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ user_id: user_id }),
      })
        .then((response) => response.json())
        .then((user_events) => {
          let user_events_ids = user_events.events.map((event) => {
            return event.event_id;
          });
          console.log(user_events_ids);
          for (let i = 0; i < data.length; i++) {
            const event = data[i];
            if (user_events_ids.includes(event.event_id)) {
              let button = document.getElementById(`button${event.event_id}`);
              button.style.display = "none";
            }
          }
          console.log(data);
        })
        .catch((error) => console.error("Error fetching user data:", error));
    })
    .catch((error) => console.error("Error fetching data:", error));

  function displayAcceptedCards(data) {
    const cardsSection = document.getElementById("acceptedCardsSection");
    cardsSection.innerHTML = "";
    data.forEach((entry) => {
      const card = document.createElement("div");
      card.className = "card mb-5";
      card.innerHTML = `
        <div class="card-body">
          <p class="card-text">Description: ${entry.event_description}</p>
          <p class="card-text">event max guests: ${entry.event_max_guests}</p>
          <p class="card-text">category: ${entry.event_category}</p>
          <p class="card-text">event start: ${new Date(entry.event_start).toLocaleDateString()}</p>
          <p class="card-text">event end: ${new Date(entry.event_end).toLocaleDateString()}</p>
          <button id=button${entry.event_id} class="btn btn-danger" onclick="joinEvent('${entry.event_id}')">Join Event</button>
        </div>
      `;
      cardsSection.appendChild(card);
    });
  }
});
function joinEvent(id) {
  fetch(`http://localhost/masterpiece/event_crud/insertintoevent.php`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id: user_id, event_id: id }),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      alert(data.message);
      window.location.reload();
    })
    .catch((error) => {
      console.log(error);
      alert(error.message);
    });
}
