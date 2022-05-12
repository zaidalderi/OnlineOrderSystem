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
       $query = "SELECT * FROM user WHERE id= ?";
       $stmt = $conn->prepare($query);
       $stmt->bind_param("i",$id);
       $stmt->execute();
       $result = $stmt->get_result();
       $row = $result->fetch_assoc();
   }
   ?>
<!DOCTYPE HTML>
<?php
   $provider = $cardNumber = $expMonth = $expYear = $cvv = "";
   $provider_err = $cardNumber_err = $expMonth_err = $expYear_err = $cvv_err = "";
   if(isset($_POST['search'])){
      if($_SERVER["REQUEST_METHOD"] == "POST"){
         $search = $_POST['search'];
         header("location: searchResults.php?searchParam=$search");
       }
   }else{
      if($_SERVER["REQUEST_METHOD"] == "POST"){
         $provider = $_POST["providerOption"];
         //Validate card number
         if($provider === "Visa"){
            if(empty(trim($_POST["cardNumber"]))){
               $cardNumber_err = "Please enter the card number";     
            }else if(!preg_match("/^4[0-9]{12}(?:[0-9]{3})?$/",$_POST["cardNumber"])){
               $cardNumber_err = "Invalid card number";
            }else{
               $cardNumber = trim($_POST["cardNumber"]);
               $creditCardStoredFormat = str_pad(substr($cardNumber, -4), strlen($cardNumber), '*', STR_PAD_LEFT);
            }            
         }else if($provider === "Mastercard"){
            if(empty(trim($_POST["cardNumber"]))){
               $cardNumber_err = "Please enter the card number";     
            }else if(!preg_match("/^5[1-5][0-9]{14}$/",$_POST["cardNumber"])){
               $cardNumber_err = "Invalid card number";
            }else{
               $cardNumber = trim($_POST["cardNumber"]);
               $creditCardStoredFormat = str_pad(substr($cardNumber, -4), strlen($cardNumber), '*', STR_PAD_LEFT);
            }            
         }else if($provider === "Amex"){
            if(empty(trim($_POST["cardNumber"]))){
               $cardNumber_err = "Please enter the card number";     
            }else if(!preg_match("/^3[47][0-9]{13}$/",$_POST["cardNumber"])){
               $cardNumber_err = "Invalid card number";
            }else{
               $cardNumber = trim($_POST["cardNumber"]);
               $creditCardStoredFormat = str_pad(substr($cardNumber, -4), strlen($cardNumber), '*', STR_PAD_LEFT);
            }            
         }
         //Validate expiry month
         if(empty(trim($_POST['expMonth']))){
             $expMonth_err = "Please select the expiry month";     
         }else{
             $expMonth = (int)trim($_POST["expMonth"]);
         }
     
         //Validate expiry year
         if(empty(trim($_POST["expYear"]))){
             $expYear_err = "Please enter the expiry year";     
         }else{
             $expYear = (int)trim($_POST["expYear"]);
         }
     
         //Validate cvv code
         if(empty(trim($_POST["cvv"]))){
             $cvv_err = "Please enter the cvv code";     
         }else{
             $cvv = (int)trim($_POST["cvv"]);
         }
     
         if(empty($cardNumber_err) && empty($expMonth_err) && empty($expYear_err) && empty($cvv_err)){    
             // Prepare an insert statement
             $sql = "INSERT INTO user_payment (user_id, provider, card_number, security_code, exp_month, exp_year) VALUES (?, ?, ?, ?, ?, ?)";
              
             if($stmt = mysqli_prepare($conn, $sql)){
               // Bind variables to the prepared statement as parameters
               mysqli_stmt_bind_param($stmt, "issiii", $id, $provider, $creditCardStoredFormat, $cvv, $expMonth, $expYear);
                 
               // Set parameters
                 
               // Attempt to execute the prepared statement
               if(mysqli_stmt_execute($stmt)){
                 // Redirect to login page
                 header("location: user_payment_methods.php");
               }else{
                 echo "Oops! Something went wrong. Please try again later.#2";
               }
               // Close statement
               mysqli_stmt_close($stmt);
           }
        }
     }  
   }
   ?>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Payment Methods</title>
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
            <button class="btn btn-warning search-button" type="submit">Search</button>
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
              <a class="nav-link" href="profile.php">Profile</a>
              <a class="nav-link" href="orderHistory.php">Orders history</a>
              <a class="nav-link" href="user_address.php">Addresses</a>
              <a class="nav-link active" href="user_payment_methods.php">Payment Methods</a>
              <a class="nav-link" href="resetPassword.php">Change Password</a>
            </nav>
          </aside>
          <main class="col-lg-9  col-xl-9">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="profile.php">Profile</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payment Methods</li>
              </ol>
            </nav>
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
                  </figcaption>
                </figure>
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
                           $paymentQuery = "SELECT * FROM user_payment WHERE user_id = ?";
                           $stmt = $conn->prepare($paymentQuery);
                           $stmt->bind_param("i",$id);
                           $stmt->execute();
                           $paymentResult = $stmt->get_result();
                           while($paymentRows = $paymentResult->fetch_assoc()){?>
                  <div class="col-md-6">
                    <article class="box bg-light">
                      <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align: -.125em" width="16" height="16" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z" />
                        <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z" />
                      </svg>
                      <?php echo $paymentRows['provider'] . ', '. $paymentRows['card_number'] . ', Exp: ' . $paymentRows['exp_month'] . '/' . $paymentRows['exp_year'] ;?>
                      <a class="btn btn-danger" href="deletePayment.php?id=<?php echo $paymentRows['id']?>" style="padding: 1px 1px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                          <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                          <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                        </svg>
                      </a>
                    </article>
                  </div>
                  <?php ;}
                           ?>
                </div>
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Add New Payment</button>
                <div class="collapse mt-3" id="collapseExample">
                  <div class="col-lg-8">
                    <form method="post">
                      <div class="row gx-3">
                        <div class="col-lg-8  mb-3">
                          <label class="form-label">Provider</label>
                          <select name="providerOption" style="width: 100px" class="form-select">
                            <option value="Visa">Visa</option>
                            <option value="Mastercard">Mastercard</option>
                            <option value="Amex">Amex</option>
                          </select>
                        </div>
                        <div class="col-lg-6  mb-3">
                          <label class="form-label">Card number</label>
                          <input class="form-control <?php echo (!empty($cardNumber_err)) ? 'is-invalid' : ''; ?>" type="text" name="cardNumber" placeholder="Card number" value="<?php echo $cardNumber; ?>" maxlength="16">
                          <span class="invalid-feedback"><?php echo $cardNumber_err; ?></span>
                        </div>
                        <div class="col-2 mb-3">
                          <label class="form-label">Exp. Month</label>
                          <input class="form-control <?php echo (!empty($expMonth_err)) ? 'is-invalid' : ''; ?>" type="text" name="expMonth" placeholder="MM" value="<?php echo $expMonth;?>" maxlength="2">
                          <span class="invalid-feedback"><?php echo $expMonth_err; ?></span>
                        </div>
                        <div class="col-2 mb-3">
                          <label class="form-label">Exp. Year</label>
                          <input class="form-control <?php echo (!empty($expYear_err)) ? 'is-invalid' : ''; ?>" type="text" name="expYear" placeholder="YY" value="<?php echo $expYear;?>" maxlength="2">
                          <span class="invalid-feedback"><?php echo $expYear_err; ?></span>
                        </div>
                        <div class="col-3  mb-3">
                          <label class="form-label">CVV Code</label>
                          <input class="form-control <?php echo (!empty($cvv_err)) ? 'is-invalid' : ''; ?>" type="text" name="cvv" placeholder="3-4 digits" value="<?php echo $cvv;?>">
                          <span class="invalid-feedback"><?php echo $cvv_err; ?></span>
                        </div>
                      </div>
                      <button class="btn btn-primary" type="submit">Save</button>
                    </form>
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
    <!-- Bootstrap js -->
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>

</html>