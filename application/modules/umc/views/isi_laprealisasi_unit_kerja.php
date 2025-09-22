<?php if($lap == 'ada') { 
    if(sizeof($unit_kerja) > 0) { ?>
        <div class="table-responsive m-t-15">
            <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Tindakan</th>
                        <th rowspan="2">Total Vol.</th>
                        <th colspan="3">Volume</th>
                        <th rowspan="2">Total Tarif Rill</th>
                        <th colspan="3">Penerimaan</th>
                    </tr>   
                    <tr>
                        <td>BPJS</td>
                        <td>UMUM</td>
                        <td>IKS</td>
                        <td>BPJS</td>
                        <td>UMUM</td>
                        <td>IKS</td>
                    </tr>                                    
                </thead>
                <tbody id="tbodyexample">
                <?php
                    $i = 1;
                    $total_vol = 0;
                    $total_vol_bpjs = 0;
                    $total_vol_umum = 0;
                    $total_vol_iks = 0;
                    $penerimaan_bpjs = 0;
                    $penerimaan_umum = 0;
                    $penerimaan_iks = 0;
                    $vtotRill = 0;
                    $akom = 0;
                    foreach($unit_kerja as $row) { 
                        $vtotRill += $row['rill'];
                        $total_vol += $row['total_vol'];
                        $total_vol_bpjs += $row['vol_bpjs'];
                        $total_vol_umum += $row['vol_umum'];
                        $total_vol_iks += $row['vol_iks'];
                        $penerimaan_bpjs += $row['penerimaan_bpjs'];
                        $penerimaan_umum += $row['penerimaan_umum'];
                        $penerimaan_iks += $row['penerimaan_iks'];?>
                        <tr>
                            <td><?php echo $i++;?></td>
                            <td><?php echo $row['nmtindakan'];?></td>
                            <td><?php echo $row['total_vol'];?></td>
                            <td><?php echo $row['vol_bpjs'];?></td>
                            <td><?php echo $row['vol_umum'];?></td>
                            <td><?php echo $row['vol_iks'];?></td>
                            <td><?php echo number_format($row['rill']);?></td>
                            <td><?php echo number_format($row['penerimaan_bpjs']);?></td>
                            <td><?php echo number_format($row['penerimaan_umum']);?></td>
                            <td><?php echo number_format($row['penerimaan_iks']);?></td>
                        </tr>
                <?php } 
                if($unit == 'ruang') { 
                    $akom = $akomodasi->penerimaan_bpjs + $akomodasi->penerimaan_umum + $akomodasi->penerimaan_iks;?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $akomodasi->nmtindakan; ?></td>
                        <td><?php echo $akomodasi->vol_bpjs + $akomodasi->vol_umum + $akomodasi->vol_iks;?></td>
                        <td><?php echo $akomodasi->vol_bpjs;?></td>
                        <td><?php echo $akomodasi->vol_umum;?></td>
                        <td><?php echo $akomodasi->vol_iks;?></td>
                        <td><?php echo number_format($akomodasi->penerimaan_bpjs + $akomodasi->penerimaan_umum + $akomodasi->penerimaan_iks);?></td>
                        <td><?php echo number_format($akomodasi->penerimaan_bpjs);?></td>
                        <td><?php echo number_format($akomodasi->penerimaan_umum);?></td>
                        <td><?php echo number_format($akomodasi->penerimaan_iks);?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <h4>Total Semua Vol : <?php echo $total_vol;?></h4>
            <h4>Total Vol BPJS : <?php echo $total_vol_bpjs;?></h4>
            <h4>Total Vol UMUM : <?php echo $total_vol_umum;?></h4>
            <h4>Total Vol IKS : <?php echo $total_vol_iks;?></h4>
            <h4>Penerimaan BPJS : <?php echo number_format($penerimaan_bpjs);?></h4>
            <h4>Penerimaan UMUM : <?php echo number_format($penerimaan_umum);?></h4>
            <h4>Penerimaan IKS : <?php echo number_format($penerimaan_iks);?></h4>
            <h4>Total Tarif Rill : <?php
            if($unit == 'ruang') {
                echo number_format($vtotRill + $akom);
            } else {
                echo number_format($vtotRill);
            } ?></h4>
        </div><br>
        <?php 
        $id_poli = explode("_", $object);
        ?>
        <?php
            if($unit == 'ruang') { ?>
               
               <a href="<?= base_url('umc/cumcicilan/excel_lap_realisasi_unit_kerja/'.$object.'/'.$date); ?>" class="btn btn-success" target="_blank">Excel</a>
           <?php  } else { 
            $v = str_replace([' ', '(' ,')'], ['_', '', ''], $object);
            ?>
                <a href="<?= base_url('umc/cumcicilan/excel_lap_realisasi_unit_kerja/'.$v.'/'.$date1.'/'.$date2); ?>" class="btn btn-success" target="_blank">Excel</a>
            <?php } ?>
        
<?php } else { ?>
        <div class="table-responsive m-t-15">
            <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Tindakan</th>
                        <th rowspan="2">Total Vol.</th>
                        <th colspan="3">Volume</th>
                        <th rowspan="2">Total Tarif Rill</th>
                        <th colspan="3">Penerimaan</th>
                    </tr>   
                    <tr>
                        <td>BPJS</td>
                        <td>UMUM</td>
                        <td>IKS</td>
                        <td>BPJS</td>
                        <td>UMUM</td>
                        <td>IKS</td>
                    </tr>                                    
                </thead>
                <tbody id="tbodyexample">
                    <tr>
                        <td colspan="9" align="center">Data Tidak ditemukan</td>
                    </tr>
                </tbody>
            </table>
        </div><br>
<?php }
} else { ?>
    <div class="table-responsive m-t-15">
        <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
            <thead>
                <tr>
                    <th rowspan="2">No.</th>
                    <th rowspan="2">Tindakan</th>
                    <th rowspan="2">Total Vol.</th>
                    <th colspan="3">Volume</th>
                    <th rowspan="2">Total Tarif Rill</th>
                    <th colspan="3">Penerimaan</th>
                </tr>   
                <tr>
                    <td>BPJS</td>
                    <td>UMUM</td>
                    <td>IKS</td>
                    <td>BPJS</td>
                    <td>UMUM</td>
                    <td>IKS</td>
                </tr>                                    
            </thead>
            <tbody id="tbodyexample">
            </tbody>
        </table>
    </div><br>
<?php } ?>