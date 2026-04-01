<?php
include "config.php";

if(isset($_POST['search'])){

$search = $_POST['search'];
$like = "%".$search."%";

// 🔥 RESULTS (cards)
$stmt = $conn->prepare("SELECT * FROM games WHERE name LIKE ? OR genre LIKE ?");
$stmt->bind_param("ss", $like, $like);
$stmt->execute();
$result = $stmt->get_result();

while($row = $result->fetch_assoc()){
?>
<div class="col-md-4 d-flex">
<div class="card w-100 shadow">

<img src="images/<?php echo $row['image']; ?>" 
class="card-img-top" 
style="height:200px; object-fit:cover;">

<div class="card-body">
<h5><?php echo $row['name']; ?></h5>
<p>Genre: <?php echo $row['genre']; ?></p>

<a href="game.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">
View
</a>

</div>

</div>
</div>
<?php
}

// 🔥 SUGGESTIONS (top 5)
$stmt2 = $conn->prepare("SELECT name FROM games WHERE name LIKE ? LIMIT 5");
$stmt2->bind_param("s", $like);
$stmt2->execute();
$suggestions = $stmt2->get_result();

echo "<div class='suggest-box'>";
while($row = $suggestions->fetch_assoc()){
    echo "<div class='suggest-item p-2' style='cursor:pointer;'>".$row['name']."</div>";
}
echo "</div>";

}
?>