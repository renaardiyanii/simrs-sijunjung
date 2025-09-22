<?php 
     if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_horizontal");
        }
    ?> 
<script type="text/javascript" charset="utf-8">
$(function() {
	$('#table_diagnosa').dataTable();
    $('#id_dokter_konsul').select2();

    function setInputFilter(textbox, inputFilter) {
	["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
		textbox.addEventListener(event, function() {
		if (inputFilter(this.value)) {
			this.oldValue = this.value;
			this.oldSelectionStart = this.selectionStart;
			this.oldSelectionEnd = this.selectionEnd;
		} else if (this.hasOwnProperty("oldValue")) {
			this.value = this.oldValue;
			this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
		} else {
			this.value = "";
		}
		});
	});
	}

	setInputFilter(document.getElementById("cari_no_cm"), function(value) {
	return /^-?\d*$/.test(value); });

    $('.auto_search_by_nocm').autocomplete({
		serviceUrl: '<?php echo site_url();?>/irj/rjcautocomplete/data_pasien_by_nocm',
		onSelect: function (suggestion) {
			$('#cari_no_cm').val(''+suggestion.no_cm);
			$('#no_medrec_baru').val(''+suggestion.no_medrec);
            $('#nama').val(suggestion.nama);
            $('#yang_bayar').val(suggestion.nama);

		}
	});
});

function buatajax(){
    if (window.XMLHttpRequest){
    return new XMLHttpRequest();
    }
    if (window.ActiveXObject){
    return new ActiveXObject("Microsoft.XMLHTTP");
    }
    return null;
}

function ajaxlayanan(kategori){
	// console.log(kategori);

    ajaxku = buatajax();
    var url="<?php echo site_url('umc/cumcicilan/data_tindakan_non_medis'); ?>";
    url=url+"/"+kategori;
    url=url+"/"+Math.random();
    ajaxku.onreadystatechange=stateChangedDokter;
    ajaxku.open("GET",url,true);
    ajaxku.send(null);
}

function stateChangedDokter(){
    var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("id_dokter_konsul").innerHTML = data;
		}
    }
}

function ajaxmedrec(nocm){
	// console.log(nocm);


    // ajaxku = buatajax();
    // var url="<?php echo site_url('umc/cumcicilan/get_nama_by_medrec'); ?>";
    // url=url+"/"+nocm;
    // url=url+"/"+Math.random();
    // ajaxku.onreadystatechange=stateChangedMedrec;
    // ajaxku.open("GET",url,true);
    // ajaxku.send(null);
}

function stateChangedMedrec(){
    var data;
    if (ajaxku.readyState==4){
		data=ajaxku.responseText;
		if(data.length>=0){
			document.getElementById("nama").innerHTML = data;
            document.getElementById("yang_bayar").innerHTML = data;
		}
    }
}

function ajaxtarif(val) {
		var temp = val.split("@");
		temp[0] = (temp[0] == "" ? 0 : temp[0]);
		$('#tarif').val(temp[0]);
		// $('#biaya_tindakan_hide').val(temp[1]);
		// $('#paket').val(temp[2]);
		// var qty = $('#qtyind').val();
		// var total = ((parseInt(qty) * (parseInt(temp[1]) + parseInt(temp[3]))));
		// $('#vtot').val(total);
}

function showswal() {
		swal({
			title: "",
			text: "MOHON REFRESH HALAMAN",
			type: "success",
			showConfirmButton: true,
			showCancelButton: false,
			closeOnConfirm: false,
			showLoaderOnConfirm: true
		},
		function () {
			// window.location.reload();
			// window.location.reload();
			location.href = '<?php echo site_url('umc/cumcicilan/input_bayar_langsung');?>';
		});
	}

$(document).ready(function() {
	var cekview = "<?php echo $view;?>";
	if(cekview==0){
		tabeltindakan();
	}else{
		tabeltindakan();
	}
	$("#form_add_bayar").submit(function(event) {
		document.getElementById("btn-diagnosa").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Loading...';
		$.ajax({
			type: "POST",
			url: "<?php echo base_url().'umc/cumcicilan/insert_input_bayar_langsung'; ?>",
			dataType: "JSON",
			data: $('#form_add_bayar').serialize(),
			success: function(data){
					document.getElementById("btn-diagnosa").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
					$("#method_pay").val("").change();
					$("#jenis_bayar").val("").change();
					$("#id_dokter_konsul").val("").change();
                    $("#tarif").val("");
                    $("#keterangan").val("");
                    $("#qty").val("");
                    $('#tgl').val(data.tgl_cetak);
                    $('#no_cm').val(data.no_cm);
					document.getElementById("form_cetak").reset();
                    tabeltindakan();	
			},
			error:function(event, textStatus, errorThrown) {
				document.getElementById("btn-diagnosa").innerHTML = '<i class="fa fa-spinner fa-spin"></i> nyimpen...';
				console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			},
				timeout: 0
		});
		event.preventDefault();
	});
});

function tabeltindakan(){
    table = $('#table_umc').DataTable({
        ajax: "<?php echo site_url();?>umc/cumcicilan/detail_tindakan/",
        columns: [
            { data: "no" },
            { data: "pembayaran" },
            { data: "tarif" },
            { data: "qty" },
            { data: "jumlah" },
            { data: "penyetor" },
            { data: "penerima" },
            { data: "aksi"}
        ],
        columnDefs: [
            { targets: [ 0 ], visible: false }
        ],
        bFilter: true,
        bPaginate: true,
        destroy: true,
        order:  [[ 2, "asc" ],[ 1, "asc" ]]
   	});
}


</script>
 
    <!-- form -->
<div class="card card-outline-info">
    <div class="card-header">
    <h5 class="m-b-0 text-white text-center">Form Input Pembayaran Non Pasien</h5></div>
    <div class="card-block">
      <form id="form_add_bayar" method="POST">
            <div class="form-group row">
                <label for="nama" class="col-3 col-form-label">No Medrec</label>
                <div class="col-9">
                    <input type="search" class="auto_search_by_nocm form-control" id="cari_no_cm" name="cari_no_cm" placeholder="Pencarian No RM" onchange="ajaxmedrec(this.value)">
                    <input type="hidden" class="form-control" id="no_medrec_baru" name="no_medrec_baru" >
                </div>
            </div>
            <div class="form-group row">
                <label for="nama" class="col-3 col-form-label">Nama</label>
                <div class="col-9">
                    <input type="text" class="form-control" value="" name="nama" id="nama" >
                </div>
            </div>
            <div class="form-group row">
                <label for="jenis_bayar" class="col-3 col-form-label">Metode Pembayaran</label>
                <div class="col-9">
                    <select id="method_pay" class="form-control" name="method_pay" required>
                        <option value="">-Pilih Item-</option>
                        <option value="TUNAI">TUNAI</option>
                        <option value="BANK">BANK</option>
                        <option value="VA">Virtual Account</option>
                        <option value="PIUTANG/IKS">Piutang / Kerjasama</option>
					</select>	
                </div>
            </div>
            <div class="form-group row">
                <label for="jenis_bayar" class="col-3 col-form-label">Jenis Pembayaran</label>
                <div class="col-9">
                    <select id="jenis_bayar" class="form-control" name="jenis_bayar" onchange="ajaxlayanan(this.value)" required>
                        <option value="">-Pilih Item-</option>
                        <option value="Administrasi">Administrasi</option>
                        <?php 
                        foreach($layanan as $row){
                            echo '<option value="'.$row->kategori.'">'.$row->kategori.'</option>';
                        }
                        ?>
					</select>	
                </div>
            </div>
            <div class="form-group row">
                <label for="jenis_bayar" class="col-3 col-form-label">Tindakan</label>
                <div class="col-9">
                <select id="id_dokter_konsul" class="form-control select2" style="width: 100%" name="id_dokter_akhir" onchange="ajaxtarif(this.value)" required>
					<?php
						// if(isset($konsul->id_dokter_akhir)?$konsul->id_dokter_akhir:''){
						// 	echo '<option value="'.$row->id_dokter.''.$row->nm_dokter.'" selected>'.$konsul->nm_dokter.'</option>';
						// }
					?>
				</select>	
                </div>
            </div>

             <!--  <div class="form-group row">
                   <label for="jenis_bayar" class="col-3 col-form-label">Jenis Pembayaran</label>
                    <div class="col-9">
                
                        <select id="prop" class="form-control select2" name="idtindakan" onchange="pilih_tindakan(this.value)" style="width:100%;" required>
                            <option value="">-Pilih Item-</option>
                            <?php 
                            foreach($layanan as $row){
                                echo '<option value="'.$row->idtindakan.'">'.$row->nmtindakan.' | Rp. '.number_format($row->total_tarif, 2 , ',' , '.' ).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div> 
             -->
            <div class="form-group row">
                <label for="Tarif" class="col-3 col-form-label">Tarif</label>
                <div class="input-group col-9">
						<span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="tarif" id="tarif" placeholder="Masukin Tarif" >
					</div>
            </div>

            
            <div class="form-group row">
                <label for="Qty" class="col-3 col-form-label">QTY</label>
                <div class="input-group col-9">
						<!-- <span class="input-group-addon">Rp</span> -->
						<input type="number" class="form-control" value="1" name="qty" id="qty" placeholder="Qty" min="1">
					</div>
            </div>	
            
            <!-- <div class="form-group row">
                <label for="jumlah_bayar" class="col-3 col-form-label">Total</label>
                <div class="input-group col-9">
						<input type="text" class="form-control" name="jumlah_bayar" id="jumlah_bayar" placeholder="Jumhah Yang dibayarkan" disable>
					</div>
            </div> -->

            <!-- <div class="form-group row">
                <label for="nom_kredit" class="col-3 col-form-label">Nominal Sisa</label>
                <div class="input-group col-9">
						<span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="nom_kredit" id="nom_kredit" placeholder="Nominal Sisa" >
					</div>
            </div> -->
            <!-- <div class="form-group row">
                <label for="nom_diskon" class="col-3 col-form-label">Nominal Diskon</label>
                <div class="input-group col-9">
						<span class="input-group-addon">Rp</span>
						<input type="text" class="form-control" name="nom_diskon" id="nom_diskon" placeholder="Nominal Diskon" >
					</div>
            </div>		 -->
			<div class="form-group row">
                <label for="note_umc" class="col-3 col-form-label">Catatan</label>
                <div class="col-9">
                    	<textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="5" style="resize:vertical"></textarea>
                </div>
            </div>
            <!-- <div class="form-group row">
                <label for="prop" class="col-3 col-form-label">Cicilan Ke</label>
                <div class="col-9">
                    	<select id="prop" class="form-control" name="klasifikasi_diagnosa" required>
									<option value="<?php //echo $detail_cicilan;?>"><?php //echo $detail_cicilan;?></option>';
								</select>	
                </div>
            </div> -->
            <div class="form-group row">
                <label for="penyetor_umc" class="col-3 col-form-label">Sudah Terima Dari</label>
                <div class="col-9">
                    	<input type="text" class="form-control"  name="yang_bayar" id="yang_bayar" >
                </div>
            </div>
			<div class="form-group row">
				<div class="offset-sm-3 col-sm-9">									
					<input type="hidden" class="form-control" value="<?php //echo $pasien_umc->no_medrec;?>" name="no_medrec" id="no_medrec">
					<button type="reset" class="btn btn-danger"><i class="fa fa-eraser"></i> Reset</button>
					<button type="submit" class="btn btn-primary" id="btn-diagnosa"><i class="fa fa-floppy-o"></i> Simpan</button>
				</div>
			</div>										
		</form>
								
		<!-- table -->
		<br>
		<div class="table-responsive">
			<table id="table_umc" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>No</th>
						<!-- <th>No ID</th> -->
                        <th>Pembayaran</th>
						<!-- <th>No Kwitansi</th> -->
                        <th>Tarif</th>
                        <th>Qty</th>
						<th>Jumlah</th>
						<th >Penyetor</th>
						<th >Penerima</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php //$no=1; 
                    // foreach ($bayar_langsung as $um_cicilan) { 
                    //     $nocm = $um_cicilan->no_cm;
                    //     $tgl = $um_cicilan->tgl_cetak;
                    ?>
					<?php //} ?>
				</tbody> 
			</table>
		</div>
        <form class="form-horizontal" id="form_cetak" method="POST" target="_blank" action="<?php echo base_url('umc/cumcicilan/cetak_print/');?>">
			<div class="form-inline" align="right" style="padding-right:20px;">
				<div class="form-group">
					<?php //var_dump($tgl);die(); ?>
                    <input type="hidden" id='no_cm' name='no_cm'>
                    <input type="hidden" id='tgl' name='tgl'>
					<button type="submit" class="btn btn-primary" onclick="showswal()">Cetak</button>
					<!-- <a href="<?php echo base_url('umc/cumcicilan/cetak_print/'.$no_cm.'/'.$tgl) ?>" class="btn btn-primary" onclick="showswal()" target="_blank">Cetak</a> -->
				</div>
			</div>
		</form> 
	</div>
</div>
<?php 
    if ($role_id == 1) {
        $this->load->view("layout/footer_left");
    } else {
        $this->load->view("layout/footer_horizontal");
    }
?> 
