<?php 
$billErr = $percentErr = $custom_tipErr = $splitErr= "";
$bill = $percent = $custom_tip = $send = "";
$split = 1;

if (empty($_POST["bill"])) {
    $billErr = "Please enter bill";
} else {
    $bill = test_input($_POST["bill"]);
}

if (empty($_POST["custom_tip"])) {
    $custom_tipErr = "Please enter tip percentage";
} else {
    $custom_tip = test_input($_POST["custom_tip"]);
}

if (empty($_POST["percent"])) {
    $percentErr = "Please select a percentage";
} else {
    $percent = test_input($_POST["percent"]);
}

if (empty($_POST["split"])) {
    $splitErr = "Please enter the number of people splitting the check";
} else {
    $split = test_input($_POST["split"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<!DOCTYPE html>
<html>
<head>
<style>
h2 {
    text-align: center;
}
div {
    border-radius: 25px;
    background-color: lightgrey;
    width: 300px;
    border: 5px solid green;
    padding: 25px;
    margin: 25px;
}

.warning {
    font-weight: bold;
    color: #ff0000;
}

input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
input[type=submit]:hover {
    background-color: #45a049;
}

</style>
</head>
    
<div>  
<body>
<h2>Tip Calculator</h2>
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
Bill Subtotal: $
<input type="number" name="bill" min="0.01" step="any" style="width:50px;" value="<?php 
    echo isset($_POST['bill']) ? $_POST['bill'] : '' ?>" /> 
<span class="warning">*
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($bill)) {
    echo $billErr;
}
?>
</span> <br>
Tip Percentage: 
<span class="warning">*
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST" && empty($custom_tip) && $percent == "custom") {
    echo $custom_tipErr;
}
?>
</span> <br>
<?php
for ($i = 10; $i <= 20; $i=$i+5) {
?>
<input type="radio" name="percent" value="<?php echo $i; ?>"> <?php echo $i . "%" ?><br>
<?php
}
?>
<input type="radio" name="percent" value="custom" id="percentCustom">Custom: 
<input type="number" name="custom tip" min="0.01" step="any" style="width:50px;"> <br>
<?php 
    if(isset($percent) && $percent == "custom") {
        $percent = $custom_tip;
        if (empty($custom_tip)) {
            $percent = '0';
        }
    }
?>
Split: <input type="number" name="split" value="1" style="width:50px;"> person(s) <br>
<input type="submit" name="send" id="send" value="Submit">
</form>
<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($bill)) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo "<h3>Get Your Wallet Out!</h3>";
        echo "For a bill of $ $bill: <br>";
        $tip = round($bill * ($percent * 0.01), 2);
        echo "Tip $" . $tip . "<br>";
        echo "Total: $" . round(($tip + $bill),2) . "<br> </br>";
        if ($split > 1) {
            echo "Splitting this bill $split ways: <br>";
            echo "Each Tip: $" . round($tip/$split, 2) . "<br>";
            echo "Each Total: $" . round(($tip + $bill)/$split, 2) . "<br>";
        }
    }
}
?>


</body>
</div>
</html>
