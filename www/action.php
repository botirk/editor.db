<?php
	
	if (isset($_GET['create'])) {
		include('../pdo.php');
		$myPDO = getPDO();
		$category = $myPDO->query('SELECT id FROM Category LIMIT 1')->fetch()["id"];
		$myPDO->query("INSERT INTO Position VALUE ( DEFAULT, 0, '', $category )");
		echo json_encode(['success' => $myPDO->query('SELECT * FROM Position WHERE id = LAST_INSERT_ID()')->fetch()]);
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
		} elseif (isset($_POST['category'])) {
			include('../pdo.php');
			$myPDO = getPDO();
			$myPDO->prepare('UPDATE Position SET category = ? WHERE id = ?')->execute([$_POST['category'],$_GET['update']]);
		}
	}
?>


