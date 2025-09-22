<style>
    select.list1 option.option2
    {
        background-color: #007700;
    }
</style>
<script>

$(function(){
	$('.select2').select2();

});


function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}

function ajaxdokter(id_poli){
	var id = id_poli.substr(0,4);
	var pokpoli = id_poli.substr(4,4);

    ajaxku = buatajax();
    var url="<?php echo site_url('iri/rictindakan/data_dokter_poli'); ?>";
    url=url+"/"+id;
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedDokter;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
	
}
function stateChangedDokter(){
    var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_dokter").innerHTML = data;
		}
    }
}

function getRuanganBedIbu(no_ipd_ibu)
{
    ajaxku = buatajax();
    var url="<?php echo site_url('iri/rictindakan/data_bed_ruangan_ibu'); ?>";
    url=url+"/"+no_ipd_ibu;
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedIbu;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
}
function stateChangedIbu(){
    var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
        // console.log(data);
		if(data.length>=0){
			document.getElementById("ruangan").innerHTML = data;
		}
    }
}
</script>
<form id="formInsertPasien" class="formInsertPasien">
    <div class="row">
        <div class="col-sm-6">
            <div class="">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">No. Register Asal</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm" name="noregasal" value="<?php echo $irna_reservasi[0]['no_register_asal']; ?>" readonly>
                        <input type="hidden" value="<?php echo $irna_reservasi[0]['no_register_asal']; ?>" id="noregasal_hidden">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">No. RM</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm" name="no_cm" value="<?php echo $irna_reservasi[0]['no_cm']; ?>" readonly>
                        <input type="hidden" name="no_cm_hidden" value="<?php echo $irna_reservasi[0]['no_medrec']; ?>" id="no_cm_hidden">
                    </div>
                </div>
                
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tgl. Daftar</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm" name="tgldaftarri" value="<?php echo date('Y-m-d H:i:s',strtotime($irna_reservasi[0]['tglreserv'])); ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Cara Bayar</label>
                    <div class="col-sm-9">
                        <!-- <input type="text" class="form-control input-sm" name="carabayar"> -->
                        <select class="form-control input-sm select2" name="carabayar" onchange="update_form_bpjs(this.value)" id="cara_bayar">
                            <?php
                            foreach ($cara_bayar as $r) { 
                                // var_dump($irna_reservasi[0]);die();
                                if(!$irna_reservasi[0]['carabayar']){
                                if($r['cara_bayar'] == $irna_reservasi[0]['carabayar']){ ?>
                                <option value="<?php echo $r['cara_bayar'] ;?>" selected><?php echo $r['cara_bayar'] ;?></option>
                                <?php
                                }else{ ?>
                                <option value="<?php echo $r['cara_bayar'] ;?>"><?php echo $r['cara_bayar'] ;?></option>
                                <?php
                                }}else{
                                    if($r['cara_bayar'] == $irna_reservasi[0]['carabayar']){
                                ?>
                                <option value="<?php echo $r['cara_bayar'] ;?>" selected><?php echo $r['cara_bayar'] ;?></option>
                            <?php
                            }else{
                            ?>
                                <option value="<?php echo $r['cara_bayar'] ;?>"><?php echo $r['cara_bayar'] ;?></option>

                           <?php }
                        }}
                            ?>
                        </select>
                    </div>
                </div>	
                <!-- <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Dokter PJP</label>
                    <div class="col-sm-9">
                        <input type="hidden" class="form-control input-sm" name="id_dokter" id="id_dokter" value="<?php if(isset($data_pasien[0]['id_dokter'])){echo $data_pasien[0]['id_dokter'];}?>">
                        <input type="hidden" class="form-control input-sm" id="nmdokter" name="nmdokter" value="<?php if(isset($data_pasien[0]['nm_dokter'])){echo $data_pasien[0]['nm_dokter'];}?>" required>
                        <input type="text" class="form-control input-sm auto_no_register_dokter" id="nmdokter2" name="nmdokter1" value="<?php if(isset($data_pasien[0]['nm_dokter'])){echo $data_pasien[0]['nm_dokter'];}?>" required>
                        
                    </div>
                </div> -->
               
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Dokter Spesialis</label>
                    <div class="col-sm-9">
                        <select id="id_poli" class="form-control select2" style="width: 100%" name=""  onchange="ajaxdokter(this.value)" >
                            <option value="">-- Pilih Dokter Spesialis  --</option>
                            <?php 
                            foreach($poli as $row){
                                echo '<option value="'.$row->id_poli.''.$row->nm_pokpoli.'">'.$row->nm_poli.'</option>';
                            }
                            ?>
                        </select>	
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Dokter PJP</label>
                    <div class="col-sm-9">
                        <select id="id_dokter" class="form-control select2" style="width: 100%" name="dokter" >
                            <option value="">-- Pilih Dokter --</option>
                            <?php 
                            // foreach($dokter as $row){
                            //     echo '<option value="'.$row->id_dokter.'">'.$row->nm_dokter.'</option>';
                            // }
                            ?>
                        </select>
                    </div>
                </div>

                <!-- <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Diagnosa</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm auto_diagnosa_pasien" name="diagnosa" id="diagnosa" ><div id="loading_diagnosa"></div>

                        <input type="hidden" name="diagnosa_id" id="diagnosa_id"  >
                    </div>
                </div> -->
                <div class="form-group row">
                    <div class="offset-sm-3 col-sm-8">
                        <div class="demo-checkbox">
                            <input type="checkbox" class="filled-in" name="katarak" value="1" id="katarak">
                            <label for="katarak">Katarak</label>
                        </div>									
                        <span class="help-block" style="font-size: 13px;">Centang Katarak <i class="fa fa-check"></i>, Jika Peserta Tersebut Mendapatkan Surat Perintah Operasi katarak</span>	
                    </div>
                </div>	
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Catatan Ringkasan</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="catatan_ring" id="catatan_ring" rows="5"></textarea>
                    </div>
                </div>


                <!-- <div class="form-group row showbayi">
                    <label class="col-sm-3 col-form-label">Ruangan Ibu *</label>
                    <div class="col-sm-9">
                        <span class="label-form-validation"></span>
                        <select class="form-control select2 list1" id="ruangan" name="ruangibu" onchange="get_bed_ibu(this.value)" style="width: 100%">
                            
                        </select>
                    </div>
                </div> -->

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Kelas</label>
                    <div class="col-sm-9">
                        <select id="klsiri" class="form-control select2" style="width: 100%" name="klsiri">
                            <option value="">-- Pilih Kelas  --</option>
                            <option value="VIP"> VIP  </option>
                            <option value="I"> I  </option>
                            <option value="II"> II  </option>
                            <option value="III"> III  </option>
                           
                        </select>	
                    </div>
                </div>	
                          
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Ruangan *</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm" name="idrg" value="Perinatologi" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Bed</label>
                    <div class="col-sm-9">
                        <select id="bed" class="form-control select2" style="width: 100%" name="bed">
                            <option value="">-- Pilih Bed  --</option>
                            <?php 
                            foreach($bed_perinatologi as $row){
                                echo '<option value="'.$row->bed.'">'.$row->no_bed.'</option>';
                            }
                            ?>
                        </select>	
                    </div>
                </div>											
                
               




            </div>
        </div>
        <div class="col-sm-6 form-right">
            <div class="box-body">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">No. Reg. Lama</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm" name="noipdlama" value="<?php echo $irna_reservasi[0]['noreservasi']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm" disabled="true" name="nama_disp" value="<?php echo $data_pasien[0]['nama']; ?>" >
                        <input type="hidden" name="name" value="<?php echo $data_pasien[0]['nama']; ?>" >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tgl. Lahir</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm" id="calendar-tgl-lahir" name="tgllahirri" value="<?php echo date('d-m-Y',strtotime($data_pasien[0]['tgl_lahir'])); ?>" disabled="true">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Jenis Kelamin <?php echo $data_pasien[0]['sex']; ?></label>
                    <div class="col-sm-4">
                        <select class="form-control input-sm" name="sex" disabled="true">
                            <option id="laki_laki" value="L">Laki-Laki</option>
                            <option id="perempuan" value="P">Perempuan</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Gol. Darah</label>
                    <div class="col-sm-4">
                        <select class="form-control input-sm" name="goldarah">
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="O">O</option>
                            <option value="AB">AB</option>
                        </select>
                    </div>
                    <!-- <div class="col-sm-5">
                        <div class="demo-checkbox">	
                            <input type="checkbox" class="filled-in" value="Y" name="barulahir" id="barulahir"  />
                            <label for="barulahir">Bayi Baru Lahir</label>
                        </div>
                    </div> -->
                    
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Pasien</label>
                   
                    <div class="col-sm-5">
                        <div class="demo-checkbox">	
                            <input type="checkbox" class="filled-in" value="Y" name="barulahir" id="barulahir_v2"  />
                            <label for="barulahir_v2">Bayi Baru Lahir</label>

                            <!-- <input type="checkbox" class="filled-in" value="Y" name="anak" id="anak"  />
                            <label for="anak">Anak</label> -->
                        </div>
                    </div>
                    
                </div>

                <div class="form-group row" id="input_regibu_v2">
                    <label class="col-sm-3 col-form-label">No. Register Ibu</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm auto_no_ipd_pasien" name="ipdnama" id="ipdnama" onkeyup="getRuanganBedIbu(this.value)">
                        <input type="hidden" name="noipdibu" id="noipdibu">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Poli / Ruang Asal</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm" disabled="true" name="nama_disp" value="" >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Dokter Asal</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm" disabled="true" name="nama_disp" value="<?php echo ($irna_reservasi[0]['dikirim_oleh_teks'])??$irna_reservasi[0]['dikirim_oleh_teks'] ?>" >
                        <input type="hidden" name="drpengirim" value="<?php echo ($irna_reservasi[0]['dikirim_oleh_teks'])??$irna_reservasi[0]['dikirim_oleh_teks'] ?>" >
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Diagnosa Masuk</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm" disabled="true" name="nama_disp" value="<?php echo $diagnosa_pasien?$diagnosa_pasien[0]->id_diagnosa.'-'.$diagnosa_pasien[0]->diagnosa:''; ?>" >
                        <input type="hidden" name="diagnosa_id" value="<?php echo $diagnosa_pasien?$diagnosa_pasien[0]->id_diagnosa.'-'.$diagnosa_pasien[0]->diagnosa:''; ?>" >
                    </div>
                </div>
               
                <div class="form-group row" id="input_spri">
                    <label class="col-sm-3 col-form-label">SPRI</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control input-sm" name="spri" id="spri" value="<?= ($irna_reservasi[0]['spri'])??$irna_reservasi[0]['spri']; ?>" disabled>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Tgl. Masuk</label>
                    <div class="col-sm-9">
                        <input type="datetime-local" class="form-control input-sm" id="calendar-tgl-masuk" name="tglmasukrg" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Jatah Kelas</label>
                    <div class="col-sm-9">
                        <select class="form-control input-sm select2" name="jatahkls" id="jatahkls" required>
                            <?php
                            foreach ($all_kelas as $r) {  
                                if($r['kelas'] != 'EKSEKUTIF'){
                                    if($r['kelas'] != 'NK'){
                                ?>
                            
                            <option value="<?php echo $r['kelas'] ;?>"><?php echo $r['kelas'] ;?></option>
                            <?php
                            }}}
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <div class="demo-checkbox">	
                            <input type="checkbox" class="filled-in" value="1" name="titip" id="titip"  />
                            <label for="titip">Titip</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
    <button type="submit" id="simpan-pendaftaran" class="btn btn-primary">Simpan</button>

</form>
