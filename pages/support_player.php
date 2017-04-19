<?php if(isset($access)){if(!$access == true){exit;}}else{exit;}
if(!isset($_GET['id']) or $_GET['id'] == "" or ExistPlayerByUID($_GET['id']) == 0){header("Location: ?page=support_players"); exit;}else{
    if(!GetPanelUserSteam($_SESSION['steamid'])['ps'] == 1){header("Location: ?page=support_dashboard"); exit;}
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
                            <?php if(GetPanelUserSteam($_SESSION['steamid'])['pe'] == 1){ ?><button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#player_edit">Bearbeiten</button><?php } ?>
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
                            <?php if(GetPanelUserSteam($_SESSION['steamid'])['ls'] == 1){ ?><li class=""><a href="#licenses" data-toggle="tab" aria-expanded="true">Lizenzen</a></li><?php } ?>
                            <?php if(GetPanelUserSteam($_SESSION['steamid'])['vs'] == 1){ ?><li class=""><a href="#vehicles" data-toggle="tab" aria-expanded="false">Fahrzeuge</a></li><?php } ?>
                            <?php if(GetPanelUserSteam($_SESSION['steamid'])['hs'] == 1){ ?><li class=""><a href="#houses" data-toggle="tab" aria-expanded="false">Häuser</a></li><?php } ?>
                            <?php if(GetPanelUserSteam($_SESSION['steamid'])['pans'] == 1){ ?><li class=""><a href="#notes" data-toggle="tab" aria-expanded="false">Notizen</a></li><?php } ?>
                            <?php if(GetPanelUserSteam($_SESSION['steamid'])['par'] == 1){ ?><li class=""><a href="#permissions" data-toggle="tab" aria-expanded="false">Rechte</a></li><?php } ?>
                        </ul>
                        <div class="tab-content">
                            <?php if(GetPanelUserSteam($_SESSION['steamid'])['ls'] == 1){ ?><div class="tab-pane" id="licenses">
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
                            <?php if(GetPanelUserSteam($_SESSION['steamid'])['hs'] == 1){ ?>
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
                            <?php } ?>
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
                                            <td id="vehstat<?php echo $row['id']; ?>"><?php if($row['alive'] == 1){echo '<button onclick="RepairVehicle('.$row['id'].', 0)" class="btn btn-success btn-xs">Ganz</button>';}else{echo '<button onclick="RepairVehicle('.$row['id'].', 1)" class="btn btn-danger btn-xs">Zerstört</button>';} ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.tab-pane -->

                            <?php if(GetPanelUserSteam($_SESSION['steamid'])['pans'] == 1){ ?>
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
                                <?php if(GetPanelUserSteam($_SESSION['steamid'])['pane'] == 1){ ?><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#player_note_add">Notiz erstellen</button><?php } ?>
                            </div>
                            <!-- /.tab-pane -->
                            <?php } ?>

                            <?php if(GetPanelUserSteam($_SESSION['steamid'])['par'] == 1){ ?>
                            <div class="tab-pane" id="permissions">
                                <div class="box box-solid">

                                    <div class="box-body">
                                        <?php
                                            $rechte = GetRights($_GET['id']);
                                            function RightStatus($value){
                                                if($value == 0){
                                                    echo "btn-danger";
                                                }else{
                                                    echo "btn-success";
                                                }
                                            }
                                            $PanelUser = GetPanelUserSteam($player['pid']);

                                            /* <?php RightStatus($rechte['']['']); ?> */
                                        ?> 
                                        <div class="col-md-4">
                                            <h1>Spieler</h1>
                                            <div class="col-md-6">
                                                <button onclick="SwitchPermission(this, 'ps')" class="btn <?php RightStatus($PanelUser['ps']); ?> btn-block">Spieler Anschauen</button></br>
                                                <button onclick="SwitchPermission(this, 'vs')" class="btn <?php RightStatus($PanelUser['vs']); ?> btn-block">Fahrzeuge Anschauen</button></br>
                                                <button onclick="SwitchPermission(this, 'hs')" class="btn <?php RightStatus($PanelUser['hs']); ?> btn-block">Häuser Anschauen</button></br>
                                                <button onclick="SwitchPermission(this, 'gs')" class="btn <?php RightStatus($PanelUser['gs']); ?> btn-block">Gangs Anschauen</button></br>
                                                <button onclick="SwitchPermission(this, 'ls')" class="btn <?php RightStatus($PanelUser['ls']); ?> btn-block">Lizenzen Anschauen</button></br>
                                                <button onclick="SwitchPermission(this, 'pans')" class="btn <?php RightStatus($PanelUser['pans']); ?> btn-block">Notizen Anschauen</button></br>
                                            </div>
                                            <div class="col-md-6">
                                                <button onclick="SwitchPermission(this, 'pe')" class="btn <?php RightStatus($PanelUser['pe']); ?> btn-block">Spieler Bearbeiten</button></br>
                                                <button onclick="SwitchPermission(this, 've')" class="btn <?php RightStatus($PanelUser['ve']); ?> btn-block">Fahrzeuge Bearbeiten</button></br>
                                                <button disabled onclick="SwitchPermission(this, 'he')" class="btn <?php RightStatus($PanelUser['he']); ?> btn-block">Häuser Bearbeiten</button></br>
                                                <button disabled onclick="SwitchPermission(this, 'ge')" class="btn <?php RightStatus($PanelUser['ge']); ?> btn-block">Gangs Bearbeiten</button></br>
                                                <button onclick="SwitchPermission(this, 'le')" class="btn <?php RightStatus($PanelUser['le']); ?> btn-block">Lizenzen Bearbeiten</button></br>
                                                <button onclick="SwitchPermission(this, 'pane')" class="btn <?php RightStatus($PanelUser['pane']); ?> btn-block">Notizen Bearbeiten</button></br>
                                            </div>

                                        </div>
                                        <div class="col-md-4">
                                            <h1>Whitelistung Fraktionen</h1>
                                            <button onclick="SwitchPermission(this, 'wc', '')" class="btn <?php RightStatus($PanelUser['wc']); ?> btn-block">Polizei</button></br>
                                            <button onclick="SwitchPermission(this, 'wm')" class="btn <?php RightStatus($PanelUser['wm']); ?> btn-block">EMS</button></br>
                                        </div>
                                        <div class="col-md-4">
                                            <h1>Panel</h1>
                                            <button onclick="SwitchPermission(this, 'par')" class="btn <?php RightStatus($PanelUser['par']); ?> btn-block">Rechte</button></br>
                                            <button onclick="SwitchPermission(this, 'pas')" class="btn <?php RightStatus($PanelUser['pas']); ?> btn-block">Panel Support</button></br>
                                            <button onclick="SwitchPermission(this, 'plog')" class="btn <?php RightStatus($PanelUser['plog']); ?> btn-block">Panel Logs</button></br>
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

<?php if(GetPanelUserSteam($_SESSION['steamid'])['pe'] == 1){ ?>
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
                        <?php
                        foreach(range(0, cop_ranks) as $rank){
                            if($player['coplevel'] == $rank){
                                echo '<option value="'.$rank.'" selected>'.$rank.'</option>';
                            }else{
                                echo '<option value="'.$rank.'">'.$rank.'</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Medic Level</label>
                    <select id="usermedic" class="form-control">
                        <?php
                        foreach(range(0, medic_ranks) as $rank){
                            if($player['mediclevel'] == $rank){
                                echo '<option value="'.$rank.'" selected>'.$rank.'</option>';
                            }else{
                                echo '<option value="'.$rank.'">'.$rank.'</option>';
                            }
                        }
                        ?>
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
<?php if(GetPanelUserSteam($_SESSION['steamid'])['pane'] == 1){ ?>
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
        <?php if(GetPanelUserSteam($_SESSION['steamid'])['ve'] == 1){ ?>
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

    function SwitchLicense(btn, lic, type){
        <?php if(GetPanelUserSteam($_SESSION['steamid'])['le'] == 1){ ?>
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
        <?php if(GetPanelUserSteam($_SESSION['steamid'])['pane'] == 1){ ?>
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

    <?php if(GetPanelUserSteam($_SESSION['steamid'])['par'] == 1){ ?>
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
