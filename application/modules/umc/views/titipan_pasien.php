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
            <div class="card-header"><h5 class="m-b-0 text-white text-center"><?php echo $date_title;?></h5></div>
            <div class="card-block">	
                <?php echo form_open('umc/cumcicilan/titipan_pasien');?>
                    <div class="row p-t-0">	
                        <div class="col-md-2">
                            <div class="form-group">
                                <div id="month_input">
                                    <input type="month" id="date_picker_months" class="form-control" placeholder="Bulan" name="date_picker_months">	
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
                    
                <div class="table-responsive">
                    <table id="table-list-medrec" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>No. Register</th>
                                <th>Nama</th>
                                <th>No MedRec</th>
                                <th>Jaminan</th>
                                <th>Ruang</th>
                                <th>JK</th>
                                <th>Tgl Masuk</th>
                                <th>Tgl Keluar</th>
                                <th>Titipan</th>
                                <th>Uang Jaminan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $total = 0;
                            foreach ($titipan as $row) { ?>
                                <tr>
                                    <td><?php echo $i++;?></td>
                                    <td><?php echo $row->no_ipd;?></td>
                                    <td><?php echo $row->nama;?></td>
                                    <td><?php echo $row->no_medrec;?></td>
                                    <td><?php echo $row->carabayar;?></td>
                                    <td><?php echo $row->nmruang;?></td>
                                    <td><?php echo $row->sex;?></td>
                                    <td><?php echo date("d-m-Y", strtotime($row->tgl_masuk));?></td>
                                    <td><?php echo date("d-m-Y", strtotime($row->tgl_keluar_resume));?></td>
                                    <td><?php echo $row->jaminan_adm;?></td>
                                    <td><?php echo number_format($row->uang_muka_adm);?></td>
                                </tr>
                            <?php $total += $row->uang_muka_adm;
                            } ?>
                        </tbody>
                    </table>						
                </div> <!-- table-responsive -->
                <h4>Total : <?php echo number_format($total);?></h4><br>
                <a href="<?php echo site_url('umc/cumcicilan/titipan_pasien_excel/'.$date);?>" target="_blank"><input type="button" class="btn" style="background-color: green;color:white;" value="EXCEL"></a>
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
