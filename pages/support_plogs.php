<?php if(isset($access)){if(!$access == true){exit;}}else{exit;}
if(!GetPanelUserSteam($_SESSION['steamid'])['plog'] == 1){header("Location: ?page=support_dashboard"); exit;}
?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include("menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Panel Logliste
                <small>Support</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="?page=support_dashboard"><i class="fa fa-dashboard"></i> Support</a></li>
                <li class="active">Panel Logliste</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content animated fadeIn">
            <div class="row">
                <div class="col-md-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Panel Logliste</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="datatable" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Benutzer</th>
                                    <th>Typ</th>
                                    <th>Log-Nachricht</th>
                                    <th>Datum</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql = "SELECT * FROM panel_logs";
                                function GetLogType($type){
                                    switch($type){
                                        case 1:
                                            // Spieler Edit
                                            $return = '<span class="label label-primary">Player Edit</span>';
                                            break;
                                        case 2:
                                            // Fahrzeug Status
                                            $return = '<span class="label label-warning">Fahrzeug Edit</span>';
                                            break;
                                        case 3:
                                            // Lizenz Status
                                            $return = '<span class="label label-info">Lizenz Edit</span>';
                                            break;
                                    }
                                    return $return;
                                }
                                foreach ($pdo->query($sql) as $row) {
                                    $owner = GetPlayerByUID($row['user']);
                                ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><a href="?page=support_player&id=<?php echo $owner['uid']; ?>"><?php echo utf8_encode($owner['name']); ?></a></td>
                                    <td><?php echo GetLogType($row['typ']); ?></td>
                                    <td><?php echo $row['msg']; ?></td>
                                    <td><?php echo date("d.m.Y - H:i", $row['datetime'])." Uhr"; ?></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->

                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- modal -->
    <div class="modal fade modal-primary" id="log_show" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Log anschauen</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Schließen</button>
                </div>
            </div>
        </div>
    </div>
<?php include("foot.php"); ?>
</div>
<!-- ./wrapper -->
