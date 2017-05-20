<?php if(isset($access)){if(!$access == true){exit;}}else{exit;}
if(!isset($_SESSION['permission']['view_house']) && $_SESSION['permission']['view_house'] == 1){header("Location: ?page=support_dashboard"); exit;}
if(!isset($_GET['pid']) OR $_GET['pid'] == ""){header("Location: ?page=support_houses"); exit;}
?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include("menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Behälterliste
                <small>Support</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="?page=support_dashboard"><i class="fa fa-dashboard"></i> Support</a></li>
                <li class="active">Behälterliste</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content animated fadeIn">
            <div class="row">
                <div class="col-md-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Behälterliste</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="datatable" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Besitzer</th>
                                    <th>Position</th>
                                    <th>Aktiv</th>
                                    <th>In Besitz</th>
                                    <th>Inhalt</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql = "SELECT * FROM containers WHERE pid = ?";
                                $statement = $pdo->prepare($sql);
                                $statement->execute(array($_GET['pid']));
                                while($row = $statement->fetch()) {
                                    $owner = GetPlayer($row['pid']);
                                ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><a href="?page=support_player&id=<?php echo $owner['uid']; ?>"><?php echo utf8_encode($owner['name']); ?></a></td>
                                    <td><?php echo $row['pos']; ?></td>
                                    <td><?php if($row['active'] == 1){echo '<span class="label label-success">Ja</span>';}else{echo '<span class="label label-danger">Nein</span>';} ?></td>
                                    <td><?php if($row['owned'] == 1){echo '<span class="label label-success">Ja</span>';}else{echo '<span class="label label-danger">Nein</span>';} ?></td>
                                    <td><a href="?page=support_container&id=<?php echo $row['id']; ?>" class="btn btn-primary btn-xs">Anzeigen</a></td>
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
