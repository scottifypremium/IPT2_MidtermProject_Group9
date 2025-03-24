<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $new_username = trim($_POST['username']);
    $new_password = trim($_POST['password']);

    if (empty($new_username) || empty($new_password)) {
        echo "<script>alert('Username and Password cannot be empty!');</script>";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Handle file upload for profile image
        if (!empty($_FILES['profile_image']['name'])) {
            $targetDir = "assets/img/profiles/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true); // Create the directory if it doesn't exist
            }
            $targetFile = $targetDir . basename($_FILES['profile_image']['name']);
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if the file is an image
            $check = getimagesize($_FILES['profile_image']['tmp_name']);
            if ($check !== false) {
                // Move the uploaded file to the target directory
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $targetFile)) {
                    $profile_image = $targetFile; // Use the uploaded file
                } else {
                    echo "<script>alert('Failed to upload image. Please check directory permissions.');</script>";
                    $profile_image = 'assets/img/default-profile.jpg'; // Fallback to default image
                }
            } else {
                echo "<script>alert('File is not an image.');</script>";
                $profile_image = 'assets/img/default-profile.jpg'; // Fallback to default image
            }
        } else {
            // Use the selected suggestion or default image
            $profile_image = $_POST['selected_profile_image'] ?? 'assets/img/default-profile.jpg';
        }

        // Check if username exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
        $stmt->bind_param("s", $new_username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('Username already exists!');</script>";
        } else {
            // Insert new user with profile image
            $stmt = $conn->prepare("INSERT INTO users (username, password, profile_image) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $new_username, $hashed_password, $profile_image);
            if ($stmt->execute()) {
                // Store user data in session after successful registration
                $_SESSION['user_id'] = $stmt->insert_id; // Get the newly inserted user ID
                $_SESSION['username'] = $new_username;
                $_SESSION['profile_image'] = $profile_image;

                echo "<script>alert('Account created successfully! You can now log in.');</script>";
                header("Location: index.php"); // Redirect to the home page
                exit();
            } else {
                echo "<script>alert('Error creating account!');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>CICTEsports Register</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style_register.css">
  <link rel="stylesheet" href="assets/css/style_modal_register.css">
  
</head>
<body>
<div class="container">

<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

        <div class="d-flex justify-content-center py-4">
          <a href="index.html" class="logo d-flex align-items-center w-auto">
            <div class="bi bi-controller"></div>
            <span class="d-none d-lg-block">CICTEsports</span>
          </a>
        </div><!-- End Logo -->

        <div class="card mb-3">
          <div class="card-body">
            <div class="pt-4 pb-2">
              <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
              <p class="text-center small">Enter your details to register</p>
            </div>

            <form class="row g-3 needs-validation" novalidate method="post">
              <div class="col-12">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="Enter your username" required>
                <div class="invalid-feedback">Please enter a username.</div>
              </div>

              <div class="col-12">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                <div class="invalid-feedback">Please enter a valid email address.</div>
              </div>

              <div class="col-12">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                <div class="invalid-feedback">Please enter a password.</div>
              </div>

              <div class="col-12">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm your password" required>
                <div class="invalid-feedback">Please confirm your password.</div>
              </div>

              <div class="col-12">
    <label for="profile_image" class="form-label">Profile Picture</label>
    <input type="file" name="profile_image" class="form-control" id="profile_image" accept="image/*">
    <div class="invalid-feedback">Please upload a valid image file.</div>
</div>

<div class="col-12">
    <label class="form-label">Or choose from our suggestions:</label>
    <div class="row">
        <div class="col-2">
            <img src="assets/img/profile-img.jpg" alt="Suggestion 1" class="img-thumbnail profile-suggestion" onclick="selectProfileSuggestion('assets/img/profile-img.jpg')">
        </div>
        <div class="col-2">
            <img src="assets/img/dog.jpg" alt="Suggestion 2" class="img-thumbnail profile-suggestion" onclick="selectProfileSuggestion('assets/img/dog.jpg')">
        </div>
        <div class="col-2">
            <img src="assets/img/hacker.jpg" alt="Suggestion 3" class="img-thumbnail profile-suggestion" onclick="selectProfileSuggestion('assets/img/hacker.jpg')">
        </div>
        <div class="col-2">
            <img src="assets/img/profile-game.jpg" alt="Suggestion 4" class="img-thumbnail profile-suggestion" onclick="selectProfileSuggestion('assets/img/profile-game.jpg')">
        </div>
    </div>
</div>

<!-- Profile Image Preview -->
<div class="col-12 text-center">
    <img id="profile_image_preview" src="" alt="Selected Profile Picture" style="display: none; max-width: 100px; margin-top: 10px; cursor: pointer;" onclick="showImageModal(this.src)">
</div>

<!-- Hidden input to store the selected suggestion -->
<input type="hidden" id="selected_profile_image" name="selected_profile_image">

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Selected Profile Picture" style="max-width: 100%;">
            </div>
        </div>
    </div>
</div>

              <div class="col-12">
                <button class="btn btn-primary w-100" type="submit" name="register">Register</button>
              </div>

              <div class="col-12">
                <p class="small mb-0 text-center">Already have an account? <a href="login.php"> Log in</a></p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</div>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/quill/quill.min.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

<script>
    function selectProfileSuggestion(imageSrc) {
        // Clear the file input
        document.getElementById('profile_image').value = '';

        // Set the selected image to a hidden input field
        document.getElementById('selected_profile_image').value = imageSrc;

        // Display the selected image visually
        const profileImagePreview = document.getElementById('profile_image_preview');
        profileImagePreview.src = imageSrc;
        profileImagePreview.style.display = 'block';

        console.log('Selected profile suggestion:', imageSrc);
    }

    function showImageModal(imageSrc) {
        // Set the image source in the modal
        document.getElementById('modalImage').src = imageSrc;

        // Show the modal
        const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
        imageModal.show();
    }
        function selectProfileSuggestion(imageSrc) {
        // Set the selected image to the hidden input field
          document.getElementById('modalImage').src = imageSrc;

        // Display the selected image visually (optional)
        const profileImagePreview = document.getElementById('profile_image_preview');
        profileImagePreview.src = imageSrc;
        profileImagePreview.style.display = 'block';

        console.log('Selected profile suggestion:', imageSrc);
    }
</script>

</body>
</html>
