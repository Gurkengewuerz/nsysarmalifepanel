<li class="header">EMS BEREICH</li>
<!-- Optionally, you can add icons to the links -->
<li<?php if($_GET['page'] == "medic_dashboard"){echo ' class="active"';} ?>><a href="?page=medic_dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
<?php if($_SESSION['permission']['whitelist_medic'] == 1){ ?><li<?php if($_GET['page'] == "medic_players"){echo ' class="active"';} ?>><a href="?page=medic_players"><i class="fa fa-users"></i> <span>Spielerliste</span></a></li><?php } ?>