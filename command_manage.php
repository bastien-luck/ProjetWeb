<?php 
  //session_start();
  include ('serverDash.php');
  if (htmlspecialchars($_SESSION['user_permission'])!="2")
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
				<h1 class="page-header">Gestion Commandes</h1>
			</div>
		</div><!--/.row-->
		
		<?php 
		echo "<table class='table'> ";
            echo "<tr>";
            	echo "<th>Numéro Commande</th>";
                echo "<th>Client</th>";
                echo "<th>Adresse</th>";
                echo "<th>Statut</th>";
            echo "</tr>";
			foreach( $adresses_commandes_admin as $adr_admin )
			{
				echo "<tr>";
					echo '<td>' . htmlspecialchars($adr_admin['id_command']) . '</td>';
					echo '<td>' . htmlspecialchars($adr_admin['Name']) . ' ' . htmlspecialchars($adr_admin['First_name']) . '</td>';
					echo '<td>' . htmlspecialchars($adr_admin['Street']) . ' ' . htmlspecialchars($adr_admin['Additional']) . ', ' . htmlspecialchars($adr_admin['City']) . ' ' . htmlspecialchars($adr_admin['Postcode']) . ', ' . htmlspecialchars($adr_admin['Country']) . '</td>';
					echo '<td> Valider </td>';
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
	<script>
// Add active class to the current button (highlight it)
var header = document.getElementById("divider");
var btns = header.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
    var current = document.getElementsByClassName("active");
    current[0].className = current[0].className.replace(" active", "");
    this.className += " active";
  });
}
</script>
		
</body>
</html>