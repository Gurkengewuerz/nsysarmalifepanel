<?php if(isset($access)){if(!$access == true){exit;}}else{exit;}
?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include("menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Mitglieder
                <small>Polizei</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="?page=medic_dashboard"><i class="fa fa-dashboard"></i> Polizei</a></li>
                <li class="active">Mitglieder</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content animated fadeIn">
            <div class="row">
                <div class="col-md-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Mitgliederliste</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">




                            <table id="datatable" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Funk Nummer</th>
                                    <th>Name des Beamten</th>
                                    <th>Rang</th>
                                    <th>Department</th>
                                    <th>Aktiv</th>
                                    <th>S.E.R.T</th>
                                    <th>Ausbilder</th>
                                    <th>Bemerkung</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql = "SELECT * FROM policeuser";
                                foreach ($pdo->query($sql) as $row) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['nr']; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['rang']; ?></td>
                                        <td><?php echo $row['dep']; ?></td>
                                        <td><?php echo $row['aktiv']; ?></td>
                                        <td><?php echo $row['sert']; ?></td>
                                        <td><?php echo $row['ausbilder']; ?></td>
                                        <td><?php echo $row['bemerkung']; ?></td>
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
    <?php include("foot.php"); ?>
</div>
<!-- ./wrapper -->
