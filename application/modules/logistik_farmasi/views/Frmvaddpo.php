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
            format: "dd-mm-yyyy",
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
                $("#harga_beli_kecil").val(suggestion.hargabeligd);
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
        // $('#tgl_po').datepicker('setDate', myDate.yyyymmdd());
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

    function pilihkemasan(val)
    {
        if(val.includes('/'))
        {
            $("#isi").val(val.split('/')[1]);
        }else{
            $("#isi").val('1');
        }
    }

    function set_qty_kecil(val)
    {
        qty_besar_obat = $("#qty_besar").val();
        var numString = $("#harga_beli_kecil").val();
        // Remove commas and parse it to a float
        var num = parseFloat(numString.replace(/,/g, ''));
        isi = $("#isi").val();
        console.log(num);
        total_obat_kecil = qty_besar_obat * isi;
        total_harga_obat_besar = num * isi;
        total_harga_obat = total_harga_obat_besar * qty_besar_obat;
        $("#qty").val(total_obat_kecil);

        $("#hargagd").val(total_harga_obat_besar);
       
        $("#hargapo").val(total_harga_obat);
    }

    function set_harga_besar(val)
    {
        qty_besar_obat = $("#qty_besar").val();
        isi = $("#isi").val();
        
        harga_besar_bef = $("#hargagd").val();
        harga_besar = harga_besar_bef.replace(',','');
        total_harga_obat_kecil = harga_besar / isi;
        total_harga_obat = harga_besar * qty_besar_obat;
       
        $("#harga_beli_kecil").val(total_harga_obat_kecil);

        // $("#harga_beli_kecil").html(harga_kecil.formatMoney(0, ',', '.'));


        $("#hargapo").val(total_harga_obat);
    }

    function set_harga_kecil(val)
    {
        harga_besar_bef = $("#hargagd").val();
        harga_besar = harga_besar_bef.replace(',','');
        qty_kecil = $("#qty").val();

       total_harga_kecil = harga_besar / qty_kecil;

       console.log(harga_besar);
       console.log(qty_kecil);
       console.log(total_harga_kecil);

       $("#harga_beli_kecil").val(total_harga_kecil);
       $("#hargapo").val(harga_besar);
     
    }

    function addItems() {
        var idobat = $('#id_obat').val();
        var satuanbesar = $("#satuanb").val();
        var harga_besar = $('#hargagd').val();
        var qty_besar = $('#qty_besar').val();
        var satuankecil = $("#satuank").val();
        var qty_kecil = $('#qty').val();
        var harga_kecil = $('#harga_beli_kecil').val();
        var total = $('#hargapo').val();

        if(idobat == "") {

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
                $('#satuanb').val(),
                $("#hargagd").val(),
                $("#qty_besar").val(),
                $('#satuank').val(),
                $("#qty").val(),
                $('#harga_beli_kecil').val(),
                $('#hargapo').val(),
                '<center><button type="button" class="btnDel btn btn-primary btn-xs" title="Hapus">Hapus</button></center>'
            ]).draw(false);

                $('#id_obat').val("");
                $('#cari_obat').val("");
                $('#satuanb').val(""),
                $("#hargagd").val(""),
                $("#qty_besar").val(""),
                $('#satuank').val(""),
                $("#qty").val(""),
                $("#harga_beli_kecil").val(""),
                $("#hargapo").val(""),

            populateDataObat();
        }
    }


    function populateDataObat() {
        vjson = table.rows().data();
        ndata = vjson.length;
        var vjson2 = [[]];
        console.log(vjson);
        var total = 0;
        jQuery.each(vjson, function (i, val) {
            total += vjson[i][8];
            vjson2[i] = {
                "item_id": vjson[i][0],
                "description": vjson[i][1],
                "satuanb": vjson[i][2],
                "hargabeli": vjson[i][3],
                "qty_besar": vjson[i][4],
                "satuank": vjson[i][5],
                "qty": vjson[i][6],
                "harga_item": vjson[i][7],
                "harga_po": vjson[i][8],
            };
        });
        $('#dataobat').val(JSON.stringify(vjson2));
        console.log(total);
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
                                <input type="text" class="form-control" name="tgl_po" id="tgl_po" value="<?php echo date('Y-m-d') ?>" required>
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

                        <div class="form-group row">
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label" id="sumber_dana">Asal Usul Obat</p>
                            <div class="col-sm-6">
                                <select class="form-control" name="sumber_dana" id="sumber_dana" required>
                                    <option value="" disabled selected>----- Pilih Asal Usul -----</option>
                                    <option value="Pengadaan">Pengadaan</option>
                                    <option value="Hibah">Hibah</option>
                                    <option value="Dropping">Dropping</option>
                                    <option value="Diskes">Diskes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" >
                            <div class="col-sm-1"></div>
                            <p class="col-sm-3 form-control-label" id="lsupplier">PPN</p>
                            <div class="col-sm-6">
                                <div class="demo-radio-button">
                                    <input name="ppn" type="radio" id="ada" class="with-gap" value="0"/>
                                    <label for="ada">Ya</label>
                                    <input name="ppn" type="radio" id="tidak" class="with-gap" value="1"  />
                                    <label for="tidak">Tidak</label>  
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
                                            <div class="col-sm-3">
                                                <input type="search" class="form-control" id="cari_obat" name="cari_obat" placeholder="Pencarian Obat">
                                                <input type="hidden" name="id_obat" id="id_obat">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right">Satuan Besar</p>
                                            <div class="col-sm-3">
                                                <select id="satuanb" class="form-control select2" style="width:100%" name="satuanb">
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
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Harga Satuan Besar</p>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="hargagd" id="hargagd">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Jumlah Satuan Besar</p>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" name="qty_besar" id="qty_besar" min=1 >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                               
  

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right">Satuan Kecil</p>
                                            <div class="col-sm-3">
                                                <select id="satuank" class="form-control select2" style="width:100%" name="satuank">
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
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli"> Jumlah Satuan Kecil</p>
                                            <div class="col-sm-3">
                                                <input type="number" class="form-control" name="qty" id="qty" min=1 onchange="set_harga_kecil(this.value)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Harga Satuan Kecil</p>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="harga_beli_kecil" id="harga_beli_kecil">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <p class="col-sm-3 form-control-label text-right"
                                               id="lbl_biaya_poli">Total</p>
                                            <div class="col-sm-3">
                                                <input type="text" class="form-control" name="hargapo" id="hargapo">
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
                            <div class="table-responsive m-t-0">	
                            <table id="example"
                                   class="display nowrap table table-hover table-bordered table-striped"
                                   cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                <th><p align="center">ID Obat</p></th>
                                    <th><p align="center">Nama Obat</p></th>
                                    <th><p align="center">Satuan Besar</p></th>
                                    <th><p align="center">Harga Satuan Besar</p></th>
                                    <th><p align="center">Qty Satuan Besar</p></th>
                                    <th><p align="center">Satuan Kecil</p></th>
                                    <th><p align="center">Qty Satuan Kecil</p></th>
                                    <th><p align="center">Harga Satuan Kecil</p></th>
                                    <th><p align="center">Total</p></th>
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

    <script>
	// Jquery Dependency

$("#hargagd").on({
    keyup: function() {
      formatCurrency($(this));
    },
    blur: function() { 
      formatCurrency($(this), "blur");
    }
});



function formatNumber(n) {
  // format number 1000000 to 1,234,567
  return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
}


function formatCurrency(input, blur) {
  // appends $ to value, validates decimal side
  // and puts cursor back in right position.
  
  // get input value
  var input_val = input.val();
  
  // don't validate empty input
  if (input_val === "") { return; }
  
  // original length
  var original_len = input_val.length;

  // initial caret position 
  var caret_pos = input.prop("selectionStart");
    
  // check for decimal
  if (input_val.indexOf(".") >= 0) {

    // get position of first decimal
    // this prevents multiple decimals from
    // being entered
    var decimal_pos = input_val.indexOf(".");

    // split number by decimal point
    var left_side = input_val.substring(0, decimal_pos);
    var right_side = input_val.substring(decimal_pos);

    // add commas to left side of number
    left_side = formatNumber(left_side);

    // validate right side
    right_side = formatNumber(right_side);
    
    // On blur make sure 2 numbers after decimal
    // if (blur === "blur") {
    //   right_side += "00";
    // }
    
    // Limit decimal to only 2 digits
    right_side = right_side.substring(0, 2);

    // join number by .
    input_val = left_side + "." + right_side;

  } else {
    // no decimal entered
    // add commas to number
    // remove all non-digits
    input_val = formatNumber(input_val);
    input_val = input_val;
    
    // final formatting
    // if (blur === "blur") {
    //   input_val += ".00";
    // }
  }
  
  // send updated string to input
  input.val(input_val);

  // put caret back in the right position
  var updated_len = input_val.length;
  caret_pos = updated_len - original_len + caret_pos;
  input[0].setSelectionRange(caret_pos, caret_pos);
}



</script>
<?php
$this->load->view('layout/footer_left.php');
?>