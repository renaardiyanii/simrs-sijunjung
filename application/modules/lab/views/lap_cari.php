<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-outline-info">
            <div class="card-block">
				<?php echo form_open('lab/Labclaporan/data_kunjungan');?>
                <div class="row p-t-0">
                    <div class="col-md-3">
                        <div class="form-group">
							<select name="tampil_per" id="tampil_per" class="form-control"  onchange="cek_tampil_per(this.value)">
								<option value="TGL">Tanggal</option>
								<option value="BLN">Bulan</option>
								<!-- <option value="THN">Tahun</option> -->
							</select>	
						</div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
							<div id="date_input">
								<input type="date" id="date_picker_days" class="form-control" placeholder="Tanggal Awal" name="date_picker_days">
							</div>
							<div id="month_input">
									<input type="month" id="date_picker_months" class="form-control" placeholder="Bulan" name="date_picker_months">						
							</div>
							<!-- <div id="year_input">
									<input type="number" min="<?php echo date('Y')-100 ?>" id="date_picker_years" class="form-control" placeholder="Tahun" name="date_picker_years">											
							</div> -->
						</div>
                    </div>
                    <div class="col-md-3 ">
                        <div class="form-group">
							<button class="form-control btn btn-inverse" type="submit">Cari</button>
						</div>
                    </div>
                </div>
					<?php echo form_close();?>
            </div>
        </div>
    </div>
</div>