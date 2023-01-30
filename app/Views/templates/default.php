<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title><?= isset($view)?esc($view):'Document' ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href=<?php echo base_url('img/favicon.ico'); ?> rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href= <?php echo base_url('css/style.css'); ?> rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" integrity="sha512-PgQMlq+nqFLV4ylk1gwUOgm6CtIIXkKwaIHp/PAIWHzig/lKZSEGKEysh0TCVbHJXCLN7WetD8TFecIky75ZfQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href=<?php echo base_url("lib/bootstrap-icons-1.4.1/bootstrap-icons.css"); ?> rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href=<?php echo base_url("lib/owlcarousel/assets/owl.carousel.min.css");?> rel="stylesheet">
    <link href=<?php echo base_url("lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css");?> rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href=<?php echo base_url("css/bootstrap.min.css");?> rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href=<?php echo base_url("css/style.css");?> rel="stylesheet">
</head>

<body>
    <?= $this->renderSection('content')?>
    
    <!-- JavaScript Libraries -->
    <script src=<?php echo base_url("js/jquery-3.4.1.min.js");?>></script>
    <script src=<?php echo base_url("js/bootstrap-5.0.bundle.min.js");?>></script>
    <script src=<?php echo base_url("lib/chart/chart.min.js");?>></script>
    <script src=<?php echo base_url("lib/easing/easing.min.js");?>></script>
    <script src=<?php echo base_url("lib/waypoints/waypoints.min.js");?>></script>
    <script src=<?php echo base_url("lib/owlcarousel/owl.carousel.min.js");?>></script>
    <script src=<?php echo base_url("lib/tempusdominus/js/moment.min.js");?>></script>
    <script src=<?php echo base_url("lib/tempusdominus/js/moment-timezone.min.js");?>></script>
    <script src=<?php echo base_url("lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js");?>></script>

    <!-- Template Javascript -->
    <script src=<?php echo base_url("js/main.js");?>></script>
</body>
</html>