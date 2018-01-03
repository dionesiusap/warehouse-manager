<!DOCTYPE HTML>
<html>

<head>
    <title>Product Details</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="add-stock.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" style="padding:5px" href="#"><img style="height:100%;width:auto;" src="img/logo.png"></a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="search-item.php">Home</a></li>
            <li><a href="new-item.php">New Item</a></li>
            <li><a href="add-stock.php">Items In</a></li>
            <li><a href="item-out.php"">Items Out</a></li>
            <li class="active"><a href="#"">Product Details</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="pagetitle">
        <h2 class="text-justify">Product Details<br><small>Look for details of a product by Product ID or Name.</small></h2>
    </div>

    <?php
    // define variables and set to empty values
    // $itemidErr = "";
    $itemid = "";
    $where = "";

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (!empty($_GET["itemid"])) {
            $itemid = test_input($_GET["itemid"]);
            $where = "WHERE itemid = '" . $itemid . "'";
        }
        // else {
        //     $itemidErr = "Item ID required";
        // }
    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    ?>

    <form class="form" method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
            <label class="control-label" for="id">Item ID</label>
            <input type="text" name="itemid" class="form-control" value="<?php echo $itemid;?>" placeholder="XXXX-0000-00">
            <!-- <span class="error"><?php echo $itemidErr;?></span> -->
        </div>
        <input class="btn btn-primary" type="submit" name="search" value="Search">
    </form>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test-item";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT name, package, price FROM itemlist " . $where;
    $result = mysqli_query($conn, $sql);

    if ($itemid != "") {
        if (mysqli_num_rows($result) == 1) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class=\"info-table\">";
                echo "<h3><strong>" . $row['name'] . "</strong></h3>";
                echo "<table class=\"table\">";
                echo "<tr><td colspan=\"2\">";
                echo "<p style=\"text-align:center;\"><img src='https://barcode.tec-it.com/barcode.ashx?translate-esc=off&data=" . $itemid . "&code=Code128&multiplebarcodes=false&unit=Fit&dpi=96&imageype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0' alt='Barcode Generator TEC-IT'/></p></td></tr>";
                echo "<tr><td><b>Item ID<b></td><td>". $itemid . "</td></tr>";
                echo "<tr><td><b>Package<b></td><td>" . $row['package'] . "</td></tr>";
                echo "<tr><td><b>Price<b></td><td>" . $row['price'] . "</td></tr>";
                echo "</table>";
                echo "</div>";
            }
        }
        else {
            echo "<div class=\"alert alert-danger\"><strong>Item not found.</strong> Item with ID " . $itemid . " does not exist in database.</p></div>";
        }
    }
    ?>

</div>

<?php include 'footer.php';?>
</body>

</html>