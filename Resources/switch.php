<?php 

if (isset($_GET['action'])){
	switch ($_GET['action']) {
		case 'destroy':
			$mysql->destroy();
			header('location:index.php');
			break;
		case 'table':
			$result = $mysql->get_usuarios();
			echo json_encode($result);
			break;
	}
}

?>