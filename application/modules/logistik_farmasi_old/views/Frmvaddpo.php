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
        $("#generik").select2();
        $("#kemasan").select2();
        $("#bentuk_sediaan").select2();
        // var satuanbesar = $("#satuanbesar").select2();
        // var satuankecil = $("#satuankecil").select2();

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
                $("#satuan_besar").val(suggestion.satuanb);
                $("#faktor_satuan").val(suggestion.faktorsatuan);
                $("#qty_beli_besar").val(1);
                $("#satuan_kecil").val(suggestion.satuank);
                $("#qty_beli_kecil").val(suggestion.faktorsatuan);
                $("#harga_beli_kecil").val(suggestion.hargabeli);
                // $("#margin").val(25);
                $("#diskon").val(0);
                $("#hargagd").val(suggestion.hargabeligd);
                // $('#hargak').val(suggestion.hargabeli);
                // $("#satuankecil").val(suggestion.satuank.toUpperCase()).trigger('change');
                // console.log(suggestion.satuank.toUpperCase());
                // console.log(suggestion.satuanb.toUpperCase());
                
                harga_beli_kecil = suggestion.hargabeli;
                jmlh_satuan = suggestion.faktorsatuan;

                var jumlah_besar = harga_beli_kecil * jmlh_satuan;
                $("#hargak").val(jumlah_besar);
                $("#harga_beli_besar").val(jumlah_besar);



                // var rumus1 = harga_beli * 10 / 100;
                // var hasil1 = parseInt(harga_beli) + parseInt(rumus1);
                

                // var rumus2 = hasil1 * 25 / 100;
                // var hasil2 = parseInt(hasil1) + parseInt(rumus2);

                // var harga_jual = parseInt(hasil1) + parseInt(hasil2);

                // $('#harga_jual').val(harga_jual);
               
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


        $("#qty_beli_besar").change(function () {
            var jml_satuan = $("#faktor_satuan").val();
            var harga = $("#harga_beli_besar").val();
            var jmlh_beli = $("#qty_beli_besar").val();
            // var harga = $("#harga_beli").val();qty_beli_kecil
            var total_jmlh = jml_satuan * jmlh_beli;
            total = parseFloat(harga) * parseFloat(jmlh_beli);
            $("#hargak").val(total.toFixed(0));
            $("#qty_beli_kecil").val(total_jmlh.toFixed(0));
        });

        $("#harga_beli_besar").change(function () {
            var jml_satuan = $("#faktor_satuan").val();
            var harga = $("#harga_beli_besar").val();
            var jmlh_beli = $("#qty_beli_besar").val();
            // var harga = $("#harga_beli").val();qty_beli_kecil
            total_harga_kecil = harga / jml_satuan;
            total = parseFloat(harga) * parseFloat(jmlh_beli);
            $("#hargak").val(total.toFixed(0));
            $("#harga_beli_kecil").val(total_harga_kecil.toFixed(0));
            
        });


        $("#jml_kemasan").keyup(function () {
            var jml = $("#jml_kemasan").val();
            var harga = $("#harga_beli").val();

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

    // function changeHandlerPPN(event) {
	
	// switch (this.value) {
	// 	case "1":		
    //         var total_hrg = $("#hargak").val();
    //         var total_jmlh = total_hrg * 1.11;
    //         $("#hargak").val(total_jmlh.toFixed(0));
    //         // $("#qty_beli_kecil").val(total_jmlh.toFixed(0));
	// 		break;

    //     case "0":		
    //         var jml_satuan = $("#faktor_satuan").val();
    //         var harga = $("#harga_beli").val();
    //         var jmlh_beli = $("#qty_beli_besar").val();
    //         // var harga = $("#harga_beli").val();qty_beli_kecil
    //         var total_jmlh = jml_satuan * jmlh_beli;
    //         total = parseFloat(harga) * parseFloat(total_jmlh);
    //         $("#hargak").val(total.toFixed(0));
	// 		break;
		
	// 	default:
	// 		// console.log(this.value);
	// 		// document.getElementById("no_identitas").required= true;		
	// 		// $("#label-identitas").html("No. "+this.value); 
	// 		// $("#div-no-identitas").show();
	// 		break;
	// 	}
    // }

    // $(document).ready(function() {
    //     var radios = document.querySelectorAll('input[type=radio][name="ppn"]');

    //     Array.prototype.forEach.call(radios, function(radio) {
    //         radio.addEventListener('change', changeHandlerPPN);
    //     });
    // });

    function addItems() {
        var idobat = $('#id_obat').val();
        var generik = $('#generik').val();
        var bentuk_sediaan = $('#bentuk_sediaan').val();
        var kemasan = $('#kemasan').val();
        var jmlkemasan = $('#qty_beli').val();
        var jmlkemasanhuruf = $('#qty_beli2').val();
        var satuankecil = $("#satuank").val();
        var harga = $('#hargagd').val();

        if(idobat == "" ||  jmlkemasan == "") {

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
                $('#generik').val(),
                $('#satuank').val(),
                $("#bentuk_sediaan").val(),
                $('#kemasan').val(),
                $("#qty_beli").val(),
                $("#qty_beli2").val(),
                $("#hargagd").val(),
                // $('#diskon').val(),
                // $('#hargak').val(),
                '<center><button type="button" class="btnDel btn btn-primary btn-xs" title="Hapus">Hapus</button></center>'
            ]).draw(false);

            $('#id_obat').val("");
            $('#cari_obat').val("");
                $('#generik').val(""),
                $('#satuank').val(""),
                $("#bentuk_sediaan").val(""),
                $('#kemasan').val(""),
                $("#qty_beli").val(""),
                $("#qty_beli2").val(""),
                $("#hargagd").val(),

            populateDataObat();
        }
    }


    function populateDataObat() {
        vjson = table.rows().data();
        ndata = vjson.length;
        var vjson2 = [[]];
        console.log(vjson)
        var total = 0;
        jQuery.each(vjson, function (i, val) {
            total += vjson[i][3] * vjson[i][5];
            vjson2[i] = {
                "item_id": vjson[i][0],
                "description": vjson[i][1],
                "nm_generik": vjson[i][2],
                "satuank": vjson[i][3],
                "bentuk_sediaan": vjson[i][4],
                "kemasan": vjson[i][5],
                "qty": vjson[i][6],
                "qty2": vjson[i][7],
                "hargabeli": vjson[i][8],
            };
        });
        $('#dataobat').val(JSON.stringify(vjson2));
        // $("#total_po").html("<h2>Total: Rp. " + total.formatMoney(0, ',', '.') + "</h2>");
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

    //unchecked ppn
    $(document).on("click", "input[name='ppn']", function(){
        thisRadio = $(this);
        if (thisRadio.hasClass("imCek")) {
            thisRadio.removeClass("imCek");
            thisRadio.prop('checked', false);
        } else { 
            thisRadio.prop('checked', true);
            thisRadio.addClass("imCek");
        };
    })

    function hitung_margin_diskon() {
        // alert('yuhu');
        var harga_beli = $('#hargak').val();
        // var margin = $('#margin').val();
        var diskon = $('#diskon').val();

        var rumus1 = harga_beli * diskon / 100;
        // var hasil1 = parseInt(harga_beli) + parseInt(rumus1);


        // var rumus2 = hasil1 * margin / 100;
        // var hasil2 = parseInt(hasil1) + parseInt(rumus2);

        // var harga = parseInt(hasil1) + parseInt(hasil2);

        // $('#harga_jual').val(harga);

        // var rumus3 = harga * diskon / 100;
        // var hasil3 = parseInt(harga) - parseInt(rumus3);

        $('#hargak').val(rumus1.toFixed(0));
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
                                       value="">
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
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" >
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label" id="lsupplier">Golongan</p>
                            <div class="col-sm-6">
                                <select name="jenis_po" id="jenis_po"
                                        class="form-control js-example-basic-single">
                                    <option value="" selected>---- Pilih Golongan ----</option>
                                    <?php
                                    foreach ($golongan as $row) {
                                        echo '<option value="' . $row->nm_golongan . '">' . $row->nm_golongan . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- <div class="form-group row" >
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label" id="lpo">Jenis PO</p>
                            <div class="col-sm-6">
                                <select class="form-control" name="jenis_po" id="jenis_po">
                                    <option value="" disabled selected>----- Pilih Jenis PO -----</option>
                                    <option value="Obat_tertentu">Obat Tertentu</option>
                                    <option value="psikotropika">Psikotropika</option>
                                    <option value="narkotika">Narkotika</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div> -->


                        <div class="form-group row" >
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label" id="lsupplier">PPN</p>
                            <div class="col-sm-6">
                                <div class="demo-radio-button">
                                    <input name="ppn" type="radio" id="ada" class="with-gap" value="1"/>
                                    <label for="ada">Ya</label>
                                    <input name="ppn" type="radio" id="tidak" class="with-gap" value="0"  />
                                    <label for="tidak">Tidak</label>  
                                </div>
                            </div>
                        </div>

                       
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label" id="lprodusen">Produsen/Prinsipal</p>
                            <div class="col-sm-6">
                                <select name="vprodusen_id" id="vprodusen_id"
                                        class="form-control js-example-basic-single" required>
                                    <option value="" selected>---- Pilih ----</option>
                                    <?php
                                    foreach ($select_produsen as $row) {
                                        echo '<option value="' . $row->id . '">' . $row->nm_produsen . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                           
                        </div>

                       
                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label" id="lsupplier">Supplier/PBF</p>
                            <div class="col-sm-6">
                                <select name="vsupplier_id" id="vsupplier_id"
                                        class="form-control js-example-basic-single" required>
                                    <option value="" selected>---- Pilih Supplier ----</option>
                                    <?php
                                    foreach ($select_pemasok as $row) {
                                        echo '<option value="' . $row->id . '">' . $row->pbf . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-default" id="btnUbah">Ubah Pemasok</a>
                            </div>
                        </div>
                        <input type="hidden" id="user" name="user" value="<?php echo $user_info->username; ?>"/>
                        <input type="hidden" id="userid" name="userid" value="<?php echo $user_info->userid; ?>"/>
                        <input type="hidden" id="supplier_id" name="supplier_id"/>
                    </div>
                    <hr>
                    <div id="detailObat">
                        <form action="#" class="form-horizontal">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right">Nama Obat</p>
                                            <div class="col-sm-6">
                                                <input type="search" class="form-control" id="cari_obat" name="cari_obat" placeholder="Pencarian Obat">
                                                <input type="hidden" name="id_obat" id="id_obat">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right">Nama Generik</p>
                                            <div class="col-sm-6">
                                            <select id="generik" class="form-control select2" style="width:100%" name="generik">
                                                <option value="">-Generik-</option>
                                                <?php 
                                                    foreach($generik as $row){
                                                    echo '<option value="'.$row->nm_generik.'">'.$row->nm_generik.'</option>';
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
                                            <p class="col-sm-3 form-control-label text-right">Satuan Kecil</p>
                                            <div class="col-sm-6">
                                                <select id="satuank" class="form-control select2" style="width:100%" name="bentuk_sediaan">
                                                    <option value="">-pilih-</option>
                                                    <?php 
                                                        foreach($satuan as $row){
                                                        echo '<option value="'.$row->satuan.'">'.$row->satuan.'</option>';
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
                                            <p class="col-sm-3 form-control-label text-right">Kemasan/Satuan</p>
                                            <div class="col-sm-6">
                                                <select id="kemasan" class="form-control select2" style="width:100%" name="kemasan">
                                                    <option value="">-pilih-</option>
                                                    <?php 
                                                        foreach($kemasan as $row){
                                                        echo '<option value="'.$row->kemasan.'">'.$row->kemasan.'</option>';
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
                                            <p class="col-sm-3 form-control-label text-right">Bentuk Sediaan</p>
                                            <div class="col-sm-6">
                                                <select id="bentuk_sediaan" class="form-control select2" style="width:100%" name="bentuk_sediaan">
                                                    <option value="">-pilih-</option>
                                                    <?php 
                                                        foreach($bentuk_sediaan as $row){
                                                        echo '<option value="'.$row->bentuk_sediaan.'">'.$row->bentuk_sediaan.'</option>';
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
                                               id="lbl_biaya_poli">Qty Beli (angka)</p>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" name="qty_beli" id="qty_beli" min=1>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Qty Beli (Huruf)</p>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="qty_beli2" id="qty_beli2" min=1>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Harga</p>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="hargagd" id="hargagd">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Faktor Satuan</p>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" name="faktor_satuan" id="faktor_satuan" min=1 readonly="">
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <!-- <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Satuan Besar</p>
                                            <div class="col-sm-3">
                                            <input type="text" class="form-control" name="satuan_besar"  id="satuan_besar" readonly=""> -->
                                            <!-- ini ngga di comment -->
                                                <!-- <select id="satuanbesar" class="form-control select2"
                                                        name="satuanbesar">
                                                    <option value="">-Satuan Besar-</option>
                                                    <?php
                                                    foreach ($obat_satuan as $row) {
                                                        echo "<option value='" . $row->id_satuan . "'>" . $row->nm_satuan . "</option>";
                                                    }
                                                    ?>
                                                </select> -->
                                            <!-- sampai sini -->

                                            <!-- </div>
                                        </div>
                                    </div>
                                </div> -->

                                


                                <!-- <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Satuan Kecil</p>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="satuan_kecil"  id="satuan_kecil" readonly=""> -->
                                                
                                                <!-- <select id="satuankecil" disabled="" class="form-control select2" name="satuankecil">
                                                    <option value="">-Satuan-</option>
                                                    <?php
                                                    foreach ($obat_satuan as $row) {
                                                        echo "<option value='" . $row->nm_satuan . "'>" . $row->nm_satuan . "</option>";
                                                    }
                                                    ?>
                                                </select> -->


                                            <!-- </div>
                                        </div>
                                    </div>
                                </div> -->


                                <!-- <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Harga Beli (satuan kecil )</p>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" name="harga_beli_kecil" id="harga_beli_kecil" min=1 readonly="">
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                <!-- <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Harga Beli (satuan Besar )</p>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" name="harga_beli_besar" id="harga_beli_besar" min=1>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                
                                <!-- <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Qty Beli Satuan Besar</p>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" name="qty_beli_besar" id="qty_beli_besar" min=1>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->

                                

                                <!-- <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Diskon(%)</p>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" name="diskon" id="diskon">
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Harga Total</p>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="hargak" id="hargak" readonly="">
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                
                               
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
                            <div class="table-responsive m-t-0">	
                            <table id="example"
                                   class="display nowrap table table-hover table-bordered table-striped"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                <th><p align="center">ID Obat</p></th>
                                    <th><p align="center">Nama Obat</p></th>
                                    <th><p align="center">Nama Generik</p></th>
                                    <th><p align="center">Satuan Kecil</p></th>
                                    <th><p align="center">Bentuk Sediaan</p></th>
                                    <th><p align="center">Kemasan</p></th>
                                    <th><p align="center">Jumlah<br>Kemasan</p></th>
                                    <th><p align="center">Jumlah<br>Kemasan</p></th>
                                    <th><p align="center">Harga</p></th>
                                    
                                    <th><p align="center">Aksi</p></th>
                                </tr>
                                </thead>
                            </table>
                             </div>
                            <br/><br/>
                            <div class="row p-t-0">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group" align="right" style="margin-right:10px;">
                                        <div align="right" id="total_po"></div>
                                    </div>
                                </div><br>
                            </div>
                            <br/><br/>
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