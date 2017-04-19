<li class="header">SUPPORT BEREICH</li>
<!-- Optionally, you can add icons to the links -->
<li<?php if($_GET['page'] == "support_dashboard"){echo ' class="active"';} ?>><a href="?page=support_dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
<?php if(GetPanelUserSteam($_SESSION['steamid'])['ps'] == 1){ ?><li<?php if($_GET['page'] == "support_players"){echo ' class="active"';} ?>><a href="?page=support_players"><i class="fa fa-user"></i> <span>Spielerliste</span></a></li><?php } ?>
<?php if(GetPanelUserSteam($_SESSION['steamid'])['gs'] == 1){ ?><li<?php if($_GET['page'] == "support_gangs"){echo ' class="active"';} ?>><a href="?page=support_gangs"><i class="fa fa-users"></i> <span>Gangliste</span></a></li><?php } ?>
<?php if(GetPanelUserSteam($_SESSION['steamid'])['vs'] == 1){ ?><li<?php if($_GET['page'] == "support_vehicles"){echo ' class="active"';} ?>><a href="?page=support_vehicles"><i class="fa fa-car"></i> <span>Fahrzeugliste</span></a></li><?php } ?>
<?php if(GetPanelUserSteam($_SESSION['steamid'])['hs'] == 1){ ?><li<?php if($_GET['page'] == "support_houses"){echo ' class="active"';} ?>><a href="?page=support_houses"><i class="fa fa-home"></i> <span>Hausliste</span></a></li><?php } ?>
<?php if(GetPanelUserSteam($_SESSION['steamid'])['plog'] == 1){ ?><li<?php if($_GET['page'] == "support_plogs"){echo ' class="active"';} ?>><a href="?page=support_plogs"><i class="fa fa-file-text"></i> <span>Panel Logs</span></a></li><?php } ?>
