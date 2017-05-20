<?php if(isset($access)){if(!$access == true){exit;}}else{exit;}
if(!$_SESSION['permission']['view_vehicle'] == 1){header("Location: ?page=support_dashboard"); exit;}
?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include("menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Fahrzeugliste
                <small>Support</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="?page=support_dashboard"><i class="fa fa-dashboard"></i> Support</a></li>
                <li class="active">Fahrzeugliste</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content animated fadeIn">
            <div class="row">
                <div class="col-md-12">

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Fahrzeugliste</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="datatable" class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr>
                                    <th>Besitzer</th>
                                    <th>Klasse</th>
                                    <th>Typ</th>
                                    <th>Fraktion</th>
                                    <th>Kennzeichen</th>
                                    <th>Status</th>
                                    <th>Garage</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sql = "SELECT * FROM vehicles";
                                foreach ($pdo->query($sql) as $row) {
                                    $owner = GetPlayer($row['pid']);
                                ?>
                                <tr>
                                    <td><a href="?page=support_player&id=<?php echo $owner['uid']; ?>"><?php echo utf8_encode($owner['name']); ?></a></td>
                                    <td><?php echo ParseVehicleName($row['classname']); ?></td>
                                    <td><?php echo $row['type']." ".ParseVehicleTyp($row['type']); ?></td>
                                    <td><?php echo ParseSide($row['side']); ?></td>
                                    <td><?php echo $row['plate']; ?></td>
                                    <td id="vehstat<?php echo $row['id']; ?>"><?php if($row['alive'] == 1){echo '<button onclick="RepairVehicle('.$row['id'].', 0)" class="btn btn-success btn-xs">Ganz</button>';}else{echo '<button onclick="RepairVehicle('.$row['id'].', 1)" class="btn btn-danger btn-xs">Zerstört</button>';} ?></td>
                                    <td id="vehgar<?php echo $row['id']; ?>"><?php if($row['active'] == 1){echo '<button onclick="GarageVehicle('.$row['id'].', 0)" class="btn btn-warning btn-xs">Ausgeparkt</button>';}else{echo '<button onclick="GarageVehicle('.$row['id'].', 1)" class="btn btn-success btn-xs">Eingeparkt</button>';} ?></td>
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

<script type="application/javascript">
    function RepairVehicle(id, status){
        <?php if($_SESSION['permission']['edit_vehicle'] == 1){ ?>
        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: {
                'javadata': 'support_vehicle_repair',
                'status': status,
                'id': id
            },
            success: function(){
                //alert(data);
                if(status == 1){
                    $("#vehstat" + id).html('<button onclick="RepairVehicle(' + id + ', 0)" class="btn btn-success btn-xs">Ganz</button>');
                }else{
                    $("#vehstat" + id).html('<button onclick="RepairVehicle(' + id + ', 1)" class="btn btn-danger btn-xs">Zerstört</button>');
                }
            }
        });
        <?php } ?>
    }
    function GarageVehicle(id, status){
        <?php if($_SESSION['permission']['edit_vehicle'] == 1){ ?>
        $.ajax({
            type: 'POST',
            url: 'index.php',
            data: {
                'javadata': 'support_vehicle_garage',
                'status': status,
                'id': id
            },
            success: function(){
                //alert(data);
                if(status == 1){
                    $("#vehgar" + id).html('<button onclick="GarageVehicle(' + id + ', 0)" class="btn btn-warning btn-xs">Ausgeparkt</button>');
                }else{
                    $("#vehgar" + id).html('<button onclick="GarageVehicle(' + id + ', 1)" class="btn btn-success btn-xs">Eingeparkt</button>');
                }
            }
        });
        <?php } ?>
    }
</script>