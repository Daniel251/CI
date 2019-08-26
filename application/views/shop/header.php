<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow"/>
    <script src='<?php echo base_url() ?>js/jquery2.js'></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>css/lightbox.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/shop.css">
    <link rel='stylesheet' href='<?php echo base_url() ?>css/lightbox.css'>
    <title><?php echo $title ?></title>
</head>
<body>

<div class='container'>
    <nav class="navbar navbar-inverse navbar-fixed-top container">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li><a href="<?php echo base_url() ?>shop">Sklep</a></li>
                    <li><a href="<?php echo base_url() ?>">Strona Główna Zespołu </a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">

                    <?php if ($this->session->userdata('logged_in') != 1): ?>

                        <li id='nav-login'>
                            <div>
                                <a href='<?php echo base_url() ?>shop/user'>Logowanie</a>
                            </div>
                            <div>
                                <a href='<?php echo base_url() ?>shop/user/registration'>Rejestracja</a>
                            </div>
                        </li>

                    <?php else: ?>

                        <li id='nav-login'>
                            <div>
                                <a href='<?php echo base_url() ?>shop/user'>
                                    Zalogowano: <?php echo $this->session->userdata('email') ?>
                                </a>
                            </div>
                            <div id='nav-logout'>
                                <a href='<?php echo base_url() ?>shop/user/logout'>
                                    Wyloguj
                                </a>
                            </div>
                        </li>

                    <?php endif ?>

                    <li>
                        <?php echo form_open('shop/home/search', 'class="navbar-form navbar-left"') ?>
                        <div class="form-group">
                            <input type="text" name="phrase" class="form-control" minlength="3"
                                   placeholder="Szukaj produktu">
                            <button type="submit" class="btn btn-default btn-sm"><span
                                        class="glyphicon glyphicon-search"></span></button>
                        </div>
                        <?php echo form_close() ?>
                    </li>
                    <li>
                        <a class='showcart' href="<?php echo base_url() ?>shop/cart"><span class="glyphicon glyphicon-shopping-cart"></span></a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <div id="logo">
        <img src="<?php echo base_url() ?>images/nk_logo.png" alt="">
    </div>
    <div class="row">
        <div class=''>
            <div id='menu'>
                <ul>
                    <li>
                        <div id='title'>Menu</div>
                    </li>
                    <a href='<?php echo base_url() ?>shop'>
                        <li class='hover'>Strona Główna</li>
                    </a>
                    <?php foreach ($categories as $row): ?>
                        <a href='<?php echo base_url() ?>shop/home/category/<?php echo $row->id ?>'>
                            <li class='hover'><?php echo $row->name ?></li>
                        </a>
                    <?php endforeach ?>
                    <a href='<?php echo base_url() ?>shop/cart'>
                        <li class='hover cart'>Koszyk</li>
                    </a>

                    <?php if ($this->session->userdata('logged_in') != 1): ?>

                        <a href='<?php echo base_url() ?>shop/user'>
                            <li class='hover'>Logowanie</li>
                        </a>
                        <a href='<?php echo base_url() ?>shop/user/registration'>
                            <li class='hover'>Rejestracja</li>
                        </a>
                    <?php else: ?>
                        <a href='<?php echo base_url() ?>shop/user'>
                            <li class='hover'>Profil</li>
                        </a>
                        <a href='<?php echo base_url() ?>shop/user/orders'>
                            <li class='hover'>Moje zamówienia</li>
                        </a>
                        <a href='<?php echo base_url() ?>shop/user/logout'>
                            <li class='hover'>Wyloguj</li>
                        </a>
                    <?php endif ?>
                </ul>
            </div>
        </div>
        <div class='col-xs-10'>
            <div id='content'>

