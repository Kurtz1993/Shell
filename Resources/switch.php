<?php 

if (isset($_GET['action'])){
	switch ($_GET['action']) {
		case 'destroy':
			$mysql->destroy();
			header('location:index.php');
			break;
	}
}

?>