<table class="table calc">
	<tr>
		<td>ინვოისის თანხა:</td>
		<td><?php echo e($calculated->invoice_amount); ?></td>
	</tr>
	<tr>
		<td>ფასდათმობა:</td>
		<td><?php echo e($calculated->sale); ?></td>
	</tr>
	<tr>
		<td>გადახდილი თანხა:</td>
		<td><?php echo e($calculated->paid_money); ?></td>
	</tr>
	<tr>
		<td>თვეების რაოდენობა:</td>
		<td><?php echo e($calculated->month); ?></td>
	</tr>
	<tr>
		<td>ფასი:</td>
		<td><?php echo e($calculated->price); ?></td>
	</tr>
	<tr>
	<td>ღირებულება განვადებამდე:</td>
		<td><?php echo e($calculated->cost_before_g); ?></td>
	</tr>
</table>

<style type="text/css">

	.table.calc {
		margin-top: 20px;
		max-width: 500px;
	}
	.table.calc td:first-child {
		font-size: larger;
		/*border-right: 1px solid grey;*/
	}
	.table.calc td:nth-child(2) {
		font-size: larger;
		/*border-right: 1px solid grey;*/
	}
</style>