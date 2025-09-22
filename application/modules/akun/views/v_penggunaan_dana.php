<?php
$this->load->view('layout/header_left.php');
?>
    <style>
        .datepicker{z-index:1151 !important;}
        @media (min-width: 768px) {
            .modal-lg {
                max-width: 1024px;
            }
        }
        .table thead > tr > th{
            border-top: 1px solid black; 
            border-bottom: 1px solid black; 
            border-left: 1px solid black; 
            border-right: 1px solid black;
        }
    </style>
    <script type='text/javascript'>
        var table, tableObat, tableBeli;
        var det_item_id, det_id_po, det_jml_kemasan, det_harga_po, det_satuan_item;
        $(function() {
            $('.datepicker').datepicker({
                format: "yyyy-mm-dd",
                endDate: '0',
                autoclose: true,
                todayHighlight: true
            });

            $("#mata_anggaran").change(function() {
                var ma = $(this).val();
                $.ajax({
                    url: '<?php echo site_url(); ?>akun/Crsakun/get_child_manggar',
                    type: 'POST',
                    data: {
                        ma:ma
                    },
                    dataType: "text",
                    success: function (response) {
                        $("#sub_manggar").html(response);
                    }
                });
            });

            table = $('#example').DataTable();
        });

        function simpanTransaksi() {
            $.ajax({
                url: '<?php echo site_url(); ?>akun/Crsakun/saveTransaksi',
                type: 'POST',
                data: $('#frmTransaksi').serialize(),
                dataType: "json",
                success: function (response) {
                    if(response['data'] === 'sukses'){
                        swal("Sukses", "Transaksi Berhasil Ditambahkan", "success");

                        $('#frmTransaksi').reset();

                        $('#rencana').val('');
                        $('#mata_anggaran').val('');
                        $('#sub_manggar').val('');
                        $('#jenis_penggunaan').val('');
                        $('#sumber_dana').val('');
                        $('#nominal').val('');
                        $('#keterangan').val('');

                        $('#tambahModal').modal('hide');
                    }else{
                        swal("Perhatian!", "Oops! Terjadi Kesalahan", "error");
                    }
                }
            });
        }

       

    </script>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div style="background: #e4efe0">
                <div class="inner">
                    <div class="container-fluid"><br>
                        <form id="frmCari" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-sm-2 control-label">Tanggal Input</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control datepicker" name="tgl0" id="tgl0" >
                                </div>
                                <label class="col-sm-1 control-label">s/d</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control datepicker" name="tgl1" id="tgl1" >
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-danger" data-toggle="modal" type="button" data-target="#tambahModal">Tambah Data</button>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-2">
                                </div>
                                <div class="col-sm-10">
                                    <button type="button" id="btnCari" class="btn btn-primary">Cari</button>
                                    <button type="reset" id="btnReset" class="btn btn-primary">Reset</button>
                                    <button type="button" id="submit" onclick="export_excel()" class="btn btn-warning"><i class="fa fa-print"> &nbsp;Export Excel</i> </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-xs-9" id="alertMsg">
                            <?php echo $this->session->flashdata('alert_msg'); ?>
                        </div>
                    </div>
                </div>
                <div class="card-block">
                    <div class="modal-body">
                        <table class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" id="example">
                            <thead >

                            <tr style="border-top: 2px solid black; border-left: 2px solid black; border-right: 2px solid black;">
                                <th align="center" rowspan="2">RENCANA PENGGUNAAN<br/>URAIAN KEGIATAN</th>
                                <th rowspan="2" class="text-center">MA</th>
                                <th rowspan="2" class="text-center">DETAIL</th>
                                <th colspan="2"class="text-center">PAGU</th>
                                <th rowspan="2" class="text-center">TOTAL</th>
                                <th colspan="2" class="text-center">PENGGUNAAN</th>
                                <th rowspan="2" class="text-center">TOTAL<br/>PENGGUNAAN</th>
                                <th colspan="2"class="text-center">SISA PAGU</th>
                                <th rowspan="2" class="text-center">TOTAL SISA</th>
                                <th rowspan="2" class="text-center" >Aksi</th>
                            </tr>
                            <tr style="border-top: 1px solid black; border-bottom: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;">
                                <th class="text-center" >YMS</th>
                                <th class="text-center">BPJS</th>
                                <th class="text-center">YMS</th>
                                <th class="text-center">BPJS</th>
                                <th class="text-center">YMS</th>
                                <th class="text-center">BPJS</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Insert-->
    <div class="modal fade" id="tambahModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-default modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Tambah Data Penggunaan Dana</h4>
                </div>
                <div class="modal-body">
                    <form id="frmTransaksi" class="form-horizontal" >
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Rencana Penggunaan</label>
                            <div class="col-sm-4">
                                <select name="rencana" id="rencana" class="form-control" style="width:100%" required>
                                    <option value="" selected>---- Pilih Rencana ----</option>
                                    <?php
                                    foreach ($rencana as $rens) {
                                    ?>
                                        <option value="<?=$rens->id?>"><?=$rens->rencana_penggunaan?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Mata Anggaran</label>
                            <div class="col-sm-4">
                                <select name="mata_anggaran" id="mata_anggaran" class="form-control" style="width:100%">
                                    <option value="">---- Pilih Mata Anggaran ----</option>
                                    <?php
                                    foreach ($mata_anggaran as $ma) {
                                        ?>
                                        <option value="<?=$ma->kode_manggaran?>"><?=$ma->kode_manggaran." - ".$ma->nm_manggaran?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Sub Mata Anggaran</label>
                            <div class="col-sm-4" id="lsubmanggar">
                                <select name="sub_manggar" id="sub_manggar" class="form-control" style="width:100%">

                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Jenis Penggunaan</label>
                            <div class="col-sm-4">
                                <select name="jenis_penggunaan" id="jenis_penggunaan" class="form-control" style="width:100%">
                                    <option value="pagu">- PAGU -</option>
                                    <option value="penggunaan">- PENGGUNAAN -</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Sumber Dana</label>
                            <div class="col-sm-4">
                                <select name="sumber_dana" id="sumber_dana" class="form-control" style="width:100%">
                                    <option value="yms">- YANMASUM -</option>
                                    <option value="bpjs">- BPJS -</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Nominal</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <span class="input-group-addon">Rp</span>
                                    <input type="text" class="form-control col-sm-10" placeholder="0" name="nominal" id="nominal">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 control-label">Keterangan Biaya</label>
                            <div class="col-sm-7">
                                <textarea class="form-control" name="keterangan" id="keterangan"></textarea>
                                <!--<input type="text" class="form-control" name="jatuh_tempo" id="jatuh_tempo" required="" placeholder="Tgl Jatuh Tempo">-->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button id="btnClose" class="btn btn-primary pull-right" type="button" data-dismiss="modal">Close</button>
                            <button id="btnSimpan" name="bt_selesai" class="btn btn-danger" type="button" onclick="simpanTransaksi()">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
     var objTable;

        objTable = $('#example').DataTable( {
            ajax: "<?php echo site_url('akun/Crsakun/dataPenggunaanDana'); ?>",
            columns: [
                { data: "rencana_penggunaan" },
                { data: "ma" },
                { data: "detail" },
                { data: "pagu_yms" },
                { data: "pagu_bpjs" },
                { data: "pagu_total" },
                { data: "penggunaan_yms" },
                { data: "penggunaan_bpjs" },
                { data: "penggunaan_total" },
                { data: "sisa_yms" },
                { data: "sisa_bpjs" },
                { data: "sisa_total" },
                { data: "aksi" }
            ],
            columnDefs: [
                { targets: [ 12 ], visible: false }
            ] ,
            searching: true,
            paging: true,
            bDestroy : true,
            bSort : false,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
        } );

     $("#btnCari").click(function () {
            $.ajax({
                dataType: "json",
                type: 'POST',
                data: $('#frmCari').serialize(),
                url: "<?php echo site_url('akun/Crsakun/dataPenggunaanDana'); ?>",
                success: function( response ) {
                    objTable.clear().draw();
                    objTable.rows.add(response.data);
                    objTable.columns.adjust().draw();
                }
            });
        });
</script>

<?php
$this->load->view('layout/footer_left.php');
?>