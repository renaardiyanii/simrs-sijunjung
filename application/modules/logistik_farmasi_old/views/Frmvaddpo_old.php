<?php
$this->load->view('layout/header_left.php');
?>
<script type='text/javascript'>
    Date.prototype.yyyymmdd = function () {
        var mm = this.getMonth() + 1; // getMonth() is zero-based
        var dd = this.getDate();

        return [this.getFullYear() + '-',
            (mm > 9 ? '' : '0') + mm + '-',
            (dd > 9 ? '' : '0') + dd + '-'
        ].join('');
    };

    var table;
    var ndata = 0;
    $(function () {
        <?php echo $this->session->flashdata('cetak'); ?>
        $('#cari_obat').focus();
        var satuanbesar = $("#satuanbesar").select2();
        var satuankecil = $("#satuankecil").select2();

        $('#tgl_po').datepicker({
            format: "yyyy-mm-dd",
            endDate: '0',
            autoclose: true,
            todayHighlight: true
        });

        $('#cari_obat').autocomplete({
            serviceUrl: '<?php echo site_url();?>logistik_farmasi/Frmcpo/cari_data_obat',
            onSelect: function (suggestion) {
                $('#cari_obat').val('' + suggestion.nama);
                $("#id_obat").val(suggestion.idobat);
                $("#satuankecil").val(suggestion.satuank).trigger('change');
                $('#hargak').val(suggestion.hargabeli);
                $('#harga_po').val(suggestion.hargabeli);
                $("#harga_po").focus();
            }
        });

        var myDate = new Date();
        $('#tgl_po').datepicker('setDate', myDate.yyyymmdd());
        table = $('#example').DataTable();
        $('#btnUbah').css("display", "none");
        $('#detailObat').css("display", "none");
        $("#vsupplier_id").change(function () {
            $('#vsupplier_id').prop('disabled', true);
            $('#btnUbah').css("display", "");
            $('#detailObat').css("display", "");
            $('#supplier_id').val($("#vsupplier_id").val());
        });

        $("#btnUbah").click(function () {
            $('#vsupplier_id').prop('disabled', false);
            $('#vsupplier_id option[value=""]').prop('selected', 'selected');
            $('#supplier_id').val("");
            $('#vsupplier_id').focus();
            $('#btnUbah').css("display", "none");
            table.clear().draw();
            $('#detailObat').css("display", "none");
        });
        $("#no_po").change(function () {
            var vno = $("#no_po").val();
            $.ajax({
                dataType: "json",
                type: 'POST',
                data: {id: vno},
                url: "<?php echo site_url(); ?>logistik_farmasi/Frmcpo/is_exist",
                success: function (response) {
                    if (response.exist > 0) {
                        alert("Nomor PO " + vno + " sudah pernah diinputkan pada tanggal " + response.tgl);
                        $("#no_po").val('');
                        $("#no_po").focus();
                    }
                }
            })
        });
        $("#jml_kemasan").change(function () {
            var jml = $("#jml_kemasan").val();
            var harga = $("#harga_po").val();

            total = parseFloat(harga) * parseFloat(jml);
            $("#hargak").val(total.toFixed(0));
        });

        $("#btnTambah").click(function () {
            addItems();
        });

        $("#hargak").keyup(function (event) {
            if (event.keyCode == 13) {
                addItems();
            }
        });


        $('#example tbody').on('click', 'button.btnDel', function () {
            table.row($(this).parents('tr')).remove().draw();
            populateDataObat();
        });
        $("#btnSimpan").click(function () {
            if (ndata == 0) {
                alert("Silahkan input data obat");
                $('#id_obat').focus();
            } else
                $("#frmAdd").submit();
            // data = document.getElementById("dataobat").value;
            // alert(data);
        });
    });

    function addItems() {
        var idobat = $('#id_obat').val();
        var hargapo = $('#harga_po').val();
        var hargak = $('#hargak').val();
        var jmlkemasan = $('#jml_kemasan').val();
        var satuankecil = $("#satuankecil option:selected").val();

        if(idobat == "" || hargapo == "" || hargak == "" || jmlkemasan == "" || satuankecil == "") {

            swal({
                    title: "Perhatian!",
                    text: "Kolom Item PO Tidak Boleh Kosong!",
                    type: "error",
                    showCancelButton: false,
                    confirmButtonClass: "btn btn-danger",
                    confirmButtonText: "OK",
                    closeOnConfirm: true
                },
                function(){
                    $('#cari_obat').focus();
                });
        }else{
            table.row.add([
                $('#id_obat').val(),
                $("#cari_obat").val(),
                $('#harga_po').val(),
                $('#jml_kemasan').val(),
                $("#satuankecil option:selected").text(),
                $('#diskon').val(),
                $('#hargak').val(),
                '<center><button type="button" class="btnDel btn btn-primary btn-xs" title="Hapus">Hapus</button></center>'
            ]).draw(false);

            $('#id_obat').val("");
            $('#cari_obat').val("");
            $('#satuanbesar').val("").trigger("change");
            $('#harga_po').val("");
            $('#jml').val("");
            $('#diskon').val("");
            $('#hargak').val("");
            $('#jml_kemasan').val("");
            $('#satuankecil').val("").trigger("change");
            $('#cari_obat').focus();

            populateDataObat();
        }
    }


    function populateDataObat() {
        vjson = table.rows().data();
        ndata = vjson.length;
        var vjson2 = [[]];
        var total = 0;
        jQuery.each(vjson, function (i, val) {
            total += vjson[i][2] * vjson[i][3];
            vjson2[i] = {
                "item_id": vjson[i][0],
                "description": vjson[i][1],
                "harga_item": vjson[i][2],
                "qty": vjson[i][3],
                "jml_kemasan": vjson[i][3],
                "satuan_item": vjson[i][4],
                "satuank": vjson[i][4],
                "diskon_item": vjson[i][5],
                "diskon_persen": vjson[i][5],
                "hargabeli": vjson[i][2],
                "harga_po": vjson[i][6],
            };
        });
        $('#dataobat').val(JSON.stringify(vjson2));
        $("#total_po").html("<h2>Total: Rp. " + total.formatMoney(0, ',', '.') + "</h2>");
    }

    Number.prototype.formatMoney = function (c, d, t) {
        var n = this,
            c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };
    function cetak(id) {
        window.open('<?=site_url('download/logistik_farmasi/PO/FP_')?>' + id + '.pdf', '_blank');
        /*var win = window.open(baseurl+'download/logistik_farmasi/PO/FP_'+id+'.pdf', '_blank');
         if (win) {
         //Browser has allowed it to be opened
         win.focus();
         } else {
         //Browser has blocked it
         alert('Please allow popups for this website');
         }*/
    }

</script>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-block">
                    <a class="btn btn-primary pull-right"
                            href="<?php echo site_url('logistik_farmasi/Frmcpo'); ?>"><i class="fa fa-book"> &nbsp;Monitoring
                            PO</i></a>
                    <br/><br/>
                    <div class="row">
                        <div class="col-xs-12" id="alertMsg">
                            <?php echo $this->session->flashdata('alert_msg'); ?>
                        </div>
                        <div class="col-xs-3" align="right"></div>
                    </div>
                    <?php echo form_open('logistik_farmasi/Frmcpo/save', array('id' => 'frmAdd', 'method' => 'post')); ?>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Tanggal PO</p>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" name="tgl_po" id="tgl_po" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Nomor PO</p>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="no_po" id="no_po" required
                                       value="<?= $no_po ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Surat Dari</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="surat_dari" id="surat_dari" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Nomor Surat</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="no_surat" id="no_surat" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">Perihal</p>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" name="perihal" id="perihal" required>
                            </div>
                        </div>
                        <div class="form-group row" >
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label" id="lsupplier">Jenis Pesanan</p>
                            <div class="col-sm-6">
                                <select class="form-control" name="sumber_dana" id="sumber_dana">
                                    <option value="" disabled selected>----- Pilih Jenis Pesanan -----</option>
                                    <option value="BPJS">BPJS</option>
                                    <option value="Umum">Umum</option>
                                    <!--<option value="Subsidi">Subsidi</option>-->
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label">PPN</p>
                            <div class="col-sm-6">
                                <div class="demo-radio-button">
                                    <input name="ppn" type="radio" id="radio_7" class="radio-col-red" value="1" checked="">
                                    <label for="radio_7">Ya</label>
                                    <input name="ppn" type="radio" id="radio_8" class="radio-col-pink" value="0">
                                    <label for="radio_8">Tidak</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label" id="lsupplier">Supplier</p>
                            <div class="col-sm-6">
                                <select name="vsupplier_id" id="vsupplier_id"
                                        class="form-control js-example-basic-single" required>
                                    <option value="" selected>---- Pilih Supplier ----</option>
                                    <?php
                                    foreach ($select_pemasok as $row) {
                                        echo '<option value="' . $row->person_id . '">' . $row->company_name . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-default" id="btnUbah">Ubah Pemasok</a>
                            </div>
                        </div>
                        <input type="hidden" id="user" name="user" value="<?php echo $user_info->username; ?>"/>
                        <input type="hidden" id="supplier_id" name="supplier_id"/>
                    </div>
                    <hr>
                    <div id="detailObat">
                        <form action="#" class="form-horizontal">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right">Nama
                                                Obat</p>
                                            <div class="col-sm-6">
                                                <input type="search" class="form-control" id="cari_obat"
                                                       name="cari_obat" placeholder="Pencarian Obat">
                                                <input type="hidden" name="id_obat" id="id_obat">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Harga Obat</p>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control"
                                                       name="harga_po" id="harga_po" min=1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
  
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Satuan</p>
                                            <div class="col-sm-3">
                                                <select id="satuankecil" disabled="" class="form-control select2" name="satuankecil">
                                                    <option value="">-Satuan-</option>
                                                    <?php
                                                    foreach ($obat_satuan as $row) {
                                                        echo "<option value='" . $row->nm_satuan . "'>" . $row->nm_satuan . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Jumlah</p>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control"
                                                       name="jml_kemasan" id="jml_kemasan" min=1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Diskon(%)</p>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="diskon"
                                                       id="diskon" value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Harga Total</p>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="hargak"
                                                       id="hargak">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group row">
                                            <div class="col-sm-2">
                                                <a class="btn btn-danger" id="btnTambah" href="#"><i class="fa fa-plus"></i> Tambahkan</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <table id="example"
                                   class="display nowrap table table-hover table-striped table-bordered"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th><p align="center">ID Obat</p></th>
                                    <th><p align="center">Nama Obat</p></th>
                                    <th><p align="center">Harga</p></th>
                                    <th><p align="center">Jumlah<br>Kemasan</p></th>
                                    <th><p align="center">Satuan</p></th>
                                    <th><p align="center">Diskon</p></th>
                                    <th><p align="center">Harga Total</p></th>
                                    <th><p align="center">Aksi</p></th>
                                </tr>
                                </thead>
                            </table>
                            <br/>
                            <div class="row p-t-0">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" align="right" style="margin-right:10px;">
                                        <div align="right" id="total_po"></div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="dataobat" id="dataobat">
                            <button type="button" class="btn btn-success" id="btnSimpan">Simpan</button>
                        <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
    </div>
<?php
$this->load->view('layout/footer_left.php');
?>