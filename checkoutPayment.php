<?php
    session_start();
    $cartID = $_SESSION['cartID'];
    $id = $_SESSION['id'];
    $servername  = "localhost";
    $database = "Website_Database";
    $username = "root";
    $password = "";

    $conn  = mysqli_connect($servername, $username, $password, $database);
    $firstName = $_SESSION['checkoutFirstName'];
    $lastName = $_SESSION['checkoutLastName'];
    $address1 = $_SESSION['checkoutAddress1'];
    $address2 = $_SESSION['checkoutAddress2'];
    $email = $_SESSION['checkoutEmail'];
    $country = $_SESSION['checkoutCountry'];
    $city = $_SESSION['checkoutCity'];
    $mobile = $_SESSION['checkoutMobile'];
    $postcode = $_SESSION['checkoutPostcode'];
    $total = $_SESSION['total'];

    $provider = $cardNumber = $expMonth = $expYear = $cvv = "";
    $provider_err = $cardNumber_err = $expMonth_err = $expYear_err = $cvv_err = "";

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
          }            
      }else if($provider === "Mastercard"){
          if(empty(trim($_POST["cardNumber"]))){
            $cardNumber_err = "Please enter the card number";     
          }else if(!preg_match("/^5[1-5][0-9]{14}$/",$_POST["cardNumber"])){
            $cardNumber_err = "Invalid card number";
          }else{
            $cardNumber = trim($_POST["cardNumber"]);
          }            
      }else if($provider === "Amex"){
          if(empty(trim($_POST["cardNumber"]))){
            $cardNumber_err = "Please enter the card number";     
          }else if(!preg_match("/^3[47][0-9]{13}$/",$_POST["cardNumber"])){
            $cardNumber_err = "Invalid card number";
          }else{
            $cardNumber = trim($_POST["cardNumber"]);
          }            
      }
      //Validate expiry month
      if(empty(trim($_POST["expMonth"]))){
          $expMonth_err = "Please enter the expiry month";     
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

      $creditCardStoredFormat = str_pad(substr($cardNumber, -4), strlen($cardNumber), '*', STR_PAD_LEFT);

      if(empty($cardNumber_err) && empty($expMonth_err) && empty($expYear_err) && empty($cvv_err)){
        $sql="INSERT INTO `order_details` (`id`, `user_id`, `first_name`, `last_name`, `email`, `address_line_1`, `address_line_2`, `country`, `city`, `postcode`, `mobile`, `total`, `payment_id`, `created_at`, `modified_at`) 
        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NULL, current_timestamp(), current_timestamp())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssssssssd",$id,$firstName,$lastName,$email,$address1,$address2,$country,$city,$postcode,$mobile,$total);
        if($stmt->execute()){
          $sql = "SELECT * FROM order_details WHERE user_id = ? ORDER BY created_at DESC LIMIT 1";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("i",$id);
          $stmt->execute();
          $result = $stmt->get_result();
          $row = $result->fetch_assoc();
          $orderID = $row['id'];
          $cartQuery = "SELECT * FROM cart_item WHERE user_cart_id = $cartID";
          $stmt = $conn->prepare($cartQuery);
          $stmt->bind_param("i",$cartID);
          $stmt->execute();
          $cartResult = $stmt->get_result();
          while($cartRow = $cartResult->fetch_assoc()){
            $itemID = $cartRow['item_id'];
            $quantity = $cartRow['quantity'];
            $sql = "INSERT INTO `order_items` (`id`, `order_id`, `item_id`, `quantity`, `created_at`, `modified_at`) VALUES (NULL, ?, ?, ?, current_timestamp(), current_timestamp())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii",$orderID,$itemID,$quantity);
            $stmt->execute();
            $sql = "DELETE FROM cart_item WHERE user_cart_id = ? AND item_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii",$cartID,$itemID);
            $stmt->execute();
          }
          $sql = "INSERT INTO `payment_details` (`id`, `order_id`, `amount`, `provider`, `status`, `created_at`, `modified_at`, `card_number`, `exp_month`, `exp_year`, `cvv`) 
          VALUES (NULL, ?, ?, ?, '', current_timestamp(), current_timestamp(), ?, ?, ?, ?)";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("idssiii",$orderID,$total,$provider,$creditCardStoredFormat,$expMonth,$expYear,$cvv);
          $stmt->execute();
          $sql = "SELECT * FROM payment_details WHERE order_id = ? ORDER BY created_at DESC LIMIT 1";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("i",$orderID);
          $stmt->execute();
          $result = $stmt->get_result();
          $rows = $result->fetch_assoc();
          $paymentID = $rows['id'];
          $sql = "UPDATE order_details SET payment_id = ? WHERE id = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("ii",$paymentID,$orderID);
          $stmt->execute();
          header("location: orderConfirmation.php?orderID=$orderID");
          exit;
        }
      }
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Payment</title>

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

      body {
        display: flex;
        flex-direction: column;
        background-color: #f5f5f5;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

  </head>
  <body>
    <header class="p-3 bg-dark text-white">
      <div class="container">
        <div class="d-flex flex-row">
            <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white fw-bold text-decoration-none">
              <img src="pizza.svg" style="vertical-align: -.125em" width="40" height="40">
            </a>
            <div class="d-flex flex-row justify-content-end text-end">
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
                <a role="button" href = "cart.php" class="btn btn-outline-yellow me-2 btn-sm btn-warning cart-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                    <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                </a>
            </div>
        </div>
        
      </div>
    </header>

    <div class="container">
  <main>
    <div class="py-5 text-center">
      <h2>Checkout</h2>
    </div>

    <div class="row g-5">
      <?php
        $sql = "SELECT menu.id, menu.name AS item_name, cart_item.quantity AS selectedQuantity, item_category.name AS category_name, menu.price, menu.main_image_link, menu.price * cart_item.quantity AS itemTotal FROM cart_item INNER JOIN menu ON cart_item.item_id = menu.id 
        INNER JOIN item_category ON menu.category_id = item_category.iD WHERE user_cart_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$cartID);
        $stmt->execute();
        $result = $stmt->get_result();
        $sql2 = "SELECT SUM(cart_item.quantity) AS totalQuantity FROM cart_item WHERE user_cart_id = ?";
        $stmt = $conn->prepare($sql2);
        $stmt->bind_param("i",$cartID);
        $stmt->execute();
        $result2 = $stmt->get_result();
        $rows2 = $result2->fetch_assoc();
      ?>
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your cart</span>
          <span class="badge bg-primary rounded-pill"><?php echo $rows2['totalQuantity']; ?></span>
        </h4>
        <ul class="list-group mb-3">
          <?php
            while($rows = $result->fetch_assoc()){?>
                <li class="list-group-item d-flex justify-content-between lh-sm">
                    <div>
                    <h6 class="my-0"><?php echo $rows['item_name']?></h6>
                    <small class="text-muted"><?php echo $rows['category_name']?></small>
                    </div>
                    <span class="text-muted">£<?php echo $rows['itemTotal']?></span>
               </li>
            <?php ;}
          ?>
          <li class="list-group-item d-flex justify-content-between">
            <?php
                $query = "SELECT SUM(menu.price * cart_item.quantity) AS total FROM cart_item INNER JOIN menu ON menu.id = cart_item.item_id WHERE user_cart_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i",$cartID);
                $stmt->execute();
                $result = $stmt->get_result();
                $rows = $result->fetch_assoc();
            ?> 
            <span>Total (GBP)</span>
            <strong>£<?php echo $rows['total']?></strong>
          </li>
        </ul>
      </div>
      <div class="col-md-7 col-lg-8">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="cart.php">Cart</a></li>
            <li class="breadcrumb-item"><a href="checkoutShipping.php">Delivery</a></li>
            <li class="breadcrumb-item active" aria-current="page">Payment</li>
          </ol>
        </nav>
        <h4 class="mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" style="vertical-align: -.125em" width="23" height="23" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
                <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
            </svg> Payment details
        </h4>
        <form class="needs-validation" method="POST" novalidate>
          <div class="row g-3">
            
            <div class="col-sm-12">
              <label class="form-label">Provider</label>
              <select name= "providerOption" style="width: 100px" class="form-select">
                <option value="Visa">Visa</option>
                <option value="Mastercard">Mastercard</option>
                <option value="Amex">Amex</option>
              </select>
            </div>

            <div class="col-sm-6">
              <label for="cardNumber" class="form-label">Card Number</label>
              <input type="text" class="form-control <?php echo (!empty($cardNumber_err)) ? 'is-invalid' : ''; ?>" name="cardNumber" value="<?php echo $cardNumber; ?>" maxlength="16">
              <span class="invalid-feedback"><?php echo $cardNumber_err; ?></span>
            </div>

            <div class="col-sm-2">
              <label for="expMonth" class="form-label">Expiry Month</label>
              <input type="text" class="form-control <?php echo (!empty($expMonth_err)) ? 'is-invalid' : ''; ?>" name="expMonth" placeholder="MM" value="<?php echo $expMonth; ?>" maxlength="2">
              <span class="invalid-feedback"><?php echo $expMonth_err; ?></span>
            </div>

            <div class="col-sm-2">
              <label for="expYear" class="form-label">Expiry Year</label>
              <input type="text" class="form-control <?php echo (!empty($expYear_err)) ? 'is-invalid' : ''; ?>" name="expYear" placeholder="YY" value="<?php echo $expYear; ?>" maxlength="2">
              <span class="invalid-feedback"><?php echo $expYear_err; ?></span>
            </div>

            <div class="col-sm-2">
              <label for="cvv" class="form-label">CVV</label>
              <input type="text" class="form-control <?php echo (!empty($cvv_err)) ? 'is-invalid' : ''; ?>" name="cvv" placeholder="" value="<?php echo $cvv; ?>" maxlength="4">
              <span class="invalid-feedback"><?php echo $cvv_err; ?></span>
            </div>
          </div>
          <hr class="my-4">

          <button class="w-100 btn btn-primary btn-lg" type="submit">Place order</button>
        </form>
      </div>
    </div>
    </main>
    </div>
    
    <footer class="py-4 my-4 foot-section">
      <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li class="text-start nav-item"><a href="aboutUs.php" class="nav-link px-2 text-muted">About</a></li>
        <li class="text-center nav-item"><a href="privacy.php" class="nav-link px-2 text-muted">Privacy Policy</a></li>
        <li class="text-end nav-item"><a href="contact.php" class="nav-link px-2 text-muted">Contact Us</a></li>
      </ul>
    </footer>
  </body>
</html>