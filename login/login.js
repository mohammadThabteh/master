function submitLoginForm(event) {
  event.preventDefault();
  var email = document.getElementById("email").value;
  var password = document.getElementById("password").value;

  var formData = {
    email: email,
    password: password,
  };
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
        sessionStorage.setItem("email", data.email);
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
