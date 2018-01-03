<!DOCTYPE HTML>
<html>

<head>
    <title>Search Item</title>
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
            <li class="active"><a href="#">Home</a></li>
            <li><a href="new-item.php">New Item</a></li>
            <li><a href="add-stock.php">Items In</a></li>
            <li><a href="item-out.php"">Items Out</a></li>
            <li><a href="product-details.php"">Product Details</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="pagetitle">
        <h2 class="text-justify">Search Item<br><small>Search products either by Item ID or item name then click Search.</small></h2>
    </div>

    <?php
    // define variables and set to empty values
    $itemidErr = $nameErr = "";
    $itemid = $name = "";
    $where = "";

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (!empty($_GET["itemid"])) {
            $itemid = test_input($_GET["itemid"]);
            $where = "WHERE itemid = '" . $itemid . "'";
        }

        if (!empty($_GET["name"])) {
            $name = test_input($_GET["name"]);
            if (!empty($_GET["itemid"])) {
                $where .= " AND UPPER(name) LIKE UPPER('%" . $name . "%')";
            }
            else {
                $where = "WHERE UPPER(name) LIKE UPPER('%" . $name . "%')";
            }
        }
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
        </div>
        <div class="form-group">
            <label class="control-label" for="name">Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo $name;?>" placeholder="Item name">
        </div>
        <input class="btn btn-primary" type="submit" name="search" value="Search">
        <a href="search-item.php" class="btn btn-default" role="button">Clear</a>
    </form>

    <?php
    require 'dbconnect.php';

    if ($itemid == "" && $name == "") {
        $sql = "SELECT * FROM itemlist ORDER BY itemid";
    }
    else {
        $sql = "SELECT * FROM itemlist " . $where;
    }

    $result = mysqli_query($conn, $sql);

    echo "<div class=\"info-table\" style=\"margin:auto;width:65%;\">";
    echo "<table class=\"table table-hover\">";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Item ID</th><th>Item Name</th><th>Packaging</th><th>Price</th><th>Stock</th><th>Details</th>";
    echo "</tr>";
    echo "</thead>";
    if (mysqli_num_rows($result) != 0) {
        echo "<tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" .$row['itemid']. "</td><td>" .$row['name']. "</td><td>" .$row['package']. "</td><td>" .$row['price']. "</td><td>" .$row['stock']. "</td><td><a href=\"product-details.php?itemid=" .$row['itemid']. "&search=Search\" target=\"_blank\" class=\"btn btn-info btn-xs\" role=\"button\">Details</a></td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }
    else {
        echo "</table>";
        echo "</div>";
        echo "<div class=\"alert alert-danger\"><strong>Item not found.</strong> Try another search term.</p></div>";
    }
    ?>

</div>

<?php include 'footer.php';?>
</body>

</html>