<?php
	function getPDO() {
		$dsn = 'mysql:host=127.0.0.1;dbname=test_shop;charset=utf8';
		$user = 'test_shop_php';
		$pw = 'test_shop_pw';
		$opt = [
			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES   => false,
		];
		return new PDO($dsn, $user, $pw, $opt);
	}
?>
