<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
  			<a href="index.php" class="navbar-brand" id="startPage">SHELL SYSTEMS</a>
        <?php if($_SESSION['id'] != 1): ?>
  			<a href="table.php" class="navbar-brand" id="nodesPage">Active Nodes</a>
        <?php else: ?>
        <a href="admin.php" class="navbar-brand" id="adminPage">Generate Codes</a>
        <a href="admintable.php" class="navbar-brand" id="adminTablesPage">Tables</a>
        <?php endif; ?>
      </div>
      <div class="navbar-collapse collapse navbar-right" id="loginNav">
  			<a class="navbar-brand navbar-col" id="loggedUser">Welcome, <?php echo $_SESSION['usuario']; ?>!</a>
        <a href="index.php?action=destroy" class="navbar-brand navbar-col">Sign out</a>
		  </div>
    </div>
</nav>