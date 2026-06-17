<!DOCTYPE html>
<html>
<head>
    <title>My PHP Test</title>
</head>
<body>

<h1>
<?php
echo "Testing PHP";
?>
</h1>

<p>
<?php
$name = "Ivan";
$game = "Saints Row 3";
$age = "21";

echo "Hello " . $name . "<br>";
echo "Current game: " . $game . "<br>";
echo "Your age: " . $age;
?>
</p>

</body>
</html>