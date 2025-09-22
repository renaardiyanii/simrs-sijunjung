<?php 
// var_dump($assesment_awal_keperawatan_iri[0]);
//   var_dump(isset($assesment_awal_keperawatan_iri[0]->formjson)?json_decode($assesment_awal_keperawatan_iri[0]->formjson):'');
$data = (isset($assesment_awal_keperawatan_iri[0]->formjson)?json_decode($assesment_awal_keperawatan_iri[0]->formjson):'');
// $jsonf = json_decode($data->question885, TRUE);
//   var_dump($data);
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

       table tr td{
           font-size:11px!important;
       } 
       
        .bg-checked{
        background-color:#64C9CF;
      
    }

    </style>
    <link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">
    <body class="A4" >
        <div class="A4 sheet  padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                ASESMEN AWAL KEPERAWATAN  RAWAT INAP<br>
                (Dilengkapi 24 jam pasien masuk Ruang Rawat)
            </p>
                <div style="font-size:11px">
                    <table border="0" width="100%" style="font-size:9px">
                        <tr>
                            <td width="15%" ><span class="">Tiba di ruangan</span></span></td>
                            <td width="3%"><span class="">:<span class=""></span></span></td>
                            <td width="20%" ><span class="">Tanggal <?=':'.' '.(isset($data->tgl)?date('d-m-Y',strtotime($data->tgl)):'')?><span class=""></span></span></td>
                            <td width="15%"><span class="">Jam<?=' '.':'.' '.(isset($data->tgl)?date('H:i:s',strtotime($data->tgl)):'')?><span class=""></span></span></td>
                            <td width="20%"><span class=""><span class=""></span></span></td>
                        </tr>
                        <!-- belum -->
                        <tr>
                            <td width="15%" ><span class="">Pengkajian</span></span></td>
                            <td width="3%"><span class="">:<span class=""></span></span></td>
                            <td width="8%"><span class="">Tanggal<?=' '.':'.' '.(isset($data->tgl_selesai)?date('d-m-Y',strtotime($data->tgl_selesai)):'')?><span class=""></span></span></td>
                            <td width="20%" ><span class="">Jam <?=' '.':'.' '.(isset($data->tgl_selesai)?date('H:i:s',strtotime($data->tgl_selesai)):'')?></span></span></td>
                            <td width="20%"><span class=""><span class=""></span></span></td>
                        </tr>
                        <!--  -->
                        <tr>
                            <td width="15%" ><span class=""></span></span></td>
                            <td width="3%"><span class=""><span class="text_isi"></span></span></td>
                            <td width="8%"><span class="">
                                <input type="checkbox" value="Auto Anamnesa"  <?php echo isset($data->auto_anamnesa)? $data->auto_anamnesa == "auto" ? "checked":'':'' ?>>
                                <span>Auto Anamnesa</span>
                            </td>
                            <td width="10%" ><span class="">
                                <input type="checkbox" value="Auto Anamnesa" <?php echo isset($data->auto_anamnesa)? $data->auto_anamnesa != "auto" ? "checked":'':'' ?>>
                                <span>Allo Anamnesa <?=':'.(isset($data->check_anamnesa)?$data->check_anamnesa:'')?></span>
                            </td>
                            <td width="20%"><span class="">Hubungan<?=' '.':'.' '.(isset($data->tgl_selesai)?date('d-m-Y',strtotime($data->tgl_selesai)):'')?></span></td>
                        </tr>
                        <tr>
                            <td width="15%" ><span class="">Cara Masuk</span></span></td>
                            <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                            <td width="8%"><span class="">
                                <input type="checkbox" <?php echo isset($data->cara_masuk)? $data->cara_masuk == "jalan_tanpa_bantuan" ? "checked":'':'' ?>>
                                <span>Jalan</span>
                            </td>
                            <td width="10%" ><span class="">
                                <input type="checkbox" <?php echo isset($data->cara_masuk)? $data->cara_masuk == "kursi_roda" ? "checked":'':'' ?>>
                                <span>Kursi Roda</span>
                            </td>
                           
                            <td width="10%" ><span class="">
                                <input type="checkbox" <?php echo isset($data->cara_masuk)? $data->cara_masuk == "lainnya" ? "checked":'':'' ?>>
                                <span>Lain Lain <?=':'.(isset($data->check_cara_masuk)?$data->check_cara_masuk:'')?></span>
                            </td>
                           
                        </tr>
                        <tr>
                            <td width="15%" ><span class="">Asal Masuk</span></span></td>
                            <td width="3%"><span class="">:<span class="text_isi"></span></span></td>
                            <td width="8%"><span class="">
                                <input type="checkbox" <?php echo isset($data->asal_masuk)? $data->asal_masuk == "igd" ? "checked":'':'' ?>>
                                <span>IGD</span>
                            </td>
                            <td width="10%" ><span class="">
                                <input type="checkbox" <?php echo isset($data->asal_masuk)? $data->asal_masuk == "rawat_jalan" ? "checked":'':'' ?>>
                                <span>Rawat Jalan</span>
                            </td> 
                            <td width="10%" ><span class="">
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
                               
                                    <span>Pupil</span>
                                    <span style="margin-left:10px">:</span>
                                    <span style="margin-left:10px">Kanan:<?=' '.(isset($data->Pupil_kanan)?$data->Pupil_kanan:'').' '.'mm'?></span>
                                    <span style="margin-left:20px">Kiri:<?=' '.(isset($data->pupil_kiri)?$data->pupil_kiri:'').' '.'mm'?></span>
                                    <span style="margin-left:30px;">Suhu:<?=' '.(isset($data->suhu)?$data->suhu:'').' '.'°C'?></span>
                               
                            </div>
                    </div>


                    <div style="display: flex;margin-left:10px">
                            <div style="flex-direction: column;">
                            <p>
                                    <span>Reaksi Cahaya :</span>
                                    <span style="margin-left:5px">Kanan:<?=' '.(isset($data->reaksi_cahaya_kanan)?$data->reaksi_cahaya_kanan:'')?></span>
                                    <span style="margin-left:20px">Kiri:<?=' '.(isset($data->reaksi_cahaya_kiri)?$data->reaksi_cahaya_kiri:'')?></span>
                            </p> 
                            </div>
                           
                            <div>
                                <p>
                                    
                                        <span  style="margin-left: 30px;">Nadi:<?=' '.(isset($data->nadi)?$data->nadi:'').' '.'x/menit'.','.' '.(isset($data->tidak_teratur_nadi)?$data->tidak_teratur_nadi:'')?></span>
                                        <span style="margin-left:20px">Tekanan Darah:<?=' '.(isset($data->tekanan_darah)?$data->tekanan_darah:'').' '.'mmHG'?></span>
                                        
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
                            <div style="margin-left: 120px;">
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
                            <span>KOMPOSMENTIS</span>
                            <input type="checkbox" value="Apatis" style="margin-left:30px" <?php echo isset($data->kesadaran)? $data->kesadaran == "APATIS" ? "checked":'':'' ?>>
                            <span>APATIS</span>
                            <input type="checkbox" value="Somnolent" style="margin-left:30px" <?php echo isset($data->kesadaran)? $data->kesadaran == "SAMNOLEN" ? "checked":'':'' ?>>
                            <span>SAMNOLEN</span>
                            <input type="checkbox" value="Koma" style="margin-left:30px" <?php echo isset($data->kesadaran)? $data->kesadaran == "SOPOR" ? "checked":'':'' ?>>
                            <span>SOPOR</span>
                            <input type="checkbox" value="Koma" style="margin-left:30px" <?php echo isset($data->kesadaran)? $data->kesadaran == "SOPOROCOMA" ? "checked":'':'' ?>>
                            <span>SOPOROCOMA</span>
                            <input type="checkbox" value="Koma" style="margin-left:30px" <?php echo isset($data->kesadaran)? $data->kesadaran == "KOMA" ? "checked":'':'' ?>>
                            <span>KOMA</span>
                            </p>
                        </span>
                    </div>

                    <div>
                      
                            -	Kepala	:
                            <p style="margin-left: 20px;">		            		    			
                                <input type="checkbox" value="Mesosefal" >                            
                                <span>Mesosefal</span>
                                <input type="checkbox" value="Asimetris"   >                          
                                <span>Asimetris</span>
                                <input type="checkbox" value="Hematoma"  >                          
                                <span>Hematoma</span>
                                <input type="checkbox" value="Tidak ada masalah "  >                           
                                <span>Tidak ada masalah </span>
                                <input type="checkbox" value=""   >                      
                                <span><?=' '.(isset($data->check_kepala)?$data->check_kepala:'')?></span>
                            <p>
                        
                    </div>

                    <div>
                       
                        -	Rambut	:		  
                        <p style="margin-left: 20px;">          		    			
                            <input type="checkbox" value="Kotor" >                    
                            <span>Kotor</span>
                            <input type="checkbox" value="berminyak">
                            <span>berminyak</span>
                            <input type="checkbox" value="Kering" >                       
                            <span>Kering</span>
                            <input type="checkbox" value="rontok"  >                       
                            <span>rontok</span>
                            <input type="checkbox" value="Tidak ada masalah ">
                            <span>Tidak ada masalah </span>
                            <input type="checkbox" value="" >                              
                            <span><?=' '.(isset($data->check_rambut)?$data->check_rambut:'')?></span>
                            
                        </p>
                    </div>

                    <div>
                            -	Muka	:	   
                            <p style="margin-left: 20px;">        		    			
                            <input type="checkbox" value=" Asimetris" >           
                            <span> Asimetris</span>
                            <input type="checkbox" value="Bells  palsy" >               
                            <span>Bells  palsy</span>
                            <input type="checkbox" value="Tic Facialis"  >                
                            <span>Tic Facialis</span>
                            <input type="checkbox" value="Kelainaan kongonital" >
                            <span>Kelainaan kongonital</span>
                            <input type="checkbox" value="Tidak ada masalah "  >          
                            <span>Tidak ada masalah </span>
                        </p>
                    </div>

                    <div>
                            -	Mata :	
                            <p style="margin-left: 20px;">      		    			
                            <input type="checkbox" value="Gangguan penglihatan" >
                            <span>Gangguan penglihatan</span>
                            <input type="checkbox" value="Sclera anemis">                  
                            <span>Sclera anemis</span>
                            <input type="checkbox" value="Konyungtivitis" >                   
                            <span>Konyungtivitis</span>
                            <input type="checkbox" value="Anisokor"  >      
                            <span>Anisokor</span>
                            <input type="checkbox" value="Midriasis/miosis"   >                     
                            <span>Midriasis/miosis</span><br>
                            <span>
                            <input type="checkbox" value="Tidak ada reaksi cahaya" >                 
                            <span>Tidak ada reaksi cahaya</span>
                            <input type="checkbox" value="Tidak ada masalah" >                         
                            <span>Tidak ada masalah</span>
                            <input type="checkbox" value="Ada alat bantu"  >                  
                            <span> Ada alat bantu, lokasi<?=' '.':'.(isset($data->check_mata)?$data->check_mata:'')?></span>
                        </p>
                    </div>

                    <div>
                        
                            -	Telinga	:    
                            <p style="margin-left: 20px;">      		    			
                            <input type="checkbox" value="Berdengung" >      
                            <span>Berdengung</span>
                            <input type="checkbox" value="Nyeri" >         
                            <span>Nyeri</span>
                            <input type="checkbox" value="Tuli" >                        
                            <span>Tuli</span>
                            <input type="checkbox" value="Keluar cairan" >             
                            <span>Keluar cairan</span>
                            <input type="checkbox" value="Tidak ada masalah " >                    
                            <span>Tidak ada masalah </span>
                            <input type="checkbox" value="" > 
                            <span><?=' '.(isset($data->check_telinga)?$data->check_telinga:'')?></span>
                            
                        </p>
                    </div>

                    <div>
                        
                        -	Hidung	:
                        <p style="margin-left: 20px;">	       		    			
                            <input type="checkbox" value="Tidak ada masalah" >
                            <span>Tidak ada masalah</span>
                            <input type="checkbox" value="asimetris" >            
                            <span>Asimetris</span>
                            <input type="checkbox" value="epistakis" >              
                            <span>Epistaksis</span>
                            <input type="checkbox" value="" >          
                            <span><?=' '.(isset($data->chechk_hidung)?$data->chechk_hidung:'')?></span>
                            
                        </p> 
                    </div>

                    <div>
                            -	Mulut	:
                            <p style="margin-left: 20px;">				    			
                            <input type="checkbox" value="Simetris" >                           
                            <span>Simetris</span>
                            <input type="checkbox" value="asimetris" >
                            <span>Asimetris</span>
                            <input type="checkbox" value="Bibir pucat" >    
                            <span>Bibir pucat</span>
                            <input type="checkbox" value="Kelainan kongenital" >               
                            <span>Kelainan kongenital</span>
                            <input type="checkbox" value="Tidak ada masalah" >              
                             <span>Tidak ada masalah</span>
                            <input type="checkbox" value="" >
                            <span><?=' '.(isset($data->chechk_hidung)?$data->check_mulut:'')?></span>
                            
                        </p> 
                    </div>

                    <div>
                        
                        -	Gigi	:
                        <p style="margin-left: 20px;">			    			
                            <input type="checkbox" value="Karies" >        
                            <span>Karies</span>
                            <input type="checkbox" value="Goyang" >        
                            <span>Goyang</span>
                            <input type="checkbox" value="Tambal" >        
                            <span>Tambal</span>
                            <input type="checkbox" value="Gigi palsu" >                
                            <span>Gigi palsu</span>
                            <input type="checkbox" value="Tidak ada masalah" >
                            <span>Tidak ada masalah</span>
                            <input type="checkbox" value="" >              
                            <span><?=' '.(isset($data->chechk_gigi)?$data->chechk_gigi:'')?></span>
                            <span></span>
                        </p> 
                    </div>

                    <div>
                         
                        -	Lidah	:
                        <p style="margin-left: 20px;">				    			
                            <input type="checkbox" value="Kotor" >
                            <span>Kotor</span>
                            <input type="checkbox" value="Mukosa kering" >                
                            <span>Mukosa kering</span>
                            <input type="checkbox" value="Gerakan asimetris" >                      
                            <span>Gerakan asimetris</span>
                            <input type="checkbox" value="Tidak ada masalah" >                       
                            <span>Tidak ada masalah</span>
                            <input type="checkbox" value="" >        
                            <span><?=' '.(isset($data->chechk_lidah)?$data->chechk_lidah:'')?></span>
                            <span></span>
                        </p> 
                    </div>

                    <div>
                           
                        -	Tenggorokan	: 
                        <p style="margin-left: 20px;">	  			
                            <input type="checkbox" value="Faring merah" >
                            <span>Faring merah</span>
                            <input type="checkbox" value="Sakit menelan" >  
                            <span>Sakit menelan</span>
                            <input type="checkbox" value="Tonsil membesar" >      
                            <span>Tonsil membesar</span>
                            <input type="checkbox" value="Tidak ada masalah" >         
                            <span>Tidak ada masalah</span>
                            <input type="checkbox" value="" >                       
                            <span><?=' '.(isset($data->check_tenggorokan)?$data->check_tenggorokan:'')?></span>
                            
                        </p> 
                    </div>

                    <div>
                          
                        -	Leher	:  	
                        <p style="margin-left: 20px;">		
                            <input type="checkbox" value="Pembesaran tiroid " >                
                            <span>Pembesaran tiroid </span>
                            <input type="checkbox" value="Pembesaran vena jugularis" >
                            <span>Pembesaran vena jugularis</span>
                            <input type="checkbox" value="Kaku kuduk" >  
                            <span>Kaku kuduk</span>
                            <input type="checkbox" value="Tidak ada kelaianan" >                  
                            <span>Tidak ada kelaianan</span><br>
                            <input type="checkbox" value="Keterbatasan gerak" >                 
                             <span>Keterbatasan gerak</span>
                            <input type="checkbox" value="" >                             
                            <span><?=' '.(isset($data->check_leher)?$data->check_leher:'')?></span>
                            
                        </p> 
                    </div>

                    <div>
                    <p>	
                        -	Dada	: 	
                        	
                            <input type="checkbox" value="Asimetris" >                    
                            <span>Asimetris</span>
                            <input type="checkbox" value="Retrakal" >              
                            <span>Retrakal</span>
                            <input type="checkbox" value="Tidak ada kelaianan" >          
                            <span>Tidak ada kelaianan</span>
                            <input type="checkbox" value="lain-lain" >
                            <span><?=' '.(isset($data->check_dada)?$data->check_dada:'')?></span>
                        </p> 
                    </div>
                    
                            
                </div>
                <p style="text-align:right;font-size:12px">1</p> 
        </div>

<!-- halaman 2 -->
        <div class="A4 sheet  padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/header_print_ganjil') ?>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                ASESMEN AWAL KEPERAWATAN  RAWAT INAP<br>
                (Dilengkapi 24 jam pasien masuk Ruang Rawat)
            </p>
            <div style="font-size:11px">

                   

                    <div style="margin-left:40px">
                    
                        <p>    
                        Respirasi 	:   			
                            <input type="checkbox" value="Tidak ada kesulitan" >                
                            <span>Tidak ada kesulitan</span>
                            <input type="checkbox" value="Nyeri" >                    
                            <span>Nyeri</span>
                            <input type="checkbox" value="Batuk" >      
                            <span>Batuk</span>
                            <input type="checkbox" value="Dyspnea" >            
                            <span>Dyspnea</span>
                            <input type="checkbox" value="Sputum" >          
                            <span>Sputum</span>
                            <input type="checkbox" value="Tracheostomy" >                    
                            <span>Tracheostomy</span><br>
                            <span style="margin-left: 80px;">   			
                            <input type="checkbox" value="Ronchi" >          
                            <span>Ronchi di paru kiri/kanan</span>
                            <input type="checkbox" value="Wheezing" >             
                            <span>Wheezing</span>
                            <input type="checkbox" value="Nafas pendek" >        
                            <span>Nafas pendek</span>
                            <input type="checkbox" value="Haemaptoe" >                
                            <span>Haemaptoe</span><br>
                            <span style="margin-left: 80px;">   			
                            <input type="checkbox" value="Bradipnea" >                
                            <span>Bradipnea</span>
                            <input type="checkbox" value="Takpnea" >            
                            <span>Takpnea</span>
                            <input type="checkbox" value="Sleep apnea" >        
                            <span>Sleep apnea</span>
                            <input type="checkbox" value="lain-lain" >            
                            <span><?=' '.(isset($data->chechk_respira)?$data->chechk_respira:'')?></span><br>
                            <span style="margin-left: 80px;"> 
                            <input type="checkbox" value="Alat bantu nafas saat di rumah"  >
                            <span>Alat bantu nafas saat di rumah</span>
                            <input type="checkbox" value="tidak" <?php echo isset($data->check_ya_tidak)?$data->check_ya_tidak != 'ya'?'checked':'':''  ?>>
                            <span>tidak</span>
                            <input type="checkbox" value="ya" <?php echo isset($data->check_ya_tidak)?$data->check_ya_tidak == 'ya'?'checked':'':''  ?>>
                            <span>ya, jika ya<?=' '.':'.(isset($data->check_alat_bantu)?$data->check_alat_bantu:'')?></span>
                        </p> 
                   
                        <p>     
                        Jantung 	:  			
                            <input type="checkbox" value="nyeri_dada" >                           
                             <span>Nyeri Dada</span>
                            <input type="checkbox" value="Aritmia" >                       
                            <span>Aritmia</span>
                            <input type="checkbox" value=" Palpitasi " >                           
                            <span> Palpitasi </span>

                            <input type="checkbox" value="Pacemaker"  >                            
                            <span>Pacemaker,<?=' '.(isset($data->check_pancaker)?$data->check_pancaker:'')?></span><br>
                            <input type="checkbox" style="margin-left: 68px;" value="Pingsan" >                       
                            <span> Pingsan</span>
                            <input type="checkbox" value=" Tachikardia" >
                            <span> Tachikardia</span>
                            <input type="checkbox" value="Bradikardi" >                           
                             <span>Bradikardi</span>
                            <input type="checkbox" value="lain-lain" >                       
                            <span><?=' '.(isset($data->check_jantung)?$data->check_jantung:'')?></span>
                            <input type="checkbox" value="Bradikardi" >                           
                            <span>Tidak ada masalah</span>
                        </p> 
                    </div>

                    <div>
                           
                        -	Abdomen	:
                        <p style="margin-left:20px"> 			
                            <input type="checkbox" value="Distensi" >        
                            <span>Distensi</span>
                            <input type="checkbox" value="Asites"  >      
                            <span>Asites</span>
                            <input type="checkbox" value="Jumlah bising usus" >
                            <span>Jumlah bising usus<?=' '.':'.(isset($data->jumlah_usus)?$data->jumlah_usus:'').' '.'x/menit'?></span>
                            <input type="checkbox" value="Tidak ada kelaianan" >
                            <span>Tidak ada kelaianan</span>
                            <input type="checkbox" value="lain-lain" >        
                            <span><?=' '.(isset($data->check_abodemen2)?$data->check_abodemen2:'')?></span>
                        </p> 
                    </div>

                <div>
                        <p>    
                            -	Integumen <br>
                            <p style="margin-left:25px">		
                                <input type="checkbox" value="Turgor">                
                                <span>Turgor<?=':'.(isset($data->check_tugor)?$data->check_tugor:'')?></span>
                                <input type="checkbox" value="Dingin">                
                                <span>Dingin</span>
                                <input type="checkbox" value="Bula">            
                                <span>Bula</span>
                                <input type="checkbox" value="Fistula">                 
                                 <span>Fistula</span>
                                <input type="checkbox" value="Pucat">             
                                 <span>Pucat </span>
                                <input type="checkbox" value="Baal">            
                                <span>Baal </span><br>
                                <input type="checkbox" value="RL positif">                       
                                 <span>RL positif</span>
                                <input type="checkbox" value="Rash/kemerahan">  
                                 <span>Rash/kemerahan</span>
                                <input type="checkbox" value="Lesi">            
                                <span>Lesi</span><br>
                                <span>
                                <input type="checkbox" value="Luka parut">                        
                                <span>Luka parut</span>
                                <input type="checkbox" value="Diaphoresis">>
                                <span>Diaphoresis/banyak berkeringat</span>
                                <input type="checkbox" value="Memar">             
                                 <span>Memar</span>
                                <input type="checkbox" value="Ada indikasi kekerasan fisik">                          
                                 <span>Ada indikasi kekerasan fisik</span>
                                <input type="checkbox" value="Tidak ada kelaianan">      
                                 <span>Tidak ada kelaianan</span>
                                <input type="checkbox" value="lain-lain">                  
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
                                    <td style="width: 5%;font-size:11px;text-align:center" class="<?= isset($data->assesment_dekubitis->result->{'1'})?$data->assesment_dekubitis->result->{'1'} == "4"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'1'})?$data->assesment_dekubitis->result->{'1'} == "4"?"√":"":"" ?></td>
                                    <td style="width: 15%;font-size:11px;text-align:center">Waspada</td>
                                    <td style="width: 5%;font-size:11px;text-align:center"  class="<?= isset($data->assesment_dekubitis->result->{'2'})?$data->assesment_dekubitis->result->{'2'} == "4"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'2'})?$data->assesment_dekubitis->result->{'2'} == "4"?"√":"":"" ?></td>
                                    <td style="width: 15%;font-size:11px;text-align:center">Ambulasi baik</td>
                                    <td style="width: 5%;font-size:11px;text-align:center" class="<?= isset($data->assesment_dekubitis->result->{'3'})?$data->assesment_dekubitis->result->{'3'} == "4"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'3'})?$data->assesment_dekubitis->result->{'3'} == "4"?"√":"":"" ?></td>
                                    <td style="width: 15%;font-size:11px;text-align:center">Penuh</td>
                                    <td style="width: 5%;font-size:11px;text-align:center" class="<?= isset($data->assesment_dekubitis->result->{'4'})?$data->assesment_dekubitis->result->{'4'} == "4"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'4'})?$data->assesment_dekubitis->result->{'4'} == "4"?"√":"":"" ?></td>
                                    <td style="width: 15%;font-size:11px;text-align:center">Kontinen</td>
                                    <td style="width: 5%;font-size:11px;text-align:center" class="<?= isset($data->assesment_dekubitis->result->{'5'})?$data->assesment_dekubitis->result->{'5'} == "4"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'5'})?$data->assesment_dekubitis->result->{'5'} == "4"?"√":"":"" ?></td>
                                    <td style="width: 15%;font-size:11px;text-align:center"></td>
                                </tr>

                                <tr>
                                    <td style="width: 5%;font-size:11px;text-align:center">3</td>
                                    <td style="width: 15%;font-size:11px;text-align:center">Cukup</td>
                                    <td style="width: 5%;font-size:11px;text-align:center" class="<?= isset($data->assesment_dekubitis->result->{'1'})?$data->assesment_dekubitis->result->{'1'} == "3"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'1'})?$data->assesment_dekubitis->result->{'1'} == "3"?"√":"":"" ?></td>
                                    <td style="width: 15%;font-size:11px;text-align:center">Apatis</td>
                                    <td style="width: 5%;font-size:11px;text-align:center"class="<?= isset($data->assesment_dekubitis->result->{'2'})?$data->assesment_dekubitis->result->{'2'} == "3"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'2'})?$data->assesment_dekubitis->result->{'2'} == "3"?"√":"":"" ?></td>
                                    <td style="width: 15%;font-size:11px;text-align:center">Perlu bantuan</td>
                                    <td style="width: 5%;font-size:11px;text-align:center" class="<?= isset($data->assesment_dekubitis->result->{'3'})?$data->assesment_dekubitis->result->{'3'} == "3"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'3'})?$data->assesment_dekubitis->result->{'3'} == "3"?"√":"":"" ?></td>
                                    <td style="width: 15%;font-size:11px;text-align:center">Terbatas</td>
                                    <td style="width: 5%;font-size:11px;text-align:center" class="<?= isset($data->assesment_dekubitis->result->{'4'})?$data->assesment_dekubitis->result->{'4'} == "3"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'4'})?$data->assesment_dekubitis->result->{'4'} == "3"?"√":"":"" ?></td>
                                    <td style="width: 15%;font-size:11px;text-align:center">Kadang inkontinen</td>
                                    <td style="width: 5%;font-size:11px;text-align:center" class="<?= isset($data->assesment_dekubitis->result->{'5'})?$data->assesment_dekubitis->result->{'5'} == "3"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'5'})?$data->assesment_dekubitis->result->{'5'} == "3"?"√":"":"" ?></td>
                                    <td style="width: 15%;font-size:11px;text-align:center"></td>
                                </tr>

                                <tr>
                                    <td style="width: 5%;font-size:11px;text-align:center">2</td>
                                    <td style="width: 15%;font-size:11px;text-align:center">Lemah</td>
                                    <td style="width: 5%;font-size:11px;text-align:center" class="<?= isset($data->assesment_dekubitis->result->{'1'})?$data->assesment_dekubitis->result->{'1'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'1'})?$data->assesment_dekubitis->result->{'1'} == "2"?"√":"":"" ?></td>
                                    <td style="width: 15%;font-size:11px;text-align:center">Bingung</td>
                                    <td style="width: 5%;font-size:11px;text-align:center"class="<?= isset($data->assesment_dekubitis->result->{'2'})?$data->assesment_dekubitis->result->{'2'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'2'})?$data->assesment_dekubitis->result->{'2'} == "2"?"√":"":"" ?></td>
                                    <td style="width: 15%;font-size:11px;text-align:center">Tak bisa pindah bed</td>
                                    <td style="width: 5%;font-size:11px;text-align:center" class="<?= isset($data->assesment_dekubitis->result->{'3'})?$data->assesment_dekubitis->result->{'3'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'3'})?$data->assesment_dekubitis->result->{'3'} == "2"?"√":"":"" ?></td>
                                    <td style="width: 15%;font-size:11px;text-align:center">Sangat terbatas</td>
                                    <td style="width: 5%;font-size:11px;text-align:center" class="<?= isset($data->assesment_dekubitis->result->{'4'})?$data->assesment_dekubitis->result->{'4'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'4'})?$data->assesment_dekubitis->result->{'4'} == "2"?"√":"":"" ?></td>
                                    <td style="width: 15%;font-size:11px;text-align:center">Inkontinen BAK</td>
                                    <td style="width: 5%;font-size:11px;text-align:center" class="<?= isset($data->assesment_dekubitis->result->{'5'})?$data->assesment_dekubitis->result->{'5'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'5'})?$data->assesment_dekubitis->result->{'5'} == "2"?"√":"":"" ?></td>
                                    <td style="width: 15%;font-size:11px;text-align:center"></td>
                                </tr>

                                <tr>
                                    <td style="width: 5%;font-size:11px;text-align:center">1</td>
                                    <td style="width: 10%;font-size:11px;text-align:center">Sangat lemah</td>
                                    <td style="width: 5%;font-size:11px;text-align:center" class="<?= isset($data->assesment_dekubitis->result->{'1'})?$data->assesment_dekubitis->result->{'1'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'1'})?$data->assesment_dekubitis->result->{'1'} == "1"?"√":"":"" ?></td>
                                    <td style="width: 10%;font-size:11px;text-align:center">Tak sadar</td>
                                    <td style="width: 5%;font-size:11px;text-align:center"class="<?= isset($data->assesment_dekubitis->result->{'2'})?$data->assesment_dekubitis->result->{'2'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'2'})?$data->assesment_dekubitis->result->{'2'} == "1"?"√":"":"" ?></td>
                                    <td style="width: 10%;font-size:11px;text-align:center">Tak bergerak</td>
                                    <td style="width: 5%;font-size:11px;text-align:center" class="<?= isset($data->assesment_dekubitis->result->{'3'})?$data->assesment_dekubitis->result->{'3'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'3'})?$data->assesment_dekubitis->result->{'3'} == "1"?"√":"":"" ?></td>
                                    <td style="width: 10%;font-size:11px;text-align:center">Imobilisasi</td>
                                    <td style="width: 5%;font-size:11px;text-align:center" class="<?= isset($data->assesment_dekubitis->result->{'4'})?$data->assesment_dekubitis->result->{'4'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'4'})?$data->assesment_dekubitis->result->{'4'} == "1"?"√":"":"" ?></td>
                                    <td style="width: 10%;font-size:11px;text-align:center">Inkonkontinen BAB & BAK</td>
                                    <td style="width: 5%;font-size:11px;text-align:center" class="<?= isset($data->assesment_dekubitis->result->{'5'})?$data->assesment_dekubitis->result->{'5'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_dekubitis->result->{'5'})?$data->assesment_dekubitis->result->{'5'} == "1"?"√":"":"" ?></td>
                                    <td style="width: 10%;font-size:11px;text-align:center"></td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="text-align: right;">Jumlah</td>
                                    <td style="width: 15%;text-align:center"><?=(isset($data->assesment_dekubitis->result->total_skor)?$data->assesment_dekubitis->result->total_skor:'')?></td>
                                </tr>
                                
                            </table><br>
                            <input type="checkbox" <?php echo isset($data->resiko_ranap)?$data->resiko_ranap == 'tinggi'?'checked':'':''  ?>>
                            <span>Resiko tinggi : > 14</span>
                        
                            <input type="checkbox"  style="margin-left: 80px;" <?php echo isset($data->resiko_ranap)?$data->resiko_ranap == 'sedang'?'checked':'':''  ?>>
                            <span>Resiko sedang : 12 – 13</span>
                            
                            <input type="checkbox" style="margin-left: 70px;" <?php echo isset($data->resiko_ranap)?$data->resiko_ranap == 'rendah'?'checked':'':''  ?>>
                            <span>Resiko rendah : < 14</span>
                        </p> 
                    </p>
                </div>

                <div>
                        <span>
                        <span>-	Ekstremitas	:</span><br>
                        <p style="margin-left:25px">
                        
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
                        <input type="checkbox" value="Edema" <?php echo isset($data->question107)?$data->question107 == 'edema'?'checked':'':''  ?>>
                      
                        <span>Edema </span>
                        <input type="checkbox" value="Rasa baal" <?php echo isset($data->question107)?$data->question107 == 'rasa_baal'?'checked':'':''  ?>>
                       
                        <span>Rasa baal</span><br>
                        <input type="checkbox" value="Tidak ada kelaianan" <?php echo isset($data->question107)?$data->question107 == 'tidak_ada_kelaaian'?'checked':'':''  ?>>
                       
                        <span>Tidak ada kelaianan </span>
                        <input type="checkbox" value="Lain-lain" <?php echo isset($data->question107)?$data->question107 == 'kekuatan_otot'?'checked':'':''  ?>>
                        <span>Lain-lain :</span><br>
                        <input type="checkbox" value="Kekuatan otot" <?= (isset($data->kekuatan_otot)?in_array("kekuatan_otot", $data->kekuatan_otot)?'checked':'':'') ?>>
                        <span>Kekuatan Otot</span>
                        </span>
                        </p>
                       
                        <table  width="10%" style="margin-left:30px">
                            <tr style="border-bottom:1px solid black">
                                <td style="font-size:15pt;text-align:center;border-right:1px solid black;"><?= isset($data->tangan_kanan)?($data->tangan_kanan?$data->tangan_kanan :''):'' ?></td>
                                <td style="font-size:15pt;text-align:center;"><?= isset($data->tangan_kiri)?($data->tangan_kiri?$data->tangan_kiri :''):"" ?></td>
                            </tr>
                            <tr>
                                <td style="font-size:15pt;text-align:center;border-right:1px solid black;"><?= isset($data->kaki_kanan)?($data->kaki_kanan?$data->kaki_kanan :''):"" ?></td>
                                <td style="font-size:15pt;text-align:center;"><?= isset($data->kaki_krir)?($data->kaki_krir?$data->kaki_krir :''):"" ?></td>
                            </tr>
                        </table>
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

                        <span >BAB  :</span><br><br>
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
                        <span>Colosstomy ,jelaskan <?=' '.':'.(isset($data->question117)?$data->question117:'')?></span><br><br>
                        

                        <span >BAK  :</span><br><br>
                        <input type="checkbox" value="Normal" <?php echo isset($data->question118)?$data->question118 == 'normal'?'checked':'':''  ?>>
                        <span>Normal</span>
                        <input type="checkbox" value="Inkontinensia urin" <?php echo isset($data->question118)?$data->question118 == 'inkontinensia_urin'?'checked':'':''  ?>>
                        <span>Inkontinensia urin </span>
                        <input type="checkbox" value="hematuria" <?php echo isset($data->question118)?$data->question118 == 'heamturia'?'checked':'':''  ?>>
                        <span>Hematuria</span>
                        <input type="checkbox" value="Disuria" <?php echo isset($data->question118)?$data->question118 == 'disuria'?'checked':'':''  ?>>>
                        <span>Disuria</span>
                        <input type="checkbox" value="Urin menetes" <?php echo isset($data->question118)?$data->question118 == 'urin_menetas'?'checked':'':''  ?>>
                        <span>Urin menetes </span><br>
                        <input type="checkbox" value="Nocturia" <?php echo isset($data->question118)?$data->question118 == 'nocturial / sering kencing malam hari'?'checked':'':''  ?>>
                        <span>Nocturia/ sering kencing malam hari </span>
                        <input type="checkbox" value="Kateter" <?php echo isset($data->question118)?$data->question118 == 'keteter'?'checked':'':''  ?>>
                        <span>Kateter</span><br><br>

                        

                       
                    </p>
                </div>

               

            </div>
            <p style="text-align:right;font-size:12px">2</p>
        </div>



<!-- halaman 3 -->

        <div class="A4 sheet  padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                ASESMEN AWAL KEPERAWATAN  RAWAT INAP<br>
                (Dilengkapi 24 jam pasien masuk Ruang Rawat)
            </p>
            <div style="font-size:11px">
                <div>
                    <p style="margin-left:25px">
                    
                        <div style="display: flex;margin-left:25px">
                                <span >- Seksual dan Reproduksi  :</span><br><br>
                                <div style="flex-direction: column;">
                                    <span style="margin-left:15px">Wanita :</span><br>
                                    <span style="margin-left:15px">Normal</span>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question122)?$data->question122 != 'ya'?'checked':'':''  ?>>
                                    <span>Tidak</span>
                                    <input type="checkbox" value="Ya" <?php echo isset($data->question122)?$data->question122 == 'ya'?'checked':'':''  ?>>
                                    <span>Ya</span><br>  
                                    <span style="margin-left:15px">Tanggal Haid Terakhir:<?=' '.(isset($data->question123)?$data->question123:'')?></span>    
                                </div>
                            
                                <div style="margin-left: 40px;">
                                    <span>Laki-Laki  :<br>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question125)?$data->question125 == 'ya'?'checked':'':''  ?>>
                                    <label for="Tidak">Tidak</label>
                                    <input type="checkbox" value="Ya" <?php echo isset($data->question125)?$data->question125 != 'ya'?'checked':'':''  ?>>
                                    <label for="Ya">Ya</label></span><br>
                                    <span>Masalah Prostat:<?=' '.(isset($data->question126)?$data->question126:'')?></span>
                                </div>
                        </div>
                        <p>
                            <span style="margin-left:15px">
                                <span>Penggunaaan alat kontrasepsi :  </span>
                                <input type="checkbox" value="Tidak" <?php echo isset($data->question127)?$data->question127 != 'ya'?'checked':'':''  ?>>
                                <label for="Tidak">Tidak</label>
                                <input type="checkbox" value="Ya" <?php echo isset($data->question127)?$data->question127 == 'ya'?'checked':'':''  ?>>
                                <label for="Ya">Ya</label>
                                <span>Jenis : <?=' '.(isset($data->question128)?$data->question128:'')?></span>
                            </span>
                        </p>    
                    </p>
                </div>
                <p><b>2. ALASAN MASUK RUMAH SAKIT </b></p>
                <p style="margin-left:25px"><?=(isset($data->question129)?$data->question129:'')?></p>
                <span><b>3. RIWAYAT KESEHATAN</b></span><br>
                <div style="margin-left:25px">

                    <p>
                        <p>-	Pernah di rawat</p>
                        <input type="checkbox" value="Tidak" style="margin-left: 12px;" <?php echo isset($data->question131)?$data->question131 != 'ya_diagnosis'?'checked':'':''  ?>>
                        <span>Tidak</span>
                        <input type="checkbox" value="Ya" <?php echo isset($data->question131)?$data->question131 == 'ya_diagnosis'?'checked':'':''  ?>>
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
                    <input type="checkbox" value="Reaksi Alergi?" <?php echo isset($data->question136)?$data->question136 == 'reaksi_alergi'?'checked':'':''  ?>>
                    <span>Reaksi Alergi?</span>
                    <input type="checkbox" value="Tidak" <?php echo isset($data->question137)?$data->question137 != 'ya'?'checked':'':''  ?>>
                    <span>Tidak</span>
                    <input type="checkbox" value="Ya" <?php echo isset($data->question137)?$data->question137 == 'ya'?'checked':'':''  ?>>
                    <span>Ya</span>
                    <p style="margin-left: 12px;">Jika ya, jelaskan reaksi yang timbul :<?=(isset($data->question138)?$data->question138:'')?></p>
                    </span>
                    <p style="margin-left: 12px;">Golongan Darah : <?= isset($data_pasien[0]->goldarah)?$data_pasien[0]->goldarah:'' ?></p>

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
                    <span>lain-lain</span>
                    
                </div>

                <p><b>4. ASESMEN NYERI</b></p>
                <span style="margin-left: 20px;"><b>Petunjuk : Beri nilai sesuai kondisi pasien</b></span><br>

                <div style="display: flex;margin-left:25px">
                    <div style="flex-direction: column;">
                        <img src=" <?= base_url("assets/img/assesmentinap.jpeg"); ?>"  alt="img" height="150" width="250" style="padding-right:5px;"><br>    
                    </div>
                    <div style="margin-left: 70px;margin-top:30px">
                    <span style="margin-top: 30px;"><b>Keterangan :</b></span><br>
                        <span>
                            <span>0	:	Tidak nyeri</span><br>
                            <span>1-3	:	Nyeri ringan</span><br>
                            <span>4-7	:	Nyeri sedang</span><br>
                            <span >8-10	:	Nyeri berat</span>
                        </span>
                    </div>
                    
                </div>
               

                <div style="margin-left:25px">
                    <p>Range Nyeri : <?= isset($data->nyeri)?$data->nyeri:'' ?>
                        
                    </p>
                    <p>Nyeri</p>
                    <input type="checkbox" value="Ya" <?php echo isset($data->question143)?$data->question143 == 'ya_lokasi'?'checked':'':''  ?>>
                    <span>Ya</span>
                    <span>lokasi,<?=(isset($data->question144)?$data->question144:''),' '?>Lanjutkan pada formulir pengkajian nyeri komprehensif</span><br>
                    <input type="checkbox" value="Tidak" <?php echo isset($data->question143)?$data->question143 != 'ya_lokasi'?'checked':'':''  ?>>
                    <span>Tidak</span><br>

                    <p>
                        Nyeri mempengaruhi :<br><br>
                        <input type="checkbox" value="Tidur" <?= (isset($data->question145)?in_array("tidur", $data->question145)?'checked':'':'') ?>>
                        <span>Tidur</span>
                        <input type="checkbox" value="Aktivitas fisik" <?= (isset($data->question145)?in_array("akticitas_fisik", $data->question145)?'checked':'':'') ?>>
                        <span>Aktivitas fisik</span>
                        <input type="checkbox" value="Emosi" <?= (isset($data->question145)?in_array("emosi", $data->question145)?'checked':'':'') ?>>
                        <span>Emosi</span>
                        <input type="checkbox" value="Nafsu makan" <?= (isset($data->question145)?in_array("nafsu_makan", $data->question145)?'checked':'':'') ?>>
                        <span>Nafsu makan</span>
                        <input type="checkbox" value="Konsentrasi" <?= (isset($data->question145)?in_array("konsentrasi", $data->question145)?'checked':'':'') ?>>
                        <span>Konsentrasi</span>
                        <input type="checkbox" value="lain-lainnya" <?= (isset($data->question145)?in_array("lainnya", $data->question145)?'checked':'':'') ?>>
                        <span>lain-lainnya<?=(isset($data->question146)?$data->question146:'')?></span>
                    </p>

                    <p>
                        Nyeri hilang : <br><br>
                        <input type="checkbox" value="Minum obat" <?= (isset($data->question147)?in_array("minum_obat", $data->question147)?'checked':'':'') ?>>
                        <span>Minum obat</span>
                        <input type="checkbox" value="Istirahat" <?= (isset($data->question147)?in_array("istirahat", $data->question147)?'checked':'':'') ?>>
                        <span>Istirahat</span>
                        <input type="checkbox" value="Mendengarkan musik" <?= (isset($data->question147)?in_array("mendengarkan_musik", $data->question147)?'checked':'':'') ?>>
                        <span>Mendengarkan musik</span>
                        <input type="checkbox" value="Berubah posisi tidur" <?= (isset($data->question147)?in_array("berubah_posisi_tidur", $data->question147)?'checked':'':'') ?>>
                        <span>Berubah posisi tidur</span>
                        <input type="checkbox" value="lain-lainnya" <?= (isset($data->question147)?in_array("lainnya", $data->question147)?'checked':'':'') ?>>
                        <span>lain-lainnya <?=(isset($data->question148)?$data->question148:'')?> </span>
                    </p>
                </div>

               
   
            </div>
            <br><br><br>
            <p style="text-align:right;font-size:12px">3</p>
            </br></br></br>
        </div> 
        
<!-- halaman 4 -->

        <div class="A4 sheet  padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/header_print_ganjil') ?>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                ASESMEN AWAL KEPERAWATAN  RAWAT INAP<br>
                (Dilengkapi 24 jam pasien masuk Ruang Rawat)
            </p>
            <div style="font-size:11px">
                <span><b>5. PSIKOSOSIAL SPIRITUAL</b></span><br>

                    <div style="margin-left:25px">
                        <p><u>SOSIAL EKONOMI</u></p>
                        
                            <p>Pekerjaan</p>
                            <input type="checkbox" value="Wiraswasta" <?php echo isset($data->question150)?$data->question150 == 'Buruh'?'checked':'':''  ?>>
                            <span>Buruh</span>
                            <input type="checkbox" value="Swasta" <?php echo isset($data->question150)?$data->question150 == 'Dagang'?'checked':'':''  ?>>
                            <span>Dagang</span>
                            <input type="checkbox" value="PNS " <?php echo isset($data->question150)?$data->question150 == 'Ibu Rumah Tangga'?'checked':'':''  ?>>
                            <span>Ibu Rumah Tangga </span> 
                            <input type="checkbox" value="Pensiunan" <?php echo isset($data->question150)?$data->question150 == 'PNS/Pol/TNI'?'checked':'':''  ?>>
                            <span>PNS/Pol/TNI</span>
                            <input type="checkbox" value="Pensiunan" <?php echo isset($data->question150)?$data->question150 == 'Pelajar/Mahasiswa'?'checked':'':''  ?>>
                            <span>Pelajar/Mahasiswa</span>
                            <input type="checkbox" value="Pensiunan" <?php echo isset($data->question150)?$data->question150 == 'Karyawan Swasta'?'checked':'':''  ?>>
                            <span>Karyawan Swasta</span><br>
                            <input type="checkbox" value="lain-lainnya" <?php echo isset($data->question150)?$data->question150 == 'Lainnya'?'checked':'':''  ?>>
                            <span>lain-lainnya :<?=(isset($data->question151)?$data->question151:'')?></span>
                    
                        
                            <p>Warganegara</p>
                            <input type="checkbox" value="WNI" <?php echo isset($data->question152)?$data->question152 == 'wni'?'checked':'':''  ?>>
                            <span>WNI</span>
                            <input type="checkbox" value="WNA" <?php echo isset($data->question152)?$data->question152 != 'wni'?'checked':'':''  ?>>
                            <span>WNA</span>
                        

                            <p>Tinggal bersama</p>
                            <input type="checkbox" value="suami/istri" <?php echo isset($data->question153)?$data->question153 == 'suami_istri'?'checked':'':''  ?>>
                            <span>suami/istri</span>
                            <input type="checkbox" value="orangtua" <?php echo isset($data->question153)?$data->question153 == 'orang_tua'?'checked':'':''  ?>>
                            <span>orangtua</span>
                            <input type="checkbox" value="Anak" <?php echo isset($data->question153)?$data->question153 == 'anak'?'checked':'':''  ?>>
                            <span>Anak</span>
                            <input type="checkbox" value="Teman" <?php echo isset($data->question153)?$data->question153 == 'teman'?'checked':'':''  ?>>
                            <span>Teman</span>
                            <input type="checkbox" value="Sendiri" <?php echo isset($data->question153)?$data->question153 == 'sendiri'?'checked':'':''  ?>>
                            <span>Sendiri</span>
                            <input type="checkbox" value="lain-lainnya" <?php echo isset($data->question153)?$data->question153 == 'lainnya'?'checked':'':''  ?>>
                            <span>lain-lainnya :<?=(isset($data->question154)?$data->question154:'')?></span>
                        
                    </div>

                    <div style="margin-left:25px">
                        <p>Kondisi lingkungan rumah<p>
                        <input type="checkbox" value="1 lantai" <?php echo isset($data->question155)?$data->question155 == '1_lantai'?'checked':'':''  ?>>
                        <span>1 lantai</span>
                        <input type="checkbox" value="2 lantai" <?php echo isset($data->question155)?$data->question155 == '2_lantai'?'checked':'':''  ?>>
                        <span>2 lantai</span>
                        <input type="checkbox" value="Kamar mandi" <?php echo isset($data->question155)?$data->question155 == 'kamar_mandi'?'checked':'':''?>>
                        <span>Kamar mandi di lantai 1 :</span>
                        <input type="checkbox" value="Ya"  <?php echo isset($data->question156)?$data->question156 == 'ya'?'checked':'':''?>>
                        <span>Ya</span>
                        <input type="checkbox" value="Tidak" <?php  echo isset($data->question156)?$data->question156 != 'ya'?'checked':'':''?>>
                        <span>Tidak</span><br>

                        <p>
                            Masuk ke rumah ada tangga :
                            <input type="checkbox" value="Ya" <?php echo isset($data->question157)?$data->question157 == 'ya'?'checked':'':''  ?>>
                            <label for="Ya">Ya</label>
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question157)?$data->question157 != 'ya'?'checked':'':''  ?>>
                            <label for="Tidak">Tidak</label>
                        </p>

                        <p>Orang yang membantu perawatan selama di rumah : <p>
                        <input type="checkbox" value="Anak" <?php echo isset($data->orang_yg_membantu_perawatan)?$data->orang_yg_membantu_perawatan == 'anak'?'checked':'':''  ?>>
                        <span>Anak</span>
                        <input type="checkbox" value="Suami" <?php echo isset($data->orang_yg_membantu_perawatan)?$data->orang_yg_membantu_perawatan == 'suami'?'checked':'':''  ?>>
                        <span>Suami</span>
                        <input type="checkbox" value="Istri" <?php echo isset($data->orang_yg_membantu_perawatan)?$data->orang_yg_membantu_perawatan == 'istri'?'checked':'':''?>>
                        <span>Istri</span>
                        <input type="checkbox" value="saudara"  <?php echo isset($data->orang_yg_membantu_perawatan)?$data->orang_yg_membantu_perawatan == 'ssaudara'?'checked':'':''?>>
                        <span>saudara</span>
                        
                       
                        
                         <p>   Bantuan yang di butuhkan setelah di rumah : <p>
                            <input type="checkbox" value="Mandi" <?php echo isset($data->question159)?(in_array("mandi", $data->question159) ? "checked" : "disabled"):""; ?>>
                            <span>Mandi</span>
                            <input type="checkbox" value="bab_bak" <?php echo isset($data->question159)?(in_array("bab_bak", $data->question159) ? "checked" : "disabled"):""; ?>>
                            <span>BAB/BAK</span>
                            <input type="checkbox" value="Makan" <?php echo isset($data->question159)?(in_array("makan", $data->question159) ? "checked" : "disabled"):""; ?>>
                            <span>Makan</span>
                            <input type="checkbox" value="Berjalan/ambulasi" <?php echo isset($data->question159)?(in_array("berjalan_ambulasi", $data->question159) ? "checked" : "disabled"):""; ?>>
                            <span>Berjalan/ambulasi</span>
                            <input type="checkbox" value="Perawatan luka" <?php echo isset($data->question159)?(in_array("perawatan_luka", $data->question159) ? "checked" : "disabled"):""; ?>>
                            <span>Perawatan luka  </span>
                            <input type="checkbox" value="Pemberian obat" <?php echo isset($data->question159)?(in_array("pemberian_obat", $data->question159) ? "checked" : "disabled"):""; ?>>
                            <span>Pemberian obat</span>

                        <p><u>SPIRITUAL</u></p>
                        <p>Agama :
                            <input type="checkbox" value="Islam" <?php echo isset($data_pasien[0]->agama)?$data_pasien[0]->agama == 'ISLAM'?'checked':'':''  ?>>
                            <span>Islam</span>
                            <input type="checkbox" value="Kristen" <?php echo isset($data_pasien[0]->agama)?$data_pasien[0]->agama == 'KRISTEN'?'checked':'':''  ?>>
                            <span>Kristen</span>
                            <input type="checkbox" value="Katolik" <?php echo isset($data_pasien[0]->agama)?$data_pasien[0]->agama == 'KATHOLIK'?'checked':'':''  ?>>
                            <span>Katolik </span>
                            <input type="checkbox" value="Hindu" <?php echo isset($data_pasien[0]->agama)?$data_pasien[0]->agama == 'HINDU'?'checked':'':''  ?>>
                            <span>Hindu</span>
                            <input type="checkbox" value="Budha" <?php echo isset($data_pasien[0]->agama)?$data_pasien[0]->agama == 'BUDHA'?'checked':'':''  ?>>
                            <span>Budha</span>
                        </p>
                       
                        <p>	Identifikasi Nilai : </p>
                        <p>
                            <ol>
                                <li><?=(isset($data->question378->text1)?$data->question378->text1:'')?></li><br>
                                <li><?=(isset($data->question378->text2)?$data->question378->text2:'')?></li><br>
                                <li><?=(isset($data->question378->text3)?$data->question378->text3:'')?></li>
                            </ol>
                        </p>

                        <p>Kegiatan spriritual yang di butuhkan selama perawatan :<?=(isset($data->question379)?$data->question379:'')?></p>

                        <p><u>PSIKOLOGIS</u></p>
                        <input type="checkbox" value="Cemas" <?php echo isset($data->question380)?$data->question380 == 'cemas'?'checked':'':''  ?>>
                        <span>Cemas</span>
                        <input type="checkbox" value="Marah" <?php echo isset($data->question380)?$data->question380 == 'marah'?'checked':'':''  ?>>
                        <span>Marah</span>
                        <input type="checkbox" value="Sedih" <?php echo isset($data->question380)?$data->question380 == 'sedih'?'checked':'':''  ?>>
                        <span>Sedih</span>
                        <input type="checkbox" value="Kecendrungan bunuh diri" <?php echo isset($data->question380)?$data->question380 == 'kecenderungan bunuh diri'?'checked':'':''  ?>>
                        <span>Kecendrungan bunuh diri</span>
                        <input type="checkbox" value="Tegang" <?php echo isset($data->question380)?$data->question380 == 'tegang'?'checked':'':''  ?>>
                        <span>Tegang</span><br>
                        <input type="checkbox" value="Takut terhadap therapy" <?php echo isset($data->question380)?$data->question380 == 'takut'?'checked':'':''  ?>>
                        <span>Takut terhadap therapy/pembedahan/lingkungan RS </span>
                        <input type="checkbox" value="Lain-lainnya" <?php echo isset($data->question380)?$data->question380 == 'lainnya'?'checked':'':''  ?>>
                        <span>Lain-lainnya : <?=(isset($data->question381)?$data->question381:'')?></span>
                        
                        


                    </div>

                    <p><b>6. RIWAYAT ALERGI</b></p>

                    <div style="margin-left:25px">
                        <p>Riwayat  Alergi :
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question383)?$data->question383 == 'tidak'?'checked':'':''  ?>>
                        <span>Tidak</span>
                        <input type="checkbox" value="Ya:" <?php echo isset($data->question383)?$data->question383 == 'ya'?'checked':'':''  ?>>
                        <span>Ya</span>
                        <input type="checkbox" value="Pasang gelang warna merah" <?php echo isset($data->question3)?$data->question3 == 'pasang_gelang_warna_merah '?'checked':'':''  ?>>
                        <span>Pasang gelang warna merah</span>
                        </p>

                        <p>
                            a.	Alergi Obat :
                            <input type="checkbox" value="Tidak" <?php echo isset($data->question384)?$data->question384 == 'tidak'?'checked':'':''  ?>>
                            <span>Tidak</span>
                            <input type="checkbox" value="Ya:" <?php echo isset($data->question384)?$data->question384 == 'ya'?'checked':'':''  ?>>
                            <span>Ya, jenis/nama obat : <?=(isset($data->question385)?$data->question385:'')?></span><br>
                            <p style="margin-left:20px">Reaksi utama yang timbul :<?=(isset($data->question386)?$data->question386:'')?>
                                <input type="checkbox" value="merah" <?php echo isset($data->question5)?$data->question5 == 'merah'?'checked':'':''  ?>>
                                <span>Merah Merah</span>
                                <input type="checkbox" value="gatal" <?php echo isset($data->question5)?$data->question5 == 'gatal'?'checked':'':''  ?>>
                                <span>Gatal Gatal</span>
                                <input type="checkbox" value="bengkak" <?php echo isset($data->question5)?$data->question5 == 'bengkak'?'checked':'':''  ?>>
                                <span>Bengkak</span>
                            </p>
                            
                        </p>

                        <p>
                            b.	Lain-lain :
                            <input type="checkbox" value="Astma" <?php echo isset($data->question387)?(in_array("astma", $data->question387) ? "checked" : "disabled"):""; ?>>
                            <span>Astma</span> 
                            <input type="checkbox" value="Eksim kulit" <?php echo isset($data->question387)?(in_array("eksim_kulit ", $data->question387) ? "checked" : "disabled"):""; ?>>
                            <span>Eksim kulit</span>
                            <input type="checkbox" value="sabun" <?php echo isset($data->question387)?(in_array("sabun", $data->question387) ? "checked" : "disabled"):""; ?>>
                            <span>Debu</span>
                            <input type="checkbox" value="Debu" <?php echo isset($data->question387)?(in_array("debu", $data->question387) ? "checked" : "disabled"):""; ?>>
                            <span>Debu</span>
                            <input type="checkbox" value="Udara" <?php echo isset($data->question387)?(in_array("udara", $data->question387) ? "checked" : "disabled"):""; ?>>
                            <span>Udara</span> 
                            <input type="checkbox" value="Makanan" <?php echo isset($data->question387)?(in_array("makanan", $data->question387) ? "checked" : "disabled"):""; ?>>
                            <span>Makanan :<?=(isset($data->question388)?$data->question388:'')?></span><br>
                            <p style="margin-left:20px">Reaksi utama yang timbul :<?=(isset($data->question389)?$data->question389:'')?></p>
                        </p>
                    </div>

                   

            </div>
            <br><br><br><br>
            <p style="text-align:right;font-size:12px">4</p>
            </br></br></br></br>
        </div>

<!-- halaman 5 -->

        <div class="A4 sheet  padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                ASESMEN AWAL KEPERAWATAN  RAWAT INAP<br>
                (Dilengkapi 24 jam pasien masuk Ruang Rawat)
            </p>

            <div style="font-size:11px">

                <p><b>7. ASESMEN FUNGSIONAL</b></p>

                <div style="margin-left:25px">
                    <span>Asesmen Fungsional ( Barthel Indeks) </span><br>
                    <span>Beri nilai pada hasil pemeriksaan dan jumlahkan</span>

                    <table id="data" border="1">
                        <tr>
                            <th rowspan="2" style="width: 5%;">No</th>
                            <th  rowspan="2" style="width: 25%;">Fungsi</th>
                            <th  rowspan="2" style="width: 10%;">Skor</th>
                            <th  rowspan="2" style="width: 40%;">Uraian</th>
                            <th colspan="2" style="width: 20%;">Nilai Skor</th>
                        </tr>

                        <tr>
                            <th>Saat Masuk RS</th>
                            <th>Saat Keluar RS</th>
                        </tr>
                        <tr>
                            <td rowspan="3" style="width: 10%;text-align: center;font-size:11px">1</td>
                            <td rowspan="3" style="width: 25%;font-size:11px">Mengendalikan ransang defekasi (BAB)</td>
                            <td style="width: 10%;text-align: center;font-size:11px">0</td>
                            <td style="width: 35%;font-size:11px">Tak terkendali/ tak teratur (perlu pencahar)</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'1'})?$data->assesment_fungsional->masuk_rs->{'1'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'1'})?$data->assesment_fungsional->masuk_rs->{'1'} == "0"?"√":"":"" ?></td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'1'})?$data->assesment_fungsional->keluar_rs->{'1'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'1'})?$data->assesment_fungsional->keluar_rs->{'1'} == "0"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;font-size:11px">1</td>
                            <td style="width: 35%;font-size:11px">Kadang-kadang tak terkendali</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'1'})?$data->assesment_fungsional->masuk_rs->{'1'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'1'})?$data->assesment_fungsional->masuk_rs->{'1'} == "1"?"√":"":"" ?></td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'1'})?$data->assesment_fungsional->keluar_rs->{'1'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'1'})?$data->assesment_fungsional->keluar_rs->{'1'} == "1"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;font-size:11px">2</td>
                            <td style="width: 35%;font-size:11px">Mandiri</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'1'})?$data->assesment_fungsional->masuk_rs->{'1'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'1'})?$data->assesment_fungsional->masuk_rs->{'1'} == "2"?"√":"":"" ?></td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'1'})?$data->assesment_fungsional->keluar_rs->{'1'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'1'})?$data->assesment_fungsional->keluar_rs->{'1'} == "2"?"√":"":"" ?></td>
                        </tr>

                        <tr>
                            <td rowspan="3" style="width: 10%;text-align: center;font-size:11px">2</td>
                            <td rowspan="3" style="width: 25%;font-size:11px">Mengendalikan ransang berkemih (BAK)</td>
                            <td style="width: 10%;text-align:center;font-size:11px">0</td>
                            <td style="width: 35%;font-size:11px">Tak terkendali / pakai kateter</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'2'})?$data->assesment_fungsional->masuk_rs->{'2'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'2'})?$data->assesment_fungsional->masuk_rs->{'2'} == "0"?"√":"":"" ?></td>                               
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'2'})?$data->assesment_fungsional->keluar_rs->{'2'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'2'})?$data->assesment_fungsional->keluar_rs->{'2'} == "0"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;font-size:11px">1</td>
                            <td style="width: 35%;font-size:11px">Kadang-kadang tak terkendali (1x24 jam)</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'2'})?$data->assesment_fungsional->masuk_rs->{'2'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'2'})?$data->assesment_fungsional->masuk_rs->{'2'} == "1"?"√":"":"" ?></td>                               
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'2'})?$data->assesment_fungsional->keluar_rs->{'2'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'2'})?$data->assesment_fungsional->keluar_rs->{'2'} == "1"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;font-size:11px">2</td>
                            <td style="width: 35%;font-size:11px">Mandiri</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'2'})?$data->assesment_fungsional->masuk_rs->{'2'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'2'})?$data->assesment_fungsional->masuk_rs->{'2'} == "2"?"√":"":"" ?></td>                               
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'2'})?$data->assesment_fungsional->keluar_rs->{'2'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'2'})?$data->assesment_fungsional->keluar_rs->{'2'} == "2"?"√":"":"" ?></td>
                        </tr>

                        <tr>
                            <td rowspan="2" style="width: 10%;text-align: center;font-size:11px">3</td>
                            <td rowspan="2" style="width: 25%;font-size:11px">Membersihkan diri (cuci muka, sisi rambut, sikat gigi)</td>
                            <td style="width: 10%;text-align: center;font-size:11px">0</td>
                            <td style="width: 35%;font-size:11px">Butuh pertolongan orang lain</td>
                            <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->masuk_rs->{'3'})?$data->assesment_fungsional->masuk_rs->{'3'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'3'})?$data->assesment_fungsional->masuk_rs->{'3'} == "0"?"√":"":"" ?></td>                               
                            <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->keluar_rs->{'3'})?$data->assesment_fungsional->keluar_rs->{'3'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'3'})?$data->assesment_fungsional->keluar_rs->{'3'} == "0"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;font-size:11px">1</td>
                            <td style="width: 35%;font-size:11px">Perlu pertolongan pada beberapa kegiatan, tetapi dapatmengerjakan sendiri kegiatan yang lain</td>
                            <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->masuk_rs->{'3'})?$data->assesment_fungsional->masuk_rs->{'3'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'3'})?$data->assesment_fungsional->masuk_rs->{'3'} == "1"?"√":"":"" ?></td>                               
                            <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->keluar_rs->{'3'})?$data->assesment_fungsional->keluar_rs->{'3'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'3'})?$data->assesment_fungsional->keluar_rs->{'3'} == "1"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td rowspan="3" style="width: 10%;text-align: center;font-size:11px">4</td>
                            <td rowspan="3" style="width: 25%;font-size:11px">Penggunaan jamban, masuk dan keluar (melepaskan, memakai celana, membersihkan, menyiram)	0	Tergantung pertolongan orang lain</td>
                            <td style="width: 10%;text-align: center;font-size:11px">0</td>
                            <td style="width: 35%;font-size:11px">Tergantung pertolongan orang lain</td>
                            <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->masuk_rs->{'4'})?$data->assesment_fungsional->masuk_rs->{'4'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'4'})?$data->assesment_fungsional->masuk_rs->{'4'} == "0"?"√":"":"" ?></td>                               
                            <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->keluar_rs->{'4'})?$data->assesment_fungsional->keluar_rs->{'4'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'4'})?$data->assesment_fungsional->keluar_rs->{'4'} == "0"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;font-size:11px">1</td>
                            <td style="width: 35%;font-size:11px">Perlu pertolongan pada beberapa kegiatan, tetapi dapat mengerjakan sendiri kegiatan yang lain</td>
                            <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->masuk_rs->{'4'})?$data->assesment_fungsional->masuk_rs->{'4'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'4'})?$data->assesment_fungsional->masuk_rs->{'4'} == "1"?"√":"":"" ?></td>                               
                            <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->keluar_rs->{'4'})?$data->assesment_fungsional->keluar_rs->{'4'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'4'})?$data->assesment_fungsional->keluar_rs->{'4'} == "1"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;font-size:11px">2</td>
                            <td style="width: 35%;font-size:11px">Mandiri</td>
                            <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->masuk_rs->{'4'})?$data->assesment_fungsional->masuk_rs->{'4'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'4'})?$data->assesment_fungsional->masuk_rs->{'4'} == "2"?"√":"":"" ?></td>                               
                            <td style="text-align: center;"class="<?= isset($data->assesment_fungsional->masuk_rs->{'4'})?$data->assesment_fungsional->masuk_rs->{'4'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'4'})?$data->assesment_fungsional->masuk_rs->{'4'} == "2"?"√":"":"" ?></td>
                        </tr>
                    </table>
                </div>

                <div style="margin-left:25px;">
                    <table id="data" border="1">
                        <tr>
                            <th rowspan="2" style="width: 5%;">No</th>
                            <th  rowspan="2" style="width: 25%;">Fungsi</th>
                            <th  rowspan="2" style="width: 10%;">Skor</th>
                            <th  rowspan="2" style="width: 40%;">Uraian</th>
                            <th colspan="2" style="width: 20%;">Nilai Skor</th>
                        </tr>
                        <tr>
                            <th>Saat Masuk RS</th>
                            <th>Saat Keluar RS</th>
                        </tr>

                        <tr>
                            <td rowspan="3" style="width: 10%;text-align: center;">5</td>
                            <td rowspan="3" style="width: 25%;">Makan</td>
                            <td style="width: 10%;text-align: center;">0</td>
                            <td style="width: 35%;">Tidak mampu</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'5'})?$data->assesment_fungsional->masuk_rs->{'5'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'5'})?$data->assesment_fungsional->masuk_rs->{'5'} == "0"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'5'})?$data->assesment_fungsional->keluar_rs->{'5'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'5'})?$data->assesment_fungsional->keluar_rs->{'5'} == "0"?"√":"":"" ?></td>
                        </tr>                        
                        <tr>
                            <td style="width: 10%;text-align: center;">1</td>
                            <td style="width: 35%;">Perlu pertolongan memotong makanan</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'5'})?$data->assesment_fungsional->masuk_rs->{'5'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'5'})?$data->assesment_fungsional->masuk_rs->{'5'} == "1"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'5'})?$data->assesment_fungsional->keluar_rs->{'5'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'5'})?$data->assesment_fungsional->keluar_rs->{'5'} == "1"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;">2</td>
                            <td style="width: 35%;">Mandiri</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'5'})?$data->assesment_fungsional->masuk_rs->{'5'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'5'})?$data->assesment_fungsional->masuk_rs->{'5'} == "2"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'5'})?$data->assesment_fungsional->keluar_rs->{'5'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'5'})?$data->assesment_fungsional->keluar_rs->{'5'} == "2"?"√":"":"" ?></td>
                        </tr>

                        <tr>
                            <td rowspan="3" style="width: 10%;text-align: center;">6</td>
                            <td rowspan="3" style="width: 25%;">Berubah sikap dari berbaring ke duduk</td>
                            <td style="width: 10%;text-align: center;">0</td>
                            <td style="width: 35%;">Tidak mampu</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'6'})?$data->assesment_fungsional->masuk_rs->{'6'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'6'})?$data->assesment_fungsional->masuk_rs->{'6'} == "0"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'6'})?$data->assesment_fungsional->keluar_rs->{'6'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'6'})?$data->assesment_fungsional->keluar_rs->{'6'} == "0"?"√":"":"" ?></td>
                        </tr>
                         <tr>
                            <td style="width: 10%;text-align: center;">1</td>
                            <td style="width: 35%;">Perlu pertolongan memotong makanan</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'6'})?$data->assesment_fungsional->masuk_rs->{'6'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'6'})?$data->assesment_fungsional->masuk_rs->{'6'} == "1"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'6'})?$data->assesment_fungsional->keluar_rs->{'6'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'6'})?$data->assesment_fungsional->keluar_rs->{'6'} == "1"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;">2</td>
                            <td style="width: 35%;">Mandiri</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'6'})?$data->assesment_fungsional->masuk_rs->{'6'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'6'})?$data->assesment_fungsional->masuk_rs->{'6'} == "2"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'6'})?$data->assesment_fungsional->keluar_rs->{'6'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'6'})?$data->assesment_fungsional->keluar_rs->{'6'} == "2"?"√":"":"" ?></td>
                        </tr>

                        <tr>
                            <td rowspan="4" style="width: 10%;text-align: center;">7</td>
                            <td rowspan="4" style="width: 25%;">Berpindah/berjalan </td>
                            <td style="width: 10%;text-align: center;">0</td>
                            <td style="width: 35%;">Tidak mampu</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'7'})?$data->assesment_fungsional->masuk_rs->{'7'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'7'})?$data->assesment_fungsional->masuk_rs->{'7'} == "0"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'7'})?$data->assesment_fungsional->keluar_rs->{'7'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'7'})?$data->assesment_fungsional->keluar_rs->{'7'} == "0"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;">1</td>
                            <td style="width: 35%;">Bisa  (pindah) dengan kursi roda</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'7'})?$data->assesment_fungsional->masuk_rs->{'7'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'7'})?$data->assesment_fungsional->masuk_rs->{'7'} == "1"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'7'})?$data->assesment_fungsional->keluar_rs->{'7'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'7'})?$data->assesment_fungsional->keluar_rs->{'7'} == "1"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;">2</td>
                            <td style="width: 35%;">Berjalan dengan bantuan 1 orang		</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'7'})?$data->assesment_fungsional->masuk_rs->{'7'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'7'})?$data->assesment_fungsional->masuk_rs->{'7'} == "2"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'7'})?$data->assesment_fungsional->keluar_rs->{'7'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'7'})?$data->assesment_fungsional->keluar_rs->{'7'} == "2"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;">3</td>
                            <td style="width: 35%;">Mandiri</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'7'})?$data->assesment_fungsional->masuk_rs->{'7'} == "3"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'7'})?$data->assesment_fungsional->masuk_rs->{'7'} == "3"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'7'})?$data->assesment_fungsional->keluar_rs->{'7'} == "3"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'7'})?$data->assesment_fungsional->keluar_rs->{'7'} == "3"?"√":"":"" ?></td>
                        </tr>
                        
                        <tr>
                            <td rowspan="3" style="width: 10%;text-align: center;">8</td>
                            <td rowspan="3" style="width: 25%;">Memakai baju</td>
                            <td style="width: 10%;text-align: center;">0</td>
                            <td style="width: 35%;">Tergantung pada orang lain</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'8'})?$data->assesment_fungsional->masuk_rs->{'8'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'8'})?$data->assesment_fungsional->masuk_rs->{'8'} == "0"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'8'})?$data->assesment_fungsional->keluar_rs->{'8'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'8'})?$data->assesment_fungsional->keluar_rs->{'8'} == "0"?"√":"":"" ?></td>
                        </tr>

                        <tr>
    
                            <td style="width: 10%;text-align: center;">1</td>
                            <td style="width: 35%;">Sebagian dibantu (misalnya mengancing baju)</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'8'})?$data->assesment_fungsional->masuk_rs->{'8'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'8'})?$data->assesment_fungsional->masuk_rs->{'8'} == "1"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'8'})?$data->assesment_fungsional->keluar_rs->{'8'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'8'})?$data->assesment_fungsional->keluar_rs->{'8'} == "1"?"√":"":"" ?></td>
                        </tr>

                        <tr>
    
                            <td style="width: 10%;text-align: center;">2</td>
                            <td style="width: 35%;">mandiri</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'8'})?$data->assesment_fungsional->masuk_rs->{'8'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'8'})?$data->assesment_fungsional->masuk_rs->{'8'} == "2"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'8'})?$data->assesment_fungsional->keluar_rs->{'8'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'8'})?$data->assesment_fungsional->keluar_rs->{'8'} == "2"?"√":"":"" ?></td>
                        </tr>

                        <tr>
                            <td rowspan="3" style="width: 10%;text-align: center;">9</td>
                            <td rowspan="3" style="width: 25%;">Naik turun tangga</td>
                            <td style="width: 10%;text-align: center;">0</td>
                            <td style="width: 35%;">Tidak mampu</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'9'})?$data->assesment_fungsional->masuk_rs->{'9'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'9'})?$data->assesment_fungsional->masuk_rs->{'9'} == "0"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'9'})?$data->assesment_fungsional->keluar_rs->{'9'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'9'})?$data->assesment_fungsional->keluar_rs->{'9'} == "0"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;">1</td>
                            <td style="width: 35%;">Perlu pertolongan </td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'9'})?$data->assesment_fungsional->masuk_rs->{'9'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'9'})?$data->assesment_fungsional->masuk_rs->{'9'} == "1"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'9'})?$data->assesment_fungsional->keluar_rs->{'9'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'9'})?$data->assesment_fungsional->keluar_rs->{'9'} == "1"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;">2</td>
                            <td style="width: 35%;">Mandiri</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'9'})?$data->assesment_fungsional->masuk_rs->{'9'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'9'})?$data->assesment_fungsional->masuk_rs->{'9'} == "2"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'9'})?$data->assesment_fungsional->keluar_rs->{'9'} == "2"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'9'})?$data->assesment_fungsional->keluar_rs->{'9'} == "2"?"√":"":"" ?></td>
                        </tr>

                        <tr>
                            <td rowspan="2" style="width: 10%;text-align: center;">10</td>
                            <td rowspan="2" style="width: 25%;">Mandi</td>
                            <td style="width: 10%;text-align: center;">0</td>
                            <td style="width: 35%;">Tergantung orang lain</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->masuk_rs->{'10'})?$data->assesment_fungsional->masuk_rs->{'10'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->masuk_rs->{'10'})?$data->assesment_fungsional->masuk_rs->{'10'} == "0"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'10'})?$data->assesment_fungsional->keluar_rs->{'10'} == "0"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'10'})?$data->assesment_fungsional->keluar_rs->{'10'} == "0"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td style="width: 10%;text-align: center;">1</td>
                            <td style="width: 35%;">Mandiri</td>
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'10'})?$data->assesment_fungsional->keluar_rs->{'10'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'10'})?$data->assesment_fungsional->keluar_rs->{'10'} == "1"?"√":"":"" ?></td>                           
                            <td style="text-align: center;" class="<?= isset($data->assesment_fungsional->keluar_rs->{'10'})?$data->assesment_fungsional->keluar_rs->{'10'} == "1"?"bg-checked":"":"" ?> "><?= isset($data->assesment_fungsional->keluar_rs->{'10'})?$data->assesment_fungsional->keluar_rs->{'10'} == "1"?"√":"":"" ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" style=""><b>Total Skor</b></td>
                            <td><?=(isset($data->assesment_fungsional->masuk_rs->total_skor)?$data->assesment_fungsional->masuk_rs->total_skor:'')?></td>
                            <td><?=(isset($data->assesment_fungsional->keluar_rs->total_skor)?$data->assesment_fungsional->keluar_rs->total_skor:'')?></td>
                        </tr>
                    </table>
                    <span>Keterangan :</span><br>
                    <span style="margin-left: 30px;">20	:	Mandiri</span><br>
                    <span style="margin-left: 30px;">12-19	:	Ketergantungan ringan</span><br>
                    <span style="margin-left: 30px;">9 - 11	:	Ketergantungan sedang</span><br>
                    <span style="margin-left: 30px;">5 - 8	:	Ketergantungan berat</span><br>
                    <span style="margin-left: 30px;">0 - 4	:	Ketergantungan total</span>
                </div>

                <div style="margin-left:25px">
                    <p>Kemampuan melakukan aktivitas sehari-hari </p>
                    <span>
                        <input type="checkbox" value="Mandiri" <?php echo isset($data->question612)?$data->question612 == 'mandiri' ? 'checked':'':'' ?>>
                        <span>Mandiri</span>
                        <input type="checkbox" value="Ketergantungan Ringan" <?php echo isset($data->question612)?$data->question612 == 'ketergantungan_ringan'?'checked':'':''  ?>>
                        <span>Ketergantungan Rringan</span>
                        <input type="checkbox" value="Ketergantungan Sedang" <?php echo isset($data->question612)?$data->question612 == 'ketergantungan_sedang'?'checked':'':''  ?>>
                        <span>Ketergantungan Sedang  </span><br>
                        <input type="checkbox" value="Ketergantungan Berat" <?php echo isset($data->question612)?$data->question612 == 'ketergantungan_berat'?'checked':'':''  ?>>
                        <span>Ketergantungan Berat  </span>
                        <input type="checkbox" value="Ketergantungan Total" <?php echo isset($data->question612)?$data->question612 == 'ketergantungan total'?'checked':'':''  ?>>
                        <span>Ketergantungan Total</span>
                    </span><br>

                    
                </div>

            </div>
            <p style="text-align:right;font-size:12px">5</p>
        </div>

<!-- halaman 6 -->

       
        <div class="A4 sheet  padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/header_print_ganjil') ?>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                ASESMEN AWAL KEPERAWATAN  RAWAT INAP<br>
                (Dilengkapi 24 jam pasien masuk Ruang Rawat)
            </p>

            <div style="font-size:11px">

                <div style="margin-left:25px">

                    <p>Berjalan : </p>
                        <input type="checkbox" value="Tidak ada kesulitan" <?php echo isset($data->question613)? $data->question613 == 'tidak_ada_kesulitan' ? 'checked':'':'' ?>>
                        <span>Tidak ada kesulitan</span>
                        <input type="checkbox" value="Penururnan kekuatan otot (ROM)" <?php echo isset($data->question613)? $data->question613 == 'penurunan_kekuatan' ? 'checked':'':'' ?>>
                        <span>Penururnan kekuatan otot (ROM)</span>
                        <input type="checkbox" value="Paralysis" <?php echo isset($data->question613)? $data->question613 == 'paralysis' ? 'checked':'':'' ?>>
                        <span>Paralysis</span>
                        <input type="checkbox" value="Lain-lain" <?php echo isset($data->question613)? $data->question613 == 'lain_lain' ? 'checked':'':'' ?>>
                        <span> Lain-lain : <?=(isset($data->question614)?$data->question614:'')?></span>
                    
                    <p>Alat Ambulatory :</p>
                        <input type="checkbox" value="Walker" <?php echo isset($data->question615)?$data->question615 == 'walker'?'checked':'':''  ?>>
                        <span>Walker</span>
                        <input type="checkbox" value="Tongkat" <?php echo isset($data->question615)?$data->question615 == 'tongkat'?'checked':'':''  ?>>
                        <span>Tongkat</span>
                        <input type="checkbox" value="Kursi roda" <?php echo isset($data->question615)?$data->question615 == 'kursi_roda'?'checked':'':''  ?>>
                        <span>Kursi roda</span>
                        <input type="checkbox" value="Lain-lain" <?php echo isset($data->question615)?$data->question615 == 'lainnya'?'checked':'':''  ?>>
                        <span> Lain-lain : <?php echo isset($data->question616)?$data->question616:''?></span>

                    <p>Kebutuhan terhadap bantuan :</p>   
                        <input type="checkbox" value="Mandiri" <?php echo isset($data->question617)?$data->question617 == 'mandiri'?'checked':'':''  ?>>
                        <span>Mandiri</span>
                        <input type="checkbox" value=" Bantu sebagian" <?php echo isset($data->question617)?$data->question617 == 'bantu_sebagian'?'checked':'':''  ?>>
                        <span> Bantu sebagian</span>
                        <input type="checkbox" value="Bantu total" <?php echo isset($data->question617)?$data->question617 == 'Babtu_total'?'checked':'':''  ?>>
                        <span>Bantu total</span>

                    <p>Ekstremitas  atas/ bawah :</p> 
                        <input type="checkbox" value="Tidak ada kesulitan" <?php echo isset($data->question618)?$data->question618 == 'tidak_ada_kesulitan'?'checked':'':''  ?>>
                        <span>Tidak ada kesulitan</span>
                        <input type="checkbox" value="Lemah" <?php echo isset($data->question618)?$data->question618 == 'lemah'?'checked':'':''  ?>>
                        <span> Lemah</span>
                        <input type="checkbox" value="Paralysis" <?php echo isset($data->question618)?$data->question618 == 'paralysis'?'checked':'':''  ?>>
                        <span>Paralysis</span>
                        <input type="checkbox" value="Deformitas" <?php echo isset($data->question618)?$data->question618 == 'deformitas'?'checked':'':''  ?>>
                        <span>Deformitas</span>
                        <input type="checkbox" value="Lain-lain" <?php echo isset($data->question618)?$data->question618 == 'lainnya'?'checked':'':''  ?>>
                        <span> Lain-lain :<?php echo isset($data->question619)?$data->question619:''?> </span>

                    <p>Pola istirahat sehari-hari : </p>
                        <input type="checkbox" value="Normal" <?php echo isset($data->question620)?$data->question620 == 'normal'?'checked':'':''  ?>>
                        <span>Normal</span>
                        <input type="checkbox" value="Sulit memulai tidur" <?php echo isset($data->question620)?$data->question620 == 'sulit_memulai_tidur'?'checked':'':''  ?>>
                        <span>Sulit memulai tidur</span>
                        <input type="checkbox" value="Sering terbangun akibat nyeri" <?php echo isset($data->question620)?$data->question620 == 'sering_terbangun_akibat_nyeri'?'checked':'':''  ?>>
                        <span>Sering terbangun akibat nyeri</span>
                        <input type="checkbox" value="Sering terbangun akibat cemas" <?php echo isset($data->question620)?$data->question620 == 'sering_terbangun_akibat_cemas'?'checked':'':''  ?>>
                        <span>Sering terbangun akibat cemas</span>

                    <p><u>PROTEKSI DAN RESIKO</u></p>
                    <p>Status mental : </p>
                        <input type="checkbox" value="Orientasi" <?php echo isset($data->question622)?$data->question622 == 'orientasi'?'checked':'':''  ?>>
                        <span>Orientasi</span>
                        <input type="checkbox" value="Agitasi" <?php echo isset($data->question622)?$data->question622 == 'agitasi'?'checked':'':''  ?>>
                        <span>Agitasi</span>
                        <input type="checkbox" value="Menyerang" <?php echo isset($data->question622)?$data->question622 == 'menyerang'?'checked':'':''  ?>>
                        <span>Menyerang</span>
                        <input type="checkbox" value="Tidak ada respon" <?php echo isset($data->question622)?$data->question622 == 'tak_ada_respon'?'checked':'':''  ?>>
                        <span>Tidak ada respon</span>
                        <input type="checkbox" value="Lain-lain" <?php echo isset($data->question622)?$data->question622 == 'lainnya'?'checked':'':''  ?>>
                        <span> Lain-lain : <?php echo isset($data->question623)?$data->question623:''  ?></span><br>

                        <p><input type="checkbox" value="Kooperatif">
                        <span>Kooperatif</span>
                        <input type="checkbox" value="Disorientasi orang" <?php echo isset($data->question622)?$data->question622 == 'disorientasi_orang'?'checked':'':''  ?>>
                        <span>Disorientasi orang</span>
                        <input type="checkbox" value="Disorientasi tempat" <?php echo isset($data->question622)?$data->question622 == 'disorientasi tempat'?'checked':'':''  ?>>
                        <span>Disorientasi tempat</span>
                        <input type="checkbox" value="Disorientasi waktu" <?php echo isset($data->question622)?$data->question622 == 'disorientasi waktu'?'checked':'':''  ?>>
                        <span>Disorientasi waktu</span>
                        <input type="checkbox" value="Letargi" <?php echo isset($data->question622)?$data->question622 == 'letargi'?'checked':'':''  ?>>
                        <span> Letargi</span><br></p>

                        <p><input type="checkbox" value="Kejang" <?php echo isset($data->question622)?$data->question622 == 'kejang,_tipe_dan_frekwensi'?'checked':'':''  ?>>
                        <span>Kejang, tipe dan frekwensi : <?php echo isset($data->question624)?$data->question624:''  ?></span></p>

                    </div>

                    
                <p><b>9. ASESMEN RISIKO JATUH</b></p>

                <div style="margin-left:25px">   
                    <span> <b>Asesmen Risiko Jatuh</b> (Skala Morse )</span><br>
                    <span>Lingkari skore sesuai dengan kondisi pasien dan jumlahkan</span><br>
                    <table id="data" border="1">
                        <tr>
                        <th style="width: 10%;">No</th>
                        <th style="width: 35%;">Parameter</th>
                        <th style="width: 35%;">Status</th>
                        <th style="width: 20%;">Skor</th>
                        </tr>
                        <tr>
                            <td rowspan="2" style="width: 10%;text-align: center;">1.</td>
                            <td rowspan="2" style="width: 35%;">Riwayat jatuh </td>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'1'})?$data->assesment_resiko_jatuh->skor->{'1'} == "0"?"bg-checked":"":"" ?> ">Tidak </td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'1'})?$data->assesment_resiko_jatuh->skor->{'1'} == "0"?"bg-checked":"":"" ?> ">0</td>
                        </tr>
                        <tr>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'1'})?$data->assesment_resiko_jatuh->skor->{'1'} == "15"?"bg-checked":"":"" ?> ">Ya</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'1'})?$data->assesment_resiko_jatuh->skor->{'1'} == "15"?"bg-checked":"":"" ?> ">15</td>
                        </tr>

                        <tr>
                            <td rowspan="2" style="width: 10%;text-align: center;">2.</td>
                            <td rowspan="2" style="width: 35%;">Penyakit penyerta(diagnosis sekunder ≥ 2)</td>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'2'})?$data->assesment_resiko_jatuh->skor->{'2'} == "0"?"bg-checked":"":"" ?> ">Tidak </td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'2'})?$data->assesment_resiko_jatuh->skor->{'2'} == "0"?"bg-checked":"":"" ?> ">0</td>
                        </tr>
                        <tr>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'2'})?$data->assesment_resiko_jatuh->skor->{'2'} == "15"?"bg-checked":"":"" ?> ">Ya</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'2'})?$data->assesment_resiko_jatuh->skor->{'2'} == "15"?"bg-checked":"":"" ?> ">15</td>
                        </tr>

                        <tr>
                            <td rowspan="3" style="width: 10%;text-align: center;">3.</td>
                            <td style="width: 35%;">
                                Alat bantu jalan<br>
                                a.	Tidak ada/Bed rest / dibantu perawat
                                </td>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "0"?"bg-checked":"":"" ?> ">Tanpa alat bantu</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "0"?"bg-checked":"":"" ?> ">0</td>
                        </tr>
                        <tr>
                            <td style="width: 35%;">
                                b.	Penopang
                                tongkat/walker
                                </td>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "15"?"bg-checked":"":"" ?> ">Tidak dapat jalan</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "15"?"bg-checked":"":"" ?> ">15</td>
                        </tr>
                        <tr>
                            <td style="width: 35%;">
                                c.	Berpegang dengan perabot
                                </td>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "30"?"bg-checked":"":"" ?> ">Kursi </td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'3'})?$data->assesment_resiko_jatuh->skor->{'3'} == "30"?"bg-checked":"":"" ?> ">30</td>
                        </tr>

                        <tr>
                            <td rowspan="2" style="width: 10%;text-align: center;">4.</td>
                            <td rowspan="2" style="width: 35%;">Pemakaian tera
                                i heparin / intra vena / infus </td>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'4'})?$data->assesment_resiko_jatuh->skor->{'4'} == "0"?"bg-checked":"":"" ?> ">Tidak </td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'4'})?$data->assesment_resiko_jatuh->skor->{'4'} == "0"?"bg-checked":"":"" ?> ">0</td>
                        </tr>
                        <tr>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'4'})?$data->assesment_resiko_jatuh->skor->{'4'} == "20"?"bg-checked":"":"" ?> ">Ya</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'4'})?$data->assesment_resiko_jatuh->skor->{'4'} == "20"?"bg-checked":"":"" ?> ">20</td>
                        </tr>

                        <tr>
                            <td rowspan="3" style="width: 10%;text-align: center;">5.</td>
                            <td rowspan="3" style="width: 35%;">Cara berjalan / berpindah  </td>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "0"?"bg-checked":"":"" ?> ">Normal /bed rest/immobilisasi</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "0"?"bg-checked":"":"" ?> ">0</td>
                        </tr>
                        <tr>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "10"?"bg-checked":"":"" ?> ">Lemah</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "10"?"bg-checked":"":"" ?> ">10</td>
                        </tr>
                        <tr>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "20"?"bg-checked":"":"" ?> ">Terganggu</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'5'})?$data->assesment_resiko_jatuh->skor->{'5'} == "20"?"bg-checked":"":"" ?> ">20</td>
                        </tr>

                        <tr>
                            <td rowspan="2" style="width: 10%;text-align: center;">6.</td>
                            <td rowspan="2" style="width: 35%;">	Status mental</td>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'6'})?$data->assesment_resiko_jatuh->skor->{'6'} == "0"?"bg-checked":"":"" ?> ">Orientasi sesuai kemampuan diri</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'6'})?$data->assesment_resiko_jatuh->skor->{'6'} == "0"?"bg-checked":"":"" ?> ">0</td>
                        </tr>
                        <tr>
                            <td  style="width: 35%;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'6'})?$data->assesment_resiko_jatuh->skor->{'6'} == "15"?"bg-checked":"":"" ?> ">Lupa keterbatasan diri</td>
                            <td style="width: 20%;text-align: center;" class="<?= isset($data->assesment_resiko_jatuh->skor->{'6'})?$data->assesment_resiko_jatuh->skor->{'6'} == "15"?"bg-checked":"":"" ?> ">15</td>
                        </tr>
                        <tr>
                            <td  colspan="3"><b>Total</b></td>
                            <td style="width: 20%;"><?php echo isset($data->assesment_resiko_jatuh->skor->total_skor)?$data->assesment_resiko_jatuh->skor->total_skor:''  ?></td>
                        </tr>
                    </table>
                    <p>Keterangan :</p>
                    <table id="data" border="1" style="width: 55%;">
                        <tr>
                            <td style="width: 30%;">0 – 24</td>
                            <td style="width: 10%;text-align: center;">:</td>
                            <td style="width: 60%;">Tidak berisiko</td>
                        </tr>
                        <tr>
                            <td style="">25-50</td>
                            <td style="text-align: center;">:</td>
                            <td style="">Risiko rendah</td>
                        </tr>
                        <tr>
                            <td style="">≥ 51</td>
                            <td style="text-align: center;">:</td>
                            <td style="">Risiko tinggi</td>
                        </tr>
                    </table>
                        <p>Keamanan :  </p> 
                        <input type="checkbox" value="Tidak" <?php echo isset($data->keamanan)? $data->keamanan == 'tidak' ? 'checked':'':'' ?>>
                        <span>Tidak</span>
                        <input type="checkbox" value="Ya" <?php echo isset($data->keamanan)? $data->keamanan == "ya" ? "checked":'':'' ?>>
                        <span>Ya :</span>
                        <input type="checkbox" value="Pasang pengaman" <?php echo isset($data->check_keamanan)?(in_array("pasang_tempat_tidur", $data->check_keamanan) ? "checked" : "disabled"):""; ?>>
                        <span>Pasang pengaman tempat tidur/ bed railis</span>
                        <input type="checkbox" value="Penanda Segitiga" <?php echo isset($data->check_keamanan)?(in_array("penanda_segitiga", $data->check_keamanan) ? "checked" : "disabled"):""; ?>>
                        <span>Penanda Segitiga Resiko Jatuh </span><br>
                        <input type="checkbox" value="Kunci roda tempat tidur" <?php echo isset($data->check_keamanan)?(in_array("kunci_roda", $data->check_keamanan) ? "checked" : "disabled"):""; ?>>
                        <span>Kunci roda tempat tidur</span>
                        </span> 

                       

                </div>

               

            </div>
            <p style="text-align:right;font-size:12px">6</p>
                

        </div>

<!--halaman 7 -->

        <div class="A4 sheet  padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                ASESMEN AWAL KEPERAWATAN  RAWAT INAP<br>
                (Dilengkapi 24 jam pasien masuk Ruang Rawat)
            </p>

            <div style="font-size:11px">
                <div style="margin-left:25px">
                    <p>Resiko melarikan diri :</p>  
                    <input type="checkbox" value="Tidak ada masalah yang teridentifikasi"  <?php echo isset($data->question630)? $data->question630 == "tidak_ada_masalah_yang_terindetifikasi" ? "checked":'':'' ?>>
                    <span>Tidak ada masalah yang teridentifikasi</span>
                    </span><br>
                    <span>
                    <input type="checkbox" value="Resiko" <?php echo isset($data->question630)? $data->question630 == "resiko_karena" ? "checked":'':'' ?>>
                    <span> Resiko,  karena :</span>
                    <input type="checkbox" value="Gangguan status mental" <?php echo isset($data->question631)? $data->question631 == "gangguan _status_mental" ? "checked":'':'' ?>>
                    <span>Gangguan status mental</span>
                    <input type="checkbox" value="Bingung" <?php echo isset($data->question631)? $data->question631 == "bingung" ? "checked":'':'' ?>>
                    <span>Bingung</span>
                    <input type="checkbox" value=" Pusing" <?php echo isset($data->question631)? $data->question631 == "pusing" ? "checked":'':'' ?>>
                    <span> Pusing</span>
                    <input type="checkbox" value="Dementia" <?php echo isset($data->question631)? $data->question631 == "dementia" ? "checked":'':'' ?>>
                    <span>Dementia</span><br>
                    <input type="checkbox" value="Menolak tinggal" <?php echo isset($data->question631)? $data->question631 == "menolak_tinggal_di_rumah_sakit" ? "checked":'':'' ?>>
                    <span> Menolak tinggal di Rumah Sakit  </span>
                    <input type="checkbox" value="Lain-lainnya" <?php echo isset($data->question631)? $data->question631 == "lainnya" ? "checked":'':'' ?>>
                    <spa>Lain-lainnya</span>
                </div>

            <p><b>10. KEBUTUHAN EDUKASI</b></p>

                <div style="margin-left:25px">

                    <p>Bicara :</p> 
                    <input type="checkbox" value="Normal" <?php echo isset($data->question633)? $data->question633 == "normal" ? "checked":'':'' ?>>
                    <span>Normal</span>
                    <input type="checkbox" value="Serangan awal" <?php echo isset($data->question633)? $data->question633 == "serangan_awal_gangguan_biacara," ? "checked":'':'' ?>>
                    <span> Serangan awal gangguan bicara, kapan : <?php echo isset($data->question634)? $data->question634 :'' ?></span>

                    <p>Bahasa sehari-hari :</p>  
                    <input type="checkbox" value="Indonesia" <?php echo isset($data->question635)? $data->question635 == "indonesia" ? "checked":'':'' ?>>
                    <span>Indonesia,<?php echo isset($data->question638)? $data->question638:'' ?></span>
                    <input type="checkbox" value="Daerah" <?php echo isset($data->question635)? $data->question635 == "daerah" ? "checked":'':'' ?>>
                    <span> Daerah, jelaskan <?php echo isset($data->question636)? $data->question636:'' ?></span>
                    <br>
                    <input type="checkbox" value="Inggris" <?php echo isset($data->question635)? $data->question635 == "inggris" ? "checked":'':'' ?>>
                    <span>Inggris ,<?php echo isset($data->question639)? $data->question639:'' ?></span>
                    <input type="checkbox" value="Lain-lainnya" <?php echo isset($data->question635)? $data->question635 == "lainnya" ? "checked":'':'' ?>>
                    <span> Lain-lainnya , jelaskan <?php echo isset($data->question637)? $data->question637:'' ?></span>

                    <p>Perlu penerjemah : 
                    <input type="checkbox" value=" Tidak" <?php echo isset($data->question640)? $data->question640 == "tidak" ? "checked":'':'' ?>>
                    <span> Tidak</span>
                    <input type="checkbox" value="Ya" <?php echo isset($data->question640)? $data->question640 != "tidak" ? "checked":'':'' ?>>
                    <span>Ya, Bahasa <?php echo isset($data->question641)? $data->question641:'' ?></span></p>

                    <p>Hambatan belajar : </p>
                    <input type="checkbox" value="Bahasa" <?php echo isset($data->question642)? $data->question642 == "bahasa" ? "checked":'':'' ?>>
                    <span>Bahasa</span>
                    <input type="checkbox" value="Cemas" <?php echo isset($data->question642)? $data->question642 == "cemas" ? "checked":'':'' ?>>
                    <span>Cemas</span>
                    <input type="checkbox" value="Menulis " <?php echo isset($data->question642)? $data->question642 == "menulis" ? "checked":'':'' ?>>
                    <span>Menulis </span>
                    <input type="checkbox" value="Lain-lainnya" <?php echo isset($data->question642)? $data->question642 == "lainnya" ? "checked":'':'' ?>>
                    <span>Lain-lainnya : <?php echo isset($data->question643)? $data->question643:'' ?></span>

                    <p>Cara belajar yang di sukai : audio-visual /gambar 
                    <input type="checkbox" value="Diskusi" <?php echo isset($data->question645)? $data->question645 == "diskusi" ? "checked":'':'' ?>>
                    <span>Diskusi</span>
                    <input type="checkbox" value="Lain-lainnya" <?php echo isset($data->question645)? $data->question645 == "lainnya" ? "checked":'':'' ?>>
                    <span>Lain-lainnya , jelaskan : <?php echo isset($data->question646)? $data->question646:'' ?></span></p>

                    <p>Tingkat pendidikan : <p>
                    <input type="checkbox" value="TK" <?php echo isset($data->question647)? $data->question647 == "Belum/Tdk Sekolah" ? "checked":'':'' ?>>
                    <span>Belum/Tdk Sekolah</span>
                    <input type="checkbox" value="SD" <?php echo isset($data->question647)? $data->question647 == "SD" ? "checked":'':'' ?>>
                    <span>SD</span>
                    <input type="checkbox" value="SMP" <?php echo isset($data->question647)? $data->question647 == "SLTP" ? "checked":'':'' ?>>
                    <span>SMP</span>
                    <input type="checkbox" value=" SMA" <?php echo isset($data->question647)? $data->question647 == "SMA" ? "checked":'':'' ?>>
                    <span> SMA</span>
                    <input type="checkbox" value=" Akademi" <?php echo isset($data->question647)? $data->question647 == "DIII" ? "checked":'':'' ?>>
                    <span>DIII</span>
                    <input type="checkbox" value=" Sarjana " <?php echo isset($data->question647)? $data->question647 == "S1/DIV" ? "checked":'':'' ?>>
                    <span>  S1/DIV </span>
                    <input type="checkbox" value="Lain-lainnya" <?php echo isset($data->question647)? $data->question647 == "other" ? "checked":'':'' ?>>
                    <span>Lain-lainnya : <?php echo isset($data->{'question648-Comment'})? $data->{'question648-Comment'}:'' ?></span>

                    <p>Potensi kebutuhan pembelajaran : <?php echo isset($data->question649)? $data->question649:'' ?></p>

                    <p>Adanya Ketersediaan Media : 
                    <input type="checkbox" value="Tidak" <?php echo isset($data->question650)? $data->question650 == "tidak" ? "checked":'':'' ?>>
                    <span>Tidak</span>
                    <input type="checkbox" value="Ya" <?php echo isset($data->question650)? $data->question650 != "tidak" ? "checked":'':'' ?>>
                    <span>Ya : <?php echo isset($data->question651)? $data->question651:'' ?></span></p>

                </div>
                <div style="margin-left:25px">
                    
                    <p>Respon emosi :</p>
                        <input type="checkbox" value="Takut" <?php echo isset($data->question652)? $data->question652 == "takut_terhadap_therapy_pembedahan_lingkungan_RS" ? "checked":'':'' ?>>
                        <span>Takut terhadap therapy/pembedahan/lingkungan RS</span>
                        <input type="checkbox" value="marah" <?php echo isset($data->question652)? $data->question652 == "marah" ? "checked":'':'' ?>>
                        <span>marah </span>
                        <input type="checkbox" value="Tegang" <?php echo isset($data->question652)? $data->question652 == "tegang" ? "checked":'':'' ?>>
                        <span>Tegang</span>
                        <input type="checkbox" value="Lain-lainnya" <?php echo isset($data->question652)? $data->question652 == "lainya" ? "checked":'':'' ?>>
                        <span>Lain-lainnya : <?php echo isset($data->question653)? $data->question653:'' ?></span>

                    <p>Respon Kognitif :</p>
                        <span>Pasien dan keluarga menginginkan informasi tentang : <span><br>
                        <input type="checkbox" value="Penyakit yang di derita" <?php echo isset($data->question654)?(in_array("penyakit_yang_di_derita", $data->question654) ? "checked" : "disabled"):""; ?>>
                        <span>Penyakit yang di derita</span>
                        <input type="checkbox" value="Tindakan pemeriksaan lanjut" <?php echo isset($data->question654)?(in_array("tindakan_pemeriksaan_lanjut", $data->question654) ? "checked" : "disabled"):""; ?>>
                        <span>Tindakan pemeriksaan lanjut</span><br>

                        <input type="checkbox" value="Tindakan" <?php echo isset($data->question654)?(in_array("tindakan_pengobatan_dan_perawatan_yang_di_berikan ", $data->question654) ? "checked" : "disabled"):""; ?>>
                        <span>Tindakan/pengobatan dan perawatan yang di berikan</span>
                        <input type="checkbox" value="Perubahan aktifitas sehari-hari" <?php echo isset($data->question654)?(in_array("perubahan_aktifitas_sehari_hari ", $data->question654) ? "checked" : "disabled"):""; ?>>
                        <span>Perubahan aktifitas sehari-hari</span><br>

                        <input type="checkbox" value="Perencanaan diet dan menu" <?php echo isset($data->question654)?(in_array("perencanaan_diet_dan_menu ", $data->question654) ? "checked" : "disabled"):""; ?>>
                        <span>Perencanaan diet dan menu</label>
                        <input type="checkbox" value="Perawatan setelah di rumah" <?php echo isset($data->question654)?(in_array("perawatan_setelah_di_rumah", $data->question654) ? "checked" : "disabled"):""; ?>>
                        <span>Perawatan setelah di rumah</span> 
                </div>

                <p><b>11. ASESMEN RISIKO NUTRISONAL</b></p>
                <div style="margin-left:25px">
                    <span><b>Skrining Gizi : Malnutrition Screning Tool (MST)</b></span><br>
                    <span>(Lingkari skor sesuai dengan jawaban, total skor adalah jumlah skor yang dilingkari)</span>

                    <table id="data" border="1">
                        <tr>
                            <th style="width: 20%;">No</th>
                            <th style="width: 50%;">Parameter</th>
                            <th style="width: 30%;">Skor</th>
                        </tr>
                        <tr>
                            <td style="width: 20%;text-align: center;">1.</td>
                            <td style="width: 50%;">Apakah pasien mengalami penurunan berat badan yang tidak diinginkan dalam 6 bulan terakhir ?</td>
                            <td style="width: 30%;text-align: center;"></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;"></td>
                            <td style="width: 50%;" class="<?= isset($data->question7->skor->{'1'})?$data->question7->skor->{'1'} == "0"?"bg-checked":"":"" ?> ">a.	Tidak ada penurunan berat badan</td>
                            <td style="width: 30%;text-align: center;" class="<?= isset($data->question7->skor->{'1'})?$data->question7->skor->{'1'} == "0"?"bg-checked":"":"" ?> ">0</td>
                        </tr>
                        <tr>
                            <td style="width: 20%;"></td>
                            <td style="width: 50%;" class="<?= isset($data->question7->skor->{'1'})?$data->question7->skor->{'1'} == "2"?"bg-checked":"":"" ?> ">b.	Tidak yakin / tidak tahu / terasa baju lebih longgar</td>
                            <td style="width: 30%;text-align: center;" class="<?= isset($data->question7->skor->{'1'})?$data->question7->skor->{'1'} == "2"?"bg-checked":"":"" ?> ">2</td>
                        </tr>
                        <tr>
                            <td style="width: 20%;"></td>
                            <td style="width: 50%;" class="<?= isset($data->question7->skor->{'1'})?$data->question7->skor->{'1'} == "0"?"bg-checked":"":"" ?> ">c.	Jika ya, berapa penurunan berat badan tersebut </td>
                            <td style="width: 30%;" class="<?= isset($data->question7->skor->{'1'})?$data->question7->skor->{'1'} == "0"?"bg-checked":"":"" ?> "></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;"></td>
                            <td style="width: 50%;" class="<?= isset($data->question7->skor->{'1'})?$data->question7->skor->{'1'} == "1"?"bg-checked":"":"" ?> ">1-5 kg</td>
                            <td style="width: 30%;text-align: center;" class="<?= isset($data->question7->skor->{'1'})?$data->question7->skor->{'1'} == "1"?"bg-checked":"":"" ?> ">1</td>
                        </tr>
                        <tr>
                            <td style="width: 20%;"></td>
                            <td style="width: 50%;" class="<?= isset($data->question7->skor->{'1'})?$data->question7->skor->{'1'} == "2"?"bg-checked":"":"" ?> ">6-10 kg</td>
                            <td style="width: 30%;text-align: center;" class="<?= isset($data->question7->skor->{'1'})?$data->question7->skor->{'1'} == "2"?"bg-checked":"":"" ?> ">2</td>
                        </tr>
                        <tr>
                            <td style="width: 20%;"></td>
                            <td style="width: 50%;" class="<?= isset($data->question7->skor->{'1'})?$data->question7->skor->{'1'} == "3"?"bg-checked":"":"" ?> ">11-15 kg</td>
                            <td style="width: 30%;text-align: center;" class="<?= isset($data->question7->skor->{'1'})?$data->question7->skor->{'1'} == "3"?"bg-checked":"":"" ?> ">3</td>
                        </tr>
                        <tr>
                            <td style="width: 20%;"></td>
                            <td style="width: 50%;" class="<?= isset($data->question7->skor->{'1'})?$data->question7->skor->{'1'} == "4"?"bg-checked":"":"" ?> ">>15 kg</td>
                            <td style="width: 30%;text-align: center;" class="<?= isset($data->question7->skor->{'1'})?$data->question7->skor->{'1'} == "4"?"bg-checked":"":"" ?> ">4</td>
                        </tr>
                        <tr>
                            <td style="width: 20%;"></td>
                            <td style="width: 50%;" class="<?= isset($data->question7->skor->{'1'})?$data->question7->skor->{'1'} == "2"?"bg-checked":"":"" ?> ">Tidak yakin penurunannya</td>
                            <td style="width: 30%;text-align: center;" class="<?= isset($data->question7->skor->{'1'})?$data->question7->skor->{'1'} == "2"?"bg-checked":"":"" ?> ">2</td>
                        </tr>
                        <tr>
                            <td style="width: 20%;text-align: center;">2</td>
                            <td style="width: 50%;" >Apakah asupan makan berkurang karena berkurangnya nafsu makan?</td>
                            <td style="width: 30%;text-align: center;"></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;"></td>
                            <td style="width: 50%;" class="<?= isset($data->question7->skor->{'2'})?$data->question7->skor->{'2'} == "0"?"bg-checked":"":"" ?> ">1.	Tidak</td>
                            <td style="width: 30%;text-align: center;" class="<?= isset($data->question7->skor->{'2'})?$data->question7->skor->{'2'} == "0"?"bg-checked":"":"" ?> ">0</td>
                        </tr>
                        <tr>
                            <td style="width: 20%;"></td>
                            <td style="width: 50%;" class="<?= isset($data->question7->skor->{'2'})?$data->question7->skor->{'2'} == "1"?"bg-checked":"":"" ?> ">2.	Ya</td>
                            <td style="width: 30%;text-align: center;" class="<?= isset($data->question7->skor->{'2'})?$data->question7->skor->{'2'} == "1"?"bg-checked":"":"" ?> ">1</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: right;"><b>Total skor</b></td>
                            <td style="width: 30%;" style="text-align:;"><center><?=  isset($data->question7->skor->total_skor)?$data->question7->skor->total_skor:'' ?></center></td>
                        </tr>
                    </table>

                   
                </div>
                
            </div>

            <p style="text-align:right;font-size:12px">7</p>
        </div>


<!--halaman 8 -->

        <div class="A4 sheet  padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/header_print_ganjil') ?>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                ASESMEN AWAL KEPERAWATAN  RAWAT INAP<br>
                (Dilengkapi 24 jam pasien masuk Ruang Rawat)
            </p>

            <div style="font-size:11px">
                    
                <div style="margin-left:25px">
                    <table id="data" border="1">
                        <tr>
                            <td colspan="4">
                                <p><span>Pasien dengan diagnosa khusus :</span>
                                    <input type="checkbox" value="Tidak" <?php echo isset($data->question875)? $data->question875 == "tidak" ? "checked":'':'' ?>>
                                    <span>Tidak</span>
                                    <input type="checkbox" value="Ya " <?php echo isset($data->question875)? $data->question875 != "tidak" ? "checked":'':'' ?>>
                                    <span> Ya : </span>
                                    <input type="checkbox" value="DM" <?= (isset($data->question876)?in_array("dm", $data->question876)?'checked':'':'') ?>>
                                    <span>DM</span>
                                    <input type="checkbox" value="Ginjal" <?= (isset($data->question876)?in_array("ginjal", $data->question876)?'checked':'':'') ?>>
                                    <span>Ginjal</span>
                                    <input type="checkbox" value="Hati" <?= (isset($data->question876)?in_array("hati", $data->question876)?'checked':'':'') ?>>
                                    <span>Hati</span>
                                    <input type="checkbox" value="Jantung" <?= (isset($data->question876)?in_array("jantung", $data->question876)?'checked':'':'') ?> >
                                    <span>Jantung</span>
                                    <input type="checkbox" value="Paru " <?= (isset($data->question876)?in_array("paru", $data->question876)?'checked':'':'') ?>>
                                    <span>Paru </span>
                                </p>

                                <span>
                                    <input type="checkbox" value="Stroke" <?= (isset($data->question876)?in_array("stroke", $data->question876)?'checked':'':'') ?>>
                                    <span>Stroke</span>
                                    <input type="checkbox" value="Kanker" <?= (isset($data->question876)?in_array("kanker", $data->question876)?'checked':'':'') ?>>
                                    <span>Kanker</span>
                                    <input type="checkbox" value="Penurunan Immunitas" <?= (isset($data->question876)?in_array("penurunan_immunitas", $data->question876)?'checked':'':'') ?>>
                                    <span>Penurunan Immunitas  </span>
                                    <input type="checkbox" value="Lain-lain" <?= (isset($data->question876)?in_array("lainnya", $data->question876)?'checked':'':'') ?>>
                                    <span>Lain-lain : <?= isset($data->lainnya2)?$data->lainnya2:'' ?></span>
                                <span>
                            </td>
                        </tr>
                    </table>
                    <p>
                        <b>
                            Bila skore ≥ 2 dan atau pasien dengan diagnosis/ kondisi khusus dilakukan pengkajian lanjut oleh Tim Terapi Gizi
                            (TTG)
                        </b>
                    </p>

                    <span>
                        <p>Intake Nutrisi lewat : <p>
                        <input type="checkbox" value="Oral" <?php echo isset($data->question878)? $data->question878 == "oral" ? "checked":'':'' ?>>
                        <span>Oral</span>
                        <input type="checkbox" value="NGT" <?php echo isset($data->question878)? $data->question878 == "ngt" ? "checked":'':'' ?>>
                        <span>NGT</span>
                        <input type="checkbox" value="Gastostomy" <?php echo isset($data->question878)? $data->question878 == "gastostomy " ? "checked":'':'' ?>>
                        <span>Gastostomy</span>
                        <input type="checkbox" value="Lain-lain" <?php echo isset($data->question878)? $data->question878 == "other" ? "checked":'':'' ?>>
                        <span>Lain-lain : <?= isset($data->{'question878-Comment'})?$data->{'question878-Comment'}:'' ?></span>
                    </span>

                    <span>
                        <p>Masalah yang berhubungan dengan nutrisi :</p>
                        <input type="checkbox" value="mendapat" <?php echo isset($data->question879)?(in_array("mendapat", $data->question879) ? "checked" : "disabled"):""; ?>>
                        <span>mendapat</span>
                        <input type="checkbox" value="kemotherapy" <?php echo isset($data->question879)?(in_array("kemotherapy", $data->question879) ? "checked" : "disabled"):""; ?>>
                        <span>kemotherapy</span>
                        <input type="checkbox" value="Hamil/menyusui" <?php echo isset($data->question879)?(in_array("hamil_menyusui", $data->question879) ? "checked" : "disabled"):""; ?>>
                        <span>Hamil/menyusui  </span>
                    </span>

                    <p>
                        <input type="checkbox" value="Pasien operasi" <?php echo isset($data->question879)?(in_array("pasien_operasi_usia", $data->question879) ? "checked" : "disabled"):""; ?>>
                        <span>Pasien operasi usis ≥ 65 tahun  </span>
                        <input type="checkbox" value="Nausea" <?php echo isset($data->question879)?(in_array("nausea", $data->question879) ? "checked" : "disabled"):""; ?>>
                        <span>Nausea</span>
                        <input type="checkbox" value="Vomitus" <?php echo isset($data->question879)?(in_array("vomitus", $data->question879) ? "checked" : "disabled"):""; ?>>
                        <span>Vomitus</span>
                        <input type="checkbox" value="Malnutrisi " <?php echo isset($data->question879)?(in_array("malnutrisi", $data->question879) ? "checked" : "disabled"):""; ?>>
                        <span>Malnutrisi </span>
                        <input type="checkbox" value="Obesitas" <?php echo isset($data->question879)?(in_array("obesitas", $data->question879) ? "checked" : "disabled"):""; ?>>
                        <span>Obesitas</span>
                        <input type="checkbox" value="Sulit menelan" <?php echo isset($data->question879)?(in_array("sulit_menelan", $data->question879) ? "checked" : "disabled"):""; ?>>
                        <span>Sulit menelan</span>
                    </p>

                    <p>
                        <input type="checkbox" value="Disfagia" <?php echo isset($data->question879)?(in_array("disfagia", $data->question879) ? "checked" : "disabled"):""; ?>>
                        <span>Disfagia, lama masalah nutrisi :<?php echo isset($data->question880)? $data->question880:'' ?></span>
                        
                    </p>

                    <p>
                        <input type="checkbox" value="BB menurun" <?php echo isset($data->question879)?(in_array("bb_menurun", $data->question879) ? "checked" : "disabled"):""; ?>>
                        <span>BB menurun/meningkat dalam 1 bulan</span>
                    </p>

                    <p>
                        <input type="checkbox" value="BB menurun" <?php echo isset($data->question879)?(in_array("diet_saat_ini", $data->question879) ? "checked" : "disabled"):""; ?>>
                        <span>Diet saat ini : <?php echo isset($data->question881)? $data->question881:'' ?></span>
                    </p>

                    <p>Makanan kesukaan : <?php echo isset($data->question882)? $data->question882:'' ?></p>
                </div>

                <p><b>12. RIWAYAT PENGGUNAAN OBAT</b></p>

                <div style="margin-left:25px">
                    <p>
                        Riwayat Penggunaan Di rumah : 
                        <input type="checkbox" value="Tidak" <?php echo isset($data->question884)? $data->question884 == "tidak" ? "checked":'':'' ?>>
                        <span>Tidak</span>
                        <input type="checkbox" value="Ya" <?php echo isset($data->question884)? $data->question884 == "ya" ? "checked":'':'' ?>>
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
                            $jml_array = isset($data->question885)?count($data->question885):'';
                            for ($x = 0; $x < $jml_array; $x++) {
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= isset($data->question885[$x]->nama_obat2)?$data->question885[$x]->nama_obat2:'' ?></td>
                                <td><?= isset($data->question885[$x]->dosis)?$data->question885[$x]->dosis:'' ?></td>
                                <td><?= isset($data->question885[$x]->cara_pemberian)?$data->question885[$x]->cara_pemberian:'' ?></td>
                            </tr>
                        <?php } ?>
                            
                    </table>
                </div>

                <p><b>12. RIWAYAT PENGGUNAAN OBAT</b></p>
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
                            <td style="width: 15;text-align:center"><?= (isset($data->question887->perlu_pelayanan_home_care->ya)?in_array("1", $data->question887->perlu_pelayanan_home_care->ya)?'√':'':'') ?></td>
                            <td style="width: 15;text-align:center"><?= (isset($data->question887->perlu_pelayanan_home_care->tidak)?in_array("1", $data->question887->perlu_pelayanan_home_care->tidak)?'√':'':'') ?></td>
                            <td style="width: 40;"><?php echo isset($data->question887->perlu_pelayanan_home_care->keterangan)? $data->question887->perlu_pelayanan_home_care->keterangan:'' ?></td>
                        </tr>
                        <tr>
                            <td  style="width: 30;">Perlu Pemasangan Implant</td>
                            <td style="width: 15;text-align:center"><?= (isset($data->question887->perlu_pemasangan_implant->ya)?in_array("1", $data->question887->perlu_pemasangan_implant->ya)?'√':'':'') ?></td>
                            <td style="width: 15;text-align:center"><?= (isset($data->question887->perlu_pemasangan_implant->tidak)?in_array("1", $data->question887->perlu_pemasangan_implant->tidak)?'√':'':'') ?></td>
                            <td style="width: 40;"><?php echo isset($data->question887->perlu_pemasangan_implant->keterangan)? $data->question887->perlu_pemasangan_implant->keterangan:'' ?></td>
                        </tr>
                        <tr>
                            <td  style="width: 30;">Penggunaan Alat Bantu</td>
                            <td style="width: 15;text-align:center"><?= (isset($data->question887->{'Penggunaan alat bantu'}->ya)?in_array("1", $data->question887->{'Penggunaan alat bantu'}->ya)?'√':'':'') ?></td>
                            <td style="width: 15;text-align:center"><?= (isset($data->question887->{'Penggunaan alat bantu'}->tidak)?in_array("1", $data->question887->{'Penggunaan alat bantu'}->tidak)?'√':'':'') ?></td>
                            <td style="width: 40;"><?php echo isset($data->question887->{'Penggunaan alat bantu'}->keterangan)? $data->question887->{'Penggunaan alat bantu'}->keterangan:'' ?></td>
                        </tr>
                        <tr>
                            <td  style="width: 30;">Telah dilakukan Pemesanan Alat</td>
                            <td style="width: 15;text-align:center"><?= (isset($data->question887->telah_dilakukan_pemesanan_alat->ya)?in_array("1", $data->question887->telah_dilakukan_pemesanan_alat->ya)?'√':'':'') ?></td>
                            <td style="width: 15;text-align:center"><?= (isset($data->question887->telah_dilakukan_pemesanan_alat->tidak)?in_array("1", $data->question887->telah_dilakukan_pemesanan_alat->tidak)?'√':'':'') ?></td>
                            <td style="width: 40;"><?php echo isset($data->question887->telah_dilakukan_pemesanan_alat->keterangan)? $data->question887->telah_dilakukan_pemesanan_alat->keterangan:'' ?></td>
                        </tr>
                        <tr>
                            <td  style="width: 30;">Dirujuk ke Komunitas Tertentu</td>
                            <td style="width: 15;text-align:center"><?= (isset($data->question887->dirujuk_komunitas->ya)?in_array("1", $data->question887->dirujuk_komunitas->ya)?'√':'':'') ?></td>
                            <td style="width: 15;text-align:center"><?= (isset($data->question887->dirujuk_komunitas->tidak)?in_array("1", $data->question887->dirujuk_komunitas->tidak)?'√':'':'') ?></td>
                            <td style="width: 40;"><?php echo isset($data->question887->dirujuk_komunitas->keterangan)? $data->question887->dirujuk_komunitas->keterangan:'' ?></td>
                        </tr>
                        <tr>
                            <td  style="width: 30;">Dirujuk ke Tim Terapis</td>
                            <td style="width: 15;text-align:center"><?= (isset($data->question887->dirujuk_tim_terapis->ya)?in_array("1", $data->question887->dirujuk_tim_terapis->ya)?'√':'':'') ?></td>
                            <td style="width: 15;text-align:center"><?= (isset($data->question887->dirujuk_tim_terapis->tidak)?in_array("1", $data->question887->dirujuk_tim_terapis->tidak)?'√':'':'') ?></td>
                            <td style="width: 40;"><?php echo isset($data->question887->dirujuk_tim_terapis->keterangan)? $data->question887->dirujuk_tim_terapis->keterangan:'' ?></td>
                        </tr>
                        <tr>
                            <td  style="width: 30;">Dirujuk ke Ahli Gizi</td>
                            <td style="width: 15;text-align:center"><?= (isset($data->question887->dirujuk_ahli->ya)?in_array("1", $data->question887->dirujuk_ahli->ya)?'√':'':'') ?></td>
                            <td style="width: 15;text-align:center"><?= (isset($data->question887->dirujuk_ahli->tidak)?in_array("1", $data->question887->dirujuk_ahli->tidak)?'√':'':'') ?></td>
                            <td style="width: 40;"><?php echo isset($data->question887->dirujuk_ahli->keterangan)? $data->question887->dirujuk_ahli->keterangan:'' ?></td>
                        </tr>
                        <tr>
                            <td  style="width: 30;">Lain – Lain</td>
                            <td style="width: 15;text-align:center"><?= (isset($data->question887->laib_lain->ya)?in_array("1", $data->question887->laib_lain->ya)?'√':'':'') ?></td>
                            <td style="width: 15;text-align:center"><?= (isset($data->question887->laib_lain->tidak)?in_array("1", $data->question887->laib_lain->tidak)?'√':'':'') ?></td>
                            <td style="width: 40;"><?php echo isset($data->question887->laib_lain->keterangan)? $data->question887->laib_lain->keterangan:'' ?></td>
                        </tr>
                    </table>
                </div>

                <p><b>13. DAFTAR DIAGNOSA KEPERAWATAN</b></p>
                <div style="margin-left:25px">
                    <p>
                        <input type="checkbox" value="Bersihan jalan" size="2px" <?= (isset($data->question1106)?in_array(" bersihkan_jalan_nafas", $data->question1106)?'checked':'':'') ?>>
                        <span>Bersihan jalan nafas tidak  efektif</span><br>
                        <input type="checkbox" value="Nyeri"  <?= (isset($data->question1106)?in_array("nyeri", $data->question1106)?'checked':'':'') ?>>
                        <span>Nyeri</span><br>
                        <input type="checkbox" value="Hipertermi"  <?= (isset($data->question1106)?in_array("hipertermi", $data->question1106)?'checked':'':'') ?>>
                        <span>Hipertermi</span><br>
                        <input type="checkbox" value="Penurunan kapasitas"  <?= (isset($data->question1106)?in_array("penurunan_kapasitas_adaptif", $data->question1106)?'checked':'':'') ?>>
                        <span>Penurunan kapasitas adaptif intra Kranial</span><br>
                        <input type="checkbox" value="Risiko "  <?= (isset($data->question1106)?in_array("risiko_penurunan_curah_jantung", $data->question1106)?'checked':'':'') ?>>
                        <span>Risiko Penurunan curah jantung</span><br>
                        <input type="checkbox" value="Gangguan menelan"  <?= (isset($data->question1106)?in_array("gangguan_menelan", $data->question1106)?'checked':'':'') ?>>
                        <span>Gangguan menelan</span><br>
                        <input type="checkbox" value="Gangguan mobilitas fisik"  <?= (isset($data->question1106)?in_array("gangguan_mobilitas_fisik", $data->question1106)?'checked':'':'') ?>>
                        <span>Gangguan mobilitas fisik</span><br>
                        <input type="checkbox" value="Defisit perawatan diri"  <?= (isset($data->question1106)?in_array("defisit_perawatan_diri", $data->question1106)?'checked':'':'') ?>>
                        <span>Defisit perawatan diri</span><br>
                        <input type="checkbox" value="Risiko ketidakstabilan gula darah"  <?= (isset($data->question1106)?in_array("esiko_ketidakstabilan_gula_darah", $data->question1106)?'checked':'':'') ?>>
                        <span>Risiko ketidakstabilan gula darah</span><br>
                        <input type="checkbox" value="Risiko gangguan integritas kulit/jaringan "  <?= (isset($data->question1106)?in_array("risiko_gangguan_integritas_kulit", $data->question1106)?'checked':'':'') ?>>
                        <span>Risiko gangguan integritas kulit/jaringan </span><br>
                        <input type="checkbox" value="Risiko perfusi cerebral tidak efektif"  <?= (isset($data->question1106)?in_array("risiko_perfusi", $data->question1106)?'checked':'':'') ?>>
                        <span>Risiko perfusi cerebral tidak efektif</span><br>
                        <input type="checkbox" value="Risiko jatuh"  <?= (isset($data->question1106)?in_array("risiko_jatuh", $data->question1106)?'checked':'':'') ?>>
                        <span>Risiko jatuh</span><br>
                        <input type="checkbox" value="Berduka"  <?= (isset($data->question1106)?in_array("berduka_nyeri", $data->question1106)?'checked':'':'') ?>>
                        <span>Berduka</span><br>
                      
                    </p>
                    
                </div>

            </div>
            <p style="text-align:right;font-size:12px">8</p>

        </div>

<!--halaman 9 -->

        <div class="A4 sheet  padding-fix-10mm">
        <header>
                <?php $this->load->view('emedrec/header_print') ?>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                ASESMEN AWAL KEPERAWATAN  RAWAT INAP<br>
                (Dilengkapi 24 jam pasien masuk Ruang Rawat)
            </p>

            <div style="font-size:11px">
                <div style="margin-left:25px">
                    <input type="checkbox" value="Gangguan komunikasi verbal"  <?= (isset($data->question1106)?in_array("gangguan_komunikasi_verbal", $data->question1106)?'checked':'':'') ?>>
                    <span>Gangguan komunikasi verbal</span><br>
                    <input type="checkbox" value="Risiko Infeksi"  <?= (isset($data->question1106)?in_array(" risiko_infeksi", $data->question1106)?'checked':'':'') ?>>
                    <span>Risiko Infeksi</span>
                    <p>
                    <?php echo isset($data->question1107)? $data->question1107:'' ?>
                    </p>
                </div>
                <p><b>14. INTERVENSI KEPERAWATAN</b></p>
                <div style="margin-left:25px">
                    <p>
                        <input type="checkbox" value=" Latihan batuk efektif" <?= (isset($data->question1109)?in_array("latihan_batuk_efektif", $data->question1109)?'checked':'':'') ?>>
                        <span> Latihan batuk efektif</span><br>
                        <input type="checkbox" value="Manajemen jalan nafas" <?= (isset($data->question1109)?in_array("manajemen_jalan_nafas", $data->question1109)?'checked':'':'') ?>>
                        <span>Manajemen jalan nafas</span><br>
                        <input type="checkbox" value="Pengaturan posisi" <?= (isset($data->question1109)?in_array("pengaturan_posisi", $data->question1109)?'checked':'':'') ?>>
                        <span>Pengaturan posisi</span><br>
                        <input type="checkbox" value="Pengisapan jalan nafas" <?= (isset($data->question1109)?in_array("pengisapan_jalan_nafas", $data->question1109)?'checked':'':'') ?>>
                        <span>Pengisapan jalan nafas</span><br>
                        <input type="checkbox" value="Manajemen hipertermia" <?= (isset($data->question1109)?in_array("manajemen_hipertermia", $data->question1109)?'checked':'':'') ?>>
                        <span>Manajemen hipertermia</span><br>
                        <input type="checkbox" value="Manajemen kejang" <?= (isset($data->question1109)?in_array("manajemen_kejang", $data->question1109)?'checked':'':'') ?>>
                        <span>Manajemen kejang</span><br>
                        <input type="checkbox" value="Manajemen nyeri" <?= (isset($data->question1109)?in_array("manajemen_nyeri", $data->question1109)?'checked':'':'') ?>>
                        <span>Manajemen nyeri</span><br>
                        <input type="checkbox" value="Manajemen diare" <?= (isset($data->question1109)?in_array("manajemen_diare", $data->question1109)?'checked':'':'') ?>>
                        <span>Manajemen diare</span><br>
                        <input type="checkbox" value="Manajemen cairan" <?= (isset($data->question1109)?in_array("manajemen_cairan", $data->question1109)?'checked':'':'') ?>>
                        <span>Manajemen cairan</span><br>
                        <input type="checkbox" value="Dukungan perawatan diri" <?= (isset($data->question1109)?in_array("dukungan_perawatan_diri", $data->question1109)?'checked':'':'') ?>>
                        <span>Dukungan perawatan diri</span><br>
                        <input type="checkbox" value="Pencegahan jatuh" <?= (isset($data->question1109)?in_array("pencegahan_jatuh", $data->question1109)?'checked':'':'') ?>>
                        <span>Pencegahan jatuh</span><br>
                        <input type="checkbox" value="Manajemen nutrisi" <?= (isset($data->question1109)?in_array("manajemen_nutrisi", $data->question1109)?'checked':'':'') ?>>
                        <span>Manajemen nutrisi</span><br>
                        <input type="checkbox" value="Terapi relaksasi" <?= (isset($data->question1109)?in_array("terapi_relaksasi", $data->question1109)?'checked':'':'') ?>>
                        <span>Terapi relaksasi</span><br>

                        <input type="checkbox" value="Manajemen peningkatan tekanan intrakranial" <?= (isset($data->question1109)?in_array("manajemen_peningkatan_tekanan", $data->question1109)?'checked':'':'') ?>>
                        <span>Manajemen peningkatan tekanan intrakranial</span><br>
                        <input type="checkbox" value="Pencegahan infeksi" <?= (isset($data->question1109)?in_array("pencegahan_infeksi", $data->question1109)?'checked':'':'') ?>>
                        <span>Pencegahan infeksi</span><br>
                        <input type="checkbox" value="Pencegahan aspirasi" <?= (isset($data->question1109)?in_array("pencegahan_aspirasi pengaturan_posisi", $data->question1109)?'checked':'':'') ?>>
                        <span>Pencegahan aspirasi</span><br>
                        <input type="checkbox" value="Perawatan integritas kulit" <?= (isset($data->question1109)?in_array("perawatan_integritas_kulit", $data->question1109)?'checked':'':'') ?>>
                        <span>Perawatan integritas kulit</span><br>
                        <input type="checkbox" value="Kolaborasi dalam pemberian obat" <?= (isset($data->question1109)?in_array("kolaborasi_dalam_pemberian_obat", $data->question1109)?'checked':'':'') ?>>
                        <span>Kolaborasi dalam pemberian obat</span><br>
                        <input type="checkbox" value="Promosi komunikasi" <?= (isset($data->question1109)?in_array("promosi_komunikasi_defisit_bicara", $data->question1109)?'checked':'':'') ?>>
                        <span>Promosi komunikasi ; Defisit bicara</span><br>
                        
                    </p>

                    <div style="min-height:200px"><p><?php echo isset($data->question1110)? $data->question1110:'' ?></p></div>
                </div>


            <div style="display: inline; position: relative;">
                <div style="float: left;">
                    <p>
                        <span>Tanggal selesai pengkajian :<?= isset($data->question1111)? date('d-m-Y',strtotime($data->question1111)):''; ?></span><br>
                        <span>jam :<?= isset($data->question1111)? date('H:i:s',strtotime($data->question1111)):''; ?></span>                      
                    </p>
                    <p>Perawat yang mengkaji I</p>
                    <?php
                        $name_one = $data->nm_pemeriksa_1??null;
                                                            
                        $result = $name_one?$this->db->query("SELECT ttd FROM hmis_users  where name = '$name_one'")->row():null;
                        if(isset($result->ttd)){
                    ?>
                        <img width="120px" height="130px"src="<?= $result->ttd ?>" alt=""><br>
                    <?php }?>
                    <span><?= isset($data->nm_pemeriksa_1)?$data->nm_pemeriksa_1:'' ?></span>      
                </div>
                <div style="float: right;">
                    <p>
                        <span>Tanggal selesai pengkajian :<?= isset($data->question1112)? date('d-m-Y',strtotime($data->question1112)):''; ?></span><br>                                                      
                        <span>Jam : <?= isset($data->question1112)? date('H:i:s',strtotime($data->question1112)):''; ?>
                    </p>
                    <p>Perawat yang mengkaji II</p>
                    <?php
                        $name_two = $data->nm_pemeriksa_2??null;
                                                            
                        $result_two = $name_two?$this->db->query("SELECT ttd FROM hmis_users  where name = '$name_two'")->row():null;
                        if(isset($result_two->ttd)){
                    ?>
                        <img width="120px" height="130px"src="<?= $result_two->ttd ?>" alt=""><br>
                    <?php }?>
                    <span><?= isset($data->nm_pemeriksa_2)?$data->nm_pemeriksa_2:'' ?></span>     
                </div>
            </div>
                
            </div>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            
                
                <p style="text-align:right;font-size:12px">9</p>
             </br></br></br></br></br> </br></br></br></br></br></br></br>
        </div>

<!--halaman 10 -->

        <!-- <div class="A4 sheet  padding-fix-10mm">
            <header style="margin-top:20px; font-size:1pt!important;">
                    <table border="0" width="100%">
                        <tr>
                            <td width="13%">
                                <p align="center">
                                <img src="<?= base_url("assets/img/$logo_kesehatan_header"); ?>" alt="img" height="60" style="padding-right:5px;">
                                </p>
                            </td>
                            <td  width="74%" style="font-size:9px;" align="center">
                                <font style="font-size:8pt!important">
                                    <b><label>KEMENTERIAN KESEHATAN REPUBLIK INDONESIA</label></b><br>
                                </font>
                                <font style="font-size:8pt">
                                    <b><label>DIREKTORAT JENDERAL PELAYANAN KESEHATAN</label></b><br>
                                    <b><label>RUMAH SAKIT OTAK DR. Drs. M. HATTA BUKITTINGGI</label></b>
                                </font>    
                                <br>
                                <label>Jalan Jenderal Sudirman Bukittinggi Telepon (0752) 21013 Faksimile (0752) 23431</label><br>
                                <label>Email : rsomh.bkt20@gmail.com Email : rssnyanmed@yahoo.co.id Website : www.rsstrokebkt.com</label>
                            </td>
                            <td width="13%">
                                <p align="center">
                                    <img src=" <?= base_url("assets/img/$logo_header"); ?>"  alt="img" height="60" style="padding-right:5px;">
                                </p>
                            </td>
                        </tr>
                    </table>
            </header>
            <div style="height:0px;border: 2px solid black;"></div>
            <p style = "font-weight:bold; font-size: 13px; text-align: center;">
                ASESMEN AWAL KEPERAWATAN  RAWAT INAP<br>
                (Dilengkapi 24 jam pasien masuk Ruang Rawat)
            </p>

        </div>

    </body>
</html>  -->