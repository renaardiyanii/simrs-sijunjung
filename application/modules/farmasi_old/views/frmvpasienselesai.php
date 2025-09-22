<?php
	$this->load->view('layout/header_left.php');
?>
<style type="text/css">
    .modal-lg{
        width: 100%;
    }
    
</style>

    <script type='text/javascript'>
        var table, tableObat;
        //-----------------------------------------------Data Table
        $(document).ready(function() {
            $('#example').DataTable({
                ajax: "<?=base_url('farmasi/Frmcreturjual/get_list_pasien')?>",
                columns:[
                    { data: "no" },
                    { data: "aksi" },
                    { data: "tgl_kunjungan" },
                    { data: "no_resep" },
                    { data: "no_register" },
                    { data: "nama" },
                    { data: "kelas" },
                    { data: "idrg" },
                    { data: "bed" },
                    { data: "status" },
                   
                ],
                columnDefs: [
                    { targets: [ 0 ], visible: true, className: "text-center" },
                    { targets: [ 1 ], visible: true, className: "text-center" },
                    { targets: [ 2 ], visible: true, className: "text-center" },
                    { targets: [ 3 ], visible: true, className: "text-center" },
                    { targets: [ 4 ], visible: true, className: "text-center" },
                    { targets: [ 5 ], visible: true, className: "text-center" },
                    { targets: [ 6 ], visible: true, className: "text-center" },
                    { targets: [ 7 ], visible: true, className: "text-center" },
                    { targets: [ 8 ], visible: true, className: "text-center" },
                    { targets: [ 9 ], visible: true, className: "text-center" }
                ]
            });

            tableObat = $('#detailTable').DataTable({
                columns: [
                    { data: "no" },
                    { data: "tgl_kunjungan" },
                    { data: "id_obat" },
                    { data: "harga_obat" },
                    { data: "subtotal" },
                    { data: "qty_beli" },
                    { data: "qty_retur" },
                    { data: "aksi" }
                    
                ],
                bFilter: false,
                bPaginate: false,
                destroy: true,
                order:  [[ 0, "asc" ]]
            });

            $('#detailModal').on('shown.bs.modal', function(e) {
                var id = $(e.relatedTarget).data('id');
                $('#no_resep').html(id);

                $.ajax({
                    dataType: "json",
                    type: 'POST',
                    data: {id:id},
                    url: "<?php echo site_url(); ?>farmasi/Frmcreturjual/get_detail_list",
                    success: function( response ) {
                        tableObat.clear().draw();
                        tableObat.rows.add(response.data);
                        tableObat.columns.adjust().draw();
                    }
                });
                //getDetailObat(id);
            });
        } );
        //---------------------------------------------------------

        function getDetailObat(id) {
            $.ajax({
                dataType: "json",
                type: 'POST',
                data: {id:id},
                url: "<?php echo site_url(); ?>farmasi/Frmcreturjual/get_detail_list",
                success: function( response ) {
                    tableObat.clear().draw();
                    tableObat.rows.add(response.data);
                    tableObat.columns.adjust().draw();
                }
            });
        }

        $(function() {
            $('#date_picker').datepicker({
                format: "yyyy-mm-dd",
                endDate: '0',
                autoclose: true,
                todayHighlight: true
            });

        });

        function retur_barang(no, idresep, idinventory, noresep) {
            var qty_retur = $("#qty_retur"+no).val();
            //alert(qty_retur);
            swal({
                title: "Ubah Item Ini?",
                text: "Mengubah Data ini berarti Mengubah kembali Stok yang Telah Masuk.",
                type: "error",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                confirmButtonColor: '#F00'
            },
            function(){
                $.ajax({
                    url: "<?=site_url()?>farmasi/Frmcreturjual/save_retur_barang",
                    type: "POST",
                    dataType: "json",
                    data:{
                        idresep: idresep,
                        id_inventory: idinventory,
                        qty: qty_retur
                    },
                    success: function (response) {
                        if(response.sukses) {
                            swal({
                                title: "Data Berhasil Diubah!",
                                text: "Akan menghilang dalam 3 detik.",
                                timer: 3000,
                                showConfirmButton: false,
                                showCancelButton: true
                            });

                            getDetailObat(noresep);
                        }
                    }
                });
            });
        }

        function hapus_barang(no, idresep, idinventory, noresep) {
            //alert(qty_retur);
            swal({
                title: "Hapus Obat Ini?",
                text: "Mengubah Data ini berarti Mengubah kembali Stok yang Telah Masuk.",
                type: "error",
                showCancelButton: true,
                closeOnConfirm: false,
                showLoaderOnConfirm: true,
                confirmButtonColor: '#F00'
            },
            function(){
                $.ajax({
                    url: "<?=site_url()?>farmasi/Frmcreturjual/save_hapus_item",
                    type: "POST",
                    dataType: "json",
                    data:{
                        idresep: idresep,
                        id_inventory: idinventory
                    },
                    success: function (response) {
                        if(response.sukses) {
                            swal({
                                title: "Data Berhasil Diubah!",
                                text: "Akan menghilang dalam 3 detik.",
                                timer: 3000,
                                showConfirmButton: false,
                                showCancelButton: true
                            });

                            getDetailObat(noresep);
                        }
                    }
                });
            });
        }
    </script>

    <section class="content-header">
        <?php
        echo $this->session->flashdata('success_msg');
        ?>
    </section>
    <div class="row">
        <div class="col-lg-12 col-md-12">
        
        <div class="card">
                <div class="card-header">
                    <h3 align="center">DAFTAR PENGAMBILAN RESEP PASIEN</h3>
                </div>
                <div class="card-block">
                    <div class="table-responsive m-t-0">	
                        <table id="example" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>No</th>
                                <th width="15%">Aksi</th>
                                <th>Tanggal Kunjungan</th>
                                <th>No Resep</th>
                                <th>No Registrasi</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Ruangan</th>
                                <th>Bed</th>
                                <th>Cara Bayar</th>
                            
                            </tr>
                            </thead>
                        </table>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="detailModal" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-default modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Retur Penjualan, No Resep: <span id="no_resep"></span></h4>
                </div>
                <div class="modal-body table-responsive">
                    <table id="detailTable" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Tgl Permintaan</th>
                            <th>Item Obat</th>
                            <th>Harga Obat</th>
                            <th>Subtotal</th>
                            <th>Qty Beli</th>
                            <th>Qty Retur</th>
                            <th><div align="center">Aksi</div></th>
                        </tr>
                        </thead>
                    </table>
                    <br>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary pull-right" data-toggle="dismiss">Simpan</button>
                </div>
            </div>
        </div>
    </div>
<?php
	$this->load->view('layout/footer_left.php');
?>