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
						<h1><center>Виведення всього маршуту за номером поїзда</center></h1>
            <br>
            <form method="POST">
								<p>
								<h2>Потяг :
									<input class="text-field" type = "name" name="name"></h2>
								</p>

								<p><input id="send-button" type="submit" value = "Show"></p>
						</form>
						<br>
            <h2><center>
						<?php
						  $db_host = "trainshedule";
							$db_user = "root";
							$db_password = "";
							$connection = @mysqli_connect($db_host, $db_user, $db_password) or die ("Could not connect");
							mysqli_select_db($connection, "trainshedule");
              $name = $_POST["name"];
              $routeId = "";
              $sql = "SELECT * FROM trainonroute";
              if($result = $connection->query($sql)){
                  $rowsCount = $result->num_rows;
                  foreach($result as $row){
                      if($row["TrainId"] == $name)
                        $routeId = $row["RouteId"];
                  }
                  $result->free();
              }
              if($routeId == "")
              {echo "Маршут для даного потяга не знайдено.";}
              else{
              echo "Для потяга " , "$name" , " знайдено наступний маршут.";
              }
							$sql = "SELECT * FROM stationonroute WHERE RouteId = '$routeId' ORDER BY Priority";
							if($result = $connection->query($sql)){
    							$rowsCount = $result->num_rows;
    							echo "<table class=\"raz\"><tr><th>Станція</th></tr><br>";
    							foreach($result as $row)
                  {
        							echo "<tr>";
                      $stationName = "";
                      $sql2 = "SELECT * FROM station";
      								if($result2 = $connection->query($sql2)){
      	    							$rowsCount2 = $result2->num_rows;
      	    							foreach($result2 as $row2){
      	            					if($row2["Id"] == $row["StationId"])
      													$stationName = $row2["Name"];
      	    							}
      								}
            					echo "<td>" . $stationName . "</td>";
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
          <h1><center>Пошук потягів що слідують наступним маршутом</center></h1>
          <br>
          <form method="POST">
              <p>
              <h2>Станція відправлення :
                <input class="text-field" type = "start" name="start"></h2>
              </p>
              <br>
              <p>
              <h2>Станція прибуття :
                <input class="text-field" type = "end" name="end"></h2>
              </p>
              <p><input id="send-button" type="submit" value = "Show one more time"></p>
          </form>
          <br>
          <h2><center>
            <?php
              $db_host = "trainshedule";
              $db_user = "root";
              $db_password = "";
              $connection = @mysqli_connect($db_host, $db_user, $db_password) or die ("Could not connect");
              mysqli_select_db($connection, "trainshedule");
              $start = $_POST["start"];
              $end = $_POST["end"];
              $len_start = strlen($start);
              $len_end = strlen($end);
              if($len_start>0 & $len_end > 0)
              {
                $sql0 = "SELECT * FROM train";
                if($result0 = $connection->query($sql0)){
                    $rowsCount0 = $result0->num_rows;
                    foreach($result0 as $row0){
                      $name = $row0["Id"];
                      $routeId = "";
                      $sql = "SELECT * FROM trainonroute";
                      if($result = $connection->query($sql)){
                          $rowsCount = $result->num_rows;
                          foreach($result as $row){
                              if($row["TrainId"] == $name)
                                $routeId = $row["RouteId"];
                          }
                          $result->free();
                      }
                      if($routeId == "")
                      {echo "Маршут для даного потяга не знайдено.";}
                      else{
                      echo "Для потяга " , "$name" , " знайдено наступний маршут.";
                      }
                      $sql = "SELECT * FROM stationonroute WHERE RouteId = '$routeId' ORDER BY Priority";
                      if($result = $connection->query($sql)){
                          $rowsCount = $result->num_rows;
                          echo "<table class=\"raz\"><tr><th>Станція</th></tr><br>";
                          $check = false;
                          foreach($result as $row)
                          {
                              echo "<tr>";
                              $stationName = "";
                              $sql2 = "SELECT * FROM station";
                              if($result2 = $connection->query($sql2)){
                                  $rowsCount2 = $result2->num_rows;
                                  foreach($result2 as $row2){
                                      if($row2["Id"] == $row["StationId"])
                                        $stationName = $row2["Name"];
                                  }
                              }
                              if($stationName == $start){$check = true;}
                              if($check == true){echo "<td>" . $stationName . "</td>";}
                              if($stationName == $end){$check = false;}

                              echo "</tr>";
                          }
                          echo "</table>";
                          $result->free();
                      } else{
                          echo "Ошибка: " . $connection->error;
                      }
                    }
                    $result0->free();
                } else{
                    echo "Ошибка: " . $connection->error;
                }
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
