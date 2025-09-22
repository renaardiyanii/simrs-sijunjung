<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }
?>
<?php echo $this->session->flashdata('success_msg'); ?>

<section class="content">
	<div class="row">
		<div class="card card-outline-info" style="width:97%;margin:0 auto">
			<div class="card-header">		
				<h4  class="text-white" align="center">Cetak Surat Bukti Pelayanan Kesehatan (SBPK) Per Poli</h4>
			</div>
			<div class="card-block">
                <?php echo form_open('emedrec/c_emedrec/sbpk', array('target' => '_blank'));?>
                    <div class="row p-t-0">	
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_days" class="form-control" placeholder="Bulan" name="date_days">	
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <select name="poli" id="poli" class="form-control">
                                    <option value="">-- Pilih Poli --</option>
                                    <?php foreach($poli as $r) {
                                        echo '<option value="'.$r->id_poli.'@'.$r->nm_poli.'">'.$r->nm_poli.'</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                <?php echo form_close();?>
			</div>
		</div>
</section>
<?php 
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?>
