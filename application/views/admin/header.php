<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/cms.css">
    <title>Panel admina</title>
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-inverse">
		    <div class="container-fluid">
		    <!-- Brand and toggle get grouped for better mobile display -->
		        <div class="navbar-header">
		          <buttcon type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		            <span class="sr-only">Toggle navigation</span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		          </buttcon>
		            <img src="<?php echo base_url() ?>images/nk_logo_50.png"></img>
		        </div>

		        <!-- Collect the nav links, forms, and other content for toggling -->
		        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		          <ul class="nav navbar-nav">
		            <li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Zarządzanie Stroną Zespołu<span class="caret"></span></a>
		              <ul class="dropdown-menu">
		                <li><a href="<?php echo base_url() ?>cms/admin/news">Newsy</a></li>
		                <li role="separator" class="divider"></li>
		                <li><a href="<?php echo base_url() ?>cms/admin/concerts">Koncerty</a></li>
		                <li role="separator" class="divider"></li>
		                <li><a href="<?php echo base_url() ?>cms/admin/videos">Filmy</a></li>
		              </ul>
		            </li>
		          	<li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Zarządzanie Sklepem<span class="caret"></span></a>
		              <ul class="dropdown-menu">
		                <li><a href="<?php echo base_url() ?>cms/admin/products">Produkty</a></li>
		                <li role="separator" class="divider"></li>
		                <li><a href="<?php echo base_url() ?>cms/admin/orders">Zamówienia</a></li>
                        <li role="separator" class="divider"></li>
		                <li><a href="<?php echo base_url() ?>cms/admin/packages">Typy paczek</a></li>
		              </ul>
		            </li>
		            <li class="dropdown">
		              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Admin<span class="caret"></span></a>
		              <ul class="dropdown-menu">
		                <li><a href="<?php echo base_url() ?>cms/admin/add_admin">Dodaj</a></li>
		                <li role="separator" class="divider"></li>
		                <li><a href="<?php echo base_url() ?>cms/admin/remove_admin">Usuń</a></li>
		              </ul>
		            </li>
		            <li><a href="<?php echo base_url() ?>">Strona Zespołu</a></li>
		            <li><a href="<?php echo base_url() ?>shop">Sklep</a></li>
		          </ul>
		          <ul class="nav navbar-nav navbar-right">
		          <li class="logout"><a  href="<?php echo base_url() ?>shop/user/logout">Wyloguj</a></li>
		          </ul>
		        </div><!-- /.navbar-collapse -->
		    </div><!-- /.container-fluid -->
		</nav>