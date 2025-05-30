<?php 
    $conn = mysqli_connect('localhost','root','','room_reservation');
    session_start();
    error_reporting(1);

    if(isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $sql = mysqli_query($conn, "SELECT * from login where username='$username'");
        $fetch = mysqli_fetch_assoc($sql);
            $id = $fetch['id'];
            $pw = $fetch['password'];
            $usertype = $fetch['usertype_id'];
        $row = mysqli_num_rows($sql);

        if ($row > 0) {
            if ($password == $pw) {
                session_start();
                if($usertype == '1') {
                    $_SESSION['id'] = $id;
                    echo "<script>alert('Logged admin account');</script>";
                    header('location:admin/admin.php');
                    exit();
                } else {
                    $profile = mysqli_query($conn, "SELECT * FROM `profile` WHERE `login_id`= '$id'");
                    $rows = mysqli_num_rows($profile);
                        if ($rows > 0) {
                            $_SESSION['id'] = $id;

                            header('location:user/dashboard.php');
                            exit();
                        } else {
                            $_SESSION['id'] = $id;
                            header('location:user/profile.php');
                            exit();
                        }
                }
            } else {
                echo "<script>alert('Invalid password');</script>";
                echo "<script>window.location.href='index.php';</script>";
                echo "<meta http-equiv='refresh' content='0'>";
                exit();
            }
        } else {
            echo "<script>alert('User not found.');</script>";
            echo "<script>window.location.href='index.php';</script>";
            echo "<meta http-equiv='refresh' content='0'>";
            exit();
        }

    }

     if(isset($_POST['register'])) {
        $username = $_POST['username'];
        $password = $_POST['pw'];
        $confirm = $_POST['confirm'];

        $sql = mysqli_query($conn, "SELECT * from login where username='$username'");
        $row = mysqli_num_rows($sql);

        if ($row > 0) {
            echo "<script>alert('Username already used. Please try again.');</script>";
            echo "<script>window.location.href='sign-up.php';</script>";
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            if ($password == $confirm) {
                // Hash the password

                // Insert into login table
                mysqli_query($conn, "INSERT INTO login (`username`, `password`,`usertype_id`) VALUES ('$username', '$password', '2')");
                    echo "<script>alert('Registration successful!');</script>";
                    echo "<script>window.location.href='index.php';</script>";
                    echo "<meta http-equiv='refresh' content='0'>";
            } else {
                echo "<script>alert('Passwords do not match. Please try again.');</script>";
                echo "<script>window.location.href='sign-up.php';</script>";
                echo "<meta http-equiv='refresh' content='0'>";
            }
        }
    }


    if (isset($_POST['add_room'])) {
        $name = $_POST['room_name'];
        $desc = $_POST['description'];
        $in = $_POST['open_in'];
        $out = $_POST['close_in'];
        $floor = $_POST['floor'];
        $type = $_POST['type'];
        $price = $_POST['price'];

        $targetDirectory = "assets/rooms/";

        // Get the original file extension
        $fileExtension = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        // Generate a unique filename using a timestamp
        $targetFile = $targetDirectory . $name . '.' . $fileExtension;

        $sql = mysqli_query($conn, "SELECT * FROM rooms WHERE name = '$name'");
        $fetch = mysqli_fetch_assoc($sql);
        $namef = $fetch['name'];

        if ($namef == $name) {
            echo "<script>alert('Product already exists. Please add a different one.');</script>";
            echo "<script>window.location.href='admin/add_room.php';</script>";
        } else {
            $check = getimagesize($_FILES["image"]["tmp_name"]);

            // Handle file upload
            if ($check !== false) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    // Continue with database insertion
                    $image = $targetFile;

                    // Insert the product information
                    $sql1 = "INSERT INTO `rooms`(`name`, `img`, `description`, `open_in`, `close_in`, `room_floor_id`, `room_type_id`, `price`, `room_status_id`) VALUES ('$name','$image','$desc','$in','$out','$floor','$type','$price', '2')";

                    if (mysqli_query($conn, $sql1)) {
                        $newProduct = mysqli_insert_id($conn);

                        foreach ($_POST['room_feature'] as $features) {
                            
                            $sql2 = "INSERT INTO `room_features`(`room_feature_id`, `rooms_id`) VALUES ('$features', '$newProduct')";

                            if (mysqli_query($conn, $sql2)) {
                                echo "<script>alert('New Room added successfully.');</script>";
                                echo "<script>window.location.href='admin/add_room.php';</script>";
                            } else {
                                echo "<script>alert('Error adding Room to inventory.');</script>";
                                echo "<script>window.location.href='admin/add_room.php';</script>";
                            }
                        }
                    } else {
                        echo "<script>alert('Error adding Room to database.');</script>";
                        echo "Error updating address: " . mysqli_error($conn);
                        echo "<script>window.location.href='add_room.php';</script>";
                    }
                } else {
                    echo "<script>alert('Error uploading file.');</script>";
                    echo "<script>window.location.href='admin/add_room.php';</script>";
                }
            } else {
                echo "<script>alert('Invalid file format.');</script>";
                echo "<script>window.location.href='add_room.php';</script>";
            }

            mysqli_close($conn);
        }
    }
        
    if (isset($_POST['updateProf'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $mname = $_POST['mname'];
        $contactno = $_POST['contactno'];
        $email = $_POST['email'];
        $bday = $_POST['bday'];
        $gender = $_POST['gender'];
        $province = $_POST['province'];
        $city = $_POST['city'];

        // Check if the user already has a profile
        $profileQuery = mysqli_query($conn, "SELECT * FROM profile WHERE login_id = {$_SESSION['id']}");
        $existingProfile = mysqli_fetch_assoc($profileQuery);

        // Insert or update address
        $addressQuery = mysqli_query($conn, "SELECT address_id FROM profile WHERE login_id = {$_SESSION['id']}");
        $fetch = mysqli_fetch_assoc($addressQuery);
        $address_id = $fetch['address_id'];

        if ($address_id) {
            $updateAddress = mysqli_query($conn, "UPDATE `address` SET `city_id`='$city', `province_id`='$province' WHERE `id` = '$address_id'");

            if (!$updateAddress) {
                echo "Error updating address: " . mysqli_error($conn);
            }
        } else {
            $addressInsertQuery = mysqli_query($conn, "INSERT INTO address ( `city_id`, `province_id` ) VALUES ('$city','$province')");

            if (!$addressInsertQuery) {
                echo "Error inserting new address: " . mysqli_error($conn);
            }

            $address_id = mysqli_insert_id($conn);
        }

        $contactQuery = mysqli_query($conn, "SELECT contact_id FROM profile WHERE login_id = {$_SESSION['id']}");
        $fetcher = mysqli_fetch_assoc($contactQuery);
        $contact_id = $fetcher['contact_id'];

        if ($contact_id) {

            $updateContact = mysqli_query($conn, "UPDATE contact SET `phoneNum`='$contactno', `email`='$email' WHERE `id`='$contact_id'");
            if (!$updateContact) {
                    echo "Error updating address: " . mysqli_error($conn);
                }

        } else {

            $contactInsertQuery = mysqli_query($conn, "INSERT INTO contact (`phoneNum`,`email`) VALUES ('$contactno','$email')");
                if (!$contactInsertQuery) {
                        echo "Error updating address: " . mysqli_error($conn);
                    }
                $contact_id = mysqli_insert_id($conn);
        }

        if ($existingProfile) {
            $profileUpdateQuery = mysqli_query($conn, "UPDATE profile SET `lname`='$lname', `fname`='$fname', `mname`='$mname', `address_id`='$address_id', `gender_id`='$gender', `bday`='$bday', `contact_id`='$contact_id' WHERE `login_id`={$_SESSION['id']}");
        } else {
            $profileInsertQuery = mysqli_query($conn, "INSERT INTO profile (`lname`, `fname`, `mname`, `address_id`, `gender_id`, `bday`, `contact_id`, `login_id`) VALUES ('$lname', '$fname', '$mname', '$address_id', '$gender', '$bday', '$contact_id', '{$_SESSION['id']}')");
        }

        if ($profileUpdateQuery || $profileInsertQuery) {
            echo "<script>alert('Profile created/updated successfully.');</script>";
            echo "<script>window.location.href='user/profile.php';</script>";
            echo "<meta http-equiv='refresh' content='0'>";
        } else {
            echo "<script>alert('Error creating/updating profile.');</script>";
            echo "<script>window.location.href='user/profile.php';</script>";
            echo "<meta http-equiv='refresh' content='0'>";
        }
    }

    


    if (isset($_POST['search_btn'])) {
        $search = $_POST['search'];
        header("location: dashboard.php?search=$search");
        exit();
    }

 
    

if (isset($_POST['update_room'])) {
    $room_id = intval($_POST['room_id']);
    $room_name = mysqli_real_escape_string($conn, $_POST['room_name']);
    $room_price = floatval($_POST['room_price']);
    $room_status = isset($_POST['room_status']) ? intval($_POST['room_status']) : $row['status']; // Default to current status if unchanged

    $sql = "UPDATE rooms 
            SET name = '$room_name', price = '$room_price', room_status_id = '$room_status' 
            WHERE id = '$room_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Room updated successfully!');</script>";
        echo "<script>window.location.href='admin/manage_rooms.php';</script>";
    } else {
        echo "Error updating room: " . mysqli_error($conn);
    }
}

if (isset($_POST['delete_room'])) {
    echo "<script>
        if (confirm('Are you sure you want to delete this room? This action cannot be undone.')) {
            window.location.href='admin/delete_room.php?room_id={$_POST['room_id']}';
        } else {
            window.location.href='admin/manage_rooms.php';
        }
    </script>";
    exit;
}

if (isset($_POST['edit_room'])) {
    $room_id = $_POST['room_id'];
    header("Location: admin/edit_room.php?room_id=$room_id");
    exit();
}

if (isset($_POST['book'])) {
    $login_id = $_POST['login_id'];
    $room_id = $_POST['room_id'];

    $sql = "INSERT INTO `review` (`login_id`, `room_id` )
            VALUES ('$login_id', '$room_id')";

    if (mysqli_query($conn, $sql)) {

    echo "<script>alert('Room successfully reservered');</script>";
    echo "<script>window.location.href='user/review.php';</script>";

    }

    exit();
}

// if (!isset($_SESSION['id'])) {
//     header('Location: index.php'); // Redirect if not logged in
//     exit();
// }

if (!isset($_SESSION['sbmtreview'])) {
    $room_id = $_POST['room_id'] ?? null;
    $content = trim($_POST['content'] ?? ''); // Trim to avoid whitespace-only content
    $login_id = $_SESSION['id'] ?? null; // Assuming user ID is stored in session

    // Validate inputs
    if (empty($room_id) || empty($content)) {
        echo "<script>alert('Review cannot be empty. Please write a valid review.');</script>";
        exit();
    }

    // Insert the new review into the database
    $stmt = $conn->prepare("INSERT INTO `review` (`room_id`, `login_id`, `review`) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $room_id, $login_id, $content);

    if ($stmt->execute()) {
        header("Location: user/write_review.php?room_id=$room_id"); // Redirect back to the reviews page
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

