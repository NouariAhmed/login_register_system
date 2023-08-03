<?php
session_start();

// Check if the user is logged in and their role is "admin"
if (isset($_SESSION['id']) && $_SESSION['role'] === "admin") {
    // The user is an admin, continue with dashboard content
} else {
    // The user is not an admin or not logged in, redirect to login page
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="style.css">
</head>

<body class="main-bg d-flex justify-content-center align-items-center">
  <!-- Dashboard Content -->
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-lg-4 col-md-6 col-sm-6 align-self-center">
        <div class="card shadow">
          <div class="card-title text-center border-bottom">
            <h2 class="p-3">Welcome Admin <?php echo $_SESSION['username']; ?>!</h2>
          </div>
          <div class="card-body">
            <!-- Dashboard Content Goes Here -->
          </div>
          <div class="card-footer text-center">
            <a href="logout.php" class="btn btn-danger">Logout</a>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>
