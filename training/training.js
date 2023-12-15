async function submitPetInfoForm() {
  try {
    const petFormData = {
      name: document.getElementById('name').value,
      age: document.getElementById('age').value,
      user_id: sessionStorage.getItem("USER_ID")
    }
    console.log(petFormData);
    const addPetResponse = await fetch('http://localhost/masterpiece/pet_profile/pet_creat.php', {
      method: 'POST',
      headers: {  'Content-Type': 'application/json' },
      body: JSON.stringify(petFormData),
    })
    let petInfo = await addPetResponse.json()
    const petInfoFormData = {
        animal_id: petInfo.id,
        training_id: "2",
        training_date: document.getElementById('training_date').value,
        training_end_date: document.getElementById('training_end_date').value,
        price: document.getElementById('price').value,
        description: document.getElementById('description').value
      }

      const addPetInfoResponse = await fetch('http://localhost/masterpiece/trainigCrud/insertUser.php', {
        method: 'POST',
        headers: {  'Content-Type': 'application/json' },
        body: JSON.stringify(petInfoFormData),
      })
      let petInfoData = await addPetInfoResponse.json();
      console.log(petInfoData);
  } catch (error) {
    console.log(error);
  }   
}
  document.getElementById('petForm').addEventListener('submit', function (event) {
  event.preventDefault(); 
  });