<?php $i = 1; ?> 

<?php foreach ($this->cart->contents() as $items): ?>
     
		<?php echo $items['rowid']; ?>
        <?php echo $items['id']; ?>
		<?php echo $items['name']; ?>
		<?php echo $items['qty']; ?> 
	    <?php echo $this->cart->format_number($items['price']); ?>  

<?php endforeach; ?>

<table>
<?php echo form_open('');?>
<?php form_input($name);?>
<?php form_input($quantity);?>
<?php form_input($);?>
<?php echo form_submit('submit','submit');?>
</table>