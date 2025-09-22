<?php
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_left");
    }

    function formatCurrency($number) {
        return "Rp. " . number_format((float)$number, 0, ',', '.');
    }
?>
<script type="text/javascript">
$(document).ready(function() {
    $('#date_days').show();
    $('#date_months').hide();
    $('#example').DataTable();
});

function cek_tampil_per(val) {
    if (val === 'TGL') {
        document.getElementById("date_days").required = true;
        document.getElementById("date_months").required = false;
        $('#date_days').show();
        $('#date_months').hide();
    } else if (val === 'BLN') {
        document.getElementById("date_days").required = false;
        document.getElementById("date_months").required = true;
        $('#date_days').hide();
        $('#date_months').show();
    }
}
</script>
<style>
hr {
    border-color: #7DBE64 !important;
}
</style>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-outline-info">
            <div class="card-block">
                <?php echo form_open('lab/labclaporan/lap_capkin');?>
                <div class="row p-t-0">
                    <div class="col-md-2">
                        <div class="form-group">
                            <select name="tampil_per" id="tampil_per" onchange="cek_tampil_per(this.value)"
                                class="form-control">
                                <option value="TGL">Tanggal</option>
                                <option value="BLN">Bulan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input type="date" id="date_days" class="form-control" name="date_days">
                            <input type="month" id="date_months" class="form-control" name="date_months">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-actions">
                            <button class="btn btn-primary" id="btncari" name="btncari" type="submit">Search</button>
                        </div>
                    </div>
                </div>
                <?php echo form_close();?>
            </div>
        </div>
    </div>
</div>


</section>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-block">
                <div class="card-title" align="center">
                    <h4 align="center">Laporan Capaian Kinerja Pelayanan Instalasi Laboratorium
                        <b><?php echo $date ?></b></h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive m-t-15">
                        <table id="example" class="display nowrap table table-hover table-bordered table-striped"
                            cellspacing="0">
                            <thead>
                                <tr>
                                    <th rowspan="3">No</th>
                                    <th rowspan="3">pelayanan</th>
                                    <th colspan="9">dr. Elhuriyah, Sp. PK</th>
                                    <th colspan="9">dr. Fatimah Yasin, Sp. PK</th>
                                </tr>
                                <tr>
                                    <th colspan="3">R. Inap</th>
                                    <th colspan="3">R. Jalan</th>
                                    <th rowspan="2">Eksekutif</th>
                                    <th rowspan="2">Isolasi</th>
                                    <th rowspan="2">Jumlah</th>
                                    <th colspan="3">R. Inap</th>
                                    <th colspan="3">R. Jalan</th>
                                    <th rowspan="2">Eksekutif</th>
                                    <th rowspan="2">Isolasi</th>
                                    <th rowspan="2">Jumlah</th>
                                </tr>
                                <tr>
                                    <th>BPJS</th>
                                    <th>UMUM</th>
                                    <th>IKS</th>
                                    <th>BPJS</th>
                                    <th>UMUM</th>
                                    <th>IKS</th>
                                    <th>BPJS</th>
                                    <th>UMUM</th>
                                    <th>IKS</th>
                                    <th>BPJS</th>
                                    <th>UMUM</th>
                                    <th>IKS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Pemeriksaan Laboratorium</td>
                                    <?php
            $idx = 0;
            foreach($lap_pemeriksaan as $index => $row) {
                if ($index == $idx) {
                    echo "<td>".($row->el_ri_bpjs !== null ? $row->el_ri_bpjs : '0')."</td>";
                    echo "<td>".($row->el_ri_umum !== null ? $row->el_ri_umum : '0')."</td>";
                    echo "<td>".($row->el_ri_iks !== null ? $row->el_ri_iks : '0')."</td>";
                    echo "<td>".($row->el_rj_bpjs !== null ? $row->el_rj_bpjs : '0')."</td>";
                    echo "<td>".($row->el_rj_umum !== null ? $row->el_rj_umum : '0')."</td>";
                    echo "<td>".($row->el_rj_iks !== null ? $row->el_rj_iks : '0')."</td>";
                    echo "<td>".($row->el_eksekutif !== null ? $row->el_eksekutif : '0')."</td>";
                    echo "<td>".($row->el_isolasi !== null ? $row->el_isolasi : '0')."</td>";
                    echo "<td>".(($row->el_isolasi + $row->el_ri_bpjs + $row->el_ri_umum + $row->el_ri_iks + $row->el_rj_bpjs + $row->el_rj_umum + $row->el_rj_iks + $row->el_eksekutif + $row->el_isolasi !== null) ? ($row->el_isolasi + $row->el_ri_bpjs + $row->el_ri_umum + $row->el_ri_iks + $row->el_rj_bpjs + $row->el_rj_umum + $row->el_rj_iks + $row->el_eksekutif + $row->el_isolasi) : '0')."</td>";
                    
                    echo "<td>".($row->f_ri_bpjs !== null ? $row->f_ri_bpjs : '0')."</td>";
                    echo "<td>".($row->f_ri_umum !== null ? $row->f_ri_umum : '0')."</td>";
                    echo "<td>".($row->f_ri_iks !== null ? $row->f_ri_iks : '0')."</td>";
                    echo "<td>".($row->f_rj_bpjs !== null ? $row->f_rj_bpjs : '0')."</td>";
                    echo "<td>".($row->f_rj_umum !== null ? $row->f_rj_umum : '0')."</td>";
                    echo "<td>".($row->f_rj_iks !== null ? $row->f_rj_iks : '0')."</td>";
                    echo "<td>".($row->f_eksekutif !== null ? $row->f_eksekutif : '0')."</td>";
                    echo "<td>".($row->f_isolasi !== null ? $row->f_isolasi : '0')."</td>";
                    echo "<td>".(($row->f_ri_bpjs + $row->f_ri_umum + $row->f_ri_iks + $row->f_rj_bpjs + $row->f_rj_umum + $row->f_rj_iks + $row->f_eksekutif + $row->f_isolasi !== null) ? ($row->f_ri_bpjs + $row->f_ri_umum + $row->f_ri_iks + $row->f_rj_bpjs + $row->f_rj_umum + $row->f_rj_iks + $row->f_eksekutif + $row->f_isolasi) : '0')."</td>";
                }
            }
            ?>
                                </tr>

                                <tr>
                                    <td>2</td>
                                    <td>Jumlah Pasien</td>
                                    <?php
            $idx = 1;
            foreach($lap_pemeriksaan as $index=>$row) {
                if ($index == $idx) {
                    echo "<td>".($row->el_ri_bpjs !== null ? $row->el_ri_bpjs : '0')."</td>";
                    echo "<td>".($row->el_ri_umum !== null ? $row->el_ri_umum : '0')."</td>";
                    echo "<td>".($row->el_ri_iks !== null ? $row->el_ri_iks : '0')."</td>";
                    echo "<td>".($row->el_rj_bpjs !== null ? $row->el_rj_bpjs : '0')."</td>";
                    echo "<td>".($row->el_rj_umum !== null ? $row->el_rj_umum : '0')."</td>";
                    echo "<td>".($row->el_rj_iks !== null ? $row->el_rj_iks : '0')."</td>";
                    echo "<td>".($row->el_eksekutif !== null ? $row->el_eksekutif : '0')."</td>";
                    echo "<td>".($row->el_isolasi !== null ? $row->el_isolasi : '0')."</td>";
                    echo "<td>".(($row->el_isolasi + $row->el_ri_bpjs + $row->el_ri_umum + $row->el_ri_iks + $row->el_rj_bpjs + $row->el_rj_umum + $row->el_rj_iks + $row->el_eksekutif + $row->el_isolasi !== null) ? ($row->el_isolasi + $row->el_ri_bpjs + $row->el_ri_umum + $row->el_ri_iks + $row->el_rj_bpjs + $row->el_rj_umum + $row->el_rj_iks + $row->el_eksekutif + $row->el_isolasi) : '0')."</td>";
                    
                    echo "<td>".($row->f_ri_bpjs !== null ? $row->f_ri_bpjs : '0')."</td>";
                    echo "<td>".($row->f_ri_umum !== null ? $row->f_ri_umum : '0')."</td>";
                    echo "<td>".($row->f_ri_iks !== null ? $row->f_ri_iks : '0')."</td>";
                    echo "<td>".($row->f_rj_bpjs !== null ? $row->f_rj_bpjs : '0')."</td>";
                    echo "<td>".($row->f_rj_umum !== null ? $row->f_rj_umum : '0')."</td>";
                    echo "<td>".($row->f_rj_iks !== null ? $row->f_rj_iks : '0')."</td>";
                    echo "<td>".($row->f_eksekutif !== null ? $row->f_eksekutif : '0')."</td>";
                    echo "<td>".($row->f_isolasi !== null ? $row->f_isolasi : '0')."</td>";
                    echo "<td>".(($row->f_ri_bpjs + $row->f_ri_umum + $row->f_ri_iks + $row->f_rj_bpjs + $row->f_rj_umum + $row->f_rj_iks + $row->f_eksekutif + $row->f_isolasi !== null) ? ($row->f_ri_bpjs + $row->f_ri_umum + $row->f_ri_iks + $row->f_rj_bpjs + $row->f_rj_umum + $row->f_rj_iks + $row->f_eksekutif + $row->f_isolasi) : '0')."</td>";
                }
            }
            ?>
                                </tr>

                                <tr>
                                    <td>3</td>
                                    <td>Penerimaan</td>
                                    <?php
            $idx = 2;
            foreach($lap_pemeriksaan as $index=>$row) {
                if ($index == $idx) {
                    echo "<td>".($row->el_ri_bpjs !== null ? formatCurrency($row->el_ri_bpjs) : '0')."</td>";
                    echo "<td>".($row->el_ri_umum !== null ? formatCurrency($row->el_ri_umum) : '0')."</td>";
                    echo "<td>".($row->el_ri_iks !== null ? formatCurrency($row->el_ri_iks) : '0')."</td>";
                    echo "<td>".($row->el_rj_bpjs !== null ? formatCurrency($row->el_rj_bpjs) : '0')."</td>";
                    echo "<td>".($row->el_rj_umum !== null ? formatCurrency($row->el_rj_umum) : '0')."</td>";
                    echo "<td>".($row->el_rj_iks !== null ? formatCurrency($row->el_rj_iks) : '0')."</td>";
                    echo "<td>".($row->el_eksekutif !== null ? formatCurrency($row->el_eksekutif) : '0')."</td>";
                    echo "<td>".($row->el_isolasi !== null ? formatCurrency($row->el_isolasi) : '0')."</td>";
                    echo "<td>".(($row->el_isolasi + $row->el_ri_bpjs + $row->el_ri_umum + $row->el_ri_iks + $row->el_rj_bpjs + $row->el_rj_umum + $row->el_rj_iks + $row->el_eksekutif + $row->el_isolasi !== null) ? formatCurrency(($row->el_isolasi + $row->el_ri_bpjs + $row->el_ri_umum + $row->el_ri_iks + $row->el_rj_bpjs + $row->el_rj_umum + $row->el_rj_iks + $row->el_eksekutif + $row->el_isolasi)) : '0')."</td>";
                    
                    echo "<td>".($row->f_ri_bpjs !== null ? formatCurrency($row->f_ri_bpjs) : '0')."</td>";
                    echo "<td>".($row->f_ri_umum !== null ? formatCurrency($row->f_ri_umum) : '0')."</td>";
                    echo "<td>".($row->f_ri_iks !== null ? formatCurrency($row->f_ri_iks) : '0')."</td>";
                    echo "<td>".($row->f_rj_bpjs !== null ? formatCurrency($row->f_rj_bpjs) : '0')."</td>";
                    echo "<td>".($row->f_rj_umum !== null ? formatCurrency($row->f_rj_umum) : '0')."</td>";
                    echo "<td>".($row->f_rj_iks !== null ? formatCurrency($row->f_rj_iks ): '0')."</td>";
                    echo "<td>".($row->f_eksekutif !== null ? formatCurrency($row->f_eksekutif) : '0')."</td>";
                    echo "<td>".($row->f_isolasi !== null ? formatCurrency($row->f_isolasi ): '0')."</td>";
                    echo "<td>".(($row->f_ri_bpjs + $row->f_ri_umum + $row->f_ri_iks + $row->f_rj_bpjs + $row->f_rj_umum + $row->f_rj_iks + $row->f_eksekutif + $row->f_isolasi !== null) ? formatCurrency($row->f_ri_bpjs + $row->f_ri_umum + $row->f_ri_iks + $row->f_rj_bpjs + $row->f_rj_umum + $row->f_rj_iks + $row->f_eksekutif + $row->f_isolasi) : '0')."</td>";
                }
            }
            ?>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
                <a href="<?php echo base_url('lab/labclaporan/excel_lap_capkin/'.$tanggal.'/'.$tampil) ?>"
                    class="btn btn-danger" target="_blank">Excel</a>
            </div>
        </div>
    </div>
</div>
</div><!-- end row -->

<?php
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_left");
    }
?>