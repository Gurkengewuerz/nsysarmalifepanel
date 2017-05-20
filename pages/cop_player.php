<?php if(isset($access)){if(!$access == true){exit;}}else{exit;}
if(!isset($_GET['id']) or $_GET['id'] == "" or ExistPlayerByUID($_GET['id']) == 0){header("Location: ?page=cop_players"); exit;}else{
    if(!isset($_SESSION['permission']['whitelist_cop']) && $_SESSION['permission']['whitelist_cop'] == 1){header("Location: ?page=cop_dashboard"); exit;}
    $player = GetPlayerByUID($_GET['id']);
    if(CheckSteamID($player['pid']) == 0){
        InsertSteamID($player['pid']);
    }
    if(!$player['mediclevel'] == 0 or $player['coplevel'] == 1 or $player['coplevel'] == 2){header("Location: ?page=cop_players"); exit;}
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
                <small>Polizei</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="?page=cop_dashboard"><i class="fa fa-dashboard"></i> Polizei</a></li>
                <li><a href="?page=cop_players">Spielerliste</a></li>
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
                                    <b>Cop Level</b> <a class="pull-right" id="anzeigecop"><?php echo $player['coplevel'] - 2; ?></a>
                                </li>
                            </ul>
                            <?php if(isset($_SESSION['permission']['whitelist_medic']) && $_SESSION['permission']['whitelist_medic'] == 1){ ?><button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#player_edit">Bearbeiten</button><?php } ?>
                            <a class="btn btn-default btn-block" href="http://steamcommunity.com/profiles/<?php echo $player['pid']; ?>" target="_blank">Steam Profil öffnen</a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#inventory" data-toggle="tab" aria-expanded="false">Inventar</a></li>
                            <li class=""><a href="#licenses" data-toggle="tab" aria-expanded="true">Lizenzen</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="licenses">
                                <b>Polizei</b>
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
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane active" id="inventory">

                                <b>Polizei</b>
                                <div class="well">
                                    <?php echo $player['cop_gear']; ?>
                                </div>
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Schließen</button>
                <button type="button" onclick="SavePlayer()" class="btn btn-primary">Speichern</button>
            </div>
        </div>
    </div>
</div>


<script type="application/javascript">
    function SavePlayer(){
        $("#player_edit").modal("hide");

        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: {
                'javadata': 'support_player_save_cop',
                'cop': $("#usercop").val(),
                'id': '<?php echo $player['uid']; ?>'
            },
            success: function(data){
                //alert(data);
                $("#anzeigecop").html($("#usercop").val() - 2);
            }
        });
    }


    function SwitchLicense(btn, lic, type){
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
    }

</script>
