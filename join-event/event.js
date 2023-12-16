document.addEventListener("DOMContentLoaded", function () {
  fetch(`http://localhost/masterpiece/event_crud/event_read.php`, {
    method: "GET",
    headers: { "Content-Type": "application/json" },
  })
    .then((response) => response.json())
    .then((data) => {
      displayAcceptedCards(data);
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
          <p class="card-text">event start: ${entry.event_start}</p>
          <p class="card-text">event_end: ${entry.event_end}</p>
          <button class="btn btn-danger" onclick="joinEvent('${entry.event_id}')">Join Event</button>
        </div>
      `;
      cardsSection.appendChild(card);
    });
  }
});
function joinEvent(id) {
  const user_id = sessionStorage.getItem("USER_ID");
  fetch(`http://localhost/masterpiece/event_crud/insertintoevent.php`, {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id: user_id, event_id: id }),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      alert(data.message);
    })
    .catch((error) => {
      console.log(error);
      alert(error.message);
    });
}
