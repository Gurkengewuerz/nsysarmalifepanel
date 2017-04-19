<?php if(isset($access)){if(!$access == true){exit;}}else{exit;} ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include("menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Spielerliste
                <small>Support</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="?page=support_dashboard"><i class="fa fa-dashboard"></i> Support</a></li>
                <li class="active">Spielerliste</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Spielerliste</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="datatable" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>IP</th>
                                    <th>Ping</th>
                                    <th>GUID</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $rcondata = GetRCONData();
                                $rconstring = json_decode($rcondata['stringdata'], true);
                                foreach ($rconstring as $row) {
                                ?>
                                <tr>
                                    <td><?php echo $row[0]; ?></td>
                                    <td><?php echo $row[4]; ?></td>
                                    <td><?php echo explode(":", $row[1])[0]; ?></td>
                                    <td><?php echo $row[2]; ?></td>
                                    <td><?php echo $row[3]; ?></td>
                                    <td><button onclick="Kick(<?php echo $row[0]; ?>)" class="btn btn-warning btn-xs">Kick</button> <button onclick="Ban(<?php echo $row[0]; ?>)" class="btn btn-danger btn-xs">Ban</button></td>
                                </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <span class="badge">Zuletzt akutalisiert: <?php echo date("d.m.Y - H:i", $rcondata['timestampdate']);?> Uhr und <?php echo date("s", $rcondata['timestampdate']);?> Sekunden</span>
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
<?php include("foot.php"); ?>
</div>
<!-- ./wrapper -->

<script type="application/javascript">
    function Kick(id){

    }
    function Ban(id){

    }
</script>
