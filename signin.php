<?php
  session_start();

  if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
  }

  $servername  = "localhost";
  $database = "Website_Database";
  $username = "root";
  $password = "";
  
  $conn  = mysqli_connect($servername, $username, $password, $database);

  $email = $password = "";
  $email_err = $password_err = $login_err = "";

  if(isset($_POST['search'])){
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      $search = $_POST['search'];
      header("location: searchResults.php?searchParam=$search");
    }
  }else{
    if($_SERVER["REQUEST_METHOD"] == "POST"){

      //Check if email is empty
      if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email address";
      }else{
        $email = trim($_POST["email"]);
      }
  
      //Check if password is empty
      if(empty(trim($_POST["password"]))){
        $password_err = "Please enter password";
      }else{
        $password = trim($_POST["password"]);
      }
  
      //Validate credentials
      if(empty($email_err) && empty($password_err)){
        $sql = "SELECT id, email, password FROM user WHERE email = ?";
  
        if($stmt = mysqli_prepare($conn, $sql)){
          mysqli_stmt_bind_param($stmt, "s", $param_email);
          
          //Set Parameter
          $param_email = $email;
  
          if(mysqli_stmt_execute($stmt)){
            //Store result
            mysqli_stmt_store_result($stmt);
  
            //Check is email exists, if yes then verify password
            if(mysqli_stmt_num_rows($stmt) == 1){
              //Bind result variables
              mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
              if(mysqli_stmt_fetch($stmt)){
                if(password_verify($password, $hashed_password)){
                  //Password is correct, so start a new session
                  session_start();
                  //Store data in session variables
                  $_SESSION["loggedin"] = true;
                  $_SESSION["id"] = $id;
                  $_SESSION["email"] = $email;
  
                  //Redirect user to homepaghe
                  header("location: index.php");
                }else{
                  //Password is not valid, display a generic error message
                  $login_err = "Invalid email or password";
                }
              }
            }else{
              //Email is not valid, display generic error message
              $login_err = "Invalid email or password";
            }
          }else {
            echo "Oops, something went wrong!";
          }
  
          //Close statement
          mysqli_stmt_close($stmt);
        }
      }
      mysqli_close($conn);
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Sign In</title>

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
            <input class="form-control me-2" name="search" type="search" placeholder="Search menu..." aria-label="Search">
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
                    <a class='dropdown-item' href='#'>Order history</a>
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
            <a role="button" href = "cart.php" class="btn btn-outline-yellow me-2 btn-sm btn-warning cart-button">
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
              </svg>
            </a>
          </div>
        </div>
        
      </div>
    </header>
    <main class="form-signin text-center">
      <form method="post">
        <h1 class="h3 mb-3 fw-normal">Login</h1>
        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>
        <div class="form-floating">
          <input type="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" id="floatingInput" name="email" placeholder="name@example.com" value="<?php echo $email; ?>">
          <label for="floatingInput">Email address</label>
          <span class="invalid-feedback"><?php echo $email_err; ?></span>
        </div>
        <div class="form-floating">
          <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" id="floatingPassword" name="password" placeholder="Password" value="<?php echo $password; ?>">
          <label for="floatingPassword">Password</label>
          <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>    
        <button class="w-100 btn btn-lg btn-primary login-btn" type="submit">Sign in</button>
      </form>
      <br>
      <a href="signup.php" class="link-primary">Create Account</a>
    </main>
    <footer class="py-4 my-4 foot-section">
      <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li class="text-start nav-item"><a href="aboutUs.php" class="nav-link px-2 text-muted">About</a></li>
        <li class="text-center nav-item"><a href="privacy.php" class="nav-link px-2 text-muted">Privacy Policy</a></li>
        <li class="text-end nav-item"><a href="contact.php" class="nav-link px-2 text-muted">Contact Us</a></li>
      </ul>
    </footer>
  </body>
</html>
