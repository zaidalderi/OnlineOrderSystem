<?php
    session_start();
    if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
      header("location: index.php");
      exit;
    }else{
      $servername  = "localhost";
      $database = "Website_Database";
      $username = "root";
      $password = "";
        
      $conn  = mysqli_connect($servername, $username, $password, $database);
      $id = $_SESSION["id"];
      $query = "SELECT * FROM user,user_payment WHERE user.id= ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("i",$id);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      if($_SERVER["REQUEST_METHOD"] == "POST"){
        $search = $_POST['search'];
        header("location: searchResults.php?searchParam=$search");
      }
      
    }
?>
<!DOCTYPE HTML>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>My Account</title>


    <!-- Bootstrap css -->
    <link href="css/bootstrap.css?v=2.0" rel="stylesheet" type="text/css" />

    <!-- Custom css -->
    <link href="css/ui.css?v=2.0" rel="stylesheet" type="text/css" />
    <link href="css/responsive.css?v=2.0" rel="stylesheet" type="text/css" />


    <style>
      .search-button,
      .cart-button {
        background-color: #ffc107;
        border-color: #ffc107;
        color: black;
      }

      .search-button:hover {
        background-color: orange;
        border-color: orange;
        color: white;
      }

      .cart-button:hover {
        background-color: orange;
        border-color: orange;
        color: white;
      }
    </style>

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
    <section class="padding-y bg-light">
      <div class="container">

        <div class="row">
          <aside class="col-lg-3 col-xl-3">
            <nav class="nav flex-lg-column nav-pills mb-4">
              <a class="nav-link active" href="#">Profile</a>
              <a class="nav-link" href="orderHistory.php">Orders history</a>
              <a class="nav-link" href="user_address.php">Addresses</a>
              <a class="nav-link" href="user_payment_methods.php">Payment Methods</a>
              <a class="nav-link" href="resetPassword.php">Change Password</a>
            </nav>
          </aside>
          <main class="col-lg-9  col-xl-9">
            <div class="container">
              <article class="card">
                <div class="content-body">
                  <figure class="itemside align-items-center">
                    <div class="aside">
                      <span class="bg-gray icon-md rounded-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                    </svg>
                    </span>
                    </div>
                    <figcaption class="info">
                      <h6 class="title"><?php echo $row['first_name']; echo " "; echo $row['last_name']?></h6>
                      <p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                          <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                        </svg>
                        <?php echo $row['email']?>
                      </p>
                      <p>Member Since: <?php echo date('Y', strtotime($row['created_at']));?></p>
                      <p>Number of orders: <?php echo mysqli_num_rows($result); ?>
                    </figcaption>
                  </figure>
                  <hr>
                  <p class="text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align: -.125em" width="16" height="16" fill="currentColor" style="vertical-align: middle;" class="bi bi-house" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                      <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                    </svg>
                    Saved Addresses
                  </p>
                  <div class="row g-2 mb-3">
                    <?php
                      $addressQuery = "SELECT * FROM user_address WHERE user_id = ?";
                      $stmt = $conn->prepare($addressQuery);
                      $stmt->bind_param("i",$id);
                      $stmt->execute();
                      $addressResult = $stmt->get_result();
                      while($addressRows = $addressResult->fetch_assoc()){?>
                    <div class="col-md-6">
                      <article class="box bg-light">
                        <b class="text-muted"><i class="fa fa-map-marker-alt"></i></b>
                        <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align: -.125em" width="16" height="16" fill="currentColor" style="vertical-align: middle;" class="bi bi-house" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M2 13.5V7h1v6.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V7h1v6.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5zm11-11V6l-2-2V2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5z" />
                          <path fill-rule="evenodd" d="M7.293 1.5a1 1 0 0 1 1.414 0l6.647 6.646a.5.5 0 0 1-.708.708L8 2.207 1.354 8.854a.5.5 0 1 1-.708-.708L7.293 1.5z" />
                        </svg>
                        <?php echo $addressRows['address_line_1'] . ', '. $addressRows['address_line_2'] . ', ' . $addressRows['city'] . ', ' . $addressRows['postcode'] . ', ' . $addressRows['country'] ; ?>
                      </article>
                    </div>
                    <?php ;}
                    ?>
                  </div>
                  <hr>
                  <p class="text-muted">
                    <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align: -.125em" width="16" height="16" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                      <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z" />
                      <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z" />
                    </svg>
                    Saved Payment Methods
                  </p>
                  <div class="row g-2 mb-3">
                    <?php
                      $PaymentQuery = "SELECT * FROM user_payment WHERE user_id = ?";
                      $stmt = $conn->prepare($PaymentQuery);
                      $stmt->bind_param("i",$id);
                      $stmt->execute();
                      $paymentResult = $stmt->get_result();
                      while($paymentRows = $paymentResult->fetch_assoc()){?>
                    <div class="col-md-6">
                      <article class="box bg-light">
                        <b class="text-muted"><i class="fa fa-map-marker-alt"></i></b>
                        <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align: -.125em" width="16" height="16" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                          <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z" />
                          <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z" />
                        </svg>
                        <?php echo $paymentRows['provider'] . " " . $paymentRows['card_number'] . ", Exp: " . $paymentRows['exp_month'] . "/" . $paymentRows['exp_year'] ; ?>
                      </article>
                    </div>
                    <?php ;}
                    ?>
                  </div>
                </div>
              </article>
          </main>
        </div>

        <br><br>


      </div>
    </section>


    <footer class="mt-auto py-4 my-4">
      <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li class="text-start nav-item"><a href="aboutUs.php" class="nav-link px-2 text-muted">About</a></li>
        <li class="text-center nav-item"><a href="privacy.php" class="nav-link px-2 text-muted">Privacy Policy</a></li>
        <li class="text-end nav-item"><a href="contact.php" class="nav-link px-2 text-muted">Contact Us</a></li>
      </ul>
    </footer>


    <script src="js/bootstrap.bundle.min.js"></script>

  </body>

</html>