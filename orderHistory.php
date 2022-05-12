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
    <title>Order History</title>
    <!-- Bootstrap css -->
    <link href="css/bootstrap.css?v=2.0" rel="stylesheet" type="text/css" />
    <!-- Custom css -->
    <link href="css/ui.css?v=2.0" rel="stylesheet" type="text/css" />
    <link href="css/responsive.css?v=2.0" rel="stylesheet" type="text/css" />
    <!-- Font awesome 5 -->
    <link href="fonts/fontawesome/css/all.min.css" type="text/css" rel="stylesheet">
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
              <a class="nav-link" href="profile.php">Profile</a>
              <a class="nav-link active" href="orderHistory.php">Orders history</a>
              <a class="nav-link" href="user_address.php">Addresses</a>
              <a class="nav-link" href="user_payment_methods.php">Payment Methods</a>
              <a class="nav-link" href="resetPassword.php">Change Password</a>
            </nav>
          </aside>
          <main class="col-lg-9  col-xl-9">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="profile.php">Profile</a></li>
                <li class="breadcrumb-item active" aria-current="page">Order History</li>
              </ol>
            </nav>
            <article class="card">
              <div class="content-body">
                <h5 class="card-title"> Your orders </h5>
                <?php
                    $query = "SELECT * FROM order_details WHERE user_id=?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i",$id);
                    $stmt->execute();
                    $result = $stmt->get_result();;
                    while($rows = $result->fetch_assoc()){?>
                <article class="card border-primary mb-4">
                  <div class="card-body">
                    <div class="d-lg-flex">
                      <div class="flex-grow-1">
                        <h6 class="mb-0">Order ID: <?php echo $rows['id']?></h6>
                        <span class="text-muted">Order Placed: <?php echo date('d M Y', strtotime($rows['created_at']));?></span>
                        <br>
                        <span>Total: £<?php echo $rows['total']?></span>
                      </div>
                      <div>
                        <a href="singleorder.php?orderID=<?php echo $rows['id'];?>" class="btn btn-sm btn-primary">View order</a>
                      </div>
                      </date_interval_create_from_date_string>
                    </div>
                </article>
                <?php ;}
                ?>
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
    <!-- Bootstrap js -->
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>

</html>