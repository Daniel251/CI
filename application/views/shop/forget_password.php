<div class="edit-profile">
	<div class='row'>
    	<div class='error center'>
    		<?= $this->session->flashdata('errors') ?>
    	</div>
    </div>
    <div class='row'>
    	<div class='ok center'>
    		<?= $this->session->flashdata('ok') ?>
    	</div>
    </div>
	<div class='header'>Odzyskiwanie hasła</div>
	<div class='center'>
	<?= form_open('shop/user/forget_password') ?>
	    <div class='heading'>
	        Podaj email: 
	    </div> 
	    <div class='value'>
	        <input type='email' name='email'>
	    </div>
	</div>
	<div class='center'>
	    <button type='submit' class='submit-btn'>Potwierdź</button>
	</div>
</div>