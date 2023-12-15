    function submitForm() {
        event.preventDefault();

        const animalDescription = document.getElementById('animal_description').value;
        const price = document.getElementById('price').value;

        const formData = {
          description: animalDescription,
          order_price: price
        }

        fetch('http://localhost/masterpiece/booking_reservation/creatBooking.php', {
            method: 'POST',
            headers: {  'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            console.log('Response from the server:', data);
            console.log("data received");
        })
        .catch(error => {
            // Handle errors
            console.error('Error:', error);
        });
    }
