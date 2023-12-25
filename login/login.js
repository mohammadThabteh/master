function submitLoginForm(event) {
  event.preventDefault();
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;
  if (!email || !password) {
    alert("Please enter a username and email address and password")
    window.location.reload()
  }
  var hasError = false;

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

  if (hasError) {
    return alert("Please check errors below ")
  }

  var formData = {
    email: email,
    password: password,
  }

  console.log(formData);
  fetch("http://localhost/masterpiece/sign_up&in/login.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(formData),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      if (data.STATUS === true) {
        console.log("Login successful");
        sessionStorage.setItem("isLoggedIn", true);
        sessionStorage.setItem("USER_ID", data.USER_ID);
        sessionStorage.setItem("role", data.ROLE);
        sessionStorage.setItem("email", formData.email);
        window.location.href = "http://127.0.0.1:5500/index.html";
      } else {
        console.error("Login failed");
        alert("Login failed. Please check your credentials and try again.");
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("An error occurred. Please try again later.");
    });
}
function highlightError(fieldId) {
 let element =  document.getElementById(fieldId)
 element.classList.add("error");
}