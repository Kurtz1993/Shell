<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
			<a href="index.php" class="navbar-brand" id="startPage">SHELL SYSTEMS</a>
			<a href="table.php" class="navbar-brand" id="nodesPage">Active Nodes</a>
        </div>
        <div class="navbar-collapse collapse navbar-right" id="loginNav">
        	<!-- Aquí irá el nombre del usuario loggeado, que se extraerá de la BD -->
			<label class="navbar-brand navbar-col" id="loggedUser">Welcome, <?php echo $_SESSION['usuario']; ?>!</label>
      <a href="index.php?action=destroy" class="navbar-brand navbar-col">Sign out</a>
		</div>
      </div>
</nav>