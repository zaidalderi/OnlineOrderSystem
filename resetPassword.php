<?php
    session_start();
    // Check if the user is logged in, otherwise redirect to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: signin.php");
        exit;
    }

    $servername  = "localhost";
    $database = "Website_Database";
    $username = "root";
    $password = "";

    $conn  = mysqli_connect($servername, $username, $password, $database);

    $new_password = $confirm_password = "";
    $new_password_err = $confirm_password_err = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
 
        // Validate new password
        if(empty(trim($_POST["new_password"]))){
            $new_password_err = "Please enter the new password.";     
        } elseif(strlen(trim($_POST["new_password"])) < 6){
            $new_password_err = "Password must have atleast 6 characters.";
        } else{
            $new_password = trim($_POST["new_password"]);
        }
        
        // Validate confirm password
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Please confirm the password.";
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($new_password_err) && ($new_password != $confirm_password)){
                $confirm_password_err = "Password did not match.";
            }
        }
            
        // Check input errors before updating the database
        if(empty($new_password_err) && empty($confirm_password_err)){
            // Prepare an update statement
            $sql = "UPDATE user SET password = ? WHERE id = ?";
            
            if($stmt = mysqli_prepare($conn, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
                
                // Set parameters
                $param_password = password_hash($new_password, PASSWORD_DEFAULT);
                $param_id = $_SESSION["id"];
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // Password updated successfully. Destroy the session, and redirect to login page
                    session_destroy();
                    header("location: signin.php");
                    exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
    
                // Close statement
                mysqli_stmt_close($stmt);
            }
        }
        
        // Close connection
        mysqli_close($conn);
    }

?>

<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Reset Password</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">



    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>


    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>

  <body>
    <header class="p-3 bg-dark text-white">
      <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
          <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white fw-bold text-decoration-none">
            <img src="pizza.svg" style="vertical-align: -.125em" width="40" height="40">
          </a>


          <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
            <li><a href="index.php" class="nav-link px-2 text-white">Home</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link px-2 text-white dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Menu
              </a>
              <ul class="dropdown-menu dropdown-menu" aria-labelledby="navbarDarkDropdownMenuLink">
                <li><a class="dropdown-item" href="burgerMenu.php">Burger</a></li>
                <li><a class="dropdown-item" href="pizzaMenu.php">Pizza</a></li>
                <li><a class="dropdown-item" href="sidesMenu.php">Sides</a></li>
                <li><a class="dropdown-item" href="drinksMenu.php">Drinks</a></li>
              </ul>
            </li>

          </ul>

          <form class="d-flex col-lg-7 col-lg-offset-7" method="POST">
            <input class="form-control me-2" type="search" placeholder="Search menu..." aria-label="Search">
            <button class="btn btn-warning search-button" name="submit" type="submit">Search</button>
          </form>


          <div class="text-end">
            <?php
              if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                echo"<a class='nav-item dropdown'>
                <a class='nav-link dropdown-toggle text-white' href='#' data-bs-toggle='dropdown'>
                  Account
                </a>
                <ul class='dropdown-menu'>
                  <li>
                    <a class='dropdown-item' href='profile.php'>Profile</a>
                  </li>
                  <li>
                    <a class='dropdown-item' href='orderHistory.php'>Order history</a>
                  </li>
                  <li>
                    <hr class='dropdown-divider'>
                  </li>
                  <li>
                    <a class='dropdown-item' href='signout.php'>Logout</a>
                  </li>
                </ul>
              </a>";
              }else {
                echo '<a href="signin.php" class="nav-link text-white">Login</a>';
              }
            ?>
          </div>
          <div class="text-end">
            <a role="button" href="cart.php" class="btn btn-outline-yellow me-2 btn-sm btn-warning cart-button">
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
              </svg>
            </a>
          </div>
        </div>

      </div>
    </header>
    <main class="form-signin text-center">
      <form method="post">
        <h1 class="h3 mb-3 fw-normal">Reset Password</h1>

        <div class="form-floating">
          <input type="password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" name="new_password" placeholder="New Password" value="<?php echo $new_password; ?>">
          <label for="floatingInput">New Password</label>
          <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" name="confirm_password" placeholder="Confirm Password" value="<?php echo $confirm_password; ?>">
          <label for="floatingInput">Confirm Password</label>
          <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
        </div>

        <button class="w-100 btn btn-lg btn-primary login-btn" type="submit">Change Password</button>
      </form>
      <br>
    </main>
    <footer class="py-4 my-4">
      <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li class="text-start nav-item"><a href="aboutUs.php" class="nav-link px-2 text-muted">About</a></li>
        <li class="text-center nav-item"><a href="privacy.php" class="nav-link px-2 text-muted">Privacy Policy</a></li>
        <li class="text-end nav-item"><a href="contact.php" class="nav-link px-2 text-muted">Contact Us</a></li>
      </ul>
    </footer>
  </body>

</html>