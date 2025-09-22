<?php
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else if ($role_id == 37){
    $this->load->view("layout/header_dashboard");
} else {
    $this->load->view("layout/header_horizontal");
}
?>
    <style type="text/css">
        tbody > tr > td {
            border: 2px solid #000;
        }
        .table-bordered td, .table-bordered th {
            border: 1px solid #000;
        }
    </style>
    <script type="text/javascript">
        $(function(){
        tableObat = $('#tableObat').DataTable({
            columns: [
                { data: "description" },
                { data: "satuank" },
                { data: "qty_po" },
                { data: "hargabeli" },
                { data: "subtotal" }
            ],
            order:  [[ 0, "asc" ]]
        });
            $('#detailModal').on('shown.bs.modal', function(e) {
                //get data-id attribute of the clicked element
                var id = $(e.relatedTarget).data('id');
                var no = $(e.relatedTarget).data('no');
                $('#sDetailID').html(no);
                $('#hideIdPO').val(id);
                $.ajax({
                  dataType: "json",
                  type: 'POST',
                  data: {id:id},
                  url: "<?php echo site_url(); ?>dashboard/get_detail_farmasi_pembelian",
                  success: function( response ) {
                        tableObat.clear().draw();
                        tableObat.rows.add(response.data);
                        tableObat.columns.adjust().draw(); 

                        $("#totals").html('<h3>' + response.total + '</h3>');
                  }
                }); 
            });
        });

        $(document).on("click","#btnClose",function(){
            $('#detailModal').modal('hide');
        });
    </script>
    <!-- Main content -->
    <section class="content">
        <!-- <header class="floating-header">
    <div class="floating-menu-btn">
      <div class="floating-menu-toggle-wrap">
        <div class="floating-menu-toggle">
          <span class="bar"></span>
          <span class="bar"></span>
          <span class="bar"></span>
        </div>
      </div>
    </div>
    <div class="main-navigation-wrap">
      <nav class="main-navigation" data-back-btn-text="Back">
        <ul class="menu">
          <li class="delay-1"><a href="<?php echo site_url('dashboard'); ?>">Menu Utama</a></li>
          <li class="delay-1"><a href="<?php echo site_url('Change_password'); ?>">Ganti Password</a></li>
          <li class="delay-2"><a href="<?php echo site_url('logout'); ?>">Logout</a></li>
        </ul>
      </nav>
    </div>
  </header> -->
        <!-- Main row -->
        <div class="row">
            <div class="col-md-12">
                <!-- AREA CHART -->
                <div class="card card-outline-primary">
                    <div class="card-footer">
                        <div class="col-sm-10">
                            <div class="form-inline">
                                <div class="form-group">
                                    <input style="width: 100px;" type="text" id="date_picker_awal" class="form-control form-control-sm date_picker_awal" placeholder="Tanggal awal" name="date_picker_awal" onchange="cek_tgl_awal(this.value)" required>&nbsp;
                                    <input style="width: 100px;" type="text" id="date_picker_akhir" class="form-control form-control-sm date_picker_akhir" placeholder="Tanggal akhir" name="date_picker_akhir" onchange="cek_tgl_akhir(this.value)" required>&nbsp;
                                    <button class="btn btn-primary btn-xs" type="submit" onclick="pilih_obat()">Cari</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-block chart-responsive">
                        <!-- <p class="col-sm-2">Cari Data</p> -->
                        <!-- <div class="chart" id="obat" style="height: 450px;width: 100%;"></div> -->
                        <div class="table-responsive">
                        <table class="display nowrap table table-hover table-bordered dataTable" id="example" style="font-size: 14px; border: 2px solid black;" >
                            <thead style="border: 2px solid black; font-weight: bold;">
                            <tr style="border: 2px solid black;">
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">No</td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">No Faktur</td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">Tanggal</td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">Supplier</td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">Jatuh Tempo</td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">Total</td>
                                <td style="border: 2px solid black; vertical-align: middle;" align="center">Aksi</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $no = 0; $total = 0;
                            foreach ($pembelian as $row){
                                $no++; $total += $row->total_obat;
                                ?>
                                <tr>
                                    <td><?=$no?></td>
                                    <td><?=$row->no_faktur?></td>
                                    <td><?=$row->tgl_faktur?></td>
                                    <td><?=$row->company_name?></td>
                                    <td><?=$row->jatuh_tempo?></td>
                                    <td align="right"><?=number_format($row->total_obat, '0',',', '.')?></td>
                                    <!-- <td align="center"><button type="button" class="btn btn-danger"><i class="fa fa-search"></i> Detail</button></td> -->
                                    <td align="center"><button class="btn btn-danger" data-toggle="modal" data-target="#detailModal" data-id="<?=$row->id_po?>" data-no="<?=$row->no_faktur?>"><i class="fa fa-search"></i> Details</button></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="5"><h3><b>TOTAL</b></h3></td>
                                <td colspan="2" align="right"><h3>Rp. <?=number_format($total, '0',',', '.')?></h3></td>
                            </tr>
                            </tbody>
                        </table>
                        </div>

                        <div class="overlay" id="overlay">
                            <!--<i class="fa fa-refresh fa-spin"></i>-->
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->

    </section><!-- /.content -->

    <!-- Modal Insert-->
<div class="modal fade" id="detailModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-default modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Detail Pembelian Obat No Faktur : <span id="sDetailID"></h4>
        </div>
        <div class="modal-body table-responsive m-t-0">                         
            <table id="tableObat" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0">
              <thead>
              <tr>
                <th><p align="center">Nama Obat</p></th>
                <th><p align="center">Satuan</p></th>
                <th><p align="center">Jml PO</p></th>
                <th><p align="center">Harga Beli</p></th>
                <th><p align="center">Subtotal</p></th>
              </tr>
              </thead>
            </table>
            <br/><br/>
            <table cellspacing="0" width="100%" class="display">
                <thead>
                <tr>
                    <th width="80%"><div align="right"><h3>Total</h3></div></th>
                    <th width="20%"><div align="right" id="totals"></div></th>
                </tr>
                </thead>
            </table>
        </div>
        <div class="modal-footer">  
            <button id="btnClose" class="btn btn-primary pull-right">Close</button>
        </div>
        </div>
    </div>
</div>
<?php
if ($role_id == 1) {
    $this->load->view("layout/footer_left");
} else {
    $this->load->view("layout/footer_horizontal");
}
?>