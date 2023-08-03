<?php
// Initialize variables
$uname = "";
$uname_err = "";
$pwd_err = "";
$login_err = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $uname = trim($_POST["txt_uname"]);
    $pwd = trim($_POST["txt_pwd"]);
    

    // Validate username
    if (empty($uname)) {
        $uname_err = "Please enter your username.";
    }

    // Validate password
    if (empty($pwd)) {
        $pwd_err = "Please enter your password.";
    }

// If there are no errors, proceed with login
if (empty($uname_err) && empty($pwd_err)) {
    // Create a database connection
    include('connect.php');

    // Check if the input matches either the email or username in the database
    $sql_check_user = "SELECT id, username, email, pass, role FROM users WHERE email = ? OR username = ?";
    $stmt_check_user = mysqli_prepare($conn, $sql_check_user);
    mysqli_stmt_bind_param($stmt_check_user, "ss", $uname, $uname);
    mysqli_stmt_execute($stmt_check_user);
    mysqli_stmt_store_result($stmt_check_user);

    if (mysqli_stmt_num_rows($stmt_check_user) == 1) {
        // Bind the result to variables
        mysqli_stmt_bind_result($stmt_check_user, $id, $username, $email, $hashed_password, $role);
        mysqli_stmt_fetch($stmt_check_user);

        // Verify the password
        if (password_verify($pwd, $hashed_password)) {
            // Password is correct, create a session and redirect to the appropriate page
            session_start();
            $_SESSION["id"] = $id;
            $_SESSION['role'] = $role;
            
            if ($role == "admin") {
                // Admin user, redirect to dashboard
                header("Location: dashboard.php");
            } else {
                // Member user, redirect to welcome page
                header("Location: welcome.php");
            }
            exit();
        } else {
            // Password is incorrect
            $login_err = "Invalid email/username or password.";
        }
    } else {
        // User does not exist
        $login_err = "Invalid email/username or password.";
    }

    // Close the statement
    mysqli_stmt_close($stmt_check_user);

    // Close the connection
    mysqli_close($conn);
}

}
?>





 <html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" />

	   <link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/droid-arabic-kufi" type="text/css"/>
	  	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	  
  <style>
        body {
        font-family: DroidArabicKufiRegular;
		  margin: 0px;
      }
    :root{
      --main-bg: linear-gradient(90deg, #0152A1 0%, #B3B3FF 100%);
}

.main-bg {
  background: var(--main-bg) !important;
}

input:focus, button:focus {
  border: 1px solid lightblue !important;
  box-shadow: none !important;
}

.form-check-input:checked {
  background-color: var(--main-bg) !important;
  border-color: var(--main-bg) !important;
}

.card, .btn, input{
  border-radius:30px !important;
}

  </style>
</head>

<body class="main-bg d-flex justify-content-center align-items-center">
  <!-- Login Form -->
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-lg-4 col-md-6 col-sm-6 align-self-center">
        <div class="card shadow">
          <div class="card-title text-center border-bottom">
            <h2 class="p-3">Login</h2>
          </div>
          <div class="card-body">
            <form method="post" action="">
              <div class="mb-4" dir="rtl">
                <label for="username" class="form-label">اسم المستخدم /الإيمايل</label>
                <input type="text" class="form-control <?php echo (!empty($uname_err)) ? 'is-invalid' : ''; ?>" id="username" name="txt_uname" value="<?php echo $uname; ?>"/>
                <span class="invalid-feedback"><?php echo $uname_err; ?></span>
              </div>
              <div class="mb-4" dir="rtl">
                <label for="password" class="form-label" dir="rtl">كلمة السر</label>
                <input type="password" class="form-control <?php echo (!empty($pwd_err)) ? 'is-invalid' : ''; ?>" id="password" name="txt_pwd"/>
                <span class="invalid-feedback"><?php echo $pwd_err; ?></span>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn text-light main-bg" name="but_submit">login</button>
              </div>
               <?php if (!empty($login_err)) { ?>
      <div class="alert alert-danger mt-3" role="alert" dir="rtl">
        <?php echo $login_err; ?>
      </div>
    <?php } ?>
            </form>
          </div>
        </div>
      </div>
    </div>
        <!-- Sign Up Link -->
        <div class="row justify-content-center mt-3">
      <div class="col-lg-4 col-md-6 col-sm-6 text-center">
        <p class="mb-0">Not a member? <a href="register.php" class="text-decoration-none">Sign Up</a></p>
      </div>
    </div>
  </div>
 
</body>
</html>




