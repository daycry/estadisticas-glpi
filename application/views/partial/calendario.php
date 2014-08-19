<div class="row">&nbsp;</div>
<div class="row">
	<div class="col-md-8">
		<?php echo form_open('inicio/exportarExcelCalendar', array('id'=>'form_excel', 'target' =>'_blank', 'class' => 'form-horizontal', 'role' => "form")); ?>
			 <fieldset>
				 <legend>Formulari per exportar les dades a Excel del tíckets <b>Oberts</b></legend>
				<div class="form-group">
					<label for="inputEmail3" class="col-sm-2 control-label">Any</label>
					<div class="col-sm-10">
					  <select id="anyoCal" name="anyoCal" class="form-control">
						  <option value="2014">2014</option>
						</select>
					</div>
				  </div>
				  <div class="form-group">
					<label for="inputPassword3" class="col-sm-2 control-label">Mes</label>
					<div class="col-sm-10">
					  <select id="mesCal" name="mesCal" class="form-control">
						  <option value="01">01</option>
						  <option value="02">02</option>
						  <option value="03">03</option>
						  <option value="04">04</option>
						  <option value="05">05</option>
						  <option value="06">06</option>
						  <option value="07">07</option>
						  <option value="08">08</option>
						  <option value="09">09</option>
						  <option value="10">10</option>
						  <option value="11">11</option>
						  <option value="12">12</option>
						</select>
					</div>
				  </div>
				  <div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
					  <button id="exportar_excelCal" name="exportar_excelCal" type="submit" class="btn btn-link">Exportar Excel</button>
					</div>
				  </div>
			  </fieldset>
		</form> 
	</div>
	
</div>
<div class="row" id='calendar'></div>



