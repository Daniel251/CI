<div id="orders">
	<div class="row title">
		Zamówienie nr <?php echo $order->id ?>
	</div>
	<div class='row'>
        <div class='col-sm-5 error center'>
            <?php echo $this->session->flashdata('errors') ?>
        </div>
    </div>
    <div class='row'>
	    <div class='col-sm-10 ok'>
	        <?php echo $this->session->flashdata('ok') ?>
	    </div>
	</div>
	<div class="user-details">
		<div class="row subtitle">
			Dane zamawiającego
		</div>

		<div class="row">
			Id użytkownika:
		</div>
		<div class="row value">
			<?php echo $order->user_id ?>
		</div>
		<div class="row">
			Email:
		</div>
		<div class="row value">
			<?php echo $order->email ?>
		</div>
		<div class="row">
			Imię:
		</div>
		<div class="row value">
			<?php echo $order->name ?>
		</div>
		<div class="row">
			Nazwisko:
		</div>
		<div class="row value">
			<?php echo $order->surname ?>
		</div>
		<div class="row">
			Kod pocztowy:
		</div>
		<div class="row value">
			<?php echo $order->post_code ?>
		</div>
		<div class="row">
			Miasto:
		</div>
		<div class="row value">
			<?php echo $order->city ?>
		</div>
		<div class="row">
			Ulica:
		</div>
		<div class="row value">
			<?php echo $order->street ?>
		</div>

	<?php if($order->send_date != NULL): ?>

		<div class="row">
			Data wysyłki:
		</div>
		<div class="row value">
			<?php echo $order->send_date ?>
		</div>
		<div class="row">
			Nr paczki:
		</div>
		<div class="row value">
			<?php echo $order->parcel_nr ?>
		</div>

	<?php else: ?>

		<?php echo form_open('cms/admin/send/'.$order->id) ?>
		<div class="row">
			Podaj datę wysyłki:
		</div>
		<div class="row value">
			<input type="date" name="date">
		</div>
		<div class="row">
			Podaj nr paczki:
		</div>
		<div class="row value">
			<input type="text" name="nr">
		</div>
		<div class="row">
			<button class="btn btn-warning btn-m btn-add" type="submit" >Potwierdź nadanie paczki</button>
		</div>
	<?php endif ?>

	</div>
	<div class="center">
		<div class="row subtitle">
			Zamówione produkty:
		</div>
		<table class="table">
		    <thead>
		        <th>Nazwa</th>
		        <th>Rozmiar</th>
		        <th>Ilość</th>
		        <th>Cena</th>
		        <th>Suma</th>
		    </thead>
		    <tbody>
		    <?php $sum=0 ?>
		<?php foreach($products as $row): ?>
				<tr>
					<td class='name'><?php echo $row->name ?></td>
					<td><?php echo $size = $row->size == '0' ? '-' : $row->size ?></td>
					<td><?php echo $row->quantity ?></td>
					<td><?php echo number_format($row->price, 2) ?></td>
					<td><?php echo number_format($row->price*$row->quantity, 2) ?></td>
				</tr>
				<?php $sum += $row->price*$row->quantity ?>
			<?php endforeach ?>
			<tr>
			<td></td>
			<td></td>
			<td></td>
			<td>Suma:</td>
			<td><?php echo number_format($sum, 2) ?></td>
			</tbody>
		</table>
		<a href='<?php echo base_url() ?>cms/admin/orders' >Wróć</a>
	</div>
</div>