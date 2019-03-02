<?php 
  //session_start();
  include ('serverDash.php');
  if ($_SESSION['user_permission']!="2")
{
	header('location: index.php');
}
  //include ('server.php');
  ?>
<!DOCTYPE html>
<html>
<body>
	<?php include ('headerDash.php'); ?>
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span></button>
				<a class="navbar-brand" href="index.php"><span>TopBuilder</span></a>
				
			</div>
		</div><!-- /.container-fluid -->
	</nav>

	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Dashboard</li>
			</ol>
		<?php include('dashNav.php'); ?>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Gestion Utilisateur</h1>
				<a href="createUser.php#oModal"> + Create </a>
			</div>
		</div><!--/.row-->
		
		<?php 
		$result = getUser();
		$countUser=0;
		//var_dump (mysqli_num_rows($result));
		echo "<table class='table'> ";
            echo "<tr>";
            	echo "<th>Name</th>";
                echo "<th>First Name</th>";
                echo "<th>Email</th>";
                echo "<th>Telephone</th>";
                echo "<th>Type</th>";
            echo "</tr>";
            $row = mysqli_fetch_array($result);
		while($row){
			$countUser=$countUser+1;
            echo "<tr>";
            	echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['First_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Mail']) . "</td>";
                echo "<td>" . htmlspecialchars($row['Telephone']) . "</td>";
                switch ($row['User_permission']) {
					case 1:
						echo "<td> Client</td>";
						break;
					case 2:
						echo "<td> Admin </td>";
						break;
				}
				?> 
				<td> 
					<?php $id =  htmlspecialchars($row['id_usr']);
					echo "<a href='modifUser.php?id=$id#oModal'>Modifier</a>";
					?>
			     </td>
			     <?php
			     $row = mysqli_fetch_array($result);
				echo "<td><a href='deleteUser.php?action=deleteUser&amp;id=$id#oModal'>Delete</a></td>";
            echo "</tr>";
        }
        echo "</table>";
		 ?>
	</div>	<!--/.main-->
	
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/classActive.js"></script>
	<script src="js/custom.js"></script>
	<script>
		window.onload = function () {
	var chart1 = document.getElementById("line-chart").getContext("2d");
	window.myLine = new Chart(chart1).Line(lineChartData, {
	responsive: true,
	scaleLineColor: "rgba(0,0,0,.2)",
	scaleGridLineColor: "rgba(0,0,0,.05)",
	scaleFontColor: "#c5c7cc"
	});
};
	</script>
	
		
</body>
</html>