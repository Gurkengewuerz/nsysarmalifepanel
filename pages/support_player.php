<?php if(isset($access)){if(!$access == true){exit;}}else{exit;}
if(!isset($_GET['id']) or $_GET['id'] == "" or ExistPlayerByUID($_GET['id']) == 0){header("Location: ?page=support_players"); exit;}else{
    if(!$_SESSION['permission']['view_player'] == 1){header("Location: ?page=support_dashboard"); exit;}
    $player = GetPlayerByUID($_GET['id']);
    if(CheckSteamID($player['pid']) == 0){
        InsertSteamID($player['pid']);
    }
}
?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include("menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Spieler
                <small>Support</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="?page=support_dashboard"><i class="fa fa-dashboard"></i> Support</a></li>
                <li><a href="?page=support_players">Spielerliste</a></li>
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
                            <?php if($_SESSION['permission']['edit_player'] == 1){ ?><button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#player_edit">Bearbeiten</button><?php } ?>
                            <a class="btn btn-warning btn-block" href="http://webinterface.playerindex.de/default.aspx?id=<?php echo $player['pid']; ?>" target="_blank">Auf Playerindex Ban prüfen</a>
                            <a class="btn btn-default btn-block" href="http://steamcommunity.com/profiles/<?php echo $player['pid']; ?>" target="_blank">Steam Profil öffnen</a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#inventory" data-toggle="tab" aria-expanded="false">Inventar</a></li>
                            <?php if($_SESSION['permission']['view_licence'] == 1){ ?><li class=""><a href="#licenses" data-toggle="tab" aria-expanded="true">Lizenzen</a></li><?php } ?>
                            <?php if($_SESSION['permission']['view_vehicle'] == 1){ ?><li class=""><a href="#vehicles" data-toggle="tab" aria-expanded="false">Fahrzeuge</a></li><?php } ?>
                            <?php if($_SESSION['permission']['view_house'] == 1){ ?><li class=""><a href="#houses" data-toggle="tab" aria-expanded="false">Häuser</a></li><?php } ?>
                            <?php if($_SESSION['permission']['view_notice'] == 1){ ?><li class=""><a href="#notes" data-toggle="tab" aria-expanded="false">Notizen</a></li><?php } ?>
                            <?php if($_SESSION['permission']['panel_right'] == 1){ ?><li class=""><a href="#permissions" data-toggle="tab" aria-expanded="false">Rechte</a></li><?php } ?>
                        </ul>
                        <div class="tab-content">
                            <?php if($_SESSION['permission']['view_licence'] == 1){ ?><div class="tab-pane" id="licenses">
                                <b>Spieler</b>
                                <div class="well">
                                    <?php
                                    foreach(GetLicensesByID($player['uid']) as $lic){
                                        if($lic['status'] == 1){
                                            echo '<button onclick="SwitchLicense('."this, '".$lic['name']."', 'civ'".')" class="btn btn-success btn-xs">'.ParseLicense($lic['name']).'</button> ';
                                        }else{
                                            echo '<button onclick="SwitchLicense('."this, '".$lic['name']."', 'civ'".')" class="btn btn-danger btn-xs">'.ParseLicense($lic['name']).'</button> ';
                                        }

                                    }
                                    ?>
                                </div>

                                <b>Cop / Justiz</b>
                                <div class="well">
                                    <?php
                                    foreach(GetLicensesByID($player['uid'], 1) as $lic){
                                        if($lic['status'] == 1){
                                            echo '<button onclick="SwitchLicense('."this, '".$lic['name']."', 'cop'".')" class="btn btn-success btn-xs">'.ParseLicense($lic['name']).'</button> ';
                                        }else{
                                            echo '<button onclick="SwitchLicense('."this, '".$lic['name']."', 'cop'".')" class="btn btn-danger btn-xs">'.ParseLicense($lic['name']).'</button> ';
                                        }

                                    }
                                    ?>
                                </div>

                                <b>EMS</b>
                                <div class="well">
                                    <?php
                                    foreach(GetLicensesByID($player['uid'], 2) as $lic){
                                        if($lic['status'] == 1){
                                            echo '<button onclick="SwitchLicense('."this, '".$lic['name']."', 'medic'".')" class="btn btn-success btn-xs">'.ParseLicense($lic['name']).'</button> ';
                                        }else{
                                            echo '<button onclick="SwitchLicense('."this, '".$lic['name']."', 'medic'".')" class="btn btn-danger btn-xs">'.ParseLicense($lic['name']).'</button> ';
                                        }

                                    }
                                    ?>
                                </div>
                            </div><?php } ?>
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
                            <?php if($_SESSION['permission']['view_house'] == 1){ ?>
                            <div class="tab-pane" id="houses">
                                <table class="table table-responsive table-bordered table-striped table-hover">
                                    <thead>
                                    <th>Position</th>
                                    <th>In Besitz</th>
                                    <th>Garage</th>
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
                                        <td><?php if($row['owned'] == 1){echo '<span class="label label-success">Ja</span>';}else{echo '<span class="label label-danger">Nein</span>';} ?></td>
                                        <td><?php if($row['garage'] == 1){echo '<span class="label label-success">Ja</span>';}else{echo '<span class="label label-danger">Nein</span>';} ?></td>
                                        <td><a href="?page=support_containers&pid=<?php echo $row['pid']; ?>" class="btn btn-primary btn-xs">Anzeigen</a></td>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.tab-pane -->
                            <?php } ?>
                            <div class="tab-pane" id="vehicles">
                                <table class="table table-responsive table-bordered table-striped table-hover">
                                    <thead>
                                        <th>Klasse</th>
                                        <th>Typ</th>
                                        <th>Fraktion</th>
                                        <th>Status</th>
                                        <th>Garage</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql = "SELECT * FROM vehicles WHERE pid = ?";
                                    $statement = $pdo->prepare($sql);
                                    $statement->execute(array($player['pid']));
                                    while($row = $statement->fetch()) {
                                        ?>
                                        <tr><td><?php echo ParseVehicleName($row['classname']); ?></td>
                                            <td><?php echo ParseVehicleTyp($row['type']); ?></td>
                                            <td><?php echo ParseSide($row['side']); ?></td>
                                            <td id="vehstat<?php echo $row['id']; ?>"><?php if($row['alive'] == 1){echo '<button onclick="RepairVehicle('.$row['id'].', 0)" class="btn btn-success btn-xs">Ganz</button>';}else{echo '<button onclick="RepairVehicle('.$row['id'].', 1)" class="btn btn-danger btn-xs">Zerstört</button>';} ?></td>
                                            <td id="vehgar<?php echo $row['id']; ?>"><?php if($row['active'] == 1){echo '<button onclick="GarageVehicle('.$row['id'].', 0)" class="btn btn-warning btn-xs">Ausgeparkt</button>';}else{echo '<button onclick="GarageVehicle('.$row['id'].', 1)" class="btn btn-success btn-xs">Eingeparkt</button>';} ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.tab-pane -->

                            <?php if($_SESSION['permission']['view_notice'] == 1){ ?>
                            <div class="tab-pane" id="notes">
                                <table id="NoteTable" class="table table-responsive table-bordered table-striped table-hover">
                                    <thead>
                                    <th>Ersteller</th>
                                    <th>Notiz</th>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql = "SELECT * FROM panel_notes WHERE targetid = ?";
                                    $statement = $pdo->prepare($sql);
                                    $statement->execute(array($player['uid']));
                                    while($row = $statement->fetch()) {
                                        ?>
                                        <tr>
                                            <td><?php echo utf8_encode(GetPlayerByUID($row['uid'])['name']); ?></td>
                                            <td><?php echo utf8_encode($row['note']); ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <?php if($_SESSION['permission']['edit_notice'] == 1){ ?><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#player_note_add">Notiz erstellen</button><?php } ?>
                            </div>
                            <!-- /.tab-pane -->
                            <?php } ?>

                            <?php if($_SESSION['permission']['panel_right'] == 1){ ?>
                            <div class="tab-pane" id="permissions">
                                <div class="box box-solid">

                                    <div class="box-body">
                                        <?php
                                            $rechte = GetPermissionByPanelUser($_GET['id']);
                                            function RightStatus($value){
                                                global $rechte;

                                                $found = false;
                                                foreach ($rechte as $perm) {
                                                    if($perm["permission"] == $value && $perm["val"] == 1) {
                                                        $found = true;
                                                    }
                                                }
                                                if($found) {
                                                    echo "btn-success";
                                                } else {
                                                    echo "btn-danger";
                                                }
                                            }
                                            $PanelUser = GetPanelUserSteam($player['pid']);

                                        ?>
                                        <div class="col-md-4">
                                            <h1>Spieler</h1>
                                            <div class="col-md-6">
                                                <button onclick="SwitchPermission(this, 'view_player')" class="btn <?php RightStatus('view_player'); ?> btn-block">Spieler Anschauen</button></br>
                                                <button onclick="SwitchPermission(this, 'view_vehicle')" class="btn <?php RightStatus('view_vehicle'); ?> btn-block">Fahrzeuge Anschauen</button></br>
                                                <button onclick="SwitchPermission(this, 'view_house')" class="btn <?php RightStatus('view_house'); ?> btn-block">Häuser Anschauen</button></br>
                                                <button onclick="SwitchPermission(this, 'view_gangs')" class="btn <?php RightStatus('view_gangs'); ?> btn-block">Gangs Anschauen</button></br>
                                                <button onclick="SwitchPermission(this, 'view_licence')" class="btn <?php RightStatus('view_licence'); ?> btn-block">Lizenzen Anschauen</button></br>
                                                <button onclick="SwitchPermission(this, 'view_notice')" class="btn <?php RightStatus('view_notice'); ?> btn-block">Notizen Anschauen</button></br>
                                            </div>
                                            <div class="col-md-6">
                                                <button onclick="SwitchPermission(this, 'edit_player')" class="btn <?php RightStatus('edit_player'); ?> btn-block">Spieler Bearbeiten</button></br>
                                                <button onclick="SwitchPermission(this, 'edit_vehicle')" class="btn <?php RightStatus('edit_vehicle'); ?> btn-block">Fahrzeuge Bearbeiten</button></br>
                                                <button onclick="SwitchPermission(this, 'edit_house')" class="btn <?php RightStatus('edit_house'); ?> btn-block">Häuser Bearbeiten</button></br>
                                                <button onclick="SwitchPermission(this, 'edit_gang')" class="btn <?php RightStatus('edit_gang'); ?> btn-block">Gangs Bearbeiten</button></br>
                                                <button onclick="SwitchPermission(this, 'edit_licence')" class="btn <?php RightStatus('edit_licence'); ?> btn-block">Lizenzen Bearbeiten</button></br>
                                                <button onclick="SwitchPermission(this, 'edit_notice')" class="btn <?php RightStatus('edit_notice'); ?> btn-block">Notizen Bearbeiten</button></br>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <h1>Whitelistung Fraktionen</h1>
                                            <button onclick="SwitchPermission(this, 'whitelist_cop')" class="btn <?php RightStatus('whitelist_cop'); ?> btn-block">Polizei</button></br>
                                            <button onclick="SwitchPermission(this, 'whitelist_justice')" class="btn <?php RightStatus('whitelist_justice'); ?> btn-block">Justiz</button></br>
                                            <button onclick="SwitchPermission(this, 'whitelist_medic')" class="btn <?php RightStatus('whitelist_medic'); ?> btn-block">EMS</button></br>
                                        </div>
                                        <div class="col-md-4">
                                            <h1>Panel</h1>
                                            <button onclick="SwitchPermission(this, 'panel_right')" class="btn <?php RightStatus('panel_right'); ?> btn-block">Rechte</button></br>
                                            <button onclick="SwitchPermission(this, 'panel_support')" class="btn <?php RightStatus('panel_support'); ?> btn-block">Panel Support</button></br>
                                            <button onclick="SwitchPermission(this, 'panel_log')" class="btn <?php RightStatus('panel_log'); ?> btn-block">Panel Logs</button></br>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <?php } ?>
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

<?php if($_SESSION['permission']['edit_player'] == 1){ ?>
<!-- modal -->
<div class="modal fade modal-primary" id="player_edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Spieler bearbeiten</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Bargeld</label>
                    <input id="userbargeld" type="number" class="form-control" placeholder="Bargeld.." value="<?php echo $player['cash']; ?>">
                </div>
                <div class="form-group">
                    <label>Bank</label>
                    <input id="userbank" type="number" class="form-control" placeholder="Bank.." value="<?php echo $player['bankacc']; ?>">
                </div>
                <div class="form-group">
                    <label>Admin Level</label>
                    <select id="useradmin" class="form-control">
                        <option value="0" <?php if($player['adminlevel'] == 0){echo "selected";} ?>>0</option>
                        <option value="1" <?php if($player['adminlevel'] == 1){echo "selected";} ?>>1</option>
                        <option value="2" <?php if($player['adminlevel'] == 2){echo "selected";} ?>>2</option>
                        <option value="3" <?php if($player['adminlevel'] == 3){echo "selected";} ?>>3</option>
                        <option value="4" <?php if($player['adminlevel'] == 4){echo "selected";} ?>>4</option>
                        <option value="5" <?php if($player['adminlevel'] == 5){echo "selected";} ?>>5</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Cop Level</label>
                    <select id="usercop" class="form-control">
                        <option value="0" <?php if($player['coplevel'] == 0){echo "selected";} ?>>0</option>
                        <option value="1" <?php if($player['coplevel'] == 1){echo "selected";} ?>>1 - Justiz</option>
                        <option value="2" <?php if($player['coplevel'] == 2){echo "selected";} ?>>2 - FBI</option>
                        <option value="3" <?php if($player['coplevel'] == 3){echo "selected";} ?>>3</option>
                        <option value="4" <?php if($player['coplevel'] == 4){echo "selected";} ?>>4</option>
                        <option value="5" <?php if($player['coplevel'] == 5){echo "selected";} ?>>5</option>
                        <option value="6" <?php if($player['coplevel'] == 6){echo "selected";} ?>>6</option>
                        <option value="7" <?php if($player['coplevel'] == 7){echo "selected";} ?>>7</option>
                        <option value="8" <?php if($player['coplevel'] == 8){echo "selected";} ?>>8</option>
                        <option value="9" <?php if($player['coplevel'] == 9){echo "selected";} ?>>9</option>
                        <option value="10" <?php if($player['coplevel'] == 10){echo "selected";} ?>>10</option>
                        <option value="11" <?php if($player['coplevel'] == 11){echo "selected";} ?>>11</option>
                        <option value="12" <?php if($player['coplevel'] == 12){echo "selected";} ?>>12</option>
                        <option value="13" <?php if($player['coplevel'] == 13){echo "selected";} ?>>13</option>
                        <option value="14" <?php if($player['coplevel'] == 14){echo "selected";} ?>>14</option>
                        <option value="15" <?php if($player['coplevel'] == 15){echo "selected";} ?>>15</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Medic Level</label>
                    <select id="usermedic" class="form-control">
                        <option value="0" <?php if($player['mediclevel'] == 0){echo "selected";} ?>>0</option>
                        <option value="1" <?php if($player['mediclevel'] == 1){echo "selected";} ?>>1</option>
                        <option value="2" <?php if($player['mediclevel'] == 2){echo "selected";} ?>>2</option>
                        <option value="3" <?php if($player['mediclevel'] == 3){echo "selected";} ?>>3</option>
                        <option value="4" <?php if($player['mediclevel'] == 4){echo "selected";} ?>>4</option>
                        <option value="5" <?php if($player['mediclevel'] == 5){echo "selected";} ?>>5</option>
                        <option value="6" <?php if($player['mediclevel'] == 6){echo "selected";} ?>>6</option>
                        <option value="7" <?php if($player['mediclevel'] == 7){echo "selected";} ?>>7</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Schließen</button>
                <button type="button" onclick="SavePlayer()" class="btn btn-primary">Speichern</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<?php if($_SESSION['permission']['edit_notice'] == 1){ ?>
<!-- modal -->
<div class="modal fade modal-primary" id="player_note_add" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Notiz zu <?php echo $player['name']; ?> erstellen</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Notiz Text</label>
                    <textarea id="notecontent" class="form-control" placeholder="Notiz Text.." rows="5" id="comment"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Schließen</button>
                <button type="button" onclick="CreateNote()" class="btn btn-primary">Erstellen</button>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script type="application/javascript">
    function SavePlayer(){
        $("#player_edit").modal("hide");

        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: {
                'javadata': 'support_player_save_general',
                'bargeld': $("#userbargeld").val(),
                'bank': $("#userbank").val(),
                'admin': $("#useradmin").val(),
                'cop': $("#usercop").val(),
                'medic': $("#usermedic").val(),
                'id': '<?php echo $player['uid']; ?>'
            },
            success: function(data){
                //alert(data);
                $("#anzeigebargeld").html(numberWithCommas($("#userbargeld").val()) + " $");
                $("#anzeigebank").html(numberWithCommas($("#userbank").val()) + " $");
                $("#anzeigeadmin").html($("#useradmin").val());
                $("#anzeigecop").html($("#usercop").val());
                $("#anzeigemedic").html($("#usermedic").val());
            }
        });
    }

    function numberWithCommas(x) {
        var parts = x.toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        return parts.join(".");
    }

    function RepairVehicle(id, status){
        <?php if($_SESSION['permission']['edit_vehicle'] == 1){ ?>
        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: {
                'javadata': 'support_vehicle_repair',
                'status': status,
                'id': id
            },
            success: function(){
                //alert(data);
                if(status == 1){
                    $("#vehstat" + id).html('<button onclick="RepairVehicle(' + id + ', 0)" class="btn btn-success btn-xs">Ganz</button>');
                }else{
                    $("#vehstat" + id).html('<button onclick="RepairVehicle(' + id + ', 1)" class="btn btn-danger btn-xs">Zerstört</button>');
                }
            }
        });
        <?php } ?>
    }

    function GarageVehicle(id, status){
        <?php if($_SESSION['permission']['edit_vehicle'] == 1){ ?>
        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: {
                'javadata': 'support_vehicle_garage',
                'status': status,
                'id': id
            },
            success: function(){
                //alert(data);
                if(status == 1){
                    $("#vehgar" + id).html('<button onclick="GarageVehicle(' + id + ', 0)" class="btn btn-warning btn-xs">Ausgeparkt</button>');
                }else{
                    $("#vehgar" + id).html('<button onclick="GarageVehicle(' + id + ', 1)" class="btn btn-success btn-xs">Eingeparkt</button>');
                }
            }
        });
        <?php } ?>
    }

    function SwitchLicense(btn, lic, type){
        <?php if($_SESSION['permission']['edit_licence'] == 1){ ?>
        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: {
                'javadata': 'support_license',
                'type': type,
                'lic': lic,
                'id': <?php echo $player['uid']; ?>
            },
            success: function(){
                //alert(data);
                if ($(btn).hasClass('btn-success')) {
                    $(btn).removeClass('btn-success').addClass('btn-danger');
                } else {
                    $(btn).removeClass('btn-danger').addClass('btn-success');
                }
            }
        });
        <?php } ?>
    }

    function CreateNote(){
        <?php if($_SESSION['permission']['edit_notice'] == 1){ ?>
        $("#player_note_add").modal("hide");
        // Notiz zu einem Spieler hinzufügen
        var content = $("#notecontent").val();
        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: {
                'javadata': 'support_note_add',
                'content': content,
                'id': <?php echo $player['uid']; ?>
            },
            success: function(){
                //alert(data);
                $("#notecontent").val("");
                var tableRef = document.getElementById('NoteTable').getElementsByTagName('tbody')[0];
                var newRow   = tableRef.insertRow(tableRef.rows.length);
                var newCell  = newRow.insertCell(0);
                var newCell2  = newRow.insertCell(1);
                newCell.appendChild(document.createTextNode('<?php echo $_SESSION['name']; ?>'));
                newCell2.appendChild(document.createTextNode(content));
            }
        });
        <?php } ?>
    }

    <?php if($_SESSION['permission']['panel_right'] == 1){ ?>
    function SwitchPermission(btn, field1){

        var field2 = 0;
        if ($(btn).hasClass('btn-success')) {
            field2 = 0;
        } else {
            field2 = 1;
        }
        console.log("PermF: " + field1 + ", " + field2);
        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: {
                'javadata': 'support_right',
                'field1': field1,
                'field2': field2,
                'pid': '<?php echo GetPlayerByUID($_GET['id'])['pid']; ?>'
            },
            success: function(data){
                //alert(data);
                if ($(btn).hasClass('btn-success')) {
                    $(btn).removeClass('btn-success').addClass('btn-danger');
                } else {
                    $(btn).removeClass('btn-danger').addClass('btn-success');
                }
                console.log("Perm: " + data);
            }
        });
    }
    <?php } ?>
</script>
