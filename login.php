<?php
session_start();
include 'db_connect.php';

// Handle Login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if user exists
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;
            header("Location: index.php"); // Redirect to dashboard
            exit();
        } else {
            echo "<script>alert('Incorrect password!');</script>";
        }
    } else {
        echo "<script>alert('User not found!');</script>";
    }
    
} 
       

// Handle Registration (Prevent Empty Fields)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $new_username = trim($_POST['new_username']);
    $new_password = trim($_POST['new_password']);

    if (empty($new_username) || empty($new_password)) {
        echo "<script>alert('Username and Password cannot be empty!');</script>";
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Check if username exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
        $stmt->bind_param("s", $new_username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('Username already exists!');</script>";
        } else {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $new_username, $hashed_password);
            if ($stmt->execute()) {
                echo "<script>alert('Account created successfully! You can now log in.');</script>";
            } else {
                echo "<script>alert('Error creating account!');</script>";
            }
        }
    }
}

// Handle Registration (Create Account)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $new_username = $_POST['new_username'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT); // Encrypt password

    // Check if username exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE username=?");
    $stmt->bind_param("s", $new_username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Username already exists!');</script>";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $new_username, $new_password);
        if ($stmt->execute()) {
            echo "<script>alert('Account created successfully! You can now log in.');</script>";
        } else {
            echo "<script>alert('Error creating account!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>CICTEsports Login</title>
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
</head>
<body>
<div class="container">

<section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

        <div class="d-flex justify-content-center py-4">
          <a href="index.html" class="logo d-flex align-items-center w-auto">
            <img src="assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">CICTEsports</span>
          </a>
        </div><!-- End Logo -->
        <div class="card mb-3">

          <div class="card-body">
          <div class="pt-4 pb-2">
    <h5 class="card-title text-center pb-0 fs-4">Login</h5>
    <p class="text-center small">Enter your username & password to login</p>
    </div>

    <form class="row g-3 needs-validation" novalidate method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        
    <div class="col-12">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
          <label class="form-check-label" for="rememberMe">Remember me</label>
       </div>
    </div>

        <button button class="btn btn-primary w-100" type="submit" name="login">Login</button>
    </form>

   
    <div class="col-12">
        <p class="small mb-0">Don't have account? <a href="pages-register.php">Create an account</a></p>
    </div>
    
    <script>  
    

    <script>
</body>
</html>
