<?php 

$data = isset($assesment_awal_keperawatan_iri[0]->formjson)?json_decode($assesment_awal_keperawatan_iri[0]->formjson):'';
//  var_dump($data->table_fim);
?>

<!DOCTYPE html>
<html>
    <head><title></title></head>
    <style>
        .header-parent{
        display: flex;
        justify-content: space-between;

        }
        .right{
            display: flex;
            align-items: flex-end;
            flex-direction: column;
        }
        .patient-info{
            border: 1px solid black;
            padding: 1em;
            display: flex;
            border-radius: 10px;
        }
        #data {
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 100%;
            font-size: 11px;
            /* position: relative; */
            padding: 0%;
        }
        #data {
            margin-top: 20px;
            border-collapse: collapse;
            border: 1px solid black;    
            width: 80%%;
            font-size: 11px;
            /* position: relative; */
            padding: 0%;
        }
        .text_isi{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
        font-weight: bold;
       }
       .text_judul{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14pt;
        font-weight: bold;
        text-decoration: underline;
       } 
       td {line-height: 1.5; vertical-align:top;}
       .padding-fix-10mm {padding-top:0mm; padding-left: 10mm;padding-right: 10mm;}

       /* table tr td{
           font-size:11px!important;
       }   */
       .flex{
            display: flex;

        }

        .bg-checked{
            background-color:#64C9CF;
            color:white;
        }

    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4" >

    <!-- halaman 1 -->

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                ASESMEN AWAL KEPERAWATAN ANAK RAWAT INAP <br>
                (Untuk Anak Usia ≥ 29h hari sampai 18 tahun)<br>
                Dilengkapi 24 jam pasien masuk Ruang Rawat
            </p>
            <div style="font-size:11px">
                <table border="0" width="100%" style="font-size:9px">
                    <tr>
                        <td width="15%" style="font-size:11px"><span class="">Tiba di ruangan</span></span></td>
                        <td width="3%" style="font-size:11px"><span class="">:<span class=""></span></span></td>
                        <td width="20%" style="font-size:11px"><span class="">Tanggal <?=':'.' '.(isset($data->tgl)?date('d-m-Y',strtotime($data->tgl)):'')?><span class=""></span></span></td>
                        <td width="15%" style="font-size:11px"><span class="">Jam<?=' '.':'.' '.(isset($data->tgl)?date('H:i:s',strtotime($data->tgl)):'')?><span class=""></span></span></td>
                        <td width="20%" style="font-size:11px"><span class=""><span class=""></span></span></td>
                    </tr>
                    <!-- belum -->
                    <tr>
                        <td width="15%" style="font-size:11px"><span class="">Pengkajian</span></span></td>
                        <td width="3%" style="font-size:11px"><span class="">:<span class=""></span></span></td>
                        <td width="8%" style="font-size:11px"><span class="">Tanggal<?=' '.':'.' '.(isset($data->tgl_selesai)?date('d-m-Y',strtotime($data->tgl_selesai)):'')?><span class=""></span></span></td>
                        <td width="20%" style="font-size:11px"><span class="">Jam <?=' '.':'.' '.(isset($data->tgl_selesai)?date('H:i:s',strtotime($data->tgl_selesai)):'')?></span></span></td>
                        <td width="20%" style="font-size:11px"><span class=""><span class=""></span></span></td>
                    </tr>
                    <!--  -->
                    <tr>
                        <td width="15%" style="font-size:11px"><span class=""></span></span></td>
                        <td width="3%" style="font-size:11px"><span class=""><span class="text_isi"></span></span></td>
                        <td width="8%" style="font-size:11px"><span class="">
                            <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->auto_anamnesa)? $data->auto_anamnesa == "auto" ? "checked":'':'' ?>>
                            <span>Auto Anamnesa</span>
                        </td>
                        <td width="10%" style="font-size:11px" ><span class="">
                            <input type="checkbox" value="Auto Anamnesa" <?php echo isset($data->auto_anamnesa)? $data->auto_anamnesa != "auto" ? "checked":'':'' ?>>
                            <span>Allo Anamnesa <?=':'.(isset($data->check_anamnesa)?$data->check_anamnesa:'')?></span>
                        </td>
                        <td width="20%" style="font-size:11px"><span class="">Hubungan</span></td>
                    </tr>
                    <tr>
                        <td width="15%" style="font-size:11px"><span class="">Cara Masuk</span></span></td>
                        <td width="3%" style="font-size:11px"><span class="">:<span class="text_isi"></span></span></td>
                        <td width="8%" style="font-size:11px"><span class="">
                            <input type="checkbox" <?php echo isset($data->cara_masuk)? $data->cara_masuk == "jalan" ? "checked":'':'' ?>>
                            <span>Jalan</span>
                        </td>
                        <td width="10%" style="font-size:11px"><span class="">
                            <input type="checkbox" <?php echo isset($data->cara_masuk)? $data->cara_masuk == "roda" ? "checked":'':'' ?>>
                            <span>Kursi Roda</span>
                        </td>
                        
                        <td width="10%" style="font-size:11px"><span class="">
                            <input type="checkbox" <?php echo isset($data->cara_masuk)? $data->cara_masuk == "lainnya" ? "checked":'':'' ?>>
                            <span>Lain Lain <?=':'.(isset($data->check_cara_masuk)?$data->check_cara_masuk:'')?></span>
                        </td>
                        
                    </tr>
                    <tr>
                        <td width="15%" style="font-size:11px"><span class="">Asal Masuk</span></span></td>
                        <td width="3%" style="font-size:11px"><span class="">:<span class="text_isi"></span></span></td>
                        <td width="8%" style="font-size:11px"><span class="">
                            <input type="checkbox" <?php echo isset($data->asal_masuk)? $data->asal_masuk == "igd" ? "checked":'':'' ?>>
                            <span>IGD</span>
                        </td>
                        <td width="10%" style="font-size:11px"><span class="">
                            <input type="checkbox" <?php echo isset($data->asal_masuk)? $data->asal_masuk == "rawat_jalan" ? "checked":'':'' ?>>
                            <span>Rawat Jalan</span>
                        </td>
                        <td width="10%" style="font-size:11px"><span class="">
                            </span>
                        </td>
                    </tr>
                </table>
                <p><b>1.STATUS FISIK</b></p>

                <div style="display: flex;margin-left:10px">
                        <div style="flex-direction: column;">
                            
                                <span>GCS</span>
                                <span style="margin-left:10px">:</span>
                                <span style="margin-left:10px">E:<?=' '.(isset($data->e)?$data->e:'')?></span>
                                <span style="margin-left:20px">M:<?=' '.(isset($data->m)?$data->m:'')?></span>
                                <span style="margin-left:20px">V:<?=' '.(isset($data->v)?$data->v:'')?></span>
                            
                        </div>
                        <div style="margin-left: 50px;">
                            
                                <span style="margin-left:30px;">Suhu:<?=' '.(isset($data->suhu)?$data->suhu:'').' '.'°C'?></span>
                            
                        </div>
                </div>


                <div style="display: flex;margin-left:10px">
                        
                        <div>
                            <p>
                                
                                    <span>Nadi:<?=' '.(isset($data->nadi)?$data->nadi:'').' '.'x/menit'.','.' '.(isset($data->tidak_teratur_nadi)?$data->tidak_teratur_nadi:'')?></span>
                                    <span style="margin-left:165px">Tekanan Darah:<?=' '.(isset($data->tekanan_darah)?$data->tekanan_darah:'').' '.'mmHG'?></span>
                                    
                            </p>
                        </div>
                </div>

                <div style="display: flex;margin-left:10px">
                    <p>
                        <div style="flex-direction: column;">
                        <span >Pernafasan:<?=' '.(isset($data->pernafasan)?$data->pernafasan:'').' '.'x/menit'.','.' '.(isset($data->tidak_teratur_pernafasan)?$data->tidak_teratur_pernafasan:'')?></span>
                        
                            
                        </div>
                    </p>
                    <p>
                        <div style="margin-left: 135px;">
                                <span>BB:<?=' '.(isset($data->bb)?$data->bb:'').' '.'Kg'?></span>
                        </div>
                    </p>
                    <p>
                        <div style="margin-left: 120px;">
                                <span>TB:<?=' '.(isset($data->tb)?$data->tb:'').' '.'Cm'?></span>
                        </div>
                    </p>
                </div>

                <div>
                    <span>
                        -	Kesadaran	:
                        <p style="margin-left: 20px;">	            		    			
                        <input type="checkbox" value="CM" <?php echo isset($data->kesadaran)? $data->kesadaran == "KOMPOSMENTIS" ? "checked":'':'' ?>>
                        <span>CM</span>
                        <input type="checkbox" value="Apatis" style="margin-left:50px" <?php echo isset($data->kesadaran)? $data->kesadaran == "APATIS" ? "checked":'':'' ?>>
                        <span>Apatis</span>
                        <input type="checkbox" value="Somnolent" style="margin-left:50px" <?php echo isset($data->kesadaran)? $data->kesadaran == "SAMNOLEN" ? "checked":'':'' ?>>
                        <span>Somnolent</span>
                        <input type="checkbox" value="Somnolent" style="margin-left:50px" <?php echo isset($data->kesadaran)? $data->kesadaran == "SOPOR" ? "checked":'':'' ?>>
                        <span>Sopor</span>
                        <input type="checkbox" value="Somnolent" style="margin-left:50px" <?php echo isset($data->kesadaran)? $data->kesadaran == "SOPOROCOMA" ? "checked":'':'' ?>>
                        <span>Soporocoma</span>
                        <input type="checkbox" value="Koma" style="margin-left:50px" <?php echo isset($data->kesadaran)? $data->kesadaran == "KOMA" ? "checked":'':'' ?>>
                        <span>Coma</span>
                        </p>
                    </span>
                </div>

                <div>
                    
                        -	Kepala	:
                        <p style="margin-left: 20px;">		            		    			
                            <input type="checkbox" value="Mesosefal" <?php echo isset($data->kepala)? $data->kepala == "mesosefal" ? "checked":'':'' ?>>
                            <span>Mesosefal</span>
                            <input type="checkbox" value="Asimetris" <?php echo isset($data->kepala)? $data->kepala == "asimetris" ? "checked":'':'' ?>>
                            <span>Asimetris</span>
                            <input type="checkbox" value="Hematoma" <?php echo isset($data->kepala)? $data->kepala == "hematoma" ? "checked":'':'' ?>>
                            <span>Hematoma</span>
                            <input type="checkbox" value="Tidak ada masalah " <?php echo isset($data->kepala)? $data->kepala == "tidak_ada" ? "checked":'':'' ?>>
                            <span>Tidak ada masalah </span>
                            <input type="checkbox" value="" <?php echo isset($data->kepala)? $data->kepala == 'lainnya' ? "checked":'':'' ?>>
                            <span><?=' '.(isset($data->{'check_kepala'})?$data->{'check_kepala'}:'')?></span>
                        <p>
                    
                </div>

                <div>
                    
                    -	Rambut	:		  
                    <p style="margin-left: 20px;">          		    			
                        <input type="checkbox" value="Kotor" <?php echo isset($data->rambut)? $data->rambut == "kotor" ? "checked":'':'' ?>>
                        <span>Kotor</span>
                        <input type="checkbox" value="berminyak" <?php echo isset($data->rambut)? $data->rambut == "berminyak" ? "checked":'':'' ?>>
                        <span>berminyak</span>
                        <input type="checkbox" value="Kering" <?php echo isset($data->rambut)? $data->rambut == "kering" ? "checked":'':'' ?>>
                        <span>Kering</span>
                        <input type="checkbox" value="rontok" <?php echo isset($data->rambut)? $data->rambut == "rontok" ? "checked":'':'' ?>>
                        <span>rontok</span>
                        <input type="checkbox" value="Tidak ada masalah " <?php echo isset($data->rambut)? $data->rambut == "tidak_ada" ? "checked":'':'' ?>>
                        <span>Tidak ada masalah </span>
                        <input type="checkbox" value="" <?php echo isset($data->rambut)? $data->rambut == 'lainnya' ? "checked":'':'' ?>>
                            <span><?=' '.(isset($data->check_rambut)?$data->check_rambut:'')?></span>
                        
                    </p>
                </div>

                <div>
                        -	Muka	:	   
                        <p style="margin-left: 20px;">        		    			
                        <input type="checkbox" value=" Asimetris" <?php echo isset($data->muka)? $data->muka == "asimetris" ? "checked":'':'' ?>>
                        <span> Asimetris</span>
                        <input type="checkbox" value="Bells  palsy" <?php echo isset($data->muka)? $data->muka == "bells_palsy" ? "checked":'':'' ?>>
                        <span>Bells  palsy</span>
                        <input type="checkbox" value="Tic Facialis" <?php echo isset($data->muka)? $data->muka == "tic_facialis" ? "checked":'':'' ?>>
                        <span>Tic Facialis</span>
                        <input type="checkbox" value="Kelainaan kongonital" <?php echo isset($data->muka)? $data->muka == "kelainan_kongonital" ? "checked":'':'' ?>>
                        <span>Kelainaan kongonital</span>
                        <input type="checkbox" value="Tidak ada masalah " <?php echo isset($data->muka)? $data->muka == "tidak_ada" ? "checked":'':'' ?>>
                        <span>Tidak ada masalah </span>
                    </p>
                </div>

                <div>
                        -	Mata :	
                        <p style="margin-left: 20px;">      		    			
                        <input type="checkbox" value="Gangguan penglihatan" <?php echo isset($data->mata)? $data->mata == "gangguan_penglihatan" ? "checked":'':'' ?>>
                        <span>Gangguan penglihatan</span>
                        <input type="checkbox" value="Sclera anemis" <?php echo isset($data->mata)? $data->mata == "sclera_anemis" ? "checked":'':'' ?>>
                        <span>Sclera anemis</span>
                        <input type="checkbox" value="Konyungtivitis" <?php echo isset($data->mata)? $data->mata == "konyungtivitas" ? "checked":'':'' ?>>
                        <span>Konyungtivitis</span>
                        <input type="checkbox" value="Anisokor" <?php echo isset($data->mata)? $data->mata == "anisokor" ? "checked":'':'' ?>>
                        <span>Anisokor</span>
                        <input type="checkbox" value="Midriasis/miosis" <?php echo isset($data->mata)? $data->mata == "midriasis_miosis" ? "checked":'':'' ?>>
                        <span>Midriasis/miosis</span><br>
                        <span>
                        <input type="checkbox" value="Tidak ada reaksi cahaya" <?php echo isset($data->mata)? $data->mata == "reaksi_cahaya" ? "checked":'':'' ?>>
                        <span>Tidak ada reaksi cahaya</span>
                        <input type="checkbox" value="Tidak ada masalah" <?php echo isset($data->mata)? $data->mata == "tidak_ada_masalah" ? "checked":'':'' ?>>
                        <span>Tidak ada masalah</span>
                        <input type="checkbox" value="Ada alat bantu" <?php echo isset($data->mata)? $data->mata == 'ada_alat_bantu' ? "checked":'':'' ?>>
                        <span> Ada alat bantu, lokasi<?=' '.':'.(isset($data->check_mata)?$data->check_mata:'')?></span>
                    </p>
                </div>

                <div>
                    
                        -	Telinga	:    
                        <p style="margin-left: 20px;">      		    			
                        <input type="checkbox" value="Berdengung" <?php echo isset($data->telinga)? $data->telinga == "berdengung" ? "checked":'':'' ?>>
                        <span>Berdengung</span>
                        <input type="checkbox" value="Nyeri" <?php echo isset($data->telinga)? $data->telinga == "nyeri_ranap" ? "checked":'':'' ?>>
                        <span>Nyeri</span>
                        <input type="checkbox" value="Tuli" <?php echo isset($data->telinga)? $data->telinga == "tuli" ? "checked":'':'' ?>>
                        <span>Tuli</span>
                        <input type="checkbox" value="Keluar cairan" <?php echo isset($data->telinga)? $data->telinga == "keluar_cairan" ? "checked":'':'' ?>>
                        <span>Keluar cairan</span>
                        <input type="checkbox" value="Tidak ada masalah " <?php echo isset($data->telinga)? $data->telinga == "tidak_ada_masalah" ? "checked":'':'' ?>>
                        <span>Tidak ada masalah </span>
                        <input type="checkbox" value="" <?php echo isset($data->telinga)? $data->telinga == 'lainnya' ? "checked":'':'' ?>>
                        <span><?=' '.(isset($data->check_telinga)?$data->check_telinga:'')?></span>
                        
                    </p>
                </div>

                <div>
                    
                    -	Hidung	:
                    <p style="margin-left: 20px;">	       		    			
                        <input type="checkbox" value="Tidak ada masalah" <?php echo isset($data->hidung)? $data->hidung == "tidak_ada_masalah" ? "checked":'':'' ?>>
                        <span>Tidak ada masalah</span>
                        <input type="checkbox" value="asimetris" <?php echo isset($data->hidung)? $data->hidung == "asimetris" ? "checked":'':'' ?>>
                        <span>Asimetris</span>
                        <input type="checkbox" value="epistakis" <?php echo isset($data->hidung)? $data->hidung == "epistakis" ? "checked":'':'' ?>>
                        <span>Epistaksis</span>
                        <input type="checkbox" value="" <?php echo isset($data->hidung)? $data->hidung == 'lainnya' ? "checked":'':'' ?>>
                        <span><?=' '.(isset($data->chechk_hidung)?$data->chechk_hidung:'')?></span>
                        
                    </p> 
                </div>

                <div>
                        -	Mulut	:
                        <p style="margin-left: 20px;">				    			
                        <input type="checkbox" value="Simetris" <?php echo isset($data->mulut)? $data->mulut == "simetris" ? "checked":'':'' ?>>
                        <span>Simetris</span>
                        <input type="checkbox" value="asimetris" <?php echo isset($data->mulut)? $data->mulut == "asimetris" ? "checked":'':'' ?>>
                        <span>Asimetris</span>
                        <input type="checkbox" value="Bibir pucat" <?php echo isset($data->mulut)? $data->mulut == "bibir_pucat" ? "checked":'':'' ?>>
                        <span>Bibir pucat</span>
                        <input type="checkbox" value="Kelainan kongenital" <?php echo isset($data->mulut)? $data->mulut == "kelainan_kongenil" ? "checked":'':'' ?>>
                        <span>Kelainan kongenital</span>
                        <input type="checkbox" value="Tidak ada masalah" <?php echo isset($data->mulut)? $data->mulut == "tidak_ada_masalah" ? "checked":'':'' ?>>
                        <span>Tidak ada masalah</span>
                        <input type="checkbox" value="" <?php echo isset($data->mulut)? $data->mulut == 'lainnya' ? "checked":'':'' ?>>
                            <span><?=' '.(isset($data->check_mulut)?$data->check_mulut:'')?></span>
                        
                    </p> 
                </div>

                <div>
                    
                    -	Gigi	:
                    <p style="margin-left: 20px;">			    			
                        <input type="checkbox" value="Karies" <?php echo isset($data->gigi)? $data->gigi == "karies" ? "checked":'':'' ?>>
                        <span>Karies</span>
                        <input type="checkbox" value="Goyang" <?php echo isset($data->gigi)? $data->gigi == "goyang" ? "checked":'':'' ?>>
                        <span>Goyang</span>
                        <input type="checkbox" value="Tambal" <?php echo isset($data->gigi)? $data->gigi == "tambal" ? "checked":'':'' ?>>
                        <span>Tambal</span>
                        <input type="checkbox" value="Gigi palsu" <?php echo isset($data->gigi)? $data->gigi == "gigi_palsu" ? "checked":'':'' ?>>
                        <span>Gigi palsu</span>
                        <input type="checkbox" value="Tidak ada masalah" <?php echo isset($data->gigi)? $data->gigi == "tidak_ada_masalah" ? "checked":'':'' ?>>
                        <span>Tidak ada masalah</span>
                        <input type="checkbox" value="" <?php echo isset($data->gigi)? $data->gigi == 'lainnya' ? "checked":'':'' ?>>
                            <span><?=' '.(isset($data->chechk_gigi)?$data->chechk_gigi:'')?></span>
                        <span></span>
                    </p> 
                </div>

                <div>
                        
                    -	Lidah	:
                    <p style="margin-left: 20px;">				    			
                        <input type="checkbox" value="Kotor" <?php echo isset($data->lidah)? $data->lidah == "kotor" ? "checked":'':'' ?>>
                        <span>Kotor</span>
                        <input type="checkbox" value="Mukosa kering" <?php echo isset($data->lidah)? $data->lidah == "mukosa_kering" ? "checked":'':'' ?>>
                        <span>Mukosa kering</span>
                        <input type="checkbox" value="Gerakan asimetris" <?php echo isset($data->lidah)? $data->lidah == "gerakan_simetris" ? "checked":'':'' ?>>
                        <span>Gerakan asimetris</span>
                        <input type="checkbox" value="Tidak ada masalah" <?php echo isset($data->lidah)? $data->lidah == "tidak_ada_masalah" ? "checked":'':'' ?>>
                        <span>Tidak ada masalah</span>
                        <input type="checkbox" value="" <?php echo isset($data->lidah)? $data->lidah == 'lainnya' ? "checked":'':'' ?>>
                            <span><?=' '.(isset($data->chechk_lidah)?$data->chechk_lidah:'')?></span>
                        <span></span>
                    </p> 
                </div>

                <div>
                        
                    -	Tenggorokan	: 
                    <p style="margin-left: 20px;">	  			
                        <input type="checkbox" value="Faring merah" <?php echo isset($data->tenggorokan)? $data->tenggorokan == "faring_merah" ? "checked":'':'' ?>>
                        <span>Faring merah</span>
                        <input type="checkbox" value="Sakit menelan" <?php echo isset($data->tenggorokan)? $data->tenggorokan == "sakit_menelan" ? "checked":'':'' ?>>
                        <span>Sakit menelan</span>
                        <input type="checkbox" value="Tonsil membesar" <?php echo isset($data->tenggorokan)? $data->tenggorokan == "tonsil_membesar" ? "checked":'':'' ?>>
                        <span>Tonsil membesar</span>
                        <input type="checkbox" value="Tidak ada masalah" <?php echo isset($data->tenggorokan)? $data->tenggorokan == "tidak_ada_masalah" ? "checked":'':'' ?>>
                        <span>Tidak ada masalah</span>
                        <input type="checkbox" value="" <?php echo isset($data->tenggorokan)? $data->tenggorokan == 'lainnya' ? "checked":'':'' ?>>
                            <span><?=' '.(isset($data->check_tenggorokan)?$data->check_tenggorokan:'')?></span>
                        
                    </p> 
                </div>

                <div>
                        
                    -	Leher	:  	
                    <p style="margin-left: 20px;">		
                        <input type="checkbox" value="Pembesaran tiroid " <?php echo isset($data->tenggorokan)? $data->tenggorokan == "pembesaran_tiroid" ? "checked":'':'' ?>>
                        <span>Pembesaran tiroid </span>
                        <input type="checkbox" value="Pembesaran vena jugularis" <?php echo isset($data->tenggorokan)? $data->tenggorokan == "pembsaran_vena_jugularis" ? "checked":'':'' ?>>
                        <span>Pembesaran vena jugularis</span>
                        <input type="checkbox" value="Kaku kuduk" <?php echo isset($data->tenggorokan)? $data->tenggorokan == "kaku_kuduk" ? "checked":'':'' ?>>
                        <span>Kaku kuduk</span>
                        <input type="checkbox" value="Tidak ada kelaianan" <?php echo isset($data->tenggorokan)? $data->tenggorokan == "tidak_ada_kelainan" ? "checked":'':'' ?>>
                        <span>Tidak ada kelaianan</span><br>
                        <input type="checkbox" value="Keterbatasan gerak" <?php echo isset($data->tenggorokan)? $data->tenggorokan == "keterbatasan_gerak" ? "checked":'':'' ?>>
                        <span>Keterbatasan gerak</span>
                        <input type="checkbox" value="" <?php echo isset($data->leher)? $data->leher == 'lainnya' ? "checked":'':'' ?>>
                            <span><?=' '.(isset($data->check_leher)?$data->check_leher:'')?></span>
                        
                    </p> 
                </div>

                <div>
                    <p>	
                    -	Dada	: 	
                        
                        <input type="checkbox" value="Asimetris" <?php echo isset($data->dada)? $data->dada == "asimetris" ? "checked":'':'' ?>>
                        <span>Asimetris</span>
                        <input type="checkbox" value="Retrakal" <?php echo isset($data->dada)? $data->dada == "retral" ? "checked":'':'' ?>>
                        <span>Retrakal</span>
                        <input type="checkbox" value="Tidak ada kelaianan" <?php echo isset($data->dada)? $data->dada == "tidak_ada_kelalaian" ? "checked":'':'' ?>>
                        <span>Tidak ada kelaianan</span>
                        <input type="checkbox" value="lain-lain" <?php echo isset($data->dada)? $data->dada == 'lainnya' ? "checked":'':'' ?>>
                        <span><?=' '.(isset($data->check_dada)?$data->check_dada:'')?></span>
                    </p> 
                </div>
                            
            </div><br><br><br>
            <div style="display: inline; position: relative;font-size: 12px;">
                <div style="float: left;text-align: center;">
                    <p>Hal 1 dari 10</p>    
                </div>
                <div style="float: right;text-align: center;">
                    <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                </div>     
            </div> 
        </div>

    <!-- halaman 2 -->

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>
                <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                    ASESMEN AWAL KEPERAWATAN ANAK RAWAT INAP<br>
                </p>
                <div style="font-size:11px">
                    <div style="margin-left:40px">
                        <p>    
                        Respirasi 	:   			
                            <input type="checkbox" value="Tidak ada kesulitan" <?php echo isset($data->respirasi)? $data->respirasi == "tidak_ada" ? "checked":'':'' ?>>
                            <span>Tidak ada kesulitan</span>
                            <input type="checkbox" value="Nyeri" <?php echo isset($data->respirasi)? $data->respirasi == "nyeri_ranap" ? "checked":'':'' ?>>
                            <span>Nyeri</span>
                            <input type="checkbox" value="Batuk" <?php echo isset($data->respirasi)? $data->respirasi == "batk" ? "checked":'':'' ?>>
                            <span>Batuk</span>
                            <input type="checkbox" value="Dyspnea" <?php echo isset($data->respirasi)? $data->respirasi == "dyspnea" ? "checked":'':'' ?>>
                            <span>Dyspnea</span>
                            <input type="checkbox" value="Sputum" <?php echo isset($data->respirasi)? $data->respirasi == "sputum" ? "checked":'':'' ?>>
                            <span>Sputum</span>
                            <input type="checkbox" value="Tracheostomy" <?php echo isset($data->respirasi)? $data->respirasi == "tracheotomy" ? "checked":'':'' ?>>
                            <span>Tracheostomy</span><br>
                            <span style="margin-left: 80px;">   			
                            <input type="checkbox" value="Ronchi" <?php echo isset($data->respirasi)? $data->respirasi == "ronchi" ? "checked":'':'' ?>>
                            <span>Ronchi di paru kiri/kanan</span>
                            <input type="checkbox" value="Wheezing" <?php echo isset($data->respirasi)? $data->respirasi == "wheezing" ? "checked":'':'' ?>>
                            <span>Wheezing</span>
                            <input type="checkbox" value="Nafas pendek" <?php echo isset($data->respirasi)? $data->respirasi == "nafas" ? "checked":'':'' ?>>
                            <span>Nafas pendek</span>
                            <input type="checkbox" value="Haemaptoe" <?php echo isset($data->respirasi)? $data->respirasi == "haemaptoe" ? "checked":'':'' ?>>
                            <span>Haemaptoe</span><br>
                            <span style="margin-left: 80px;">   			
                            <input type="checkbox" value="Bradipnea" <?php echo isset($data->respirasi)? $data->respirasi == "bradipnea" ? "checked":'':'' ?>>
                            <span>Bradipnea</span>
                            <input type="checkbox" value="Takpnea" <?php echo isset($data->respirasi)? $data->respirasi == "takpnea" ? "checked":'':'' ?>>
                            <span>Takpnea</span>
                            <input type="checkbox" value="Sleep apnea" <?php echo isset($data->respirasi)? $data->respirasi == "sleep" ? "checked":'':'' ?>>
                            <span >Sleep apnea</span><br>
                            <input type="checkbox" value="Sleep apnea" style="margin-left: 80px;" <?php echo isset($data->respirasi)? $data->respirasi == "alat_bantu_nafas" ? "checked":'':'' ?>>
                            <span>Alat bantu nafas saat dirumah :</span>
                            
                            <input type="checkbox" value="Takpnea" <?php echo isset($data->check_ya_tidak)? $data->check_ya_tidak == "ya" ? "checked":'':'' ?>>
                            <span>tidak</span>
                            <input type="checkbox" value="Takpnea" <?php echo isset($data->check_ya_tidak)? $data->check_ya_tidak == "tidak" ? "checked":'':'' ?>>
                            <span>ya, <?=' '.(isset($data->check_alat_bantu)?$data->check_alat_bantu:'')?></span>

                            <input type="checkbox" value="lain-lain" <?php echo isset($data->respirasi)? $data->respirasi == 'lainnya' ? "checked":'':'' ?>>
                            <span><?=' '.(isset($data->chechk_respira)?$data->chechk_respira:'')?></span><br>
                            
                        </p> 
                    </div> 
                    
                    <div style="margin-left:40px">
                        <p>     
                        Jantung 	:  			
                            <input type="checkbox" value="nyeri_dada" <?php echo isset($data->jantung)?$data->jantung == 'nyeri_dada'?'checked':'':''  ?>>
                            <span>Nyeri Dada</span>
                            <input type="checkbox" value="Aritmia" <?php echo isset($data->jantung)?$data->jantung == 'aritmia'?'checked':'':''  ?>>
                            <span>Aritmia</span>
                            <input type="checkbox" value=" Palpitasi " <?php echo isset($data->jantung)?$data->jantung == 'palpitasi'?'checked':'':''  ?>>
                            <span> Palpitasi </span><br>

                            <input type="checkbox" value="Pacemaker" style="margin-left: 68px;" <?php echo isset($data->jantung)?$data->jantung == 'pancamaker'?'checked':'':''  ?>>
                            <span>Pacemaker,<?=' '.(isset($data->check_pancaker)?$data->check_pancaker:'')?></span>
                            <input type="checkbox" value="Pingsan" <?php echo isset($data->jantung)?$data->jantung == 'pingsan'?'checked':'':''  ?>>
                            <span> Pingsan</span>
                            <input type="checkbox" value=" Tachikardia" <?php echo isset($data->jantung)?$data->jantung == 'tachikardia'?'checked':'':''  ?>>
                            <span> Tachikardia</span>
                            <input type="checkbox" value="Bradikardi" <?php echo isset($data->jantung)?$data->jantung == 'bradikardi'?'checked':'':''  ?>>
                            <span>Bradikardi</span>
                            <input type="checkbox" value="lain-lain" <?php echo isset($data->jantung)?$data->jantung == 'lainnya'?'checked':'':''  ?>>
                            <span><?=' '.(isset($data->check_jantung)?$data->check_jantung:'')?></span>
                        </p> 
                    </div>

                    <div>
                        
                        -	Abdomen	:
                        <p style="margin-left:20px"> 			
                            <input type="checkbox" value="Distensi"
                            <?php echo isset($data->abdomen)?$data->abdomen == 'distensi '?'checked':'':''  ?>>
                            <span>Distensi</span>
                            <input type="checkbox" value="Asites"  <?php echo isset($data->abdomen)?$data->abdomen == 'asites'?'checked':'':''  ?>>
                            <span>Asites</span>
                            <input type="checkbox" value="Jumlah bising usus" <?php echo isset($data->abdomen)?$data->abdomen == 'jumlah bising usus'?'checked':'':''  ?>>
                            <span>Jumlah bising usus<?=' '.':'.(isset($data->jumlah_usus)?$data->jumlah_usus:'').' '.'x/menit'?></span>
                            <input type="checkbox" value="Tidak ada kelaianan" <?php echo isset($data->abdomen)?$data->abdomen == 'tidak ada kelainan '?'checked':'':''  ?>>
                            <span>Tidak ada kelaianan</span>
                            <input type="checkbox" value="lain-lain" <?php echo isset($data->abdomen)?$data->abdomen == 'lainnya' ?'checked':'':''  ?>>
                            <span><?=' '.(isset($data->check_abodemen2)?$data->check_abodemen2:'')?></span>
                        </p> 
                    </div>

                    <div>
                            <p>    
                                -	Integumen <br>
                                <p style="margin-left:25px">		
                                    <input type="checkbox" value="Turgor" <?php echo isset($data->integumen)?$data->integumen == 'turgor'?'checked':'':''  ?>>
                                    <span>Turgor<?=':'.(isset($data->check_tugor)?$data->check_tugor:'')?></span>
                                    <input type="checkbox" value="Dingin" <?php echo isset($data->integumen)?$data->integumen == 'dingin'?'checked':'':''  ?>>
                                    <span>Dingin</span>
                                    <input type="checkbox" value="Bula" <?php echo isset($data->integumen)?$data->integumen == 'bula'?'checked':'':''  ?>>
                                    <span>Bula</span>
                                    <input type="checkbox" value="Fistula" <?php echo isset($data->integumen)?$data->integumen == 'fistula'?'checked':'':''  ?>>
                                    <span>Fistula</span>
                                    <input type="checkbox" value="Pucat" <?php echo isset($data->integumen)?$data->integumen == 'pucat'?'checked':'':''  ?>>
                                    <span>Pucat </span>
                                    <input type="checkbox" value="Baal" <?php echo isset($data->integumen)?$data->integumen == 'baal'?'checked':'':''  ?>>
                                    <span>Baal </span><br>
                                    <input type="checkbox" value="RL positif" <?php echo isset($data->integumen)?$data->integumen == 'rl positif'?'checked':'':''  ?>>
                                    <span>RL positif</span>
                                    <input type="checkbox" value="Rash/kemerahan" <?php echo isset($data->integumen)?$data->integumen == 'rash / kemerahan'?'checked':'':''  ?>>
                                    <span>Rash/kemerahan</span>
                                    <input type="checkbox" value="Lesi" <?php echo isset($data->integumen)?$data->integumen == 'lesi'?'checked':'':''  ?>>
                                    <span>Lesi</span><br>
                                    <span>
                                    <input type="checkbox" value="Luka parut" <?php echo isset($data->integumen)?$data->integumen == 'luka parut '?'checked':'':''  ?>>
                                    <span>Luka parut</span>
                                    <input type="checkbox" value="Diaphoresis" <?php echo isset($data->integumen)?$data->integumen == 'diaphoresis / banyak berkeringan'?'checked':'':''  ?>>
                                    <span>Diaphoresis/banyak berkeringat</span>
                                    <input type="checkbox" value="Memar" <?php echo isset($data->integumen)?$data->integumen == 'memar'?'checked':'':''  ?>>
                                    <span>Memar</span>
                                    <input type="checkbox" value="Ada indikasi kekerasan fisik" <?php echo isset($data->integumen)?$data->integumen == 'ada indikasi kekerasan fisik'?'checked':'':''  ?>>
                                    <span>Ada indikasi kekerasan fisik</span>
                                    <input type="checkbox" value="Tidak ada kelaianan" <?php echo isset($data->integumen)?$data->integumen == 'tidak ada kelainan'?'checked':'':''  ?>>
                                    <span>Tidak ada kelaianan</span>
                                    <input type="checkbox" value="lain-lain" <?php echo isset($data->integumen)?$data->integumen == 'lainnya'?'checked':'':''  ?>>
                                    <span><?=(isset($data->check_intugemen)?$data->check_intugemen:'')?></span>
                                </span><br>
                                <span>
                                    Ada luka / pressure  
                                    <input type="checkbox" value="Ya"  <?php echo isset($data->pressure)?$data->pressure == true?'checked':'':''  ?>>
                                    <span>Ya</span>
                                    <input type="checkbox" value="Tidak"  <?php echo isset($data->pressure)?$data->pressure == false?'checked':'':''  ?>>
                                    <span>Tidak</span>
                                </span><br>
                                <span>	Bila da di area : <?=(isset($data->bila_ada_luka)?$data->bila_ada_luka:'')?><br>
                                <span> Asesmen Dekubitus ( Skala Norton)<br><br>
                                <span> Berikan tanda (√) sesuai  kondisi pasien Skore
                                </span>
                                <table id="data" border="1" style="font-size:11px">
                                    <tr>
                                    <th style="width: 5%;">Skor</th>
                                    <th style="width: 15%;">Kondisi Umum</th>
                                    <th style="width: 5%;">(√)</th>
                                    <th style="width: 15%;">Kondisi Mental</th>
                                    <th style="width: 5%;">(√)</th>
                                    <th style="width: 15%;">Aktivitas</th>
                                    <th style="width: 5%;">(√)</th>
                                    <th style="width: 15%;">Mobilitas</th>
                                    <th style="width: 5%;">(√)</th>
                                    <th style="width: 15%;">Inkontinensia</th>
                                    <th style="width: 5%;">(√)</th>
                                    <th style="width: 15%;">Total Skore</th>
                                    </tr>

                                    <tr>
                                        <td style="width: 5%;font-size:11px;text-align:center">4</td>
                                        <td style="width: 15%;font-size:11px;text-align:center">Baik</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'1'})?$data->assesment_dekubitis->result->{'1'} == '4'?'√':'':''  ?></td>
                                        <td style="width: 15%;font-size:11px;text-align:center">Waspada</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'2'})?$data->assesment_dekubitis->result->{'2'} == '4'?'√':'':''  ?></td>
                                        <td style="width: 15%;font-size:11px;text-align:center">Ambulasi baik</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'3'})?$data->assesment_dekubitis->result->{'3'} == '4'?'√':'':''  ?></td>
                                        <td style="width: 15%;font-size:11px;text-align:center">Penuh</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'4'})?$data->assesment_dekubitis->result->{'4'} == '4'?'√':'':''  ?></td>
                                        <td style="width: 15%;font-size:11px;text-align:center">Kontinen</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'5'})?$data->assesment_dekubitis->result->{'5'} == '4'?'√':'':''  ?></td>
                                        <td style="width: 15%;font-size:11px;text-align:center"></td>
                                    </tr>

                                    <tr>
                                        <td style="width: 5%;font-size:11px;text-align:center">3</td>
                                        <td style="width: 15%;font-size:11px;text-align:center">Cukup</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'1'})?$data->assesment_dekubitis->result->{'1'} == '3'?'√':'':''  ?></td>
                                        <td style="width: 15%;font-size:11px;text-align:center">Apatis</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'2'})?$data->assesment_dekubitis->result->{'2'} == '3'?'√':'':''  ?></td>
                                        <td style="width: 15%;font-size:11px;text-align:center">Perlu bantuan</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'3'})?$data->assesment_dekubitis->result->{'3'} == '3'?'√':'':''  ?></td>
                                        <td style="width: 15%;font-size:11px;text-align:center">Terbatas</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'4'})?$data->assesment_dekubitis->result->{'4'} == '3'?'√':'':''  ?></td>
                                        <td style="width: 15%;font-size:11px;text-align:center">Kadang inkontinen</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'5'})?$data->assesment_dekubitis->result->{'5'} == '3'?'√':'':''  ?></td>
                                        <td style="width: 15%;font-size:11px;text-align:center"></td>
                                    </tr>

                                    <tr>
                                        <td style="width: 5%;font-size:11px;text-align:center">2</td>
                                        <td style="width: 15%;font-size:11px;text-align:center">Lemah</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'1'})?$data->assesment_dekubitis->result->{'1'} == '2'?'√':'':''  ?></td>
                                        <td style="width: 15%;font-size:11px;text-align:center">Bingung</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'2'})?$data->assesment_dekubitis->result->{'2'} == '2'?'√':'':''  ?></td>
                                        <td style="width: 15%;font-size:11px;text-align:center">Tak bisa pindah bed</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'3'})?$data->assesment_dekubitis->result->{'3'} == '2'?'√':'':''  ?></td>
                                        <td style="width: 15%;font-size:11px;text-align:center">Sangat terbatas</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'4'})?$data->assesment_dekubitis->result->{'4'} == '2'?'√':'':''  ?></td>
                                        <td style="width: 15%;font-size:11px;text-align:center">Inkontinen BAK</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'5'})?$data->assesment_dekubitis->result->{'5'} == '2'?'√':'':''  ?></td>
                                        <td style="width: 15%;font-size:11px;text-align:center"></td>
                                    </tr>

                                    <tr>
                                        <td style="width: 5%;font-size:11px;text-align:center">1</td>
                                        <td style="width: 10%;font-size:11px;text-align:center">Sangat lemah</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'1'})?$data->assesment_dekubitis->result->{'1'} == '1'?'√':'':''  ?></td>
                                        <td style="width: 10%;font-size:11px;text-align:center">Tak sadar</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'2'})?$data->assesment_dekubitis->result->{'2'} == '1'?'√':'':''  ?></td>
                                        <td style="width: 10%;font-size:11px;text-align:center">Tak bergerak</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'3'})?$data->assesment_dekubitis->result->{'3'} == '1'?'√':'':''  ?></td>
                                        <td style="width: 10%;font-size:11px;text-align:center">Imobilisasi</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'4'})?$data->assesment_dekubitis->result->{'4'} == '1'?'√':'':''  ?></td>
                                        <td style="width: 10%;font-size:11px;text-align:center">Inkonkontinen BAB & BAK</td>
                                        <td style="width: 5%;font-size:11px;text-align:center"><?php echo isset($data->assesment_dekubitis->result->{'5'})?$data->assesment_dekubitis->result->{'5'} == '1'?'√':'':''  ?></td>
                                        <td style="width: 10%;font-size:11px;text-align:center"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="11" style="text-align: right;">Jumlah</td>
                                        <td style="width: 15%;text-align:center"><?=(isset($data->assesment_dekubitis->result->total_skor)?$data->assesment_dekubitis->result->total_skor:'')?></td>
                                    </tr>
                                    
                                </table><br>
                                <input type="checkbox" <?php echo isset($data->assesment_dekubitis->result->kategori)?$data->assesment_dekubitis->result->kategori == 'Tinggi (>14)'?'checked':'':''  ?>>
                                <span>Resiko tinggi : > 14</span>
                            
                                <input type="checkbox"  style="margin-left: 80px;" <?php echo isset($data->assesment_dekubitis->result->kategori)?$data->assesment_dekubitis->result->kategori == 'Sedang ( 12-13)'?'checked':'':''  ?>>
                                <span>Resiko sedang : 12 – 13</span>
                                
                                <input type="checkbox" style="margin-left: 70px;" <?php echo isset($data->assesment_dekubitis->result->kategori)?$data->assesment_dekubitis->result->kategori == 'Rendah ( > 14 )'?'checked':'':''  ?>>
                                <span>Resiko rendah : < 14</span>
                            </p> 
                        </p>
                    </div>

                    <div>
                            <span>
                            <span>-	question107	:</span><br>
                            <p style="margin-left:25px">
                            
                            <!-- <span>Kekuatan otot <?=' '.':'.(isset($data->question6)?$data->question6:'')?></span> -->

                            <input type="checkbox" value="Kejang" <?php echo isset($data->question107)?$data->question107 == 'kejang'?'checked':'':''  ?>>
                            <span>Kejang</span>

                            <input type="checkbox" value="Tremor " <?php echo isset($data->question107)?$data->question107 == 'tremor'?'checked':'':''  ?>>
                            <span>Tremor </span>

                            <input type="checkbox" value="Plegi" <?php echo isset($data->question107)?$data->question107 == 'plegi'?'checked':'':''  ?>>
                            <span>Plegi di <?=' '.':'.(isset($data->question109)?$data->question109:'')?></span><br>

                            <input type="checkbox" value="Parese" <?php echo isset($data->question107)?$data->question107 == 'pararese'?'checked':'':''  ?>>
                            <span>Parese di <?=' '.':'.(isset($data->question110)?$data->question110:'')?> </span>

                            <input type="checkbox" value="Kelainan kongenital" <?php echo isset($data->question107)?$data->question107 == 'kelainan_kongenital'?'checked':'':''  ?>>
                            <span>Kelainan kongenital  </span>

                            <input type="checkbox" value="Inkoordinasi " <?php echo isset($data->question107)?$data->question107 == 'inkordinasi'?'checked':'':''  ?>>
                            <span>Inkoordinasi  </span>

                            <input type="checkbox" value="Edema" <?php echo isset($data->question107)?$data->question107 == 'edeme'?'checked':'':''  ?>>
                            <span>Edema </span>

                            <input type="checkbox" value="Rasa baal" <?php echo isset($data->question107)?$data->question107 == 'rasa_baal'?'checked':'':''  ?>>
                            <span>Rasa baal</span>

                            <input type="checkbox" value="Tidak ada kelaianan" <?php echo isset($data->question107)?$data->question107 == 'tidak_ada_kelaaian'?'checked':'':''  ?>>
                            <span>Tidak ada kelaianan </span><br>

                            <input type="checkbox" name="" id=""  <?php echo isset($data->kekuatan_otot)?(in_array("kekuatan_otot", $data->kekuatan_otot) ? "checked" : "disabled"):""; ?>>
                            <span>Kekuatan Otot</span>

                            <span>
                                <table  width="10%">
                                    <tr style="border-bottom:1px solid black">
                                        <td style="font-size:15pt;text-align:center;border-right:1px solid black;"><?= isset($data->tangan_kanan)?($data->tangan_kanan?$data->tangan_kanan :''):'' ?></td>
                                        <td style="font-size:15pt;text-align:center;"><?= isset($data->tangan_kiri)?($data->tangan_kiri?$data->tangan_kiri :''):"" ?></td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:15pt;text-align:center;border-right:1px solid black;"><?= isset($data->kaki_kanan)?($data->kaki_kanan?$data->kaki_kanan :''):"" ?></td>
                                        <td style="font-size:15pt;text-align:center;"><?= isset($data->kaki_krir)?($data->kaki_krir?$data->kaki_krir :''):"" ?></td>
                                    </tr>
                                </table>
                            </span>
                            
                            </span>
                            </p>
                    </div>

                    <div>
                            
                            <span>-	Genetalia	:</span><br>
                            <p style="margin-left:25px">
                            <input type="checkbox" value="Keputihan" <?php echo isset($data->question111)?$data->question111 == 'keputihan'?'checked':'':''  ?>>
                            <span>Keputihan</span>
                            <input type="checkbox" value="Kotor" <?php echo isset($data->question111)?$data->question111 == 'kotor'?'checked':'':''  ?>>
                            <span>Kotor</span>
                            <input type="checkbox" value=" Berbau" <?php echo isset($data->question111)?$data->question111 == 'berbau'?'checked':'':''  ?>>
                            <span> Berbau</span>
                            <input type="checkbox" value="Tidak ada kelaianan" <?php echo isset($data->question111)?$data->question111 == 'tidak_ada_kelainan'?'checked':'':''  ?>>
                            <span>Tidak ada kelaianan</span>
                            <input type="checkbox" value="Lain-lain"<?php echo isset($data->question111)?$data->question111 == 'lainnya'?'checked':'':''  ?>>
                            <span>Lain-lain<?=' '.':'.(isset($data->question112)?$data->question112:'')?></span>
                            </p>
                            
                    </div>

                    <div>
                        <span style="margin-left:25px">-Eliminasi	:</span><br>
                        <p style="margin-left:25px">

                            <span >BAB  :</span><br>
                            <input type="checkbox" value="Normal" <?php echo isset($data->question114)?$data->question114 == 'normal'?'checked':'':''  ?>>
                            <span>Normal</span>
                            <input type="checkbox" value="Konstipasi" <?php echo isset($data->question114)?$data->question114 == 'konstipasi'?'checked':'':''  ?>>
                            <span>Konstipasi</span>
                            <input type="checkbox" value="Diare" <?php echo isset($data->question114)?$data->question114 == 'diare'?'checked':'':''  ?>>
                            <span>Diare</span>
                            <input type="checkbox" value="Frekwensi BAB/hari" <?php echo isset($data->question114)?$data->question114 == 'frekwensi_bab'?'checked':'':''  ?>>
                            <span>Frekwensi BAB<?=' '.':'.(isset($data->question115)?$data->question115:'').' '.'/hari'?></span><br>
                            <input type="checkbox" value="inkontinensia alvi" <?php echo isset($data->question114)?$data->question114 == 'inkontenensia_alvi'?'checked':'':''  ?>>
                            <span>inkontinensia alvi  </span>
                            <input type="checkbox" value="ileostomy"  <?php echo isset($data->question114)?$data->question114 == 'ileostomy'?'checked':'':''  ?>>
                            <span>ileostomy</span>
                            <input type="checkbox" value="Colosstomy" <?php echo isset($data->question114)?$data->question114 == 'colosstomy'?'checked':'':''  ?>>
                            <span>Colosstomy ,jelaskan <?=' '.':'.(isset($data->question117)?$data->question117:'')?></span><br>
                            <input type="checkbox" value="Colosstomy" <?php echo isset($data->question114)?$data->question114 == 'lainnya'?'checked':'':''  ?>>
                            <span>Colosstomy ,jelaskan <?=' '.':'.(isset($data->question116)?$data->question116:'')?></span><br><br>
                            

                            <span >BAK  :</span><br>
                            <input type="checkbox" value="Normal" <?php echo isset($data->question118)?$data->question118 == 'normal'?'checked':'':''  ?>>
                            <span>Normal</span>
                            <input type="checkbox" value="Inkontinensia urin" <?php echo isset($data->question118)?$data->question118 == 'inkontinensia_urin'?'checked':'':''  ?>>
                            <span>Inkontinensia urin </span>
                            <input type="checkbox" value="hematuria" <?php echo isset($data->question118)?$data->question118 == 'heamturia'?'checked':'':''  ?>>
                            <span>Hematuria</span>
                            <input type="checkbox" value="Disuria" <?php echo isset($data->question118)?$data->question118 == 'disuria'?'checked':'':''  ?>>
                            <span>Disuria</span>
                            <input type="checkbox" value="Urin menetes" <?php echo isset($data->question118)?$data->question118 == 'urin_menetas'?'checked':'':''  ?>>
                            <span>Urin menetes </span><br>
                            <input type="checkbox" value="Nocturia" <?php echo isset($data->question118)?$data->question118 == 'nocturial / sering kencing malam hari '?'checked':'':''  ?>>
                            <span>Nocturia/ sering kencing malam hari </span>
                            <input type="checkbox" value="Kateter" <?php echo isset($data->question118)?$data->question118 == 'keteter'?'checked':'':''  ?>>
                            <span>Kateter</span>
                            <input type="checkbox" value="Kateter" <?php echo isset($data->question118)?$data->question118 == 'other'?'checked':'':''  ?>>
                            <span>Lainnya</span><br><br>
                        </p>
                    </div>

                    <p><b>2. ALASAN MASUK RUMAH SAKIT </b></p>
                    <p style="margin-left:25px;min-height:120px"><?=(isset($data->question129)?$data->question129:'')?></p>

                </div>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 2 dari 10</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
            
        </div>

    <!-- halaman 3 -->

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
                <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                    ASESMEN AWAL KEPERAWATAN ANAK RAWAT INAP<br>
                </p>
                <div style="font-size:11px">
                    <span><b>3. RIWAYAT KESEHATAN</b></span><br>
                    <div style="margin-left:25px">

                        <p>
                            <p>-	Pernah di rawat</p>
                            <input type="checkbox" value="Tidak" style="margin-left: 12px;" <?php echo isset($data->question131)?$data->question131 == 'tidak'?'checked':'':''  ?>>
                            <span>Tidak</span>
                            <input type="checkbox" value="Ya" <?php echo isset($data->question131)?$data->question131 != 'tidak'?'checked':'':''  ?>>
                            <span>Ya, </span>
                            <span>Diagnosis : <?=(isset($data->question132)?$data->question132:'')?></span><br>
                            <p style="margin-left: 12px;">Kapan : <?=(isset($data->question133)?$data->question133:'')?></p>
                            <p style="margin-left: 12px;">Dimana : <?=(isset($data->question134)?$data->question134:'')?></p>
                        </p>

                        <p>-	Alat Implant yang terpasang : <?=(isset($data->question135)?$data->question135:'')?></p>
                        

                        <p>- Riwayat Transfusi Darah  :</p>
                        <input type="checkbox" value="Tidak" style="margin-left: 12px;" <?php echo isset($data->question136)?$data->question136 == 'tidak'?'checked':'':''  ?>>
                        <span>Tidak</span>
                        <input type="checkbox" value="Pernah" <?php echo isset($data->question136)?$data->question136 == 'pernah'?'checked':'':''  ?>>
                        <span>Pernah</span>
                        <input type="checkbox" value="Reaksi Alergi?" <?php echo isset($data->transfusi_darah)?$data->transfusi_darah == 'reaksi_alergi'?'checked':'':''  ?>>
                        <span>Reaksi Alergi?</span>
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question137)?$data->question137 != 'ya'?'checked':'':''  ?>>
                        <span>Tidak</span>
                        <input type="checkbox" value="Ya" <?php echo isset($data->question137)?$data->question137 == 'ya'?'checked':'':''  ?>>
                        <span>Ya</span>
                        <p style="margin-left: 12px;">Jika ya, jelaskan reaksi yang timbul :<?=(isset($data->question138)?$data->question138:'')?></p>
                        </span>
                        <p style="margin-left: 12px;">Golongan Darah : <?=(isset($data->golongan_darah)?$data->golongan_darah:'')?></p>

                        <p>- Riwayat Penyakit Keluarga  :</p>
                        <input type="checkbox" value="Diabetes "style="margin-left: 12px;" <?php echo isset($data->question139)?$data->question139 == 'diabetes'?'checked':'':''  ?>>
                        <span>Diabetes </span>
                        <input type="checkbox" value=" Cancer" <?php echo isset($data->question139)?$data->question139 == 'cancer'?'checked':'':''  ?>>
                        <span> Cancer</span>
                        <input type="checkbox" value="Jantung" <?php echo isset($data->question139)?$data->question139 == 'jantung'?'checked':'':''  ?>>
                        <span>Jantung</span>
                        <input type="checkbox" value="Hipertensi" <?php echo isset($data->question139)?$data->question139 == 'hipertensi'?'checked':'':''  ?>>
                        <span>Hipertensi</span>
                        <input type="checkbox" value="lain-lain" <?php echo isset($data->question139)?$data->question139 == 'lain'?'checked':'':''  ?>>
                        <span>lain-lain, sebutkan</span>
                        
                    </div>

                    <p><b>4. SOSIAL EKONOMI</b></p>
                    <div style="margin-left:25px">
                            <p>
                                Saudara : 
                                <input type="checkbox" value="Kandung" <?php echo isset($data->saudara)?$data->saudara == 'kandung'?'checked':'':''  ?>>
                                <span>Kandung, jumlah<?=(isset($data->check_kandung)?' '.$data->check_kandung.' ':'')?>orang</span>
                                <input type="checkbox" value="Tiri" <?php echo isset($data->saudara)?$data->saudara == 'tiri'?'checked':'':''  ?>>
                                <span>Tiri,<?=(isset($data->check_tiri)?' '.$data->check_tiri.' ':'')?>orang</span> 
                            </p>
                            <p>
                                Pendidikan saat ini  : 
                                <input type="checkbox" value="Belum sekolah" <?php echo isset($data->pendidikan)?$data->pendidikan == 'Belum / Tdk Sekolah'?'checked':'':''  ?>>
                                <span>Belum sekolah</span>
                                <input type="checkbox" value="SD" <?php echo isset($data->pendidikan)?$data->pendidikan == 'SD'?'checked':'':''  ?>>
                                <span>SD</span>
                                <input type="checkbox" value="SMP" <?php echo isset($data->pendidikan)?$data->pendidikan == 'SLTP'?'checked':'':''  ?>>
                                <span>SLTP</span>
                                <input type="checkbox" value="SMA/SMK" <?php echo isset($data->pendidikan)?$data->pendidikan == 'SMA'?'checked':'':''  ?>>
                                <span>SMA/SMK</span>
                                <input type="checkbox" value="SMA/SMK" <?php echo isset($data->pendidikan)?$data->pendidikan == 'DIII'?'checked':'':''  ?>>
                                <span>DIII</span>
                                <input type="checkbox" value="SMA/SMK" <?php echo isset($data->pendidikan)?$data->pendidikan == 'SI/DIV'?'checked':'':''  ?>>
                                <span>SI/DIV</span>
                            
                            </p>
                            <p>
                                Pekerjaan orangtua : 
                                <input type="checkbox" value=" PNS " <?php echo isset($data->pekerjaan)?$data->pekerjaan == 'PNS/Pol/TNI'?'checked':'':''  ?>>
                                <span> PNS </span>
                                <input type="checkbox" value="Swasta" <?php echo isset($data->pekerjaan)?$data->pekerjaan == 'Karyawan Swasta'?'checked':'':''  ?>>
                                <span>Swasta</span>
                                <input type="checkbox" value="Swasta" <?php echo isset($data->pekerjaan)?$data->pekerjaan == 'Ibu Rumah Tangga'?'checked':'':''  ?>>
                                <span>IRT</span>
                                <input type="checkbox" value="Swasta" <?php echo isset($data->pekerjaan)?$data->pekerjaan == 'Dagang'?'checked':'':''  ?>>
                                <span>Dagang</span>
                                <input type="checkbox" value="Swasta" <?php echo isset($data->pekerjaan)?$data->pekerjaan == 'Buruh'?'checked':'':''  ?>>
                                <span>Buruh</span>
                                <input type="checkbox" value="Swasta" <?php echo isset($data->pekerjaan)?$data->pekerjaan == 'Pelajar  Mahasiswa'?'checked':'':''  ?>>
                                <span>Pelajar/Mahasiswa</span>
                                <input type="checkbox" value="Lain-lainya" <?php echo isset($data->pekerjaan)?$data->pekerjaan == 'Lainnya'?'checked':'':''  ?>>
                                <span>Lainnya</span>
                            </p>
                            <p>
                                Warga Negara  :  
                                <input type="checkbox" value="WNI" <?php echo isset($data->wnegara)?$data->wnegara == 'WNI'?'checked':'':''  ?>>
                                <span>WNI</span>
                                <input type="checkbox" value="WNA" <?php echo isset($data->wnegara)?$data->wnegara == 'WNA'?'checked':'':''  ?>>
                                <span>WNA</span>
                            </p>
                            <p>
                                Tinggal bersama : 
                                <input type="checkbox" value="Orang tua" <?php echo isset($data->tinggal_bersama)?$data->tinggal_bersama == 'orang_tua'?'checked':'':''  ?>>
                                <span>Orang tua</span>
                                <input type="checkbox" value="Sendiri" <?php echo isset($data->tinggal_bersama)?$data->tinggal_bersama == 'sendiri'?'checked':'':''  ?>>
                                <span>Sendiri</span>
                                <input type="checkbox" value="lain-lain" <?php echo isset($data->tinggal_bersama)?$data->tinggal_bersama == 'lainnya'?'checked':'':''  ?>>
                                <span>lain-lain, sebutkan</span>
                            </p><br>
                    </div>

                    <span><b>5. PSIKOSOSIAL SPIRITUAL</b></span><br>

                    <div style="margin-left:25px">
                            <p><b>SPIRITUAL</b></p>
                            <p>
                                Agama : 
                                <input type="checkbox" value="Islam" <?php echo isset($data->agama)?$data->agama == 'ISLAM'?'checked':'':''  ?>>
                                <span>Islam </span>
                                <input type="checkbox" value="Kristen" <?php echo isset($data->agama)?$data->agama == 'KRISTEN'?'checked':'':''  ?>>
                                <span>Kristen</span>
                                <input type="checkbox" value=" Katolik " <?php echo isset($data->agama)?$data->agama == 'KATHOLIK'?'checked':'':''  ?>>
                                <span> Katolik </span>
                                <input type="checkbox" value="Hindu " <?php echo isset($data->agama)?$data->agama == 'HINDU'?'checked':'':''  ?>>
                                <span>Hindu </span>
                                <input type="checkbox" value=" Budha " <?php echo isset($data->agama)?$data->agama == 'BUDHA'?'checked':'':''  ?>>
                                <span> Budha </span>
                            </p>
                            <p>Identifikasi Nilai : </p>
                            <ol>
                                <li><?=(isset($data->identifikasi->{'1'})?$data->identifikasi->{'1'}:'')?></li>
                                <li><?=(isset($data->identifikasi->{'2'})?$data->identifikasi->{'2'}:'')?></li>
                                <li><?=(isset($data->identifikasi->{'3'})?$data->identifikasi->{'3'}:'')?></li>
                            </ol>
                            <p>Kegiatan keagamaan yang biasa dilakukan (di isi pada anak usaia > 6 tahun ) : <?=(isset($data->kegiatan_anak)?$data->kegiatan_anak:'')?></p>


                            <p><b>PSIKOLOGIS</b></p>
                            <input type="checkbox" value="Cemas" <?php echo isset($data->psikologi)?$data->psikologi == 'cemas'?'checked':'':''  ?>>
                            <span>Cemas</span>
                            <input type="checkbox" value="Marah" <?php echo isset($data->psikologi)?$data->psikologi == 'marah'?'checked':'':''  ?>>
                            <span>Marah</span>
                            <input type="checkbox" value="Sedih" <?php echo isset($data->psikologi)?$data->psikologi == 'takut_therapy'?'checked':'':''  ?>>
                            <span>Sedih</span>
                            <input type="checkbox" value="Kecendrungan bunuh diri" <?php echo isset($data->psikologi)?$data->psikologi == 'tegang'?'checked':'':''  ?>>
                            <span>Tegang</span><br>
                            <input type="checkbox" value="Takut terhadap therapy" <?php echo isset($data->psikologi)?$data->psikologi == 'takut'?'checked':'':''  ?>>
                            <span>Takut terhadap therapy/pembedahan/lingkungan RS    </span>
                            <input type="checkbox" value="Lain-lainnya" <?php echo isset($data->psikologi)?$data->psikologi == 'lainnya'?'checked':'':''  ?>>
                            <span>Lain-lainnya  </span>

                            <p>
                                Anak Kandung :   
                                <input type="checkbox" value="Ya " <?php echo isset($data->anak_kandung)?$data->anak_kandung == 'ya'?'checked':'':''  ?>>
                                <span>Ya </span>
                                <input type="checkbox" value="Tidak " <?php echo isset($data->anak_kandung)?$data->anak_kandung == 'tidak' ?'checked':'':''  ?>>
                                <span>Tidak </span> 
                            </p>

                            <p>
                                Penekantaran fisik/mental  :       
                                <input type="checkbox" value="Ya " <?php echo isset($data->penekantaran_fisik)?$data->penekantaran_fisik =='ya'?'checked':'':''  ?>>
                                <span>Ya </span>
                                <input type="checkbox" value="Tidak " <?php echo isset($data->penekantaran_fisik)?$data->penekantaran_fisik !='ya'?'checked':'':''  ?>>
                                <span>Tidak </span> 
                            </p>
                            <p>
                                Penurunan prestasi sekolah :      
                                <input type="checkbox" value="Ya " <?php echo isset($data->penurunan_prestasi)?$data->penurunan_prestasi =='ya'?'checked':'':''  ?>>
                                <span>Ya </span>
                                <input type="checkbox" value="Tidak " <?php echo isset($data->penurunan_prestasi)?$data->penurunan_prestasi !='ya'?'checked':'':''  ?>>
                                <span>Tidak </span> 
                            </p>
                            <p>
                                Kekerasan Fisik :        
                                <input type="checkbox" value="Ya " <?php echo isset($data->kekerasan_fisik)?$data->kekerasan_fisik =='ya'?'checked':'':''  ?>>
                                <span>Ya </span>
                                <input type="checkbox" value="Tidak " <?php echo isset($data->kekerasan_fisik)?$data->kekerasan_fisik !='ya'?'checked':'':''  ?>>
                                <span>Tidak </span> 
                            </p>
                    </div>
                </div><br><br><br><br><br><br><br>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 3 dari 10</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div> 

    <!-- halaman 4 -->

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>
                <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                    ASESMEN AWAL KEPERAWATAN ANAK RAWAT INAP<br>
                </p>
                <div style="font-size:11px">
                        <p><b>6. RIWAYAT ALERGI</b></p>
                        <div style="margin-left:25px">
                            <p>Riwayat  Alergi :
                            <input type="checkbox" value="Tidak" <?php echo isset($data->riwayat_alergi)?$data->riwayat_alergi =='tidak'?'checked':'':''  ?>>
                            <span>Tidak</span>
                            <input type="checkbox" value="Ya:" <?php echo isset($data->riwayat_alergi)?$data->riwayat_alergi =='ya'?'checked':'':''  ?>>
                            <span>Ya</span>
                            <input type="checkbox" value="Pasang gelang warna merah" <?php echo isset($data->check_riwayat_alergi)?$data->check_riwayat_alergi =='pasang_gelang'?'checked':'':''  ?>>
                            <span>Pasang gelang warna merah</span>
                            </p>

                            <p>
                                a.	Alergi Obat :
                                <input type="checkbox" value="Tidak" <?php echo isset($data->alergi_obat)?$data->alergi_obat =='tidak'?'checked':'':''  ?>>
                                <span>Tidak</span>
                                <input type="checkbox" value="Ya:" <?php echo isset($data->alergi_obat)?$data->alergi_obat !='tidak'?'checked':'':''  ?>>
                                <span>Ya, jenis/nama obat : <?=(isset($data->check_alergi_obat)?$data->check_alergi_obat:'')?></span><br>
                                <p style="margin-left:20px">Reaksi utama yang timbul :<?=(isset($data->reaksi)?$data->reaksi:'')?></p>
                            </p>

                            <p>
                                b.	Lain-lain :
                                <input type="checkbox" value="Astma" <?php echo isset($data->lain_lain_alergi)?$data->lain_lain_alergi =='astma'?'checked':'':''  ?>>
                                <span>Astma</span>
                                <input type="checkbox" value="Eksim kulit" <?php echo isset($data->lain_lain_alergi)?$data->lain_lain_alergi =='eksim_kulit'?'checked':'':''  ?>>
                                <span>Eksim kulit</span>
                                <input type="checkbox" value="sabun" <?php echo isset($data->lain_lain_alergi)?$data->lain_lain_alergi =='sabun'?'checked':'':''  ?>>
                                <span>Sabun</span>
                                <input type="checkbox" value="Debu" <?php echo isset($data->lain_lain_alergi)?$data->lain_lain_alergi =='debu'?'checked':'':''  ?>>
                                <span>Debu</span>
                                <input type="checkbox" value="Udara" <?php echo isset($data->lain_lain_alergi)?$data->lain_lain_alergi =='udara'?'checked':'':''  ?>>
                                <span>Udara</span>
                                <input type="checkbox" value="Makanan" <?php echo isset($data->lain_lain_alergi)?$data->lain_lain_alergi =='makanan'?'checked':'':''  ?>>
                                <span>Makanan :<?=(isset($data->chek_makanan)?$data->chek_makanan:'')?></span><br>
                                <p style="margin-left:20px">Reaksi utama yang timbul :<?=(isset($data->reaksi1)?$data->reaksi1:'')?></p>
                            </p>
                        </div>

                        <p><b>7. ASESMEN NYERI</b></p>
                        <div style="margin-left:25px">
                            <p><b>A.	Metode FLACC Scale (Untuk usia 2 bulan – 7 tahun )</b></p>
                            <p>Petunjuk : Beri nilai sesuai kondisi pasien</p>
                            <table id="data" border="1">
                                <tr>
                                    <th style="width: 15%;" rowspan="2">Kategori</th>
                                    <th colspan="3">Score</th>
                                    <th style="width: 15%;" rowspan="2">Nilai Score</th>
                                </tr>

                                <tr>
                                    <th style="width: 20%;">0</th>
                                    <th style="width: 20%;">1</th>
                                    <th style="width: 20%;">2</th>
                                </tr>
                                
                                <tr>
                                    <td style="width: 15%;">Face (Wajah)</td>
                                    <td style="width: 20%;">Tidak ada ekspresi khusus, senyum</td>
                                    <td style="width: 20%;">Menyeringai, mengerutkan dahi, tampak tidak tertarik (kadang-kadang) </td>
                                    <td style="width: 20%;">Dagu gemetar, gerutu berulang (sering)</td>
                                    <td style="width: 15%;text-align:center" ><?= isset($data->table_assesment_nyeri->result->{'1'})?$data->table_assesment_nyeri->result->{'1'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 15%;">Leg (Kaki)</td>
                                    <td style="width: 20%;">Posisi normal atau santai</td>
                                    <td style="width: 20%;">Gelisah, tegang</td>
                                    <td style="width: 20%;">Menendang, kaki tertekuk </td>
                                    <td style="width: 15%;text-align:center"><?= isset($data->table_assesment_nyeri->result->{'2'})?$data->table_assesment_nyeri->result->{'2'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 15%;">Activity (Aktivitas)</td>
                                    <td style="width: 20%;">Berbaring tenang, posisi normal, gerakan mudah</td>
                                    <td style="width: 20%;">Menggeliat, tidak bisa diam, tegang</td>
                                    <td style="width: 20%;">Kaku atau tegang</td>
                                    <td style="width: 15%;text-align:center"><?= isset($data->table_assesment_nyeri->result->{'3'})?$data->table_assesment_nyeri->result->{'3'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 15%;">Cry (Menangis)</td>
                                    <td style="width: 20%;">Tidak menangis</td>
                                    <td style="width: 20%;">Merintih, merengek, kadang-kadang mengeluh</td>
                                    <td style="width: 20%;">Terus menangis, berteriak</td>
                                    <td style="width: 15%;text-align:center"><?= isset($data->table_assesment_nyeri->result->{'4'})?$data->table_assesment_nyeri->result->{'4'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 15%;">Consolability (Kemampuan Consol)</td>
                                    <td style="width: 20%;">Rileks</td>
                                    <td style="width: 20%;">Dapat ditenangkan dengan sentuhan, pelukan, bujukan, dapat dialihkan</td>
                                    <td style="width: 20%;">Sering mengeluh, sulit dibujuk</td>
                                    <td style="width: 15%;text-align:center"><?= isset($data->table_assesment_nyeri->result->{'5'})?$data->table_assesment_nyeri->result->{'5'}:'' ?></td>
                                </tr>
                                <tr>
                                    <td colspan="4" style="text-align: right;">Total Score</td>
                                    <td style="width: 15%;text-align:center"><?= isset($data->table_assesment_nyeri->result->total_skor)?$data->table_assesment_nyeri->result->total_skor:'' ?></td>
                                </tr>
                            </table>

                        
                            
                            <p><b>B.	Metode Numeric Scale (Untuk usia >7 tahun)</b></p>
                            <p><b>Petunjuk : Beri nilai sesuai kondisi pasien</b></p>
                            <img src=" <?= base_url("assets/img/assesmentinap.jpeg"); ?>"  alt="img" height="150" width="250" style="padding-right:5px;"><br>
                            <p><b>Keterangan :</b></p>
                            <p style="margin-left: 50px;">
                                <span>0	:	Tidak nyeri</span><br>
                                <span >1-3	:	Nyeri ringan</span><br>
                                <span>4-7	:	Nyeri sedang</span><br>
                                <span>8-10	:	Nyeri berat</span>
                            </p>
                            
                        </div>
                
                </div><br><br><br><br><br><br><br>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 4 dari 10</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>

    <!-- halaman 5 -->

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
                <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                    ASESMEN AWAL KEPERAWATAN ANAK RAWAT INAP<br>
                </p>
                <div style="font-size:11px">
                    <div style="margin-left:25px">
                            <p>Keterangan :</p>
                            <p>Nyeri :
                                <input type="checkbox" value="Tidak nyeri" <?php echo isset($data->nyeri)?$data->nyeri=='tidak'?'checked':'':''  ?>>
                                <span>Tidak nyeri</span>
                                <input type="checkbox" value="Ya" <?php echo isset($data->nyeri)?$data->nyeri=='ya'?'checked':'':''  ?>>
                                <span>Ya</span>
                            </p>
                            <p>Nyeri mempengaruhi :  </p>
                                <input type="checkbox" value="Tidur" <?php echo isset($data->nyeri_memperngaruhi)?$data->nyeri_memperngaruhi=='tidur'?'checked':'':''  ?>>
                                <span>Tidur</span>
                                <input type="checkbox" value="Aktivitas fisik" <?php echo isset($data->nyeri_memperngaruhi)?$data->nyeri_memperngaruhi=='aktivitas_fisik'?'checked':'':''  ?>>
                                <span>Aktivitas fisik</span>
                                <input type="checkbox" value="Emosi" <?php echo isset($data->nyeri_memperngaruhi)?$data->nyeri_memperngaruhi=='emosi'?'checked':'':''  ?>>
                                <span>Emosi</span>
                                <input type="checkbox" value="Nafsu makan" <?php echo isset($data->nyeri_memperngaruhi)?$data->nyeri_memperngaruhi=='nafsu_makan'?'checked':'':''  ?>>
                                <span>Nafsu makan</span>
                                <input type="checkbox" value="Konsentrasi" <?php echo isset($data->nyeri_memperngaruhi)?$data->nyeri_memperngaruhi=='konsentrasi'?'checked':'':''  ?>>
                                <span>Konsentrasi</span>
                                <input type="checkbox" value="lain-lainnya" <?php echo isset($data->nyeri_memperngaruhi)?$data->nyeri_memperngaruhi=='lainya'?'checked':'':''  ?>>
                                <span>lain-lainnya : <?= isset($data->check_nyeri_mempengaruhi)?$data->check_nyeri_mempengaruhi:'' ?></span>
                        
                            <p>Nyeri hilang : </p>
                                <input type="checkbox" value="Minum obat" <?php echo isset($data->nyeri_hilang)?$data->nyeri_hilang=='minum_obat'?'checked':'':''  ?>>
                                <span>Minum obat</span>
                                <input type="checkbox" value="Istirahat " <?php echo isset($data->nyeri_hilang)?$data->nyeri_hilang=='istirahat'?'checked':'':''  ?>>
                                <span>Istirahat </span>
                                <input type="checkbox" value="Medengarkan musik" <?php echo isset($data->nyeri_hilang)?$data->nyeri_hilang=='mendengarkan musik'?'checked':'':''  ?>>
                                <span>Medengarkan musik</span>
                                <input type="checkbox" value="Berubah posisi tidur" <?php echo isset($data->nyeri_hilang)?$data->nyeri_hilang=='berubah_posisi tidur'?'checked':'':''  ?>>
                                <span>Berubah posisi tidur</span>
                                <input type="checkbox" value="lain-lainnya" <?php echo isset($data->nyeri_hilang)?$data->nyeri_hilang=='lainnya'?'checked':'':''  ?>>
                                <span>lain-lainnya : <?= isset($data->check_nyeri_hilang)?$data->check_nyeri_hilang:'' ?></span>
                    </div>
                    <div style="margin-left:25px">
                        <p><b>B.	Penilaian Fungsional Anak Menurut FIM (Untuk Usia 9 - 18 tahun)</b><br>
                        <b>Petunjuk : Beri tanda (√)  sesuai kondisi pasien dan jumlahkan</b>
                        </p>
                    </div>
                    <table style="width: 100%;" cellpadding="0" cellspacing="0" border="1">
                        <thead>
                            <tr>
                                <th style="width: 10%;font-size:11px" rowspan="3">No</th>
                                <th style="width: 20%;font-size:11px" rowspan="3">Klasifikasi</th>
                                <th style="width: 70%;font-size:11px" colspan="7">Nilai</th>
                            </tr>
                            <tr>
                                <th style="width: 10%;font-size:11px">7</th>
                                <th style="width: 10%;font-size:11px">6</th>
                                <th style="width: 10%;font-size:11px">5</th>
                                <th style="width: 10%;font-size:11px">4</th>
                                <th style="width: 10%;font-size:11px">3</th>
                                <th style="width: 10%;font-size:11px">2</th>
                                <th style="width: 10%;font-size:11px">1</th>
                            </tr>
                            <tr>
                                <th style="font-size:11px">Komplit tanpa ketergantungan</th>
                                <th style="font-size:11px">Relatif tanpa ketergantungan</th>
                                <th style="font-size:11px">Supervisi</th>
                                <th style="font-size:11px">Bantuan minimal (≤75% tanpa ketergantungan)</th>
                                <th style="font-size:11px">Bantuan sedang (≥ 50% tanpa ketergantungan)</th>
                                <th style="font-size:11px">Bantuan maksimal (≥ 25% tanpa ketergantungan)</th>
                                <th style="font-size:11px">Bantuan total (≤ 25% tanpa ketergantungan)</th>
                            </tr>
                        </thead>    
                        <tbody>
                            <tr>
                                <td colspan="2" style="font-size:11px">Motorik</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px">1</td>
                                <td style="font-size:11px">Mengurus diri sendiri</td>
                                <td style="font-size:11px;text-align:center"></td>
                                <td style="font-size:11px;text-align:center"></td>
                                <td style="font-size:11px;text-align:center"></td>
                                <td style="font-size:11px;text-align:center"></td>
                                <td style="font-size:11px;text-align:center"></td>
                                <td style="font-size:11px;text-align:center"></td>
                                <td style="font-size:11px;text-align:center"></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px">a.	Makan</td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'1'}->{'1'})?$data->table_fim->{'1'}->{'1'}=='Makan'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'2'}->{'1'})?$data->table_fim->{'2'}->{'1'}=='Makan'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'3'}->{'1'})?$data->table_fim->{'3'}->{'1'}=='Makan'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'4'}->{'1'})?$data->table_fim->{'4'}->{'1'}=='Makan'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'5'}->{'1'})?$data->table_fim->{'5'}->{'1'}=='Makan'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'6'}->{'1'})?$data->table_fim->{'6'}->{'1'}=='Makan'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'7'}->{'1'})?$data->table_fim->{'7'}->{'1'}=='Makan'?'√':'':''  ?></td>
                            </tr>

                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px">b.	Berdandan</td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'1'}->{'1'})?$data->table_fim->{'1'}->{'1'}=='Berdandan'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'2'}->{'1'})?$data->table_fim->{'2'}->{'1'}=='Berdandan'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'3'}->{'1'})?$data->table_fim->{'3'}->{'1'}=='Berdandan'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'4'}->{'1'})?$data->table_fim->{'4'}->{'1'}=='Berdandan'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'5'}->{'1'})?$data->table_fim->{'5'}->{'1'}=='Berdandan'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'6'}->{'1'})?$data->table_fim->{'6'}->{'1'}=='Berdandan'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'7'}->{'1'})?$data->table_fim->{'7'}->{'1'}=='Berdandan'?'√':'':''  ?></td>
                            </tr>

                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px">c.	Mandi</td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'1'}->{'1'})?$data->table_fim->{'1'}->{'1'}=='Mandi '?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'2'}->{'1'})?$data->table_fim->{'2'}->{'1'}=='Mandi '?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'3'}->{'1'})?$data->table_fim->{'3'}->{'1'}=='Mandi '?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'4'}->{'1'})?$data->table_fim->{'4'}->{'1'}=='Mandi '?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'5'}->{'1'})?$data->table_fim->{'5'}->{'1'}=='Mandi '?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'6'}->{'1'})?$data->table_fim->{'6'}->{'1'}=='Mandi '?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'7'}->{'1'})?$data->table_fim->{'7'}->{'1'}=='Mandi '?'√':'':''  ?></td>
                            </tr>

                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px">d.	Memakai baju</td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'1'}->{'1'})?$data->table_fim->{'1'}->{'1'}=='Memakai baju'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'2'}->{'1'})?$data->table_fim->{'2'}->{'1'}=='Memakai baju'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'3'}->{'1'})?$data->table_fim->{'3'}->{'1'}=='Memakai baju'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'4'}->{'1'})?$data->table_fim->{'4'}->{'1'}=='Memakai baju'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'5'}->{'1'})?$data->table_fim->{'5'}->{'1'}=='Memakai baju'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'6'}->{'1'})?$data->table_fim->{'6'}->{'1'}=='Memakai baju'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'7'}->{'1'})?$data->table_fim->{'7'}->{'1'}=='Memakai baju'?'√':'':''  ?></td>
                            </tr>

                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px">e.	Memakai celana</td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'1'}->{'1'})?$data->table_fim->{'1'}->{'1'}=='Memakai celana'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'2'}->{'1'})?$data->table_fim->{'2'}->{'1'}=='Memakai celana'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'3'}->{'1'})?$data->table_fim->{'3'}->{'1'}=='Memakai celana'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'4'}->{'1'})?$data->table_fim->{'4'}->{'1'}=='Memakai celana'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'5'}->{'1'})?$data->table_fim->{'5'}->{'1'}=='Memakai celana'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'6'}->{'1'})?$data->table_fim->{'6'}->{'1'}=='Memakai celana'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'7'}->{'1'})?$data->table_fim->{'7'}->{'1'}=='Memakai celana'?'√':'':''  ?></td>
                            </tr>

                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px">f.	Ke kamar mandi (toilet)</td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'1'}->{'1'})?$data->table_fim->{'1'}->{'1'}=='Ke kamar mandi (toilet)'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'2'}->{'1'})?$data->table_fim->{'2'}->{'1'}=='Ke kamar mandi (toilet)'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'3'}->{'1'})?$data->table_fim->{'3'}->{'1'}=='Ke kamar mandi (toilet)'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'4'}->{'1'})?$data->table_fim->{'4'}->{'1'}=='Ke kamar mandi (toilet)'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'5'}->{'1'})?$data->table_fim->{'5'}->{'1'}=='Ke kamar mandi (toilet)'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'6'}->{'1'})?$data->table_fim->{'6'}->{'1'}=='Ke kamar mandi (toilet)'?'√':'':''  ?></td>
                                <td style="font-size:11px;text-align:center"><?php echo isset($data->table_fim->{'7'}->{'1'})?$data->table_fim->{'7'}->{'1'}=='Ke kamar mandi (toilet)'?'√':'':''  ?></td>
                            </tr>
                        
                        

                            <tr>
                                <td style="font-size:11px">2</td>
                                <td style="font-size:11px">Kontrol Sphincter</td>
                                <td style="font-size:11px"><?= (isset($data->table_penilaian_fungsional[7]->{'Column 9'})?in_array("1", $data->table_penilaian_fungsional[7]->{'Column 9'})?'√':'':'') ?></td>
                                <td style="font-size:11px"><?= (isset($data->table_penilaian_fungsional[7]->{'Column 9'})?in_array("1", $data->table_penilaian_fungsional[7]->{'Column 9'})?'√':'':'') ?></td>
                                <td style="font-size:11px"><?= (isset($data->table_penilaian_fungsional[7]->{'Column 9'})?in_array("1", $data->table_penilaian_fungsional[7]->{'Column 9'})?'√':'':'') ?></td>
                                <td style="font-size:11px"><?= (isset($data->table_penilaian_fungsional[7]->{'Column 9'})?in_array("1", $data->table_penilaian_fungsional[7]->{'Column 9'})?'√':'':'') ?></td>
                                <td style="font-size:11px"><?= (isset($data->table_penilaian_fungsional[7]->{'Column 9'})?in_array("1", $data->table_penilaian_fungsional[7]->{'Column 9'})?'√':'':'') ?></td>
                                <td style="font-size:11px"><?= (isset($data->table_penilaian_fungsional[7]->{'Column 9'})?in_array("1", $data->table_penilaian_fungsional[7]->{'Column 9'})?'√':'':'') ?></td>
                                <td style="font-size:11px"><?= (isset($data->table_penilaian_fungsional[7]->{'Column 9'})?in_array("1", $data->table_penilaian_fungsional[7]->{'Column 9'})?'√':'':'') ?></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px">a.	Manajemen control BAK</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px">b.	Manajemen control BAB</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>

                            <tr>
                                <td style="font-size:11px">3</td>
                                <td style="font-size:11px">Mobilitas</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px">a.	Tidur, pakai kursi roda</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px">b.	Buang air sendiri</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px">c.	Mandi di bak mandi, dengan shower</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>

                            <tr>
                                <td style="font-size:11px">4</td>
                                <td style="font-size:11px">Gerakan</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px">a.	Berjalan atau dengan kursi roda</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px">b.	Naik tangga</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>

                            <tr>
                                <td style="font-size:11px" colspan="2">Kognitif</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px">1</td>
                                <td style="font-size:11px">Komunikasi</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px">a.	Pemahamam</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px">b.	ekspresi</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px">2</td>
                                <td style="font-size:11px">Kognisi sosial</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px">a.	interaksi sosial</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px;">b.	memecahkan masalah</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>
                            <tr>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px;">c.	ingatan</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px"></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: right;">Total Nilai</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: right;">Nilai Rata-rata</td>
                                <td colspan="7"><?= isset($data->nilai_rata_rata)?$data->nilai_rata_rata:'' ?></td>
                            </tr>
                        </tbody>                        
                    </table>
                </div><br><br><br><br><br><br><br><br><br><br>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 5 dari 10</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>

    <!-- halaman 6 -->

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>
                <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                    ASESMEN AWAL KEPERAWATAN ANAK RAWAT INAP<br>
                </p>
                <div style="font-size:11px">
                    <p>
                        <input type="checkbox" value="Tanpa bantuan" <?php echo isset($data->tanpa_bantuan)?$data->tanpa_bantuan == 'tanpa_bantuan'?'checked':'':''  ?>>
                        <span>Tanpa bantuan</span>

                        <input type="checkbox" value="Relatif tergantung pada bantuan" <?php echo isset($data->tanpa_bantuan)?$data->tanpa_bantuan == 'relatif_tergantung'?'checked':'':''  ?>>
                        <span>Relatif tergantung pada bantuan</span>

                        <input type="checkbox" value="Komplit tergantung pada bantuan " <?php echo isset($data->tanpa_bantuan)?$data->tanpa_bantuan == 'komplit_tergantung'?'checked':'':''  ?>>
                        <span>Komplit tergantung pada bantuan </span>
                    </p>
                    <p>
                        <b>Keterangan :</b>
                    </p>
                    <div style="margin-left: 30px;">
                        <span>6 - 7	:	Tanpa bantuan</span><br>
                        <span>3 - 5	:	Relatif tergantung pada bantuan    </span><br>
                        <span>1 - 2	:	Komplit tergantung pada bantuan</span>
                    </div>
                    <P>
                        <b>PROTEKSI DAN RESIKO</b>
                    </P>
                    <p> Status mental :</p>
                        <input type="checkbox" value="Orientasi" <?php echo isset($data->staus_mental)?$data->staus_mental == 'Orientasi '?'checked':'':''  ?>>
                        <span>Orientasi</span>

                        <input type="checkbox" value="Agitasi" <?php echo isset($data->staus_mental)?$data->staus_mental == 'Agitasi'?'checked':'':''  ?>>
                        <span>Agitasi</span>

                        <input type="checkbox" value="Menyerang" <?php echo isset($data->staus_mental)?$data->staus_mental == 'Menyerang '?'checked':'':''  ?>>
                        <span>Menyerang</span>

                        <input type="checkbox" value="Tidak ada respon" <?php echo isset($data->staus_mental)?$data->staus_mental == 'Tidak ada respon'?'checked':'':''  ?>>
                        <span>Tidak ada respon</span>

                    

                        <input type="checkbox" value="Kejang" <?php echo isset($data->staus_mental)?$data->staus_mental == ' Kejang, tipe dan frekwensi '?'checked':'':''  ?>>
                        <span>Kejang, tipe dan frekwensi : <?= isset($data->check_status_mental)?$data->check_status_mental:'' ?></span> 
                        
                        
                    
                    <p><b>9. ASESMEN RISIKO JATUH</b></p>
                    <div style="margin-left:25px">
                            <p><b>Pengkajian Resiko Jatuh pada Anak menggunakan Skala Humpty Dumpty</b></p>
                            <p><b>Beri nilai sesuai dengan hasil pemeriksan</b></p>
                            <table id="data" border="1">
                                <tr>
                                    <th style="width: 45%;">Parameter</th>
                                    <th style="width: 25%;">Parameter</th>
                                    <th style="width: 5%;">Skor</th>
                                    <th style="width: 25%;">Hasil Pemeriksaan</th>
                                </tr>
                                <tr>
                                    <td rowspan="4">Umur</td>
                                    <td style="width: 25%;">Di bawah 3 tahun</td>
                                    <td style="width: 15%;text-align:center">4</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'1'})?$data->question9->result->{'1'} == '4'?'√':'':''  ?></td>
                                </tr>
                                <tr>
                                    
                                    <td style="width: 25%;">3 – 7 tahun</td>
                                    <td style="width: 15%;text-align:center">3</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'1'})?$data->question9->result->{'1'} == '3'?'√':'':''  ?></td>
                                </tr>
                                <tr>
                                
                                    <td style="width: 25%;">7 – 13 tahun</td>
                                    <td style="width: 15%;text-align:center">2</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'1'})?$data->question9->result->{'1'} == '2'?'√':'':''  ?></td>
                                </tr>
                                <tr>
                                
                                    <td style="width: 25%;">13 tahun</td>
                                    <td style="width: 15%;text-align:center">1</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'1'})?$data->question9->result->{'1'} == '1'?'√':'':''  ?></td>
                                </tr>


                                <tr>
                                    <td rowspan="2">Jenis Kelamin</td>
                                    <td style="width: 25%;">Laki – laki</td>
                                    <td style="width: 15%;text-align:center">2</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'2'})?$data->question9->result->{'2'} == '2'?'√':'':''  ?></td>
                                </tr>
                                <tr>
                                    
                                    <td style="width: 25%;">Perempuan</td>
                                    <td style="width: 15%;text-align:center">1</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'2'})?$data->question9->result->{'2'} == '1'?'√':'':''  ?></td>
                                </tr>

                                <tr>
                                    <td rowspan="4">Diagnosa</td>
                                    <td style="width: 25%;">Kelainan Neurologi</td>
                                    <td style="width: 15%;text-align:center">4</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'3'})?$data->question9->result->{'3'} == '4'?'√':'':''  ?></td>
                                </tr>
                                <tr>
                                    
                                    <td style="width: 25%;">Perubahan dalam oksigen (Masalah Saluran Nafas, Dehidrasi, Anemia, Anoreksia, Sinkop / sakit kepala, dll)</td>
                                    <td style="width: 15%;text-align:center">3</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'3'})?$data->question9->result->{'3'} == '3'?'√':'':''  ?></td>
                                </tr>
                                <tr>
                                
                                    <td style="width: 25%;">Kelainan Psikis / Perilaku</td>
                                    <td style="width: 15%;text-align:center">2</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'3'})?$data->question9->result->{'3'} == '2'?'√':'':''  ?></td>
                                </tr>
                                <tr>
                                
                                    <td style="width: 25%;">Diagnosis Lain</td>
                                    <td style="width: 15%;text-align:center">1</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'3'})?$data->question9->result->{'3'} == '1'?'√':'':''  ?></td>
                                </tr>

                                <tr>
                                    <td rowspan="3">Gangguan Kognitif</td>
                                    <td style="width: 25%;">Tidak sadar terhadap keterbatasan</td>
                                    <td style="width: 15%;text-align:center">3</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'4'})?$data->question9->result->{'4'} == '3'?'√':'':''  ?></td>
                                </tr>
                                <tr>
                                    
                                    <td style="width: 25%;">Lupa keterbatasan</td>
                                    <td style="width: 15%;text-align:center">2</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'4'})?$data->question9->result->{'4'} == '2'?'√':'':''  ?></td>
                                </tr>
                                <tr>
                                
                                    <td style="width: 25%;">Mengetahui kemampuan diri</td>
                                    <td style="width: 15%;text-align:center">1</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'4'})?$data->question9->result->{'4'} == '1'?'√':'':''  ?></td>
                                </tr>


                                <tr>
                                    <td rowspan="4">Faktor Lingkungan</td>
                                    <td style="width: 25%;">Riwayat jatuh dari tempat tidur saat bayi anak</td>
                                    <td style="width: 15%;text-align:center">4</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'5'})?$data->question9->result->{'5'} == '4'?'√':'':''  ?></td>
                                </tr>
                                <tr>
                                    
                                    <td style="width: 25%;">Pasien menggunakan alat bantu atau box atau mebel</td>
                                    <td style="width: 15%;text-align:center">3</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'5'})?$data->question9->result->{'5'} == '3'?'√':'':''  ?></td>
                                </tr>
                                <tr>
                                
                                    <td style="width: 25%;">Pasien berada di tempat tidur</td>
                                    <td style="width: 15%;text-align:center">2</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'5'})?$data->question9->result->{'5'} == '2'?'√':'':''  ?></td>
                                </tr>
                                <tr>
                                
                                    <td style="width: 25%;">Di luar ruang rawat</td>
                                    <td style="width: 15%;text-align:center">1</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'5'})?$data->question9->result->{'5'} == '1'?'√':'':''  ?></td>
                                </tr>



                                <tr>
                                    <td rowspan="3">Respon Terhadap Operasi / Obat Penenang / Efek Anestesi</td>
                                    <td style="width: 25%;">Dalam 24 jam</td>
                                    <td style="width: 15%;text-align:center">3</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'6'})?$data->question9->result->{'6'} == '3'?'√':'':''  ?></td>
                                </tr>
                                <tr>
                                    
                                    <td style="width: 25%;">Dalam 48 jam Riwayat Jatuh</td>
                                    <td style="width: 15%;text-align:center">2</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'6'})?$data->question9->result->{'6'} == '2'?'√':'':''  ?></td>
                                </tr>
                                <tr>
                                
                                    <td style="width: 25%;">>48 jam</td>
                                    <td style="width: 15%;text-align:center">1</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'6'})?$data->question9->result->{'6'} == '1'?'√':'':''  ?></td>
                                </tr>


                                <tr>
                                    <td rowspan="3">Penggunaan Obat</td>
                                    <td style="width: 25%;">Bermacam-macam obat yang digunakan : Obat sedative (kecuali pasien ICU yang menggunakan sedasi dan paralisis), Hipnotik, Barbiturat, Fenotiazin, Antidepresan, Laksans / Diuretika, Narkotik</td>
                                    <td style="width: 15%;text-align:center">3</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'7'})?$data->question9->result->{'7'} == '3'?'√':'':''  ?></td>
                                </tr>
                                <tr>
                                    
                                    <td style="width: 25%;">Salah satu dari pengobatan di atas</td>
                                    <td style="width: 15%;text-align:center">2</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'7'})?$data->question9->result->{'7'} == '2'?'√':'':''  ?></td>
                                </tr>
                                <tr>
                                
                                    <td style="width: 25%;">Pengobatan lain</td>
                                    <td style="width: 15%;text-align:center">1</td>
                                    <td style="width: 20%;text-align:center"><?php echo isset($data->question9->result->{'7'})?$data->question9->result->{'7'} == '1'?'√':'':''  ?></td>
                                </tr>
                            </table>
                            <p>
                                <input type="checkbox" value="Risiko rendah" <?php echo isset($data->question9->result->kategori)?$data->question9->result->kategori != ' Risiko Tinggi Untuk Jatuh ( > 12 )'?'checked':'':''  ?>>
                                <span>Risiko rendah</span>
                                <input type="checkbox" value="Risiko tinggi" <?php echo isset($data->question9->result->kategori)?$data->question9->result->kategori == ' Risiko Tinggi Untuk Jatuh ( > 12 )'?'checked':'':''  ?>>
                                <span>Risiko tinggi</span>
                            </p>
                            
                    </div>
                
                    </span>
                    
                </div><br>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 6 dari 10</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div> 

    <!-- halaman 7 -->

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
                <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                    ASESMEN AWAL KEPERAWATAN ANAK RAWAT INAP<br>
                </p>
                <div style="font-size:11px">

                    <div style="margin-left:25px">
                            <p>Tingkat risiko dan tindakan :</p>
                            <ol>
                                <li>Skor  7 – 11	:   Risiko Rendah Untuk Jatuh		* Skor Minimal	     :    7</li>
                                <li>2.	Skor  ≥ 12 	:   Risiko Tinggi Untuk Jatuh		* Skor Maksimal	:   23</li>
                            </ol>
                            <p><b>CATATAN:</b></p>
                            <ul>
                                <li>Kolaborasikan untuk mengatasi area masalah pasien dengan tim kesehatan lain</li>
                                <li>Komunikasikan status resiko tinggi pasien setiap pergantian shift dan setiap pindah keruangan lain</li>
                                <li>Berikan perhatian khusus terhadap hasil penilaian resiko jatuh pasien</li>
                            </ul>
                            <p>Keamanan : </p>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->keamanan)?$data->keamanan == 'tidak'?'checked':'':''  ?>>
                                <span>Tidak</span>
                                <input type="checkbox" value="Ya " <?php echo isset($data->keamanan)?$data->keamanan == 'ya'?'checked':'':''  ?>>
                                <span>Ya Risiko rendah Pasang pengaman tempat tidur/ bed railis </span><br>
                                <input type="checkbox" value="Penanda Segitiga Resiko Jatuh" <?php echo isset($data->check_keamanan)?$data->check_keamanan == 'Pasang pengaman tempat tidur/ bed railis'?'checked':'':''  ?>>
                                <span>Pasang pengaman tempat tidur/ bed railis  </span> 
                                <input type="checkbox" value="Penanda Segitiga Resiko Jatuh" <?php echo isset($data->check_keamanan)?$data->check_keamanan == 'Penanda Segitiga Resiko Jatuh  '?'checked':'':''  ?>>
                                <span>Penanda Segitiga Resiko Jatuh  </span>
                    </div>

                    <p><b>10.  ASESMEN RISIKO NUTRISONAL PADA ANAK (Berdasarkan Metode Strong Kids)</b></p>
                    <div style="margin-left:25px">
                        <p>Lingkari skor sesuai dengan jawaban, total skor adalah jumlah skor yang dilingkari</p>
                        <table id="data" border="1">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 60%;">Parameter</th>
                                <th style="width: 35%;">Skor</th>
                            </tr>
                            <tr>
                                <td style="width: 5%;text-align: center;">1.</td>
                                <td style="width: 60%;">Apakah pasien tampak kurus?</td>
                                <td style="width: 35%;"></td>
                            </tr>
                            <tr >
                                <td style="width: 5%;"></td>
                                <td style="width: 60%;">a.	Tidak</td>
                                <td style="width: 35%;text-align: center;" class="<?= isset($data->table_risiko_nutrisional->result->{'1'})?$data->table_risiko_nutrisional->result->{'1'} == "0"?"bg-checked":"":"" ?>">0</td>
                            </tr>
                            <tr >
                                <td style="width: 5%;"></td>
                                <td style="width: 60%;">b.	Ya</td>
                                <td style="width: 35%;text-align: center;" class="<?= isset($data->table_risiko_nutrisional->result->{'1'})?$data->table_risiko_nutrisional->result->{'1'} == "1"?"bg-checked":"":"" ?>">1</td>
                            </tr>

                            <tr>
                                <td rowspan="2" style="text-align: center;">2.</td>
                                <td colspan="2">Apakah terdapat penyakit atau keadaan berikut yang mengakibatkan pasien berisiko mengalami malnutrisi ?</td>
                            </tr>

                            <tr>  
                                <td style="width: 60%;">
                                <ul>
                                    <li>Diare kronik (lebih dari 2 minggu)</li>
                                    <li>Penyakit Jantung Bawaan</li>
                                    <li>Infeksi Human Immunodeficiency Virus (HIV)</li>
                                    <li>Kanker</li>
                                    <li>Penyakit hati kronik</li>
                                    <li>Penyakit Ginjal kronik</li>
                                    <li>TB Paru</li>
                                    <li>Luka bakar luas</li>
                                    <li>Lain-lain (berdasarkan pertimbangan dokter) ……………</li>
                                </ul>
                                </td>
                                <td style="width: 35%;">
                                    <ul>
                                        <li>Kelainan anatomi daerah mulut yang menyebabkan kesulitan makan (misal: bibir sumbing)</li>
                                        <li>Trauma</li>
                                        <li>Kelainan metabolik bawaan </li>
                                        <li>Retardasi mental</li>
                                        <li>Keterlambatan perkembangan</li>
                                        <li>Rencana/paskaoperasi mayor (misal: laparotomi, Torakotomi)</li>
                                        <li>Terpasang stoma</li>
                    
                                    </ul>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 5%;"></td>
                                <td style="width: 60%;">a.	Tidak</td>
                                <td style="width: 35%;text-align: center;" class="<?= isset($data->table_risiko_nutrisional->result->{'2'})?$data->table_risiko_nutrisional->result->{'2'} == "0"?"bg-checked":"":"" ?>">0</td>
                            </tr>
                            <tr>
                                <td style="width: 5%;"></td>
                                <td style="width: 60%;">b.	Ya</td>
                                <td style="width: 35%;text-align: center;" class="<?= isset($data->table_risiko_nutrisional->result->{'2'})?$data->table_risiko_nutrisional->result->{'2'} == "2"?"bg-checked":"":"" ?>">1</td>
                            </tr>
                            <tr>
                                <td style="width: 5%;text-align: center;">3.</td>
                                <td colspan="2">
                                    <span>Apakah terdapat salah satu dari kondisi berikut?</span>
                                    <ul>
                                        <li>Diare ≥ 5 kali/hari dan atau muntah> 3 kali/hari dalam seminggu terakhir</li>
                                        <li>Asupan makanan berkurang selama 1 minggu terakhir</li>
                                    </ul>
                                </td>    
                            </tr>

                            <tr>
                                <td style="width: 5%;"></td>
                                <td style="width: 60%;">a.	Tidak</td>
                                <td style="width: 35%;text-align: center;" class="<?= isset($data->table_risiko_nutrisional->result->{'3'})?$data->table_risiko_nutrisional->result->{'3'} == "0"?"bg-checked":"":"" ?>">0</td>
                            </tr>
                            <tr>
                                <td style="width: 5%;"></td>
                                <td style="width: 60%;">b.	Ya</td>
                                <td style="width: 35%;text-align: center;" class="<?= isset($data->table_risiko_nutrisional->result->{'3'})?$data->table_risiko_nutrisional->result->{'3'} == "1"?"bg-checked":"":"" ?>">1</td>
                            </tr>
                            <tr>
                                <td style="width: 5%;text-align: center;">4.</td>
                                <td colspan="2">
                                    <span>Apakah terdapat penurunan berat badan atau tidak ada penambahan berat badan <br>     
                                        (bayi< 1 tahun) selama beberapa minggu/bulan terakhir?</span>
                                </td>    
                            </tr>
                            <tr>
                                <td style="width: 5%;"></td>
                                <td style="width: 60%;">a.	Tidak</td>
                                <td style="width: 35%;text-align: center;" class="<?= isset($data->table_risiko_nutrisional->result->{'4'})?$data->table_risiko_nutrisional->result->{'4'} == "0"?"bg-checked":"":"" ?>">0</td>
                            </tr>
                            <tr>
                                <td style="width: 5%;"></td>
                                <td style="width: 60%;">b.	Ya</td>
                                <td style="width: 35%;text-align: center;" class="<?= isset($data->table_risiko_nutrisional->result->{'4'})?$data->table_risiko_nutrisional->result->{'4'} == "1"?"bg-checked":"":"" ?>">1</td>
                            </tr>
                            <tr>
                                <td style="width: 5%;"></td>
                                <td style="width: 60%;text-align: right;"><b>Total skor</b></td>
                                <td style="width: 35%;text-align: center;"><?= isset($data->table_risiko_nutrisional->result->total_skor)?$data->table_risiko_nutrisional->result->total_skor:'' ?></td>
                            </tr>
                        </table>
                        <p>Hasil total skor :</p>
                        <div style="margin-left: 30px;">
                            <span>0		:	Berisiko rendah, ulangi skrining setiap 7 hari</span><br>
                            <span>1-3	:	Berisiko menengah, dirujuk ke Tim Terapi Gizi (TTG),monitor asupan makan setiap 3 hari</span><br>
                            <span>4-5	:	Berisiko tinggi, dirujuk ke Tim Terapi Gizi (TTG), monitor asupan makan setiap hari</span>
                        </div>
                        <p>Sudah dilaporkan ke Tim Terapi Gizi :
                            <input type="checkbox" value="Ya" >
                            <span>Ya, tanggal & jam </span>
                            <input type="checkbox" value="Tidak" >
                            <span>Tidak</span>
                        </p>
                    </div>

                    <p><b>11.	KEBUTUHAN EDUKASI</b></p>
                    <div style="margin-left:25px">
                        <p>Bicara :</p> 
                            <input type="checkbox" value="Normal" <?php echo isset($data->bicara)? $data->bicara == "normal" ? "checked":'':'' ?>>
                            <span>Normal</span>
                            <input type="checkbox" value="Serangan awal" <?php echo isset($data->bicara)? $data->bicara == "Serangan awal gangguan bicara," ? "checked":'':'' ?>>
                            <span> Serangan awal gangguan bicara, kapan : <?php echo isset($data->check_bicara)? $data->check_bicara :'' ?></span>

                            <p>Bahasa sehari-hari :</p>  
                            <input type="checkbox" value="Indonesia" <?php echo isset($data->bahasa_sehari_hari)? $data->bahasa_sehari_hari == "indonesia" ? "checked":'':'' ?>>
                            <span>Indonesia, <?= isset($data->aktif_indonesia)?$data->aktif_indonesia:'' ?></span>
                            <input type="checkbox" value="Daerah" <?php echo isset($data->bahasa_sehari_hari)? $data->bahasa_sehari_hari == "daerah" ? "checked":'':'' ?>>
                            <span> Daerah, jelaskan <?php echo isset($data->value_bahasa)? $data->value_bahasa:'' ?></span>
                            <br>
                            <input type="checkbox" value="Inggris" <?php echo isset($data->bahasa_sehari_hari)? $data->bahasa_sehari_hari == "inggris " ? "checked":'':'' ?>>
                            <span>Inggris ,  <?= isset($data->aktif_inggris)?$data->aktif_inggris:'' ?></span>
                            <input type="checkbox" value="Lain-lainnya" <?php echo isset($data->bahasa_sehari_hari)? $data->bahasa_sehari_hari == "lainnya" ? "checked":'':'' ?>>
                            <span> Lain-lainnya , jelaskan <?= isset($data->check_lainnya)?$data->check_lainnya:'' ?></span>
                    </div>    
                </div>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 7 dari 10</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>

    <!-- halaman 8 -->

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>
                <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                    ASESMEN AWAL KEPERAWATAN ANAK RAWAT INAP<br>
                </p>
                <div style="font-size:11px">
                    <div style="margin-left:25px">
                        <p>Perlu penerjemah : 
                        <input type="checkbox" value=" Tidak" <?php echo isset($data->penerjemah)? $data->penerjemah == "tidak" ? "checked":'':'' ?>>
                        <span> Tidak</span>
                        <input type="checkbox" value="Ya" <?php echo isset($data->penerjemah)? $data->penerjemah != "tidak" ? "checked":'':'' ?>>
                        <span>Ya, Bahasa <?php echo isset($data->question33)? $data->question33:'' ?></span></p>

                        <p>Hambatan belajar : </p>
                        <input type="checkbox" value="Bahasa" <?php echo isset($data->hambatan_belajar)? $data->hambatan_belajar == "bahasa" ? "checked":'':'' ?>>
                        <span>Bahasa</span>
                        <input type="checkbox" value="Cemas" <?php echo isset($data->hambatan_belajar)? $data->hambatan_belajar == "cemas" ? "checked":'':'' ?>>
                        <span>Cemas</span>
                        <input type="checkbox" value="Menulis " <?php echo isset($data->hambatan_belajar)? $data->hambatan_belajar == "menulis" ? "checked":'':'' ?>>
                        <span>Menulis </span>
                        <input type="checkbox" value="Lain-lainnya" <?php echo isset($data->hambatan_belajar)? $data->hambatan_belajar == "lainnya" ? "checked":'':'' ?>>
                        <span>Lain-lainnya, <?= isset($data->chek_hambatan_belajar)?$data->chek_hambatan_belajar:'' ?></span>

                        <p>Cara belajar yang di sukai : audio-visual /gambar 
                        <input type="checkbox" value="Diskusi" <?php echo isset($data->cara_belajar)? $data->cara_belajar == "Diskusi" ? "checked":'':'' ?>>
                        <span>Diskusi</span>
                        <input type="checkbox" value="Diskusi" <?php echo isset($data->cara_belajar)? $data->cara_belajar == " audio-visual /gambar" ? "checked":'':'' ?>>
                        <span> audio-visual /gambar</span>
                        <input type="checkbox" value="Lain-lainnya" <?php echo isset($data->cara_belajar)? $data->cara_belajar == "lainnya" ? "checked":'':'' ?>>
                        <span>Lain-lainnya , jelaskan <?= isset($data->check_cara_belajar)?$data->check_cara_belajar:'' ?></span></p>

                        <p>Tingkat pendidikan : <p>
                    
                        <input type="checkbox" value="SD" <?php echo isset($data->tingkat_pendidikan)? $data->tingkat_pendidikan == "sd" ? "checked":'':'' ?>>
                        <span>SD</span>
                        <input type="checkbox" value="SMP" <?php echo isset($data->tingkat_pendidikan)? $data->tingkat_pendidikan == "smp" ? "checked":'':'' ?>>
                        <span>SMP</span>
                        <input type="checkbox" value=" SMA" <?php echo isset($data->tingkat_pendidikan)? $data->tingkat_pendidikan == "sma" ? "checked":'':'' ?>>
                        <span> SMA</span>
                        <input type="checkbox" value=" Akademi" <?php echo isset($data->tingkat_pendidikan)? $data->tingkat_pendidikan == "tk" ? "checked":'':'' ?>>
                        <span>Akademi</span>
                        <input type="checkbox" value=" Sarjana " <?php echo isset($data->tingkat_pendidikan)? $data->tingkat_pendidikan == "sarjana" ? "checked":'':'' ?>>
                        <span>  Sarjana </span>
                        <input type="checkbox" value="Lain-lainnya" <?php echo isset($data->tingkat_pendidikan)? $data->tingkat_pendidikan == "lainnya" ? "checked":'':'' ?>>
                        <span>Lain-lainnya : <?= isset($data->check_pendidikan)?$data->check_pendidikan:'' ?></span>

                        <p>Potensi kebutuhan pembelajaran : <?php echo isset($data->potensi_kebutuhan)? $data->potensi_kebutuhan:'' ?></p>

                        <p>Adanya Ketersediaan Media : 
                        <input type="checkbox" value="Tidak" <?php echo isset($data->adanya_keterbiasaan)? $data->adanya_keterbiasaan == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak</span>
                        <input type="checkbox" value="Ya" <?php echo isset($data->adanya_ketersediaan)? $data->adanya_ketersediaan == 'ya' ? "checked":'':'' ?>>
                        <span>Ya : <?php echo isset($data->check_ya)? $data->check_ya:'' ?></span></p>

                        <p>Respon emosi :</p>
                            <input type="checkbox" value="Takut" <?php echo isset($data->respon_emosi)? $data->respon_emosi == "Takut terhadap therapy/pembedahan/lingkungan RS" ? "checked":'':'' ?>>
                            <span>Takut terhadap therapy/pembedahan/lingkungan RS</span>
                            <input type="checkbox" value="marah" <?php echo isset($data->respon_emosi)? $data->respon_emosi == "Marah" ? "checked":'':'' ?>>
                            <span>marah </span>
                            <input type="checkbox" value="Tegang" <?php echo isset($data->respon_emosi)? $data->respon_emosi == "Tegang" ? "checked":'':'' ?>>
                            <span>Tegang</span>
                            <input type="checkbox" value="Lain-lainnya" <?php echo isset($data->respon_emosi)? $data->respon_emosi == "Lain-lainnya" ? "checked":'':'' ?>>
                            <span>Lain-lainnya : <?php echo isset($data->check_respon)? $data->check_respon:'' ?></span>

                        <p>Respon Kognitif :</p>
                            <span>Pasien dan keluarga menginginkan informasi tentang : <span><br>
                            <input type="checkbox" value="Penyakit yang di derita" <?php echo isset($data->respon_kognitif)? $data->respon_kognitif == "Penyakit yang di derita" ? "checked":'':'' ?>>
                            <span>Penyakit yang di derita</span>
                            <input type="checkbox" value="Tindakan pemeriksaan lanjut" <?php echo isset($data->respon_kognitif)? $data->respon_kognitif == "Tindakan pemeriksaan lanjut" ? "checked":'':'' ?>>
                            <span>Tindakan pemeriksaan lanjut</span><br>

                            <input type="checkbox" value="Tindakan" <?php echo isset($data->respon_kognitif)? $data->respon_kognitif == "Tindakan/pengobatan dan perawatan yang di berikan " ? "checked":'':'' ?>>
                            <span>Tindakan/pengobatan dan perawatan yang di berikan</span>
                            <input type="checkbox" value="Perubahan aktifitas sehari-hari" <?php echo isset($data->respon_kognitif)? $data->respon_kognitif == "Perubahan aktifitas sehari-hari" ? "checked":'':'' ?>>
                            <span>Perubahan aktifitas sehari-hari</span><br>

                            <input type="checkbox" value="Perencanaan diet dan menu" <?php echo isset($data->respon_kognitif)? $data->respon_kognitif == "Perencanaan diet dan menu " ? "checked":'':'' ?>>
                            <span>Perencanaan diet dan menu</label>
                            <input type="checkbox" value="Perawatan setelah di rumah" <?php echo isset($data->respon_kognitif)? $data->respon_kognitif == "Perawatan setelah di rumah" ? "checked":'':'' ?>>
                            <span>Perawatan setelah di rumah</span> 
                    </div>

                    <p><b>12. RIWAYAT PENGGUNAAN OBAT</b></p>
                    <div style="margin-left:25px">
                        <p>
                            Riwayat Penggunaan Di rumah : 
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question24)? $data->question24 != "ya" ? "checked":'':'' ?>>
                            <span>Tidak</span>
                            <input type="checkbox" value="Ya" <?php echo isset($data->question24)? $data->question24 == "ya" ? "checked":'':'' ?>>
                            <span>Ya</span>    
                        </p>
                        <table id="data" border="1">
                                <tr>
                                    <td style="width: 10%;text-align: center;">No</td>
                                    <td style="width: 40%;text-align: center;">Nama Obat</td>
                                    <td style="width: 20%;text-align: center;">Dosis</td>
                                    <td style="width: 30%;text-align: center;">Cara Pemberian</td>
                                </tr>
                                <?php
                                $no=1; 
                                $jml_array = isset($data->question25)?count($data->question25):'';
                                for ($x = 0; $x < $jml_array; $x++) {
                            ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= isset($data->question25[$x]->{'1'})?$data->question25[$x]->{'1'}:'' ?></td>
                                    <td><?= isset($data->question25[$x]->{'2'})?$data->question25[$x]->{'2'}:'' ?></td>
                                    <td><?= isset($data->question25[$x]->{'3'})?$data->question25[$x]->{'3'}:'' ?></td>
                                </tr>
                            <?php } ?>
                                
                        </table>
                    </div>

                    <p><b>13. DISCHARGE PLANNING</b></p>
                    <div style="margin-left:25px">
                        <p>( Dilengkapi dalam 48 jam pertama pasien masuk ruang rawat )</p>
                        <table id="data" border="1">
                            <tr>
                                <th style="width: 30;">Kebutuhan Pelayanan</th>
                                <th style="width: 15;">Ya</th>
                                <th style="width: 15;">Tidak</th>
                                <th style="width: 40;">Keterangan</th>
                            </tr>
                            <tr>
                                <td  style="width: 30;">Perlu Pelayanan Home Care</td>
                                <td style="width: 15;text-align:center"> <?php echo isset($data->table_discharge->{'Perlu Pelayanan Home Care'}->{'1'})? $data->table_discharge->{'Perlu Pelayanan Home Care'}->{'1'} == "ya" ? "√":'':'' ?></td>
                                <td style="width: 15;text-align:center"><?php echo isset($data->table_discharge->{'Perlu Pelayanan Home Care'}->{'1'})? $data->table_discharge->{'Perlu Pelayanan Home Care'}->{'1'} == "tidak" ? "√":'':'' ?> </td>
                                <td style="width: 40;"><?php echo isset($data->table_discharge->{'Perlu Pelayanan Home Care'}->{'2'})? $data->table_discharge->{'Perlu Pelayanan Home Care'}->{'2'}:'' ?></td>
                            </tr>
                            <tr>
                                <td  style="width: 30;">Penggunaan Alat Bantu</td>
                                <td style="width: 15;text-align:center"><?php echo isset($data->table_discharge->{'Penggunaan Alat Bantu'}->{'1'})? $data->table_discharge->{'Penggunaan Alat Bantu'}->{'1'} == "ya" ? "√":'':'' ?></td>
                                <td style="width: 15;text-align:center"><?php echo isset($data->table_discharge->{'Penggunaan Alat Bantu'}->{'1'})? $data->table_discharge->{'Penggunaan Alat Bantu'}->{'1'} == "tidak" ? "√":'':'' ?></td>
                                <td style="width: 40;"><?php echo isset($data->table_discharge->{'Penggunaan Alat Bantu'}->{'2'})? $data->table_discharge->{'Penggunaan Alat Bantu'}->{'2'}:'' ?></td>
                            </tr>
                            <tr>
                                <td  style="width: 30;">Telah dilakukan Pemesanan Alat</td>
                                <td style="width: 15;text-align:center"><?php echo isset($data->table_discharge->{'Telah dilakukan Pemesanan Alat'}->{'1'})? $data->table_discharge->{'Telah dilakukan Pemesanan Alat'}->{'1'} == "ya" ? "√":'':'' ?></td>
                                <td style="width: 15;text-align:center"><?php echo isset($data->table_discharge->{'Telah dilakukan Pemesanan Alat'}->{'1'})? $data->table_discharge->{'Telah dilakukan Pemesanan Alat'}->{'1'} == "tidak" ? "√":'':'' ?></td>
                                <td style="width: 40;"><?php echo isset($data->table_discharge->{'Telah dilakukan Pemesanan Alat'}->{'2'})? $data->table_discharge->{'Telah dilakukan Pemesanan Alat'}->{'2'}:'' ?></td>
                            </tr>
                            <tr>
                                <td  style="width: 30;">Dirujuk ke Komunitas Tertentu</td>
                                <td style="width: 15;text-align:center"><?php echo isset($data->table_discharge->{'Dirujuk ke Komunitas Tertentu'}->{'1'})? $data->table_discharge->{'Dirujuk ke Komunitas Tertentu'}->{'1'} == "ya" ? "√":'':'' ?></td>
                                <td style="width: 15;text-align:center"><?php echo isset($data->table_discharge->{'Dirujuk ke Komunitas Tertentu'}->{'1'})? $data->table_discharge->{'Dirujuk ke Komunitas Tertentu'}->{'1'} == "tidak" ? "√":'':'' ?></td>
                                <td style="width: 40;"><?php echo isset($data->table_discharge->{'Dirujuk ke Komunitas Tertentu'}->{'2'})? $data->table_discharge->{'Dirujuk ke Komunitas Tertentu'}->{'2'}:'' ?></td>
                            </tr>
                            <tr>
                                <td  style="width: 30;">Dirujuk ke Tim Terapis</td>
                                <td style="width: 15;text-align:center"><?php echo isset($data->table_discharge->{'Dirujuk ke Tim Terapis'}->{'1'})? $data->table_discharge->{'Dirujuk ke Tim Terapis'}->{'1'} == "ya" ? "√":'':'' ?></td>
                                <td style="width: 15;text-align:center"><?php echo isset($data->table_discharge->{'Dirujuk ke Tim Terapis'}->{'1'})? $data->table_discharge->{'Dirujuk ke Tim Terapis'}->{'1'} == "tidak" ? "√":'':'' ?></td>
                                <td style="width: 40;"><?php echo isset($data->table_discharge->{'Dirujuk ke Tim Terapis'}->{'2'})? $data->table_discharge->{'Dirujuk ke Tim Terapis'}->{'2'}:'' ?></td>
                            </tr>
                            <tr>
                                <td  style="width: 30;">Dirujuk ke Ahli Gizi</td>
                                <td style="width: 15;text-align:center"><?php echo isset($data->table_discharge->{'Dirujuk ke Ahli Gizi'}->{'1'})? $data->table_discharge->{'Dirujuk ke Ahli Gizi'}->{'1'} == "ya" ? "√":'':'' ?></td>
                                <td style="width: 15;text-align:center"><?php echo isset($data->table_discharge->{'Dirujuk ke Ahli Gizi'}->{'1'})? $data->table_discharge->{'Dirujuk ke Ahli Gizi'}->{'1'} == "tidak" ? "√":'':'' ?></td>
                                <td style="width: 40;"><?php echo isset($data->table_discharge->{'Dirujuk ke Ahli Gizi'}->{'2'})? $data->table_discharge->{'Dirujuk ke Ahli Gizi'}->{'2'}:'' ?></td>
                            </tr>
                            <tr>
                                <td  style="width: 30;">lainnya</td>
                                <td style="width: 15;text-align:center"><?php echo isset($data->table_discharge->{'lainnya'}->{'1'})? $data->table_discharge->{'lainnya'}->{'1'} == "ya" ? "√":'':'' ?></td>
                                <td style="width: 15;text-align:center"><?php echo isset($data->table_discharge->{'lainnya'}->{'1'})? $data->table_discharge->{'lainnya'}->{'1'} == "tidak" ? "√":'':'' ?></td>
                                <td style="width: 40;"><?php echo isset($data->table_discharge->{'lainnya'}->{'2'})? $data->table_discharge->{'lainnya'}->{'2'}:'' ?></td>
                            </tr>
                        
                        
                        </table>
                        <p><b>PENGKAJIAN KHUSUS ANAK</b></p>
                        <p><b>Riwayat Prenatal </b></p>
                        <p>Lama kehamilan : <?= isset($data->lama_kehamilan)?$data->lama_kehamilan.' ':'' ?>bulan/mgg</p>
                        <p>
                            Komplikasi :
                            <input type="checkbox" value="Tidak" <?php echo isset($data->komplikasi)? $data->komplikasi == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak</span>
                            <input type="checkbox" value="Ya" <?php echo isset($data->komplikasi)? $data->komplikasi != "tidak" ? "checked":'':'' ?>>
                            <span>Ya : PEB/DM/HT/ <?= isset($data->check_komplikasi)?' '.':'.$data->check_komplikasi:'' ?></span>
                        </p>
                        <p>
                            Masalah Maternal :
                            <input type="checkbox" value="Tidak" <?php echo isset($data->masalah_maternal)? $data->masalah_maternal == "tidak" ? "checked":'':'' ?>>
                            <span>Tidak</span>
                            <input type="checkbox" value="Ya" <?php echo isset($data->masalah_maternal)? $data->masalah_maternal != "tidak" ? "checked":'':'' ?>>
                            <span>Ya <?= isset($data->check_masalah)?':'.' '.$data->check_masalah:'' ?></span>
                        </p>
                        <p><b>Riwayat Natal : </b></p>
                            <input type="checkbox" value="Persalinan : " <?php echo isset($data->riwayat_natal)? $data->riwayat_natal == "persalinan" ? "checked":'':'' ?>>
                            <span>Persalinan : </span>
                            <input type="checkbox" value="Spontan" <?php echo isset($data->riwayat_natal)? $data->riwayat_natal == "spontan" ? "checked":'':'' ?>>
                            <span>Spontan</span>
                            <input type="checkbox" value="Sectio Secaria " <?php echo isset($data->riwayat_natal)? $data->riwayat_natal == "sectio_secario" ? "checked":'':'' ?>>
                            <span>Sectio Secaria </span>
                            <input type="checkbox" value="Induksi" <?php echo isset($data->riwayat_natal)? $data->riwayat_natal == " Induksi" ? "checked":'':'' ?>>
                            <span">Induksi</span>
                            <input type="checkbox" value="Lain-lainnya" <?php echo isset($data->riwayat_natal)? $data->riwayat_natal == "lainnya" ? "checked":'':'' ?>>
                            <span>Lain-lainnya : <?= isset($data->question53)?$data->question53:'' ?></span>

                            <p>
                            <input type="checkbox" value="Lain-lainnya" <?php echo isset($data->riwayat_natal)? $data->riwayat_natal == "Penyulit persalinan" ? "checked":'':'' ?>>
                            <span>Penyulit Persalinan : <?= isset($data->question55)?' '.$data->question55:'' ?></span>
                            </p>
                        
                    </div>
                </div><br><br><br><br><br>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 8 dari 10</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>

    <!-- halaman 9 -->

        <div class="A4 sheet  padding-fix-10mm">
            <header>
                <?php $this->load->view('emedrec/ri/header_print') ?>
            </header>
                <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                    ASESMEN AWAL KEPERAWATAN ANAK RAWAT INAP<br>
                </p>

                <div style="font-size: 11px;">
                    <div style="margin-left:25px">
                            <p>
                                <span>BB Lahir : <?= isset($data->bb_lahir)?$data->bb_lahir:'' ?></span>
                                <span style="margin-left: 30px;">Panjang : <?= isset($data->panjang)?$data->panjang:'' ?></span>
                                <span style="margin-left: 30px;">Lingkar kepala : <?= isset($data->lingkar_kepala)?$data->lingkar_kepala:'' ?></span>
                            </p>
                            <p>
                                <span>BB saat  di kaji : <?= isset($data->bb_saat_dikaji)?$data->bb_saat_dikaji:'' ?></span>
                                <span style="margin-left: 40px;">TB : <?= isset($data->question12)?$data->question12:'' ?></span>
                            </p>
                            <p><b>Riwayat Post Natal :  </b></p>
                                <input type="checkbox" value="Premature/Aterm/Post Date" <?php echo isset($data->riwayat_post_natal)? $data->riwayat_post_natal == "Premature/Aterm/Post Date" ? "checked":'':'' ?>>
                                <span>Premature/Aterm/Post Date</span>
                                <input type="checkbox" value="Pasca NICU/PICU" <?php echo isset($data->riwayat_post_natal)? $data->riwayat_post_natal == " Pasca NICU/PICU   " ? "checked":'':'' ?>>
                                <span>Pasca NICU/PICU</span>
                                <input type="checkbox" value="Lain-lainnya" <?php echo isset($data->riwayat_post_natal)? $data->riwayat_post_natal == "lainnya" ? "checked":'':'' ?>>
                                <span>Lain-lainnya : <?= isset($data->check_lainnya1)?$data->check_lainnya1:'' ?></span>
                            <p><b>Riwayat Imunisasi :</b></p>
                                <input type="checkbox" value="Lengkap" <?php echo isset($data->riwayat_imunisasi)? $data->riwayat_imunisasi == "Lengkap" ? "checked":'':'' ?>>
                                <span>Lengkap</span>
                                <input type="checkbox" value="Tidak pernah" <?php echo isset($data->riwayat_imunisasi)? $data->riwayat_imunisasi == "Tidak pernah" ? "checked":'':'' ?>>
                                <span>Tidak pernah</span>
                                <input type="checkbox" value="Tidak lengkap " <?php echo isset($data->riwayat_imunisasi)? $data->riwayat_imunisasi == "Tidak lengkap" ? "checked":'':'' ?>>
                                <span>Tidak lengkap , sebutkan yang belum  <?= isset($data->check_riwayat_post)?$data->check_riwayat_post:'' ?></span>
                            <p><b>Tingkat Perkembangan Saat Ini  (Diisi bila anak berusia 1 bulan – 5 tahun)</b></p>
                            <p><b>(lingkari pada kolom umur sesuai umur pasien)</b></p>

                            <table id="data" border="1">
                                <tr>
                                    <th style="width: 10%;font-size:11pxfont-size:10px">UMUR</th>
                                    <th style="width: 20%;font-size:11px">GERAKAN KASAR</th>
                                    <th style="width: 20%;font-size:11px">GERAKAN HALUS</th>
                                    <th style="width: 20%;font-size:11px">KOMUNIKASIBERBICARA</th>
                                    <th style="width: 30%;font-size:11px">SOSIAL &KEMANDIRIAN</th>
                                </tr>
                                <tr>
                                    <td style="width: 10%;font-size:11px">1 bulan</td>
                                    <td style="width: 20%;font-size:11px">Tangan & kaki bergerak aktif</td>
                                    <td style="width: 20%;font-size:11px">Kepala menoleh ke samping kanan & kiri</td>
                                    <td style="width: 20%;font-size:11px">Bereaksi terhadap bunyi</td>
                                    <td style="width: 30%;font-size:11px">Menatap wajah ibu / pengasuh</td>
                                </tr>

                                <tr>
                                    <td style="width: 10%;font-size:11px">2 bulan</td>
                                    <td style="width: 20%;font-size:11px">Mengangkat kepala ketika tengkurap</td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 20%;font-size:11px">Bersuara Ooo… Ooo / ooo..ooo</td>
                                    <td style="width: 30%;font-size:11px">Tersenyum spontan</td>
                                </tr>

                                <tr>
                                    <td style="width: 10%;font-size:11px">3 bulan</td>
                                    <td style="width: 20%;font-size:11px">Kepala tegak ketika didudukkan</td>
                                    <td style="width: 20%;font-size:11px">Memegang mainan</td>
                                    <td style="width: 20%;font-size:11px">Tertawa/berteriak</td>
                                    <td style="width: 30%;font-size:11px">Memandang tangannya</td>
                                </tr>

                                <tr>
                                    <td style="width: 10%;font-size:11px">4 bulan</td>
                                    <td style="width: 20%;font-size:11px">Tengkurap-terlentang sendiri</td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 30%;font-size:11px"></td>
                                </tr>

                                <tr>
                                    <td style="width: 10%;font-size:11px">5 bulan</td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 20%;font-size:11px">Meraih, menggapai</td>
                                    <td style="width: 20%;font-size:11px">Menoleh ke suara</td>
                                    <td style="width: 30%;font-size:11px">Meraih mainan</td>
                                </tr>

                                <tr>
                                    <td style="width: 10%;font-size:11px">6 bulan</td>
                                    <td style="width: 20%;font-size:11px">Duduk tanpa berpegangan</td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 30%;font-size:11px">Memasukkan benda ke mulut</td>
                                </tr>

                                <tr>
                                    <td style="width: 10%;font-size:11px">7 bulan</td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 20%;font-size:11px">Mengambil dgn tangan kanan dan kiri</td>
                                    <td style="width: 20%;font-size:11px">Bersuara ma..ma.., da.. da..</td>
                                    <td style="width: 30%;font-size:11px"></td>
                                </tr>

                                <tr>
                                    <td style="width: 10%;font-size:11px">8 bulan</td>
                                    <td style="width: 20%;font-size:11px">Berdiri berpegangan</td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 20%;font-size:11px">Bersuara ma..ma.., da.. da..</td>
                                    <td style="width: 30%;font-size:11px"></td>
                                </tr>

                                <tr>
                                    <td style="width: 10%;font-size:11px">9 bulan</td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 20%;font-size:11px">Menjimpit</td>
                                    <td style="width: 20%;font-size:11px">Memanggil mama, papa</td>
                                    <td style="width: 30%;font-size:11px">Melambaikan tangan</td>
                                </tr>

                                <tr>
                                    <td style="width: 10%;font-size:11px">10 bulan</td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 20%;font-size:11px">Memukul mainan dengan kedua tangan</td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 30%;font-size:11px">Bertepuk tangan</td>
                                </tr>

                                <tr>
                                    <td style="width: 10%;font-size:11px">11 bulan</td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 20%;font-size:11px">Memanggil mama, papa</td>
                                    <td style="width: 30%;font-size:11px">Menunjuk dan meminta</td>
                                </tr>

                                <tr>
                                    <td style="width: 10%;font-size:11px">12 bulan</td>
                                    <td style="width: 20%;font-size:11px">Berdiri tanpa berpegangan</td>
                                    <td style="width: 20%;font-size:11px">Memasukkan mainan ke cangkir</td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 30%;font-size:11px">Bermain dengan orang lain</td>
                                </tr>

                                <tr>
                                    <td style="width: 10%;font-size:11px">15 bulan</td>
                                    <td style="width: 20%;font-size:11px">Berjalan</td>
                                    <td style="width: 20%;font-size:11px">Mencoret-coret</td>
                                    <td style="width: 20%;font-size:11px">Berbicara 2 kata</td>
                                    <td style="width: 30%;font-size:11px">Minum dari gelas</td>
                                </tr>

                                <tr>
                                    <td style="width: 10%;font-size:11px">1,5 tahun</td>
                                    <td style="width: 20%;font-size:11px">Lari, naik tangga</td>
                                    <td style="width: 20%;font-size:11px">Menumpuk 2 kubus</td>
                                    <td style="width: 20%;font-size:11px">Berbicara beberapa kata</td>
                                    <td style="width: 30%;font-size:11px">Memakai sendok dan menyuapi boneka</td>
                                </tr>

                                <tr>
                                    <td style="width: 10%;font-size:11px">2 tahun</td>
                                    <td style="width: 20%;font-size:11px">Menendang bola</td>
                                    <td style="width: 20%;font-size:11px">Menumpuk 2 kubus</td>
                                    <td style="width: 20%;font-size:11px">Menujuk 1 gambar</td>
                                    <td style="width: 30%;font-size:11px">Menyikat gigi, melepas dan memakai pakaian</td>
                                </tr>

                                <tr>
                                    <td style="width: 10%;font-size:11px">2,5 tahun</td>
                                    <td style="width: 20%;font-size:11px">Melompat</td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 20%;font-size:11px">Menunjuk bagian 6 tubuh</td>
                                    <td style="width: 30%;font-size:11px">Mencuci dan mengeringkan tangan</td>
                                </tr>

                                <tr>
                                    <td style="width: 10%;font-size:11px">3 tahun</td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 30%;font-size:11px">Menumpuk 8 kubus</td>
                                    <td style="width: 20%;font-size:11px">Menyebut 4 gambar</td>
                                    <td style="width: 20%;font-size:11px">Menyebut nama teman</td>
                                </tr>
                                <tr>
                                    <td style="width: 10%;font-size:11px">3,5 tahun</td>
                                    <td style="width: 20%;font-size:11px">Berdiri satu kaki 3 detik</td>
                                    <td style="width: 30%;font-size:11px">Menggoyangkan ibu jari</td>
                                    <td style="width: 20%;font-size:11px">Bercerita singkat menyebutkan penggunaan benda</td>
                                    <td style="width: 20%;font-size:11px">Memakai baju kaos</td>
                                </tr>
                                <tr>
                                    <td style="width: 10%;font-size:11px">4 tahun</td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 30%;font-size:11px">Menggambar lingkaran</td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 20%;font-size:11px">Memakai baju tanpa dibatu</td>
                                </tr>
                                <tr>
                                    <td style="width: 10%;font-size:11px">4,5 tahun</td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 30%;font-size:11px">Menggambar manusia (kepala, badan, kaki, tangan)</td>
                                    <td style="width: 20%;font-size:11px"></td>
                                    <td style="width: 20%;font-size:11px">Bermain kartu, menyikat gigi tanpa dibantu</td>
                                </tr>
                                <tr>
                                    <td style="width: 10%;font-size:11px">5 tahun</td>
                                    <td style="width: 20%;font-size:11px">Berdiri satu kaki 5 detik</td>
                                    <td style="width: 30%;font-size:11px"></td>
                                    <td style="width: 20%;font-size:11px">Menghitung kubus</td>
                                    <td style="width: 20%;font-size:11px">Mengambil makanan sendiri</td>
                                </tr>
                            </table>

                            <p><b>HASIL PENGKAJIAN PERTUMBUHAN DAN PERKEMBANGAN BAYI DAN BALITA</b></p>
                            <p>Gerakan kasar/motorik kasar 	: <?= isset($data->hasil_pengkajian->gerakan_kasar)?$data->hasil_pengkajian->gerakan_kasar:'' ?></p>
                            <p>Gerakan halus/motorik halus	: <?= isset($data->hasil_pengkajian->gerakan_halus)?$data->hasil_pengkajian->gerakan_halus:'' ?></p>
                            <p>Komunikasi/ berbicara	: <?= isset($data->hasil_pengkajian->komunikasi_berbicara)?$data->hasil_pengkajian->komunikasi_berbicara:'' ?></p>
                            <p>Sosial & kemandirian	: <?= isset($data->hasil_pengkajian->sosial_kemandirian)?$data->hasil_pengkajian->sosial_kemandirian:'' ?></p>
                            <p>
                                Gangguan tumbuh kembang	:
                                <input type="checkbox" value="Ya" <?php echo isset($data->gangguan_tumbuh)? $data->gangguan_tumbuh == 'tidak' ? "checked":'':'' ?>>
                                <span>Ya</span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->gangguan_tumbuh)? $data->gangguan_tumbuh == 'ya' ? "checked":'':'' ?>>
                                <span>Tidak</span>
                            </p>
                            <p><i>Bila terdapat masalah tumbuh kembang lapor ke DPJP</i></p>
                            <p>Sudah dilaporkan ke DPJP 	:	
                                <span>Tgl : <?= isset($data->dpjp)? date('d-m-Y',strtotime($data->dpjp)):''; ?></span>
                                <span style="margin-left: 60px;" >Jam:  <?= isset($data->dpjp)? date('H-:i:s',strtotime($data->dpjp)):''; ?></span>
                            </p>
                    </div>
                </div><br><br><br>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 9 dari 10</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>

    <!-- halaman 10 -->

        <div class="A4 sheet  padding-fix-10mm">    
            <header>
                <?php $this->load->view('emedrec/ri/header_print_genap') ?>
            </header>
                <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                    ASESMEN AWAL KEPERAWATAN ANAK RAWAT INAP<br>
                </p>
                <div style="font-size:11px">
                    <span><b>13. DIAGNOSA KEPERAWATAN </b></span>
                    <div style="margin-left:25px"> 
                        <div class="flex">
                            <div>
                                <input type="checkbox" value="Bersihan jalan nafas tidak  efektif" <?= (isset($data->question27)?in_array(" bersihkan_jalan_nafas", $data->question27)?'checked':'':'') ?>>
                                <span>Bersihan jalan nafas tidak  efektif</span><br>
                                <input type="checkbox" value="Gangguan tumbuh kembang" <?= (isset($data->question27)?in_array(" bersihkan_jalan_nafas", $data->question27)?'checked':'':'') ?>>
                                <span>Gangguan tumbuh kembang</span><br>
                                <input type="checkbox" value="Hipertermi" <?= (isset($data->question27)?in_array("hipertermi", $data->question27)?'checked':'':'') ?>>
                                <span>Hipertermi</span><br>
                                <input type="checkbox" value="Penurunan kapasitas adaptif intra Kranial" <?= (isset($data->question27)?in_array("penurunan_kapasitas_adaptif", $data->question27)?'checked':'':'') ?>>
                                <span>Penurunan kapasitas adaptif intra Kranial</span><br>
                                <input type="checkbox" value="Risiko gangguan integritas kulit/jaringan" <?= (isset($data->question27)?in_array("risiko_gangguan_integritas_kulit", $data->question27)?'checked':'':'') ?>>
                                <span>Risiko gangguan integritas kulit/jaringan</span><br>
                            </div>

                            <div style="margin-left: 70px;">
                                <input type="checkbox" value="Defisit nutrisi" <?= (isset($data->question27)?in_array("defiisit_nutrisi", $data->question27)?'checked':'':'') ?>>
                                <span>Defisit nutrisi</span><br>
                                <input type="checkbox" value="Defisit perawatan diri" <?= (isset($data->question27)?in_array("defisit_perawatan_diri", $data->question27)?'checked':'':'') ?>>
                                <span>Defisit perawatan diri</span><br>
                                <input type="checkbox" value="Ansietas" <?= (isset($data->question27)?in_array("ansieta", $data->question27)?'checked':'':'') ?>>
                                <span>Ansietas</span><br>
                                <input type="checkbox" value="Diare" <?= (isset($data->question27)?in_array(" bersihkan_jalan_nafas", $data->question27)?'checked':'':'') ?>>
                                <span>Diare</span><br>
                                <input type="checkbox" value="Nyeri" <?= (isset($data->question27)?in_array("nyeri", $data->question27)?'checked':'':'') ?>>
                                <span>Nyeri</span><br>
                            </div>

                            <div style="margin-left: 70px;">
                                <input type="checkbox" value="Risiko Perfusi cerebral tidak efektif" <?= (isset($data->question27)?in_array("risiko_perfusi", $data->question27)?'checked':'':'') ?>>
                                <span>Risiko Perfusi cerebral tidak efektif</span><br>
                                <input type="checkbox" value="Risiko infeksi" <?= (isset($data->question27)?in_array(" risiko_infeksi", $data->question27)?'checked':'':'') ?>>
                                <span>Risiko infeksi</span><br>
                                <input type="checkbox" value="Risiko  Aspirasi" <?= (isset($data->question27)?in_array("resiko_aspirasi", $data->question27)?'checked':'':'') ?>>
                                <span>Risiko  Aspirasi</span><br>
                                <input type="checkbox" value="Risiko  Jatuh" <?= (isset($data->question27)?in_array("risiko_jatuh", $data->question27)?'checked':'':'') ?>>
                                <span>Risiko  Jatuh</span><br>
                            
                            </div>
                        </div>
                        <span>
                            <input type="checkbox" value="Lain-lainnya" <?= (isset($data->question28)?in_array("lainnya", $data->question28)?'checked':'':'') ?>>
                            <span for="Lain-lainnya">Lain-lainnya: <?= isset($data->question29)?$data->question29:'' ?></span><br>
                        </span><br><br><br>


                        <div class="flex">
                            <div>
                                <input type="checkbox" value="Latihan batuk efektif" <?= (isset($data->question31)?in_array("latihan_batuk_efektif", $data->question31)?'checked':'':'') ?>>
                                <span>Latihan batuk efektif</span><br>
                                <input type="checkbox" value="Manajemen jalan nafas" <?= (isset($data->question31)?in_array("manajemen_jalan_nafas", $data->question31)?'checked':'':'') ?>>
                                <span>Manajemen jalan nafas</span><br>
                                <input type="checkbox" value="Pengaturan posisi" <?= (isset($data->question31)?in_array(" ", $data->question31)?'checked':'':'') ?>>
                                <span>Pengaturan posisi</span><br>
                                <input type="checkbox" value="Pengisapan jalan nafas" <?= (isset($data->question31)?in_array("pengisapan_jalan_nafas", $data->question31)?'checked':'':'') ?>>
                                <span>Pengisapan jalan nafas</span><br>
                                <input type="checkbox" value="Perawatan perkembangan" <?= (isset($data->question31)?in_array("perawatan_perkembangan", $data->question31)?'checked':'':'') ?>>
                                <span>Perawatan perkembangan</span><br>
                                <input type="checkbox" value="Manajemen hipertermia" <?= (isset($data->question31)?in_array("manajemen_hipertermia", $data->question31)?'checked':'':'') ?>>
                                <span>Manajemen hipertermia</span><br>
                                <input type="checkbox" value="Manajemen kejang" <?= (isset($data->question31)?in_array("manajemen_kejang", $data->question31)?'checked':'':'') ?>>
                                <span>Manajemen kejang</span><br>
                                <input type="checkbox" value="Manajemen nyeri" <?= (isset($data->question31)?in_array("manajemen_nyeri", $data->question31)?'checked':'':'') ?>>
                                <span>Manajemen nyeri</span><br>
                                <input type="checkbox" value="Manajemen diare" <?= (isset($data->question31)?in_array("manajemen_diare", $data->question31)?'checked':'':'') ?>>
                                <span>Manajemen diare</span><br>
                                <input type="checkbox" value="Manajemen cairan" <?= (isset($data->question31)?in_array("manajemen_cairan", $data->question31)?'checked':'':'') ?>>
                                <span>Manajemen cairan</span><br>
                            
                            </div>

                            <div style="margin-left: 180px;">
                                <input type="checkbox" value="Dukungan perawatan diri" <?= (isset($data->question31)?in_array("dukungan_perawatan_diri", $data->question31)?'checked':'':'') ?>>
                                <span>Dukungan perawatan diri</span><br>
                                <input type="checkbox" value="Pencegahan jatuh" <?= (isset($data->question31)?in_array("pencegahan_jatuh", $data->question31)?'checked':'':'') ?>>
                                <span>Pencegahan jatuh</span><br>
                                <input type="checkbox" value="Manajemen nutrisi" <?= (isset($data->question31)?in_array("manajemen_nutrisi", $data->question31)?'checked':'':'') ?>>
                                <span>Manajemen nutrisi</span><br>
                                <input type="checkbox" value="Terapi relaksasi" <?= (isset($data->question31)?in_array("terapi_relaksasi", $data->question31)?'checked':'':'') ?>>
                                <span>Terapi relaksasi</span><br>
                                <input type="checkbox" value="Manajemen peningkatan tekanan intrakranial" <?= (isset($data->question31)?in_array("manajemen_peningkatan_tekanan", $data->question31)?'checked':'':'') ?>>
                                <span>Manajemen peningkatan tekanan intrakranial</span><br>
                                <input type="checkbox" value="Pencegahan infeksi" <?= (isset($data->question31)?in_array("pencegahan_infeksi", $data->question31)?'checked':'':'') ?>>
                                <span>Pencegahan infeksi</span><br>
                                <input type="checkbox" value="Pencegahan aspirasi" <?= (isset($data->question31)?in_array("pencegahan_aspirasi pengaturan_posisi", $data->question31)?'checked':'':'') ?>>
                                <span>Pencegahan aspirasi</span><br>
                                <input type="checkbox" value="Perawatan integritas kulit" <?= (isset($data->question31)?in_array("perawatan_integritas_kulit", $data->question31)?'checked':'':'') ?>>
                                <span>Perawatan integritas kulit</span><br>
                                <input type="checkbox" value="Kolaborasi dalam pemberian obat" <?= (isset($data->question31)?in_array("kolaborasi_dalam_pemberian_obat", $data->question31)?'checked':'':'') ?>>
                                <span>Kolaborasi dalam pemberian obat</span><br>
                                <input type="checkbox" value="Manajemen cairan" <?= (isset($data->question31)?in_array("manajemen_cairan", $data->question31)?'checked':'':'') ?>>
                                <span>Manajemen cairan</span><br>
                                <input type="checkbox" value="Manajemen cairan" <?= (isset($data->question32)?in_array("lainnya", $data->question32)?'checked':'':'') ?>>
                                <span><?= isset($data->question33)?$data->question33:'' ?></span><br>
                                
                            </div>
                        </div>


                        <div style="display: inline; position: relative;">
                            <div style="float: left;">
                                <p>
                                    <span>Tanggal selesai pengkajian :<?= isset($data->question34)? date('d-m-Y',strtotime($data->question34)):''; ?></span><br>
                                    <span>jam :<?= isset($data->question34)? date('H:i:s',strtotime($data->question34)):''; ?></span>                      
                                </p>
                                <p>Perawat yang mengkaji I</p>
                                <img width="120px" height="130px"src="<?= (isset($ttd_perawat_one->ttd)?$ttd_perawat_one->ttd:''); ?>" alt=""><br>
                                <span><?= isset($data->question36)?$data->question36:'' ?></span>      
                            </div>
                            <div style="float: right;">
                                <p>
                                    <span>Tanggal selesai pengkajian :<?= isset($data->question35)? date('d-m-Y',strtotime($data->question35)):''; ?></span><br>                                                      
                                    <span>Jam : <?= isset($data->question35)? date('H:i:s',strtotime($data->question35)):''; ?>
                                </p>
                                <p>Perawat yang mengkaji II</p>
                                <img width="120px" height="130px" src="<?= (isset($ttd_perawat_two->ttd)?$ttd_perawat_two->ttd:''); ?>" alt=""> <br>
                                <span><?= isset($data->question37)?$data->question37:'' ?></span>      
                            </div>
                        </div>
                    </div>
                </div><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                <div style="display: inline; position: relative;font-size: 12px;">
                    <div style="float: left;text-align: center;">
                        <p>Hal 10 dari 10</p>    
                    </div>
                    <div style="float: right;text-align: center;">
                        <p> <?php echo isset($kode_document)?$kode_document!=""?$kode_document->tgl_rev_form.'.'.' '.$kode_document->kode_form:"":""; ?> </p>
                    </div>     
                </div> 
        </div>

</html>

