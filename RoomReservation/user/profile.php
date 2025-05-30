<?php
    $conn = mysqli_connect('localhost', 'root', '', 'room_reservation');
    session_start();
    error_reporting(1);

    if (isset($_SESSION['id'])) {
        #echo "Login ID: " . $_SESSION['id'];
    } else {
        #echo "No session started.";
    }

    if($_SESSION['id'] == 1) {
        echo "<script>alert('Restricted area.');</script>";
        echo '<meta http-equiv="refresh" content="0;url=admin.php">';
    exit();
    }

    $sql = mysqli_query($conn, "SELECT p.*, 
       a.*, 
       c.*, 
       g.*, 
       pr.name AS province_name, 
       ct.name AS city_name
FROM profile p 
INNER JOIN address a ON p.address_id = a.id 
INNER JOIN contact c ON p.contact_id = c.id 
INNER JOIN gender g ON p.gender_id = g.id
INNER JOIN province pr ON a.province_id = pr.id  
INNER JOIN city ct ON a.city_id = ct.id
WHERE p.login_id = {$_SESSION['id']}
");

        if (!$sql) {
            echo "Error: " . mysqli_error($conn);
        } else {
            $fetch = mysqli_fetch_assoc($sql);
            $fname = $fetch['fname'];
            $lname = $fetch['lname'];
            $mname = $fetch['mname'];
            $contactno = $fetch['phoneNum'];
            $email = $fetch['email'];
            $bday = $fetch['bday'];
            $selectedGender = $fetch['gender_id'];
            $province = $fetch['province_name'];
            $city = $fetch['city_name'];
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
     <script>
        function populateCities() {
    var provinceDropdown = document.getElementById("province");
    var selectedProvince = parseInt(provinceDropdown.value, 10);
    console.log("Selected Province:", selectedProvince);

    var cityDropdown = document.getElementById("city");

    // Clear existing options, excluding the default option
    cityDropdown.innerHTML = '<option value="" disabled selected>Select your city</option>';

    // Fetch cities for the selected province from the database
    fetch(`../get_cities.php?province_id=${selectedProvince}`)
        .then(response => response.json())
        .then(data => {
            console.log("Cities Data:", data);

            // Add cities to the dropdown
            data.forEach(city => {
                addCityOption(city);
            });
        })
        .catch(error => console.error('Error:', error));
}

function addCityOption(city) {
    var option = document.createElement("option");
    option.value = city.id;  // Assuming 'id' is the value you want to use
    option.text = city.name;  // Assuming 'cname' is the display text
    document.getElementById("city").add(option);
}

// If you don't need barangays, you can remove the related functions

// You can keep this part for setting city selection if you need
function setCityId() {
    var cityDropdown = document.getElementById("city");
    var cityIdInput = document.getElementById("city_id"); // Hidden input field for city ID

    // Set the city_id value based on the selected city
    cityIdInput.value = cityDropdown.value;
    console.log("Selected City:", cityDropdown.value);
    console.log("City ID:", cityIdInput.value);
}

      </script>

    <title>NGARAN IYO HOTEL OR RENTAHAN</title> <!-- balyue nala ngan remove ine na comment-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="../assets/hotel.png">
    <link rel="stylesheet" type="text/css" href="../assets/des.css">

</head>
<body>

    <div class="user-side-nav">
    <img src="../assets/hotel.png" alt="Logo" style="width:85px; height: 75px; padding-top: 20px; padding: 10px; margin: 10px;">
    
    <a href="dashboard.php">Rooms</a>
    <a href="profile.php">Profile</a>
    <a href="review.php">Review</a>
    <a href="../logout.php">Log out</a>
    </div>
           <div class="add-room-container">
          <h2>Your Profile</h2>

          <form action="../config.php" method="POST">
            <div class="form-group-add-room">
              <label for="fname">First Name: </label>
              <input type="text" id="fname" name="fname" required value="<?php echo $fname ?>">
            </div>

            <div class="form-group-add-room">
              <label for="mname">Middle Name</label>
              <input type="text" id="mname" name="mname" required value="<?php echo $mname ?>">
            </div>

            <div class="form-group-add-room">
              <label for="lname">Last Name</label>
              <input type="text" id="lname" name="lname" required value="<?php echo $lname ?>">
            </div>

            <div class="form-group-add-room">
             <label for="lname">Province: </label>
            <select id="province" name="province" onchange="populateCities()" required>
                <option value="" disabled selected>Select your province</option>

                <?php
                  $conn = mysqli_connect('localhost', 'root', '', 'room_reservation');
                  error_reporting(1);
                  $sql = mysqli_query($conn, "SELECT * FROM province");

                  while ($fetch = mysqli_fetch_assoc($sql)) {
                    $provinceId = $fetch['id'];
                    $pname = $fetch['name'];
                    echo "<option value=\"$provinceId\" " . ($province == $provinceId ? 'selected' : '') . ">$pname</option>";
                  }

                ?>
            </select>
            </div>

            <div class="form-group-add-room">
            <label for="lname">City: </label>
            <select id="city" name="city" required>
                <option value="" disabled selected>Select your city</option>
            </select>
            </div>

            <div class="form-group-add-room">
              <label for="bday">Birthday</label>
              <input type="date" id="bday" name="bday" required value="<?php echo $bday ?>">
            </div>

          <div class="form-group-add-room">
          <label for="gender">Gender:</label>
            <select id="gender" name="gender" required class="compact-select">
                <option value="" disabled selected>Select One</option>
                <?php
                $sql = mysqli_query($conn, "SELECT * from gender");
                while ($fetch = mysqli_fetch_assoc($sql)) {
                    $id = $fetch['id'];
                    $cat = $fetch['name'];
                    echo "<option value='$id'>$cat</option>";
                }
                ?>
            </select>
            </div>

            <div class="form-group-add-room">
              <label for="contact">Contact Number:</label>
              <input type="text" id="contact" name="contactno" required value="<?php echo $contactno ?>">
            </div>

                <div class="form-group-add-room">
                  <label for="contact">Email address:</label>
                  <input type="email" name="email" required value="<?php echo $email ?>">
                </div>

            <input type="submit" class="submit-button" name="updateProf">
          </form>
        </div>

     
</body>
</html>
