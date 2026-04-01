<?php
include "config.php";
include "navbar.php";

$id = $_GET['id'];

$sql = "SELECT * FROM games WHERE id=$id";
$result = $conn->query($sql);

$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>

<title><?php echo $row['name']; ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container mt-5">

<div class="card shadow">

<img src="images/<?php echo $row['image']; ?>" class="card-img-top">

<div class="card-body">

<h2><?php echo $row['name']; ?></h2>

<p><strong>Genre:</strong> <?php echo $row['genre']; ?></p>

<p><?php echo $row['description']; ?></p>

<a href="index.php" class="btn btn-secondary">Back</a>

</div>

</div>

</div>

</body>

</html>