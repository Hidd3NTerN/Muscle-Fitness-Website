<?php

class Data
{
  public $price;
  public $sale;
  public $percentage;

  public function __construct($price, $sale, $percentage)
  {
    $this->price = $price;
    $this->sale = $sale;
    $this->percentage = $percentage;
  }
}
$graphData = array();
include('session_m.php');

if (!isset($login_session)) {
  header('Location: managerlogin.php'); // Redirecting To Home Page
}

$sql = "SELECT COUNT(*) as total from orders";
$result = mysqli_query($conn, $sql);
// die($conn->error);
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    $total_sales = $row['total'];
  }
}

$sql = "SELECT productname, COUNT(*) as sales, SUM(price) as sum FROM `orders` group by F_ID";
$products = array();
$sales = array();
$sums = array();
$percentages = array();
$grandTotal = 0;
// array_push($sales, "0");
$result = mysqli_query($conn, $sql);
// die($conn->error);
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_assoc($result)) {
    // array_push($graphData, new Data());
    array_push($products, $row['productname']);
    array_push($sales, $row['sales']);
    array_push($sums, $row['sum']);
    $value = round(($row['sales'] / $total_sales) * 100, 2);
    array_push($percentages, $value);
    $grandTotal += $row['sum'];
  }
}

// var_dump($products);
?>


<!DOCTYPE html>
<html>

<head>
  <title> Admin Login | Muscle Fitness </title>
</head>

<link rel="stylesheet" type="text/css" href="css/analytics.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>

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

        <ul class="nav navbar-nav navbar-right">
          <li><a href="#"><span class="glyphicon glyphicon-user"></span> Welcome <?php echo $login_session; ?> </a></li>
          <li class="active"> <a href="managerlogin.php">MANAGER CONTROL PANEL</a></li>
          <li><a href="admin_product.php">Product Zone</a></li>
          <li><a href="logout_m.php"><span class="glyphicon glyphicon-log-out"></span> Log Out </a></li>
        </ul>
      </div>

    </div>
  </nav>

  <div class="container">
    <div class="jumbotron">
      <h1>Hello Admin! </h1>
      <p>Manage all your gym from here</p>

    </div>
  </div>

  <div class="container">
    <div class="container">
      <div class="col">
      </div>
    </div>


    <div class="col-xs-3" style="text-align: center;">

      <div class="list-group">
        <!-- <a href="analytics.php" class="list-group-item ">My Gym</a> -->
        <a href="view_product_items.php" class="list-group-item">View Product Items</a>
        <a href="add_product_items.php" class="list-group-item ">Add Product Items</a>
        <a href="edit_product_items.php" class="list-group-item ">Edit Product Items</a>
        <a href="delete_product_items.php" class="list-group-item ">Delete Product Items</a>
        <a href="view_order_details.php" class="list-group-item">View Order Details</a>
        <a href="analytics.php" class="list-group-item active">Analytics</a>
      </div>
    </div>

    <div class="col-xs-9">
      <div style="text-align:center; padding-right:20%">
        <h1>Total Sales RM: <?php echo round($grandTotal, 2) ?></h1>
        <canvas id="myChart" style="width:100%;max-width:700px"></canvas>
        <p>Bar Chart of Quantity items sold</p>
      </div>
      <hr>
      <div style="text-align: center; padding-right: 20%">
        <canvas id="myChart2" style="width:100%;max-width:700px"></canvas>
        <p>Pie Chart of Items Sold</p>
      </div>
    </div>
  </div>
  <br>
  <br>
  <br>
  <br>
  <footer class="container-fluid bg-4 text-center">
    <br>
    <p> Muscle Fitness 2022 | &copy All Rights Reserved </p>
    <br>
  </footer>
  <script>
    // Chart.defaults.global.legend.display = false;
    const footer = (tooltipItems) => {
      let sum = 0;

      tooltipItems.forEach(function(tooltipItem) {
        sum += tooltipItem.parsed.y;
      });
      return 'Sum: ' + sum;
    };
    var chartdata = {
      type: 'bar',
      data: {
        labels: <?php echo json_encode($products); ?>,
        datasets: [{
          label: '',
          backgroundColor: ["red", "blue", "green", "yellow", "black", "orange"],
          data: <?php echo json_encode($sales); ?>
        }]
      },
      "options": {
        "legend": {
          "display": false
        },
        "scales": {
          "yAxes": [{
            "ticks": {
              "autoSkip": false,
              "beginAtZero": true
            }
          }]
        }
      }
    };
    var ctx = document.getElementById('myChart').getContext('2d');
    new Chart(ctx, chartdata);

    // pie chart data
    var piechartdata = {
      type: 'pie',
      data: {
        labels: <?php echo json_encode($products); ?>,
        datasets: [{
          backgroundColor: ["red", "blue", "green", "yellow", "purple", "orange"],
          data: <?php echo json_encode($percentages); ?>
        }]
      },
      "options": {
        "legend": {
          "position": "top"
        },
        "scales": {
          "yAxes": [{
            "ticks": {
              "autoSkip": false,
              "beginAtZero": true
            }
          }]
        },
        tooltips: {
          callbacks: {
            title: function(tooltipItem, data) {
              // console.log("titlte" + data['labels'][tooltipItem[0]['index']]);
              return data['labels'][tooltipItem[0]['index']];
            },
            label: function(tooltipItem, data) {
              // console.log(data['datasets'][0]['data'][tooltipItem['index']]);
              return data['datasets'][0]['data'][tooltipItem['index']];
            },
            afterLabel: function(tooltipItem, data) {
              var dataset = data['datasets'][0];
              var percent = dataset['data'][tooltipItem['index']];
              var sale = Math.round(percent/100 * <?php echo $grandTotal ?>)
              // sale = sales[tooltipItem['index']];
              return '(RM ' + sale + ')';
            }
          }
        }
      }
    };

    var ctx2 = document.getElementById('myChart2').getContext('2d');
    new Chart(ctx2, piechartdata);
  </script>
</body>


</html>