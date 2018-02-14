<?php
session_start();

require_once 'dbconfig.php';
require_once 'class.user.php';
$user_login = new USER();
$conn = mysqli_connect("localhost", "root", "kimatia7950", "palm");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Palm</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">


    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Palm</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
              <li>
                      <?php if($user_login->is_logged_in()!="")
                              {
                                $stmt = $user_login->runQuery("SELECT * FROM tbl_users WHERE userID=:uid");
                                $stmt->execute(array(":uid"=>$_SESSION['userSession']));
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                      ?>
                      <a class="page-scroll" href="login.php"><span class="fa fa-user"></span><?php echo $row['userName']?></a>
                      <?php
                            } else {
                       ?>
                       <a href="login.php"><span class="fa fa-user"></span> Login</a>
                       <?php
                            }
                        ?>
                    </li>
            </ul>
            <!-- /.navbar-top-links -->
        </nav>

    <br>
    <div class="row" style="background-color: cream">
      <div class="col-md-10 col-md-offset-1">
       <br>
       <center><h3>Welcome to Palm</h3></center>
       <br>
      </div>
    </div>

</div>



    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <script>
    function mySearch() {

      // Declare variables
      var input, filter, table, tr, td, i;
      input = document.getElementById("forms");
      filter = input.value.toUpperCase();
      table = document.getElementById("formsTable");
      tr = table.getElementsByTagName("tr");
      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }
      }
    }
    </script>
</body>

</html>
