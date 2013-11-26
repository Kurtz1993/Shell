<?php session_start(); ?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico">
  <link rel="stylesheet" href="Resources/css/bootstrap.css">
  <link rel="stylesheet" href="Resources/css/styles.css">
  <script src="resources/js/jquery.js"></script>
  <script src="resources/js/functions.js"></script>
  <script src="resources/js/userScripts.js"></script>
  <script type="text/javascript"
      src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBSzrc6U_85i4yf8a41AfHpaCqF4K4kEAU&sensor=false">
    </script>
  <title>Shell Systems</title>
</head>
<body>
  <nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <a href="index.php" class="navbar-brand" id="startPage">SHELL SYSTEMS</a>
        <a href="nodes.php" class="navbar-brand" id="nodesPage">Active Nodes</a>
        <a href="user.php" class="navbar-brand" id="userPage">User Profile</a>
      </div>
      <div class="navbar-collapse collapse navbar-right" id="loginNav">
        <a href="index.php?action=logout" class="navbar-brand navbar-col">Sign out</a>
      </div>
    </div>
  </nav>
  <div id="userInfo">Edit your information</div>
  <input type="hidden" id="userID" value="<?php echo $_SESSION['id']; ?>">

  <!-- User Information -->
  <div class="userForm panel-success">
    <div class="userFormTitle">Basic Info</div>
      <form id="editUserInfo">
        <div id="user">
          <input id="corp" type="text" class="form-control"required placeholder="Corporation">
          <input id="phone" type="text" class="form-control"required placeholder="Phone Number" pattern="[0-9]*$" title="You must enter a valid phone number! (Just numbers)">
          <input id="email" type="email" class="form-control"required placeholder="E-mail">
        </div>
        <button class="btn btn-primary register" type="submit">Update Info</button>
      </form>
  </div>

  <!-- Password -->
  <div class="userForm panel-success">
    <div class="userFormTitle">Password</div>
    <form id="editUserPassword">
      <div id="user">
        <input id="password" type="password" class="form-control" placeholder="New password" required>
        <input id="rePassword" type="password" class="form-control" placeholder="Re-type Password" required onchange="validate(this);">
      </div>
        <button class="btn btn-primary register" type="submit">Change</button>
    </form>
  </div>

  <!-- Nodes information -->
  <div class="userForm panel-success">
    <div class="userFormTitle">Nodes</div>
    <a href="" class="linkNodes" id="addNode">Add new node</a>
    <div id="nodesTable"></div>
    
    <div id="addForm">
      <div id="userInfo">Add New Node</div>
      <form id="addDevice">
        <input type="text" id="serial" class="form-control" placeholder="Serial Number" autofocus required>
        <input type="text" id="deviceName" class="form-control" placeholder="Device Name" required>
        <input type="hidden" id="latitud" required>
        <input type="hidden" id="longitud" required>
        <button type="submit" class="btn btn-primary register">Add</button>
      </form>
    </div>

    <div id="nodesMap" class="nodesForms"></div>
  </div>

  <div id="notification"></div>

  <!-- Delete confirmation form -->
  <div class="loginForm" class="panel-success">
    <div id="userInfo">Confirm delete</div>
    <form id="loginForm">
      <input type="password" id="pswd" class="form-control" placeholder="Password" required autofocus>
      <button type="submit" id="confirmBtn" class="btn btn-primary">Confirm</button>
    </form>
    <div id="notifier"></div>
    <a href="" id="dismissNotif">Dismiss</a>
  </div>

  <!-- Footer -->
  <footer class="navbar navbar-inverse navbar-bottom">
    <div class="container">
      <div class="navbar-header">
        <a class="navbar-brand navbar-col">Shell Systems® 2013</a>
      </div>
      <div class="navbar-collapse collapse navbar-right">
          <a class="navbar-brand navbar-col" id="loggedUser">Welcome, <?php echo $_SESSION['usuario']; ?>!</a>
      </div>
    </div>
  </footer>
  <!-- Scripts -->
  <script>$('#userPage').css({ color: '#FFFFFF', background: '#383838'});</script>
</body>
</html>