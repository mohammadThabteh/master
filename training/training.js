document.addEventListener("DOMContentLoaded", function () {
  const user_id = sessionStorage.getItem("USER_ID");
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

  fetch("http://localhost/masterpiece/trainigCrud/training_read.php")
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      const trainingIdSelect = document.getElementById("training_id");

      data.forEach((training) => {
        const option = document.createElement("option");
        option.value = training.training_id;
        option.text = training.name;
        trainingIdSelect.appendChild(option);
      });
    })
    .catch((error) => console.error("Error fetching data:", error));
});

async function submitPetInfoForm() {
  try {
    const animal_id = document.getElementById("animal_id").value;
    const training_id = document.getElementById("training_id").value;

    const petInfoFormData = {
      animal_id: animal_id,
      training_id: training_id,
      training_date: document.getElementById("training_date").value,
      training_end_date: document.getElementById("training_end_date").value,
      price: document.getElementById("price").value,
      description: document.getElementById("description").value,
    };
    console.log(petInfoFormData);
    const addPetInfoResponse = await fetch(
      "http://localhost/masterpiece/trainigCrud/insertUser.php",
      {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        headers: { Accept: "application/json" },
        body: JSON.stringify(petInfoFormData),
      }
    );
    let petInfoData = await addPetInfoResponse.json();
    console.log(petInfoData);
    alert(petInfoData.message)
    window.location.reload();
  } catch (error) {
    console.log(error);
    alert(error.message)
  }
}
document.getElementById("petForm").addEventListener("submit", function (event) {
  event.preventDefault();
});
