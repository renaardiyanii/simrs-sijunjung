<?php
    $this->load->view('irj/layout/header_form',['hide'=>true,'redirect'=>base_url()]);
    
?>
<div class="card m-5">
    <div class="card-header">
        History Rencana Kontrol
    </div>
    <div class="card-body">
    <form>
        <div class="row mx-2 my-4">
            <!-- Tanggal Surat Kontrol -->
            <div class="form-group row">
                <label class="col-sm-3 control-label col-form-label">Bulan</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <select name="bulan" id="" class="form-control">
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>	
                </div>								
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label col-form-label">Tahun</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <select name="tahun" id="" class="form-control">
                            <?php
                            for($i = 2015;$i<=2040;$i++){
                                echo '<option value="'.$i.'" '.($i==intval(date('Y'))?'selected':'').'>'.$i.'</option>';
                            }
                            ?>
                        </select>
                    </div>	
                </div>								
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label col-form-label">Nomor Kartu</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control" name="no_kartu" required value="<?= $nokartu ?>" >
                    </div>	
                </div>								
            </div>
            <div class="form-group row">
                <label class="col-sm-3 control-label col-form-label">Format Filter</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <select name="filter" id="" class="form-control">
                            <option value="1">Tgl. Entri</option>
                            <option value="2">Tgl. Rencana Kontrol</option>
                        </select>
                    </div>	
                </div>								
            </div>

            
            <div class="col-md-5">
                <div class="form-actions">
                    <button type="submit" class="btn waves-effect waves-light btn-info" >
                        <i class="fa fa-search"></i> Cari
                    </button>
                </div>
            </div>
        </div>
    </form>
    </div>
</div>

<?php
if(isset($history->metaData->code)):
    if($history->metaData->code == '200'):
    // var_dump($monitoring->response);die();
?>
<div class="card card-outline-info p-4">
    <h4>Hasil Pencarian</h4>
    <div class="table-responsive">
        <table class="table table-bordered">
    
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No. Surat Kontrol</th>
                    <th>Jenis Pelayanan</th>
                    <th>Tgl. Rencana Kontrol</th>
                    <th>Tgl. Terbit Surat Kontrol</th>
                    <th>Nomor Sep Asal</th>
                    <th>Poli Tujuan</th>
                    <th>Nama Dokter</th>
                    <th>Terbit SEP</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(count($history->response->list)): 
                    $i=1;
                    foreach($history->response->list as $val):
                ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $val->noSuratKontrol ?></td>
                        <td><?= $val->jnsPelayanan ?></td>
                        <td><?= $val->tglRencanaKontrol ?></td>
                        <td><?= $val->tglTerbitKontrol ?></td>
                        <td><?= $val->noSepAsalKontrol ?></td>
                        <td><?= $val->namaPoliTujuan ?></td>
                        <td><?= $val->namaDokter ?></td>
                        <td><?= $val->terbitSEP ?></td>
                    </tr>
                <?php 
                    $i++;
                    endforeach;
                    else:
                ?>
                    <tr>
                        <td colspan="9" style="text-align:center"><?= $history->metaData->message ?></td>
                    </tr>
                <?php
                endif; 
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>