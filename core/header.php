<?php
require_once ("head.php");


if(isset($_SESSION['steamid'])) {
    if(isset($_POST['javadata'])){
        switch($_POST['javadata']){
            case "support_player_save_general":
                $tplayer = GetPlayerByUID($_POST['id']);
                $logmsg = "Spieler-ID: ".$_POST['id']." // 
                Bargeld: ".$tplayer['cash']." -> ".$_POST['bargeld']." // 
                Bank: ".$tplayer['bankacc']." -> ".$_POST['bank']." // 
                Admin: ".$tplayer['adminlevel']." -> ".$_POST['admin']." // 
                CopLvl: ".$tplayer['coplevel']." -> ".$_POST['cop']." // 
                MedLvl: ".$tplayer['mediclevel']." -> ".$_POST['medic'];

                AddLog($_SESSION['uid'], 1, $logmsg);
                echo SaveGeneralPlayer($_POST['id'], $_POST['bargeld'], $_POST['bank'], $_POST['admin'], $_POST['cop'], $_POST['medic']);
                break;
            case "support_vehicle_repair":
                if($_POST['status'] == 0){$logstat = 1;}else{$logstat = 0;}
                $logmsg = "Fahrzeug-ID: ".$_POST['id']." // Status: ".$logstat." -> ".$_POST['status'];
                AddLog($_SESSION['uid'], 2, $logmsg);
                SetVehicleStatus($_POST['id'], $_POST['status']);
                break;
            case "support_vehicle_garage":
                if($_POST['status'] == 0){$logstat = 1;}else{$logstat = 0;}
                $logmsg = "Fahrzeug-ID: ".$_POST['id']." // Garage: ".$logstat." -> ".$_POST['status'];
                AddLog($_SESSION['uid'], 2, $logmsg);
                SetVehicleGarage($_POST['id'], $_POST['status']);
                break;
            case "support_license":
                SwitchLicenseByID($_POST['id'], $_POST['type'], $_POST['lic']);
                break;
            case "support_note_add":
                print_r(AddNoteToUser($_POST['id'], $_SESSION['uid'], $_POST['content']));
                break;
            case "support_right":
                UpdateRight($_POST['pid'], $_POST['field1'], $_POST['field2']);
                break;
            case "support_player_save_medic":
                echo SaveMedicPlayer($_POST['id'], $_POST['medic']);
                break;
            case "support_player_save_cop":
                echo SaveCopPlayer($_POST['id'], $_POST['cop']);
                break;
        }
        exit;
    }
}




if(!isset($page_title)){$ptitle = site_name;}else{$ptitle = $page_title;}
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $ptitle; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">


    <link rel="stylesheet" href="dist/css/animate.css">
    <link rel="stylesheet" href="bootstrap/css/main.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
