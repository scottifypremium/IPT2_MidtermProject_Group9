<?php
session_start(); // Initialize the session
include 'db_connect.php'; // Include the database connection

// Suggested profile images
$suggestedImages = [
    'assets/img/dog.jpg',
    'assets/img/profile-game.jpg',
    'assets/img/profile-img.jpg',
    'assets/img/hacker.jpg',
];

// Initialize variables
$error = '';
$success = '';
$username = $_SESSION['username'] ?? '';
$profileImage = $_SESSION['profile_image'] ?? 'assets/img/default-profile.jpg';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle profile updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and update profile information
    if (!empty($_POST['username'])) {
        $newUsername = htmlspecialchars($_POST['username']); // Sanitize the username
        $_SESSION['username'] = $newUsername; // Update username in session
    }

    // Handle profile image selection
    if (!empty($_POST['selected_image'])) {
        // Use the selected suggested image
        $newProfileImage = $_POST['selected_image'];
        $_SESSION['profile_image'] = $newProfileImage;
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
                $newProfileImage = $targetFile;
                $_SESSION['profile_image'] = $newProfileImage; // Update profile image in session
            } else {
                $error = "Failed to upload image. Please check directory permissions.";
            }
        } else {
            $error = "File is not an image.";
        }
    }
    }
}
    // Update the database
    if (isset($_SESSION['user_id']) && !isset($error)) {
        $newProfileImage = $newProfileImage ?? $_SESSION['profile_image']; // Ensure $newProfileImage is set
    
        $sql = "UPDATE users SET profile_image = :profile_image WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([
            ':profile_image' => $newProfileImage,
            ':id' => $userId
        ])) {
            $success = "Profile updated successfully!";
        } else {
            $error = "Failed to update profile.";
        }
    }
// Fetch current user data from the session
$username = $_SESSION['username'] ?? '';
$profileImage = $_SESSION['profile_image'] ?? 'assets/img/default-profile.jpg';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Profile - CICT Esports</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Include the same header styles and scripts as header.php -->
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

  <!-- Custom CSS for Gamer Theme -->
  <style>
    .gamer-modal {
      background: linear-gradient(135deg, #1e1e2f, #2a2a40);
      color: #fff;
      border: 2px solid #00ffcc;
      border-radius: 10px;
    }
    .gamer-modal .modal-header {
      border-bottom: 2px solid #00ffcc;
    }
    .gamer-modal .modal-footer {
      border-top: 2px solid #00ffcc;
    }
    .gamer-modal .btn-close {
      filter: invert(1);
    }
    .suggested-image {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border: 2px solid #00ffcc;
      border-radius: 10px;
      cursor: pointer;
      transition: transform 0.2s;
    }
    .suggested-image:hover {
      transform: scale(1.1);
    }
    .profile-image-container {
      text-align: center;
      margin-bottom: 20px;
    }
    .profile-image-container img {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border: 3px solid #00ffcc;
      border-radius: 10px;
    }
    .profile-title {
      background: linear-gradient(45deg, #00ffcc, #ff00ff, #00ffcc);
      background-size: 200% 200%;
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      font-size: 2.5rem;
      font-weight: bold;
      animation: gradientAnimation 3s ease infinite;
    }
    @keyframes gradientAnimation {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }
    .btn-secondary {
      background-color: #6c757d; /* Default Bootstrap secondary color */
      border: none;
      transition: background-color 0.3s ease;
    }
    .btn-secondary:hover {
      background-color: #5a6268; /* Darker shade on hover */
    }
  </style>
</head>

<body>
  <!-- Include the header -->
  <?php include 'partials/header.php'; ?>

  <!-- ======= Main Content ======= -->
  <main id="main" class="main">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="card gamer-modal">
            <div class="card-body">
              <h5 class="card-title profile-title">Profile</h5>

              <!-- Display success or error messages -->
              <?php if (!empty($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
              <?php endif; ?>
              <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
              <?php endif; ?>

              <!-- Profile Form -->
              <form action="profile.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>">
                </div>

                <div class="mb-3">
                  <label class="form-label">Profile Image</label>
                  <div class="profile-image-container">
                    <img src="<?php echo $profileImage; ?>" alt="Profile Image" id="profile-image-preview">
                  </div>
                  <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#imageModal">
                      Choose Suggested Image
                    </button>
                    <button type="button" class="btn btn-outline-secondary" onclick="document.getElementById('profile_image').click()">
                      Upload Custom Image
                    </button>
                  </div>
                  <input type="file" class="form-control d-none" id="profile_image" name="profile_image" accept="image/*" onchange="previewImage(event)">
                  <input type="hidden" name="selected_image" id="selected_image" value="">
                </div>

                <button type="submit" class="btn btn-primary">Update Profile</button>
                <a href="index.php" class="btn btn-secondary">Back</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main><!-- End Main Content -->

  <!-- Suggested Image Modal -->
  <div class="modal fade gamer-modal" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="imageModalLabel">Choose a Profile Picture</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <?php foreach ($suggestedImages as $image): ?>
              <div class="col-6 text-center mb-3">
                <img src="<?php echo $image; ?>" alt="Suggested Image" class="suggested-image" onclick="selectImage('<?php echo $image; ?>')">
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- Custom Script for Image Selection -->
  <script>
    function selectImage(imageUrl) {
      document.getElementById('profile-image-preview').src = imageUrl;
      document.getElementById('selected_image').value = imageUrl;
      bootstrap.Modal.getInstance(document.getElementById('imageModal')).hide();
    }

    function previewImage(event) {
      const reader = new FileReader();
      reader.onload = function() {
        document.getElementById('profile-image-preview').src = reader.result;
      };
      reader.readAsDataURL(event.target.files[0]);
    }
  </script>
</body>

</html>