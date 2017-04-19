<?php if(isset($access)){if(!$access == true){exit;}}else{exit;} ?>
<body class="hold-transition skin-red sidebar-mini">
<div class="wrapper">

    <?php include("menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>EMS</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content animated fadeIn">

            <div class="row">
                <div class="col-md-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h4 class="box-title">
                                Fraktionsmitglieder
                            </h4>
                        </div>
                        <div class="box-body">
                            <table class="table table-hover">
                                <thead>
                                <th>Name</th>
                                <th>Rang</th>
                                </thead>
                                <tbody>
                                <?php
                                $sql = "SELECT * FROM players WHERE mediclevel >= '1' ORDER BY mediclevel DESC";
                                foreach ($pdo->query($sql) as $row) {
                                    echo '<tr>';
                                    echo '<td>'.utf8_encode($row['name']).'</td>';
                                    echo '<td>'.$row['mediclevel'].'</td>';
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