<?php if(isset($access)){if(!$access == true){exit;}}else{exit;}
if(!$_SESSION['permission']['view_house'] == 1){header("Location: ?page=support_dashboard"); exit;}
?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include("menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Hausliste
                <small>Support</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="?page=support_dashboard"><i class="fa fa-dashboard"></i> Support</a></li>
                <li class="active">Hausliste</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content animated fadeIn">
            <div class="row">
                <div class="col-md-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Hausliste</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="datatable" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Besitzer</th>
                                    <th>Position</th>
                                    <th>In Besitz</th>
                                    <th>Garage</th>
                                    <th>Behälter</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql = "SELECT * FROM houses";
                                foreach ($pdo->query($sql) as $row) {
                                    $owner = GetPlayer($row['pid']);
                                ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><a href="?page=support_player&id=<?php echo $owner['uid']; ?>"><?php echo utf8_encode($owner['name']); ?></a></td>
                                    <td><?php echo $row['pos']; ?></td>
                                    <td><?php if($row['owned'] == 1){echo '<span class="label label-success">Ja</span>';}else{echo '<span class="label label-danger">Nein</span>';} ?></td>
                                    <td><?php if($row['garage'] == 1){echo '<span class="label label-success">Ja</span>';}else{echo '<span class="label label-danger">Nein</span>';} ?></td>
                                    <td><a href="?page=support_containers&pid=<?php echo $row['pid']; ?>" class="btn btn-primary btn-xs">Anzeigen</a></td>
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
