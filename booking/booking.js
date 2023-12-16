document.addEventListener("DOMContentLoaded", function () {
  const user_id = sessionStorage.getItem("USER_ID");
  fetch(
    `http://localhost/masterpiece/booking_reservation/OrderPendingForUser.php?user_id=${user_id}`,
    {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    }
  )
    .then((response) => response.json())
    .then((data) => {
      displayCards(data);
    })
    .catch((error) => console.error("Error fetching data:", error));

  fetch(
    `http://localhost/masterpiece/booking_reservation/OrderAcceptedForUser.php?user_id=${user_id}`,
    {
      method: "GET",
      headers: { "Content-Type": "application/json" },
    }
  )
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
          <h5 class="card-title">${entry.animal_name}</h5>
          <p class="card-text">Start Date: ${entry.start_date}</p>
          <p class="card-text">End Date: ${entry.end_date}</p>
          <p class="card-text">Total Price: ${entry.total_price}</p>
          <p class="card-text">Status: ${entry.status}</p>
        </div>
      `;
      cardsSection.appendChild(card);
    });
  }

  function displayCards(data) {
    const cardsSection = document.getElementById("cardsSection");

    cardsSection.innerHTML = "";
    data.forEach((entry) => {
      const card = document.createElement("div");
      card.className = "card mb-5";
      card.innerHTML = `
        <div class="card-body">
          <h5 class="card-title">${entry.animal_name}</h5>
          <p class="card-text-accepted">Start Date: ${entry.start_date}</p>
          <p class="card-text-accepted">End Date: ${entry.end_date}</p>
          <p class="card-text-accepted">Total Price: ${entry.total_price}</p>
          <p class="card-text-accepted">Status: ${entry.status}</p>
        </div>
      `;
      cardsSection.appendChild(card);
    });
  }

  fetch("http://localhost/masterpiece/usersPet/user_petNames.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ user_id }),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      const animalIdSelect = document.getElementById("animal_id");

      data.forEach((animal) => {
        const option = document.createElement("option");
        option.value = animal.id;
        option.text = animal.name;
        animalIdSelect.appendChild(option);
      });
    })
    .catch((error) => console.error("Error fetching data:", error));
});

function submitForm(event) {
  event.preventDefault();
  const user_id = sessionStorage.getItem("USER_ID");
  const start_date = document.getElementById("start_date").value;
  const end_date = document.getElementById("end_date").value;
  const animal_id = document.getElementById("animal_id").value;
  let send_data = {
    animal_id: animal_id,
    user_id: user_id,
    start_date: start_date,
    end_date: end_date,
  };
  console.log(send_data);
  fetch(
    "http://localhost/masterpiece/booking_reservation/user_creatReservation.php",
    {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(send_data),
    }
  )
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      alert(data.message);
      window.location.reload();
    })
    .catch((error) => {
      console.error("Error fetching data:", error);
      alert(error.message);
    })
}