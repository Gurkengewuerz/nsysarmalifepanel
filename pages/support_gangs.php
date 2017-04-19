<?php if(isset($access)){if(!$access == true){exit;}}else{exit;}
if(!GetPanelUserSteam($_SESSION['steamid'])['gs'] == 1){header("Location: ?page=support_dashboard"); exit;}
?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include("menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Gangliste
                <small>Support</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="?page=support_dashboard"><i class="fa fa-dashboard"></i> Support</a></li>
                <li class="active">Gangliste</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content animated fadeIn">
            <div class="row">
                <div class="col-md-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Gangliste</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="datatable" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Leiter</th>
                                    <th>Mitglieder</th>
                                    <th>Geld</th>
                                    <th>Aktiv</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql = "SELECT * FROM gangs";
                                foreach ($pdo->query($sql) as $row) {
                                    $owner = GetPlayer($row['owner']);
                                    $member = explode("," ,str_replace("[", "", str_replace("`", "", str_replace("]", "", str_replace('"', "", $row['members'])))));
                                ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo utf8_encode($row['name']); ?> <span class="badge">Slots <?php echo $row['maxmembers']; ?></span></td>
                                    <td><a href="?page=support_player&id=<?php echo $owner['uid']; ?>"><?php echo utf8_encode($owner['name']); ?></a></td>
                                    <td><?php foreach($member as $pers){echo '<a href="?page=support_player&id='.GetPlayer($pers)['uid'].'">'.utf8_encode(GetPlayer($pers)['name']).'</a>, ';}  ?></td>
                                    <td><?php echo $row['bank']; ?> $</td>
                                    <td><?php if($row['active'] == 1){echo '<span class="label label-success">Aktiv</span>';}else{echo '<span class="label label-danger">Inaktiv</span>';} ?></td>
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
