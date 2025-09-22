<div class="panel-body">	
	<div class="well">
		<div class="form-group row">
			<p class="col-sm-2 form-control-label">Tekanan Darah</p>
			<div class="col-sm-3">
				<div class="input-group">
					<input disabled="" type="text" class="form-control" name="td" id="td" placeholder="" value="<?php 
						if ($td == null){
							echo '';
						} else {
							echo $td.' mmHg';
						}?>">
				</div>
			</div>
			<div class="col-sm-2"></div>
			<p class="col-sm-2 form-control-label">Nadi</p>
			<div class="col-sm-3">
				<div class="input-group">
					<input disabled="" type="text" class="form-control" name="nadi" id="nadi" placeholder="" value="<?php 
						if ($nadi == null){
							echo '';
						} else {
							echo $nadi.' x/mnt';
						}?>">
				</div>
			</div>
		</div>
		<div class="form-group row">
			<p class="col-sm-2 form-control-label">Berat Badan</p>
			<div class="col-sm-3">
				<div class="input-group">
					<input disabled="" type="text" class="form-control" name="bb" id="bb" placeholder="" value="<?php 
						if ($bb == null){
							echo '';
						} else {
							echo $bb.' Kg';
						}?>"> 
				</div>
			</div>
			<div class="col-sm-2"></div>
			<p class="col-sm-2 form-control-label">Suhu</p>
			<div class="col-sm-3">
				<div class="input-group">
					<input disabled="" type="text" class="form-control" name="suhu" id="suhu" placeholder="" value="<?php 
						if ($suhu == null){
							echo '';
						} else {
							echo $suhu.' Celcius';
						}?>">
				</div>
			</div>
		</div>
		<div class="form-group row">
			<p class="col-sm-2 form-control-label">Tinggi Badan</p>
			<div class="col-sm-3">
				<div class="input-group">
					<input disabled="" type="text" class="form-control" name="tb" id="tb" placeholder="" value="<?php 
						if ($tb == null){
							echo '';
						} else {
							echo $tb.' cm';
						}?>">
				</div>
			</div>
			<div class="col-sm-2"></div>
			<p class="col-sm-2 form-control-label">RR</p>
			<div class="col-sm-3">
				<div class="input-group">
					<input disabled="" type="text" class="form-control" name="rr" id="rr" placeholder="" value="<?php 
						if ($rr == null){
							echo '';
						} else {
							echo $rr;
						}?>">
				</div>
			</div>
		</div>
		<div class="form-group row">
			<p class="col-sm-2 form-control-label">Anamnesa</p>
			<div class="col-sm-8">
				<textarea disabled="" rows="10" cols="80" name="catatan" id="catatan"><?php 
						if ($catatan == null){
							echo '';
						} else {
							echo $catatan;
						}?>
					
				</textarea>
			</div>
		</div>
	</div> 
</div> 
