<?php if(isset($access)){if(!$access == true){exit;}}else{exit;} ?>
<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="pull-right hidden-xs animated fadeInRight">
        Made with <i class="fa fa-magic" aria-hidden="true"></i> by <a target="_blank" href="https://github.com/MrNeta" data-toggle="tooltip" data-placement="top" title="<?php echo site_version; ?>">MrNeta</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; <?php if(date("Y") == 2017){echo date("Y");}else{echo 2017 - date("Y");} ?> <a href="<?php echo site_url; ?>"><?php echo site_name; ?></a>.</strong> All rights reserved.