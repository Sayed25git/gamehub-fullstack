<?php include "navbar.php"; ?>
<?php include "config.php"; ?>

<!DOCTYPE html>
<html>

<head>
<title>Game Library</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container mt-5">

<h1 class="text-center mb-4">Game Library</h1>

<!-- GAME LIST -->
<div class="row g-4 justify-content-center" id="result">

<?php
// show all games initially
$sql = "SELECT * FROM games";
$result = $conn->query($sql);

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

<?php } ?>

</div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

// 🔥 LIVE SEARCH + AUTOCOMPLETE
$("#search").keyup(function(){

    var value = $(this).val();

    if(value != ""){

        $.post("search.php", {search: value}, function(data){

            // Split results + suggestions
            var split = data.split("<div class='suggest-box'>");

            $("#result").html(split[0]); // cards
            $("#suggestions").html("<div class='suggest-box'>" + (split[1] || ""));

        });

    } else {
        location.reload();
    }
});

// CLICK SUGGESTION
$(document).on("click", ".suggest-item", function(){
    $("#search").val($(this).text());
    $("#suggestions").html("");
});

// SEARCH BUTTON
$("#searchBtn").click(function(){

    var value = $("#search").val();

    $.post("search.php", {search: value}, function(data){
        $("#result").html(data);
        $("#suggestions").html("");
    });

});

</script>

</script>

</body>
</html>