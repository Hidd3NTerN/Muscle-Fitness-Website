<?php
include('session_m.php');
if (!isset($login_session)) {
  header("location: customerlogin.php"); //Redirecting to mygym Page
}

if (isset($_POST['search_product'])) {
  $product_name = $_POST['search_product'];
  $sql = "SELECT * FROM product where name like '%$product_name%' ORDER BY F_ID ";
} else {
  $sql = "SELECT * FROM product ORDER BY F_ID";
}

?>


<html>

<head>
  <title> Explore | Muscle Fitness </title>
</head>

<link rel="stylesheet" type="text/css" href="css/productlist.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<body>

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

      <div class="collapse navbar-collapse " id="myNavbar">
        <ul class="nav navbar-nav">
          <li><a href="index.php">Home</a></li>
          <li><a href="aboutus.php">About</a></li>
          <li><a href="contactus.php">Contact Us</a></li>

        </ul>

        <?php
        if (isset($_SESSION['login_user1'])) {

        ?>


          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $_SESSION['login_user1']; ?> </a></li>
            <li><a href="analytics.php">MANAGER CONTROL PANEL</a></li>
            <li><a href="admin_product.php">Product Zone</a></li>
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

  <!-- Carousal ================================================================ -->
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner">

      <div class="item active">
        <img src="https://api.time.com/wp-content/uploads/2020/03/gym-coronavirus.jpg" style="width:100%;">
        <div class="carousel-caption">
        </div>
      </div>

      <div class="item">
        <img src="https://image.cnbcfm.com/api/v1/image/105999935-1562097549646sport-stretching-leisure-hobby-woman-strong-exercise-workout-gym-weightlifting_t20_v7r7a7.jpg?v=1594825333&w=929&h=523" style="width:100%;">
        <div class="carousel-caption">

        </div>
      </div>
      <div class="item">
        <img src="https://www.cnet.com/a/img/resize/d7905a9724299ec12fc9aca6bb9271949ee7793d/2020/03/06/5afa92b5-777b-4ef8-ab4a-07253682bffe/gettyimages-1132006407.jpg?auto=webp&fit=crop&height=675&width=1200" style="width:100%;">
        <div class="carousel-caption">

        </div>
      </div>

    </div>
    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <!-- Carousal End -->

  <div class="jumbotron">
    <div class="container text-center">
      <h1>Muscle Fitness</h1>
      <p>See our latest product</p>
    </div>
  </div>


  <form action="" class="search" method="POST">
    <input type="search" class="input_search" placeholder="search product" name="search_product" style="margin-bottom: 10px;">
  </form>

  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Fill in the form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label for="exampleFormControlSelect1">Select Body Type</label>
              <select class="form-control" id="exampleFormControlSelect1">
                <option>Skinny</option>
                <option>Average</option>
                <option>Fat</option>
              </select>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Password</label>
              <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1">
              <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </div>

  <div class="container" style="width:95%;">

    <!-- Display all Product from product table -->
    <?php
    $result = mysqli_query($conn, $sql);
    // die($conn->error);
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
    ?>
        <div class="col-md-4">
          <form method="post" action="cart.php?action=add&id=<?php echo $row["F_ID"]; ?>">
            <div class="mypanel" align="center" ;>
              <img style="height: 200px;" src="<?php echo $row["images_path"]; ?>" class="img-responsive">
              <h5 class="text-info"><?php echo $row["name"]; ?></h5>
              <h5 class="text-info"><?php echo $row["description"]; ?></h5>
              <h5 class="text-danger">RM <?php echo $row["price"]; ?></h5>
              <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>">
              <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>">
              <input type="hidden" name="hidden_RID" value="<?php echo $row["R_ID"]; ?>">
            </div>
          </form>
        </div>
      <?php
      }
    } else {
      ?>

      <div class="container">
        <div class="jumbotron">
          <center>
            <label style="margin-left: 5px;color: red;">
              <h1>Oops! No product is available.</h1>
            </label>
            <p>Stay Hungry...! :P</p>
          </center>

        </div>
      </div>

    <?php

    }

    ?>

  </div>

</body>
<!--
  <footer class="container-fluid bg-4 text-center">
  <br>
  <p> Muscle Fitness 2022 | &copy All Rights Reserved </p>
  <br>
  </footer>
-->

</html>