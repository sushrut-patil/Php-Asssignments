<!DOCTYPE html>
<html>

<head>
    <title>Simple Calculator Program in PHP</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="calculator">
        <form method="get" action="">
            <h1>Calculator</h1>
            <table>
                <tr>
                    <td><label for="Operand1">First Number</label></td>
                    <td><input id="Operand1" name="Operand1" type="number" step="any" class="form-control"
                            value="<?php echo $Operand1; ?>" required></td>
                </tr>
                <tr>
                    <td><label for="Operand2">Second Number</label></td>
                    <td><input id="Operand2" name="Operand2" type="number" step="any" class="form-control"
                            value="<?php echo $Operand2; ?>" required></td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>
                        <input type="submit" class="btn arithmetic-btn" name="Calculate" value="Add">
                    </td>
                    <td>
                        <input type="submit" class="btn arithmetic-btn" name="Calculate" value="Subtract">
                    </td>
                    <td>
                        <input type="submit" class="btn arithmetic-btn" name="Calculate" value="Multiply">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" class="btn arithmetic-btn" name="Calculate" value="Divide">
                    </td>
                    <td>
                        <input type="submit" class="btn arithmetic-btn" name="Calculate" value="Power">
                    </td>
                    <td>
                        <input type="submit" class="btn arithmetic-btn" name="Calculate" value="Modulus">
                    </td>
                </tr>
            </table>
            <br>
            Result: <input id="Result" type='text' name="Result" readonly><br>
    </div>
    </form>
    <form method="get" action="">
        <input type="submit" class="btn clear-btn" name="Clear" value="Clear">
    </form>
</body>
</html>

<?php

if (isset($_GET['Operand1'], $_GET['Operand2'], $_GET['Calculate'])) {
    $Operand1 = floatval($_GET['Operand1']);
    $Operand2 = floatval($_GET['Operand2']);
    $Operator = $_GET['Calculate'];
    $Result = "";

    if ($Operator == "Add")
        $Result = $Operand1 + $Operand2;
    elseif ($Operator == "Subtract")
        $Result = $Operand1 - $Operand2;
    elseif ($Operator == "Multiply")
        $Result = $Operand1 * $Operand2;
    elseif ($Operator == "Divide")
        if ($Operand2 == 0)
            $Result = "Cannot Divide by zero";
        else
            $Result = $Operand1 / $Operand2;
    elseif ($Operator == "Power")
        $Result = pow($Operand1, $Operand2);
    elseif ($Operator == "Modulus")
        if ($Operand2 == 0)
            $Result = "Cannot Divide by zero";
        else
            $Result = $Operand1 % $Operand2;

    echo "<script>document.getElementById('Operand1').value = '$Operand1';</script>";
    echo "<script>document.getElementById('Operand2').value = '$Operand2';</script>";
    echo "<script>document.getElementById('Result').value = '$Result';</script>";

}
if (isset($GET['Clear'])) {
    echo "<script>document.getElementById('Result').value = '';</script>";
    echo "<script>document.getElementById('Operand1').value = '';</script>";
    echo "<script>document.getElementById('Operand2').value = '';</script>";
}
?>