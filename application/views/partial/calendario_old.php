
<div class="row-fluid">
	<div class="alert alert-info">
		<p>Calendario.</p>
	</div>
</div>
<div class="row-fluid">
	<div class="span8">
		
		<?php echo form_open('inicio/exportarExcelCalendar', array('id'=>'form_excel', 'target' =>'_blank')); ?>

			<button id="exportar_excelCal" name="exportar_excelCal" type="submit" class="btn btn-link">Exportar datos</button>
			<input type="hidden" name="anyoCal" id="anyoCal" value="<?php echo $anyoCalendar; ?>" />
			<input type="hidden" name="mesCal" id="mesCal" value="<?php echo $mesCalendar; ?>" />
		
		</form> 
		
		
		<p>Tíckets Abiertos</p>
		<?php echo $calendar; ?>
	</div>
	<?php //print_r($datos_calendario); ?>
</div>
<br>

<p>&nbsp;</p>

