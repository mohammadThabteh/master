function validateAndSubmit() {
  var username = document.getElementById("username").value;
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;
  var confirmPassword = document.getElementById("confirmPassword").value;

  var hasError = false;
  if (!username || !email || !password || !confirmPassword) {
    alert("Please enter a username and email address and password")
    window.location.reload()
  }
  // Validate email using regex
  var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email)) {
    highlightError("email");
    hasError = true;
  }

  // Check password length
  if (password.length < 6) {
    highlightError("password");
    hasError = true;
  }

  // Check if passwords match
  if (password !== confirmPassword) {
    highlightError("password");
    highlightError("confirmPassword");
    hasError = true
  }
  if (hasError) {
    return alert("Please check errors below ")
  }

  // If validation passes, proceed with form submission
  var formData = {
    username: username,
    email: email,
    password: password
  };

  // Your existing fetch code
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
      console.log('Registration successful');
      window.location.href = 'http://127.0.0.1:5500/index.html';
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

function highlightError(fieldId) {
 let element =  document.getElementById(fieldId)
 console.log("element:", element);
 element.classList.add("error");
}

