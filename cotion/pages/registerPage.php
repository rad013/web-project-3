<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dbHost = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "cotion";

    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    function insert_user($conn, $email, $password)
    {

        $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $email, $password);
        if (!$stmt->execute()) {
            alert("Error: " . mysqli_error($conn));
            return false;
        }
        return $stmt->insert_id;
    }

    function insert_team($conn, $team_name, $leader_name, $leader_gender, $leader_dob, $leader_phone_number, $leader_address, $leader_institution, $competition_branch, $id_card)
    {

        $sql = "INSERT INTO teams (team_name, leader_name, leader_gender, leader_dob, leader_phone_number, leader_address, leader_institution, competition_branch, leader_id_card) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $team_name, $leader_name, $leader_gender, $leader_dob, $leader_phone_number, $leader_address, $leader_institution, $competition_branch, $id_card);
        if (!$stmt->execute()) {
            alert("Error: " . mysqli_error($conn));
            return false;
        }
        return $stmt->insert_id;
    }

    function update_team_member($conn, $team_id, $member_index, $member_name, $member_gender, $member_dob, $member_phone_number, $member_address, $member_institution, $member_email, $member_id_card)
    {

        if ($member_index == 1) {

            $sql = "UPDATE teams SET member1_name=?, member1_gender=?, member1_dob=?, member1_phone_number=?, member1_address=?, member1_institution=?, member1_email=?, member1_id_card=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                alert("Error: " . mysqli_error($conn));
                return false;
            }
            if (!$stmt->bind_param("ssssssssi",
                $member_name,
                $member_gender,
                $member_dob,
                $member_phone_number,
                $member_address,
                $member_institution,
                $member_email,
                $member_id_card,
                $team_id)) {
                alert("Error: " . mysqli_error($conn));
                return false;
            }
            if (!$stmt->execute()) {
                alert("Error: " . mysqli_error($conn));
                return false;
            }
        } else {

            $sql = "UPDATE teams SET member2_name=?, member2_gender=?, member2_dob=?, member2_phone_number=?, member2_address=?, member2_institution=?, member2_email=?, member2_id_card=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                alert("Error: " . mysqli_error($conn));
                return false;
            }
            if (!$stmt->bind_param("ssssssssi",
                $member_name,
                $member_gender,
                $member_dob,
                $member_phone_number,
                $member_address,
                $member_institution,
                $member_email,
                $member_id_card,
                $team_id)) {
                alert("Error: " . mysqli_error($conn));
                return false;
            }
            if (!$stmt->execute()) {
                alert("Error: " . mysqli_error($conn));
                return false;
            }
        }
    }

    function alert($msg)
    {
        header('Content-Type: application/json');
        echo json_encode(['alert' => $msg]);
        exit;
    }

    $team_name = $_POST['team_name'];
    $leader_name = $_POST['leader_name'];
    $leader_gender = $_POST['gender'];
    $leader_dob = $_POST['dob'];
    $leader_phone_number = $_POST['phone_number'];
    $leader_address = $_POST['address'];
    $leader_institution = $_POST['institution'];
    $competition_branch = $_POST['competition_branch'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $id_card = $_FILES['id_card']['name'];

    move_uploaded_file($_FILES['id_card']['tmp_name'], 'uploads/' . $id_card);

    $user_id = insert_user($conn, $email, $password);

    $team_id = insert_team($conn, $team_name, $leader_name, $leader_gender, $leader_dob, $leader_phone_number, $leader_address, $leader_institution, $competition_branch, $id_card);

    for ($i = 1; $i <= 2; $i++) {
        if (!empty($_POST["member{$i}_name"])) {
            $member_name = $_POST["member{$i}_name"];
            $member_gender = $_POST["member{$i}_gender"];
            $member_dob = $_POST["member{$i}_dob"];
            $member_phone_number = $_POST["member{$i}_phone_number"];
            $member_address = $_POST["member{$i}_address"];
            $member_institution = $_POST["member{$i}_institution"];
            $member_email = $_POST["member{$i}_email"];
            if (!empty($_FILES["member{$i}_id_card"]['name'])) {
                $member_id_card = $_FILES["member{$i}_id_card"]['name'];
                move_uploaded_file($_FILES["member{$i}_id_card"]['tmp_name'], 'uploads/' . $member_id_card);
            } else {
                $member_id_card = null;
            }
            update_team_member($conn, $team_id, $i, $member_name, $member_gender, $member_dob, $member_phone_number, $member_address, $member_institution, $member_email, $member_id_card);
        }
    }

    alert("Successfully registered");

}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/styles/registerStyle.css" />
    <title>Register</title>
  </head>
  <body>
    <img src="assets/cotion-logo.png" alt="logo" />

    <div class="form_container">
      <h1>Registration</h1>
      <form method="post" enctype="multipart/form-data">
        <h2>Team Leader Information (Mandatory)</h2>
        <br>
        <label for="team_name">Team Name</label><br />
        <input type="text" id="team_name" name="team_name" /><br />

        <label for="leader_name">Full Name</label><br />
        <input type="text" id="leader_name" name="leader_name" /><br />

        <label for="gender">Gender</label><br />
        <select id="gender" name="gender">
          <option value="" disabled selected>Select Gender</option>
          <option value="male">Male</option>
          <option value="female">Female</option></select
        ><br />

        <label for="dob">Date of Birth</label><br />
        <input type="date" id="dob" name="dob" /><br />

        <label for="phone_number">Phone Number</label><br />
        <input type="tel" id="phone_number" name="phone_number" /><br />

        <label for="address">Address</label><br />
        <input type="text" id="address" name="address" /><br />

        <label for="institution">Institution</label><br />
        <input type="text" id="institution" name="institution" /><br />

        <label for="competition_branch">Competition Branch</label><br />
        <select id="competition_branch" name="competition_branch">
          <option value="" disabled selected>Select Competition Branch</option>
          <option value="UI/UX">UI/UX</option>
          <option value="IT-Case">IT-Case</option></select
        ><br /><label for="email">Email</label><br />
        <input type="email" id="email" name="email" /><br />

        <label for="password">Password</label><br />
        <input type="password" id="password" name="password" /><br />

        <label for="id_card">Upload ID Card</label><br />
        <input type="file" id="id_card" name="id_card" /><br />
        <hr />
        <br />
        <h2>Team Member 1 Information (Optional)</h2>
        <br>
        <label for="member1_name">Full Name</label><br />
        <input type="text" id="member1_name" name="member1_name" /><br />

        <label for="member1_gender">Gender</label><br />
        <select id="member1_gender" name="member1_gender">
          <option value="" disabled selected>Select Gender</option>
          <option value="male">Male</option>
          <option value="female">Female</option></select
        ><br />

        <label for="member1_dob">Date of Birth</label><br />
        <input type="date" id="member1_dob" name="member1_dob" /><br />

        <label for="member1_phone_number">Phone Number</label><br />
        <input
          type="tel"
          id="member1_phone_number"
          name="member1_phone_number"
        /><br />

        <label for="member1_address">Address</label><br />
        <input type="text" id="member1_address" name="member1_address" /><br />
        <label for="member1_institution">Institution</label><br />
        <input
          type="text"
          id="member1_institution"
          name="member1_institution"
        /><br />

        <label for="member1_email">Email</label><br />
        <input type="email" id="member1_email" name="member1_email" /><br />

        <label for="member1_id_card">Upload ID Card</label><br />
        <input type="file" id="member1_id_card" name="member1_id_card" /><br />
        <hr />
        <br />
        <h2>Team Member 2 Information (Optional)</h2>
        <br>
        <label for="member2_name">Full Name</label><br />
        <input type="text" id="member2_name" name="member2_name" /><br />

        <label for="member2_gender">Gender</label><br />
        <select id="member2_gender" name="member2_gender">
          <option value="" disabled selected>Select Gender</option>
          <option value="male">Male</option>
          <option value="female">Female</option></select
        ><br />

        <label for="member2_dob">Date of Birth</label><br />
        <input type="date" id="member2_dob" name="member2_dob" /><br />

        <label for="member2_phone_number">Phone Number</label><br />
        <input
          type="tel"
          id="member2_phone_number"
          name="member2_phone_number"
        /><br />
        <label for="member2_address">Address</label><br />
        <input type="text" id="member2_address" name="member2_address" /><br />

        <label for="member2_institution">Institution</label><br />
        <input
          type="text"
          id="member2_institution"
          name="member2_institution"
        /><br />

        <label for="member2_email">Email</label><br />
        <input type="email" id="member2_email" name="member2_email" /><br />

        <label for="member2_id_card">Upload ID Card</label><br />
        <input type="file" id="member2_id_card" name="member2_id_card" />

        <input
          class="submit"
          type="submit"
          value="Register"
        />
      </form>

      <p>
        Already have an account?
        <a href="loginPage.php">Login</a>
      </p>    </div>
    <div class="footer">
      <h3>&copy; 2502021310 Muhammad Radityo Wicaksono</h3>
    </div>
  </body>

  <script>
    const form = document.querySelector("form");
    form.addEventListener("submit", (event) => {
      event.preventDefault();
      let isValid = true;
      const teamLeaderFields = [
        "team_name",
        "leader_name",
        "gender",
        "dob",
        "phone_number",
        "address",
        "institution",
        "competition_branch",
        "email",
        "password",
        "id_card",
      ];
      for (let i = 0; i < teamLeaderFields.length; i++) {
        const field = teamLeaderFields[i];
        const input = document.querySelector(`#${field}`);
        if (!input.value) {
          isValid = false;
          alert(`${field} is required`);
          break;
        }
      }
      if (isValid) {
        const teamMemberFields = [
          "name",
          "gender",
          "dob",
          "phone_number",
          "address",
          "institution",
          "email",
          "id_card",
        ];
        for (let i = 1; i <= 2; i++) {
          let isMemberValid = true;
          for (let j = 0; j < teamMemberFields.length; j++) {
            const field = teamMemberFields[j];
            const input = document.querySelector(`#member${i}_${field}`);
            if (!input.value) {
              isMemberValid = false;
              break;
            }
          }
          if (!isMemberValid) {
            for (let j = 0; j < teamMemberFields.length; j++) {
              const field = teamMemberFields[j];
              const input = document.querySelector(`#member${i}_${field}`);
              if (input.value) {
                isValid = false;
                alert(`Please fill in all fields for member ${i}`);
                break;
              }
            }
          }
          if (!isValid) {
            break;
          }
        }
      }
      if (isValid) {

        const formData = new FormData(form);

        fetch("registerPage.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.alert) {
              alert(data.alert);
            }
            window.location.href = "loginPage.php";
          })
          .catch((error) => console.error(error));
      }
    });
  </script>
</html>
