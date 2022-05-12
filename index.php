<?php
    session_start();
    $servername  = "localhost";
    $database = "Website_Database";
    $username = "root";
    $password = "";

    $conn  = mysqli_connect($servername, $username, $password, $database);
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
      $id = $_SESSION['id'];
      $sql = "SELECT * FROM user_cart WHERE user_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i",$id);
      $stmt->execute();
      $result = $stmt->get_result();
      if(mysqli_num_rows($result) > 0){
        $row= $result->fetch_assoc();
        $_SESSION['cartID'] = $row['id'];
      }else{
        $sql = "INSERT INTO `user_cart` (`id`, `user_id`, `total`, `created_at`, `modified_at`) VALUES (NULL, ?, '0', current_timestamp(), current_timestamp())";
        mysqli_query($conn,$sql);
        $stmt = mysqli_prepare($conn,$sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $sql = "SELECT * FROM user_cart WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $_SESSION['cartID'] = $row['id'];
      }
      if(isset($_POST['search'])){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
          $search = $_POST['search'];
          header("location: searchResults.php?searchParam=$search");
        }
      }
    }
    $sql = "SELECT * FROM `menu` ORDER BY RAND() LIMIT 9";
    $result = $conn->query($sql);
    mysqli_close($conn);
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="generator" content="Hugo 0.88.1">
    <title>Online Order System</title>


    

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
      .search-button:hover{
        background-color: orange;
        border-color: orange;
        color: white;
      }
      
      .cart-button:hover{
        background-color: orange;
        border-color: orange;
        color: white;
      }

      .card {
        height: 420px;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style> 

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
              <a class='nav-link dropdown-toggle text-white text-center' href='#' data-bs-toggle='dropdown'>
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
          <a role="button" href = "cart.php" class="btn btn-outline-yellow me-2 btn-sm btn-warning cart-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
              <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </svg>
          </a>
        </div>
      </div>
      
    </div>
  </header>

  <div class="album py-5 bg-light">
    <div class="container">
      <h3 class="fw-bold">Featured Menu</h3>
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
          <?php
            while($row = $result->fetch_assoc()){?>
              <div class="col">
                <div class="card shadow-sm">
                  <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                      <div class="carousel-item active">
                        <a href="singleItem.php?id=<?php echo $row['id'] ?>"><img src="<?php echo $row['main_image_link']?>" class="d-block w-100" style="height: 300px !important;"></a>
                      </div>
                    </div>
                  </div>
                  <div class="card-body">
                    <a class="fw-bold card-text text-decoration-none text-black" href="singleItem.php?id=<?php echo $row['id'] ?>"><?php echo $row['name'] ?></a>
                    <p class="text-danger card-text">£<?php echo $row['price'] ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                    </div>
                  </div>
                </div>
              </div>
            <?php ;}
          ?>
      </div>
    </div>
  </div>

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
