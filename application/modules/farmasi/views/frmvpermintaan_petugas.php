<?php
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_left");
}
?>
<style>
    #notifications {
        cursor: pointer;
        position: fixed;
        right: 0px;
        z-index: 9999;
        top: 100px;
        margin-bottom: 22px;
        margin-right: 15px;
        max-width: 300px;
    }
</style>
<script src="<?= base_url('assets/notify.js') ?>"></script>
<script src="<?php echo site_url('assets/plugins/jquery/jquery-ui.min.js'); ?>"></script>
<?= $this->session->flashdata('warning') ?>
<?= $this->session->flashdata('info') ?>

<div id="notifications"></div>
<div class="row">

    <div class="col-sm-4">
        <div class="ribbon-wrapper card">
            <div class="ribbon ribbon-info">Data Pasien
            </div>

            <div class="ribbon-content">
                <div class="p-20">
                    <div class="row">
                        <table class="table-sm table-striped" style="font-size:15" width="100%">
                            <tbody>
                                <tr>
                                    <th>Nama</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien_resep->nama; ?></td>
                                </tr>
                                <tr>
                                    <th>No. Register</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $no_register; ?></td>
                                </tr>
                                <tr>
                                    <th style="width: 30%;">Tanggal Kunjungan</th>
                                    <td style="width: 5%;">:</td>
                                    <td><?php echo date('d F Y', strtotime($data_pasien_resep->tgl_kunjungan)); ?></td>
                                </tr>
                                <tr>
                                    <th>Cara Bayar</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien_resep->cara_bayar; ?></td>
                                </tr>
                                <?php
                                if ($nmkontraktor != "") {
                                ?>
                                    <tr>
                                        <th></th>
                                        <td> &nbsp;</td>
                                        <td><?php echo $nmkontraktor; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>

                                <tr>
                                    <th>Dokter</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $nmdokter; ?></td>

                                    <?php
                                    if (substr($no_register, 0, 2) == "PL") {
                                    ?>
                                <tr>
                                    <th colspan=3>Pasien Luar</th>
                                </tr>
                            <?php
                                    } else if (substr($no_register, 0, 2) == "RJ") {
                            ?>
                                <tr>
                                    <th>No. CM</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien_resep->no_cm; ?></td>
                                </tr>
                                <tr>
                                    <th>Unit</th>
                                    <td>:&nbsp;</td>
                                    <th colspan=3>Pasien Rawat Jalan</th>
                                </tr>
                                <tr>
                                    <th>Id Poli</th>
                                    <td>:&nbsp;</td>
                                    <th colspan=3><?= $data_pasien_resep->idrg; ?></th>
                                </tr>
                                <tr>
                                    <th>Poliklinik</th>
                                    <td>:&nbsp;</td>
                                    <th colspan=3><?= $data_pasien_resep->bed; ?></th>
                                </tr>

                            <?php
                                    } else if (substr($no_register, 0, 2) == "RD") {
                            ?>
                                <tr>
                                    <th>No. CM</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien_resep->no_cm; ?></td>
                                </tr>
                                <tr>
                                    <th>Unit</th>
                                    <td>:&nbsp;</td>
                                    <th colspan=3>Pasien Rawat Darurat</th>
                                </tr>

                            <?php
                                    } else {
                            ?>
                                <tr>
                                    <th>No. CM</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien_resep->no_cm; ?></td>
                                </tr>
                                <tr>
                                    <th>Kelas</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien_resep->kelas; ?></td>
                                </tr>
                                <tr>
                                    <th>ID Ruangan</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien_resep->idrg; ?></td>
                                </tr>
                                <tr>
                                    <th>Bed</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien_resep->bed; ?></td>
                                </tr>

                            <?php
                                    }
                            ?>

                                <tr>
                                    <th>No. BPJS</th>
                                    <td>:&nbsp;</td>
                                    <th colspan=3><?= $data_pasien_resep->no_kartu; ?></th>
                                </tr>
                                <tr>
                                    <th colspan ="3">
                                    <a class="btn btn-primary" href="<?php echo site_url('emedrec/C_emedrec/rekam_medik_detail/' . $data_pasien_resep->no_cm . '/' . $data_pasien_resep->no_medrec); ?>" target="_blank"><i class="fa fa-binoculars">&nbsp; Rekam Medik Elektronik</i> </a>&nbsp;&nbsp;&nbsp;
                                    <a class="btn btn-danger" href="<?php echo site_url('medrec/el_record/pasien/' . $data_pasien_resep->no_cm.'/'.$data_pasien_resep->no_medrec ); ?>" target="_blank"><i class="fa fa-binoculars">&nbsp; Rekam Medik</i> </a>&nbsp;&nbsp;&nbsp;
                                    </th>
                                   
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="ribbon-wrapper card" style="min-height:61vh;">
            <div class="ribbon ribbon-info">Order Dokter</div>
            <div class="ribbon-content">
                <div class="table-responsive">
                    <table id="table_dokter" class="table table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Aksi</th>
                                <th>Item Obat</th>
                                <?php 
                                if($id_poli == 'BA00'){ ?>
                                <th>Jam Order</th>
                               <?php  }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $total = 0;
                            foreach ($data_tindakan_pasien_dokter as $row) { ?>
                                <tr id="<?= $row->id_resep_dokter ?>">
                                    <td><?php echo $i++; ?></td>
                                    <td><button type="button" class="btn btn-primary" onclick='terapkandata(<?= json_encode($row) ?>)'>Resepkan Obat</button></td>
                                    <td>
                                        <?php
                                        
                                        if ($row->racikan == '1') {
                                            echo $row->nm_obat.'<br>';
                                            foreach ($data_tindakan_racik as $row1) {
                                                if ($row->id_resep_dokter == $row1->id_resep_dokter) {
                                                    echo '- ' . $row1->nama_obat . ' Dosis ' . $row1->dosis . ', Satuan ' . $row1->satuan . ' (' . $row1->qty . ')<br>';
                                                }
                                            }
                                        } else {
                                            echo $row->nm_obat;
                                            echo "($row->signa, Qty: $row->qty)";
                                        }
                                        ?>
                                    </td>
                                    <?php 
                                        if($id_poli == 'BA00'){ ?>
                                        <td><?= $row->jam_order; ?></td>
                                    <?php  }
                                        ?>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="col-12">
        <div class="ribbon-wrapper card">
            <div class="d-flex justify-content-end">
                <div class="ribbon ribbon-info">Resep Pasien</div>
                <button id="save-btn-resep" class="btn btn-primary " onclick="simpanresep()"><i class="mdi mdi-file-document-box mr-2"></i>Simpan Resep</button>
            </div>

            <div class="ribbon-content">
                <form id="form_resep_pasien">
                    <input type="hidden" name="no_medrec" value="<?php echo $data_pasien_resep->no_medrec; ?>">
                    <input type="hidden" name="nm_dokter" value="<?php echo $nmdokter; ?>">
                    <input type="hidden" name="tgl_kunjungan" value="<?= $data_pasien_resep->tgl_kunjungan ?>">
                    <input type="hidden" name="no_register" value="<?php echo $no_register; ?>">
                    <input type="hidden" name="kelas" value="<?php echo substr($no_register, 0, 2) == 'RJ' ? 'NK' : (substr($no_register, 0, 2) == 'PL' ? '' : $data_pasien_resep->kelas); ?>">
                    <input type="hidden" name="idrg" value="<?php echo $data_pasien_resep->idrg; ?>">
                    <input type="hidden" name="bed" value="<?php echo $data_pasien_resep->bed; ?>">
                    <input type="hidden" name="cara_bayar" value="<?php echo $data_pasien_resep->cara_bayar; ?>">
                    <label>No Antrian : </label>
                    <input type="text" name="no_antri" value="<?php echo isset($data_tindakan_pasien_farmasi[0]->no_antri)?$data_tindakan_pasien_farmasi[0]->no_antri:''; ?>"></input>
                    
                    <?php 
                        if(substr($no_register, 0, 2) == 'RJ'){ ?>
                        <input type="checkbox" id="konsultasi" name="konsultasi" value="1" <?php echo isset($data_tindakan_pasien_farmasi[0]->konsul)? $data_tindakan_pasien_farmasi[0]->konsul == "1" ? "checked":'':'' ?>>
                        <label for="konsultasi">Melakukan Tindakan Konsultasi Obat</label><br>
                      <?php  }
                    ?>
                   
                   
                    <?php 
                    
                    if( substr($no_register, 0, 2) == 'RI'){ ?>
                          <label>Tgl Resep : </label>
                          <input type="date" name="tgl_resep"></input>
                    <?php    }else{ ?>
                    <?php  }
                    ?>


                    <table class="table table-fixed table-responsive">
                        <thead>
                            <tr>
                                <th width="20%">Item Obat</th>
                                <th width="15%">Batch</th>
                                <th width="30px">Qty</th>
                                <!-- <th width="10%">Kronis</th> -->
                                <th width="10%">Signa</th>
                                <th width="10%">Qtx</th>
                                <th width="10%">Satuan</th>
                                <th width="10%">Cara Pakai</th>
                                <th width="10%">Signa Manual</th>
                                <?php 
                                if(substr($no_register, 0, 2) == 'RI'){ ?>
                                    <th width="10%">Jam</th>
                                <?php }else{ ?>
                                    <th width="10%">Ket Pakai</th>
                                <?php }
                                ?>
                                <!-- <th width="10%">Ket Pakai</th> -->
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="resep_pasien_table">
                            <?php
                            $i = 0;
                            foreach ($data_tindakan_pasien_farmasi as $row) {
                                if ($row->id_inventory != null) :
                            ?>
                                    <tr id="resep-<?= $i ?>">
                                        <td width="20%">
                                            <input type="hidden" name="id_resep_pasien-<?= $i ?>" value="<?= $row->id_resep_pasien; ?>">
                                            <input type="hidden" name="biaya_obat-<?= $i ?>" id="biaya_obat-<?= $i ?>">
                                            <input type="hidden" name="nama_obat-<?= $i ?>" id="nama_obat-<?= $i ?>">
                                            <select name="obat[]" class="form-control" id="select2obat<?= $i ?>" onchange="handlerchangeobat(this.value,'<?= $i ?>')" style="overflow: hidden;">
                                                <option value="">Cari Obat..</option>
                                                <option value="<?= $row->item_obat ?>@<?= $row->nama_obat ?>" selected>
                                                    <?= $row->nama_obat ?></option>
                                            </select>
                                        </td>
                                        <td width="15%">
                                            <select name="no_batch[]" class="form-control" id="select2batch<?= $i ?>">
                                                <option value="">Pilih Batch</option>
                                                <option value="<?= $row->id_inventory ?>@<?= $row->biaya_obat ?>" selected>
                                                    <?= $row->id_inventory ?></option>
                                            </select>
                                        </td>
                                        <td width="10%">
                                            <input type="text" class="form-control" name="qty[]" value="<?= $row->qty ?>">
                                        </td>
                                        <!-- <td width="10%">
                                            <select name="kronis[]" class="form-control">
                                                <option value="0">Non Kronis</option>
                                                <option value="1">Kronis</option>
                                            </select>
                                        </td> -->
                                        <td width="10%">
                                            <select name="signa[]" class="form-control">
                                                <option value="">Pilih Signa</option>
                                                <?php foreach ($satuan_signa as $v) {
                                                    if ($v->signa == $row->kali_harian) {
                                                        echo "<option value=\"$v->signa\" selected>$v->signa</option>";
                                                    } else {
                                                        echo '<option value="' . $v->signa . '">' . $v->signa . '</option>';
                                                    }
                                                } ?>
                                            </select>
                                        </td>
                                        <td width="10%">
                                            <select name="qtx[]" class="form-control">
                                                <option value="">Pilih Qtx</option>
                                                <?php foreach ($qtx as $v) {
                                                    if ($v->qtx == $row->qtx) {
                                                        echo "<option value=\"$v->qtx\" selected>$v->qtx</option>";
                                                    } else {
                                                        echo '<option value="' . $v->qtx . '">' . $v->qtx . '</option>';
                                                    }
                                                } ?>
                                            </select>
                                        </td>
                                        <td width="10%">
                                            <select name="satuan[]" class="form-control">
                                                <option value="">Pilih Satuan</option>
                                                <?php foreach ($satuan as $v) {
                                                    if ($v->nm_satuan == $row->Satuan_obat) {
                                                        echo "<option value=\"$v->nm_satuan\" selected>$v->nm_satuan</option>";
                                                    } else {
                                                        echo '<option value="' . $v->nm_satuan . '">' . $v->nm_satuan . '</option>';
                                                    }
                                                } ?>
                                            </select>
                                        </td>
                                        <td width="10%">
                                            <select name="cara_pakai[]" class="form-control">
                                                <option value="">Pilih Cara Pakai</option>
                                                <?php foreach ($cara_pakai as $v) {
                                                    if ($v->cara_pakai == $row->cara_pakai) {
                                                        echo "<option value=\"$v->cara_pakai\" selected>$v->cara_pakai</option>";
                                                    } else {
                                                        echo '<option value="' . $v->cara_pakai . '">' . $v->cara_pakai . '</option>';
                                                    }
                                                } ?>
                                            </select>
                                        </td>
                                        <td width="10%">
                                            <input type="text" class="form-control" name="signa_manual[]" value="<?= $row->signa ?>">
                                        </td>
                                        <?php 
                                        if(substr($no_register, 0, 2) == 'RI'){ ?>
                                        <td width="10%">
                                                <input type="time"  name="jam_pemberian1[]" value="<?= $row->jam_pemberian1 ?>">
                                                <input type="time"  name="jam_pemberian2[]" value="<?= $row->jam_pemberian2 ?>">
                                                <input type="time"  name="jam_pemberian3[]" value="<?= $row->jam_pemberian3 ?>">
                                                <input type="time"  name="jam_pemberian4[]" value="<?= $row->jam_pemberian4 ?>">
                                                <input type="time"  name="jam_pemberian5[]" value="<?= $row->jam_pemberian5 ?>">
                                                <input type="time"  name="jam_pemberian6[]" value="<?= $row->jam_pemberian6 ?>">
                                         </td>
                                        <?php }else{ ?>
                                            <td width="10%">
                                                <input type="checkbox" name="ket_pakai-<?= $i ?>[]" class="form-check-input" id="exampleCheckP<?= $i ?>" value="P" <?= $row->ket_pakai_p == '1' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="exampleCheckP<?= $i ?>">P</label>
                                                <input type="checkbox" name="ket_pakai-<?= $i ?>[]" class="form-check-input" id="exampleCheckS<?= $i ?>" value="S" <?= $row->ket_pakai_s == '1' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="exampleCheckS<?= $i ?>">S</label>
                                                <input type="checkbox" name="ket_pakai-<?= $i ?>[]" class="form-check-input" id="exampleCheckM<?= $i ?>" value="M" <?= $row->ket_pakai_m == '1' ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="exampleCheckM<?= $i ?>">M</label>
                                            </td>
                                        <?php }
                                        ?>


                                        <td>
                                            <button class="btn btn-xs btn-danger" type="button" onclick="hapus_data_per('<?= $row->id_resep_pasien ?>')">Delete</button>
                                            <input type="checkbox" name="cetak_tiket-<?= $i ?>" class="form-check-input" id="cetaks<?= $i ?>" value="1" <?= $row->cetak_tiket == '1' ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="cetaks<?= $i ?>"></label>

                                        </td>

                                    </tr>
                            <?php $i++;
                                endif;
                            } ?>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary" onclick="tambahRow()"><i class="mdi mdi-briefcase-download mr-2"></i>
                        Tambah</button>
                    <hr>
                    <br>
                    <div id="racikan-tab">
                        <h4>Obat Racikan</h4>
                        <hr>
                    </div>
                    <button type="button" class="btn btn-info " onclick="tambahtabracikan()">Tambah Racikan</button>

                </form>
            </div>
        </div>
    </div>

    <?php if(substr($no_register, 0, 2) == "RI"){ ?>
        <div class="col-12">
            <div class="ribbon-wrapper card">
                <h3>Riwayat Obat Pasien</h3>
                <a href="<?php echo base_url(); ?>iri/ricmedrec/cetak_list_resep_rajal/<?php echo $data_pasien_resep->noregold.'/'.'1'?>" target="_blank"><button type="button" class="btn btn-danger btn-sm" ><i class="fa fa-plusthick"></i> Lihat Resep IGD/Poli</button></a>
                <div class="table-responsive m-t-0">
                    <table id="tabel_resep" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Obat</th>
                                <th>Signa</th>
                                <th>Qty</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($data_history_farmasi as $val){ ?>
                            <tr>
                                <td><?= isset($val->tgl_kunjungan)?date('d-m-Y',strtotime($val->tgl_kunjungan)):'' ?></td>
                                <td><?= isset($val->nama_obat)?$val->nama_obat:'' ?></td>
                                <td><?= isset($val->signa)?$val->signa:'' ?></td>
                                <td><?= isset($val->qty)?$val->qty:'' ?></td>
                                <td> <button class="btn btn-xs btn-danger" type="button" onclick="hapus_data_per('<?= $val->id_resep_pasien ?>')">Delete</button></td>
                            </tr>
                            <?php } ?>
                           
                                
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php } ?>

    <script>
        let obatfarmasi = '<?= $i ?>'
        let parent = 0
        let child = 1;

        $(document).ready(function() {

            $("#table_dokter").DataTable({
                pageLength: 25
            });
            for (x = 0; x <= obatfarmasi; x++) {
                $("#select2obat" + x).select2({
                    placeholder: 'Pencarian Obat',
                    minimumInputLength: 3, // Adjust this based on your requirements
                    language: {
                        searching: function() {
                            return "Sedang Mencari Data...";
                        },
                        inputTooShort: function() {
                            return "Minimal 3 huruf..";
                        }
                    },
                    ajax: {
                        url: '<?= base_url('farmasi/Frmcdaftar/select_caridataobat') ?>', // Replace with your server endpoint
                        dataType: 'json',
                        delay: 250, // Delay in milliseconds before sending the request
                        processResults: function(data) {
                            // Process the data received from the server
                            return {
                                results: data
                            };
                        },
                        cache: true // Cache AJAX requests to reduce server load
                    }

                });
                $("#select2batch" + x).select2();
            }
        })

        function tambahtabracikan() {

            let html = `
        <div id="racikan-${obatfarmasi}">
            <table class="table table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Nama Racikan</th>
                        <th>Qty Total</th>
                        <th>Signa</th>
                        <th>Qtx</th>
                        <th>Satuan</th>
                        <th>Cara Pakai</th>
                         <th>Signa Manual</th>
                        <th>Ket Pakai</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="text" name="nm_racikan[]" class="form-control">
                        </td>
                        <td>
                            <input type="text" name="qty_racikan-${parent}" class="form-control">
                        </td>
                        <td>
                            <select name="signa_racikan-${parent}" class="form-control">
                                <?php foreach ($satuan_signa as $v) {
                                    echo '<option value="' . $v->signa . '">' . $v->signa . '</option>';
                                } ?>
                            </select>
                        </td>
                        <td>
                            <select name="qtx_racikan-${parent}" class="form-control">
                                <?php foreach ($qtx as $v) {
                                    echo '<option value="' . $v->qtx . '">' . $v->qtx . '</option>';
                                } ?>
                            </select>
                        </td>
                        <td>
                            <select name="satuan_racikan-${parent}" class="form-control">
                                <?php foreach ($satuan as $v) {
                                    echo '<option value="' . $v->nm_satuan . '">' . $v->nm_satuan . '</option>';
                                } ?>
                            </select>
                        </td>
                        <td>
                            <select name="cara_pakai_racikan-${parent}" class="form-control">
                                <?php foreach ($cara_pakai as $v) {
                                    echo '<option value="' . $v->cara_pakai . '">' . $v->cara_pakai . '</option>';
                                } ?>              
                            </select>
                        </td>
                        <td>
                             <input type="text" name="signa_manual_racikan-${parent}" class="form-control">
                        </td>
                        <td>
                            <input type="checkbox" name="ket_pakai_racikan-${parent}[]" class="form-check-input" id="exampleCheckPracikan${parent}" value="P">
                            <label class="form-check-label" for="exampleCheckPracikan${parent}" >P</label>
                            <input type="checkbox" name="ket_pakai_racikan-${parent}[]" class="form-check-input" id="exampleCheckSracikan${parent}" value="S">
                            <label class="form-check-label" for="exampleCheckSracikan${parent}">S</label>
                            <input type="checkbox" name="ket_pakai_racikan-${parent}[]" class="form-check-input" id="exampleCheckMracikan${parent}" value="M">
                            <label class="form-check-label" for="exampleCheckMracikan${parent}">M</label>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-xs" onclick="hapustabracikan('#racikan-${obatfarmasi}')">Hapus Racikan</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div id="parent-item-racikan-${parent}">
            </div>
            <div class="ml-3 pl-3">
                <button type="button" class="btn btn-primary btn-xs" onclick="tambahitemracikan('${parent}')">Tambah Obat</button>
            </div>
            <hr>
        </div>
        `;
            $("#racikan-tab").append(html);
            obatfarmasi++;
            parent = parent + 1;
            // child = child+1;
        }

        function tambahitemracikan(parent) {
            let html = `
        <div id="item-racikan-${parent}-${child}" class="ml-3 pl-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama obat</th>
                        <th>qty</th>
                        <th>Batch</th>
                        <th>Dosis</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="item_racikan-${parent}[]" id="select2obat-${parent}-${child}" class="form-control" onchange="handlerchangeobatracikan(this.value,'#select2batch-${parent}-${child}')"></select>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="qty_racikan_item-${parent}[]">
                        </td>
                        <td>
                            <select name="batch_racikan-${parent}[]" id="select2batch-${parent}-${child}" class="form-control"></select>
                        </td>
                        <td>
                            <input type="text" name="dosis_racikan-${parent}[]" class="form-control">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-xs" onclick="hapusobatracikan('#item-racikan-${parent}-${child}')">Hapus Obat</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        `;
            $(`#parent-item-racikan-${parent}`).append(html);
            $("#select2obat-" + `${parent}-${child}`).select2({
                placeholder: 'Pencarian Obat',
                minimumInputLength: 3, // Adjust this based on your requirements
                language: {
                    searching: function() {
                        return "Sedang Mencari Data...";
                    },
                    inputTooShort: function() {
                        return "Minimal 3 huruf..";
                    }
                },
                ajax: {
                    url: '<?= base_url('farmasi/Frmcdaftar/select_caridataobat') ?>', // Replace with your server endpoint
                    dataType: 'json',
                    delay: 250, // Delay in milliseconds before sending the request
                    processResults: function(data) {
                        // Process the data received from the server
                        return {
                            results: data
                        };
                    },
                    cache: true // Cache AJAX requests to reduce server load
                }

            });
            child++;
        }

        function hapusobatracikan(parent) {
            $(parent).remove();
        }

        function hapustabracikan(id) {
            $(id).remove(id);
        }


        function tambahRow(data = null) {
            console.log(data);
            if (data) {
                if (!data.id_obat && data.racikan !== '1') {
                    // Notify("Data Obat Merupakan Obat Luar, Silahkan Tambahkan Secara Manual",'warning');
                    Notify("Data Obat Merupakan Obat Luar, Silahkan Tambahkan Secara Manual", null, null, 'warning');
                    return;
                }
                if (!data.racikan) {

                    let html = `
                    <tr id="resep-${obatfarmasi}">
                        <td width="20%">
                            <input type="hidden" name="nama_obat-${obatfarmasi}" id="nama_obat-${obatfarmasi}">
                            <input type="hidden" name="biaya_obat-${obatfarmasi}" id="biaya_obat-${obatfarmasi}">
                            <select name="obat[]" class="form-control" id="select2obat${obatfarmasi}"
                            onchange="handlerchangeobat(this.value,'${obatfarmasi}')"
                            >
                                <option value="${data?data.id_obat+'@'+data.nm_obat:''}" selected>${data?data.nm_obat:'Pilih Obat'}</option>
                            </select>
                        </td>
                        <td width="15%">
                           <select name="no_batch[]" class="form-control" id="select2batch${obatfarmasi}">
                                <option value="">Pilih Batch</option>
                            </select>
                        </td>
                        <td width="10%">
                            <input type="text" class="form-control" name="qty[]" value="${data?data.qty:'1'}">
                            <input type="hidden" class="form-control" name="id_resep_dokter[]" value="${data.id_resep_dokter}">
                        </td>
                        <td width="10%">
                            <select name="signa[]" class="form-control">
                                <option value="${data?data.kali_harian:''}" selected>${data?data.kali_harian:''}</option>
                                <?php foreach ($satuan_signa as $v) {
                                    echo '<option value="' . $v->signa . '">' . $v->signa . '</option>';
                                } ?>
                            </select>
                        </td>
                        <td width="10%">
                            <select name="qtx[]" class="form-control">
                                <option value="${data?data.qtx:''}" selected>${data?data.qtx:''}</option>
                                <?php foreach ($qtx as $v) {
                                    echo '<option value="' . $v->qtx . '">' . $v->qtx . '</option>';
                                } ?>
                            </select>
                        </td>
                        <td width="10%">
                            <select name="satuan[]" class="form-control">
                                <option value="${data?data.satuan:''}" selected>${data?data.satuan:''}</option>
                                <?php foreach ($satuan as $v) {
                                    echo '<option value="' . $v->nm_satuan . '">' . $v->nm_satuan . '</option>';
                                } ?>
                            </select>
                        </td>
                        <td width="10%">
                            <select name="cara_pakai[]" class="form-control">
                                <option value="${data?data.cara_pakai:''}" selected>${data?data.cara_pakai:''}</option>
                                <?php foreach ($cara_pakai as $v) {
                                    echo '<option value="' . $v->cara_pakai . '">' . $v->cara_pakai . '</option>';
                                } ?>              
                            </select>
                        </td>
                        <td width="10%">
                            <input type="text" class="form-control" name="signa_manual[]" value="${data?data.signa:''}">
                        </td>
                        <?php 
                        if(substr($no_register,0,2) == 'RI'){ ?>
                            <td width="10%">
                                <input type="time" name="jam_pemberian1[]"   value="${data && data.jam_pemberian1 ? data.jam_pemberian1 : ''}">
                                <input type="time"  name="jam_pemberian2[]" value="${data && data.jam_pemberian2 ? data.jam_pemberian2 : ''}">
                                <input type="time"  name="jam_pemberian3[]" value="${data && data.jam_pemberian3 ? data.jam_pemberian3 : ''}">
                                <input type="time"  name="jam_pemberian4[]" value="${data && data.jam_pemberian4 ? data.jam_pemberian4 : ''}">
                                <input type="time"  name="jam_pemberian5[]" value="${data && data.jam_pemberian5 ? data.jam_pemberian5 : ''}">
                                <input type="time"  name="jam_pemberian6[]" value="${data && data.jam_pemberian6 ? data.jam_pemberian6 : ''}">
                            </td>
                       <?php  }else{ ?>
                            <td width="10%">
                                <input type="checkbox" name="ket_pakai-${obatfarmasi}[]" class="form-check-input" id="exampleCheckP${obatfarmasi}" value="P">
                                <label class="form-check-label" for="exampleCheckP${obatfarmasi}" >P</label>
                                <input type="checkbox" name="ket_pakai-${obatfarmasi}[]" class="form-check-input" id="exampleCheckS${obatfarmasi}" value="S">
                                <label class="form-check-label" for="exampleCheckS${obatfarmasi}">S</label>
                                <input type="checkbox" name="ket_pakai-${obatfarmasi}[]" class="form-check-input" id="exampleCheckM${obatfarmasi}" value="M">
                                <label class="form-check-label" for="exampleCheckM${obatfarmasi}">M</label>
                            </td>
                        <?php }
                        ?>
                        <td>
                            <button type="button" class="btn btn-danger btn-xs" onclick="hapus_data('${obatfarmasi}')">Hapus Obat</button>
                            <input type="checkbox" name="cetak_tiket-${obatfarmasi}" class="form-check-input" id="cetaks${obatfarmasi}"  value="1" checked>
                            <label class="form-check-label" for="cetaks${obatfarmasi}" ></label>
                                

                        </td>
                        
                    </tr>
                `;
                    $("#resep_pasien_table").append(html);
                    if (data !== null) {
                        handlerchangeobat(data.id_obat, obatfarmasi);
                    }

                    // for (x = 0; x <= obatfarmasi; x++) {
                    $("#select2obat" + obatfarmasi).select2({
                        placeholder: 'Pencarian Obat',
                        minimumInputLength: 3, // Adjust this based on your requirements
                        language: {
                            searching: function() {
                                return "Sedang Mencari Data...";
                            },
                            inputTooShort: function() {
                                return "Minimal 3 huruf..";
                            }
                        },
                        ajax: {
                            url: '<?= base_url('farmasi/Frmcdaftar/select_caridataobat') ?>', // Replace with your server endpoint
                            dataType: 'json',
                            delay: 250, // Delay in milliseconds before sending the request
                            processResults: function(data) {
                                // Process the data received from the server
                                return {
                                    results: data
                                };
                            },
                            cache: true // Cache AJAX requests to reduce server load
                        }

                    });
                    $("#select2batch" + obatfarmasi).select2();
                    obatfarmasi++;
                } else {
                    // console.log(data);
                    let html = `
                <div id="racikan-${obatfarmasi}">
                    <table class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>Nama Racikan</th>
                                <th>Qty Total</th>
                                <th>Signa</th>
                                <th>Qtx</th>
                                <th>Satuan</th>
                                <th>Cara Pakai</th>
                                 <th>Signa Manual</th>
                                <th>Ket Pakai</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" name="nm_racikan[]" class="form-control" value="${data.nm_obat}">
                                    <input type="hidden" name="id_resep_dokter[]" value="${data.id_resep_dokter}">
                                </td>
                                <td>
                                    <input type="text" name="qty_racikan-${parent}" class="form-control" value="${data.qty}">
                                </td>
                                <td>
                                    <select name="signa_racikan-${parent}" class="form-control">
                                        <option value="${data?data.kali_harian:''}" selected>${data?data.kali_harian:''}</option>
                                        <?php foreach ($satuan_signa as $v) {
                                            echo '<option value="' . $v->signa . '">' . $v->signa . '</option>';
                                        } ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="qtx_racikan-${parent}" class="form-control">
                                        <option value="${data?data.qtx:''}" selected>${data?data.qtx:''}</option>
                                        <?php foreach ($qtx as $v) {
                                            echo '<option value="' . $v->qtx . '">' . $v->qtx . '</option>';
                                        } ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="satuan_racikan-${parent}" class="form-control">
                                        <option value="${data?data.satuan:''}" selected>${data?data.satuan:''}</option>
                                        <?php foreach ($satuan as $v) {
                                            echo '<option value="' . $v->nm_satuan . '">' . $v->nm_satuan . '</option>';
                                        } ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="cara_pakai_racikan-${parent}" class="form-control">
                                        <option value="${data?data.cara_pakai:''}" selected>${data?data.cara_pakai:''}</option>
                                        <?php foreach ($cara_pakai as $v) {
                                            echo '<option value="' . $v->cara_pakai . '">' . $v->cara_pakai . '</option>';
                                        } ?>              
                                    </select>
                                </td>
                                 <td>
                                    <input type="text" name="signa_manual_racikan-${parent}" class="form-control" value="${data.signa}">
                                </td>
                                <td>
                                    <input type="checkbox" name="ket_pakai_racikan-${parent}[]" class="form-check-input" id="exampleCheckPRacik${parent}" value="P">
                                    <label class="form-check-label" for="exampleCheckPRacik${parent}" >P</label>
                                    <input type="checkbox" name="ket_pakai_racikan-${parent}[]" class="form-check-input" id="exampleCheckSRacik${parent}" value="S">
                                    <label class="form-check-label" for="exampleCheckSRacik${parent}">S</label>
                                    <input type="checkbox" name="ket_pakai_racikan-${parent}[]" class="form-check-input" id="exampleCheckMRacik${parent}" value="M">
                                    <label class="form-check-label" for="exampleCheckMRacik${parent}">M</label>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-xs" onclick="hapustabracikan('#racikan-${obatfarmasi}')">Hapus Racikan</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div id="parent-item-racikan-${parent}">
                        
                    </div>
                    <div class="ml-3 pl-3">
                        <button type="button" class="btn btn-primary btn-xs" onclick="tambahitemracikan('${parent}')">Tambah Obat</button>
                    </div>
                    <hr>
                </div>
                `;
                    $("#racikan-tab").append(html);
                    obatfarmasi++;
                    $.ajax({
                        url: "<?php echo base_url('farmasi/Frmcdaftar/check_obat_racikan/') ?>" + data.id_resep_dokter,
                        success: function(v) {
                            if (v.length > 0) {
                                let html_child = '';
                                v.map((e) => {
                                    console.log(e);
                                    $(`#parent-item-racikan-${parent}`).append(`
                                    <div id="item-racikan-${parent}-${child}" class="ml-3 pl-3">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Nama obat</th>
                                                    <th>Qty</th>
                                                    <th>Batch</th>
                                                    <th>Dosis</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select name="item_racikan-${parent}[]" id="select2obat-${parent}-${child}" class="form-control" onchange="handlerchangeobatracikan(this.value,'#select2batch-${parent}-${child}')">
                                                            <option value="${e?e.item_obat+'@'+e.nama_obat:''}" selected>${e?e.nama_obat:'Pilih Obat'}</option>
                                                                                    
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="qty_racikan_item-${parent}[]" class="form-control">
                                                    </td>
                                                    <td>
                                                        <select name="batch_racikan-${parent}[]" id="select2batch-${parent}-${child}" class="form-control"></select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="dosis_racikan-${parent}[]" class="form-control" value="${e.dosis}" readonly>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-xs" onclick="hapusobatracikan('#item-racikan-${parent}-${child}')">Hapus Obat</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    `);
                                    $("#select2obat-" + `${parent}-${child}`).select2({
                                        placeholder: 'Pencarian Obat',
                                        minimumInputLength: 3, // Adjust this based on your requirements
                                        language: {
                                            searching: function() {
                                                return "Sedang Mencari Data...";
                                            },
                                            inputTooShort: function() {
                                                return "Minimal 3 huruf..";
                                            }
                                        },
                                        ajax: {
                                            url: '<?= base_url('farmasi/Frmcdaftar/select_caridataobat') ?>', // Replace with your server endpoint
                                            dataType: 'json',
                                            delay: 250, // Delay in milliseconds before sending the request
                                            processResults: function(data) {
                                                // Process the data received from the server
                                                return {
                                                    results: data
                                                };
                                            },
                                            cache: true // Cache AJAX requests to reduce server load
                                        }

                                    });
                                    handlerchangeobatracikan(e.item_obat, `#select2batch-${parent}-${child}`);

                                    child++;
                                })
                                // $(`#parent-item-racikan-${parent}`).append(html_child);

                                parent = parent + 1;
                            }

                        },
                        error: function() {
                            //alert("error");
                        }
                    });


                }
            } else {
                let html = `
                <tr id="resep-${obatfarmasi}">
                    <td width="20%">
                        <input type="hidden" name="nama_obat-${obatfarmasi}" id="nama_obat-${obatfarmasi}">
                        <input type="hidden" name="biaya_obat-${obatfarmasi}" id="biaya_obat-${obatfarmasi}">
                        <select name="obat[]" class="form-control" id="select2obat${obatfarmasi}"
                        onchange="handlerchangeobat(this.value,'${obatfarmasi}')"
                        >
                            <option value="${data?data.id_obat+'@'+data.nm_obat:''}" selected>${data?data.nm_obat:'Pilih Obat'}</option>
                        </select>
                    </td>
                    <td width="15%">
                        <select name="no_batch[]" class="form-control" id="select2batch${obatfarmasi}">
                            <option value="">Pilih Batch</option>
                        </select>
                    </td>
                    <td width="10%">
                        <input type="text" class="form-control" name="qty[]" value="${data?data.qty:'1'}">
                    </td>
                  
                    <td width="10%">
                        <select name="signa[]" class="form-control">
                            <option value="${data?data.kali_harian:''}" selected>${data?data.kali_harian:''}</option>
                            <?php foreach ($satuan_signa as $v) {
                                echo '<option value="' . $v->signa . '">' . $v->signa . '</option>';
                            } ?>
                        </select>
                    </td>
                    <td width="10%">
                        <select name="qtx[]" class="form-control">
                            <option value="${data?data.qtx:''}" selected>${data?data.qtx:''}</option>
                            <?php foreach ($qtx as $v) {
                                echo '<option value="' . $v->qtx . '">' . $v->qtx . '</option>';
                            } ?>
                        </select>
                    </td>
                    <td width="10%">
                        <select name="satuan[]" class="form-control">
                            <option value="${data?data.satuan:''}" selected>${data?data.satuan:''}</option>
                            <?php foreach ($satuan as $v) {
                                echo '<option value="' . $v->nm_satuan . '">' . $v->nm_satuan . '</option>';
                            } ?>
                        </select>
                    </td>
                    <td width="10%">
                        <select name="cara_pakai[]" class="form-control">
                            <option value="${data?data.cara_pakai:''}" selected>${data?data.cara_pakai:''}</option>
                            <?php foreach ($cara_pakai as $v) {
                                echo '<option value="' . $v->cara_pakai . '">' . $v->cara_pakai . '</option>';
                            } ?>              
                        </select>
                    </td>
                     <td width="10%">
                        <input type="text" class="form-control" name="signa_manual[]" value="${data?data.signa:''}">
                    </td>
                    <?php 
                        if(substr($no_register,0,2) == 'RI'){ ?>
                            <td width="10%">
                            <input type="time"  name="jam_pemberian1[]" value="${data?data.jam_pemberian1:''}">
                                <input type="time"  name="jam_pemberian2[]" value="${data?data.jam_pemberian2:''}">
                                <input type="time"  name="jam_pemberian3[]" value="${data?data.jam_pemberian3:''}">
                                <input type="time"  name="jam_pemberian4[]" value="${data?data.jam_pemberian4:''}">
                                <input type="time"  name="jam_pemberian5[]" value="${data?data.jam_pemberian5:''}">
                                <input type="time"  name="jam_pemberian6[]" value="${data?data.jam_pemberian6:''}">
                            </td>
                       <?php  }else{ ?>
                            <td width="10%">
                                <input type="checkbox" name="ket_pakai-${obatfarmasi}[]" class="form-check-input" id="exampleCheckP${obatfarmasi}" value="P">
                                <label class="form-check-label" for="exampleCheckP${obatfarmasi}" >P</label>
                                <input type="checkbox" name="ket_pakai-${obatfarmasi}[]" class="form-check-input" id="exampleCheckS${obatfarmasi}" value="S">
                                <label class="form-check-label" for="exampleCheckS${obatfarmasi}">S</label>
                                <input type="checkbox" name="ket_pakai-${obatfarmasi}[]" class="form-check-input" id="exampleCheckM${obatfarmasi}" value="M">
                                <label class="form-check-label" for="exampleCheckM${obatfarmasi}">M</label>
                            </td>
                        <?php }
                        ?>
                    <td>
                        <button type="button" class="btn btn-danger btn-xs" onclick="hapus_data('${obatfarmasi}')">Hapus Obat</button>
                        <input type="checkbox" name="cetak_tiket-${obatfarmasi}" class="form-check-input" id="cetaks${obatfarmasi}"  value="1" checked>
                        <label class="form-check-label" for="cetaks${obatfarmasi}" ></label>
                    </td>
                    
                </tr>
            `;
                $("#resep_pasien_table").append(html);
                if (data !== null) {
                    handlerchangeobat(data.id_obat, obatfarmasi);
                }

                // for (x = 0; x <= obatfarmasi; x++) {
                $("#select2obat" + obatfarmasi).select2({
                    placeholder: 'Pencarian Obat',
                    minimumInputLength: 3, // Adjust this based on your requirements
                    language: {
                        searching: function() {
                            return "Sedang Mencari Data...";
                        },
                        inputTooShort: function() {
                            return "Minimal 3 huruf..";
                        }
                    },
                    ajax: {
                        url: '<?= base_url('farmasi/Frmcdaftar/select_caridataobat') ?>', // Replace with your server endpoint
                        dataType: 'json',
                        delay: 250, // Delay in milliseconds before sending the request
                        processResults: function(data) {
                            // Process the data received from the server
                            return {
                                results: data
                            };
                        },
                        cache: true // Cache AJAX requests to reduce server load
                    }

                });
                $("#select2batch" + obatfarmasi).select2();
                obatfarmasi++;
            }


        }

        // function pilihbatch(val) {
        //     tambahRow();
        // }

        function terapkandata(data) {
            $(`#${data.id_resep_dokter}`).css({
                'background-color': 'lightgreen'
            });
            tambahRow(data)
        }

        function handlerchangeobatracikan(val, i) {
            $.ajax({
                url: "<?php echo base_url('farmasi/Frmcdaftar/check_gudang') ?>",
                data: {
                    id_obat: val.split('@')[0]
                },
                success: function(data) {
                    console.log(data);
                    let html = '';
                    let subs = '';
                    $(i).html(html);
                    data.batch.map((e) => {
                        html += `
                    <option value="${e.id_inventory}@${e.hargajual}">${e.batch_no}(stok:${e.qty},exp:${e.expire_date})</option>
                    `;
                    })

                    data.substitusi.map((e) => {
                        subs += `
                    <option value="${e.id_obat_sub}">${e.nm_obat}</option>
                    `;
                    })
                    $(i).html(html);
                    // $("#select2substitusi" + i).html(html);


                },
                error: function() {
                    //alert("error");
                }
            });
            $("#nama_obat-" + i).val(val.split('@')[1]);
        }

        function handlerchangeobat(val, i) {
            console.log(val);
            console.log(i);
            $.ajax({
                url: "<?php echo base_url('farmasi/Frmcdaftar/check_gudang') ?>",
                data: {
                    id_obat: val.split('@')[0]
                },
                success: function(data) {
                    let html = '';
                    let subs = '';
                    $("#select2batch" + i).html(html);
                    data.batch.map((e) => {
                        html += `
                    <option value="${e.id_inventory}@${e.hargajual}">${e.batch_no}(stok:${e.qty},exp:${e.expire_date})</option>
                    `;
                    })

                    data.substitusi.map((e) => {
                        subs += `
                    <option value="${e.id_obat_sub}">${e.nm_obat}</option>
                    `;
                    })
                    $("#select2batch" + i).html(html);
                    // $("#select2substitusi" + i).html(html);


                },
                error: function() {
                    //alert("error");
                }
            });
            $("#nama_obat-" + i).val(val.split('@')[1]);
        }


        function handlerchangeobatnew(val, i) {
            console.log(val);
            console.log(i);
            $.ajax({
                url: "<?php echo base_url('farmasi/Frmcdaftar/check_gudang_id_inven') ?>",
                data: {
                    id_inven: val
                },
                success: function(data) {
                    let html = '';
                    let subs = '';
                    $("#select2batch" + i).html(html);
                    data.batch.map((e) => {
                        html += `
                    <option value="${e.id_inventory}@${e.hargajual}">${e.batch_no}(stok:${e.qty},exp:${e.expire_date})</option>
                    `;
                    
                    })

                    data.substitusi.map((e) => {
                        subs += `
                    <option value="${e.id_obat_sub}">${e.nm_obat}</option>
                    `;
                    })
                    $("#select2batch" + i).html(html);
                    // $("#select2substitusi" + i).html(html);


                },
                error: function() {
                    //alert("error");
                }
            });
            $("#nama_obat-" + i).val(val.split('@')[1]);
        }

        function simpanresep() {
            let data = $("#form_resep_pasien").serialize();
            let roleid = '<?php echo $roleid ?>';
            let id_ok = '<?php echo $id_ok ?>';
            let noreg = '<?php echo $no_register ?>';
            let id_poli = '<?php echo isset($data_tindakan_pasien_dokter[0]->id_poli)?$data_tindakan_pasien_dokter[0]->id_poli:'' ?>';
            $.ajax({
                method: 'post',
                url: "<?php echo base_url('farmasi/Frmcdaftar/simpan_resep_pasien_new/0') ?>",
                data: data,
                beforeSend: function() {
                    $("#save-btn-resep").prop('disabled', true);
                },
                success: function(data) {
                    if (data.code === 200) {
                        window.open('<?= base_url() ?>' + '/' + data.resep)
                        swal({
                                title: "Selesai",
                                text: "Data Sudah Disimpan",
                                type: "success",
                                showCancelButton: false,
                                closeOnConfirm: false,
                                showLoaderOnConfirm: true
                            },
                            function() {
                                if(roleid == '1028'){
                                    window.open('<?= base_url() ?>' + 'ok/okcdaftar/list_tindak/'+id_ok,'_self');
                                }else if(id_poli == 'BA00'){
                                    window.open('<?= base_url() ?>' + 'farmasi/Frmcdaftar/daftar_farmasi_igd', '_self');
                                }else if(noreg.substring(0, 2) == 'RI' ){
                                    window.open('<?= base_url() ?>' + 'farmasi/Frmcdaftar/permintaan_obat_petugas?no_register='+noreg, '_self');
                                }else{
                                    window.open('<?= base_url() ?>' + 'farmasi/Frmcdaftar/', '_self');
                                }

                            });
                    } else if (data.code === 400) {
                        swal({
                            title: "Gagal",
                            text: data.message,
                            type: "warning"
                        });
                    }
                },
                error: function() {
                    //alert("error");
                },
                complete: function() {
                    $("#save-btn-resep").prop('disabled', false);
                }
            });
        }

        function obatracikan() {
            window.open('<?= base_url() ?>' + 'farmasi/Frmcdaftar/permintaan_obat/' + '<?= $no_register ?>', '_self');
        }

        function hapus_data(id) {
            $('#resep-' + id).remove();
        }

        function hapus_data_per(id_resep) {
            var noreg = '<?php echo $no_register?>';
            console.log(id_resep); // Log the id_resep to check its value.
            $.ajax({
                method: 'POST', // It's good practice to use uppercase for the HTTP methods.
                url: "<?= base_url('farmasi/Frmcdaftar/hapus_resep_pasien') ?>", // Make sure this URL is correct.
                data: { 
                    id_resep: id_resep ,
                    noreg : noreg
                }, // Send the id_resep in the data parameter.
                success: function(data) {
                    // Use dynamic base_url to ensure correct redirection.
                    var base_url = '<?= base_url() ?>';
                    var redirect_url = base_url + 'farmasi/frmcdaftar/permintaan_obat_petugas?no_register='+data.noreg;
                    window.open(redirect_url, '_self'); // Redirect to the new URL.
                },
                error: function(xhr, status, error) {
                    // Handle any errors that occur during the AJAX request
                    console.error("Error occurred: " + error);
                }
            });
        }

    </script>
    <?php
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
    ?>