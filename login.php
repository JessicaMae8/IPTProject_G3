<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Login - AppleZone PH</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


  <!-- Favicons -->
  <link href="assets/img/apple1.png" rel="icon">
  <link href="assets/img/apple1.png" rel="Logo icon">

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
  <link href="assets/css/log.css" rel="stylesheet">
  
  

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="login" >

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/apple1.png" alt="">
                  <!--<span class="d-none d-lg-block">AppleZone Staff Log-in</span> -->
                  <h5>AppleZone Staff Log-in</h5>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">
    <div class="card-body">
        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
            <p class="text-center small">Enter your login credentials to proceed</p>
        </div>

        <?php
// Display success message if redirected after registration
if (isset($_GET['message']) && $_GET['message'] == 'success') {
    echo "<div style='color: green; text-align: center;'>Registration successful!<br> You can now log in.</div>";
}
?>


        <?php
include 'database/registry.php';
session_start();

$error = ""; // Initialize an error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM registeredusers WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Store user information in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid password."; // Set the error message
        }
    } else {
        $error = "No user found with that username."; // Set the error message
    }
}
?>
<form class="login" novalidate method="POST" action="login.php">
        <div class="col-12">
    <label for="username" class="form-label">Username</label>
    <div class="input-group">
        <!-- User Icon -->
        <span class="input-group-text"><i class="bi bi-person"></i></span>

        <!-- Username Input Field -->
        <input type="text" name="username" id="username" class="form-control" placeholder="Enter username" required>
        
        <div class="invalid-feedback">Please enter your username.</div>
    </div>
</div>

<div class="col-12">
    <label for="password" class="form-label">Password</label>
    <div class="input-group">
        <!-- Padlock Icon -->
        <span class="input-group-text"><i class="bi bi-lock"></i></span>

        <!-- Password Input Field -->
        <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" required minlength="8">

        <!-- Eye Icon for Toggle -->
        <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
            <i id="toggleIcon" class="bi bi-eye"></i>
        </span>

        <div class="invalid-feedback">Password must be at least 8 characters long.</div>
    </div>
</div>



            <div class="col-12 mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
            </div>
            <div class="col-12 mb-3">
                <button class="btn btn-primary w-100" type="submit">Login</button>
            </div>
            <div class="col-12 mb-3">
                <p class="small mb-0">Don't have an account? <a href="register.php">Create an account</a></p>
            </div>
        </form>
    </div>
</div>

<!-- Display Error Messages -->
<?php if (!empty($error)): ?>
    <div style="color: red;"><?php echo $error; ?></div>
<?php endif; ?>

<script>
function togglePassword() {
    const passwordInput = document.getElementById("password");
    const toggleIcon = document.getElementById("toggleIcon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleIcon.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        passwordInput.type = "password";
        toggleIcon.classList.replace("bi-eye-slash", "bi-eye");
    }
}

</script>
              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>