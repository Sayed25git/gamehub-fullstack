<?php
include "config.php";
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit();
}

$message = "";
if(isset($_POST['add_game'])){
    $name = $_POST['name'];
    $genre = $_POST['genre'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    $newName = time()."_".$image;
    move_uploaded_file($tmp, "images/".$newName);

    $stmt = $conn->prepare("INSERT INTO games (name, genre, image) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $genre, $newName);
    $stmt->execute();

    header("Location: dashboard.php");
}
if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM games WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: dashboard.php");
}
$editData = null;
if(isset($_GET['edit'])){
    $id = $_GET['edit'];

    $stmt = $conn->prepare("SELECT * FROM games WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $editData = $stmt->get_result()->fetch_assoc();
}

if(isset($_POST['update_game'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $genre = $_POST['genre'];

    if(!empty($_FILES['image']['name'])){
        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];

        $newName = time()."_".$image;
        move_uploaded_file($tmp, "images/".$newName);

        $stmt = $conn->prepare("UPDATE games SET name=?, genre=?, image=? WHERE id=?");
        $stmt->bind_param("sssi", $name, $genre, $newName, $id);
    } else {
        $stmt = $conn->prepare("UPDATE games SET name=?, genre=? WHERE id=?");
        $stmt->bind_param("ssi", $name, $genre, $id);
    }

    $stmt->execute();
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="dashboard.css">

</head>

<body>

<div class="sidebar">
<h4><?php echo $_SESSION['user']; ?></h4>
<span class="badge bg-primary mb-3">Admin</span>

<a href="index.php"> Home</a>
<a href="dashboard.php">Dashboard</a>
<a href="#add">Add Game</a>
<a href="#list">Manage Games</a>
<a href="logout.php" class="text-danger">Logout</a>
</div>

<div class="main">

<h2>Admin Dashboard</h2>
<p>Welcome, <?php echo $_SESSION['user']; ?></p>
<div id="add" class="card-box mb-4">

<h4><?php echo $editData ? "Edit Game" : "Add Game"; ?></h4>

<form method="POST" enctype="multipart/form-data">

<input type="hidden" name="id" value="<?php echo $editData['id'] ?? ''; ?>">

<input type="text" name="name" class="form-control mb-2"
placeholder="Game Name"
value="<?php echo $editData['name'] ?? ''; ?>" required>

<input type="text" name="genre" class="form-control mb-2"
placeholder="Genre"
value="<?php echo $editData['genre'] ?? ''; ?>" required>

<input type="file" name="image" class="form-control mb-2">

<?php if($editData){ ?>
<img src="images/<?php echo $editData['image']; ?>" width="80">
<?php } ?>

<button class="btn btn-success mt-2">
<?php echo $editData ? "Update Game" : "Add Game"; ?>
</button>

<input type="hidden" name="<?php echo $editData ? 'update_game' : 'add_game'; ?>">

</form>

</div>
<div id="list" class="card-box">

<h4>All Games</h4>

<table class="table mt-3">

<tr>
<th>ID</th>
<th>Name</th>
<th>Genre</th>
<th>Image</th>
<th>Action</th>
</tr>

<?php
$result = $conn->query("SELECT * FROM games ORDER BY id DESC");

while($row = $result->fetch_assoc()){
?>

<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['genre']; ?></td>
<td><img src="images/<?php echo $row['image']; ?>" width="60"></td>
<td>
<a href="?edit=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
<a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"
onclick="return confirm('Delete this game?')">Delete</a>
</td>
</tr>

<?php } ?>

</table>

</div>

</div>

</body>
</html>