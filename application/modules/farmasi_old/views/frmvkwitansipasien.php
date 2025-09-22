<?php
	$this->load->view('layout/header_left.php');
?>

<?php echo $this->session->flashdata('message_no_tindakan'); ?>


<script type='text/javascript'>
	$(function() {
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true
		});  
	});
</script>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 align="center">RINCIAN BIAYA</h3>
            </div>
            <div class="card-block">
                <div class="row p-t-0">
                    <div class="table-responsive m-t-20">
                    <table class="table-hover" cellspacing="0" width="100%" style="width: 100%;">
                        <thead>
                        <tr>
                            <!-- <th>No Resep</th>
                            <td>:</td>
                            <td><?php //echo $no_resep;?></td> -->
                            <th>Tanggal Permintaan</th>
                            <td>:</td>
                            <td><?php echo date('d-m-Y',strtotime($data_pasien->tgl_kunjungan));?></td>
                        </tr>
                        <tr>
                            <th>No. Register</th>
                            <td>:</td>
                            <td><?php echo $data_pasien->no_register;?></td>
                            <th>No CM</th>
                            <td>:</td>
                            <td><?php echo $data_pasien->no_cm;?></td>

                        </tr>
                        <tr>
                            <th>Nama Pasien</th>
                            <td>:</td>
                            <td><?php echo $data_pasien->nama;?></td>
                            <th>Kelas Pasien</th>
                            <td>:</td>
                            <td><?php echo $data_pasien->kelas_pasien;?></td>
                            <th></th>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Nama Dokter</th>
                            <td>:</td>
                            <td><?php echo $data_pasien->nm_dokter;?></td>
                            <th>Unit Asal</th>
                            <td>:</td>
                            <td><?php echo $data_pasien->nm_poli;?></td>
                        </tr>
                        </thead>
                    </table>
                    <br/>
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr>
                            <!-- <th>No</th> -->
                            <th>Nama Obat</th>
                            <th>Harga</th>
                            <th>Banyak</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i=1;
                        $jumlah_vtot=0;
                        foreach($data_permintaan as $row){
                            ?>
                            <tr>
                                <td><?php echo $i++;?></td>
                                <td><?php echo $row->nama_obat ?></td>
                                <td><?php echo number_format($row->biaya_obat + $row->embalase); ?></td>
                                <td><?php echo $row->qty ?></td>
                                <td>Rp <div class="pull-right"><?php echo number_format(($row->vtot + $row->embalase));
                                        $jumlah_vtot += $row->vtot + $row->embalase?>
                                    </div>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        <?php //if(substr($data_pasien->no_register,0,2) == 'PL'){?>
                        <!-- <tr>
										<td class="text-center"></td>
	                                    <td><?php //echo $data_adm->nmtindakan; ?></td>
	                                    <td class="text-right"></td>
	                                    <td class="text-right"> <?php //echo number_format($data_adm->total_tarif, 2, ',', '.'); ?> </td>
	                                    <td class="text-right"> Rp <?php //echo number_format($data_adm->total_tarif, 2, ',', '.');
												//$jumlah_vtot += $data_adm->total_tarif ?> </td>
									</tr> -->
                                    <?php
                        //}
                        ?>
                        <tr>
                            <th colspan="4">Total</th>
                            <th>Rp <div class="pull-right"><?php echo number_format($jumlah_vtot);?></div></th>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="row p-t-0">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" align="right" style="margin-right:10px;">
                            <div class="input-group">
                                <span class="input-group-addon">Diskon</span>
                                <input type="text" class="form-control" placeholder="Persen" name="diskon" id="diskon">
                                <span class="input-group-btn">
                                        <button type="btn" class="btn btn-primary" onclick="setTotakhir()">Input</button>
                                    </span>
                            </div>
                        </div>
                    </div><br>
                </div>
                <div class="row p-t-0">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" align="right" style="margin-right:10px;">
                            <div class="input-group">
                                <span class="input-group-addon">Jenis Pembayaran</span>
                                <select class="form-control" name="pembayaran" id="pembayaran" style="border: 2px solid  #7DBE64;" onchange="bayar(this.value)" required>
                                    <option value="">-Pilih Pembayaran-</option>
                                    <option value="TUNAI">TUNAI </option>
                                    <option value="BANK">BANK</option>
                                </select>
                            </div>
                        </div>
                    </div><br>
                </div>
                <div class="row p-t-0">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" align="right" style="margin-right:10px;">
                            <div class="input-group">
                                <p class="form-control-label">Total Biaya setelah diskon :</p>
                                <span class="input-group-addon">Rp</span>
                                <input type="text" class="form-control" placeholder="0" name="totakhir" id="totakhir" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row p-t-0">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <?php echo form_open('farmasi/Frmckwitansi/st_cetak_kwitansi_kt',array('target'=>'_blank'));?>
                        <div class="form-group" align="right" style="margin-right:10px;">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Sudah Terima Dari" name="penyetor" id="penyetor" onchange="penyetorDetail(this.value)" value="<?php echo $data_pasien->nama;?>">
                                <input type="hidden" id="pembayaran_hide" name="pembayaran_hide">
                                <input type="hidden" class="form-control" name="pilih" value="0" >
                                <input type="hidden" class="form-control" name="totakhir_hide" id="totakhir_hide" >
                                <input type="hidden" class="form-control" name="totakhir" value="<?php //echo $totakhir ?>">

                                <input type="hidden" class="form-control" name="pilih" value="detail" >
                                <input type="hidden" class="form-control" name="penyetor_hide" id="penyetor_hide">
                                <input type="hidden" class="form-control" placeholder="" name="no_register" value="<?php echo $data_pasien->no_register ?>">

                                <input type="hidden" class="form-control" name="jumlah_vtot" value="<?php echo $jumlah_vtot ?>">
                                <input type="hidden" class="form-control" value="<?php echo $data_pasien->kelas_pasien;?>" name="kelas_pasien">
                                <input type="hidden" class="form-control" value="<?php echo $data_pasien->no_medrec;?>" name="no_medrec">
                                <input type="hidden" class="form-control" value="<?php echo $data_pasien->no_cm;?>" name="no_cm">
                                <input type="hidden" class="form-control" value="<?php echo $data_pasien->cara_bayar;?>" name="cara_bayar">

                                <span class="input-group-btn">
                                    <input type="hidden" class="form-control" value="<?php echo $data_pasien->no_register;?>" name="no_register">
                                    <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>" name="xuser">
                                    <input type="hidden" class="form-control" name="diskon_hide" id="diskon_hide">
                                    <!-- <input type="hidden" class="form-control" value="<?php //echo $no_resep;?>" name="no_resep" id="no_resep"> -->
                                    <button type="submit" class="btn btn-primary" id="btn-kwitansi" onclick="showswal();">Cetak</button>
                                </span>
                            </div>
                        </div>
                        <br>
                        <?php echo form_close();?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



	</div>
	
					
				</div>
			</div>
		</section>
	</div>

<script type='text/javascript'>	
var site = "<?php echo site_url();?>";
$(document).ready(function() {
	$("#totakhir").maskMoney({thousands:',', decimal:'.', affixesStay: true});
    $("#btn-kwitansi").prop('disabled',true);
    	//$("#diskon").maskMoney({thousands:',', decimal:'.', affixesStay: true});
    });

function cetak(){
	var no_resep = $('#no_resep').val();
	var penyetor = $('#penyetor').val();  
	
	var myWindow = window.open("<?php echo base_url('farmasi/Frmckwitansi/cetak_kwitansi_kt')?>/"+no_resep+"/"+penyetor+"/", "", "width=200,height=100");
	myWindow.focus();
}

function setTotakhir(){
	var num = $('#diskon').val(); 
	$('#diskon_hide').val(num);
	$('#diskon_hide_2').val(num);	
	var total = "<?php echo $jumlah_vtot; ?>";
	
    $("#btn-kwitansi").prop('disabled',false);
	if(total-num>=0){
		$('#totakhir').val(total-num);
		$("#totakhir").maskMoney('mask');
		$('#totakhir_hide').val(total-num);
	}
	else
		alert("Diskon melebihi biaya total !");
}


function penyetorDetail(){
	var num = $('#penyetor').val(); 
	$('#penyetor_hide').val(num); 
}

function showswal() {
    var base = "<?php echo base_url(); ?>";
    new swal({
        title: "",
        text: "MOHON REFRESH HALAMAN",
        type: "info",
        showConfirmButton: true,
        showCancelButton: false,
        closeOnConfirm: false,
        showLoaderOnConfirm: true
    },
    function () {
        window.location.href = base+"farmasi/frmckwitansi/kwitansi";
    });
}

function bayar(bayars){
	$('#pembayaran_hide').val(bayars); 
	//alert($('#jenis_bayar_hide_1').val() );
}
</script>

<?php
	$this->load->view('layout/footer_left.php');
?>