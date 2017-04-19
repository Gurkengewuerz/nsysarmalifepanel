<?php if(isset($access)){if(!$access == true){exit;}}else{exit;} ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <?php include("menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Fehler!
                <small>Seite nicht gefunden..</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="index.php"><i class="fa fa-dashboard"></i> Startseite</a></li>
                <li class="active">Fehler</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-yellow"> 404</h2>

                <div class="error-content">
                    <h3><i class="fa fa-warning text-yellow"></i> Oops! Seite nicht gefunden.</h3>

                    <p>
                        Wir haben die gewünschte seite nicht gefunden, wahrscheinlich hat sie Sistine Fibel verschwinden lassen..</br>
                        (∩ º ﹏ º )⊃━☆ﾟ.* Ist sie eine Magierin?
                    </p>
                    <p>
                        Du könntest stattdessen <a href="index.php">zurück zur Startseite</a> gehen, oder die angegebene Adresse überprüfen.
                    </p>
                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php include("foot.php"); ?>
</div>
<!-- ./wrapper -->