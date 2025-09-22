<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?>
<script type='text/javascript'>
$(document).ready(function() {
    $('#table-list-medrec').DataTable();
});
</script>
<div class="row">
    <div class="col-md-12">
        <div class="card card-outline-info">
            <div class="card-header"><h5 class="m-b-0 text-white text-center">input INA-CBG Rawat Jalan</h5></div>
            <div class="card-block">	
                <?php echo form_open('irj/rjcmedrec/input_inacbg');?>
                    <div class="row p-t-0">	
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="date" id="date_days" class="form-control" placeholder="Bulan" name="date_days">	
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-actions">
                                <button class="btn btn-primary" type="submit">Search</button>
                            </div>
                        </div>
                    </div>
                <?php echo form_close();?>								
                <br>
                <center><h4 class="box-title">Daftar Pasien Rawat Jalan <b><?php echo $date_title;?></b></h4></center>
                    
                <div class="table-responsive">
                    <table id="table-list-medrec" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">Aksi</th>
                                <th>No. Register</th>
                                <th>Nama</th>
                                <th>No MedRec</th>
                                <th>Poli</th>
                                <th>JK</th>
                                <th>Tgl Kunjungan</th>
                                <th>Dokter</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($irj as $row) { ?>
                                <tr>
                                    <td><a href="<?php echo site_url('irj/rjcmedrec/input_inacbg_pasien/'.$row->no_register); ?>" class="btn btn-default btn-sm" target="_blank"><i class="fa fa-book"></i></a></td>
                                    <td><?php echo $row->no_register;?></td>
                                    <td><?php echo $row->nama;?></td>
                                    <td><?php echo $row->no_medrec;?></td>
                                    <td><?php echo $row->nm_poli;?></td>
                                    <td><?php echo $row->sex;?></td>
                                    <td><?php echo date("d-m-Y", strtotime($row->tgl_kunjungan));?></td>
                                    <td><?php echo $row->nm_dokter;?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>						
                </div> <!-- table-responsive -->
            </div>
        </div>
    </div>
</div>	
<?php 
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?> 
