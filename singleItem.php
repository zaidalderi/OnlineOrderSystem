<?php
    session_start();
    $servername  = "localhost";
    $database = "Website_Database";
    $username = "root";
    $password = "";
    $itemID = $_GET['id'];
    $conn  = mysqli_connect($servername, $username, $password, $database);
    if(isset($_POST['search'])){
      if($_SERVER["REQUEST_METHOD"] == "POST"){
        $search = $_POST['search'];
        header("location: searchResults.php?searchParam=$search");
      }
    }else{
      if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
          header("location: signin.php");
          exit;
        }else{
          $quantity = $_POST['quantity'];
          $cartID = $_SESSION['cartID'];
          $sql = "SELECT * FROM cart_item WHERE cart_item.user_cart_id = ? AND cart_item.item_id = ?";
          $stmt = $conn->prepare($sql); 
          $stmt->bind_param("ii", $cartID, $itemID);
          $stmt->execute();
          $result = $stmt->get_result(); // get the mysqli result
          if($result->num_rows == 0){
            $sql = "INSERT INTO `cart_item` (`id`, `user_cart_id`, `item_id`, `quantity`, `created_at`, `modified_at`) VALUES (NULL, ?, ?, ?, current_timestamp(), current_timestamp())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii",$cartID, $itemID, $quantity);
            if($stmt->execute()){
              header("location: cart.php");
              exit;
            }
          }else{
            $sql = "UPDATE cart_item SET cart_item.quantity = ? WHERE cart_item.user_cart_id = ? AND cart_item.item_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iii", $quantity, $cartID, $itemID);
            if($stmt->execute()){
              header("location: cart.php");
              exit;
            }
          }
        }
      }
    }
    $sql = "SELECT menu.id,menu.name AS 'item_name', menu.description, menu.SKU, menu.price, menu.main_image_link, item_category.name AS 'category_name' FROM menu INNER JOIN item_category ON menu.category_id = item_category.id
    WHERE menu.id = ?";
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("i",$itemID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    mysqli_close($conn);
?>
<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="generator" content="Hugo 0.88.1">
    <title><?php echo $row['item_name']?></title>

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
    <script type="text/javascript">
      function imageChange(imageID) {
        var smallImgSrc = document.getElementById(imageID).src;
        var smallImg = document.getElementById(imageID);
        document.getElementById("main_image").src = smallImgSrc;
      }
    </script>
    <!-- Custom css -->
    <link href="css/ui.css?v=2.0" rel="stylesheet" type="text/css" />
    <link href="css/responsive.css?v=2.0" rel="stylesheet" type="text/css" />
    <!-- Font awesome 5 -->
    <link href="fonts/fontawesome/css/all.min.css" type="text/css" rel="stylesheet">
  </head>

  <body>
    <main>
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
      <section class="padding-y">
        <div class="container">

          <div class="row">
            <aside class="col-lg-6">
              <article class="gallery-wrap">
                <div class="img-big-wrap img-thumbnail bigImg">
                  <a data-fslightbox="mygalley" data-type="image">
                    <img id="main_image" height="550" width="550" src="<?php echo $row['main_image_link']?>">
                  </a>
                </div>
              </article>
            </aside>
            <main class="col-lg-6">
              <article class="ps-lg-3">
                <h4 class="title text-dark"><?php echo $row['item_name'] ?> </h4>

                <div class="mb-3 mt-5">
                  <var class="price h5">£<?php echo $row['price'] ?></var>
                </div>

                <p><?php echo $row['description'] ?></p>

                <dl class="row">
                  <dt class="col-3">Category:</dt>
                  <dd class="col-9"><?php echo $row['category_name'] ?></dd>
                </dl>

                <hr>

                <div class="row mb-4">
                  <div class="col-md-4 col-6 mb-3">
                    <label class="form-label d-block">Quantity</label>
                    <div class="col-auto">
                      <form method="post">
                        <input class="form-control" type="number" name="quantity" placeholder="" min="1" value="1">
                        <br>
                        <button href="#" class="btn  btn-primary" type="submit"> <i class="me-1 fa fa-shopping-basket"></i> Add to cart </button>
                      </form>
                    </div>
                  </div>
                </div>
              </article>
            </main>
          </div>

        </div>
      </section>
      <footer class="mt-auto py-4 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
          <li class="text-start nav-item"><a href="aboutUs.php" class="nav-link px-2 text-muted">About</a></li>
          <li class="text-center nav-item"><a href="privacy.php" class="nav-link px-2 text-muted">Privacy Policy</a></li>
          <li class="text-end nav-item"><a href="contact.php" class="nav-link px-2 text-muted">Contact Us</a></li>
        </ul>
      </footer>
    </main>
  </body>

</html>
