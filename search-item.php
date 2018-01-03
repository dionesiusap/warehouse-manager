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
        </ul>
    </div>
</nav>

<div class="container">
    <div class="pagetitle">
        <h2 class="text-justify">Search Item<br><small>Type in Item ID or Item Name then click Search.</small></h2>
    </div>

    <?php
    // define variables and set to empty values
    $itemidErr = $nameErr = "";
    $itemid = $name = "";
    $where = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["itemid"])) {
            $itemid = test_input($_POST["itemid"]);
            $where = "WHERE itemid = '" . $itemid . "'";
        }

        if (!empty($_POST["name"])) {
            $name = test_input($_POST["name"]);
            if (!empty($_POST["itemid"])) {
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

    <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="form-group">
            <label class="control-label col-sm-2" for="id">Item ID</label>
            <div class="col-sm-10">
                <input type="text" name="itemid" class="form-control" value="<?php echo $itemid;?>" placeholder="XXXX-0000-00">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Name</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" value="<?php echo $name;?>" placeholder="Item name">
            </div>
        </div>
        <input class="btn btn-primary" type="submit" name="submit" value="Submit">
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
    echo "<th>Item ID</th><th>Item Name</th><th>Packaging</th><th>Price</th><th>Stock</th>";
    echo "</tr>";
    echo "</thead>";
    if (mysqli_num_rows($result) != 0) {
        echo "<tbody>";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" .$row['itemid']. "</td><td>" .$row['name']. "</td><td>" .$row['package']. "</td><td>" .$row['price']. "</td><td>" .$row['stock']. "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
    }
    else {
        echo "</table>";
        echo "</div>";
        echo "Not found";
    }
    ?>

</div>

<?php include 'footer.php';?>
</body>

</html>