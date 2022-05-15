<?php
    session_start();
    $cartID = $_SESSION['cartID'];
    $id = $_SESSION['id'];
    $servername  = "localhost";
    $database = "Website_Database";
    $username = "root";
    $password = "";

    $conn  = mysqli_connect($servername, $username, $password, $database);

    $sql = "SELECT * FROM user WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_assoc();
    

    $firstName_err = $lastName_err = $addressLine1_err = $addressLine2_err = $email_err = $city_err = $mobile_err = $postcode_err = "";
    $addressLine1 = $addressLine2 = $city = $mobile = $postcode = "";
    $firstName = $rows['first_name'];
    $lastName = $rows['last_name'];
    $email = $rows['email'];
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      //Form fields validation
      if(empty(trim($_POST['firstName']))){
        $firstName_err = "Enter first name";
      }else{
        $_SESSION['checkoutFirstName'] = $_POST['firstName'];
        $firstName = $_POST['firstName'];
      }

      if(empty(trim($_POST['lastName']))){
        $lastName_err = "Enter last name";
      }else{
        $_SESSION['checkoutLastName'] = $_POST['lastName'];
        $lastName = $_POST['lastName'];
      }

      if(empty(trim($_POST['address1']))){
        $addressLine1_err = "Enter address line 1";
      }else{
        $_SESSION['checkoutAddress1'] = $_POST['address1'];
        $addressLine1 = $_POST['address1'];
      }

      if(empty(trim($_POST['address2']))){
        $addressLine2_err = "Enter address line 2";
      }else{
        $_SESSION['checkoutAddress2'] = $_POST['address2'];
        $addressLine2 = $_POST['address2'];
      }

      if(empty(trim($_POST['email']))){
        $email_err = "Enter email";
      }else{
        $_SESSION['checkoutEmail'] = $_POST['email'];
        $email = $_POST['email'];
      }

      if(empty(trim($_POST['city']))){
        $city_err = "Enter city";
      }else{
        $_SESSION['checkoutCity'] = $_POST['city'];
        $city = $_POST['city'];
      }

      if(empty(trim($_POST['mobile']))){
        $mobile_err = "Enter mobile number";
      }else{
        $_SESSION['checkoutMobile'] = $_POST['mobile'];
        $mobile = $_POST['mobile'];
      }

      if(empty(trim($_POST['postcode']))){
        $postcode_err = "Enter postcode";
      }else{
        $_SESSION['checkoutPostcode'] = $_POST['postcode'];
        $postcode = $_POST['postcode'];
      }

      $_SESSION['checkoutCountry'] = $_POST['country'];

      if(empty($firstName_err) && empty($lastName_err) && empty($addressLine1_err) && empty($addressLine2_err) && empty($email_err) && empty($city_err) && empty($mobile_err) && empty($postcode_err)){
        header("location:checkoutPayment.php");
        exit;
      }
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delivery</title>

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
        $sql = "SELECT menu.id, menu.name AS menu_name, cart_item.quantity AS selectedQuantity, item_category.name AS category_name, menu.price, menu.main_image_link, menu.price * cart_item.quantity AS itemTotal FROM cart_item INNER JOIN menu ON cart_item.item_id = menu.id 
        INNER JOIN item_category ON menu.category_id = item_category.id WHERE user_cart_id = ?";
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
                    <h6 class="my-0"><?php echo $rows['menu_name']?><small><?php echo " x" . $rows['selectedQuantity']?></small></h6>
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
                $_SESSION['total'] = $rows['total'];
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
            <li class="breadcrumb-item active" aria-current="page">Delivery</li>
          </ol>
        </nav>
        <h4 class="mb-3">Delivery address</h4>
        <form class="needs-validation" method="POST" novalidate>
          <div class="row g-3">
            <div class="col-sm-6">
              <label for="firstName" class="form-label">First name</label>
              <input type="text" class="form-control <?php echo (!empty($firstName_err)) ? 'is-invalid' : ''; ?>" name="firstName" placeholder="John" value="<?php echo $firstName;?>">
              <span class="invalid-feedback"><?php echo $firstName_err; ?></span>
            </div>

            <div class="col-sm-6">
              <label for="lastName" class="form-label">Last name</label>
              <input type="text" class="form-control <?php echo (!empty($lastName_err)) ? 'is-invalid' : ''; ?>" name="lastName" placeholder="Smith" value="<?php echo $lastName;?>">
              <span class="invalid-feedback"><?php echo $lastName_err; ?></span>
            </div>

            <div class="col-sm-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" name="email" placeholder="you@example.com" value="<?php echo $email;?>">
              <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>

            <div class="col-sm-6">
              <label for="zip" class="form-label">Mobile number</label>
              <input type="text" class="form-control <?php echo (!empty($mobile_err)) ? 'is-invalid' : ''; ?>" name="mobile" placeholder="+44123789456" value="<?php echo $mobile;?>">
              <span class="invalid-feedback"><?php echo $mobile_err; ?></span>
            </div>

            <div class="col-12">
              <label for="address1" class="form-label">Address Line 1</label>
              <input type="text" class="form-control <?php echo (!empty($addressLine1_err)) ? 'is-invalid' : ''; ?>" name="address1" placeholder="1234 Main St" value="<?php echo $addressLine1;?>">
              <span class="invalid-feedback"><?php echo $addressLine1_err; ?></span>
            </div>

            <div class="col-12">
              <label for="address2" class="form-label">Address Line 2</label>
              <input type="text" class="form-control <?php echo (!empty($addressLine2_err)) ? 'is-invalid' : ''; ?>" name="address2" placeholder="Apartment or house number" value="<?php echo $addressLine2;?>">
              <span class="invalid-feedback"><?php echo $addressLine2_err; ?></span>
            </div>

            <div class="col-md-5">
              <label for="country" class="form-label">Country</label>
              <select class="form-select" id="country" name="country">
                <option value="Afganistan">Afghanistan</option>
                <option value="Albania">Albania</option>
                <option value="Algeria">Algeria</option>
                <option value="American Samoa">American Samoa</option>
                <option value="Andorra">Andorra</option>
                <option value="Angola">Angola</option>
                <option value="Anguilla">Anguilla</option>
                <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                <option value="Argentina">Argentina</option>
                <option value="Armenia">Armenia</option>
                <option value="Aruba">Aruba</option>
                <option value="Australia">Australia</option>
                <option value="Austria">Austria</option>
                <option value="Azerbaijan">Azerbaijan</option>
                <option value="Bahamas">Bahamas</option>
                <option value="Bahrain">Bahrain</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Barbados">Barbados</option>
                <option value="Belarus">Belarus</option>
                <option value="Belgium">Belgium</option>
                <option value="Belize">Belize</option>
                <option value="Benin">Benin</option>
                <option value="Bermuda">Bermuda</option>
                <option value="Bhutan">Bhutan</option>
                <option value="Bolivia">Bolivia</option>
                <option value="Bonaire">Bonaire</option>
                <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                <option value="Botswana">Botswana</option>
                <option value="Brazil">Brazil</option>
                <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                <option value="Brunei">Brunei</option>
                <option value="Bulgaria">Bulgaria</option>
                <option value="Burkina Faso">Burkina Faso</option>
                <option value="Burundi">Burundi</option>
                <option value="Cambodia">Cambodia</option>
                <option value="Cameroon">Cameroon</option>
                <option value="Canada">Canada</option>
                <option value="Canary Islands">Canary Islands</option>
                <option value="Cape Verde">Cape Verde</option>
                <option value="Cayman Islands">Cayman Islands</option>
                <option value="Central African Republic">Central African Republic</option>
                <option value="Chad">Chad</option>
                <option value="Channel Islands">Channel Islands</option>
                <option value="Chile">Chile</option>
                <option value="China">China</option>
                <option value="Christmas Island">Christmas Island</option>
                <option value="Cocos Island">Cocos Island</option>
                <option value="Colombia">Colombia</option>
                <option value="Comoros">Comoros</option>
                <option value="Congo">Congo</option>
                <option value="Cook Islands">Cook Islands</option>
                <option value="Costa Rica">Costa Rica</option>
                <option value="Cote DIvoire">Cote DIvoire</option>
                <option value="Croatia">Croatia</option>
                <option value="Cuba">Cuba</option>
                <option value="Curaco">Curacao</option>
                <option value="Cyprus">Cyprus</option>
                <option value="Czech Republic">Czech Republic</option>
                <option value="Denmark">Denmark</option>
                <option value="Djibouti">Djibouti</option>
                <option value="Dominica">Dominica</option>
                <option value="Dominican Republic">Dominican Republic</option>
                <option value="East Timor">East Timor</option>
                <option value="Ecuador">Ecuador</option>
                <option value="Egypt">Egypt</option>
                <option value="El Salvador">El Salvador</option>
                <option value="Equatorial Guinea">Equatorial Guinea</option>
                <option value="Eritrea">Eritrea</option>
                <option value="Estonia">Estonia</option>
                <option value="Ethiopia">Ethiopia</option>
                <option value="Falkland Islands">Falkland Islands</option>
                <option value="Faroe Islands">Faroe Islands</option>
                <option value="Fiji">Fiji</option>
                <option value="Finland">Finland</option>
                <option value="France">France</option>
                <option value="French Guiana">French Guiana</option>
                <option value="French Polynesia">French Polynesia</option>
                <option value="French Southern Ter">French Southern Ter</option>
                <option value="Gabon">Gabon</option>
                <option value="Gambia">Gambia</option>
                <option value="Georgia">Georgia</option>
                <option value="Germany">Germany</option>
                <option value="Ghana">Ghana</option>
                <option value="Gibraltar">Gibraltar</option>
                <option value="Great Britain">Great Britain</option>
                <option value="Greece">Greece</option>
                <option value="Greenland">Greenland</option>
                <option value="Grenada">Grenada</option>
                <option value="Guadeloupe">Guadeloupe</option>
                <option value="Guam">Guam</option>
                <option value="Guatemala">Guatemala</option>
                <option value="Guinea">Guinea</option>
                <option value="Guyana">Guyana</option>
                <option value="Haiti">Haiti</option>
                <option value="Hawaii">Hawaii</option>
                <option value="Honduras">Honduras</option>
                <option value="Hong Kong">Hong Kong</option>
                <option value="Hungary">Hungary</option>
                <option value="Iceland">Iceland</option>
                <option value="Indonesia">Indonesia</option>
                <option value="India">India</option>
                <option value="Iran">Iran</option>
                <option value="Iraq">Iraq</option>
                <option value="Ireland">Ireland</option>
                <option value="Isle of Man">Isle of Man</option>
                <option value="Israel">Israel</option>
                <option value="Italy">Italy</option>
                <option value="Jamaica">Jamaica</option>
                <option value="Japan">Japan</option>
                <option value="Jordan">Jordan</option>
                <option value="Kazakhstan">Kazakhstan</option>
                <option value="Kenya">Kenya</option>
                <option value="Kiribati">Kiribati</option>
                <option value="Korea North">Korea North</option>
                <option value="Korea Sout">Korea South</option>
                <option value="Kuwait">Kuwait</option>
                <option value="Kyrgyzstan">Kyrgyzstan</option>
                <option value="Laos">Laos</option>
                <option value="Latvia">Latvia</option>
                <option value="Lebanon">Lebanon</option>
                <option value="Lesotho">Lesotho</option>
                <option value="Liberia">Liberia</option>
                <option value="Libya">Libya</option>
                <option value="Liechtenstein">Liechtenstein</option>
                <option value="Lithuania">Lithuania</option>
                <option value="Luxembourg">Luxembourg</option>
                <option value="Macau">Macau</option>
                <option value="Macedonia">Macedonia</option>
                <option value="Madagascar">Madagascar</option>
                <option value="Malaysia">Malaysia</option>
                <option value="Malawi">Malawi</option>
                <option value="Maldives">Maldives</option>
                <option value="Mali">Mali</option>
                <option value="Malta">Malta</option>
                <option value="Marshall Islands">Marshall Islands</option>
                <option value="Martinique">Martinique</option>
                <option value="Mauritania">Mauritania</option>
                <option value="Mauritius">Mauritius</option>
                <option value="Mayotte">Mayotte</option>
                <option value="Mexico">Mexico</option>
                <option value="Midway Islands">Midway Islands</option>
                <option value="Moldova">Moldova</option>
                <option value="Monaco">Monaco</option>
                <option value="Mongolia">Mongolia</option>
                <option value="Montserrat">Montserrat</option>
                <option value="Morocco">Morocco</option>
                <option value="Mozambique">Mozambique</option>
                <option value="Myanmar">Myanmar</option>
                <option value="Nambia">Nambia</option>
                <option value="Nauru">Nauru</option>
                <option value="Nepal">Nepal</option>
                <option value="Netherland Antilles">Netherland Antilles</option>
                <option value="Netherlands">Netherlands (Holland, Europe)</option>
                <option value="Nevis">Nevis</option>
                <option value="New Caledonia">New Caledonia</option>
                <option value="New Zealand">New Zealand</option>
                <option value="Nicaragua">Nicaragua</option>
                <option value="Niger">Niger</option>
                <option value="Nigeria">Nigeria</option>
                <option value="Niue">Niue</option>
                <option value="Norfolk Island">Norfolk Island</option>
                <option value="Norway">Norway</option>
                <option value="Oman">Oman</option>
                <option value="Pakistan">Pakistan</option>
                <option value="Palau Island">Palau Island</option>
                <option value="Palestine">Palestine</option>
                <option value="Panama">Panama</option>
                <option value="Papua New Guinea">Papua New Guinea</option>
                <option value="Paraguay">Paraguay</option>
                <option value="Peru">Peru</option>
                <option value="Phillipines">Philippines</option>
                <option value="Pitcairn Island">Pitcairn Island</option>
                <option value="Poland">Poland</option>
                <option value="Portugal">Portugal</option>
                <option value="Puerto Rico">Puerto Rico</option>
                <option value="Qatar">Qatar</option>
                <option value="Republic of Montenegro">Republic of Montenegro</option>
                <option value="Republic of Serbia">Republic of Serbia</option>
                <option value="Reunion">Reunion</option>
                <option value="Romania">Romania</option>
                <option value="Russia">Russia</option>
                <option value="Rwanda">Rwanda</option>
                <option value="St Barthelemy">St Barthelemy</option>
                <option value="St Eustatius">St Eustatius</option>
                <option value="St Helena">St Helena</option>
                <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                <option value="St Lucia">St Lucia</option>
                <option value="St Maarten">St Maarten</option>
                <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                <option value="Saipan">Saipan</option>
                <option value="Samoa">Samoa</option>
                <option value="Samoa American">Samoa American</option>
                <option value="San Marino">San Marino</option>
                <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                <option value="Saudi Arabia">Saudi Arabia</option>
                <option value="Senegal">Senegal</option>
                <option value="Seychelles">Seychelles</option>
                <option value="Sierra Leone">Sierra Leone</option>
                <option value="Singapore">Singapore</option>
                <option value="Slovakia">Slovakia</option>
                <option value="Slovenia">Slovenia</option>
                <option value="Solomon Islands">Solomon Islands</option>
                <option value="Somalia">Somalia</option>
                <option value="South Africa">South Africa</option>
                <option value="Spain">Spain</option>
                <option value="Sri Lanka">Sri Lanka</option>
                <option value="Sudan">Sudan</option>
                <option value="Suriname">Suriname</option>
                <option value="Swaziland">Swaziland</option>
                <option value="Sweden">Sweden</option>
                <option value="Switzerland">Switzerland</option>
                <option value="Syria">Syria</option>
                <option value="Tahiti">Tahiti</option>
                <option value="Taiwan">Taiwan</option>
                <option value="Tajikistan">Tajikistan</option>
                <option value="Tanzania">Tanzania</option>
                <option value="Thailand">Thailand</option>
                <option value="Togo">Togo</option>
                <option value="Tokelau">Tokelau</option>
                <option value="Tonga">Tonga</option>
                <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                <option value="Tunisia">Tunisia</option>
                <option value="Turkey">Turkey</option>
                <option value="Turkmenistan">Turkmenistan</option>
                <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                <option value="Tuvalu">Tuvalu</option>
                <option value="Uganda">Uganda</option>
                <option value="United Kingdom">United Kingdom</option>
                <option value="Ukraine">Ukraine</option>
                <option value="United Arab Erimates">United Arab Emirates</option>
                <option value="United States of America">United States of America</option>
                <option value="Uraguay">Uruguay</option>
                <option value="Uzbekistan">Uzbekistan</option>
                <option value="Vanuatu">Vanuatu</option>
                <option value="Vatican City State">Vatican City State</option>
                <option value="Venezuela">Venezuela</option>
                <option value="Vietnam">Vietnam</option>
                <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                <option value="Wake Island">Wake Island</option>
                <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                <option value="Yemen">Yemen</option>
                <option value="Zaire">Zaire</option>
                <option value="Zambia">Zambia</option>
                <option value="Zimbabwe">Zimbabwe</option>
                </select>
              <div class="invalid-feedback">
                Please select a valid country.
              </div>
            </div>

            <div class="col-md-4">
              <label for="zip" class="form-label">City</label>
              <input type="text" class="form-control <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>" name="city" placeholder="" value="<?php echo $city;?>">
              <span class="invalid-feedback"><?php echo $city_err; ?></span>
            </div>

            <div class="col-md-3">
              <label for="zip" class="form-label">Postcode</label>
              <input type="text" class="form-control <?php echo (!empty($postcode_err)) ? 'is-invalid' : ''; ?>" name="postcode" placeholder="" value="<?php echo $postcode;?>">
              <span class="invalid-feedback"><?php echo $postcode_err; ?></span>
            </div>
          </div>
          <hr class="my-4">

          <button class="w-100 btn btn-primary btn-lg" type="submit">Continue to payment</button>
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