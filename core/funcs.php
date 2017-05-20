<?php
use \Nizarii\ARC;
function GetServerOnlinePlayers(){
    $rcon = new ARC(server_ip, server_rcon_pw, 2309, [
        'timeoutSec' => 2
    ]);

    return $rcon->getPlayersArray();
}

function CheckSteamID($steamid){
    global $pdo;
    $statement = $pdo->prepare("SELECT COUNT(*) AS count FROM panel_user WHERE sid = :sid");
    $statement->execute(array('sid' => $steamid));
    $rowcount = $statement->fetch();
    return $rowcount['count'];
}

function ExistPlayer($steamid){
    global $pdo;
    $statement = $pdo->prepare("SELECT COUNT(*) AS count FROM players WHERE pid = :sid");
    $statement->execute(array('sid' => $steamid));
    $rowcount = $statement->fetch();
    if($rowcount['count'] == 1){
        return 1;
    }else {
        return 0;
    }
}

function ExistPlayerByUID($uid){
    global $pdo;
    $statement = $pdo->prepare("SELECT COUNT(*) AS count FROM players WHERE uid = :sid");
    $statement->execute(array('sid' => $uid));
    $rowcount = $statement->fetch();
    if($rowcount['count'] == 1){
        return 1;
    }else {
        return 0;
    }
}

function GetSteamIDUser($steamid){
    global $pdo;
    $sql = "SELECT * FROM panel_user WHERE sid = :sid LIMIT 1";
    $statement = $pdo->prepare($sql);
    $statement->execute(array('sid' => $steamid));
    return $statement->fetch();
}

function GetContainer($id){
    global $pdo;
    $sql = "SELECT * FROM containers WHERE id = :id LIMIT 1";
    $statement = $pdo->prepare($sql);
    $statement->execute(array('id' => $id));
    return $statement->fetch();
}

function GetPlayer($steamid){
    global $pdo;
    $sql = "SELECT * FROM players WHERE pid = :sid LIMIT 1";
    $statement = $pdo->prepare($sql);
    $statement->execute(array('sid' => $steamid));
    return $statement->fetch();
}

function GetPlayerByUID($uid){
    global $pdo;
    $sql = "SELECT * FROM players WHERE uid = :sid LIMIT 1";
    $statement = $pdo->prepare($sql);
    $statement->execute(array('sid' => $uid));
    return $statement->fetch();
}

function GetPermission($id)
{
    global $pdo;
    $sql = "SELECT permission,val FROM panel_perms WHERE sid = :id";
    $statement = $pdo->prepare($sql);
    $statement->execute(array('id' => $id));
    return $statement->fetchall();
}

function GetPermissionByPanelUser($id)
{
    global $pdo;
    $sql = "SELECT permission,val FROM panel_perms WHERE sid = (SELECT pid FROM players WHERE uid = :id)";
    $statement = $pdo->prepare($sql);
    $statement->execute(array('id' => $id));
    return $statement->fetchall();
}

function UpdatePlayer($steamid, $field, $value){
    global $pdo;
    $statement = $pdo->prepare("UPDATE panel_user SET {$field} = :value WHERE sid = :sid LIMIT 1");
    $statement->execute(array('sid' => $steamid, 'value' => $value));
}

function UpdatePlayerByID($id, $field, $value){
    global $pdo;
    $statement = $pdo->prepare("UPDATE panel_user SET {$field} = :value WHERE uid = :uid LIMIT 1");

    if(!$statement->execute(array('uid' => $id, 'value' => $value))){
        return $statement->errorInfo();
        //print_r($statement->errorInfo());
    }
}


/************************************************
 ******       RCON Players Online      **********
 ************************************************/

function CheckRCONData(){
    $rcondata = GetRCONData();
    $timediff = time() - $rcondata['timestampdate'];
    if($timediff >= 60){
        UpdateRCONData(GetServerOnlinePlayers());
    }
}

function GetRCONData(){
    global $pdo;
    $sql = "SELECT * FROM serverlist WHERE id = 1 LIMIT 1";
    $statement = $pdo->prepare($sql);
    $statement->execute();
    return $statement->fetch();
}

function UpdateRCONData($data){
    global $pdo;
    $data = json_encode($data);
    $sql = "UPDATE serverlist SET stringdata = :stringdata, timestampdate = :timestampdate WHERE id = 1 LIMIT 1";
    $statement = $pdo->prepare($sql);
    $statement->execute(array('stringdata' => $data, 'timestampdate' => time()));
}

/************************************************
*************************************************/

function InsertSteamID($steamid){
    global $pdo;

    /*

    $rights[0]['name'] = "ps";// Player Show
    $rights[1]['name'] = "pe";// Player Edit
    $rights[2]['name'] = "vs";// Vehicles Show
    $rights[3]['name'] = "ve";// Vehicles Edit
    $rights[4]['name'] = "hs";// Houses Show
    $rights[5]['name'] = "he";// Houses Edit
    $rights[6]['name'] = "gs";// Gangs Show
    $rights[7]['name'] = "ge";// Gangs Edit
    $rights[8]['name'] = "ws";// Wanted Show
    $rights[9]['name'] = "we";// Wanted Edit
    $rights[10]['name'] = "ls";// Lic Show
    $rights[11]['name'] = "le";// Lic Edit
    $rights[12]['name'] = "me";// Money Edit
    $rights[13]['name'] = "ie";// Inventory Edit
    $rights[14]['name'] = "ae";// Admin Edit
    $rights[15]['name'] = "de";// Donor Edit
    $rights[16]['name'] = "wc";// Whitelist Cop
    $rights[17]['name'] = "wm";// Whitelist Medic
    $rights[18]['name'] = "wj";// Whitelist Justice
    $rights[19]['name'] = "pas";// Panel Support
    $rights[20]['name'] = "pal";// Panel Logs
    $rights[21]['name'] = "par";// Panel Rights
    $rights[22]['name'] = "pans";// Panel Notes Show
    $rights[23]['name'] = "pane";// Panel Notes Edit
    $rights[24]['name'] = "pabs";// Panel Bans Show
    $rights[25]['name'] = "pabe";// Panel Bans Edit
    $rights[26]['name'] = "pase";// Panel Settings Edit


    */
    $statement = $pdo->prepare("INSERT INTO panel_user (sid, locked, last_login) VALUES (:sid, :locked, :last_login)");
    if (!$statement->execute(array('sid' => $steamid, 'locked' => 0, 'last_login' => time()))) {
        //return $statement->errorInfo();
        //print_r($statement->errorInfo());
    }
}


function SupportSteamID($steamid){
    global $pdo;
    $statement = $pdo->prepare("SELECT COUNT(*) AS count FROM panel_user WHERE sid = :sid");
    $statement->execute(array('sid' => $steamid));
    $rowcount = $statement->fetch();
    if($rowcount['count'] == 0){
        $statement = $pdo->prepare("INSERT INTO panel_user (sid, locked, last_login) VALUES (:sid, :locked, :last_login)");
        if (!$statement->execute(array('sid' => $steamid, 'locked' => 0, 'last_login' => time()))) {
            error_log($statement->errorInfo());
            //return $statement->errorInfo();
            //print_r($statement->errorInfo());
        }
    }
}


function UpdateRight($steamid, $key, $val)
{
    global $pdo;
    $statement = $pdo->prepare("SELECT * FROM panel_perms WHERE sid = :sid AND permission = :permname LIMIT 1");
    $statement->execute(array('sid' => $steamid, 'permname' => $key));
    $result = $statement->fetchAll();

    if (count($result) > 0) {
        $sql = "UPDATE panel_perms SET val = :val WHERE sid = :sid AND permission = :permname";
    } else {
        $sql = "INSERT INTO panel_perms (sid, permission, val) VALUES (:sid, :permname, :val);";
    }

    $statement = $pdo->prepare($sql);
    if (!$statement->execute(array('sid' => $steamid, 'permname' => $key, 'val' => $val))) {
        return $statement->errorInfo();
        //print_r($statement->errorInfo());
    } else {
        return $sql . " // " . $steamid;
    }
}

function UpdateLoginTime($steamid){
    global $pdo;
    $statement = $pdo->prepare("UPDATE panel_user SET last_login = :last_login WHERE sid = :sid LIMIT 1");
    $statement->execute(array('sid' => $steamid, 'last_login' => time()));
}

function UpdateRights($steamid, $rightarray){
    global $pdo;
/*
    $rights['players']['show'] = $rightarray['players']['show'];
    $rights['players']['edit'] = $rightarray['players']['edit'];
    $rights['vehicles']['show'] = $rightarray['vehicles']['show'];
    $rights['vehicles']['edit'] = $rightarray['vehicles']['edit'];
    $rights['houses']['show'] = $rightarray['houses']['show'];
    $rights['houses']['edit'] = $rightarray['houses']['edit'];
    $rights['gangs']['show'] = $rightarray['gangs']['show'];
    $rights['gangs']['edit'] = $rightarray['gangs']['edit'];
    $rights['wanted']['show'] = $rightarray['wanted']['show'];
    $rights['wanted']['edit'] = $rightarray['wanted']['edit'];
    $rights['licenses']['show'] = $rightarray['licenses']['show'];
    $rights['licenses']['edit'] = $rightarray['licenses']['edit'];
    $rights['money']['edit'] = $rightarray['money']['edit'];
    $rights['inventory']['edit'] = $rightarray['inventory']['edit'];
    $rights['admin']['edit'] = $rightarray['admin']['edit'];
    $rights['donor']['edit'] = $rightarray['donor']['edit'];

    $rights['whitelist']['cop'] = $rightarray['whitelist']['cop']; // 14 Ränge (Cop Lvl 3-16
    $rights['whitelist']['medic'] = $rightarray['whitelist']['medic']; // 7 Ränge
    $rights['whitelist']['justice'] = $rightarray['whitelist']['justice']; // 2 Ränge (Cop Lvl 1-2)

    $rights['panel']['support'] = $rightarray['panel']['support'];
    $rights['panel']['logs'] = $rightarray['panel']['logs'];
    $rights['panel']['rights'] = $rightarray['panel']['rights'];
    $rights['panel']['notes']['show'] = $rightarray['panel']['notes']['show'];
    $rights['panel']['notes']['edit'] = $rightarray['panel']['notes']['edit'];
    $rights['panel']['bans']['show'] = $rightarray['panel']['bans']['show'];
    $rights['panel']['bans']['edit'] = $rightarray['panel']['bans']['edit'];
    $rights['panel']['settings']['edit'] = $rightarray['panel']['settings']['edit'];
*/
    $sqlrights = json_encode($rightarray);

    $statement = $pdo->prepare("UPDATE panel_user SET rights = :rights WHERE sid = :sid LIMIT 1");
    $statement->execute(array('sid' => $steamid, 'rights' => $sqlrights));
}

function SwitchRight($array, $right){
    $count = 0;
    foreach($array as $row){
        if($row['name'] ==  $right){
            if($row['status'] == 1){
                $array[$count]['status'] = 0;
            }else{
                $array[$count]['status'] = 1;
            }
        }
        $count++;
    }
    return $array;

}

function GetRights($steamid){
    $user = GetSteamIDUser($steamid);
    $rights = json_decode($user['rights'], true);
    return $rights;
}

function SaveGeneralPlayer($id, $money, $bank, $admin, $cop, $medic){
    global $pdo;
    $statement = $pdo->prepare("UPDATE players SET cash = :cash, bankacc = :bank, adminlevel = :admin, coplevel = :cop, mediclevel = :medic  WHERE uid = :uid LIMIT 1");
    if (!$statement->execute(array('uid' => $id, 'cash' => $money, 'bank' => $bank, 'admin' => $admin, 'cop' => $cop, 'medic' => $medic))) {
        return $statement->errorInfo();
        //print_r($statement->errorInfo());
    }
}

function SaveMedicPlayer($id, $medic){
    global $pdo;
    $statement = $pdo->prepare("UPDATE players SET mediclevel = :medic  WHERE uid = :uid LIMIT 1");
    if (!$statement->execute(array('uid' => $id, 'medic' => $medic))) {
        return $statement->errorInfo();
        //print_r($statement->errorInfo());
    }
}

function SaveCopPlayer($id, $cop){
    global $pdo;
    $statement = $pdo->prepare("UPDATE players SET coplevel = :cop  WHERE uid = :uid LIMIT 1");
    if (!$statement->execute(array('uid' => $id, 'cop' => $cop))) {
        return $statement->errorInfo();
        //print_r($statement->errorInfo());
    }
}

function SetVehicleStatus($id, $status){
    global $pdo;
    $statement = $pdo->prepare("UPDATE vehicles SET alive = :status WHERE id = :id LIMIT 1");
    $statement->execute(array('id' => $id, 'status' => $status));
}

function SetVehicleGarage($id, $status){
    global $pdo;
    $statement = $pdo->prepare("UPDATE vehicles SET active = :status WHERE id = :id LIMIT 1");
    $statement->execute(array('id' => $id, 'status' => $status));
}

function GetLicenses($steamid, $fac = 0){
    $player = GetPlayer($steamid);
    $lic = $player['civ_licenses'];
    switch ($fac){
        case 0:
            $lic = $player['civ_licenses'];
            break;
        case 1:
            $lic = $player['cop_licenses'];
            break;
        case 2:
            $lic = $player['med_licenses'];
            break;
        default:
            $lic = $player['civ_licenses'];
            break;
    }

    if(!$lic == ""){
        switch ($fac){
            case 0:
                $lic = $player['civ_licenses'];
                break;
            case 1:
                $lic = $player['cop_licenses'];
                break;
            case 2:
                $lic = $player['med_licenses'];
                break;
            default:
                $lic = $player['civ_licenses'];
                break;
        }

        $licall = substr($lic, 2, -2);
        $licall = str_replace("],[", "].[", $licall);
        $licall = explode(".", $licall);

        $output = [];
        $count = 0;
        foreach($licall as $row){
            $lic = str_replace("[", "", $row);
            $lic = str_replace("]", "", $lic);
            $lic = str_replace("`", "", $lic);
            $lic = explode(",", $lic);
            $output[$count]['name'] = $lic[0];
            $output[$count]['status'] = $lic[1];
            $count++;
        }
    }else{$output = "";}
    return $output;
}

function GetLicensesByID($id, $fac = 0){
    $player = GetPlayerByUID($id);
    $lic = $player['civ_licenses'];
    switch ($fac){
        case 0:
            $lic = $player['civ_licenses'];
            break;
        case 1:
            $lic = $player['cop_licenses'];
            break;
        case 2:
            $lic = $player['med_licenses'];
            break;
        default:
            $lic = $player['civ_licenses'];
            break;
        }
    if(!$lic == ""){
        $licall = substr($lic, 2, -2);
        $licall = str_replace("],[", "].[", $licall);
        $licall = explode(".", $licall);

        $output = [];
        $count = 0;
        foreach($licall as $row){
            $lic = str_replace("[", "", $row);
            $lic = str_replace("]", "", $lic);
            $lic = str_replace("`", "", $lic);
            $lic = explode(",", $lic);
            $output[$count]['name'] = $lic[0];
            $output[$count]['status'] = $lic[1];
            $count++;
        }
    }else{$output = "";}
    return $output;
}

function ParseLicense($name){
    switch($name){
        case "license_civ_driver":
            $output = "Auto Führerschein";
            break;
        case "license_civ_boat":
            $output = "Boots Schein";
            break;
        case "license_civ_pilot":
            $output = "Piloten Schein";
            break;
        case "license_civ_trucking":
            $output = "LKW Lizenz";
            break;
        case "license_civ_gun":
            $output = "Waffenschein";
            break;
        case "license_civ_dive":
            $output = "Tauchschein";
            break;
        case "license_civ_oil":
            $output = "Öl Verarbeitung";
            break;
        case "license_civ_home":
            $output = "Eigentumslizenz";
            break;
        case "license_civ_diamond":
            $output = "Diamanten Verarbeitung";
            break;
        case "license_civ_salt":
            $output = "Salz Verarbeitung";
            break;
        case "license_civ_sand":
            $output = "Sand Verarbeitung";
            break;
        case "license_civ_iron":
            $output = "Eisen Verarbeitung";
            break;
        case "license_civ_copper":
            $output = "Kupfer Verarbeitung";
            break;
        case "license_civ_cement":
            $output = "Zement Verarbeitung";
            break;
        case "license_civ_medmarijuana":
            $output = "Medizinisches Marijuana-Lizenz";
            break;
        case "license_civ_cocaine":
            $output = "Cocaine Verarbeitung";
            break;
        case "license_civ_heroin":
            $output = "Heroin Verarbeitung";
            break;
        case "license_civ_marijuana":
            $output = "Marijuana Verarbeitung";
            break;
        case "license_civ_rebel":
            $output = "Rebellenlizenz";
            break;
        case "license_civ_anwalt":
            $output = "Anwaltslizenz";
            break;
        case "license_civ_einbuergerung":
            $output = "Einbürgerung";
            break;
        case "license_civ_gun2":
            $output = "Erw. Waffenschein";
            break;

        case "license_cop_cAir":
            $output = "Flugschein";
            break;
        case "license_cop_cg":
            $output = "Küstenwache";
            break;
        case "license_cop_swat":
            $output = "SWAT";
            break;
        case "license_cop_fbi":
            $output = "FBI";
            break;
        case "license_med_mAir":
            $output = "Flugschein";
            break;
        case "license_cop_state":
            $output = "State Police";
            break;
        case "license_cop_justiz":
            $output = "Justiz";
            break;
        case "license_civ_taxi":
            $output = "Taxi Lizenz";
            break;


        default:
            $output = $name;
    }
    return $output;
}

function BuildLicenseString($licensearray){
    $begin = '"[';
    $end = ']"';

    $string = "";
    foreach($licensearray as $row){
        $string = $string."[`".$row['name']."`,".$row['status']."],";
    }

    $string = substr($string, 0 , -1);
    return $begin.$string.$end;
}

function ChangeLicenseArray($licensearray, $license, $status){
    $count = 0;
    foreach($licensearray as $row){
        if($row['name'] == $license){
            $licensearray[$count]['status'] = $status;
        }
        $count++;
    }
    return $licensearray;
}

function GetLicenseStatus($licensearray, $license){
    foreach($licensearray as $row){
        if($row['name'] == $license){
            $return = $row['status'];
        }
    }
    return $return;
}

function SwitchLicenseByID($id, $type, $lic){
    switch ($type){
        case "civ":
            $licenses = GetLicensesByID($id, 0);
            if(GetLicenseStatus($licenses, $lic) == 1){
                $licenses = ChangeLicenseArray($licenses, $lic, 0);
                $logstatus = 0;
            }else{
                $licenses = ChangeLicenseArray($licenses, $lic, 1);
                $logstatus = 1;
            }
            $licenses = BuildLicenseString($licenses);
            global $pdo;
            $statement = $pdo->prepare("UPDATE players SET civ_licenses = :licenses WHERE uid = :id LIMIT 1");
            $statement->execute(array('id' => $id, 'licenses' => $licenses));
            break;
        case "cop":
            $licenses = GetLicensesByID($id, 1);
            if(GetLicenseStatus($licenses, $lic) == 1){
                $licenses = ChangeLicenseArray($licenses, $lic, 0);
                $logstatus = 0;
            }else{
                $licenses = ChangeLicenseArray($licenses, $lic, 1);
                $logstatus = 1;
            }
            $licenses = BuildLicenseString($licenses);
            global $pdo;
            $statement = $pdo->prepare("UPDATE players SET cop_licenses = :licenses WHERE uid = :id LIMIT 1");
            $statement->execute(array('id' => $id, 'licenses' => $licenses));
            break;
        case "medic":
            $licenses = GetLicensesByID($id, 2);
            if(GetLicenseStatus($licenses, $lic) == 1){
                $licenses = ChangeLicenseArray($licenses, $lic, 0);
                $logstatus = 0;
            }else{
                $licenses = ChangeLicenseArray($licenses, $lic, 1);
                $logstatus = 1;
            }
            $licenses = BuildLicenseString($licenses);
            global $pdo;
            $statement = $pdo->prepare("UPDATE players SET med_licenses = :licenses WHERE uid = :id LIMIT 1");
            $statement->execute(array('id' => $id, 'licenses' => $licenses));
            break;
    }
    $logmsg = "Spieler-ID: ".$_POST['id']." // Typ: ".$_POST['type']." // Neuer Status: ".$logstatus;
    AddLog($_SESSION['uid'], 2, $logmsg);
}

function AddNoteToUser($targetid, $creatorid, $note){
    global $pdo;
    $statement = $pdo->prepare("INSERT INTO panel_notes (uid, targetid, note, created) VALUES (:uid, :targetid, :note, :created)");
    if (!$statement->execute(array('uid' => $creatorid, 'targetid' => $targetid, 'created' => time(), 'note' => $note))) {
        return $statement->errorInfo();
        //print_r($statement->errorInfo());
    }
}

function GetUserNotes($id){
    global $pdo;
    $sql = "SELECT * FROM panel_notes WHERE uid = :uid";
    $statement = $pdo->prepare($sql);
    $statement->execute(array('uid' => $id));
    return $statement->fetch();
}

function GetPanelUserSteam($id){
    global $pdo;
    $sql = "SELECT * FROM panel_user WHERE sid = :id LIMIT 1";
    $statement = $pdo->prepare($sql);
    $statement->execute(array('id' => $id));
    return $statement->fetch();
}

function ParseSide($side){
    switch ($side){
        case "cop":
            $return = '<span class="label label-primary">Polizei</span>';
            break;
        case "med":
            $return = '<span class="label label-danger">EMS</span>';
            break;
        case "civ":
            $return = '<span class="label label-default">Zivil</span>';
            break;
        default:
            $return = '<span class="label label-warning">Unbekannt</span>';
            break;
    }
    return $return;
}

function ParseVehicleName($vehicle){
    switch ($vehicle){
        case "FPT_MAN_base_F":
            $return = 'HLF MAN (Fire Dep.)';
            break;
        case "IVORY_R8":
            $return = 'Audi R8 Coupé';
            break;
        case "IVORY_R8SPYDER":
            $return = 'Audi R8 Spyder';
            break;
        case "shounka_a3_spr_civ_noir":
            $return = 'Mercedes Sprinter(Schwarz)';
            break;
        case "shounka_a3_spr_civ_bleufonce":
            $return = 'Mercedes Sprinter(Dunkelblau)';
            break;
        case "shounka_a3_spr_civ_jaune":
            $return = 'Mercedes Sprinter(Gelb)';
            break;
        case "shounka_a3_spr_civ_grise":
            $return = 'Mercedes Sprinter(Grau)';
            break;
        case "shounka_a3_spr_civ_orange":
            $return = 'Mercedes Sprinter(Orange)';
            break;
        case "shounka_a3_spr_civ_rose":
            $return = 'Mercedes Sprinter(Rosa)';
            break;
        case "shounka_a3_spr_civ_rouge":
            $return = 'Mercedes Sprinter(Rot)';
            break;
        case "shounka_a3_spr_civ_violet":
            $return = 'Mercedes Sprinter(Violett)';
            break;
        case "DRPG_08Suburban_P_P":
            $return = '2006 Chevrolet Suburban PPV';
            break;
        case "DRPG_08Suburban_Black":
            $return = '2008 Chevrolet Suburban(Schwarz)';
            break;
        case "DRPG_08Suburban_blue":
            $return = '2008 Chevrolet Suburban(Blau)';
            break;
        case "DRPG_08Suburban_Orange":
            $return = '2008 Chevrolet Suburban(Orange)';
            break;
        case "DRPG_08Suburban_Green":
            $return = '2008 Chevrolet Suburban(Grün)';
            break;
        case "DRPG_08Suburban_Pink":
            $return = '2008 Chevrolet Suburban(Pink)';
            break;
        case "DRPG_08Suburban_Purple":
            $return = '2008 Chevrolet Suburban(Violett)';
            break;
        case "DRPG_08Suburban_Red":
            $return = '2008 Chevrolet Suburban(Rot)';
            break;
        case "DRPG_08Suburban_White":
            $return = '2008 Chevrolet Suburban(Weiß)';
            break;
        case "DRPG_08Suburban_Yellow":
            $return = '2008 Chevrolet Suburban(Gelb)';
            break;
        case "DRPG_08Suburban_P_LPD":
            $return = '2008 Chevrolet Suburban - LPD';
            break;
        case "DRPG_08Suburban_P_U":
            $return = '2008 Chevrolet Suburban PPV/UM';
            break;
        default:
            $return = $vehicle;
            break;
    }
    return $return;
}

function AddLog($userid, $typ, $msg){
    global $pdo;
    $statement = $pdo->prepare("INSERT INTO panel_logs (user, typ, msg, datetime) VALUES (:uid, :typ, :msg, :created)");
    if (!$statement->execute(array('uid' => $userid, 'typ' => $typ, 'created' => time(), 'msg' => $msg))) {
        return $statement->errorInfo();
        //print_r($statement->errorInfo());
    }

    /*
     * Typen:
     * 1 - Spieler Bearbeitet
     * 2 - Fahrzeug Status bearbeitet
     * 3 - Lizenz bearbeitet
     */

}

function ParseVehicleTyp($typ){
    switch(strtolower($typ)){
        case "car":
            $return = '<i class="fa fa-car" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Fahrzeug"></i>';
            break;
        case "air":
            $return = '<i class="fa fa-plane" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Luftfahrzeug"></i>';
            break;
        case "ship":
            $return = '<i class="fa fa-ship" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Boot"></i>';
            break;
        default:
            $return = $typ;
            break;
    }
    return $return;
}