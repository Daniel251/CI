<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/cms.css">
    <title>Login</title>
</head>
<body>
    <div class='container'>
        <div id="login">
            <div id="logo">
                <img src="<?= base_url(); ?>images/nk_logo.png" alt="">
            </div>    
            <?php if($this->session->flashdata('errors')): ?>
                <div class='row'>
                    <div class='col-sm-5 error center'>
                        <?php echo $this->session->flashdata('errors') ?>
                    </div>
                </div>
            <?php endif; ?>
            <div id="login-form">
            <?php echo form_open('cms/login'); ?>
                <div class="row">
                    <div class="title label col-sm-3">Email: </div>
                    <div class="label col-sm-9">
                        <input type="email" name="email" required>
                    </div>
                </div>
                <div class="row">
                    <div class="title label col-sm-3">Hasło: </div> 
                    <div class="label col-sm-9">
                        <input type="password" name="password" required>
                    </div>
                </div>
                <div class="row">
                    <div class="submit col-sm-12">
                        <button type='submit' class='submit-btn'>Zaloguj</button>
                    </div>
                </div>
            <?php form_close(); ?>
            </div>
        </div>
    </div>
    <script src='<?php echo base_url(); ?>js/cms.js'></script>
</body>
</html>