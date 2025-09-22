<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
//   var_dump($data_pasien_daftar_ulang->id_poli);
?> 

<link href="<?= base_url('assets/survey/') ?>modern.css" type="text/css" rel="stylesheet" />
<script src="<?= base_url('assets/sweetalert2.js') ?>"></script>
<script src="<?= base_url('assets/survey/survey.jquery.min.js') ?>"></script>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>

<script>
    $(document).ready(function(){
        $('#table').DataTable();
    });
</script>
 
<style type="text/css">

.title{
		font-size:12pt;
		font-weight:bold;
	}
	.subtitle{
		font-size:9pt;
		font-weight:light;
	}

	.hr{
		background-color:gray;
		height:1px;
		width:22%;
		margin-left:4em;
		margin-right:4em;
		margin-bottom:2em;
	}
	.list-group-item{
		display:flex;
		flex-direction:column;
		align-items:flex-start;
	}

	.js-example-basic-single{
		z-index: 9999;
	}
</style>

	<section class="content-header">
		<div class="row">
            <?php include('okvdatapasien_tindak.php');?>
			<div class="col-sm-6">
                <div class="card card-outline-info ">
                    <div class="card-header text-white" align="center" >Pelayanan Pasien</div>
                    <div class="card-body p-5">
                        <table class=" datatable table  table-striped" id="table">
                            <thead>
                                <tr>
                                    <th>Nama Form</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                <tr>
                                    <td> <img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($laporan_pembedahan)?'check.png':'uncheck.png' ?>" alt=""> Laporan Pembedahan</td>
                                    <td>
                                        <a target="_blank" href="<?php echo base_url('ok/okcdaftar/form/lap_pembedahan/'.$no_register.'/'.$id); ?>" class="btn btn-primary">Input</a>
                                        <a target="_blank" href="<?php echo base_url('ok/okchasil/laporan_pembedahan_view/'.$no_register.'/'.$id); ?>" class="btn btn-primary">View</a>
                                    </td>
                                </tr>

                                <tr>
                                    <td> <img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($checklist_keselamatan_operasi)?'check.png':'uncheck.png' ?>" alt=""> Checklist Keselamatan Pasien OK</td>
                                    <td>
                                        <a target="_blank" href="<?php echo base_url('ok/okcdaftar/form/check_keselamatan/'.$no_register.'/'.$id); ?>" class="btn btn-primary">Input</a>
                                        <!-- <a target="_blank" href="<?php echo base_url('ok/okchasil/laporan_pembedahan_view/'.$no_register.'/'.$id); ?>" class="btn btn-primary">View</a> -->
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td> <img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($peng_anastesi_sedasi)?'check.png':'uncheck.png' ?>" alt=""> Pengkajian Pra Anestesi dan Sedasi</td>
                                    <td>
                                        <a target="_blank" href="<?php echo base_url('ok/okcdaftar/form/anestesi_sedasi/'.$no_register.'/'.$id); ?>" class="btn btn-primary">Input</a>
                                        <!-- <a target="_blank" href="<?php echo base_url('ok/okchasil/laporan_pembedahan_view/'.$no_register.'/'.$id); ?>" class="btn btn-primary">View</a> -->
                                    </td>
                                </tr>

                                 
                                <tr>
                                    <td> <img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($caper_peri_operatif)?'check.png':'uncheck.png' ?>" alt="">Catatan Keperawatan Peri Operatif</td>
                                    <td>
                                        <a target="_blank" href="<?php echo base_url('ok/okcdaftar/form/caper_peri_operatif/'.$no_register.'/'.$id); ?>" class="btn btn-primary">Input</a>
                                        <!-- <a target="_blank" href="<?php echo base_url('ok/okchasil/laporan_pembedahan_view/'.$no_register.'/'.$id); ?>" class="btn btn-primary">View</a> -->
                                    </td>
                                </tr>

                                <tr>
                                    <td> <img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($catatan_pemulihan)?'check.png':'uncheck.png' ?>" alt="">Catatan Anestesi - Catatan Pemulihan</td>
                                    <td>
                                        <a target="_blank" href="<?php echo base_url('ok/okcdaftar/form/catatan_anestesi_pemulihan/'.$no_register.'/'.$id); ?>" class="btn btn-primary">Input</a>
                                        <!-- <a target="_blank" href="<?php echo base_url('ok/okchasil/laporan_pembedahan_view/'.$no_register.'/'.$id); ?>" class="btn btn-primary">View</a> -->
                                    </td>
                                </tr>

                                <tr>
                                    <td> <img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($lap_bedah_anestesi_lokal)?'check.png':'uncheck.png' ?>" alt="">Laporan Pembedahan dengan Pendamping Anestesi Lokal</td>
                                    <td>
                                        <a target="_blank" href="<?php echo base_url('ok/okcdaftar/form/lap_bedah_anestesi_lokal/'.$no_register.'/'.$id); ?>" class="btn btn-primary">Input</a>
                                        <!-- <a target="_blank" href="<?php echo base_url('ok/okchasil/laporan_pembedahan_view/'.$no_register.'/'.$id); ?>" class="btn btn-primary">View</a> -->
                                    </td>
                                </tr>

                                <tr>
                                    <td> <img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($lap_bedah_anestesi)?'check.png':'uncheck.png' ?>" alt="">Laporan Pembedahan dengan Pendamping Anestesi</td>
                                    <td>
                                        <a target="_blank" href="<?php echo base_url('ok/okcdaftar/form/lap_bedah_anestesi/'.$no_register.'/'.$id); ?>" class="btn btn-primary">Input</a>
                                        <!-- <a target="_blank" href="<?php echo base_url('ok/okchasil/laporan_pembedahan_view/'.$no_register.'/'.$id); ?>" class="btn btn-primary">View</a> -->
                                    </td>
                                </tr>

                                <tr>
                                    <td> <img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($pramedi_pasca_operasi)?'check.png':'uncheck.png' ?>" alt="">Premedi Pasca Operasi/Bedah</td>
                                    <td>
                                        <a target="_blank" href="<?php echo base_url('ok/okcdaftar/form/pramedi_pasca_operasi/'.$no_register.'/'.$id); ?>" class="btn btn-primary">Input</a>
                                        <!-- <a target="_blank" href="<?php echo base_url('ok/okchasil/laporan_pembedahan_view/'.$no_register.'/'.$id); ?>" class="btn btn-primary">View</a> -->
                                    </td>
                                </tr>

                                

                                <tr>
                                    <td> <img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($tindakan_anestesi_sedasi)?'check.png':'uncheck.png' ?>" alt="">Pernyataan tindakan Anestesi dan Sedasi</td>
                                    <td>
                                        <a target="_blank" href="<?php echo base_url('ok/okcdaftar/form/tindakan_anestesi_sedasi/'.$no_register.'/'.$id); ?>" class="btn btn-primary">Input</a>
                                        <!-- <a target="_blank" href="<?php echo base_url('ok/okchasil/laporan_pembedahan_view/'.$no_register.'/'.$id); ?>" class="btn btn-primary">View</a> -->
                                    </td>
                                </tr>

                                <tr>
                                    <td> <img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($edukasi_anestesi_sedasi)?'check.png':'uncheck.png' ?>" alt="">Form Edukasi tindakan Anestesi dan Sedasi</td>
                                    <td>
                                        <a target="_blank" href="<?php echo base_url('ok/okcdaftar/form/edukasi_anestesi_sedasi/'.$no_register.'/'.$id); ?>" class="btn btn-primary">Input</a>
                                        <!-- <a target="_blank" href="<?php echo base_url('ok/okchasil/laporan_pembedahan_view/'.$no_register.'/'.$id); ?>" class="btn btn-primary">View</a> -->
                                    </td>
                                </tr>

                                <tr>
                                    <td> <img width="30px" src="<?= base_url('assets/icons/') ?><?php echo ($assesmen_pra_induksi)?'check.png':'uncheck.png' ?>" alt="">Monitoring Intra sedasi/anestesi</td>
                                    <td>
                                        <a target="_blank" href="<?php echo base_url('ok/okcdaftar/form/assesmen_pra_induksi/'.$no_register.'/'.$id); ?>" class="btn btn-primary">Input</a>
                                        <!-- <a target="_blank" href="<?php echo base_url('ok/okchasil/laporan_pembedahan_view/'.$no_register.'/'.$id); ?>" class="btn btn-primary">View</a> -->
                                    </td>
                                </tr>
                                <tr>
                                    <td>Resep</td>
                                    <td>
                                        <a target="_blank" href="<?php echo base_url('farmasi/frmcdaftar/permintaan_obat_petugas?no_register='.$no_register); ?>" class="btn btn-primary">Input</a>
                                        <!-- <a target="_blank" href="<?php echo base_url('ok/okchasil/laporan_pembedahan_view/'.$no_register.'/'.$id); ?>" class="btn btn-primary">View</a> -->
                                    </td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
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

