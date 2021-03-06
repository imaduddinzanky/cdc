<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <title>Admin Login</title>

    <link rel="shortcut icon" href="../assets/img/favicon.png">

    <meta name="description" content="">

    <!-- CSS -->
    <link href="<?php css_url('preload.css') ?>" rel="stylesheet" media="screen">
    <link href="<?php css_url('bootstrap.min.css') ?>" rel="stylesheet" media="screen">
    <link href="<?php css_url('yamm.css') ?>" rel="stylesheet" media="screen">
    <link href="<?php css_url('bootstrap-switch.min.css') ?>" rel="stylesheet" media="screen">
    <link href="<?php css_url('font-awesome.min.css') ?>" rel="stylesheet" media="screen">
    <link href="<?php css_url('animate.min.css')?>" rel="stylesheet" media="screen">
    <link href="<?php css_url('slidebars.css') ?>" rel="stylesheet" media="screen">
    <link href="<?php css_url('lightbox.css') ?>" rel="stylesheet" media="screen">
    <link href="<?php css_url('jquery.bxslider.css') ?>" rel="stylesheet">
    <link href="<?php css_url('syntaxhighlighter/shCore.css') ?>" rel="stylesheet" media="screen">

    <link href="<?php css_url('style-gray.css') ?>" rel="stylesheet" media="screen" title="default">
    <link href="<?php css_url('width-full.css') ?>" rel="stylesheet" media="screen" title="default">

    <link href="<?php css_url('buttons.css') ?>" rel="stylesheet" media="screen">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="../assets/js/html5shiv.min.js"></script>
        <script src="../assets/js/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="paper-back-full" style="min-height: 652px;">
    <div class="login-form-full">
        <div class="fix-box">

        <?php echo $this->load->get_section('content'); ?>

        </div>
    </div>
</div>

<!-- Scripts -->
<script src="<?php javascript_url('jquery.min.js')?>"></script>
<script src="<?php javascript_url('jquery.cookie.js')?>"></script>
<script src="<?php javascript_url('bootstrap.min.js')?>"></script>
<script src="<?php javascript_url('bootstrap-switch.min.js')?>"></script>
<script src="<?php javascript_url('wow.min.js')?>"></script>
<script src="<?php javascript_url('slidebars.js')?>"></script>
<script src="<?php javascript_url('jquery.bxslider.min.js')?>"></script>
<script src="<?php javascript_url('holder.js')?>"></script>
<script src="<?php javascript_url('buttons.js')?>"></script>
<script src="<?php javascript_url('styleswitcher.js')?>"></script>
<script src="<?php javascript_url('jquery.mixitup.min.js')?>"></script>
<script src="<?php javascript_url('circles.min.js')?>"></script>

<!-- Syntaxhighlighter -->
<script src="<?php javascript_url('syntaxhighlighter/shCore.js')?>"></script>
<script src="<?php javascript_url('syntaxhighlighter/shBrushXml.js')?>"></script>
<script src="<?php javascript_url('syntaxhighlighter/shBrushJScript.js')?>"></script>

<script src="<?php javascript_url('app.js')?>"></script>
<script src="<?php javascript_url('home_login_full.js')?>"></script>

</body>

</html>
