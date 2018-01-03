<!DOCTYPE HTML>
<html>

<head>
    <title>New Item</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<body>

<?php
// define variables and set to empty values
$itemidErr = $nameErr = $pkgErr = $unitErr = $priceErr = $stockErr = "";
$itemid = $name = $pkg = $unit = $price = $packaging = $stock = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["itemid"])) {
        $itemidErr = "ID is required";
    } else {
        $itemid = test_input($_POST["itemid"]);
    }

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
    }

    if (empty($_POST["pkg"])) {
        $pkgErr = "Packaging quantity is required";
    } else {
        $pkg = test_input($_POST["pkg"]);
        // check if e-mail address is well-formed
        if (!preg_match("/^[1-9][0-9]{0,4}$/", $pkg)) {
            $pkgErr = "Invalid format (only numbers allowed, maximum length 5 digits)";
        }
    }

    if (empty($_POST["unit"])) {
        $unitErr = "Packaging unit is required";
    } else {
        $unit = test_input($_POST["unit"]);
    }

    if ($pkgErr == "" && $unitErr == "") {
        $packaging = $pkg . " " . $unit;
    }

    if (empty($_POST["price"])) {
        $priceErr = "Price is required";
    } else {
        $price = test_input($_POST["price"]);
        // check if e-mail address is well-formed
        if (!preg_match("/^[1-9][0-9]{0,9}$/", $price)) {
            $priceErr = "Invalid format (only numbers allowed, maximum length 10 digits)";
        }
    }

    if (empty($_POST["stock"])) {
        $stockErr = "Stock amount is required";
    } else {
        $stock = test_input($_POST["stock"]);
        // check if e-mail address is well-formed
        if (!preg_match("/^[0-9]{1,5}$/", $stock)) {
            $stockErr = "Invalid format (only numbers allowed, maximum length 5 digits)";
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

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" style="padding:5px" href="#"><img style="height:100%;width:auto;" src="img/logo.png"></a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="search-item.php">Home</a></li>
            <li class="active"><a href="#">New Item</a></li>
            <li><a href="add-stock.php">Items In</a></li>
            <li><a href="item-out.php">Items Out</a></li>
            <li><a href="product-details.php"">Product Details</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="pagetitle">
        <h2 class="text-justify">New Item<br><small>This is a form for new product entry. Barcode for Item ID will be automatically generated. To add stock, go to add stock page and scan the barcode.</small></h2>
    </div>
    <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <p class="error">* required field.</p>
        <div class="form-group">
            <label class="control-label col-sm-2" for="id">Item ID<span class="error">*</span></label>
            <div class="col-sm-10">
                <input type="text" name="itemid" class="form-control" value="<?php echo $itemid;?>" placeholder="XXXX-0000-00">
                <span class="error"><?php echo $itemidErr;?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Name<span class="error">*</span></label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" value="<?php echo $name;?>" placeholder="Item name">
                <span class="error"><?php echo $nameErr;?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="pkg">Package<span class="error">*</span></label>
            <div class="col-sm-7">
                <input type="text" name="pkg" class="form-control" value="<?php echo $pkg;?>" placeholder="Nett/pack (e.g. 100 gr)">
                <span class="error"><?php echo $pkgErr;?></span>
            </div>
            <div class="col-sm-3">
            <select class="form-control" name="unit">
                <option <?php if (isset($unit) && $unit=="") echo "selected"; ?> value="">- Select -</option>
                <option <?php if (isset($unit) && $unit=="pcs") echo "selected"; ?> value="pcs">pcs</option>
                <option <?php if (isset($unit) && $unit=="gr") echo "selected"; ?> value="gr">gr</option>
                <option <?php if (isset($unit) && $unit=="ml") echo "selected"; ?> value="ml">ml</option>
                <option <?php if (isset($unit) && $unit=="tablets") echo "selected"; ?> value="tablets">tablets</option>
                <option <?php if (isset($unit) && $unit=="capsules") echo "selected"; ?> value="capsules">capsules</option>
            </select>
            <span class="error"><?php echo $unitErr;?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="price">Price<span class="error">*</span></label>
            <div class="col-sm-10">
                <input type="text" name="price" class="form-control" value="<?php echo $price;?>" placeholder="Item price (e.g. 50000)">
                <span class="error"><?php echo $priceErr;?></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="stock">Stock<span class="error">*</span></label>
            <div class="col-sm-10">
                <input type="text" name="stock" class="form-control" value="<?php echo $stock;?>" placeholder="Product quantity">
                <span class="error"><?php echo $stockErr;?></span>
            </div>
        </div>
        <input class="btn btn-primary" type="submit" name="submit" value="Submit">
    </form>

    <?php
    if ($itemidErr == "" && $nameErr == "" && $pkgErr == "" && $unitErr == "" && $priceErr == "" && $stockErr == "") {
        if ($itemid != "" && $name != "" && $pkg != "" && $unit != "" && $price != "" && $stock != "") {


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

            $sql = "INSERT INTO itemlist (itemid, name, price, package, stock)
            VALUES ('" . $itemid . "', '" . $name . "', " . $price . ", '" . $packaging . "', " . $stock . ")";

            if (mysqli_query($conn, $sql)) {
                echo "<div class=\"alert alert-success\"><strong>Input success!</strong> Item has been successfully added into database.</div>";
                if ($itemid == "") {
                    echo $itemid;
                }
                else {
                    echo "<div class=\"info-table\">";
                    echo "<table class=\"table\">";
                    echo "<tr><td colspan=\"2\">";
                    echo "<p style=\"text-align:center;\"><img src='https://barcode.tec-it.com/barcode.ashx?translate-esc=off&data=" . $itemid . "&code=Code128&multiplebarcodes=false&unit=Fit&dpi=96&imageype=Gif&rotation=0&color=%23000000&bgcolor=%23ffffff&qunit=Mm&quiet=0' alt='Barcode Generator TEC-IT'/></p></td></tr>";
                    echo "<tr><td><b>Item Name<b></td><td>". $name . "</td></tr>";
                    echo "<tr><td><b>Package<b></td><td>" . $packaging . "</td></tr>";
                    echo "<tr><td><b>Price<b></td><td>" . $price . "</td></tr>";
                    echo "<tr><td><b>Stock<b></td><td>" . $stock . "</td></tr>";
                    echo "</table>";
                    echo "</div>";
                }
            }
            else {
                echo "<div class=\"alert alert-danger\"><strong>Database Error:</strong> There might be a duplicate in Item ID.</p></div>";
            }
            mysqli_close($conn);
        }
    }
    else {
        echo "<div class=\"alert alert-danger\"><strong>Invalid input.</strong> Please check your input and try again.</p></div>";
    }
    ?>
</div>

<?php include 'footer.php';?>
</body>

</html>