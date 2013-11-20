<?php session_start(); ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
  <link rel="stylesheet" href="Resources/css/bootstrap.css">
  <link rel="stylesheet" href="Resources/css/styles.css">
  <script src="Resources/js/jquery.js"></script>
  <title>Shell Systems</title>
</head>
<body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <a href="index.php" class="navbar-brand" id="startPage">SHELL SYSTEMS</a>
        <a href="table.php" class="navbar-brand" id="nodesPage">Active Nodes</a>
        <a href="table.php" class="navbar-brand" id="userPage">User Profile</a>
      </div>
      <div class="navbar-collapse collapse navbar-right" id="loginNav">
        <a href= "user.php" class="navbar-brand navbar-col" id="loggedUser">Welcome, <?php echo $_SESSION['usuario']; ?>!</a>
        <a href="index.php?action=destroy" class="navbar-brand navbar-col">Sign out</a>
      </div>
    </div>
  </nav>
  <section id="userInfo">
    <form action="">
      <input type="submit">
    </form>
  </section>
  <footer class="navbar navbar-inverse navbar-bottom">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand navbar-col" href="#">Shell Systems® 2013</a>
      </div>
    </div>
  </footer>
  <script> $('#userPage').css({ color: '#FFFFFF', background: '#383838' }); </script>
</body>
</html>