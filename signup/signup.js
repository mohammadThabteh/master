function submitForm() {
    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
  
    var formData = {
      username: username,
      email: email,
      password: password
    }
  
    fetch('http://localhost/masterpiece/sign_up&in/signup.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);
      if (data.success === true) {
        sessionStorage.setItem('isLoggedIn', true);
        sessionStorage.setItem('username', username);
        sessionStorage.setItem('email', email);
        console.log('Registration successful')
        window.location.href = 'http://127.0.0.1:5500/NewBiz/index.html'
      } else {
        console.error('Registration failed:', data.message);
        alert('Registration failed. Please try again.');
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred. Please try again later.');
    });
  }
  