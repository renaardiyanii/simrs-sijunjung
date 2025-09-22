<!-- <div class="row">
    <div class="col-sm-6">
        <div class="card-block">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Alamat</label>
                <div class="col-sm-9">
                    <input id="alamatri" type="text" class="form-control input-sm" name="alamatri" value="<?php echo $data_pasien[0]['alamat']; ?>" >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Kelurahan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" id="kelurahanri" name="kelurahanri" value="<?php echo $data_pasien[0]['kelurahandesa']; ?>" >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Kecamatan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" name="kecamatanri" value="<?php echo $data_pasien[0]['kecamatan']; ?>" >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">RT/RW</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm" name="rtri" value="<?php echo $data_pasien[0]['rt']; ?>" >
                    </div>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm" name="rwri" value="<?php echo $data_pasien[0]['rw']; ?>" >
                    </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Daerah</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control input-sm" name="id_daerah">
                    </div>
                    <div class="col-sm-6">
                        <input type="text" class="form-control input-sm" name="nmdaerah">
                    </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">No. Telp</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="notelp" value="<?php echo $data_pasien[0]['no_telp']; ?>" >
                </div>
                <label class="col-sm-2 col-form-label">No. HP</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="nohp" value="<?php echo $data_pasien[0]['no_hp']; ?>" >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Status</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control input-sm" name="statusri" value="<?php echo $data_pasien[0]['status']; ?>" >
                </div>
                <label class="col-sm-2 col-form-label">Agama</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control input-sm" name="agamari" value="<?php echo $data_pasien[0]['agama']; ?>" >
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card-block">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Pendidikan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" name="pendidikanri" value="<?php echo $data_pasien[0]['pendidikan']; ?>" >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Pekerjaan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" name="pekerjaanri" value="<?php echo $data_pasien[0]['pekerjaan']; ?>" >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Warga Negara</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" name="wnegarari" value="<?php echo $data_pasien[0]['wnegara']; ?>" >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Suku Bangsa</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" name="sukubangsari" value="<?php echo $data_pasien[0]['suku_bangsa']; ?>" >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Bahasa</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" name="bahasari" value="<?php echo $data_pasien[0]['bahasa']; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama Ibu/Istri</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" name="nm_ibu_istri" value="<?php 
                        if($data_pasien[0]['nama_ibu'] == null){
                            echo $data_pasien[0]['istri']; 
                        }else{
                            echo $data_pasien[0]['nama_ibu']; 
                        }
                        
                    ?>" >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama Ayah/Suami</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control input-sm" name="nm_ayah_suami" value="<?php 
                        if($data_pasien[0]['nama_ayah'] == null){
                            echo $data_pasien[0]['suami']; 
                        }else{
                            echo $data_pasien[0]['nama_ayah']; 
                        }
                        
                    ?>" >
                </div>
            </div>
        </div>
    </div>
</div> -->

<form method="POST" id="form_biodata" class="form-horizontal" enctype='multipart/form-data'> 	
<!-- <?php //echo form_open_multipart('irj/rjcregistrasi/update_data_pasien');?> -->
    <input type="hidden" class="form-control" value="<?php echo $no_medrec;?>" name="no_cm" readonly>
    <input type="hidden" class="form-control" value="<?php echo $user_info->username;?>"  name="user_name">
    <div class="form-group row">
        <p class="col-sm-3 form-control-label" id="no_cm">No RM</p>
        <div class="col-sm-4">
            <input type="text" class="form-control" value="<?php echo $data_pasien->no_cm;?>" name="cm_baru" id="cm_baru" readonly>
        </div>
        <!-- <p class="col-sm-3 form-control-label" id="no_cm">No medi</p> -->
        <div class="col-sm-4">
            <input type="hidden" class="form-control" value="<?php echo $data_pasien->no_medrec;?>" name="no_medrec" id="cm_baru" readonly>
        </div>
    </div>
    <div class="form-group row">
        <p class="col-sm-3 form-control-label" id="tgl_daftar">Tanggal Daftar</p>
        <div class="col-sm-8">
            <div class="input-group">
                <input type="text" class="form-control" value="<?php echo $data_pasien->tgl_daftar;?>" name="tgl_daftar" readonly>
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <p class="col-sm-3 form-control-label" id="nama">Nama Lengkap *</p>
        <div class="col-sm-8">
            <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase()" value="<?php echo $data_pasien->nama;?>" name="nama" required>
        </div>
    </div>
    <div class="form-group row">
        <p class="col-sm-3 form-control-label" id="sex">Jenis Kelamin *</p>
        <div class="col-sm-8">										
            <div class="demo-radio-button">
                <input name="sex" type="radio" id="laki_laki" class="with-gap" value="L" <?php if($data_pasien->sex=='L') echo 'checked' ?>/>
                <label for="laki_laki">Laki-Laki</label>
                <input name="sex" type="radio" id="perempuan" class="with-gap" value="P" <?php if($data_pasien->sex=='P') echo 'checked' ?> />
                <label for="perempuan">Perempuan</label>           		
            </div>
        </div>
    </div>
    
    <div class="form-group row">
        <p class="col-sm-3 form-control-label" >Pilih Identitas</p>
        <div class="col-sm-8">
            <div class="form-inline">
                    <select class="form-control" style="width: 100%" name="jenis_identitas" id="jenis_identitas" onchange="set_ident(this.value)">
                        <option value="">-- Pilih Identitas --</option>
                        <option <?php if($data_pasien->jenis_identitas=='KTP') echo 'selected';?> value="KTP">KTP</option>
                        <option <?php if($data_pasien->jenis_identitas=='SIM') echo 'selected';?> value="SIM">SIM</option>
                        <option <?php if($data_pasien->jenis_identitas=='PASPOR') echo 'selected';?> value="PASPOR">Paspor</option>
                        <option <?php if($data_pasien->jenis_identitas=='KTM') echo 'selected';?> value="KTM">KTM</option>
                        <option <?php if($data_pasien->jenis_identitas=='NIK') echo 'selected';?> value="NIK">NIK</option>
                        <option <?php if($data_pasien->jenis_identitas=='DLL') echo 'selected';?> value="DLL">Lainnya</option>
                    </select>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <p class="col-sm-3 form-control-label" >No. Identitas</p>
        <div class="col-sm-5">
            <input type="text" class="form-control" value="<?php echo $data_pasien->no_identitas;?>" name="no_identitas"  id="no_identitas" onchange="cek_no_identitas(this.value)" onkeyup="cek_no_identitas(this.value)">
        </div>
        <div class="col-sm-3">
            <button class="btn btn-info btn-block" type="button" onclick="cekbpjs_nik()" id="btn_cek_nik">Cek Peserta BPJS</button>
        </div>
    </div>
    <div class="form-group row" id="duplikat_id">
        <p class="col-sm-3 form-control-label"></p>
        <div class="col-sm-8">
            <p class="form-control-label" id="content_duplikat_id" style="color: red;"></p>
        </div>
    </div>
    <!-- <div class="form-group row">
        <p class="col-sm-3 form-control-label">No. Kartu Keluarga</p>
        <div class="col-sm-8">
            <input type="text" class="form-control" value="<?php echo $data_pasien->no_kk;?>" name="no_kk" id="no_kk">
        </div>
    </div>	 -->							
    <hr>
    <!--div class="form-group row">
        <p class="col-sm-3 form-control-label" id="jenis_kartu">Anggota TNI/PNS</p>
        <div class="col-sm-8">
            <div class="form-inline">
                    <div class="demo-checkbox">	
                        <input type="checkbox" class="filled-in" value="ya" name="chk1" id="chk1" <?php if($data_pasien->no_nrp!='' ) echo 'checked';?>/>
                        <label for="chk1">Ya</label>
                    </div>
                
            </div>
        </div>
    </div-->
    
    <!--div id="input_tentara">
        <div class="form-group row" id="inputtentara">
            <p class="col-sm-3 form-control-label">Jenis Keanggotaan</p>
            <div class="col-sm-8">
                <select name="nrp_sbg" id="nrp_sbg" class="form-control select2" style="width: 100%" onchange="set_tentara(this.value)">
                    <option value="">-- Pilih Jenis --</option>
                            <?php 
                    foreach($hubungan as $row){	
                    echo '<option '; if($data_pasien->nrp_sbg==$row->hub_id) echo 'selected '; echo 'value="'.$row->hub_id.'">'.$row->hub_name.'</option>';
                    }
                    ?>
                            
                </select>
                
                
            </div>
        </div>
        <div class="form-group row" >
            <p class="col-sm-3 form-control-label"></p>
            <div class="col-sm-8">
                <input type="search" class="form-control" id="no_nrp" name="no_nrp" placeholder="Pencarian NRP/NIP Anggota" value="<?php echo $data_pasien->no_nrp; ?>">
                <!--<input type="text" class="form-control" value="<?php echo $data_pasien->no_nrp;?>" name="no_nrp" id="no_nrp" placeholder="Nomor NRP" onchange="cek_no_nrp(this.value,'<?php echo $data_pasien->no_nrp; ?>')">>
            </div>
        </div>
        <div class="form-group row" id="duplikat_nrp">
            <p class="col-sm-3 form-control-label"></p>
            <div class="col-sm-8">
                <p class="form-control-label" id="content_duplikat_nrp" style="color: red;"></p>
            </div>
        </div>	
        <div id="kstpktangakat">
            <div class="form-group row" >
            <p class="col-sm-3 form-control-label">Kesatuan</p>
            <div class="col-sm-8">
                <select name="kesatuan" id="kesatuan" class="form-control select2" style="width: 100%" >
                    <option value="">-Pilih Kesatuan-</option>
                    <?php 
                    foreach($kesatuan as $row){												
                    echo '<option '; if($data_pasien->kst_id==$row->kst_id) echo 'selected '; echo 'value="'.$row->kst_id.'">'.$row->kst_nama.'</option>';
                    }
                    ?>
                            
                </select>
                
                
            </div>
        </div> >

        <div class="form-group row" >
        <label class="col-sm-3 control-label col-form-label">Kesatuan</label>
        <div class="col-sm-8">
            <select name="kesatuan" id="kesatuan" class="form-control select2" style="width: 100%" >
                <option value="">-- Pilih Kesatuan --</option>
                <?php 
                    // foreach($kesatuan as $row){
                    // 	echo '<option value="'.$row->kst_id.'">'.$row->kst_nama.'</option>';
                    // }
                $satker = $data_pasien->kst_id . '@' . $data_pasien->kst2_id . '@' . $data_pasien->kst3_id;

                    foreach ($kesatuan as $item) {		
                        if ($item->kst_id . '@' .$item->kst2_id . '@' .$item->kst3_id == $satker) {
                            if ($item->kst2_id == '' && $item->kst3_id == '') {
                                echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '@' .$item->kst3_id.'" selected>'.$item->kst_nama.'</option>';
                            } else if ($item->kst3_id == '') {
                                echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '" selected>'.$item->kst_nama . ' | ' .$item->kst2_nama . '</option>';
                            } else {
                                echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '@' .$item->kst3_id.'" selected>'.$item->kst_nama . ' | ' .$item->kst2_nama . ' | ' .$item->kst3_nama.'</option>';
                            }
                        } else {
                            if ($item->kst2_id == '' && $item->kst3_id == '') {
                                echo '<option value="'.$item->kst_id.'">'.$item->kst_nama.'</option>';
                            } else if ($item->kst3_id == '') {
                                echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '">'.$item->kst_nama . ' | ' .$item->kst2_nama . '</option>';
                            } else {
                                echo '<option value="'.$item->kst_id . '@' .$item->kst2_id . '@' .$item->kst3_id.'">'.$item->kst_nama . ' | ' .$item->kst2_nama . ' | ' .$item->kst3_nama.'</option>';
                            }
                        }
                        
                    }
                ?>														
            </select>
        </div>
    <!-- 	<div class="col-sm-3">
            <select name="kesatuan2" id="kesatuan2" class="form-control select2" style="width: 100%" >												
            </select>
        </div>
        <div class="col-sm-3">
            <select name="kesatuan3" id="kesatuan3" class="form-control select2" style="width: 100%" >																		
            </select>					
        </div> >
    </div>		
        <div class="form-group row" >
            <p class="col-sm-3 form-control-label">Pangkat</p>
            <div class="col-sm-8">
                <select name="pangkat" id="pangkat" class="form-control select2" style="width: 100%" >
                    <option value="">-- Pilih Pangkat --</option>
                    <?php 
                    foreach($pangkat as $row){												
                    echo '<option '; if($data_pasien->pkt_id==$row->pangkat_id) echo 'selected '; echo 'value="'.$row->pangkat_id.'">'.$row->pangkat.'</option>';
                    }
                    ?>
                            
                </select>
                
                
            </div>
        </div>
        <div class="form-group row" >
            <p class="col-sm-3 form-control-label">Angkatan</p>
            <div class="col-sm-8">
                <select name="angkatan" id="angkatan" class="form-control select2" style="width: 100%" >
                    <option value="">-- Pilih Angkatan --</option>
                    <?php 
                    foreach($angkatan as $row){
                    echo '<option '; if($data_pasien->angkatan_id==$row->tni_id) echo 'selected '; echo 'value="'.$row->tni_id.'">'.$row->angkatan.'</option>';
                    }
                    ?>
                            
                </select>											
            </div>
        </div>
        <!-- <div class="form-group row">
            <p class="col-sm-3 form-control-label" id="tgl_nonaktif">Tanggal Non-aktif</p>
            <div class="col-sm-8">
                <input type="text" class="form-control date_picker" id="date_picker" placeholder="yyyy-mm-dd" name="tgl_nonaktif">
            </div>
            onchange="cek_no_kartu(this.value,'<?php echo $data_pasien->no_kartu; ?>')"
    
        </div>	 >	
        </div>						
    </div>
    <hr-->
    <div class="form-group row">
        <p class="col-sm-3 form-control-label" id="no_kartu">No. Kartu BPJS</p>
        <div class="col-sm-5">
            <input type="text"  class="form-control" value="<?php echo isset($data_pasien->no_kartu)?$data_pasien->no_kartu:'';?>" name="no_kartu" id="no_kartu_bpjs" onchange="cek_no_kartu(this.value,'<?php echo $data_pasien->no_kartu; ?>')">
        </div>
        <div class="col-sm-3">
            <button class="btn btn-info btn-block" type="button" id="btn-bpjs-biodata">Cek Peserta BPJS</button>
        </div>
    </div>
    <div class="form-group row" id="duplikat_kartu">
        <p class="col-sm-3 form-control-label"></p>
        <div class="col-sm-8">
            <p class="form-control-label" id="content_duplikat_kartu" style="color: red;"></p>
        </div>
    </div>

    <div class="form-group row">
        <p class="col-sm-3 form-control-label" id="tmpt_lahir">Tempat Lahir</p>
        <div class="col-sm-8">
            <input type="text" class="form-control" onkeyup="this.value = this.value.toUpperCase()"  value="<?php echo $data_pasien->tmpt_lahir;?>" name="tmpt_lahir" >
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-3 control-label" id="tgl_lahir">Tanggal Lahir *</label>
        <div class="col-sm-8">
            <input type="date" class="form-control" placeholder="" id="tgl_rujukan" value="<?php echo date('Y-m-d',strtotime($data_pasien->tgl_lahir));?>" name="tgl_lahir" required>
        </div>
    </div>	
    <div class="form-group row">
        <p class="col-sm-3 form-control-label" id="agama">Agama</p>
        <div class="col-sm-8">
            <div class="form-inline">
                    <select class="form-control" style="width: 100%" name="agama">
                        <option value="">-- Pilih Agama --</option>
                        <option <?php if($data_pasien->agama=='ISLAM') echo 'selected';?> value="ISLAM">Islam</option>
                        <option <?php if($data_pasien->agama=='KATHOLIK') echo 'selected';?> value="KATHOLIK">Katholik</option>
                        <option <?php if($data_pasien->agama=='KRISTEN') echo 'selected';?> value="KRISTEN">Kristen</option>
                        <option <?php if($data_pasien->agama=='BUDHA') echo 'selected';?> value="BUDHA">Budha</option>
                        <option <?php if($data_pasien->agama=='HINDU') echo 'selected';?> value="HINDU">Hindu</option>
                        <option <?php if($data_pasien->agama=='KONGHUCU') echo 'selected';?> value="KONGHUCU">Konghucu</option>
                    </select>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <p class="col-sm-3 form-control-label" id="status">Status</p>
        <div class="col-sm-8">
            <div class="demo-radio-button">
                <input name="status" type="radio" id="belum_menikah" class="with-gap" value="B" <?php if($data_pasien->status=='B') echo 'checked' ?>/>
                <label for="belum_menikah">Belum Menikah</label>
                <input name="status" type="radio" id="menikah" class="with-gap" value="K" <?php if($data_pasien->status=='K') echo 'checked' ?> />
                <label for="menikah">Sudah Menikah</label>  
                <input name="status" type="radio" id="cerai" class="with-gap" value="C" <?php if($data_pasien->status=='C') echo 'checked' ?> />
                <label for="cerai">Cerai</label>           		
            </div>
        </div>
    </div>
    <div class="form-group row">
        <p class="col-sm-3 form-control-label" id="goldarah">Golongan Darah</p>
        <div class="col-sm-8">
            <div class="form-inline">
                <select class="form-control" style="width: 100%" name="goldarah">
                    <option value="">-- Pilih Golongan Darah --</option>
                    <option <?php if($data_pasien->goldarah=='A+') echo 'selected';?> value="A+">A+</option>
                    <option <?php if($data_pasien->goldarah=='A-') echo 'selected';?> value="A-">A-</option>
                    <option <?php if($data_pasien->goldarah=='B+') echo 'selected';?> value="B+">B+</option>
                    <option <?php if($data_pasien->goldarah=='B-') echo 'selected';?> value="B-">B-</option>
                    <option <?php if($data_pasien->goldarah=='AB+') echo 'selected';?> value="AB+">AB+</option>
                    <option <?php if($data_pasien->goldarah=='AB-') echo 'selected';?> value="AB-">AB-</option>
                    <option <?php if($data_pasien->goldarah=='O+') echo 'selected';?> value="O+">O+</option>
                    <option <?php if($data_pasien->goldarah=='O-') echo 'selected';?> value="O-">O-</option>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <p class="col-sm-3 form-control-label" id="wnegara">Kewarganegaraan</p>
        <div class="col-sm-8">
            <div class="form-inline">
                <select class="form-control" style="width: 100%" name="wnegara">
                    <?php if($data_pasien->wnegara=='WNA'){
                        echo '<option value="WNI" >WNI</option><option value="WNA" selected>WNA</option>';
                    }else{
                        echo '<option value="WNI" selected>WNI</option><option value="WNA" >WNA</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <p class="col-sm-3 form-control-label">Alamat *</p>
        <div class="col-sm-8">
            <textarea class="form-control" name="alamat" onkeyup="this.value = this.value.toUpperCase()" id="alamat" rows="5"><?php echo $data_pasien->alamat;?></textarea>
        </div>
    </div>
    <div class="form-group row">
    <label class="col-sm-3 control-label col-form-label" id="alamat">RT/RW</label>
    <div class="form-group row col-sm-8">
        <div class="col-sm-2">
            <input class="form-control" name="rt" type="text" placeholder="RT" value="<?= $data_pasien->rt; ?>">
        </div>
        <div class="col-sm-2">
            <input class="form-control" name="rw" type="text" placeholder="RW" value="<?= $data_pasien->rw; ?>">
            
        </div>
    </div>
    </div>
    <div class="form-group row">
    <label class="col-sm-3 control-label col-form-label" id="lbl_wilayah">Asal Wilayah</label>
    <div class="col-sm-8">
        <div class="form-inline">
            <!-- <select name="load_wilayah" class="form-control load_wilayah" style="width:500px"> -->
            <select name="load_wilayah" class="form-control load_wilayah" style="width:500px">
                <?php if ($data_pasien->kelurahandesa != '') { ?>
                    <option value="<?php echo $data_pasien->id_provinsi . '@' . $data_pasien->id_kotakabupaten . '@' . $data_pasien->id_kecamatan . '@' . $data_pasien->id_kelurahandesa; ?>" selected><?php echo $data_pasien->kelurahandesa . ', ' . $data_pasien->kecamatan . ', ' . $data_pasien->kotakabupaten . ', ' . $data_pasien->provinsi; ?></option>
                <?php } ?>
            </select>
            
        </div>
    </div>
</div>	
    <div class="form-group row">
        <p class="col-sm-3 form-control-label" id="kodepos">Kode Pos</p>
        <div class="col-sm-8">
            <input type="text" class="form-control" value="<?php echo $data_pasien->kodepos;?>" name="kodepos">
        </div>
    </div>
    <div class="form-group row">
        <p class="col-sm-3 form-control-label" id="pendidikan">Pendidikan</p>
        <div class="col-sm-8">
            <div class="form-inline">
                    <select class="form-control select2" style="width: 100%" name="pendidikan">
                        <option value="">-- Pilih Pendidikan Terakhir --</option>
                        <option <?php if($data_pasien->pendidikan=='S1/DIV') echo 'selected';?> value="S1/DIV">S1/DIV</option>
                        <option <?php if($data_pasien->pendidikan=='DIII') echo 'selected';?> value="DIII">DIII</option>
                        <option <?php if($data_pasien->pendidikan=='SMA') echo 'selected';?> value="SMA">SMA</option>
                        <option <?php if($data_pasien->pendidikan=='SLTP') echo 'selected';?> value="SLTP">SLTP</option>
                        <option <?php if($data_pasien->pendidikan=='SD') echo 'selected';?> value="SD">SD</option>
                        <option <?php if($data_pasien->pendidikan=='Belum/Tdk Sekolah') echo 'selected';?> value="Belum/Tdk Sekolah">Belum/Tdk Sekolah</option>
                    </select>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <p class="col-sm-3 form-control-label" id="pekerjaan">Pekerjaan</p>
        <div class="col-sm-8">
            <select class="form-control select2" style="width: 100%" name="pekerjaan">
                        <option value="">-- Pilih Pekerjaan --</option>
                        <?php foreach($pekerjaan as $row) { ?>
                                <option value="<?php echo $row->pekerjaan; ?>" <?php if($data_pasien->pekerjaan==$row->pekerjaan) echo 'selected';?>>
                                    <?php echo $row->pekerjaan; ?>			
                                </option>;
                        <?php } ?>
                    </select>
        </div>
    </div>
    <!-- <div class="form-group row">
        <p class="col-sm-3 form-control-label">Jabatan</p>
        <div class="col-sm-8">
            <input type="text" class="form-control" value="<?php echo $data_pasien->jabatan;?>" name="jabatan">
        </div>
    </div> -->
    <div class="form-group row">
        <p class="col-sm-3 form-control-label" id="no_telp">No. Telp</p>
        <div class="col-sm-8">
            <input type="text" class="form-control" value="<?php echo $data_pasien->no_telp;?>" maxlength="12" name="no_telp">
        </div>
    </div>
    <div class="form-group row">
        <p class="col-sm-3 form-control-label" id="no_hp">No. HP</p>
        <div class="col-sm-8">
            <input type="text" class="form-control" value="<?php echo $data_pasien->no_hp;?>" name="no_hp">
        </div>
    </div>
    <div class="form-group row">
        <p class="col-sm-3 form-control-label" id="no_telp_kantor">No. Telp Kantor</p>
        <div class="col-sm-8">
            <input type="text" class="form-control" value="<?php echo $data_pasien->no_telp_kantor;?>" maxlength="12" name="no_telp_kantor">
        </div>
    </div>								
    <div class="form-group row">
        <div class="offset-sm-3 col-sm-8">									
            <button type="reset" class="btn btn-danger" id="btn-submit"><i class="fa fa-eraser"></i> Reset</button>
            <button type="submit" class="btn btn-primary" id="btn-form-biodata-insert"><i clcass="fa fa-floppy-o"></i>Simpan</button>
            <!-- <button type="submit" class="btn btn-primary" ><i clcass="fa fa-floppy-o"></i>Simpan</button> -->
        </div>
    </div>						
</form>		