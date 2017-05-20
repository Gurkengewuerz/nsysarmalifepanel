<?php if(isset($access)){if(!$access == true){exit;}}else{exit;}
if(!isset($_SESSION['permission']['view_house']) && $_SESSION['permission']['view_house'] == 1){header("Location: ?page=support_dashboard"); exit;}
if(!isset($_GET['id']) or $_GET['id'] == ""){header("Location: ?page=support_houses"); exit;}
$container = GetContainer($_GET['id']);
?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include("menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Behälter
                <small>Support</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="?page=support_dashboard"><i class="fa fa-dashboard"></i> Support</a></li>
                <li><a href="?page=support_houses">Häuserliste</a></li>
                <li class="active">Behälter</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content animated fadeIn">
            <div class="row">
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <ul class="list-group list-group-unbordered">
                                <li class="list-group-item">
                                    <b>Besitzer</b> <a class="pull-right"><?php echo GetPlayer($container['pid'])['name']; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Kiste</b> <a class="pull-right"><?php echo $container['classname']; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Position</b> <a class="pull-right"><?php echo $container['pos']; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Aktiv</b> <a class="pull-right"><?php if($container['active'] == 1){echo "Aktiv";}else{echo "Inaktiv";} ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>In Besitz</b> <a class="pull-right"><?php if($container['owned'] == 1){echo "Ja";}else{echo "Nein";} ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Erstellt am</b> <a class="pull-right"><?php echo $container['insert_time']; ?></a>
                                </li>

                            </ul>
                            <a class="btn btn-primary btn-block" href="?page=support_player&id=<?php echo GetPlayer($container['pid'])['uid']; ?>">Besitzer anzeigen</a>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-md-9">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#vinventory" data-toggle="tab" aria-expanded="false">Virtuelles Inventar</a></li>
                            <li class=""><a href="#inventory" data-toggle="tab" aria-expanded="true">Inventar</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="inventory">
                                <b>Inventar</b>
                                <div class="well">
                                    <?php echo $container['gear']; ?>
                                </div>
                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane active" id="vinventory">

                                <b>Virtuelles Inventar</b>
                                <div class="well">
                                    <?php echo $container['inventory']; ?>
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


<script type="application/javascript">
    function SavePlayer(){
        $("#player_edit").modal("hide");

        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: {
                'javadata': 'support_player_save_medic',
                'medic': $("#usermedic").val(),
                'id': '<?php echo $player['uid']; ?>'
            },
            success: function(data){
                //alert(data);
                $("#anzeigemedic").html($("#usermedic").val());
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
