<?php
session_start();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">

<a class="navbar-brand" href="index.php">GameHub</a>

<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
<span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarNav">

<ul class="navbar-nav me-auto">
<li class="nav-item">
<a class="nav-link" href="index.php">Home</a>
</li>
</ul>

<ul class="navbar-nav">

<?php if(isset($_SESSION['user'])){ ?>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
Account
</a>

<ul class="dropdown-menu dropdown-menu-dark">
<li><a class="dropdown-item" href="dashboard.php">Dashboard</a></li>
<li><a class="dropdown-item" href="logout.php">Logout</a></li>
</ul>
</li>
<?php } else { ?>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
Account
</a>

<ul class="dropdown-menu dropdown-menu-dark">
<li><a class="dropdown-item" href="login.php">Login</a></li>
<li><a class="dropdown-item" href="register.php">Register</a></li>
</ul>
</li>
<?php } ?>

</ul>

<!-- 🔥 SEARCH WITH AUTOCOMPLETE -->
<form class="d-flex ms-3 position-relative" onsubmit="return false;">

<input 
class="form-control me-2" 
type="search" 
id="search" 
placeholder="Search games..."
autocomplete="off"
>

<div id="suggestions" style="
position:absolute;
top:40px;
left:0;
width:100%;
background:white;
color:black;
z-index:999;
border-radius:5px;
"></div>

<button class="btn btn-success" id="searchBtn">Search</button>

</form>

</div>
</div>
</nav>