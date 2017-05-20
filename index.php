<?php
if (!isset($_POST['javadata'])) {
    ?>
    <!DOCTYPE html>
    <html lang="de">
    <?php
}
require_once("core/header.php");

if (!isset($_SESSION['steamid'])) {
    $page_title = "Bitte melde dich an..";
} else {
    $page_title = site_name . " Panel";
    include_once('steamauth/userInfo.php');
    if (!isset($_SESSION['online'])) {
        if (CheckSteamID($steamprofile['steamid']) == 0) {
            InsertSteamID($steamprofile['steamid']);
            $_SESSION['user'] = GetSteamIDUser($steamprofile['steamid']);
            $_SESSION['uid'] = GetPlayer($steamprofile['steamid'])['uid'];
            $_SESSION['name'] = GetPlayer($steamprofile['steamid'])['name'];
            $_SESSION['online'] = 1;
        } else {
            $_SESSION['user'] = GetSteamIDUser($steamprofile['steamid']);
            $_SESSION['uid'] = GetPlayer($steamprofile['steamid'])['uid'];
            $_SESSION['name'] = GetPlayer($steamprofile['steamid'])['name'];
            $_SESSION['online'] = 1;
        }
        $_SESSION['permission'] = array();
        foreach (GetPermission($_SESSION['steamid']) as $perm) {
            $_SESSION['permission'][$perm["permission"]] = $perm["val"];
        }
    }
    if (ExistPlayer($_SESSION['steamid']) == 0) {
        session_unset();
        session_destroy();
        session_start();
    }
}


if (!isset($_SESSION['steamid'])) {
    echo "<body class='login-page animated bounceInDown login-page'>";
    echo '
    <div class="login-box">
  
  <!-- /.login-logo -->
  <div class="login-box-body text-center">
    <div class="login-logo">
    ' . site_name . '
  </div>';

    if (!isset($mysql_connect)) {
        echo '<p class="login-box-msg">Melde dich mit Steam an</p>

    ';
        echo loginbutton();
    } else {
        echo '<label>MySQL Fehler</label><div class="alert alert-danger" role="alert">' . $mysql_msg . '</div>';
    }
    echo '

  </div>
  <!-- /.login-box-body -->
</div>
    
    
    ';
    echo "</body>";
} else {
    $player = GetPlayer($_SESSION['steamid']);

    if (!isset($_GET['page'])) {
        if ($_SESSION['permission']['panel_support'] == 1) {
            // Support Dashboard
            $access = true;
            $_GET['page'] = "support_dashboard";
            include("pages/support_dashboard.php");
        } elseif ($player['coplevel'] >= 1) {
            // Cop Dashboard
            $access = true;
            $_GET['page'] = "cop_dashboard";
            include("pages/cop_dashboard.php");
        } elseif ($player['mediclevel'] >= 1) {
            // Medic / FD Dashboard
            $access = true;
            $_GET['page'] = "medic_dashboard";
            include("pages/medic_dashboard.php");
        } else {
            $access = true;
            $_GET['page'] = "ziv_player";
            include("pages/ziv_player.php");
        }
    } else {
        $loadpage = explode("_", $_GET['page']);
        $access = false;
        switch ($loadpage[0]) {
            case "cop":
                if ($player['coplevel'] >= 3) {
                    // Cop Seite
                    $access = true;
                } else {
                    $access = false;
                }
                break;

            case "medic":
                if ($player['mediclevel'] >= 1) {
                    // Medic / FD Dashboard
                    $access = true;
                } else {
                    $access = false;
                }
                break;

            case "support":
                if ($_SESSION['permission']['panel_support'] == 1) {
                    // Support Seite
                    $access = true;
                } else {
                    $access = false;
                }
                break;
            case "ziv":
                $access = true;
                break;
            default:

                break;
        }
        if ($access == true) {
            if (file_exists("pages/" . $_GET['page'] . ".php")) {
                include("pages/" . $_GET['page'] . ".php");
            } else {
                $access = true;
                include("pages/error.php");
            }
        } else {
            $access = true;
            include("pages/error.php");
        }

    }

    //print_r(GetRights($steamprofile['steamid']));


}
?>

<?php require_once("core/footer.php"); ?>
    </body>
<?php
if (!isset($_POST['javadata'])) {
    ?>
    </html>
    <?php
}
