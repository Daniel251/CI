<!DOCTYPE html>
<html>
<head>
	<title><?= $title ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow" />
	<title>Nocny Kochanek</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<link rel="stylesheet" href="<?= base_url() ?>css/fontello.css" type="text/css" />
	<link href='https://fonts.googleapis.com/css?family=Metal+Mania&subset=latin-ext,latin' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?= base_url() ?>css/site.css" type="text/css" />
	<link rel="stylesheet" href="<?= base_url() ?>css/hamburger.css" type="text/css" />
	<?php if(isset($meta)) echo $meta ?>


	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav>
        <div id="nav-icon">
          <span></span>
          <span></span>
          <span></span>
        </div>
		<ul class="clearfix menu">
			<li><a href="<?= base_url() ?>">ZESPÓŁ</a></li>
			<li><a href="<?= base_url() ?>news/index/1">NEWSY</a></li>
			<li><a href="<?= base_url() ?>concerts">KONCERTY</a></li>
			<li><a href="<?= base_url() ?>videos">FILMY</a></li>
			<li><a href="<?= base_url() ?>shop">SKLEP</a></li>
			<li><a href="#footer">KONTAKT</a></li>
			<li class="nav-social">		
				<a href="https://www.youtube.com/c/NocnyKochanek" target="_blank"><i class="icon-youtube"></i></a>
			</li >
			<li class="nav-social">			
				<a href="https://www.facebook.com/nocnykochanek"target="_blank"><i class="icon-facebook-rect"></i></a>
			</li>
		</ul>
    </nav>