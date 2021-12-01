<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Лаб 7</title>
		<link rel="stylesheet" href="../style/lab1.css">
    <style>iframe {background-color : white} </style>
		<style>
		.raz td {
  			border: 1px solid black;
				padding-left: 10px;
				padding-right: 35px;
				padding-top: 10px;
				padding-bottom: 10px;
			}
		</style>
	</head>
	<body>
		<div class="head">
			<br><p>РОЗКЛАД РУХУ ЗАЛІЗНИЧНОГО ТРАНСПОРТУ</p>
			<br>
		</div>

		<div>
			<table width = 100% cellpadding = 20px>
				<tr>
					<td width = 25% class = "menu" valign="top">
						<ul>
							<li><a href="index.html">Головна</a></li>
							<li><a href="class.php">Робота з <b>Клас потяга</b></a></li>
							<li><a href="train.php">Робота з <b>Потяг</b></a></li>
							<li><a href="carriage.php">Робота з <b>Вагон</b></a></li>
							<li><a href="traincarriage.php">Робота з <b>Вагони потяга</b></a></li>
							<li><a href="station.php">Робота з <b>Станція</b></a></li>
							<li><a href="route.php">Робота з <b>Маршут</b></a></li>
              <li><a href="stationonroute.php">Робота з <b>Станції на маршуті</b></a></li>
							<li><a href="trainonroute.php">Робота з <b>Поїзд на маршуті</b></a></li>
							<li><a href="search.php"><b>Пошук</b></a></li>
						</ul>
					</td>

					<td>
						<h1><center>Робота з введенням даних до таблиці Вагон</center></h1>
						<br>
						<form method="POST">
								<p>
								<h2>Тип :
									<input class="text-field" type = "type" name="type"></h2>
								</p>
								<br>
								<p>
								<h2>Загальна к-сть місць :
									<input class="text-field" type = "total" name="total"></h2>
								</p>
								<br>
								<p>
								<h2>Вартість місця :
									<input class="text-field" type = "price" name="price"></h2>
								</p>
								<br>
								<p><input id="send-button" type="submit" value = "Send"></p>
						</form>
						<br>
						<h3>
						<?php
						  $db_host = "trainshedule";
							$db_user = "root";
							$db_password = "";
							$connection = @mysqli_connect($db_host, $db_user, $db_password) or die ("Could not connect");
							mysqli_select_db($connection, "trainshedule");
							$type = $_POST["type"];
							$total = $_POST["total"];
							$price= $_POST["price"];
							$len_type = strlen($type);
							if($len_type>0)
							{
								$query = "INSERT IGNORE INTO Carriage (id, type, totalamountticket, price) VALUES (NULL,'$type', '$total', '$price')";
								if(mysqli_query($connection,$query))
								{
									echo 'Дані про новий Вагон успішно додано до бази даних.';
								}else{
									echo mysqli_error($connection);
								}
							}
						?>
						</h3>
						<br><br>
						<h1><center>Робота з виведенням даних з таблиці Вагон</center></h1>
						<br>
						<h2><center>Виведення усіх даних з таблиці Вагон</center></h2>
						<br>
						<h2><center>
						<?php
						  $db_host = "trainshedule";
							$db_user = "root";
							$db_password = "";
							$connection = @mysqli_connect($db_host, $db_user, $db_password) or die ("Could not connect");
							mysqli_select_db($connection, "trainshedule");
							$sql = "SELECT * FROM carriage";
							if($result = $connection->query($sql)){
    							$rowsCount = $result->num_rows;
    							echo "<p>Отримано записів : $rowsCount</p>";
    							echo "<table class=\"raz\"><tr><th>Id</th><th>Тип</th><th>Загальна кількість місць</th><th>Вартість квитка</th></tr><br>";
    							foreach($result as $row){
        							echo "<tr>";
            					echo "<td>" . $row["Id"] . "</td>";
            					echo "<td>" . $row["Type"] . "</td>";
											echo "<td>" . $row["TotalAmountTicket"] . "</td>";
											echo "<td>" . $row["Price"] . "</td>";
        							echo "</tr>";
    							}
    							echo "</table>";
    							$result->free();
							} else{
    							echo "Ошибка: " . $connection->error;
							}
						?>
					</center></h2>
						<br><br>
					</td>
				</tr>
			</table>
		</div>


		<div class="bottom">
			<br><p>&#169;Розробив студент групи ІС-02 - Зозулюк Віктор</p><br><br>
		</div>
	</body>
</html>
