<li class="header">POLIZEI BEREICH</li>
<!-- Optionally, you can add icons to the links -->
<li<?php if($_GET['page'] == "cop_dashboard"){echo ' class="active"';} ?>><a href="?page=cop_dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
<?php if(isset($_SESSION['permission']['whitelist_cop']) && $_SESSION['permission']['whitelist_cop'] == 1){ ?><li<?php if($_GET['page'] == "cop_players"){echo ' class="active"';} ?>><a href="?page=cop_players"><i class="fa fa-users"></i> <span>Spielerlist</span></a></li><?php } ?>
<li<?php if($_GET['page'] == "cop_members"){echo ' class="active"';} ?>><a href="?page=cop_members"><i class="fa fa-user"></i> <span>Mitglieder</span></a></li>