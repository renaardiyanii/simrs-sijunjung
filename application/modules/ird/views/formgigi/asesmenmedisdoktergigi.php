<div class="row">
    <div class="col">
        <!-- 11 (51) -->
        <?= inputrow('11 (51)','gigi_1151',($gigi)?isset($gigi->gigi_1151)?$gigi->gigi_1151:null:null); ?>
        <!-- 11 (51) -->
        <?= inputrow('12 (52)','gigi_1251',($gigi)?isset($gigi->gigi_1251)?$gigi->gigi_1251:null:null); ?>
        <?= inputrow('13 (53)','gigi_1353',($gigi)?isset($gigi->gigi_1353)?$gigi->gigi_1353:null:null); ?>
        <?= inputrow('14 (54)','gigi_1454',($gigi)?isset($gigi->gigi_1454)?$gigi->gigi_1454:null:null); ?>
        <?= inputrow('15 (55)','gigi_15',($gigi)?isset($gigi->gigi_15)?$gigi->gigi_15:null:null); ?>
        <?= inputrow('16','gigi_16',($gigi)?isset($gigi->gigi_16)?$gigi->gigi_16:null:null); ?>
        <?= inputrow('17','gigi_17',($gigi)?isset($gigi->gigi_17)?$gigi->gigi_17:null:null); ?>
        <?= inputrow('18','gigi_18',($gigi)?isset($gigi->gigi_18)?$gigi->gigi_18:null:null); ?>
    </div>
    <div class="col">
        <!-- 11 (51) -->
        <?= inputrowrightlabel('(61) 21','gigi_6121',($gigi)?isset($gigi->gigi_6121)?$gigi->gigi_6121:null:null); ?>
        <!-- 11 (51) -->
        <?= inputrowrightlabel('(62) 22','gigi_6222',($gigi)?isset($gigi->gigi_6222)?$gigi->gigi_6222:null:null); ?>
        <?= inputrowrightlabel('(63) 23','gigi_6323',($gigi)?isset($gigi->gigi_6323)?$gigi->gigi_6323:null:null); ?>
        <?= inputrowrightlabel('(64) 24','gigi_6424',($gigi)?isset($gigi->gigi_6424)?$gigi->gigi_6424:null:null); ?>
        <?= inputrowrightlabel('(65) 25','gigi_25',($gigi)?isset($gigi->gigi_25)?$gigi->gigi_25:null:null); ?>
        <?= inputrowrightlabel('26','gigi_26',($gigi)?isset($gigi->gigi_26)?$gigi->gigi_26:null:null); ?>
        <?= inputrowrightlabel('27','gigi_27',($gigi)?isset($gigi->gigi_27)?$gigi->gigi_27:null:null); ?>
        <?= inputrowrightlabel('28','gigi_28',($gigi)?isset($gigi->gigi_28)?$gigi->gigi_28:null:null); ?>
    </div>
</div>

<?php include('carddiagnosa.php'); ?> 
<!-- <div id="surveyContainerGigi"></div> -->
<!-- <button type="button" onclick="alert('Masih Dalam Tahap Pengembangan')" class="btn btn-success mb-4">Clear</button> -->

<div class="row mb-3">
    <div class="col">
        <!-- 11 (51) -->
        <?= inputrow('48','gigi_48',($gigi)?isset($gigi->gigi_48)?$gigi->gigi_48:null:null); ?>
        <!-- 11 (51) -->
        <?= inputrow('47','gigi_47',($gigi)?isset($gigi->gigi_47)?$gigi->gigi_47:null:null); ?>
        <?= inputrow('46','gigi_46',($gigi)?isset($gigi->gigi_46)?$gigi->gigi_46:null:null); ?>
        <?= inputrow('45 (85)','gigi_45',($gigi)?isset($gigi->gigi_45)?$gigi->gigi_45:null:null); ?>
        <?= inputrow('44 (84)','gigi_44',($gigi)?isset($gigi->gigi_44)?$gigi->gigi_44:null:null); ?>
        <?= inputrow('43 (83)','gigi_43',($gigi)?isset($gigi->gigi_43)?$gigi->gigi_43:null:null); ?>
        <?= inputrow('42 (82)','gigi_42',($gigi)?isset($gigi->gigi_42)?$gigi->gigi_42:null:null); ?>
        <?= inputrow('41 (81)','gigi_41',($gigi)?isset($gigi->gigi_41)?$gigi->gigi_41:null:null); ?>
    </div>
    <div class="col">
        <?= inputrowrightlabel('38','gigi_38',($gigi)?isset($gigi->gigi_38)?$gigi->gigi_38:null:null); ?>
        <?= inputrowrightlabel('37','gigi_37',($gigi)?isset($gigi->gigi_37)?$gigi->gigi_37:null:null); ?>
        <?= inputrowrightlabel('36','gigi_36',($gigi)?isset($gigi->gigi_36)?$gigi->gigi_36:null:null); ?>
        <?= inputrowrightlabel('75 (35)','gigi_35',($gigi)?isset($gigi->gigi_35)?$gigi->gigi_35:null:null); ?>
        <?= inputrowrightlabel('74 (34)','gigi_74',($gigi)?isset($gigi->gigi_74)?$gigi->gigi_74:null:null); ?>
        <?= inputrowrightlabel('73 (33)','gigi_73',($gigi)?isset($gigi->gigi_73)?$gigi->gigi_73:null:null); ?>
        <?= inputrowrightlabel('72 (32)','gigi_72',($gigi)?isset($gigi->gigi_72)?$gigi->gigi_72:null:null); ?>
        <?= inputrowrightlabel('71 (31)','gigi_71',($gigi)?isset($gigi->gigi_71)?$gigi->gigi_71:null:null); ?>
    </div>
</div>

<table width="100%" border="1">
    <tr>
        <!-- Accolusi -->
        <td width="25%">
            <?= 
            inputcolwithradio('Accolusi : ',
                '
                '.radiobutton('Normal Bite','accolusi','accolusi1','normal_bite',($gigi)?isset($gigi->accolusi)?$gigi->accolusi== 'normal_bite'?'checked':null:null:null).'
                '.radiobutton('Cross Bite','accolusi','accolusi2','cross_bite',($gigi)?isset($gigi->accolusi)?$gigi->accolusi == 'cross_bite'?'checked':null:null:null).'
                '.radiobutton('Sleep Bite','accolusi','accolusi3','sleep_bite',($gigi)?isset($gigi->accolusi)?$gigi->accolusi == 'sleep_bite'?'checked':null:null:null).'
            ') 
            ?>
        </td>
        <!-- Torus Palatinus -->
        <td width="25%">
            <?= 
            inputcolwithradio('Torus Palatinus : ',
                '
                '.radiobutton('Tidak ada','torus_palatinus','torus_palatinus1','tidak_ada',($gigi)?isset($gigi->torus_palatinus)?$gigi->torus_palatinus == 'tidak_ada'?'checked':null:null:null).'
                '.radiobutton('Kecil','torus_palatinus','torus_palatinus2','kecil',($gigi)?isset($gigi->torus_palatinus)?$gigi->torus_palatinus == 'kecil'?'checked':null:null:null).'
                '.radiobutton('Sedang','torus_palatinus','torus_palatinus3','sedang',($gigi)?isset($gigi->torus_palatinus)?$gigi->torus_palatinus == 'sedang'?'checked':null:null:null).'
                '.radiobutton('Besar','torus_palatinus','torus_palatinus4','besar',($gigi)?isset($gigi->torus_palatinus)?$gigi->torus_palatinus == 'besar'?'checked':null:null:null).'
                '.radiobutton('Multiple','torus_palatinus','torus_palatinus5','multiple',($gigi)?isset($gigi->torus_palatinus)?$gigi->torus_palatinus == 'multiple'?'checked':null:null:null).'
            ') 
            ?>
        </td>

        <!-- Torus Mandibularis -->
        <td width="25%">
            <?= 
            inputcolwithradio('Torus Mandibularis : ',
                '
                '.radiobutton('Tidak ada','torus_mandibularis','torus_mandibularis1','tidak_ada',($gigi)?isset($gigi->torus_mandibularis)?$gigi->torus_mandibularis == 'tidak_ada'?'checked':null:null:null).'
                '.radiobutton('Sisi Kanan','torus_mandibularis','torus_mandibularis2','sisi_kanan',($gigi)?isset($gigi->torus_mandibularis)?$gigi->torus_mandibularis== 'sisi_kanan'?'checked':null:null:null).'
                '.radiobutton('Sisi Kiri','torus_mandibularis','torus_mandibularis3','sisi_kiri',($gigi)?isset($gigi->torus_mandibularis)?$gigi->torus_mandibularis == 'sisi_kiri'?'checked':null:null:null).'
                '.radiobutton('Kedua Sisi','torus_mandibularis','torus_mandibularis4','kedua_sisi',($gigi)?isset($gigi->torus_mandibularis)?$gigi->torus_mandibularis== 'kedua_sisi'?'checked':null:null:null).'
            ') 
            ?>
        </td>

        <!-- Palatum -->
        <td width="25%">
            <?= 
            inputcolwithradio('Palatum : ',
                '
                '.radiobutton('Dalam','palatum','palatum1','dalam',($gigi)?isset($gigi->palatum)?$gigi->palatum  == 'dalam'?'checked':null:null:null).'
                '.radiobutton('Sedang','palatum','palatum2','sedang',($gigi)?isset($gigi->palatum)?$gigi->palatum  == 'sedang'?'checked':null:null:null).'
                '.radiobutton('Rendah','palatum','palatum3','rendah',($gigi)?isset($gigi->palatum)?$gigi->palatum  == 'rendah'?'checked':null:null:null).'
            ') 
            ?>
        </td>
    </tr>
    <tr>
        <!-- Diastema -->
        <td width="25%">
            <?= 
            inputcolwithradio('Diastema : ',
                '
                '.radiobutton('Tidak Ada','diastema','diastema1','tidak_ada',($gigi)?isset($gigi->diastema)?$gigi->diastema == 'tidak_ada'?'checked':null:null:null).'
                '.radiobutton('Ada','diastema','diastema2','ada',($gigi)?isset($gigi->diastema)?$gigi->diastema != 'tidak_ada'?'checked':null:null:null).'
            ') 
            ?>
            <?= inputtext2('diastema_value',isset($gigi->diastema)?$gigi->diastema !='tidak_ada'?$gigi->diastema:null:null); ?>
        </td>
        <td width="25%">
            <?php 
            echo inputcolwithradio('Gigi Anomali : ') ;
            echo radiobutton('Tidak ada','gigi_anomali','gigianomali1','tidak_ada',isset($gigi->gigi_anomali)?$gigi->gigi_anomali == 'tidak_ada'?'checked':null:null);
            echo radiobutton('ada,(dijelaskan dimana berupa lebarnya)','gigi_anomali','gigianomali2','ada',isset($gigi->gigi_anomali )?$gigi->gigi_anomali!= 'tidak_ada'?'checked':null:null);
            ?>
            <?= inputtext2('gigianomali_value',isset($gigi->gigi_anomali )?$gigi->gigi_anomali!= 'tidak_ada'?$gigi->gigi_anomali:null:null); ?>

            
        </td>
        <td colspan="2">
        <?= inputcolwithradio('Lain - Lain (hal yang tidak tercakup) : ') ; ?>
        <?= inputtext2('lainlain',($gigi)?isset($gigi->lainlain)?$gigi->lainlain:null:null); ?>
        
        </td>
        
    </tr>

</table>

<div class="row mt-3 mb-3">
    <div class="col">
        <div class="row">
            <div class="col">
                <?= inputcolwithradio('D : ') ; ?>
                <?= inputtext2('d',($gigi)?isset($gigi->d)?$gigi->d:null:null); ?>
            </div>
            <div class="col">
                <?= inputcolwithradio('M : ') ; ?>
                <?= inputtext2('m',($gigi)?isset($gigi->m)?$gigi->m:null:null); ?>
            </div>
            <div class="col">
                <?= inputcolwithradio('F : ') ; ?>
                <?= inputtext2('f',($gigi)?isset($gigi->f)?$gigi->f:null:null); ?>
            </div>
        </div>
    </div>
    <div class="col">
        <?= inputcolwithradio('Jumlah Foto Yang Diambil : ') ; ?>
        <?= inputtext2('jumlah_foto_yang_diambil',($gigi)?isset($gigi->jumlah_foto_yang_diambil)?$gigi->jumlah_foto_yang_diambil:null:null); ?>
        <div class="row-sm-2">
            <?php
                echo radiobutton('Digital','jumlah_foto_yang_diambil_type','jmlpoto1','digital',isset($gigi->jumlah_foto_yang_diambil_type)?$gigi->jumlah_foto_yang_diambil_type == 'digital'?'checked':null:null);
                echo radiobutton('Introral','jumlah_foto_yang_diambil_type','jmlpoto2','introral',isset($gigi->jumlah_foto_yang_diambil_type)?$gigi->jumlah_foto_yang_diambil_type == 'introral'?'checked':null:null);
            ?>
        </div>
    </div>
    <div class="col">
        <?= inputcolwithradio('Jumlah Rontgen Yang Diambil : ') ; ?>
        <?= inputtext2('jumlah_rontgen_yang_diambil',isset($gigi->jumlah_rontgen_yang_diambil)?$gigi->jumlah_rontgen_yang_diambil:null); ?>
        <div class="row-sm-2">
            <?php
                echo radiobutton('Dental','jumlah_rontgen_yang_diambil_type','rontgen1','dental',isset($gigi->jumlah_rontgen_yang_diambil_type)?$gigi->jumlah_rontgen_yang_diambil_type == 'dental'?'checked':null:null);
                echo radiobutton('PA','jumlah_rontgen_yang_diambil_type','rontgen2','pa',isset($gigi->jumlah_rontgen_yang_diambil_type) ?$gigi->jumlah_rontgen_yang_diambil_type== 'pa'?'checked':null:null);
                echo radiobutton('OPG','jumlah_rontgen_yang_diambil_type','rontgen3','opg',isset($gigi->jumlah_rontgen_yang_diambil_type) ?$gigi->jumlah_rontgen_yang_diambil_type== 'pa'?'checked':null:null);
                echo radiobutton('Ceph','jumlah_rontgen_yang_diambil_type','rontgen4','ceph',isset($gigi->jumlah_rontgen_yang_diambil_type )?$gigi->jumlah_rontgen_yang_diambil_type== 'pa'?'checked':null:null);
            ?>
        </div>
    </div>
</div>
    