<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<?php echo $this->session->flashdata('pesan'); ?>
<p>sesuaikan format data yang akan diupload dengan file template dibawah ini !</p>
<a href="<?php echo base_url('assets/import_excel.xlsx');?>" class="btn btn-info" target="_blank" download>Download Format Template</a>
<form action="<?= site_url('iri/riclaporan/umbal_exe') ?>" method="post" enctype="multipart/form-data">  
    <div class="modal-body mb-3">
        <div class="form-group row">
			<label class="col-sm-2 control-label col-form-label">Periode Umpan Balik</label>
			<div class="col-sm-6">
                <!-- <input name="periode" class="form-control" type="text" id="periode"> -->
                <select name="periode" id="periode" class="form-control" style="width: 100%">
                    <option value="">-- Pilih Periode --</option>
                    <option value="Tahap I">Tahap I</option>
                    <option value="Tahap II">Tahap II</option>
                    <option value="Tahap III">Tahap III</option>
                    <option value="Tahap IV">Tahap IV</option>
                    <option value="Tahap V">Tahap V</option>
                    <option value="Tahap VI">Tahap VI</option>
                    <option value="Tahap VII">Tahap VII</option>
                    <option value="Tahap VIII">Tahap VIII</option>
                </select>
		    </div>
		</div>
        <div class="form-group row">
			<label class="col-sm-2 control-label col-form-label">Bulan Pelayanan</label>
			<div class="col-sm-4">
				<select name="bulan_pelayanan" id="bulan_pelayanan" class="form-control" style="width: 100%">
                    <option value="">-- Pilih Bulan Pelayanan --</option>
                    <?php 
					foreach($bulan as $row) {
						echo '<option value="'.$row->id_bulan.'-'.$row->bulan.'">'.$row->bulan.'</option>';
					} ?>
                </select>
		    </div>
            <div class="col-sm-2">
                <input type="number" class="form-control" name="tahun" id="tahun" placeholder="Tahun">
            </div>
            <!-- <div class="col-sm-6">
                <input type="month" name="bulan_pelayanan" id="bulan_pelayanan" class="form-control">
            </div> -->
		</div>
        <div class="form-group row">
			<label class="col-sm-2 control-label col-form-label">Objek Klaim</label>
			<div class="col-sm-6">
				<select name="objek_klaim" id="objek_klaim" class="form-control" style="width: 100%">
                    <option value="">-- Pilih Objek Klaim --</option>
                    <option value="RI">Rawat Inap</option>
                    <option value="RJ">Rawat Jalan</option>
                </select>
		    </div>
		</div>
        <!-- Upload File -->
        <div class="form-group row">
			<label class="col-sm-2 control-label col-form-label">Upload</label>
			<div class="col-sm-6">
                <input name="uploadFile" class="form-control" type="file" accept=".xls,.xlsx,.csv" required>
		    </div>
		</div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary">Submit</button>
    </div>
 </form>

<?php
   if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>