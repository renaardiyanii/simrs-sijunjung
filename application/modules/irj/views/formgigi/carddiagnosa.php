<style>
    .min-height-60{
        min-height:60vh;
    }
    .flex{
        display:flex;
    }
    .justify-center{
        justify-content:center;
    }
    .flex-column{
        flex-direction:column;

    }
    .align-center{
        align-items:center;
    }
    .font-17{
        font-size:17pt;
    }
</style>

<script>
    function showModal(name,posisi){
        console.log(posisi);
        console.log(name);
        $('#id_gigi').val(name);
        $('#posisi').val(posisi);
        $('#modalGigiShow').modal('show');   
    };
    function changeValue(name,src,posisi){
        $('#'+name).val(src);
        document.getElementById(posisi + '_gigi').src = '<?php echo base_url() ?>' + src;
        $('#modalGigiShow').modal('hide');   

    }



</script>
<?php

// var_dump($gigi);

?>
<div class="min-height-60">
    <div class="flex justify-center">
       
        <!-- <form action="irj/rjcpelayanan/insert_gigi" method="post"> -->
            <?php
            for($i = 18; $i>=11;$i--){
            ?>
            <?php 
            if($i<=13){
            ?>
            <div class="gigi flex justify-center flex-column align-center">
                <span class="font-17"><?php echo $i ?></span>
                <img onclick="showModal('<?php echo 'posisi_gigi_'.$i ?>',<?php echo $i; ?>)" width="50px" src="<?= base_url(isset($gigi->{'posisi_gigi_'.$i}) && $gigi->{'posisi_gigi_'.$i}!=null?$gigi->{'posisi_gigi_'.$i}:'assets/img/assesment_gigi/1_dpn.png') ?>" alt="gigi_1" id="<?php echo $i.'_gigi'; ?>" >
                <input type="hidden" id="<?php echo 'posisi_gigi_'.$i ?>" name="<?php echo 'posisi_gigi_'.$i ?>">
            </div>
            <?php }else{ ?>
            <div class="gigi flex justify-center flex-column align-center">
                <span class="font-17"><?php echo $i ?></span>
                <img onclick="showModal('<?php echo 'posisi_gigi_'.$i ?>',<?php echo $i; ?>)" width="50px" src="<?= base_url(isset($gigi->{'posisi_gigi_'.$i})&& $gigi->{'posisi_gigi_'.$i}!=null?$gigi->{'posisi_gigi_'.$i}:'assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" id="<?php echo $i.'_gigi'; ?>" >
                <input type="hidden" id="<?php echo 'posisi_gigi_'.$i ?>" name="<?php echo 'posisi_gigi_'.$i ?>">
            </div>
            <?php }} ?>
            <?php 
            for($j = 21;$j<=28;$j++){
            ?>
            <?php
            if($j>=24){
            ?>
            <div class="gigi flex justify-center flex-column align-center">
                <span class="font-17"><?php echo $j ?></span>
                <img onclick="showModal('<?php echo 'posisi_gigi_'.$j ?>',<?php echo $j; ?>)" width="50px" src="<?= base_url(isset($gigi->{'posisi_gigi_'.$j}) && $gigi->{'posisi_gigi_'.$j}!=null?$gigi->{'posisi_gigi_'.$j}:'assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" id="<?php echo $j.'_gigi'; ?>" >
                <input type="hidden" id="<?php echo 'posisi_gigi_'.$j ?>" name="<?php echo 'posisi_gigi_'.$j ?>">
            </div>
            <?php
            }else{
            ?>
            <div class="gigi flex justify-center flex-column align-center">
                <span class="font-17"><?php echo $j ?></span>
                <img onclick="showModal('<?php echo 'posisi_gigi_'.$j ?>',<?php echo $j; ?>)" width="50px" src="<?= base_url(isset($gigi->{'posisi_gigi_'.$j})&& $gigi->{'posisi_gigi_'.$j}!=null?$gigi->{'posisi_gigi_'.$j}:'assets/img/assesment_gigi/1_dpn.png') ?>" alt="gigi_1" id="<?php echo $j.'_gigi'; ?>" >
                <input type="hidden" id="<?php echo 'posisi_gigi_'.$j ?>" name="<?php echo 'posisi_gigi_'.$j ?>">
            </div>
            
            <?php } ?>
            

            <?php } ?>
            
            <!-- <div class="gigi flex justify-center flex-column align-center">
                <span class="font-17"><?php //echo $i ?></span>
                <img width="50px" src="<?php //echo base_url('assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" srcset="">
            </div>
            -->
            <!-- <button type="submit">Submit</button> -->
        <!-- </form> -->
       

        
    </div>
    <div class="flex justify-center">
       
        <!-- <form action="irj/rjcpelayanan/insert_gigi" method="post"> -->
            <?php
            for($k = 55; $k>=51;$k--){
            ?>
            <?php 
            if($k<=53){
            ?>
            <div class="gigi flex justify-center flex-column align-center">
                <span class="font-17"><?php echo $k ?></span>
                <img onclick="showModal('<?php echo 'posisi_gigi_'.$k ?>',<?php echo $k; ?>)" width="50px" src="<?= base_url(isset($gigi->{'posisi_gigi_'.$k})&& $gigi->{'posisi_gigi_'.$k}!=null?$gigi->{'posisi_gigi_'.$k}:'assets/img/assesment_gigi/1_dpn.png') ?>" alt="gigi_1" id="<?php echo $k.'_gigi'; ?>" >
                <input type="hidden" id="<?php echo 'posisi_gigi_'.$k ?>" name="<?php echo 'posisi_gigi_'.$k ?>">
            </div>
            <?php }else{ ?>
            <div class="gigi flex justify-center flex-column align-center">
                <span class="font-17"><?php echo $k ?></span>
                <img onclick="showModal('<?php echo 'posisi_gigi_'.$k ?>',<?php echo $k; ?>)" width="50px" src="<?= base_url(isset($gigi->{'posisi_gigi_'.$k})&& $gigi->{'posisi_gigi_'.$k}!=null?$gigi->{'posisi_gigi_'.$k}:'assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" id="<?php echo $k.'_gigi'; ?>" >
                <input type="hidden" id="<?php echo 'posisi_gigi_'.$k ?>" name="<?php echo 'posisi_gigi_'.$k ?>">
            </div>
            <?php }} ?>
            <?php 
            for($l = 61;$l<=65;$l++){
            ?>
            <?php
            if($l>=63){
            ?>
            <div class="gigi flex justify-center flex-column align-center">
                <span class="font-17"><?php echo $l ?></span>
                <img onclick="showModal('<?php echo 'posisi_gigi_'.$l ?>',<?php echo $l; ?>)" width="50px" src="<?= base_url(isset($gigi->{'posisi_gigi_'.$l}) && $gigi->{'posisi_gigi_'.$l}!=null?$gigi->{'posisi_gigi_'.$l}:'assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" id="<?php echo $l.'_gigi'; ?>" >
                <input type="hidden" id="<?php echo 'posisi_gigi_'.$l ?>" name="<?php echo 'posisi_gigi_'.$l ?>">
            </div>
            <?php
            }else{
            ?>
            <div class="gigi flex justify-center flex-column align-center">
                <span class="font-17"><?php echo $l ?></span>
                <img onclick="showModal('<?php echo 'posisi_gigi_'.$l ?>',<?php echo $l; ?>)" width="50px" src="<?= base_url(isset($gigi->{'posisi_gigi_'.$l})&& $gigi->{'posisi_gigi_'.$l}!=null?$gigi->{'posisi_gigi_'.$l}:'assets/img/assesment_gigi/1_dpn.png') ?>" alt="gigi_1" id="<?php echo $l.'_gigi'; ?>" >
                <input type="hidden" id="<?php echo 'posisi_gigi_'.$l ?>" name="<?php echo 'posisi_gigi_'.$l ?>">
            </div>
            
            <?php } ?>
            

            <?php } ?>
       

        
    </div>
    <div class="flex justify-center">
       
        <!-- <form action="irj/rjcpelayanan/insert_gigi" method="post"> -->
            <?php
            for($m = 85; $m>=81;$m--){
            ?>
            <?php 
            if($m<=83){
            ?>
            <div class="gigi flex justify-center flex-column align-center">
                <span class="font-17"><?php echo $m ?></span>
                <img onclick="showModal('<?php echo 'posisi_gigi_'.$m ?>',<?php echo $m; ?>)" width="50px" src="<?= base_url(isset($gigi->{'posisi_gigi_'.$m})&& $gigi->{'posisi_gigi_'.$m}!=null?$gigi->{'posisi_gigi_'.$m}:'assets/img/assesment_gigi/1_dpn.png') ?>" alt="gigi_1" id="<?php echo $m.'_gigi'; ?>" >
                <input type="hidden" id="<?php echo 'posisi_gigi_'.$m ?>" name="<?php echo 'posisi_gigi_'.$m ?>">
            </div>
            <?php }else{ ?>
            <div class="gigi flex justify-center flex-column align-center">
                <span class="font-17"><?php echo $m ?></span>
                <img onclick="showModal('<?php echo 'posisi_gigi_'.$m ?>',<?php echo $m; ?>)" width="50px" src="<?= base_url(isset($gigi->{'posisi_gigi_'.$m})&& $gigi->{'posisi_gigi_'.$m}!=null?$gigi->{'posisi_gigi_'.$m}:'assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" id="<?php echo $m.'_gigi'; ?>" >
                <input type="hidden" id="<?php echo 'posisi_gigi_'.$m ?>" name="<?php echo 'posisi_gigi_'.$m ?>">
            </div>
            <?php }} ?>
            <?php 
            for($n = 71;$n<=75;$n++){
            ?>
            <?php
            if($n>=73){
            ?>
            <div class="gigi flex justify-center flex-column align-center">
                <span class="font-17"><?php echo $n ?></span>
                <img onclick="showModal('<?php echo 'posisi_gigi_'.$n ?>',<?php echo $n; ?>)" width="50px" src="<?= base_url(isset($gigi->{'posisi_gigi_'.$n})&& $gigi->{'posisi_gigi_'.$n}!=null?$gigi->{'posisi_gigi_'.$n}:'assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" id="<?php echo $n.'_gigi'; ?>" >
                <input type="hidden" id="<?php echo 'posisi_gigi_'.$n ?>" name="<?php echo 'posisi_gigi_'.$n ?>">
            </div>
            <?php
            }else{
            ?>
            <div class="gigi flex justify-center flex-column align-center">
                <span class="font-17"><?php echo $n ?></span>
                <img onclick="showModal('<?php echo 'posisi_gigi_'.$n ?>',<?php echo $n; ?>)" width="50px" src="<?= base_url(isset($gigi->{'posisi_gigi_'.$n})&& $gigi->{'posisi_gigi_'.$n}!=null?$gigi->{'posisi_gigi_'.$n}:'assets/img/assesment_gigi/1_dpn.png') ?>" alt="gigi_1" id="<?php echo $n.'_gigi'; ?>" >
                <input type="hidden" id="<?php echo 'posisi_gigi_'.$n ?>" name="<?php echo 'posisi_gigi_'.$n ?>">
            </div>
            
            <?php } ?>
            

            <?php } ?>
       

        
    </div>
    <div class="flex justify-center">
       
        <!-- <form action="irj/rjcpelayanan/insert_gigi" method="post"> -->
            <?php
            for($o = 48; $o>=41;$o--){
            ?>
            <?php 
            if($o<=43){
            ?>
            <div class="gigi flex justify-center flex-column align-center">
                <span class="font-17"><?php echo $o ?></span>
                <img onclick="showModal('<?php echo 'posisi_gigi_'.$o ?>',<?php echo $o; ?>)" width="50px" src="<?= base_url(isset($gigi->{'posisi_gigi_'.$o})&& $gigi->{'posisi_gigi_'.$o}!=null?$gigi->{'posisi_gigi_'.$o}:'assets/img/assesment_gigi/1_dpn.png') ?>" alt="gigi_1" id="<?php echo $o.'_gigi'; ?>" >
                <input type="hidden" id="<?php echo 'posisi_gigi_'.$o ?>" name="<?php echo 'posisi_gigi_'.$o ?>">
            </div>
            <?php }else{ ?>
            <div class="gigi flex justify-center flex-column align-center">
                <span class="font-17"><?php echo $o ?></span>
                <img onclick="showModal('<?php echo 'posisi_gigi_'.$o ?>',<?php echo $o; ?>)" width="50px" src="<?= base_url(isset($gigi->{'posisi_gigi_'.$o})&& $gigi->{'posisi_gigi_'.$o}!=null?$gigi->{'posisi_gigi_'.$o}:'assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" id="<?php echo $o.'_gigi'; ?>" >
                <input type="hidden" id="<?php echo 'posisi_gigi_'.$o ?>" name="<?php echo 'posisi_gigi_'.$o ?>">
            </div>
            <?php }} ?>
            <?php 
            for($p = 31;$p<=38;$p++){
            ?>
            <?php
            if($p>=33){
            ?>
            <div class="gigi flex justify-center flex-column align-center">
                <span class="font-17"><?php echo $p ?></span>
                <img onclick="showModal('<?php echo 'posisi_gigi_'.$p ?>',<?php echo $p; ?>)" width="50px" src="<?= base_url(isset($gigi->{'posisi_gigi_'.$p})&& $gigi->{'posisi_gigi_'.$p}!=null?$gigi->{'posisi_gigi_'.$p}:'assets/img/assesment_gigi/2_sou.png') ?>" alt="gigi_1" id="<?php echo $p.'_gigi'; ?>" >
                <input type="hidden" id="<?php echo 'posisi_gigi_'.$p ?>" name="<?php echo 'posisi_gigi_'.$p ?>">
            </div>
            <?php
            }else{
            ?>
            <div class="gigi flex justify-center flex-column align-center">
                <span class="font-17"><?php echo $p ?></span>
                <img onclick="showModal('<?php echo 'posisi_gigi_'.$p ?>',<?php echo $p; ?>)" width="50px" src="<?= base_url(isset($gigi->{'posisi_gigi_'.$p})&& $gigi->{'posisi_gigi_'.$p}!=null?$gigi->{'posisi_gigi_'.$p}:'assets/img/assesment_gigi/1_dpn.png') ?>" alt="gigi_1" id="<?php echo $p.'_gigi'; ?>" >
                <input type="hidden" id="<?php echo 'posisi_gigi_'.$p ?>" name="<?php echo 'posisi_gigi_'.$p ?>">
            </div>
            
            <?php } ?>
            

            <?php } ?>
       

        
    </div>
</div>


<!-- modal -->
<div id="modalGigiShow" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <h5 class="modal-title">TABEL DAFTAR ODONTOGRAM</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <input type="hidden" id="id_gigi">
            <input type="hidden" id="posisi">
            <div class="flex justify-center">
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#10_cof_kanan').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/10_cof_kanan.png') ?>" alt="10_cof_kanan"  >
                    <input type="hidden" id="10_cof_kanan" value="assets/img/assesment_gigi/10_cof_kanan.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#11_cof_kiri').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/11_cof_kiri.png') ?>" alt="11_cof_kiri"  >
                    <input type="hidden" id="11_cof_kiri" value="assets/img/assesment_gigi/11_cof_kiri.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#12_cof_tengah').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/12_cof_tengah.png') ?>" alt="12_cof_tengah"  >
                    <input type="hidden" id="12_cof_tengah" value="assets/img/assesment_gigi/12_cof_tengah.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#13_fis').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/13_fis.png') ?>" alt="13_fis"  >
                    <input type="hidden" id="13_fis" value="assets/img/assesment_gigi/13_fis.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#14_ano').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/14_ano.png') ?>" alt="14_ano"  >
                    <input type="hidden" id="14_ano" value="assets/img/assesment_gigi/14_ano.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#15_non').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/15_non.png') ?>" alt="15_non"  >
                    <input type="hidden" id="15_non" value="assets/img/assesment_gigi/15_non.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#16_pre').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/16_pre.png') ?>" alt="16_pre"  >
                    <input type="hidden" id="16_pre" value="assets/img/assesment_gigi/16_pre.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#17_une').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/17_une.png') ?>" alt="17_une"  >
                    <input type="hidden" id="17_une" value="assets/img/assesment_gigi/17_une.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#18_rotasi_atas').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/18_rotasi_atas.png') ?>" alt="18_rotasi_atas"  >
                    <input type="hidden" id="18_rotasi_atas" value="assets/img/assesment_gigi/18_rotasi_atas.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#19_rotasi_bawah').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/19_rotasi_bawah.png') ?>" alt="19_rotasi_bawah"  >
                    <input type="hidden" id="19_rotasi_bawah" value="assets/img/assesment_gigi/19_rotasi_bawah.png">
                </div>
               
            </div>



            <div class="flex justify-center">
                
               
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#1_dpn').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/1_dpn.png') ?>" alt="1_dpn"  >
                    <input type="hidden" id="1_dpn" value="assets/img/assesment_gigi/1_dpn.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#20_rotasi_migrasi').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/20_rotasi_migrasi.png') ?>" alt="20_rotasi_migrasi"  >
                    <input type="hidden" id="20_rotasi_migrasi" value="assets/img/assesment_gigi/20_rotasi_migrasi.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#21_rotasi_version').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/21_rotasi_version.png') ?>" alt="21_rotasi_version"  >
                    <input type="hidden" id="21_rotasi_version" value="assets/img/assesment_gigi/21_rotasi_version.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#22_cfr').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/22_cfr.png') ?>" alt="22_cfr"  >
                    <input type="hidden" id="22_cfr" value="assets/img/assesment_gigi/22_cfr.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#23_mis').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/23_mis.png') ?>" alt="23_mis"  >
                    <input type="hidden" id="23_mis" value="assets/img/assesment_gigi/23_mis.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#24_prd_fld').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/24_prd_fld.png') ?>" alt="24_prd_fld"  >
                    <input type="hidden" id="24_prd_fld" value="assets/img/assesment_gigi/24_prd_fld.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#25_rrx').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/25_rrx.png') ?>" alt="25_rrx"  >
                    <input type="hidden" id="25_rrx" value="assets/img/assesment_gigi/25_rrx.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#26_amf').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/26_amf.png') ?>" alt="26_amf"  >
                    <input type="hidden" id="26_amf" value="assets/img/assesment_gigi/26_amf.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#27_nvt').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/27_nvt.png') ?>" alt="27_nvt"  >
                    <input type="hidden" id="27_nvt" value="assets/img/assesment_gigi/27_nvt.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#28_rct').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/28_rct.png') ?>" alt="28_rct"  >
                    <input type="hidden" id="28_rct" value="assets/img/assesment_gigi/28_rct.png">
                </div>
                &nbsp;&nbsp;&nbsp;
            </div>


            <div class="flex justify-center">
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#29_amf_rct').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/29_amf_rct.png') ?>" alt="29_amf_rct"  >
                    <input type="hidden" id="29_amf_rct" value="assets/img/assesment_gigi/29_amf_rct.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#2_sou').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/2_sou.png') ?>" alt="2_sou"  >
                    <input type="hidden" id="2_sou" value="assets/img/assesment_gigi/2_sou.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#30_fmc_rct').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/30_fmc_rct.png') ?>" alt="30_fmc_rct"  >
                    <input type="hidden" id="30_fmc_rct" value="assets/img/assesment_gigi/30_fmc_rct.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#31_fmc').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/31_fmc.png') ?>" alt="31_fmc"  >
                    <input type="hidden" id="31_fmc" value="assets/img/assesment_gigi/31_fmc.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#32_ipx').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/32_ipx.png') ?>" alt="32_ipx"  >
                    <input type="hidden" id="32_ipx" value="assets/img/assesment_gigi/32_ipx.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#33_poc').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/33_poc.png') ?>" alt="33_poc"  >
                    <input type="hidden" id="33_poc" value="assets/img/assesment_gigi/33_poc.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#34_poc_rct').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/34_poc_rct.png') ?>" alt="34_poc_rct"  >
                    <input type="hidden" id="34_poc_rct" value="assets/img/assesment_gigi/34_poc_rct.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#3_car').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/3_car.png') ?>" alt="3_car"  >
                    <input type="hidden" id="3_car" value="assets/img/assesment_gigi/3_car.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#4_car').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/4_car.png') ?>" alt="4_car"  >
                    <input type="hidden" id="4_car" value="assets/img/assesment_gigi/4_car.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#5_l').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/5_l.png') ?>" alt="5_l"  >
                    <input type="hidden" id="5_l" value="assets/img/assesment_gigi/5_l.png">
                </div>
            </div>

            <div class="flex justify-center">
               
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#6_lv').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/6_lv.png') ?>" alt="6_lv"  >
                    <input type="hidden" id="6_lv" value="assets/img/assesment_gigi/6_lv.png">
                </div>
                &nbsp;&nbsp;&nbsp;
                <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#7_m_car').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/7_m_car.png') ?>" alt="7_m_car"  >
                    <input type="hidden" id="7_m_car" value="assets/img/assesment_gigi/7_m_car.png">
                </div>
               &nbsp;&nbsp;&nbsp;
               <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#8_cof_atas').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/8_cof_atas.png') ?>" alt="8_cof_atas"  >
                    <input type="hidden" id="8_cof_atas" value="assets/img/assesment_gigi/8_cof_atas.png">
                </div>
               &nbsp;&nbsp;&nbsp;
               <div class="gigi flex justify-center flex-column align-center">
                    <img onclick="changeValue($('#id_gigi').val(),$('#9_cof_bawah').val(),$('#posisi').val())" width="50px" src="<?= base_url('assets/img/assesment_gigi/9_cof_bawah.png') ?>" alt="9_cof_bawah"  >
                    <input type="hidden" id="9_cof_bawah" value="assets/img/assesment_gigi/9_cof_bawah.png">
                </div>
               &nbsp;&nbsp;&nbsp;

            </div>
            
            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- end modal -->


<script>


$(document).ready(function(){
    
});

</script>