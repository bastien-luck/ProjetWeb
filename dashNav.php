<?php
      // On recupere l'URL de la page pour ensuite affecter class = "active" aux liens de nav
      $page = htmlspecialchars($_SERVER["REQUEST_URI"]);
      $page = str_replace("/projetweb/", "",$page);
?>

<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
	<div class="profile-sidebar">
		<div class="profile-userpic">
			<img src="http://placehold.it/50/30a5ff/fff" class="img-responsive" alt="">
		</div>
		<div class="profile-usertitle">
			<div class="profile-usertitle-name"><?php echo(htmlspecialchars($_SESSION['username']));?></div>
			<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="divider"></div>
	<ul class="nav menu">
		<li <?php if($page == "myaccount.php"){echo 'class="active"';} ?>><a href="myaccount.php"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
		<li <?php if($page == "userManage.php"){echo 'class="active"';} ?>><a href="userManage.php"><em class="fa fa-calendar">&nbsp;</em> Gestion Utilisateur</a></li>
		<li <?php if($page == "productManage.php"){echo 'class="active"';} ?>><a href="productManage.php"><em class="fa fa-bar-chart">&nbsp;</em> Gestion Produit</a></li>
		<li <?php if($page == "command_manage.php"){echo 'class="active"';} ?>><a href="command_manage.php"><em class="fa fa-toggle-off">&nbsp;</em> Gestion Commande</a></li>
	</ul>
</div><!--/.sidebar-->