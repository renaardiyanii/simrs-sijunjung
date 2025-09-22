<?php
$this->load->view('layout/header_form');
$data = isset($resep_kio->kio)?json_decode($resep_kio->kio):'';
?>
<script>
    
function edit_obat_farmasi_luar(nm_obat, frek, dokter, farmasi) {
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo base_url('iri/Rictindakan/get_data_edit_obat_farmasi_obat_luar') ?>",
            data: {
                nm_obat: nm_obat,
                frek: frek,
                dokter: dokter,
                farmasi: farmasi
            },
            success: function(data) {
                $('#edit_nama_obat_farmasi_luar').val(data.nm_obat);
                // $('#edit_nama_obat_farmasi').val(data.dpo[0].nm_obat);
                // $('#edit_qty').val(data.qty);
                $('#edit_signa_luar').val(data.qty);
                $('#dokter_pemeriksa_luar').val(data.dokter);
                $('#farmasi_pemeriksa_luar').val(data.farmasi);
                // $('#nm_gudang').val(data.gudang);
                // $('#edit_id_resep_dokter_far').val(data[0].id_resep_dokter);
                // $('#edit_signa_farmasi').val(data[0].kali_harian).change();
                // $('#edit_qtx_farmasi').val(data[0].qtx).change();
                // $('#edit_satuan_farmasi').val(data[0].satuan).change();
                // $('#edit_cara_pakai_farmasi').val(data[0].cara_pakai).change();
              
            },
            error: function() {
                alert("error");
            }
        });
    }
  $(document).ready(function () {
$(".js-example-basic-single").select2();

    $('#tabel_farmasi').DataTable();
    $('#tabel_dpo').DataTable();


    $('#form-diagnosa-submit').on('submit', function(e){  
				e.preventDefault();             
				$.ajax({  
				url:"<?php echo base_url(); ?>iri/Rictindakan/insert_obat_resep_libur",                         
				method:"POST",  
				data:new FormData(this),  
				contentType: false,  
				cache: false,  
				processData:false,  
				success: function(data)  
				{ 
					
					new swal({
									title: "Selesai",
									text: "Data berhasil disimpan",
									type: "success",
									showCancelButton: false,
									closeOnConfirm: false,
									showLoaderOnConfirm: true,
										willClose: () => {
											window.location.reload();
										}
								},
								function () {
									window.location.reload();
								});
				},
				error:function(event, textStatus, errorThrown) {
					document.getElementById("btn-form-fisik-insert").innerHTML = 'Simpan';
					new swal("Error","Data gagal disimpan.", "error"); 
					console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
				}  
				});   
			});
});

function edit_obat_farmasi(id_obat,frek) {
    console.log(frek)
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: "<?php echo base_url('iri/Rictindakan/get_data_edit_obat_farmasi')?>",
            data: {
                id_obat: id_obat,
                frek: frek
            },
            success: function (data) {
                console.log(data)
                $('#edit_id_obat_farmasi').val(data.dpo[0].id_obat);
                $('#edit_nama_obat_farmasi').val(data.dpo[0].nm_obat);
                $('#edit_qty').val(data.qty);
                $('#edit_signa').val(data.qty+'X1');
                // $('#edit_id_obat_farmasi_hidden').val(data[0].id_obat);
                // $('#edit_nama_obat_farmasi').val(data[0].nm_obat);
                //  $('#edit_biaya_obat').val(data[0].hargajual);
                // $('#edit_qty_farmasi').val(data[0].qty);
                // $('#edit_qty_farmasi_hidden').val(data[0].qty);
                // $('#edit_id_resep_dokter_far').val(data[0].id_resep_dokter);
                // $('#edit_signa_farmasi').val(data[0].kali_harian).change();
                // $('#edit_qtx_farmasi').val(data[0].qtx).change();
                // $('#edit_satuan_farmasi').val(data[0].satuan).change();
                // $('#edit_cara_pakai_farmasi').val(data[0].cara_pakai).change();
                let html = '';
                if(data.dpo.length){
                    $('#pilihbatch').empty();
                    html+= '<option value="" selected>Pilih Batch</option>';
                    data.dpo.map((i)=>{
                        html+= `
                        <option value="${i.id_inventory}">${'(batch -'+i.batch_no+','+i.expire_date+','+i.qty+')'}</option>
                        `;
                        console.log(i)
                    })

                    $('#pilihbatch').html(html);
                  
                    console.log(data)
                        
                }
                let html2 = '';
                if(data.sub.length){
                    $('#obatsubtitusi').empty();
                    html2+= '<option value="" selected>Pilih Substitusi</option>';
                    data.sub.map((a)=>{
                        html2+= `
                        <option value="${a.id_obat_sub}">${a.nm_obat}</option>
                        `;
                        console.log(a)
                    })

                    $('#obatsubtitusi').html(html2);
                  
                    console.log(data)
                        return true;
                }
            },
            error: function () {
                alert("error");
            }
        });
    }

    function ajaxbiayaobat(id)
    {
        let idobat = $('#pilihbatch').val();
        console.log(idobat);
        $.ajax({
            url: '<?= base_url('farmasi/Frmcdaftar/get_biaya_obat/') ?>'+idobat,
            beforeSend: function() {
            },
            success: function(data) {
               console.log(data)
               $('#edit_biaya_obat').val(data.hargajual);
            //    $('#biaya_obat_hide').val(data.hargajual);
            //    $('#idtindakansub').val(data.nm_obat_substitusi);
            set_total_new();

            },
            error: function(xhr) { // if error occured
                $('#obatsubtitusi').empty();
                let html = '<option>Silahkan Kontak Admin IT</option>';
                $('#obatsubtitusi').html(html)
            },
            complete: function() {
               
            },
        });
                 
           
    }

    function set_total_new() {
       
            var total = ($("#edit_biaya_obat").val() * $("#edit_qty").val());
        
            $('#edit_total_akhir').val(total.toFixed(0));
            console.log(total);
    }

    function ajaxdokterkonsul3(id)
    {
        let idobat = $('#obatsubtitusi').val();
        console.log(idobat);
        $.ajax({
            url: '<?= base_url('iri/Rictindakan/data_obat_sub3/') ?>'+idobat,
            beforeSend: function() {
            },
            success: function(data) {
               console.log(data)
               let html = '';
                if(data.length){
                    $('#pilihbatch').empty();
                    html+= '<option value="" selected>Pilih Batch</option>';
                    data.map((i)=>{
                        html+= `
                        <option value="${i.id_inventory}">${'(batch -'+i.batch_no+','+i.expire_date+','+i.qty+')'}</option>
                        `;
                        console.log(i)
                        $('#idtindakansub').val(i.nm_obat);
                    })

                    $('#pilihbatch').html(html);
                  
                    console.log(data)
                        
                }

            },
            error: function(xhr) { // if error occured
                $('#obatsubtitusi').empty();
                let html = '<option>Silahkan Kontak Admin IT</option>';
                $('#obatsubtitusi').html(html)
            },
            complete: function() {
               
            },
        });
              
           
           
    }
</script>


<div class="card m-5">
   

    <div class="card-header">
		<div class="d-flex justify-content-between">
			<h5>Daftar Obat</h5>
			<div class="d-flex">
                <div class="d-flex justify-content-between">
                    <?php echo form_open('iri/rictindakan/search_dpo_libur');?>
                        <div class="form-group row">
                            <div class="col-sm-8">
                                <input type="date" id="date_picker1" class="form-control" placeholder="Pilih Tanggal" name="tgl_resep">
                                <input type="hidden" class="form-control" value="<?php echo $no_ipd;?>" name="no_ipd">
                            </div>
                
                            <div class="col-sm-4">
                                <div class="form-actions">
                                    <button class="btn btn-primary" type="submit">Cari</button>
                                </div>
                            </div> 
                        </div>
                    <?php echo form_close();?>
                </div>
		    </div>
	    </div>
    </div>
    
    

    
    <div class="card-body">
        <div class="body">
            <div class="table-responsive">
                <table id="tabel_farmasi" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Obat dari Luar</th>
                            <th>Nama Obat</th>
                            <th>Dosis</th>
                            <th>Frekuensi</th>
                            <th>Cara Pakai</th>
                            <th>Rute</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $i = 1;
                        if (isset($data->question2)) {
                            foreach ($data->question2 as $row) {
                                if (isset($row->nm_obat)) {
                                    $nmobat = explode("-", $row->nm_obat)[0];
                                    $idobat = explode("-", $row->nm_obat)[1];
                                } else {
                                    $nmobat = $row->obat_luar;
                                    $idobat = null;
                                }

                        ?>

                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo (isset($row->nm_obat))?'Tidak':'Ya' ?></td>
                                    <td><?php echo isset($nmobat) ? $nmobat : '' ?></td>
                                    <td><?php echo isset($row->dosis) ? $row->dosis : '' ?></td>
                                    <td><?php echo isset($row->frekuensi) ? $row->frekuensi : '' ?></td>
                                    <td><?php echo isset($row->cara_pakai) ? $row->cara_pakai : '' ?></td>
                                    <td><?php echo isset($row->rute) ? $row->rute : '' ?></td>
                                    <td><?php echo isset($row->catatan) ? $row->catatan : '' ?></td>
                                    <td>
                                    <?php if (isset($idobat)) { ?>
                                            <button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#histori" onclick="edit_obat_farmasi(<?php echo isset($idobat) ? $idobat : null ?>,'<?php echo isset($row->frekuensi) ? $row->frekuensi : '' ?>','<?php echo isset($row->paraf_dok) ? $row->paraf_dok : '' ?>','<?php echo isset($data->matriks_telaah_obat[0]->disiapkan) ? $data->matriks_telaah_obat[0]->disiapkan : '' ?>','<?= $row->cara_pakai??'' ?>')">Detail Obat</button>
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-primary btn-xs" data-bs-toggle="modal" data-bs-target="#histori_obat_luar" onclick="edit_obat_farmasi_luar('<?php echo isset($nmobat) ? $nmobat : null ?>','<?php echo isset($row->frekuensi) ? $row->frekuensi : '' ?>','<?php echo isset($row->paraf_dok) ? $row->paraf_dok : '' ?>','<?php echo isset($data->matriks_telaah_obat[0]->disiapkan) ? $data->matriks_telaah_obat[0]->disiapkan : '' ?>')">Detail Obat Luar</button>
                                        <?php } ?>
                                    </td>

                                </tr>
                            <?php }
                        } else { ?>
                            <td colspan="5" style="text-align:center">Tidak ada data</td>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    
</div>


<div class="card m-5">
    <div class="card-header">
        <p style="font-weight:bold">DAFTAR PEMBERIAN OBAT</p>
    </div>

    <form class="form-horizontal" action="<?php echo site_url('iri/rictindakan/insert_dpo'); ?>" method="post">
        <div class="card-body">
            <div class="body">
                <div class="table-responsive">
                    <table id="tabel_dpo" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Obat</th>
                                <th>Frekuensi/Rute</th>
                                <th>Cara Pakai</th>
                                <th>Dokter</th>
                                <th>Farmasi</th>
                                <th>Perawat</th>
                                <th>Waktu Pemberian</th>
                                <th>Aksi</th>    
                            </tr>
                        </thead>
                    
                        <tbody>
                    
                        <?php
                            $i = 1;
                            foreach ($dpo as $row) {
                            ?>

                                <tr>

                                    <td><?php echo $i++; ?></td>
                                    <!-- <td> -->
                                    <input type="hidden" class="form-control" name="id_obat_dpo[]" id="id_obat_dpo" readonly value="<?php echo $row->id_obat ?>">
                                    <input type="hidden" class="form-control" name="id_dpo[]" id="id_dpo" readonly value="<?php echo $row->id ?>">
                                    <!-- </td> -->

                                    <td>
                                        <input type="text" class="form-control" name="nmobat-<?php echo $row->id; ?>" id="nm_obat_dpo" readonly value="<?php echo $row->nm_obat ?>">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" name="frek-<?php echo $row->id; ?>" id="frek_dpo" readonly value="<?php echo $row->frekuensi ?>">
                                    </td>

                                    <td>
                                        <input type="text" class="form-control" name="cara_pakai-<?php echo $row->id; ?>" id="cara_pakai_dpo" readonly value="<?php echo $row->cara_pakai ?>">
                                    </td>

                                    <td>
                                        <select class="form-control js-example-basic-single" name="nm_dokter-<?php echo $row->id; ?>" id="nm_dokter">
                                            <option value="<?php echo $row->dokter ?>">-Pilih Dokter-</option>

                                            <?php
                                            foreach ($dokter as $row2) {
                                                if ($row2->nm_dokter . '-' . $row2->userid == $row->dokter) {

                                            ?>
                                                    <option value="<?= $row2->nm_dokter . '-' . $row2->userid ?>" selected=""><?= $row2->nm_dokter ?></option>
                                                <?php } ?>
                                                <option value="<?= $row2->nm_dokter . '-' . $row2->userid ?>"><?= $row2->nm_dokter ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>

                                    <td>
                                        <select class="form-control js-example-basic-single" name="nm_farmasi-<?php echo $row->id; ?>" id="nm_farmasi">
                                            <option value="">-Pilih Farmasi-</option>

                                            <?php
                                            foreach ($farmasi as $row2) {
                                                if ($row2->nm_dokter . '-' . $row2->userid == $row->farmasi) {

                                            ?>
                                                    <option value="<?= $row2->nm_dokter . '-' . $row2->userid ?>" selected><?= $row2->nm_dokter ?></option>
                                                <?php } ?>
                                                <option value="<?= $row2->nm_dokter . '-' . $row2->userid ?>"><?= $row2->nm_dokter ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>

                                    <td>
                                        <select class="form-control js-example-basic-single" name="nm_perawat-<?php echo $row->id; ?>" id="nm_perawat">
                                            <option value="<?php echo $row->perawat ?>">-Pilih perawat-</option>

                                            <?php
                                            foreach ($perawat as $row2) {
                                                if ($row2->nm_dokter . '-' . $row2->userid == $row->perawat) {

                                            ?>
                                                    <option value="<?= $row2->nm_dokter . '-' . $row2->userid ?>" selected><?= $row2->nm_dokter ?></option>
                                                <?php } ?>
                                                <option value="<?= $row2->nm_dokter . '-' . $row2->userid ?>"><?= $row2->nm_dokter ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>

                                    </td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="pagi" value="pagi" name="pagi-<?php echo $row->id; ?>" <?= isset($row->pagi) ? $row->pagi == "pagi" ? 'checked' : '' : '' ?>>
                                            <label class="form-check-label" for="pagi">P</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="siang" value="siang" name="siang-<?php echo $row->id; ?>" <?= isset($row->siang) ? $row->siang == "siang" ? 'checked' : '' : '' ?>>
                                            <label class="form-check-label" for="siang">S</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="sore" value="sore" name="sore-<?php echo $row->id; ?>" <?= isset($row->sore) ? $row->sore == "sore" ? 'checked' : '' : '' ?>>
                                            <label class="form-check-label" for="sore">S</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="malam" value="malam" name="malam-<?php echo $row->id; ?>" <?= isset($row->malam) ? $row->malam == "malam" ? 'checked' : '' : '' ?>>
                                            <label class="form-check-label" for="malam">M</label>
                                            <input type="hidden" class="form-control" name="no_ipd" id="no_ipd" value="<?php echo $data_pasien[0]['no_ipd'] ?>">
                                        </div>
                                        <div id="waktupemberian-<?php echo $row->id; ?>">
                                        
                                            <?php 
                                            if($row->waktupemberian){
                                                $datawaktupemberian = json_decode($row->waktupemberian);
                                                foreach($datawaktupemberian as $vwaktu){
                                                    echo '
                                                    <div>
                                                        <label class="form-check-label" for="malam">Waktu Pemberian</label>
                                                        <input type="time" name="waktupemberian-'.$row->id.'[]" value="'.$vwaktu.'">
                                                    </div>
                                                    '; 
                                                }
                                            }else{
                                                
                                            ?>
                                            <div>
                                                <label class="form-check-label" for="malam">Waktu Pemberian</label>
                                                <input type="time" name="waktupemberian-<?php echo $row->id; ?>[]">
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-xs btn-primary" onclick="tambahjampemberian(<?php echo $row->id; ?>)">Tambah Jam Pemberian</button>
                                        </div>

                </div>
                </td>
                                    <td>
                                        <a href="<?php echo site_url("iri/rictindakan/hapus_data_obat_dpo/".$row->id.'/'.$row->no_ipd); ?>"
                                        class="btn btn-danger btn-xs">Hapus</a>
                                    </td>
                </tr>
            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o"></i> Simpan Data</button>
        </div>
	</form>
    
</div>


<div class="modal fade" tabindex="-1" id="histori" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
	<form id="form-diagnosa-submit" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail Obat</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row mb-2">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Id Obat</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_id_obat_farmasi" id="edit_id_obat_farmasi"
                                readonly>
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Nama Obat</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_nama_obat_farmasi" id="edit_nama_obat_farmasi" readonly>
                    </div>
                </div>

                <div class="form-group row mb-2 ms-5">
                    <div class="col-sm-1"></div>
                    <i>*pilih hanya jika obat akan diganti (substitusi)</i>
                </div>

                <div class="form-group row mb-2">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Obat Substitusi</p>
                    <div class="col-sm-6">
                        <select id="obatsubtitusi" name="cari_obat_sub" class="form-control" width="100%" onchange="ajaxdokterkonsul3(this.value)">
                            <option value="">Obat substitusi tidak tersedia</option>
                        </select>
                        <input type="hidden" name="nm_sub" id="idtindakansub">
                
                    </div>
                </div>

                <div class="form-group row mb-2 ms-5">
                    <div class="col-sm-1"></div>
                    <i>**********************************</i>
                </div>


                <div class="form-group row mb-2">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Batch</p>
                    <div class="col-sm-6">
                        <select id="pilihbatch" name="batch_farmasi" class="form-control" width="100%" onchange="ajaxbiayaobat(this.value)">
                            
                            <option value="">Pilih batch</option>
                        </select>
                
                    </div>
                </div>


                <div class="form-group row mb-2">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Biaya Obat</p>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" name="edit_biaya_obat"
                                id="edit_biaya_obat" min="0">
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Frekuensi</p>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_signa"
                                id="edit_signa">
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Cara Pakai</p>
                    <div class="col-sm-6">
                        <select id="cara_pakai" name="cara_pakai" class="form-control cara_pakai" style="width:100%;">
                        </select>
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Qty</p>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" name="edit_qty"
                                id="edit_qty" min="0">
                    </div>
                </div>

                
                            
                <div class="form-group row mb-2">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Total Akhir</p>
                    <div class="col-sm-6">
                        <input type="number" class="form-control" name="edit_total_akhir"
                                id="edit_total_akhir" min="0">
                            <input type="hidden" class="form-control" name="idrg" id="idrg" value="<?php echo $data_pasien[0]['idrg']?>">
                            <input type="hidden" class="form-control" name="bed" id="bed" value="<?php echo $data_pasien[0]['bed']?>">
                            <input type="hidden" class="form-control" name="cara_bayar" id="cara_bayar" value="<?php echo $data_pasien[0]['carabayar']?>">
                            <input type="hidden" class="form-control" name="kelas" id="kelas" value="<?php echo $data_pasien[0]['jatahklsiri']?>">
                            <input type="hidden" class="form-control" name="no_ipd" id="no_ipd" value="<?php echo $data_pasien[0]['no_ipd']?>">
                            <input type="hidden" class="form-control" name="no_medrec" id="no_medrec" value="<?php echo $data_pasien[0]['no_medrec']?>">
                            <input type="hidden" class="form-control" name="tgl_kunjungan" id="tgl_kunjungan" value="<?php echo $data_pasien[0]['tgl_masuk']?>">
                            <!-- <input type="hidden" class="form-control" name="tgl_resep" id="tgl_resep" value="<?php //echo $tgl_resep?>"> -->
                           
                    </div>
                </div>

                <div class="form-group row mb-2">
                    <div class="col-sm-1"></div>
                    <p class="col-sm-3 form-control-label">Waktu Pemberian</p>
                    <div class="col-sm-6">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="pagi" value="pagi" name="pagi">
                            <label class="form-check-label" for="pagi">P</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="siang" value="siang" name="siang">
                            <label class="form-check-label" for="siang">S</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="sore" value="sore" name="sore">
                            <label class="form-check-label" for="sore">S</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="malam" value="malam" name="malam">
                            <label class="form-check-label" for="malam">M</label>
                        </div>
                    </div>
                </div>

                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
            </div>
	</form>
    </div>
  </div>
</div>


<div class="modal fade" tabindex="-1" id="histori_obat_luar" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="form-diagnosa-submit_luar" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Detail Obat</h4>
                </div>
                <div class="modal-body">
                    <!-- <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Gudang</p>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="nm_gudang" id="nm_gudang" readonly>
                        </div>
                    </div> -->

                    <!-- <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Id Obat</p>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="edit_id_obat_farmasi" id="edit_id_obat_farmasi" readonly>
                        </div>
                    </div> -->

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Nama Obat</p>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="edit_nama_obat_farmasi_luar" id="edit_nama_obat_farmasi_luar" readonly>
                        </div>
                    </div>

                    <!-- <div class="form-group row mb-2 ms-5">
                        <div class="col-sm-1"></div>
                        <i>*pilih hanya jika obat akan diganti (substitusi)</i>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Obat Substitusi</p>
                        <div class="col-sm-6">
                            <select id="obatsubtitusi" name="cari_obat_sub" class="form-control" width="100%" onchange="ajaxdokterkonsul3(this.value)">
                                <option value="">Obat substitusi tidak tersedia</option>
                            </select>
                            <input type="hidden" name="nm_sub" id="idtindakansub">
                            

                        </div>
                    </div> -->

                    <!-- <div class="form-group row mb-2 ms-5">
                        <div class="col-sm-1"></div>
                        <i>**********************************</i>
                    </div> -->


                    <!-- <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Batch</p>
                        <div class="col-sm-6">
                            <select id="pilihbatch" name="batch_farmasi" class="form-control" width="100%" onchange="ajaxbiayaobat(this.value)">

                                <option value="">Pilih batch</option>
                            </select>

                        </div>
                    </div> -->


                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Biaya Obat</p>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="edit_biaya_obat_luar" id="edit_biaya_obat_luar" min="0">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Frekuensi</p>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" name="edit_signa_luar" id="edit_signa_luar">
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Qty</p>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="edit_qty" id="edit_qty" min="0" onchange="set_total_new(this.value)" required>
                        </div>
                    </div>



                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Total Akhir</p>
                        <div class="col-sm-6">
                            <input type="hidden" name="dokter_luar" id="dokter_pemeriksa_luar">
                            <input type="hidden" name="farmasi_luar" id="farmasi_pemeriksa_luar">
                            <input type="number" class="form-control" name="edit_total_akhir" id="edit_total_akhir" min="0">
                            <input type="hidden" class="form-control" name="idrg" id="idrg" value="<?php echo $data_pasien[0]['idrg'] ?>">
                            <input type="hidden" class="form-control" name="bed" id="bed" value="<?php echo $data_pasien[0]['bed'] ?>">
                            <input type="hidden" class="form-control" name="cara_bayar" id="cara_bayar" value="<?php echo $data_pasien[0]['carabayar'] ?>">
                            <input type="hidden" class="form-control" name="kelas" id="kelas" value="<?php echo $data_pasien[0]['jatahklsiri'] ?>">
                            <input type="hidden" class="form-control" name="no_ipd" id="no_ipd" value="<?php echo $data_pasien[0]['no_ipd'] ?>">
                            <input type="hidden" class="form-control" name="no_medrec" id="no_medrec" value="<?php echo $data_pasien[0]['no_medrec'] ?>">
                            <input type="hidden" class="form-control" name="tgl_kunjungan" id="tgl_kunjungan" value="<?php echo $data_pasien[0]['tgl_masuk'] ?>">
                            <!-- <input type="hidden" class="form-control" name="tgl_kunjungan" id="tgl_kunjungan" value="<?php echo $data_pasien[0]['tgl_masuk'] ?>"> -->
                        </div>
                    </div>

                    <div class="form-group row mb-2">
                        <div class="col-sm-1"></div>
                        <p class="col-sm-3 form-control-label">Waktu Pemberian</p>
                        <div class="col-sm-6">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="pagi" value="pagi" name="pagi">
                                <label class="form-check-label" for="pagi">P</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="siang" value="siang" name="siang">
                                <label class="form-check-label" for="siang">S</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="sore" value="sore" name="sore">
                                <label class="form-check-label" for="sore">S</label>
                            </div>

                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="malam" value="malam" name="malam">
                                <label class="form-check-label" for="malam">M</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>