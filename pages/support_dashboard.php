<?php if(isset($access)){if(!$access == true){exit;}}else{exit;} ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include("menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Support</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><i class="fa fa-dashboard"></i> Support</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content animated fadeIn">

            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>
                                <?php
                                $sql = "SELECT * FROM players ORDER BY insert_time DESC LIMIT 1";
                                $statement = $pdo->prepare($sql);
                                $statement->execute(array());
                                $pdash = $statement->fetch();
                                echo utf8_encode($pdash['name']);
                                ?>
                            </h3>

                            <p>Neuster Spieler</p>
                        </div>

                        <a href="?page=support_player&id=<?php echo $pdash['uid']; ?>" class="small-box-footer">
                            Anzeigen <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>
                                <?php
                                $statement = $pdo->prepare("SELECT COUNT(*) AS count FROM players");
                                $statement->execute(array());
                                $rowcount = $statement->fetch();
                                echo $rowcount['count'];
                                ?>
                            </h3>

                            <p>Spieler insgesamt</p>
                        </div>
                        <a href="?page=support_players" class="small-box-footer">
                            Anzeigen <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>
                                <?php
                                $statement = $pdo->prepare("SELECT COUNT(*) AS count FROM vehicles");
                                $statement->execute(array());
                                $rowcount = $statement->fetch();
                                echo $rowcount['count'];
                                ?>
                            </h3>

                            <p>Fahrzeuge insgesamt</p>
                        </div>
                        <a href="?page=support_vehicles" class="small-box-footer">
                            Anzeigen <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>
                                <?php
                                $statement = $pdo->prepare("SELECT COUNT(*) AS count FROM houses");
                                $statement->execute(array());
                                $rowcount = $statement->fetch();
                                echo $rowcount['count'];
                                ?>
                            </h3>

                            <p>Häuser in Besitz</p>
                        </div>

                        <a href="?page=support_houses" class="small-box-footer">
                            Anzeigen <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                Top 5 Bargeld
                            </h4>
                        </div>
                        <div class="box-body">
                            <table class="table table-hover">
                                <?php $rank = 0; ?>
                                <thead>
                                    <th>Platz</th>
                                    <th>Name</th>
                                    <th>Geld</th>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = "SELECT * FROM players ORDER BY cash DESC LIMIT 5";
                                    foreach ($pdo->query($sql) as $row) {
                                        $rank = $rank + 1;
                                        echo '<tr>';
                                        echo '<td>'.$rank.'</td>';
                                        echo '<td><a href="?page=support_player&id='.$row['uid'].'">'.utf8_encode($row['name']).'</a></td>';
                                        echo '<td>'.number_format($row['cash'], 0, ",", ".").' $</td>';
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                Top 5 Bankkonto
                            </h4>
                        </div>
                        <div class="box-body">
                            <table class="table table-hover">
                                <?php $rank = 0; ?>
                                <thead>
                                <th>Platz</th>
                                <th>Name</th>
                                <th>Geld</th>
                                </thead>
                                <tbody>
                                <?php
                                $sql = "SELECT * FROM players ORDER BY bankacc DESC LIMIT 5";
                                foreach ($pdo->query($sql) as $row) {
                                    $rank = $rank + 1;
                                    echo '<tr>';
                                    echo '<td>'.$rank.'</td>';
                                    echo '<td><a href="?page=support_player&id='.$row['uid'].'">'.utf8_encode($row['name']).'</a></td>';
                                    echo '<td>'.number_format($row['bankacc'], 0, ",", ".").' $</td>';
                                    echo '</tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
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