<?php
$this->load->view('layout/header_form');
?>
<style>

</style>
<div class="card">

    <div class="body">
        <div id="SurveyKartuIntruksiObat"></div>
    </div>
</div>

<!-- <div class="card m-5">
    <div class="card-header">
        <h5>Riwayat Kartu Intruksi Obat</h5>
    </div>
    <div class="card-body">
        <table class="table table-hover table-striped table-bordered datatable" id="dataTables-assesment" style="width:100%;" style="table-layout: fixed;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Obat</th>
                    <th>Dosis</th>
                    <th>Frekuensi</th>
                    <th>Rute</th>
                    <th>Cara Pakai</th>
                    <th>Dokter</th>
                    <th>Tgl Pemeriksaan</th>
                    <th>Stop</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $i = 1;
                if ($intruksi_obat->num_rows()) {
                    $penampung_obat = [];
                    $obat = [];
                    foreach ($intruksi_obat->result() as $value) {
                        $json_value = json_decode($value->kio);
                        foreach ($json_value->question2 as $val) {
                            if(!isset($val->obat_luar)){
                                if(isset($val->nm_obat)){
                                    // jika penampung obat ada 
                                    if (count($obat) != 0) {
                                        if (!in_array($val->nm_obat, $obat)) {
                                            array_push($penampung_obat, [
                                                'nm_obat' => $val->nm_obat ?? '-',
                                                'dosis' => $val->dosis ?? "-",
                                                'frekuensi' => $val->frekuensi ?? '-',
                                                'rute' => $val->rute ?? '-',
                                                'cara_pakai' => $val->cara_pakai ?? '-',
                                                'paraf_dok' => $val->paraf_dok ?? '-',
                                                'tgl_resep' => $value->tgl_resep ?? '-',
                                                'tglstop' => $val->tglstop ?? '-',
                                            ]);
                                            array_push($obat, $val->nm_obat);
                                        } else if (in_array($val->nm_obat, $obat)) {
                                            $index = array_search($val->nm_obat, $obat);
                                            if (isset($val->tglstop)) {
                                                $penampung_obat[$index]['tglstop'] = $val->tglstop;
                                            }
                                        }
                                    } else {
                                        // jika penampung obat kosong, langsung tambahkan
                                        array_push($penampung_obat, [
                                            'nm_obat' => $val->nm_obat ?? '-',
                                            'dosis' => $val->dosis ?? "-",
                                            'frekuensi' => $val->frekuensi ?? '-',
                                            'rute' => $val->rute ?? '-',
                                            'cara_pakai' => $val->cara_pakai ?? '-',
                                            'paraf_dok' => $val->paraf_dok ?? '-',
                                            'tgl_resep' => $value->tgl_resep ?? '-',
                                            'tglstop' => $val->tglstop ?? '-',
                                        ]);
                                        array_push($obat, $val->nm_obat);
                                    }
                                }
                            }else{
                                // disini obat luar / igd
                                if (count($obat) != 0) {
                                    if (!in_array($val->obat_luar, $obat)) {
                                        array_push($penampung_obat, [
                                            'nm_obat' => $val->obat_luar ?? '-',
                                            'dosis' => $val->dosis ?? "-",
                                            'frekuensi' => $val->frekuensi ?? '-',
                                            'rute' => $val->rute ?? '-',
                                            'cara_pakai' => $val->cara_pakai ?? '-',
                                            'paraf_dok' => $val->paraf_dok ?? '-',
                                            'tgl_resep' => $value->tgl_resep ?? '-',
                                            'tglstop' => $val->tglstop ?? '-',
                                        ]);
                                        array_push($obat, $val->obat_luar);
                                    } else if (in_array($val->obat_luar, $obat)) {
                                        $index = array_search($val->obat_luar, $obat);
                                        if (isset($val->tglstop)) {
                                            $penampung_obat[$index]['tglstop'] = $val->tglstop;
                                        }
                                    }
                                } else {
                                    // jika penampung obat kosong, langsung tambahkan
                                    array_push($penampung_obat, [
                                        'nm_obat' => $val->obat_luar ?? '-',
                                        'dosis' => $val->dosis ?? "-",
                                        'frekuensi' => $val->frekuensi ?? '-',
                                        'rute' => $val->rute ?? '-',
                                        'cara_pakai' => $val->cara_pakai ?? '-',
                                        'paraf_dok' => $val->paraf_dok ?? '-',
                                        'tgl_resep' => $value->tgl_resep ?? '-',
                                        'tglstop' => $val->tglstop ?? '-',
                                    ]);
                                    array_push($obat, $val->obat_luar);
                                }
                            }
                        }
                    }
                ?>
                    <?php
                    $int = 1;
                    foreach ($penampung_obat as $val) {
                    ?>
                        <tr>
                            <td><?= $int; ?></td>
                            <td><?= $val['nm_obat']; ?></td>
                            <td><?= $val['dosis']; ?></td>
                            <td><?= $val['frekuensi']; ?></td>
                            <td><?= $val['rute']; ?></td>
                            <td><?= $val['cara_pakai']; ?></td>
                            <td><?= isset(explode('-',$val['paraf_dok'])[0])?explode('-',$val['paraf_dok'])[0]:'-'; ?></td>
                            <td><?= $val['tgl_resep']; ?></td>
                            <td><?= $val['tglstop']; ?></td>
                        </tr>
                    <?php
                        $int++;
                    } ?>
                <?php
                } else {
                ?>
                    <tr>
                        <td style="text-align:center;" colspan="6">Tidak ada Data</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div> -->

<div class="modal fade" id="paketobat" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-success">
    
        <!-- Modal content-->
        <div class="modal-content">
            <form id="paketobatForm">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                <h4 class="modal-title">Paket Obat</h4>
            </div>
            <table id="obat_paket" class=" table display table-hover table-bordered table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama paket</th>
                        
                    </tr>
                </thead>
                <?php foreach ($paket_obat as $key) { ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="jumlah_paket[]" id="<?php echo $key->id_paket; ?>" value="<?php echo $key->id_paket; ?>">
                            <label for="<?php echo $key->id_paket; ?>"></label>
                        </td>
                        <td><label><?= $key->nama_paket ?></label></td>
                        <td>
                        
                    </tr>
                <?php } ?>
            </table>
            <div class="form-group row">
                <div class="col-sm-2">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-primary" id="brnFormPaketObat" onclick="parsingpaketobat()" type="button">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.datatable').DataTable();
    })
    Survey.CustomWidgetCollection.Instance.setActivatedBy("select2", "type");
    Survey.StylesManager.applyTheme("modern");

    surveyJSONKIO = <?php echo file_get_contents("kio.json", FILE_USE_INCLUDE_PATH); ?>;

    function sendDataToServerKIO(survey) {

          // jika data lebih dari 1
          if (survey.data.question2.length > 0) {
            survey.data.question2.map((e, index) => {
                // jika belom stop , jangan ditambahkan. 
                // jika sudah ada tgl Stop , jgn ditambahkan.
                if (survey.data.question2[index].tglstop == undefined) {
                    // jika ada stop , maka tambahkan tgl sekarang
                    if (survey.data.question2[index].stop != undefined) {
                        let yourDate = new Date()

                        survey.data.question2[index].tglstop = yourDate.toISOString().split('T')[0];
                    }
                }
            })
        }

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/KIO_resep/') ?>',
            data: {
                no_ipd: '<?php echo $no_ipd; ?>',
                kio_json: JSON.stringify(survey.data),
            },
            success: function(data) {

                // location.reload();


            },
            error: function(data) {

            }
        });
        // console.log(JSON.stringify(survey.data));

    }


    var survey_kartu_intruksi_obat = new Survey.Model(surveyJSONKIO);


    <?php

	    if($kio_today != null){ ?> 

		survey_kartu_intruksi_obat.data = <?= isset($kio_today->kio)?$kio_today->kio:null ?>;

	<?php } else if($kio_today == null && $kio_resep == null){
 
    ?>
        survey_kartu_intruksi_obat.data = {
            "question2": [

                <?php foreach ($kio_igd as $obatigd) {
                    // kalo ini bukan obat luar
                    if(isset($obatigd->id_obat)){
                    ?>
                    {
                        "nm_obat": "<?php echo $obatigd->nm_obat . '@' . $obatigd->id_obat ?>",
                        "qty":"<?= $obatigd->qty??"" ?>",
                        "frekuensi":"<?= $obatigd->kali_harian??"" ?>",
                        "cara_pakai":"<?= $obatigd->signa??'' ?>",
                    },
                <?php 
                    }else{ 
                        if(!$obatigd->obat_racikan){
                        ?>
                    // Ini Obat Luar
                    {
                        "obat_luar":"<?= $obatigd->nama_obat??'' ?>",
                        "frekuensi":"<?= $obatigd->kali_harian??"" ?>",
                        "cara_pakai":"<?= $obatigd->cara_pakai??'' ?>"
                    },

                        <?php }
                    }
                }
                foreach($racikan as $v){
                   ?>
                   {
                        "nm_obat": "<?php echo $v->nama_obat . '@' . $v->item_obat ?>",
                        "catatan":"OBAT RACIKAN"
                   },
                   <?php } ?>

            ]
        };
    <?php } else{ ?>
        let jsonData = <?= isset($kio_resep->kio) ? $kio_resep->kio : null ?>;
        if (jsonData) {
            if (jsonData.question2.length > 0) {
                jsonData.question2.map((e, index) => {
                    if (e.tglstop == undefined) {
                        return;
                    }
                    jsonData.question2.splice(index, 1);
                })
            }
        }
        survey_kartu_intruksi_obat.data = jsonData;
    <?php } ?>

    // survey_ews.showNavigationButtons = false;







    // survey.css = myCss;
    $("#SurveyKartuIntruksiObat").Survey({
        model: survey_kartu_intruksi_obat,
        onComplete: sendDataToServerKIO
    });

    const delay = ms => new Promise(res => setTimeout(res, ms));
    const parsingpaketobat = async ()=>
    {
        let position = survey_kartu_intruksi_obat.getQuestionByName('question2').value.length;

        let data = $("#paketobatForm").serializeArray();
        let model = [];
        data.map((e)=>{
            $.ajax({
                url: '<?= base_url('iri/rictindakan/get_paket_obat/') ?>/'+e.value,
                beforeSend:function(val){
                    $("#brnFormPaketObat").html('Loading...');
                    $("#brnFormPaketObat").attr('disabled',true);
                },
                success: function(res) {
                    res.map((v)=>{
                        

                        // model.push(   {
                        survey_kartu_intruksi_obat.getQuestionByName('question2').koAddRowClick();
                        survey_kartu_intruksi_obat.getQuestionByName('question2').setRowValue(position,{'nm_obat':v.nama_obat+'-'+v.id_obat});

                            
                        // );
                        // v.id_obat
                        // v.nama_obat
                        position++;
                    })
                },
                error: function(data) {
    
                },
                complete: function(_){
                   
                }
            });

        });
        $("#brnFormPaketObat").html('Simpan');
        $("#brnFormPaketObat").attr('disabled',false);
        $("#paketobat").modal('hide');
    }
    
    // $('.select2-hidden-accessible')[0].focus();
</script>
<div class="card m-5">
	<div class="card-header">
		<h5>Riwayat Obat IGD Pasien</h5>
	</div>
        <div class="card-body">

            <div class="table-responsive m-t-0">
                <table id="tabel_resep" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th>Tanggal</th>
                        <th>Nama Obat</th>
                        <th>Signa</th>
                        <th>Biaya Obat</th>
                        <th>Qty</th>
                        <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_bayar = 0;
                        if(!empty($kio_igd)){
                         
                            foreach($kio_igd as $r){ ?>
                            <tr>
                                <td><?php echo date('d-m-Y',strtotime($r->tgl_kunjungan)) ; ?></td>
                                <td><?php echo $r->nm_obat ; ?></td>
                                <td><?php echo $r->signa ; ?></td>
                                <td>Rp. <?php echo number_format($r->biaya_obat,0) ; ?></td>
                                <td><?php echo $r->qty ; ?></td>
                                <td>Rp. <?php echo number_format($r->vtot_obat,0) ; ?></td>
                                <?php $total_bayar = $total_bayar + $r->vtot_obat;?>
                            </tr>
                                     <?php
                                        }
                                   
                                         }else{ 
                                        ?>
                                        <tr>
                                                <td colspan="7">Data Kosong</td>
                                            </tr>
                                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
</div>

<div class="card m-5">
	<div class="card-header">
		<h5>Riwayat Obat Pasien</h5>
	</div>
        <div class="card-body">

            <div class="table-responsive m-t-0">
                <table id="tabel_resep" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                        <th>No Resep</th>
                        <th>Tanggal</th>
                        <th>Nama Obat</th>
                        <!-- <th>Tgl Tindakan</th> -->
                        <th>Signa</th>
                        <th>Biaya Obat</th>
                        <th>Qty</th>
                        <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_bayar = 0;
                        if(!empty($list_resep_pasien)){
                            if($data_pasien[0]['obat'] == '1'){
                            foreach($list_resep_pasien as $r){ ?>
                            <tr>
                                <td><?php echo $r->no_resep ; ?></td>
                                <td><?php echo date('d-m-Y',strtotime($r->tgl_kunjungan)) ; ?></td>
                                <td><?php echo $r->nama_obat ; ?></td>
                                <!-- <td><?php //echo isset($r->tgl_kunjungan)?date('d-m-Y',strtotime($r->tgl_kunjungan)):'-'?></td> -->
                                <td><?php echo $r->signa ; ?></td>
                                <td>Rp. <?php echo number_format($r->biaya_obat,0) ; ?></td>
                                <td><?php echo $r->qty ; ?></td>
                                <td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
                                <?php $total_bayar = $total_bayar + $r->vtot;?>
                            </tr>
                            <?php
                                        }
                                    }else{
                                        foreach($list_resep_pasien as $r){ 
                                            if(isset($r->no_resep) != null){  ?>
                                                <tr>
                                                    <td><?php echo $r->no_resep ; ?></td>
                                                    <td><?php echo $r->nama_obat ; ?></td>
                                                    <td><?= isset($r->tgl_kunjungan)?date('d-m-Y',strtotime($r->tgl_kunjungan)):'-'?></td>
                                                    <td><?php echo $r->signa ; ?></td>
                                                    <td>Rp. <?php echo number_format($r->biaya_obat,0) ; ?></td>
                                                    <td><?php echo $r->qty ; ?></td>
                                                    <td>Rp. <?php echo number_format($r->vtot,0) ; ?></td>
                                                    <?php $total_bayar = $total_bayar + $r->vtot;?>
                                                </tr>
                                                <?php }else{ ?>	<tr>
                                            <td colspan="7">Data Kosong</td>
                                            <!-- <td>Data Kosong</td>
                                            <td>Data Kosong</td>
                                            <td>Data Kosong</td>
                                            <td>Data Kosong</td>
                                            <td>Data Kosong</td>
                                            <td>Data Kosong</td> -->
                                        </tr>
                                        <?php } }
                                        } }else{ 
                                        ?>
                                        <tr>
                                                <td colspan="7">Data Kosong</td>
                                                <!-- <td>Data Kosong</td>
                                                <td>Data Kosong</td>
                                                <td>Data Kosong</td>
                                                <td>Data Kosong</td>
                                                <td>Data Kosong</td>
                                                <td>Data Kosong</td> -->
                                            </tr>
                                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </div>
</div>