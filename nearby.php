<?php
session_start();

if (!isset($_SESSION['login_user2'])) {
  header("location: customerlogin.php"); //Redirecting to mygym Page
}

if (isset($_POST['search_product'])) {
  $product_name = $_POST['search_product'];
  $sql = "SELECT * FROM product where name like '%$product_name%' ORDER BY F_ID ";
} else {
  $sql = "SELECT * FROM product ORDER BY F_ID";
}

if (isset($_POST['recommend'])) {
  $body_type = $_POST['body_type'];
  $goal = $_POST['goal'];
  $exercise = $_POST['exercise'];

  if ($body_type == "skinny" && $goal == "bulk") {
    $sql = "SELECT * FROM product where type = LOWER('creatine') or type = LOWER('mass_gainer')";
  } else if ($body_type == "skinny" && $goal == "bulk_low_fat") {
    $sql = "SELECT * FROM product where type = LOWER('creatine') or type = LOWER('whey_protein')";
  } else if ($body_type == "average" && $goal == "slim") {
    $sql = "SELECT * FROM product where type = LOWER('creatine') or type = LOWER('whey_protein')";
  } else if ($body_type == "average" && $goal == "bulk") {
    $sql = "SELECT * FROM product where type = LOWER('creatine') or type = LOWER('mass_gainer')";
  } else if ($body_type == "average" && $goal == "bulk_low_fat") {
    $sql = "SELECT * FROM product where type = LOWER('creatine') or type = LOWER('whey_protein')";
  } else if ($body_type == "fat" && $goal == "bulk") {
    $sql = "SELECT * FROM product where type = LOWER('creatine') or type = LOWER('whey_protein')";
  } else if ($body_type == "fat" && $goal == "slim") {
    $sql = "SELECT * FROM product where type = LOWER('creatine') or type = LOWER('whey_protein')";
  } else if ($body_type == "fat" && $goal == "bulk_low_fat") {
    $sql = "SELECT * FROM product where type = LOWER('creatine') or type = LOWER('whey_protein')";
  }

  $sql .=  " or type = '$exercise'";
}

// filter by product
if (isset($_POST['filter'])) {
  if (isset($_POST['protein'])) {

    if (in_array("all", $_POST['protein'])) {
      $sql = "SELECT * FROM product ";
    } else {
      $sql = "SELECT * FROM product where type = '" . $_POST['protein'][0] . "'";
      for ($x = 1; $x < count($_POST['protein']); $x++) {
        $sql .= " or type = '" . $_POST['protein'][$x] . "'";
      }
    }

    if ($_POST['product_brand'] != "all") {
      $sql .= " and product_brand = '" . $_POST['product_brand'] . "'";
    }

    // die($sql);

  }
}

if (isset($_POST['bmi_submit'])) {


  $height = $_POST['height'];
  $weight = $_POST['weight'];
  $square = $height * $height;
  $bmi = $weight / $height;
  $status = '';

  if ($bmi < 18.5) {
    $status = 'Skinny';
  } else if ($bmi >= 18.5 && $bmi <= 24.9) {
    $status = 'Average';
  } else if ($bmi >= 25) {
    $status = 'Fat';
  }
?>
  <script>
    alert('Your bmi is ' + '<?php echo $bmi ?>' + ", category " + '<?php echo $status ?>')
  </script>
<?php
}

?>


<html>

<head>
  <title> Explore | Muscle Fitness </title>
</head>

<link rel="stylesheet" type="text/css" href="css/productlist.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<body id="main">

  <!--Back to top button..................................................................................-->
  <button onclick="topFunction()" id="myBtn" title="Go to top">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </button>
  <!--Javacript for back to top button....................................................................-->
  <script type="text/javascript">
    window.onscroll = function() {
      scrollFunction()
    };

    function scrollFunction() {
      if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myBtn").style.display = "block";
      } else {
        document.getElementById("myBtn").style.display = "none";
      }
    }

    function topFunction() {
      document.body.scrollTop = 0;
      document.documentElement.scrollTop = 0;
    }
  </script>

  <nav class="navbar navbar-inverse navbar-fixed-top navigation-clean-search" role="navigation">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#myNavbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Muscle Fitness</a>
      </div>

      <div class="w3-sidebar w3-bar-block w3-card w3-animate-left" style="display:none; left: 0" id="mySidebar">
        <form action="" class="" method="POST">
          <button class="w3-bar-item w3-button w3-large" onclick="w3_close()">Close &times;</button>
          <div class="form-group">
            <!-- <select name="product_type" id="" class="form-control w3-bar-item" required="">
              <option value="">Filter product</option>
              <option value="mass_gainer">Mass Gainer</option>
              <option value="creatine">Creatine</option>
              <option value="whey_protein">Whey Protein</option>
              <option value="cardio">Equipment (Cardio)</option>
              <option value="strength">Equipment (Strength)</option>
            </select> -->
            <div class="form-check w3-bar-item">
              <input class="form-check-input" type="checkbox" value="mass_gainer" id="flexCheckDefault" name="protein[]">
              <label class="form-check-label" for="flexCheckDefault">
                Mass Gainer
              </label>
            </div>
            <div class="form-check w3-bar-item">
              <input class="form-check-input" type="checkbox" value="creatine" id="flexCheckChecked" name="protein[]">
              <label class="form-check-label" for="flexCheckChecked">
                Creatine
              </label>
            </div>
            <div class="form-check w3-bar-item">
              <input class="form-check-input" type="checkbox" value="whey_protein" id="flexCheckChecked" name="protein[]">
              <label class="form-check-label" for="flexCheckChecked">
                Whey Protein
              </label>
            </div>
            <div class="form-check w3-bar-item">
              <input class="form-check-input" type="checkbox" value="all" id="flexCheckChecked" name="protein[]">
              <label class="form-check-label" for="flexCheckChecked">
                Equipment (All)
              </label>
            </div>
            <div class="form-check w3-bar-item">
              <input class="form-check-input" type="checkbox" value="cardio" id="flexCheckChecked" name="protein[]">
              <label class="form-check-label" for="flexCheckChecked">
                Equipment (Cardio)
              </label>
            </div>
            <div class="form-check w3-bar-item">
              <input class="form-check-input" type="checkbox" value="strength" id="flexCheckChecked" name="protein[]">
              <label class="form-check-label" for="flexCheckChecked">
                Equipment (Strength)
              </label>
            </div>
            <select name="product_brand" class="form-control" id="exampleFormControlSelect1" required="">
              <option value="">Select product brand</option>
              <option value="all">All</option>
              <option value="perfoma">Perfoma</option>
              <option value="optimum_nutrition">Optimum Nutrition</option>
              <option value="my_protein">My Protein</option>
              <option value="hh">Scitec Nutrition</option>
              <option value="musclePharm_corp">MusclePharm Corp</option>
              <option value="dymatize">Dymatize</option>
            </select>
          </div>
          <div class="form-group w3-bar-item">
            <button type="submit" class="btn btn-primary" name="filter">Submit</button>
          </div>
        </form>
      </div>


      <div class="collapse navbar-collapse " id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
          <li><a href="aboutus.php">About</a></li>
          <li><a href="contactus.php">Contact Us</a></li>
          <li><a href="nearby.php">Nearby store</a></li>
        </ul>

        <?php
        if (isset($_SESSION['login_user1'])) {
        ?>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_user1']; ?> </a></li>
            <li><a href="analytics.php">MANAGER CONTROL PANEL</a></li>
            <li><a href="logout_m.php"><span class="glyphicon glyphicon-log-out"></span> Log Out </a></li>
          </ul>
        <?php
        } else if (isset($_SESSION['login_user2'])) {
        ?>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_user2']; ?> </a></li>
            <li class="active"><a href="productlist.php"><span class="glyphicon glyphicon-th-list"></span> Product Zone </a></li>
            <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Cart (<?php
                                                                                                  if (isset($_SESSION["cart"])) {
                                                                                                    $count = count($_SESSION["cart"]);
                                                                                                    echo "$count";
                                                                                                  } else
                                                                                                    echo "0";
                                                                                                  ?>) </a></li>
            <li><a href="logout_u.php"><span class="glyphicon glyphicon-log-out"></span> Log Out </a></li>
          </ul>
        <?php
        } else {

        ?>

          <ul class="nav navbar-nav navbar-right">
            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> Sign Up <span class="caret"></span> </a>
              <ul class="dropdown-menu">
                <li> <a href="customersignup.php"> User Sign-up</a></li>
                <li> <a href="managersignup.php"> Admin Sign-up</a></li>
                <li> <a href="#"> Admin Sign-up</a></li>
              </ul>
            </li>

            <li><a href="#" class="dropdown-toggle active" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-log-in"></span> Login <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li> <a href="customerlogin.php"> User Login</a></li>
                <li> <a href="managerlogin.php"> Admin Login</a></li>
                <li> <a href="#"> Admin Login</a></li>
              </ul>
            </li>
          </ul>

        <?php
        }
        ?>


      </div>

    </div>
  </nav>

  <div class="jumbotron">
    <div class="container text-center">
      <h1>Muscle Fitness</h1>
    </div>
  </div>


  <div class="container" style="width:95%;">
  </div>
  <div id="body">

    <div id="chat-circle" class="btn btn-raised">
      <div id="chat-overlay"></div>
      <i class="fa fa-commenting-o fa-2x" aria-hidden="true"></i>
    </div>

    <!-- Chat box -->
    <div class="chat-box">
      <div class="chat-box-header">
        ChatBot
        <span class="chat-box-toggle"><i class="material-icons">close</i></span>
      </div>
      <div class="chat-box-body">
        <div class="chat-box-overlay">
        </div>
        <div class="chat-logs">

        </div>
        <!--chat-log -->
      </div>
      <div class="chat-input">
        <form>
          <input type="text" id="chat-input" placeholder="Send a message..." />
          <button type="submit" class="chat-submit" id="chat-submit"><i class="material-icons">send</i></button>
        </form>
      </div>
    </div>
    <iframe width="100%" height="100%" frameborder="0" style="border:0" referrerpolicy="no-referrer-when-downgrade" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDsinS9ck3ocuAeHKbWBQxYfFupm86bouc&q=gym" allowfullscreen>
    </iframe>
    <script>
      function w3_open() {
        document.getElementById("main").style.marginLeft = "25%";
        document.getElementById("mySidebar").style.width = "25%";
        document.getElementById("mySidebar").style.display = "block";
        document.getElementById("openNav").style.display = 'none';
      }

      function w3_close() {
        document.getElementById("main").style.marginLeft = "0%";
        document.getElementById("mySidebar").style.display = "none";
        document.getElementById("openNav").style.display = "inline-block";
      }
    </script>
</body>

</html>