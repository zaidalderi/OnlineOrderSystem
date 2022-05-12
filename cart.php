<?php
    session_start();
    if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] != true){
        header("location: signin.php");
        exit;
    }else{
        $servername  = "localhost";
        $database = "Website_Database";
        $username = "root";
        $password = "";
    
        $conn  = mysqli_connect($servername, $username, $password, $database);
        $cartID = $_SESSION['cartID'];
        $query = "SELECT cart_item.id AS cartItemID, menu.id AS itemID, menu.name AS item_name, cart_item.quantity AS selectedQuantity, item_category.name AS category_name, menu.price, menu.main_image_link, menu.price * cart_item.quantity AS itemTotal FROM cart_item INNER JOIN menu ON cart_item.item_id = menu.id 
        INNER JOIN item_category ON menu.category_id = item_category.id WHERE user_cart_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i",$cartID);
        $stmt->execute();
        $result = $stmt->get_result();
        if(isset($_POST['search'])){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                $search = $_POST['search'];
                header("location: searchResults.php?searchParam=$search");
            }
        }
    }
?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Cart</title>

    <!-- Bootstrap css -->
    <link href="css/bootstrap.css?v=2.0" rel="stylesheet" type="text/css" />

    <!-- Custom css -->
    <link href="css/ui.css?v=2.0" rel="stylesheet" type="text/css" />

    <!-- Bootstrap core CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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

  </head>

  <body class="d-flex flex-column min-vh-100">
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
          <div class="col-lg-9">

            <div class="card">
              <div class="content-body">
                <h4 class="card-title mb-4">Your cart</h4>
                <?php
                $cartCounter = 1;
                while($rows = $result->fetch_assoc()){?>
                <article class="row gy-3 mb-4">
                  <div class="col-lg-5">
                    <figure class="itemside me-lg-5">
                      <div class="aside"><img src="<?php echo $rows['main_image_link'] ?>" class="img-sm img-thumbnail"></div>
                      <figcaption class="info">
                        <a href="singleItem.php?id=<?php echo $rows['itemID'] ?>" class="title"><?php echo $rows['item_name'] ?></a>
                        <p class="text-muted"> <?php echo $rows['category_name'] ?> </p>
                      </figcaption>
                    </figure>
                  </div>
                  <div class="col-2">
                    <div class="input-group mb-3"> <a href="reduceQuantity.php?itemID=<?php echo $rows['itemID'];?>&currentQuantity=<?php echo $rows['selectedQuantity'];?>" class="input-group-text">-</a> <input type="text" class="form-control" value="<?php echo $rows['selectedQuantity']?>" style="text-align:center; background-color: white;" readonly> <a href="increaseQuantity.php?itemID=<?php echo $rows['itemID'];?>" class="input-group-text">+</a> </div>
                  </div>
                  <div class="col-lg-2 col-sm-4 col-6">
                    <div class="price-wrap lh-sm">
                      <var id="price<?php echo $cartCounter?>" class="price h6">£<?php echo $rows['itemTotal']?></var> <br>
                      <small class="text-muted"> £<?php echo $rows['price'] ?> / per item </small>
                    </div>
                  </div>
                  <div class="col-lg col-sm-4">
                    <div class="float-lg-end">
                      <a href="removeItemFromCart.php?itemID=<?php echo $rows['itemID']?>" class="btn btn-light text-danger"> Remove</a>
                    </div>
                  </div>
                </article>
                <?php $cartCounter++;}
                    ?>
              </div>

            </div>

          </div>
          <aside class="col-lg-3">
            <div class="card">
              <?php
                    $itemCount = mysqli_num_rows($result);
                    $query = "SELECT SUM(menu.price * cart_item.quantity) AS total FROM cart_item INNER JOIN menu ON menu.id = cart_item.item_id WHERE user_cart_id = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("i",$cartID);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $rows = $result->fetch_assoc();
                    $total = "";
                    if($itemCount == 0){
                        $total = "0.00";
                    }else{
                        $total = $rows['total'];
                    }
                ?>
              <div class="card-body">
                <dl class="dlist-align">
                  <dt>Total price:</dt>
                  <dd class="text-end">£<?php echo $total ?></dd>
                </dl>
                <hr>
                <dl class="dlist-align">
                  <dt>Total:</dt>
                  <dd id="total_price" class="text-end text-dark h5">£<?php echo $total ?></dd>
                </dl>

                <div class="d-grid gap-2 my-3">
                  <?php
                            if($itemCount === 0){
                                echo '<a href="index.php" class="btn btn-light w-100"> Back to menu </a>';
                            }else{
                                echo '<a href="checkoutShipping.php" class="btn btn-success w-100"> Checkout </a>
                                <a href="index.php" class="btn btn-light w-100"> Back to menu </a>';
                            }
                        ?>
                </div>
              </div>
            </div>

          </aside>

        </div>

      </div>
    </section>

    <footer class="mt-auto py-4 my-4 footer-class">
      <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li class="text-start nav-item"><a href="aboutUs.php" class="nav-link px-2 text-muted">About</a></li>
        <li class="text-center nav-item"><a href="privacy.php" class="nav-link px-2 text-muted">Privacy Policy</a></li>
        <li class="text-end nav-item"><a href="contact.php" class="nav-link px-2 text-muted">Contact Us</a></li>
      </ul>
    </footer>

  </body>

</html>