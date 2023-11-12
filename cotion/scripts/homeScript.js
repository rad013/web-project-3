function downloadGuideBook(type) {
  alert("You are about to download the " + type + " Guide Book.");
}

function validateRegister() {
  let name = prompt("Please enter your name:");
  let email = prompt("Please enter your email:");

  let regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

  if (name == "" || email == "" || !regex.test(email)) {
    alert("Invalid name or email. Please try again.");
    return false;
  }

  alert(
    "You have successfully registered for the competition. We will send you a confirmation email soon."
  );
  return true;
}
