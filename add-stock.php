<!DOCTYPE HTML>
<html>

<head>
    <title>Incoming Items</title>
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
            <li class="active"><a href="#">Items In</a></li>
            <li><a href="item-out.php"">Items Out</a></li>
            <li><a href="product-details.php"">Product Details</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="pagetitle">
        <h2 class="text-justify">Incoming Items<br><small>Add product stock by Item ID (or scan item barcode) or item name and packaging and specify the amount.</small></h2>
    </div>

    <ul class="nav nav-tabs searchtab">
        <li class="active"><a data-toggle="tab" href="#searchbyid">Item ID</a></li>
        <li><a data-toggle="tab" href="#searchbyname">Name</a></li>
    </ul>

    <div class="tab-content">
        <div id="searchbyid" class="tab-pane fade in active">
            <h3>Add by Item ID</h3>
            <p class="text-justify">Type in Item ID or scan the barcode and click search. Specify stock amount then click submit.</p>

            <?php
            // define variables and set to empty values
            $idsearchErr = $stockaddedErr = "";
            $idsearch = $stockadded = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($_POST["idsearch"] != "") {
                    $idsearch = test_input($_POST["idsearch"]);
                }
                else {
                    $idsearchErr = "Item ID is required";
                }

                if (!empty($_POST["stockadded"])) {
                    $stockadded = test_input($_POST["stockadded"]);
                    if (!preg_match("/^[1-9][0-9]{0,9}$/", $stockadded)) {
                        $stockaddedErr = "Invalid format (only numbers greater than 0 allowed, maximum length 5 digits)";
                    }
                }
                else {
                    $stockaddedErr = "Stock amount is required";
                }
            }

            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
            ?>

            <form class="form stock-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="form-group">
                    <label class="control-label" for="idsearch">Item ID</label>
                    <input type="text" name="idsearch" class="form-control" value="<?php echo $idsearch;?>" placeholder="XXXX-0000-00">
                    <span class="error"><?php echo $idsearchErr;?></span>
                </div>
                <div class="form-group">
                    <label class="control-label" for="stockadded">Added Amount</label>
                    <input type="text" name="stockadded" class="form-control" value="<?php echo $stockadded;?>" placeholder="e.g. 100">
                    <span class="error"><?php echo $stockaddedErr;?></span>
                </div>
                <input class="btn btn-primary" type="submit" name="submit" value="Submit">
            </form>

            <?php
            require 'dbconnect.php';

            $sql = "SELECT itemid, name, package, price, stock FROM itemlist WHERE itemid = '" . $idsearch . "'";
            $result = mysqli_query($conn, $sql);

            if ($idsearch != "" && $stockadded !="") {
                if (mysqli_num_rows($result) == 1) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $totalstock = $row['stock'] + $stockadded;
                        $sql = "UPDATE itemlist SET stock = " . $totalstock . " WHERE itemid = '" . $idsearch . "'";
                        
                        if (mysqli_query($conn, $sql)) {
                            echo "<div class=\"alert alert-success\" style=\"width:100%;\"><strong>Success!</strong> Item stock database is successfully updated.</p></div>";
                            echo "<div class=\"info-table\" style=\"margin:auto;width:75%;\">";
                            echo "<table class=\"table\">";
                            echo "<tr><td><b>Item ID<b></td><td>". $row['itemid'] . "</td></tr>";
                            echo "<tr><td><b>Item Name<b></td><td>". $row['name'] . "</td></tr>";
                            echo "<tr><td><b>Package<b></td><td>" . $row['package'] . "</td></tr>";
                            echo "<tr><td><b>Price<b></td><td>" . $row['price'] . "</td></tr>";
                            echo "<tr><td><b>Current Stock<b></td><td>". $row['stock'] ."</td></tr>";
                            echo "<tr><td><b>Added Amount<b></td><td>". $stockadded ."</td></tr>";
                            echo "</table>";
                            echo "</div>";
                        }
                        else {
                            echo "<div class=\"alert alert-danger\" style=\"width:100%;\"><strong>Database Error:</strong> ". mysqli_error($conn);
                        }
                    }
                }
                else {
                    echo "<div class=\"alert alert-danger\" style=\"width:100%;\"><strong>Database Error:</strong> Item ID <i>" . $idsearch . "</i> does not exist.</p></div>";
                }
            }
            ?>

        </div>

        <div id="searchbyname" class="tab-pane fade">
            <h3>Add by Name</h3>
            <p class="text-justify">Input product name and packaging then click search. Specify stock amount then click submit.</p>
        </div>
    </div>

</div>

<?php include 'footer.php';?>
</body>

</html>