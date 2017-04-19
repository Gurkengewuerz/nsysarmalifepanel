<?php if(isset($access)){if(!$access == true){exit;}}else{exit;}

    if(!ExistPlayer($_SESSION['steamid']) == 1){session_destroy(); echo "Dein Account wurde nicht gefunden!"; exit;}
    $player = GetPlayer($_SESSION['steamid']);
    if(CheckSteamID($player['pid']) == 0){
        InsertSteamID($player['pid']);
    }
?>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

    <?php include("menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Spieler
                <small><?php echo utf8_encode($player['name']); ?></small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><?php echo utf8_encode($player['name']); ?></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content animated fadeIn">
            <div class="row">
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <h3 class="profile-username text-center"><?php echo utf8_encode($player['name']); ?></h3>

                            <p class="text-muted text-center"><b>Aliases:</b> <?php echo utf8_encode($player['aliases']); ?></p>

                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>PlayerID</b> <a class="pull-right"><?php echo $player['pid']; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Bargeld</b> <a class="pull-right" id="anzeigebargeld"><?php echo number_format($player['cash'], 0, ",", "."); ?> $</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Bank</b> <a class="pull-right" id="anzeigebank"><?php echo number_format($player['bankacc'], 0, ",", "."); ?> $</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Admin Level</b> <a class="pull-right" id="anzeigeadmin"><?php echo $player['adminlevel']; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Cop Level</b> <a class="pull-right" id="anzeigecop"><?php echo $player['coplevel']; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Medic Level</b> <a class="pull-right" id="anzeigemedic"><?php echo $player['mediclevel']; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Gefängnis Status</b> <a class="pull-right"><?php if($player['arrested'] == 1){echo 'Eingesperrt';}else{echo 'Frei';} ?></a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#inventory" data-toggle="tab" aria-expanded="false">Inventar</a></li>
                            <li class=""><a href="#licenses" data-toggle="tab" aria-expanded="true">Lizenzen</a></li>
                            <li class=""><a href="#vehicles" data-toggle="tab" aria-expanded="false">Fahrzeuge</a></li>
                            <li class=""><a href="#houses" data-toggle="tab" aria-expanded="false">Häuser</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="licenses">
                                <b>Spieler</b>
                                <div class="well">
                                    <?php
                                    foreach(GetLicensesByID($player['uid']) as $lic){
                                        if($lic['status'] == 1){
                                            echo '<button class="btn btn-success btn-xs">'.ParseLicense($lic['name']).'</button> ';
                                        }else{
                                            echo '<button class="btn btn-danger btn-xs">'.ParseLicense($lic['name']).'</button> ';
                                        }

                                    }
                                    ?>
                                </div>

                                <b>Cop / Justiz</b>
                                <div class="well">
                                    <?php
                                    foreach(GetLicensesByID($player['uid'], 1) as $lic){
                                        if($lic['status'] == 1){
                                            echo '<button class="btn btn-success btn-xs">'.ParseLicense($lic['name']).'</button> ';
                                        }else{
                                            echo '<button class="btn btn-danger btn-xs">'.ParseLicense($lic['name']).'</button> ';
                                        }

                                    }
                                    ?>
                                </div>

                                <b>EMS</b>
                                <div class="well">
                                    <?php
                                    foreach(GetLicensesByID($player['uid'], 2) as $lic){
                                        if($lic['status'] == 1){
                                            echo '<button class="btn btn-success btn-xs">'.ParseLicense($lic['name']).'</button> ';
                                        }else{
                                            echo '<button class="btn btn-danger btn-xs">'.ParseLicense($lic['name']).'</button> ';
                                        }

                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane active" id="inventory">
                                <b>Spieler</b>
                                <div class="well">
                                    <?php echo $player['civ_gear']; ?>
                                </div>

                                <b>Cop / Justiz</b>
                                <div class="well">
                                    <?php echo $player['cop_gear']; ?>
                                </div>

                                <b>EMS</b>
                                <div class="well">
                                    <?php echo $player['med_gear']; ?>
                                </div>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="houses">
                                <table class="table table-responsive table-bordered table-striped table-hover">
                                    <thead>
                                    <th>Position</th>
                                    <th>Aktionen</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql = "SELECT * FROM houses WHERE pid = ?";
                                    $statement = $pdo->prepare($sql);
                                    $statement->execute(array($player['pid']));
                                    while($row = $statement->fetch()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['pos']; ?></td>
                                        <td>-</td>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="vehicles">
                                <table class="table table-responsive table-bordered table-striped table-hover">
                                    <thead>
                                        <th>Klasse</th>
                                        <th>Typ</th>
                                        <th>Fraktion</th>
                                        <th>Status</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql = "SELECT * FROM vehicles WHERE pid = ?";
                                    $statement = $pdo->prepare($sql);
                                    $statement->execute(array($player['pid']));
                                    while($row = $statement->fetch()) {
                                        ?>
                                        <tr><td><?php echo ParseVehicleName($row['classname']); ?></td>
                                            <td><?php echo $row['type']; ?></td>
                                            <td><?php echo ParseSide($row['side']); ?></td>
                                            <td id="vehstat<?php echo $row['id']; ?>"><?php if($row['alive'] == 1){echo '<button class="btn btn-success btn-xs">Ganz</button>';}else{echo '<button class="btn btn-danger btn-xs">Zerstört</button>';} ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.tab-pane -->

                        </div>
                        <!-- /.tab-content -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php include("foot.php"); ?>

    </div>
<!-- ./wrapper -->

