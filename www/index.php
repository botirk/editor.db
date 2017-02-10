<!doctype html>
<html>
<head>
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<title>editor.db</title>
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
	  		<div class="navbar-header">
			  <a class="navbar-brand" href="/">editor.db</a>
			</div>
		</div>
	</nav>
	<?php 
		if (!in_array('mysql',PDO::getAvailableDrivers())) echo '<h3>PHP: PDO drivers are not installed</h3>';
		else {
			//не будем рисовать табличку в PHP, а возьмём жава скрипт
			include('../pdo.php');
			$myPDO = getPDO();
			$JSON_select = json_encode($myPDO->query("SELECT * FROM Position")->fetchAll());
			$JSON_category = json_encode($myPDO->query("SELECT id,name FROM Category")->fetchAll());
			echo "<script> var select = $JSON_select;var category = $JSON_category; </script>";
				//HTML каркас
			?>
				<h3>Отредактируйте таблицу позиций</h3>
				<table class="table">
					<thead><tr>
						<th style="width:75px">идентификатор</th>
						<th style="width:75px">цена</th>
						<th style="width:100%">описание</th>
					</tr></thead>
				<tbody></tbody></table>
				<button class='btn-success'>добавить</button>
				<script>
					//налепливаем на каркас
					var tbody = $("tbody");
					var add = function(selectJSON) {
						var addID = function() { return "<td>" + selectJSON.id + "</td>"; }
						var addPrice = function() { return "<td contenteditable>" + selectJSON.price + "</td>"; }
						var addDesc = function() { return "<td contenteditable>" + selectJSON.description + "</td>"; }
						var addRemoveButton = function() { return "<td><button class='btn btn-danger'>удалить</button></td>"; }
						var addRow = function() { return "<tr id='" + selectJSON.id + "'>" + addID() + addPrice() + addDesc() + addRemoveButton() + "</tr>"; }
						var removeRow = function() { $("#"+selectJSON.id).remove(); }
						tbody.append(addRow());
						//включаем редактор цены
						var price = $("#"+selectJSON.id).children()[1];
						price.oninput = function(){ 
							if (isNaN(price.innerHTML)) price.innerHTML = selectJSON.price.toString();
							else $.ajax("./action.php?update="+selectJSON.id+"&price="+price.innerHTML);
						};
						//включаем редактор описания 
						var desc = $("#"+selectJSON.id).children()[2];
						desc.oninput = function(){ $.post("./action.php?update="+selectJSON.id,{desc: desc.innerHTML}); }
						//включаем кнопку удаления
						$(".btn-danger").last()[0].onclick = function() { $.ajax({url: "./action.php?delete="+selectJSON.id, success: function(result) {
							result = JSON.parse(result);
							if (result.success) removeRow(); else alert(result.error);
						}});}
					}
					select.forEach(add);
					// включаем кнопку добавления
					$(".btn-success")[0].onclick = function() { $.ajax({url: "./action.php?create=true", success: function(result) {
						result = JSON.parse(result);
						if (result.success) add(result.success); else alert(result.error);		
					}});}
				</script>
			<?php
		}
	?>
</body>
</html>
