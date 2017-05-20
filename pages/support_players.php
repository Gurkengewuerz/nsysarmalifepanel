<?php if(isset($access)){if(!$access == true){exit;}}else{exit;}
if(!$_SESSION['permission']['view_player'] == 1){header("Location: ?page=support_dashboard"); exit;}
?>
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
        <section class="content animated fadeIn">
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
                                    <th>PlayerID</th>
                                    <th>Fraktion</th>
                                    <th>Bargeld</th>
                                    <th>Bank</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql = "SELECT * FROM players";
                                foreach ($pdo->query($sql) as $row) {
                                    if($row['coplevel'] >= 1){
                                        $frakspan = '<span class="label label-primary">Cop ('.($row['coplevel'] - 2).')</span>';
                                    }elseif($row['mediclevel'] >= 1){
                                        $frakspan = '<span class="label label-danger">EMS ('.$row['mediclevel'].')</span>';
                                    }else{
                                        $frakspan = '<span class="label label-default">Keine</span>';
                                    }
                                ?>
                                <tr>
                                    <td><?php echo $row['uid']; ?></td>
                                    <td><a href="?page=support_player&id=<?php echo $row['uid']; ?>"><?php echo utf8_encode($row['name']); ?></a></td>
                                    <td><?php echo $row['pid']; ?></td>
                                    <td><?php echo $frakspan; ?></td>
                                    <td><?php echo $row['cash']; ?></td>
                                    <td><?php echo $row['bankacc']; ?></td>
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
