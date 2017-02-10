<?php
	
	if (isset($_GET['create'])) {
		include('../pdo.php');
		$myPDO = getPDO();
		$myPDO->query('INSERT INTO Position VALUES ( DEFAULT, 0, "" )');
		echo json_encode(['success' => $myPDO->query('SELECT * FROM Position WHERE id = LAST_INSERT_ID()')->fetchAll()[0]]);
	} elseif (isset($_GET['delete'])) {
		include('../pdo.php');
		$myPDO = getPDO();
		$myPDO->prepare('DELETE FROM Position WHERE id = ?')->execute([$_GET['delete']]);
		echo json_encode(['success' => true]);
	} elseif (isset($_GET['update'])) {
		if (isset($_GET['price'])) {
			include('../pdo.php');
			$myPDO = getPDO();
			$myPDO->prepare('UPDATE Position SET price = ? WHERE id = ?')->execute([$_GET['price'],$_GET['update']]);
		} elseif (isset($_POST['desc'])) {
			include('../pdo.php');
			$myPDO = getPDO();
			$myPDO->prepare('UPDATE Position SET description = ? WHERE id = ?')->execute([$_POST['desc'],$_GET['update']]);
		}
	}
?>


