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
  $bmi = $weight / $square;
  $bmi = number_format((float)$bmi, 2, '.', '');
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

  <!-- <div>
    <div>
      <form action="" method="POST">
        <input type="search" class="input_search" placeholder="search product" name="search_product" style="margin-bottom: 10px;">
      </form>
    </div>
  </div> -->

  <div class="container">
    <div class="row">
      <div class="col-md-2">
        <button id="openNav" class="w3-button w3-teal w3-xlarge" style="margin-bottom: 50px; border-radius: 50%" onclick="w3_open()">&#9776;</button>
      </div>
      <div class="col-md-3">
        <form action="" method="POST">
          <input type="search" placeholder="search product" name="search_product" style="margin-bottom: 10px;">
        </form>
      </div>
      <div class="col-md-3">
        <button type="button" data-toggle="modal" data-target="#exampleModal" class="btn btn-primary btn-block input_search" style="margin-bottom: 20px;">Recommend Me!</button>
      </div>
      <div class="col-md-4">
        <button type="button" data-toggle="modal" data-target="#bmiModal" class="btn btn-secondary btn-block">
          Calculate BMI
        </button>
      </div>
    </div>
  </div>



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
          <form action="" method="POST">
            <div class="form-group">
              <label for="exampleFormControlSelect1">Select Body Type</label>
              <select name="body_type" class="form-control" id="exampleFormControlSelect1" required>
                <option value="">Please select</option>
                <option value="skinny">Skinny</option>
                <option value="average">Average</option>
                <option value="fat">Fat</option>
              </select>
            </div>
            <div class="form-group">
              <label for="exampleFormControlSelect1">Select Goal</label>
              <select name="goal" class="form-control" id="exampleFormControlSelect1" required>
                <option value="">Please select</option>
                <option value="bulk">Bulk</option>
                <option value="slim">Slim</option>
                <option value="bulk_low_fat">Bulk with low fat</option>
              </select>
            </div>
            <div class="form-group">
              <label for="exampleFormControlSelect1">Exercise</label>
              <select name="exercise" class="form-control" id="exampleFormControlSelect1" required>
                <option value="">Please select</option>
                <option value="cardio">Cardio</option>
                <option value="strength">Strength</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="recommend">Submit</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="bmiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Fill in the form</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="" method="POST">
            <div class="form-group">
              <label for="height">Height in meter (m)</label>
              <input id="height" type="number" step=".01" class="form-control" name="height" min="0" required>
            </div>
            <div class="form-group">
              <label for="weight">Weight in kilogram (kg)</label>
              <input id="weight" type="number" step=".01" class="form-control" name="weight" min="0" required>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="bmi_submit">Submit</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>

  <div class="container" style="width:95%;">

    <!-- Display all Product from product table -->
    <?php

    require 'connection.php';
    $conn = Connect();
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
              <h5 class="text-info">Quantity: <input type="number" min="1" max="25" name="quantity" class="form-control" value="1" style="width: 60px;"> </h5>
              <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>">
              <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>">
              <input type="hidden" name="hidden_RID" value="<?php echo $row["R_ID"]; ?>">
              <input type="submit" name="add" style="margin-top:5px;" class="btn btn-success" value="Add to Cart">
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
    <script>
      $(function() {
        // jquery implement here
        var INDEX = 0;
        initMessage();
        $("#chat-submit").click(function(e) {
          e.preventDefault();
          var msg = $("#chat-input").val();
          if (msg.trim() == '') {
            return false;
          }
          generate_message(msg, 'self');
          var buttons = [{
              name: 'Existing User',
              value: 'existing'
            },
            {
              name: 'New User',
              value: 'new'
            }
          ];
          setTimeout(function() {
            generate_message(msg, 'user');
          }, 1000)

        })

        function initMessage() {
          INDEX++;
          var str = "";
          str += "<div id='cm-msg-" + INDEX + "' class=\"chat-msg " + "self" + "\">";
          str += "          <span class=\"msg-avatar\">";
          str += "            <img src=https://cdn-icons-png.flaticon.com/512/1920/1920994.png>";
          
          str += "          <\/span>";
          str += "          <div class=\"cm-msg-text\">";

          str += "Are you having trouble? Let me help you. Choose your questions below <br> 1.How to use the recommend me function <br> 2. Is the map accurate? <br> 3. Is cash on delivery available or only online payment? <br> 4. Is the BMI calculator accurate? ";
          str += "          <\/div>";
          str += "        <\/div>";
          $(".chat-logs").append(str);
          $("#cm-msg-" + INDEX).hide().fadeIn(300);
          $("#chat-input").val('');
          $(".chat-logs").stop().animate({
            scrollTop: $(".chat-logs")[0].scrollHeight
          }, 1000);
        }

        function generate_message(msg, type) {
          INDEX++;
          var str = "";
          str += "<div id='cm-msg-" + INDEX + "' class=\"chat-msg " + type + "\">";
          str += "          <span class=\"msg-avatar\">";
          if (type == 'self') {
            str += "            <img src=https://cdn-icons-png.flaticon.com/512/1946/1946429.png>";
          } else {
            str += "            <img src=https://cdn-icons-png.flaticon.com/512/1920/1920994.png>";
          }
          str += "          <\/span>";
          str += "          <div class=\"cm-msg-text\">";

          // hardcoded msg
          if (type == 'user') {
            if (msg.includes("1")) {
              str += 'First you have to calculate your BMI and choose your body type, goal and exercise.';
            } else if (msg.includes("2")) {
              str += 'Yes! The map is Google Map so everything is accurate'
            } else if (msg.includes("3")){
              str += 'Yes. Cash on delivery is available as well as online payment.';
            }
            else if (msg.includes("4")){
              str += "Yes. We use the same equation of all other BMI calculator.";
            }
            else {
              str += "I do not understand your query, please try again";
            }
            str += "<br><br> Need to add one more chat after the chat box answer question. Is there any other questions? Please ask us <br><br>  1.How to use the recommend me function <br> 2. Is the map accurate? <br> 3. Is cash on delivery available or only online payment? <br> 4. Is the BMI calculator accurate? ";
            
          } else {
            str += msg;
          }

          str += "          <\/div>";
          str += "        <\/div>";
          $(".chat-logs").append(str);
          $("#cm-msg-" + INDEX).hide().fadeIn(300);
          if (type == 'self') {
            $("#chat-input").val('');
          }
          $(".chat-logs").stop().animate({
            scrollTop: $(".chat-logs")[0].scrollHeight
          }, 1000);
        }

        function generate_button_message(msg, buttons) {
          /* Buttons should be object array 
            [
              {
                name: 'Existing User',
                value: 'existing'
              },
              {
                name: 'New User',
                value: 'new'
              }
            ]
          */
          INDEX++;
          var btn_obj = buttons.map(function(button) {
            return "              <li class=\"button\"><a href=\"javascript:;\" class=\"btn btn-primary chat-btn\" chat-value=\"" + button.value + "\">" + button.name + "<\/a><\/li>";
          }).join('');
          var str = "";
          str += "<div id='cm-msg-" + INDEX + "' class=\"chat-msg user\">";
          str += "          <span class=\"msg-avatar\">";
          str += "            <img src=https://www.iconpacks.net/icons/2/free-user-icon-3296-thumb.png";
          str += "          <\/span>";
          str += "          <div class=\"cm-msg-text\">";
          str += msg;
          str += "          <\/div>";
          str += "          <div class=\"cm-msg-button\">";
          str += "            <ul>";
          str += btn_obj;
          str += "            <\/ul>";
          str += "          <\/div>";
          str += "        <\/div>";
          $(".chat-logs").append(str);
          $("#cm-msg-" + INDEX).hide().fadeIn(300);
          $(".chat-logs").stop().animate({
            scrollTop: $(".chat-logs")[0].scrollHeight
          }, 1000);
          $("#chat-input").attr("disabled", true);
        }

        $(document).delegate(".chat-btn", "click", function() {
          var value = $(this).attr("chat-value");
          var name = $(this).html();
          $("#chat-input").attr("disabled", false);
          generate_message(name, 'self');
        })

        $("#chat-circle").click(function() {
          $("#chat-circle").toggle('scale');
          $(".chat-box").toggle('scale');
        })

        $(".chat-box-toggle").click(function() {
          $("#chat-circle").toggle('scale');
          $(".chat-box").toggle('scale');
        })

      })
    </script>
</body>
<!--
  <footer class="container-fluid bg-4 text-center">
  <br>
  <p> Muscle Fitness 2022 | &copy All Rights Reserved </p>
  <br>
  </footer>
-->

</html>