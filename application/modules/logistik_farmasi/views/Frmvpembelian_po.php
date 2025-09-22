<?php
  $this->load->view('layout/header_left.php');
?>
<style>
.datepicker {
    z-index: 1151 !important;
}

@media (min-width: 992px) {
    .modal-lg {
        max-width: 1280px;
    }
}
</style>
<script src="<?= base_url('assets/js/toastr.js') ?>"></script>
<script type='text/javascript'>
var table, tableObat, tableBeli;
var det_item_id, det_id_po, det_jml_kemasan, det_harga_po, det_satuan_item;
$(function() {
    $("#itemForm").hide();
    // $('.datepicker').datepicker({
    //     format: "yyyy-mm-dd",
    //     endDate: '0',
    //     autoclose: true,
    //     todayHighlight: true
    // });

    // $('#jatuh_tempo').datepicker({
    //     format: "yyyy-mm-dd",
    //     changeMonth: true,
    //     changeYear: true,
    //     autoclose: true,
    //     todayHighlight: true
    // });

    table = $('#example').DataTable({
        ajax: "<?php echo site_url(); ?>logistik_farmasi/Frmcpo/get_pembelian_po_list",
        columns: [{
                data: "id_po"
            },
            {
                data: "no_po"
            },
            {
                data: "tgl_po"
            },
            {
                data: "company_name"
            },
            {
                data: "sumber_dana"
            },
            {
                data: "user"
            },
            {
                data: "status"
            },
            {
                data: "aksi"
            }
        ],
        columnDefs: [{
            targets: [0],
            visible: false
        }],
        bFilter: true,
        bPaginate: true,
        destroy: true,
        order: [
            [2, "asc"],
            [1, "asc"]
        ]
    });
    tableObat = $('#tableObat').DataTable({
        //ajax: "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_amprah_detail_list",
        columns: [{
                data: "description"
            },
            {
                data: "qty_beli"
            },
            {
                data: "qty_po",
                render: $.fn.dataTable.render.number('.', ',', 0, '')
            },
            {
                data: "jml_kemasan"
            },
            {
                data: "hargabeli"
            },
            {
                data: "harga_item"
            },
            {
                data: "subtotal"
            },
            //{ data: "subtotal", render: $.fn.dataTable.render.number('.', ',', 0, '') },
            {
                data: "id_po"
            },
            {
                data: "item_id"
            }
        ],
        columnDefs: [{
                targets: [7],
                visible: false
            },
            {
                targets: [8],
                visible: false
            }
        ],

        bFilter: false,
        bPaginate: false,
        destroy: true,
        order: [
            [0, "asc"]
        ]
    });
    tableBeli = $('#tableBeli').DataTable({
        //ajax: "<?php echo site_url(); ?>logistik_farmasi/Frmcamprah/get_amprah_detail_list",

        columns: [
            {
                data: "id"
            },
            {
                data:null,
                render:function(data,type,row){
                    return `
                    <button class="btn ${row.verifikasi_gudang?"btn-primary":'btn-danger'}" type="button">${row.verifikasi_gudang?"Telah Terverifikasi Gudang":'Belum Terverifikasi Gudang'}</button><br>
                    <button class="btn ${row.verifikasi_penerima?"btn-primary":"btn-danger"}" type="button">${row.verifikasi_penerima?"Telah Terverifikasi Penerima":'Belum Terverifikasi Penerima'}</button>
                    `;
                }
            },
            {
                data: "qty_beli"
            },
            {
                data: "satuan"
            },
            {
                data: "hargabeli"
            },
            {
                data: "hargajual"
            },
            {
                data: "batch_no"
            },
            {
                data: "diskon_persen"
            },
            {
                data: "expire_date"
            },
            {
                data:null,
                render:function(data,type,row){
                    return `
                    <button onclick="hapuspo(${row.id})" class="btn btn-danger" type="button">Hapus</button>
                    `;
                }
            },
        ],
        columnDefs: [{
                targets: [0],
                orderable: false
            },
            {
                targets: [1],
                orderable: false
            },
            {
                targets: [2],
                orderable: false
            },
            {
                targets: [3],
                orderable: false
            },
            {
                targets: [4],
                orderable: false
            },
            {
                targets: [5],
                orderable: false
            },
            {
                targets: [6],
                orderable: false
            }
        ],
        bFilter: false,
        bPaginate: false,
        order: [
            [0, "desc"]
        ],
        destroy: true
    });

    $('#no_po').autocomplete({
        serviceUrl: '<?php echo site_url();?>logistik_farmasi/Frmcpo/auto_no_po',
        onSelect: function(suggestion) {
            $.ajax({
                dataType: "json",
                data: {
                    id: suggestion.id
                },
                type: "POST",
                url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpo/get_info",
                success: function(response) {
                    //alert(JSON.stringify(response));
                    $('#tgl0').val(response.tgl_po);
                    $('#tgl1').val('');
                    $('#tgl1').prop('disabled', true);
                    $('#supplier_id').val(response.supplier_id);
                    $('#supplier_id').prop("disabled", true);
                }
            });
            $('#btnCari').focus();
        }
    });
    $('#btnCari').click(function() {
        refreshPO();
    });

    $('#detailModal').on('shown.bs.modal', function(e) {
        //get data-id attribute of the clicked element

        var id = $(e.relatedTarget).data('id');
        var no = $(e.relatedTarget).data('no');
        var open = $(e.relatedTarget).data('open');
        var qty = $(e.relatedTarget).data('qty');
        var qtyb = $(e.relatedTarget).data('qtyb');
        document.getElementById("id_po").value = id;
        $('#sDetailID').html(no);
        tableBeli.clear().draw();
        $.ajax({
            dataType: "json",
            type: 'POST',
            data: {
                id: id
            },
            url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpembelian_po/get_detail_list",
            success: function(response) {
                $("#tgl_faktur").val('');
                $("#no_faktur").val('');
                $("#jatuh_tempo").val('');
                $("#cara_bayar").val('');
                $("#keterangan").val('');
                $("#materai").val('0');
                $("#diskon_transaksi").val('0');
                tableObat.clear().draw();
                tableObat.rows.add(response.data);
                tableObat.columns.adjust().draw();
            }
        });
        $('#tableObat tbody').on('click', 'tr', function() {
            var vdata = tableObat.row(this).data();
            // console.log(vdata);

            // console.log(vdata['qty_beli']);
            $('#tableObat tbody tr').removeClass('selected');
            $(this).addClass('selected');
            det_item_id = vdata['item_id'];
            det_id_po = vdata['id_po'];
            det_jml_kemasan = vdata['jml_kemasan'];
            det_harga_po = vdata['hargabeli'];
            det_satuan_item = vdata['satuan_item'];
            
            // disini parsing data form 
            $("#qty_beli").val(vdata['qty_beli']);
            $("#qty_beli_kecil").val(vdata['qty_po']);
            $("#satuan").val(vdata['satuank']);
            $("#hargabeli").val(vdata['hargabeli']);
            $("#hargabeli_kecil").val(vdata['harga_item']);
            $("#description").val(vdata['description']);
            $("#hargajual").val();
            $("#batch_no").val();
            $("#diskon_item").val();
            $("#expire_date").val();
            $("#description").val();
            $("#satuank").val(vdata['satuank']);
            $("#qty").val(vdata['qty_po']);
            refreshDetailBeli();




            // $("#itemForm").show();
        });
        if ((open == 1 && (qty - qtyb == 0)) || (open == 2 && (qty - qtyb == 0))) {
            // $("input[name='bt_selesai']").prop("disabled", "false");
            // document.getElementById("bt_selesai").disabled = false;
            // document.getElementById("bt_selesai").attr("hidden", false);
            //$('#bt_selesai').attr('hidden', false);
        } else {
            // $("input[name='bt_selesai']").prop("disabled", "true");
            // document.getElementById("bt_selesai").disabled = true;
            // document.getElementById("bt_selesai").attr("hidden", true);
            //$('#bt_selesai').attr('hidden', true);
        }
    });
    /*
     $('#btnAcc').click( function() {
     var vdata = [[]];
     var idata = -1;
     var qty, vbatch, vexdate;
     $('#tableObat').find('tr').each(function(i, val) {
     if (i>0){
     vbatch = $("#batch_no"+i).val();
     vexdate = $("#expire_date"+i).val();
     qty = $("#qty_beli"+i).val();
     if ((qty != "")&&(vbatch == "")){
     alert("Mohon lengkapi Batch No & Tanggal Expired!");
     $("#batch_no"+i).focus();
     }
     if ((vbatch != "")&&(vexdate == "")){
     alert("Mohon lengkapi Tanggal Expired!");
     $("#expire_date"+i).focus();
     }
     if (((qty != "")&&(vbatch != ""))&&(vexdate != "")){
     idata = idata + 1;
     var $elements = $(this).find('input')
     var serialized = $elements.serializeArray();
     vdata[idata] = serialized;
     }
     }
     });
     if (idata >= 0){
     $.ajax({
     dataType: "html",
     data: {json: vdata },
     type: "POST",

     success: function( response ) {
     $('#detailModal').modal('hide');
     refreshAmprah();
     }
     });
     }
     return false;
     } );
     */

    $('#btnReset').click(function() {
        $('#tgl1').prop('disabled', false);
        $('#supplier_id').prop("disabled", false);
        $('#no_po').focus();
    });
});

$(document).on('click', '#btnSimpan', function(event) {
    
    vbatch = $("#batch_no").val();
    vexdate = $("#expire_date").val();
    vsatuan = $("#satuan").val();
    vqty = parseInt($("#qty_beli").val());
    vmax = parseInt($("#qty_beli").prop('max'));

    vtanggal = $("#tgl_terima").val();
  

    if (vtanggal == "") {

        alert("Lengkapi Data Faktur Terlebih Dahulu");
        $("#no_faktur").focus();
        return false;
    } else {
        if (vqty > vmax) {
            alert("Total jumlah pembelian melebihi jumlah PO ");
            $("#qty_beli").val('');
            $("#qty_beli").focus();
            return false;
        } else {
            if (((vqty == "") && (vbatch == "")) && (vexdate == "")) {
                alert("Mohon lengkapi Jumlah Beli, Batch No & Tanggal Expired!");
                $("#qty_beli").focus();
            }
            if ((vqty != "") && (vbatch == "")) {
                alert("Mohon lengkapi Batch No & Tanggal Expired!");
                $("#batch_no").focus();
            }
            if ((vbatch != "") && (vexdate == "")) {
                alert("Mohon lengkapi Tanggal Expired!");
                $("#expire_date").focus();
            }
            if (((vqty != "") && (vbatch != "")) && (vexdate != "")) {

                var me = $(this);
                event.preventDefault();
                if (me.data('requestRunning')) {
                    return;
                }

                me.data('requestRunning', true);

                $.ajax({
                    dataType: "json",
                    type: 'POST',
                    data: {
                        item_id: det_item_id,
                        id_po: det_id_po,
                        tgl_terima: vtanggal,
                        tgl_faktur: $('#tgl_faktur').val(),
                        tgl_do: $('#tgl_do').val(),
                        no_faktur: $('#no_faktur').val(),
                        no_do: $('#no_do').val(),
                        jatuh_tempo: $('#jatuh_tempo').val(),
                        cara_bayar: $('#cara_bayar').val(),
                        keterangan: $('#keterangan').val(),
                        ppn: $('#ppn').val(),
                        kemasan: $('#kemasan').val(),
                        isi: $('#isi').val(),
                        qty_beli: $('#qty_beli').val(),
                        qty_beli_kecil: $('#qty_beli_kecil').val(),
                        hargabeli: $('#hargabeli').val(),
                        hargabeli_kecil: $('#hargabeli_kecil').val(),
                        satuan: $('#satuan').val(),
                        hargajual: $('#hargajual').val(),
                        batch_no: $('#batch_no').val(),
                        expire_date: $('#expire_date').val(),
                        diskon_item: $("#diskon_item").val(),
                        total: $("#total").val(),
                        description: $('#description').val(),

                    },
                    url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpembelian_po/save_detail_beli",
                    success: function(response) {
                        refreshDetailBeli();
                    },
                    complete: function() {
                        me.data('requestRunning', false);
                    }
                });
            }
        }
    }
});
/*
 function hapusBeli(vid){
 $.ajax({
 dataType: "json",
 type: 'POST',
 data: { id:vid},

 success: function( response ) {
 refreshDetailBeli();
 }
 });
 }
 */
    function pilihkemasan(val)
    {
        if(val.includes('/'))
        {
            $("#isi").val(val.split('/')[1]);
        }else{
            $("#isi").val('1');
        }

        qty_besar_obat = $("#qty_beli").val();
        var harga_besar = $("#hargabeli").val();
        isi = $("#isi").val();

        qty_kecil = qty_besar_obat * isi;
        var harga_besar_last = parseFloat(harga_besar.replace(/,/g, ''));
        total_harga_obat = harga_besar_last * qty_besar_obat;
        total_harga_kecil = harga_besar / isi;
        total_margin = total_harga_kecil * 0.2;
        total_ppn = total_harga_kecil * 0.11;
        total_harga_jual = total_harga_kecil + total_margin + total_ppn;
        $("#total").val(total_harga_obat);
        $("#qty_beli_kecil").val(qty_kecil);
        $("#hargabeli_kecil").val(total_harga_kecil);
        $("#hargajual").val(total_harga_jual);

    }

    function set_qty_kecil(val)
    {
        qty_besar_obat = $("#qty_beli").val();
        isi = $("#isi").val();
        var harga_besar = $("#hargabeli").val();
        var harga_kecil = $("#hargabeli_kecil").val();
       
        var harga_besar_last = parseFloat(harga_besar.replace(/,/g, ''));
        var harga_kecil_last = parseFloat(harga_kecil.replace(/,/g, ''));
    
        total_obat_kecil = qty_besar_obat * isi;
        total_harga_obat = harga_besar_last * qty_besar_obat;
        $("#qty_beli_kecil").val(total_obat_kecil);
        $("#total").val(total_harga_obat);
    }

    function set_harga(val){
        qty_besar_obat = $("#qty_beli").val();
        var harga_besar = $("#hargabeli").val();
        var harga_besar_last = parseFloat(harga_besar.replace(/,/g, ''));
        isi = $("#isi").val();
        Harga_kecil = harga_besar_last / isi;
        total_obat = harga_besar_last *  qty_besar_obat;
        $("#hargabeli_kecil").val(Harga_kecil);
        $("#total").val(total_obat);

        total_margin = Harga_kecil * 0.2;
        total_ppn = Harga_kecil * 0.11;
        total_harga_jual = Harga_kecil + total_margin + total_ppn;
        $("#hargajual").val(total_harga_jual);


    }

    function set_diskon(){
        total_harga = $("#total").val();
        diskon_persen = $("#diskon_item").val();
        jmlh_diskon = diskon_persen / 100;
        harga_diskon = total_harga * jmlh_diskon;
        total_diskon = total_harga - harga_diskon;
        $("#total").val(total_diskon);
    }

function refreshPO() {
    $.ajax({
        url: '<?php echo site_url(); ?>logistik_farmasi/Frmcpo/get_pembelian_po_list',
        type: 'POST',
        data: $('#frmCari').serialize(),
        dataType: "json",
        success: function(response) {
            //alert(JSON.stringify(response.data));
            table.clear().draw();
            table.rows.add(response.data);
            table.columns.adjust().draw();
        }
    });
}

function refreshDetailBeli() {
    $.ajax({
        dataType: "json",
        type: 'POST',
        data: {
            item_id: det_item_id,
            id_po: det_id_po
        },
        url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpembelian_po/get_detail_beli",
        success: function(response) {
            if(response.data.length>0){
                let sisakuota = response.data[0].qty;
                let total = 0;
                response.data.map((e)=>{
                   
                    total+= e.qty_beli;
                })
                console.log(sisakuota);
                console.log(total);
                if(sisakuota>total){
                    $("#itemForm").show();
                }else{
                    $("#itemForm").hide();

                }
            }else{
                $("#itemForm").show();
            }
            tableBeli.clear().draw();
            tableBeli.rows.add(response.data);
            tableBeli.columns.adjust().draw();
        }
    });
}

function export_excel() {
    var d = new Date();
    tglawal = document.getElementById("tgl0").value;
    if (tglawal === "") {
        tglawal = "<?php echo date('Y-m-d');?>"
    }
    tglakhir = document.getElementById("tgl1").value;
    if (tglakhir === "") {
        tglakhir = "<?php echo date('Y-m-d');?>"
    }
    url = "<?php echo base_url('logistik_farmasi/Frmcpembelian_po/export_excel')?>";
    swal({
            title: "Export To Excel",
            text: "Benar Akan Export?",
            type: "info",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },
        function() {
            window.open(url + '/' + tglawal + '/' + tglakhir, "_blank");
            // alert(url+'/'+tglawal+'/'+tglakhir);
            swal({
                title: "Data Excel Berhasil Di download.",
                text: "Akan menghilang dalam 3 detik.",
                timer: 3000,
                showConfirmButton: false,
                showCancelButton: true
            });
        });
}


//unchecked ppn
$(document).on("click", "input[name='ppn']", function() {
    thisRadio = $(this);
    if (thisRadio.hasClass("imCek")) {
        thisRadio.removeClass("imCek");
        thisRadio.prop('checked', false);
    } else {
        thisRadio.prop('checked', true);
        thisRadio.addClass("imCek");
    };
})

//unchecked materai
$(document).on("click", "input[name='materai']", function() {
    thisRadio = $(this);
    if (thisRadio.hasClass("imCek")) {
        thisRadio.removeClass("imCek");
        thisRadio.prop('checked', false);
    } else {
        thisRadio.prop('checked', true);
        thisRadio.addClass("imCek");
    };
})
</script>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div style="background: #e4efe0">
            <div class="inner">
                <div class="container-fluid"><br>
                    <form id="frmCari" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Nomor PO</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="no_po" id="no_po">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Tanggal PO</label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control datepicker" name="tgl0" id="tgl0">
                            </div>
                            <label class="col-sm-1 control-label">s/d</label>
                            <div class="col-sm-3">
                                <input type="date" class="form-control datepicker" name="tgl1" id="tgl1">
                            </div>
                            <!-- <div class="col-sm-3">
                                <button type="button" id="submit" onclick="export_excel()"
                                    class="btn btn-primary pull-right"><i class="fa fa-print"> &nbsp;Export Excel</i>
                                </button>
                            </div> -->
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">Supplier</label>
                            <div class="col-sm-4">
                                <select name="supplier_id" id="supplier_id" class="form-control" style="width:100%"
                                    >
                                    <option value="" selected>---- Pilih Supplier ----</option>
                                    <?php
							  foreach($select_pemasok as $row){
								echo '<option value="'.$row->id.'">'.$row->pbf.'</option>';
							  }
							?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-10">
                                <button type="button" id="btnCari" class="btn btn-primary">Cari</button>
                                <button type="reset" id="btnReset" class="btn btn-primary">Reset</button>
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
                    <table id="example" class="display nowrap table table-hover table-bordered table-striped"
                        cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID PO</th>
                                <th>No. PO</th>
                                <th>Tgl PO</th>
                                <th>Supplier</th>
                                <th>Sumber Dana</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Insert-->
<div class="modal fade" id="detailModal" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-default modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Detail PO No : <span id="sDetailID"></span></h4>
            </div>
            <div class="modal-body">
                <form id="frmCari" class="form-horizontal">
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Tanggal Penerimaan</label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control datepicker" name="tgl_terima" id="tgl_terima"
                                >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Tanggal Faktur</label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control datepicker" name="tgl_faktur" id="tgl_faktur">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Tanggal DO</label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control datepicker" name="tgl_do" id="tgl_do">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">No Faktur</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="no_faktur" id="no_faktur">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">No DO</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="no_do" id="no_do">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Jatuh Tempo</label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" name="jatuh_tempo" id="jatuh_tempo"
                                placeholder="Tgl Jatuh Tempo">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Cara Bayar</label>
                        <div class="col-sm-4">
                            <select name="cara_bayar" id="cara_bayar" class="form-control" style="width:100%"
                                >
                                <option value="" selected>---- Cara Bayar ----</option>
                                <option value="cash">Cash</option>
                                <option value="credit">Credit</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">Keterangan</label>
                        <div class="col-sm-6">
                            <textarea type="text" class="form-control" name="keterangan" id="keterangan"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 control-label">PPN</label>
                        <div class="col-sm-4">
                            <select name="ppn" id="ppn" class="form-control" style="width:100%">
                                <option value="" selected>---- PPN ----</option>
                                <option value="0">Include</option>
                                <option value="1">Not Include</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-body table-responsive m-t-0">
                        <table style="border:0;" width="100%">
                            <tr>
                                <td width="100%" valign="top">
                                    <table id="tableObat"
                                        class="display nowrap table table-hover table-bordered table-striped"
                                        cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <p align="center">Nama Obat</p>
                                                </th>
                                                <th>
                                                    <p align="center">Qty Besar</p>
                                                </th>
                                                <th>
                                                    <p align="center">Qty Kecil</p>
                                                </th>
                                                <th>
                                                    <p align="center">Isi</p>
                                                </th>
                                                <th>
                                                    <p align="center">Harga Qty Besar</p>
                                                </th>
                                                <th>
                                                    <p align="center">Harga Qty Kecil</p>
                                                </th>
                                                <th>
                                                    <p align="center">Subtotal</p>
                                                </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </td>
                                <td width="2%"></td>
                            </tr>

                            <br>
                        </table>
                        <div id="itemForm">
                            <hr>
                            <h4>Detail Obat</h4>
                            <hr>

                            <div class="form-row">
                                <div class="form-group row">
                                    <div class="form-group col-sm-6">
                                        <label for="isi">Kemasan/Satuan</label>
                                        <select id="kemasan" class="form-control select2" style="width:100%" name="kemasan" onchange="pilihkemasan(this.value)">
                                            <option value="">-pilih-</option>
                                            <?php 
                                                foreach($kemasan as $row){
                                                echo '<option value="'.$row->kemasan.'">'.$row->kemasan.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="isi">Isi</label>
                                        <input type="text" class="form-control" id="isi" name="isi">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group row">
                                    <div class="form-group col-sm-6">
                                        <label for="qty_beli">Jumlah Beli (Qty Besar)</label>
                                        <input type="text" class="form-control" id="qty_beli" name="qty_beli" onchange="set_qty_kecil(this.value)">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="qty_beli_kecil">Jumlah Beli (Qty Kecil)</label>
                                        <input type="text" class="form-control" id="qty_beli_kecil" name="qty_beli_kecil" min=0>
                                    </div>
                                </div>
                            </div>

                           

                            <div class="form-row">
                                <div class="form-group row">
                                    <div class="form-group col-sm-6">
                                        <label for="isi">Harga Beli (Qty Besar)</label>
                                        <input type="text" class="form-control" id="hargabeli" name="hargabeli" onchange="set_harga(this.value)">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="isi">Harga Beli (Qty Kecil)</label>
                                        <input type="text" class="form-control" id="hargabeli_kecil" name="hargabeli_kecil">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row ">
                                <div class="form-group col-sm-6">
                                    <label for="satuan">Satuan</label>
                                    <select class="form-control" size="1" id="satuan" name="satuan">
                                        <option value="" selected>Silahkan Pilih</option>
                                        <option value="AMPUL">AMPUL</option>
                                        <option value="BAG">BAG</option>
                                        <option value="BOTOL">BOTOL</option>
                                        <option value="BOX">BOX</option>
                                        <option value="BUAH">BUAH</option>
                                        <option value="BUNGKUS">BUNGKUS</option>
                                        <option value="BUTIR">BUTIR</option>
                                        <option value="DUS">DUS</option>
                                        <option value="FLASH">FLASH</option>
                                        <option value="FLEXPEN ">FLEXPEN </option>
                                        <option value="GALON">GALON</option>
                                        <option value="GRAM">GRAM</option>
                                        <option value="KAPLET">KAPLET</option>
                                        <option value="KAPSUL">KAPSUL</option>
                                        <option value="KARTON">KARTON</option>
                                        <option value="KOTAK">KOTAK</option>
                                        <option value="LEMBAR">LEMBAR</option>
                                        <option value="LITER">LITER</option>
                                        <option value="METER">METER</option>
                                        <option value="MINIDOSE">MINIDOSE</option>
                                        <option value="OVULA">OVULA</option>
                                        <option value="PACK">PACK</option>
                                        <option value="PASANG">PASANG</option>
                                        <option value="PATCH">PATCH</option>
                                        <option value="PIECES">PIECES</option>
                                        <option value="ROLL">ROLL</option>
                                        <option value="SACHET">SACHET</option>
                                        <option value="SAK">SAK</option>
                                        <option value="SET">SET</option>
                                        <option value="SOFTBAG">SOFTBAG</option>
                                        <option value="STRIP ">STRIP </option>
                                        <option value="STRIP MINIDOSE">STRIP MINIDOSE</option>
                                        <option value="SUPPOS">SUPPOS</option>
                                        <option value="SYRINGE">SYRINGE</option>
                                        <option value="TABLET">TABLET</option>
                                        <option value="TABUNG">TABUNG</option>
                                        <option value="TUBE">TUBE</option>
                                        <option value="VIAL">VIAL</option>
                                    </select>
                                </div>
                                <div class="form-group  col-sm-6">
                                    <label for="hargaJual">Harga Jual per Item</label>
                                    <input class="form-control" type="number" id="hargajual" name="hargajual"
                                        style="width:100%" min=0 value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group  col-sm-6">
                                    <label for="batchNo">Batch No</label>
                                    <input type="text" class="form-control" id="batch_no" name="batch_no">
                                </div>
                                <div class="form-group  col-sm-6">
                                    <label for="expire">Expire</label>
                                    <input type="date" class="form-control" id="expire_date" name="expire_date" placeholder="yyyy-mm-dd"
                                        style="width:100%">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group  col-sm-6">
                                    <label for="diskonItem">Diskon Item (%)</label>
                                    <input type="text" class="form-control" id="diskon_item" name="diskon_item" onchange="set_diskon(this.value)">
                                </div>
                                <div class="form-group  col-sm-6">
                                    <label for="diskonItem">Total</label>
                                    <input type="text" class="form-control" id="total" name="total">
                                    <input type="hidden" class="form-control" id="description" name="description">
                                </div>
                               
                            </div>
                            <button class="btn btn-primary" id="btnSimpan">Simpan</button>
                        </div>
                        <!-- <button type="button" class="btn btn-primary" id="addItem">Tambah Item</button> -->
                    </div>

                    <div class="table-responsive m-t-0">

                        <table id="tableBeli" class="display nowrap table table-hover table-bordered table-striped"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="10%">
                                        <p align="center">ID</p>
                                    </th>
                                    <th width="10%">
                                        <p align="center">Status</p>
                                    </th>
                                    <th width="10%">
                                        <p align="center">Jml Beli</p>
                                    </th>
                                    <th width="10%">
                                        <p align="center">Satuan</p>
                                    </th>
                                    <th>
                                        <p align="center">Harga Beli</p>
                                    </th>
                                    <th>
                                        <p align="center">Harga Jual<br>per Item</p>
                                    </th>
                                    <th>
                                        <p align="center">Batch No</p>
                                    </th>
                                    <th width="10%">
                                        <p align="center">Diskon Item<br>(Rp/ %)</p>
                                    </th>
                                    <th width="20%">
                                        <p align="center">Expire</p>
                                    </th>
                                    <th width="20%">
                                        <p align="center">Aksi</p>
                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <button type="button" class="btn btn-primary" onclick="verifikasi_penerima()">Verifikasi Penerima</button>
                        <button type="button" class="btn btn-primary" onclick="verifikasi_gudang()">Verifikasi Gudang</button>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button id="btnClose" class="btn btn-primary pull-right" type="button"
                    data-dismiss="modal">Close</button>
                <input type="hidden" name="id_po" id="id_po">
                <button  name="bt_selesai" class="btn btn-primary" onclick="submitSelesaiPo()">Simpan &
                    Selesai</button>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    function verifikasi_penerima()
    {
        $.ajax({
            dataType: "json",
            type: 'POST',
            data: {
                item_id: det_item_id,
                id_po: det_id_po
            },
            url: `<?php echo site_url(); ?>logistik_farmasi/Frmcpembelian_po/verifikasi_penerima/`,
            success: function(response) {
                if(response.metadata.code === 200){
                    refreshDetailBeli();
                    swal({
                        text: "Data Berhasil Diverifikasi Penerima!",
                        title: "Berhasil!",
                        icon:'success'
                    });
                    // window.location.reload();
                    // toastr.success('Data Berhasil Disimpan!', 'Berhasil!')
                }
            },
        });
    }

    function verifikasi_gudang()
    {

        $.ajax({
            dataType: "json",
            type: 'POST',
            data: {
                item_id: det_item_id,
                id_po: det_id_po
            },
            url: `<?php echo site_url(); ?>logistik_farmasi/Frmcpembelian_po/verifikasi_gudang`,
            success: function(response){
                if(response.metadata.code === 200){
                    refreshDetailBeli();
                    swal({
                        text: "Data Berhasil Diverifikasi Gudang!",
                        title: "Berhasil!",
                        icon:'success'
                    });
                }
            },
            complete: function() {
                me.data('requestRunning', false);
            }
        });
        // vbatch = $("#batch_no").val();
        // vexdate = $("#expire_date").val();
        // vsatuan = $("#satuan").val();
        // vqty = parseInt($("#qty_beli").val());
        // vmax = parseInt($("#qty_beli").prop('max'));

        // vtanggal = $("#tgl_terima").val();
    

        // if (vtanggal == "") {

        //     alert("Lengkapi Data Faktur Terlebih Dahulu");
        //     $("#no_faktur").focus();
        //     return false;
        // } else {
        //     if (vqty > vmax) {
        //         alert("Total jumlah pembelian melebihi jumlah PO ");
        //         $("#qty_beli").val('');
        //         $("#qty_beli").focus();
        //         return false;
        //     } else {
        //         if (((vqty == "") && (vbatch == "")) && (vexdate == "")) {
        //             alert("Mohon lengkapi Jumlah Beli, Batch No & Tanggal Expired!");
        //             $("#qty_beli").focus();
        //         }
        //         if ((vqty != "") && (vbatch == "")) {
        //             alert("Mohon lengkapi Batch No & Tanggal Expired!");
        //             $("#batch_no").focus();
        //         }
        //         if ((vbatch != "") && (vexdate == "")) {
        //             alert("Mohon lengkapi Tanggal Expired!");
        //             $("#expire_date").focus();
        //         }
        //         if (((vqty != "") && (vbatch != "")) && (vexdate != "")) {

        //             var me = $(this);
        //             event.preventDefault();
        //             if (me.data('requestRunning')) {
        //                 return;
        //             }

        //             me.data('requestRunning', true);

                    
        //         }
        //     }
        // }
    }

    function submitSelesaiPo()
    {
        let url = 'logistik_farmasi/Frmcpembelian_po/selesai_po';
        $.ajax({
            dataType: "json",
            type: 'POST',
            data: {
                id_po: $("#id_po").val(),
            },
            url: `<?php echo site_url(); ?>${url}`,
            success: function(response) {
                if(response.metadata.code === 200){
                    window.location.reload();
                }
            },
        });
    }

    function hapuspo(id)
    {
        $.ajax({
            url: `<?php echo site_url(); ?>logistik_farmasi/Frmcpembelian_po/hapus_po_id/${id}`,
            success: function(response){
                if(response.metadata.code === 200){
                    swal({
                        text: "Data Berhasil Dihapus!",
                        title: "Berhasil!",
                        icon:'success'
                    });
                }else{
                    swal({
                        text: response.metadata.message,
                        title: "Gagal!",
                        icon:'error'
                    });
                }
                refreshDetailBeli();

            }
        });
    }
</script>

<?php
  $this->load->view('layout/footer_left.php');
?>