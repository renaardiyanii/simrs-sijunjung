<?php
if(!empty($list_mutasi_pasien)) {
   foreach($list_mutasi_pasien as $r) {
      //$diff = 1;
                  if($r['tglkeluarrg'] != null){
                     $start = new DateTime($r['tglmasukrg']);//start
                     $end = new DateTime($r['tglkeluarrg']);//end

                     $diff = $end->diff($start)->format("%a");
                     if($diff == 0){
                        $diff = 1;
                     }
                     //echo $diff." Hari"; 
                  }else{
                     if($data_pasien[0]['tgl_keluar'] != NULL){
                     $start = new DateTime($r['tglmasukrg']);//start
                        $end = new DateTime($data_pasien[0]['tgl_keluar']);//end

                        $diff = $end->diff($start)->format("%a");
                        if($diff == 0){
                           $diff = 1;
                        }
                        //echo $diff." Hari"; 
                     }else{
                        $start = new DateTime($r['tglmasukrg']);//start
                        $end = new DateTime(date("Y-m-d"));//end

                        $diff = $end->diff($start)->format("%a");
                        if($diff == 0){
                           $diff = 1;
                        }
                        
                        //echo $diff." Hari"; 
                     }
                  }
   }
} 
?>

<!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" /> -->

<!-- <script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script> -->

<script type="text/javascript">
	$('#tgl_pulang').datepicker({
		format: 'yyyy-mm-dd'
	});

function get_tarif(){
   var data1 = document.getElementById("kd_inacbg").value;
   console.log(data1.split("@")[1]);
   document.getElementById("tarif").value = data1.split("@")[0];
   document.getElementById("kode_inacbg").value = data1.split("@")[1];
}

function get_tarif_satu() {
   var data1 = document.getElementById("kd_inacbg_satu").value;
   console.log(data1.split("@")[1]);
   document.getElementById("tarif_satu").value = data1.split("@")[0];
   // document.getElementById("kode_inacbg").value = data1.split("@")[1];
   $('#kode_inacbg').val(data1.split("@")[1]);
}

function get_tarif_dua() {
   var data1 = document.getElementById("kd_inacbg_dua").value;
   console.log(data1.split("@")[1]);
   document.getElementById("tarif_dua").value = data1.split("@")[0];
   // document.getElementById("kode_inacbg").value = data1.split("@")[1];
   $('#kode_inacbg').val(data1.split("@")[1]);
}

function get_tarif2(){
   var data1 = document.getElementById("kd_inacbg2").value;
   console.log(data1.split("@")[1]);
   document.getElementById("tarif2").value = data1.split("@")[0];
   document.getElementById("kode_inacbg").value = data1.split("@")[1];
}

function get_tarif_vip(){
   var data1 = document.getElementById("kd_inacbg_vip").value;
   console.log(data1.split("@")[1]);
   document.getElementById("tarif_vip").value =  data1.split("@")[0];
   document.getElementById("kode_inacbg").value = data1.split("@")[1];
}

function get_tarif_titip(){
   var data1 = document.getElementById("kd_inacbg3").value;
   console.log(data1.split("@")[1]);
   document.getElementById("tarif3").value = data1.split("@")[0];
   document.getElementById("kode_inacbg").value = data1.split("@")[1];
}


var site = "<?php echo site_url(); ?>";
$(function(){
	$('.auto_diagnosa_pasien').autocomplete({
		serviceUrl: site+'iri/ricstatus/data_icd_1',
		onSelect: function (suggestion) {
			$('#diagnosa1').val(''+suggestion.nm_diagnosa);
			$('#id_row_diagnosa').val(''+suggestion.id_icd);
		}
	});
});

   function rawat_lagi(no_ipd){
      swal({
         title: "Kembalikan Pasien",
         text: "Benar Akan Memasukkan Pasien Ke ruangan?",
         type: "info",
         showCancelButton: true,
         closeOnConfirm: false,
         showLoaderOnConfirm: true,
      },
      function(){
         location.href = '<?php echo base_url("iri/rickwitansi/balikan_keruangan"); ?>/'+no_ipd;
      });
   }

   function edit_kasir(no_ipd){
      swal({
         title: "Edit Tindakan",
         text: "Edit Tindakan Pasien Ke ruangan?",
         type: "info",
         showCancelButton: true,
         closeOnConfirm: false,
         showLoaderOnConfirm: true,
      },
      function(){
         location.href = "<?php echo base_url("iri/rickwitansi/edit_tindakan_kasir"); ?>/"+no_ipd;
      });
   }

function update_cara_bayar(val){
	var r = confirm("Anda yakin ingin mengembalikan pasien ?");
	var no_ipd = $('#no_ipd').val();
	if (r == true) {
	   $.ajax({
		    type:'POST',
		    url:'<?php echo base_url("iri/rickwitansi/ubah_cara_bayar/"); ?>',
		    data:{
		    		'carabayar':val,
		    		'no_ipd':no_ipd
		    	},
		    success:function(data){
	    		if(data == '1'){
	    			alert("Cara bayar sukses diubah")
	    		}
		    }
		});
	   return true;
	} else {
	    return false;
	}
}

function set_total_2_ke_vip() {
   var tarif_real = "<?php echo $total;?>";
   var tarif_satu = $('#tarif_satu').val();
   var tarif_dua = $('#tarif_dua').val();
   var diskon = $('#diskon').val();
   var denda = $('#denda').val();
   var obat = "<?php echo $tot_obat?>";
   var tarif_satu_75 = 0.75 * parseInt(tarif_satu);
   var selisih_inacbg12 = parseInt(tarif_satu) - parseInt(tarif_dua);
   var max = (parseInt(tarif_real) + parseInt(obat)) - parseInt(tarif_dua);
   
   if(max <= 0) {
      var max_real = "(" + Math.abs(max) + ")";
      var jumlah = 0; 
      var selisih_kelas = '0 / impas';

      $('#ket_impas').val('impas');
   } else {
      var selisih_kelas = parseInt(tarif_satu_75) - parseInt(max);
      if(selisih_kelas > max) {
         var jumlah = max;
         var jml = "Rp. "+max.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      } else {
         var jumlah = selisih_kelas;
         var jml = "Rp. "+selisih_kelas.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
      }
      var max_real = max;
      $('#ket_impas').val('');
   }
   console.log(selisih_kelas);
   $('#biaya_max2').html("Rp. "+max_real.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#presentase_selisih_bayar2').html("Rp. "+tarif_satu_75.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   // $('#total_harga_gabungan').html("Rp. "+jumlah.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#total_harga_gabungan').html(jml);
   $('#selisih_kelas').html("Rp. "+selisih_kelas.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#biaya_max2_hidden').val(max_real);
   $('#presentase_selisih_bayar2_hidden').val(tarif_satu_75);
   $('#dibayar_tunai').val(jumlah);
   $('#selisih_kelas_hidden').val(selisih_kelas);

   // var umum_kelas2 = parseInt(tarif_real) - parseInt(tarif_dua);
   // if(umum_kelas2 < tarif_satu_75) {
   //    var jumlah = parseInt(umum_kelas2) - parseInt(tarif_satu_75);
   //    var total = parseInt(tarif_satu_75) + parseInt(jumlah);

   //    $('#total_harga_gabungan').html("Rp. "+total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   //    $('#dibayar_tunai').val(total);
   // } else {
   //    var jumlah = parseInt(umum_kelas2) - parseInt(tarif_satu_75);
   //    var pembanding = parseInt(jumlah) + parseInt(tarif_dua);

   //    if(pembanding < tarif_satu) {
   //       var total = parseInt(tarif_satu_75) + parseInt(jumlah);
   //    } else if(pembanding > tarif_satu) {
   //       var total = parseInt(tarif_satu_75) + parseInt(selisih_inacbg12);
   //    }

   //    $('#total_harga_gabungan').html("Rp. "+total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   //    $('#dibayar_tunai').val(total);
   // }
}

function set_total_1_ke_vip() {
   var tarif_real = "<?php echo $total;?>";
   var tarif_satu = $('#tarif_satu').val();
   var diskon = $('#diskon').val();
   var denda = $('#denda').val();
   var obat = "<?php echo $tot_obat?>";

   var umum_kelas1 = parseInt(tarif_real) - parseInt(tarif_satu);
   var tarif_satu_75 = 0.75 * parseInt(tarif_satu);
   var max = (parseInt(tarif_real) + parseInt(obat)) - parseInt(tarif_satu);

   if(max <= 0) {
      var max_real = "(" + Math.abs(max) + ")";
      var jumlah = 0; 
      $('#ket_impas').val('impas');
   } else { 
      if(tarif_satu_75 < max) {
         var jumlah = 0.75 * parseInt(tarif_satu);
      } else {
         var jumlah = max;
      }
      var max_real = max;
      $('#ket_impas').val('');
   }

   // if(umum_kelas1 > tarif_satu_75) {
   //    var jumlah = 0.75 * parseInt(tarif_satu);
   // } else {
   //    var jumlah = (parseInt(tarif_real) + parseInt(obat)) - parseInt(tarif_satu);
   // }
   
   $('#biaya_max').html("Rp. "+max_real.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#presentase_selisih_bayar').html("Rp. "+tarif_satu_75.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#total_harga_gabungan').html("Rp. "+jumlah.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#biaya_max_hidden').val(max_real);
   $('#presentase_selisih_bayar_hidden').val(tarif_satu_75);
   $('#dibayar_tunai').val(jumlah);
}

function set_total_2_ke_1() {
   var tarif_real = "<?php echo $total;?>";
   var tarif_satu = $('#tarif_satu').val();
   var tarif_dua = $('#tarif_dua').val();
   var diskon = $('#diskon').val();
   var denda = $('#denda').val();
   console.log(tarif_satu);
   console.log(tarif_dua);
   var jumlah = parseInt(tarif_satu) - parseInt(tarif_dua);
   
   console.log(jumlah);
   $('#total_harga_gabungan').html("Rp. "+jumlah.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#dibayar_tunai').val(jumlah);
}

function set_total_sama_kelas() {
   var tarif_real = "<?php echo $total;?>";
   var tarif_satu = $('#tarif').val();
   var tarif_dua = $('#tarif2').val();
   var diskon = $('#diskon').val();
   var denda = $('#denda').val();

   var jumlah = parseInt(tarif_satu) - parseInt(tarif_dua) - parseInt(diskon) + parseInt(denda);
   
   $('#total_harga_gabungan').html("Rp. "+jumlah.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#dibayar_tunai').val(0);
}

function set_total_umum() {
   var tarif_real = "<?php echo $total;?>";
   var diskon = $('#diskon').val();
   var denda = $('#denda').val();

   var jumlah = parseInt(tarif_real) - parseInt(diskon) + parseInt(denda);
   $('#total_harga_gabungan').html("Rp. "+jumlah.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#dibayar_tunai').val(jumlah);
}
 
function set_total(){
   var total = "<?php echo $total; ?>";
   var total1 = "<?php echo $total; ?>";
   var total3 = "<?php echo $total; ?>";
	var biaya_awal = $('#total_gabungan').val();
   var biaya_awal1 = $('#total_gabungan1').val();
   var biaya_awal3 = $('#total_gabungan3').val();
   var biaya_total = $('#biaya_total').val();
   var biaya_awal_pembulatan = $('#total_gabungan').val();
   var biaya_awal_pembulatan1 = $('#total_gabungan1').val();
   var biaya_awal_pembulatan3 = $('#total_gabungan3').val();
   var biaya_administrasi = $('#biaya_administrasi').val();
   var dibayar_tunai = $('#dibayar_tunai').val();
   var dibayar_tunai1 = $('#dibayar_tunai1').val();
   var dibayar_tunai3 = $('#dibayar_tunai3').val();
   var dibayar_tunai4 = $('#dibayar_tunai4').val();
   var dibayar_tunai5 = $('#dibayar_tunai5').val();
   var dibayar_tunai5 = $('#dibayar_tunai6').val();
   var denda = $('#denda').val();
   var totalselisih = $('#tarif').val();
   var totalselisih2 = $('#tarif2').val();
   var totalselisih3 = $('#tarif_vip').val();
   var totalselisih4 = $('#tarif3').val();
   // var totalselisih4 = $('#tarif_vip').val();
   // var totalselisih5 = $('#tarif_vip').val();
   var site = "<?php echo $diff; ?>";
   console.log(site);
   //var site = "<?php echo site_url('iri/rickwitansi/string_table_mutasi_ruangan'); ?>";
   // var obat = $('#biaya_obat').val();
   var diskon = $('#diskon').val();
   console.log('total '+total);
   console.log('total1 '+total1);
   console.log('totalselisih '+totalselisih);
   console.log('totalselisih '+totalselisih2);
   console.log('totalselisih '+totalselisih3);
   console.log('totalselisih '+totalselisih4);
   //console.log('b awal '+biaya_awal);
   //onsole.log('b tot'+biaya_total);
   // console.log('awal bulat'+biaya_awal_pembulatan);
   // console.log('b admin'+biaya_administrasi);
   // console.log('b tunai'+dibayar_tunai);
   console.log('denda'+denda);
   console.log('diskon'+diskon);

   if(biaya_administrasi == ""){
      biaya_administrasi = 0;
   }
   if(dibayar_tunai == ""){
      dibayar_tunai = 0;
   }

   if(dibayar_tunai1 == ""){
      dibayar_tunai1 = 0;
   }

   if(dibayar_tunai3 == ""){
      dibayar_tunai3 = 0;
   }

   if(dibayar_tunai4 == ""){
      dibayar_tunai4 = 0;
   }

   if(dibayar_tunai5 == ""){
      dibayar_tunai5 = 0;
   }

   if(dibayar_tunai6 == ""){
      dibayar_tunai6 = 0;
   }
 
   if(denda == ""){
      denda = 0;
   }
 
   if(totalselisih < totalselisih2) {
      var dibayar_tunai = parseInt(0); 
   } else {
      var dibayar_tunai = parseInt(totalselisih) - parseInt(totalselisih2);
   }
   var dibayar_tunai1 = parseInt(total1) + parseInt(biaya_administrasi) - parseInt(diskon) + parseInt(denda);
   var dibayar_tunai4 = parseInt(total1) + parseInt(biaya_administrasi) - parseInt(diskon) + parseInt(denda);
   var dibayar_tunai6 = parseInt(totalselisih4);
   var dibayar_tunai5 = parseInt(total) + parseInt(biaya_administrasi) - parseInt(diskon) + parseInt(denda);
   // if(lama_inap = 1) {
   //    var dibayar_tunai3 = parseInt(totalselisih3) + parseInt(totalselisih3 / 5);
   // } else if(lama_inap = 2) {
   //    var dibayar_tunai3 = parseInt(totalselisih3) + parseInt(totalselisih3 / 5);
   // } else if(lama_inap = 3) {
   //    var dibayar_tunai3 = parseInt(totalselisih3) + parseInt(totalselisih3 / 5);
   // } else if(lama_inap = 4) {
   //    var dibayar_tunai3 = parseInt(totalselisih3) + parseInt(totalselisih3 / 2);
   // } else if(lama_inap = 5) {
   //    var dibayar_tunai3 = parseInt(totalselisih3) + parseInt(totalselisih3 / 2);
   // } else if(lama_inap = 6) {
   //    var dibayar_tunai3 = parseInt(totalselisih3) + parseInt(totalselisih3 / 2);
   // } else if(lama_inap = 7) {
   //    var dibayar_tunai3 = parseInt(totalselisih3) + parseInt(totalselisih3 / 2);
   // } else if(lama_inap > 7) {
   //    var dibayar_tunai3 = parseInt(totalselisih3) + parseInt(totalselisih3);
   // }
   if (site <= 3) {
      var dibayar_tunai3 = parseInt(totalselisih3 * 0.3);
   } else if((site > 3) && (site <= 8)) {
      var dibayar_tunai3 = parseInt(totalselisih3 / 2);
   } else if (site > 8) {
      var dibayar_tunai3 = parseInt(totalselisih3 * 0.75);
   } 
   console.log(dibayar_tunai);
   console.log(dibayar_tunai1);
   console.log(dibayar_tunai3);
   console.log(dibayar_tunai4);
   console.log(dibayar_tunai5);
   console.log(dibayar_tunai6);
   $('#dibayar_tunai').val(dibayar_tunai);
   $('#dibayar_tunai1').val(dibayar_tunai1);
   $('#dibayar_tunai3').val(dibayar_tunai3);
   $('#dibayar_tunai4').val(dibayar_tunai4);
   $('#dibayar_tunai5').val(dibayar_tunai5);
   $('#dibayar_tunai6').val(dibayar_tunai6);
   $('#biaya_administrasitxt').html("Rp. "+biaya_administrasi.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")); 
   $('#biaya_administrasi').val(biaya_administrasi);    
   // biaya_awal=parseInt(total)+parseInt(biaya_administrasi);
	var total_harga_gabungan = parseInt(dibayar_tunai); //+ parseInt(dibayar_kartu_cc_debit) + parseInt(total_charge);
   var total_harga_gabungan1 = parseInt(dibayar_tunai1);
   var total_harga_gabungan3 = parseInt(dibayar_tunai3);
   var total_harga_gabungan4 = parseInt(dibayar_tunai4);
   var total_harga_gabungan5 = parseInt(dibayar_tunai5);
   var total_harga_gabungan6 = parseInt(dibayar_tunai6);
   var biaya_akhir = parseInt(biaya_awal) + parseInt(denda);
   var biaya_akhir1 = parseInt(biaya_awal1) + parseInt(denda);
   var biaya_akhir3 = parseInt(biaya_awal3) + parseInt(denda);
   //var total_harga_gabungan_pembulatan = parseInt(biaya_awal) - parseInt(diskon) + parseInt(denda);
   var biaya_dibayar = (parseInt(biaya_akhir) + parseInt(biaya_awal));
   var biaya_dibayar1 = (parseInt(biaya_akhir1) + parseInt(biaya_awal1));
   var biaya_dibayar3 = (parseInt(biaya_akhir3) + parseInt(biaya_awal3));
	$('#grand_total_show').html("Rp. "+biaya_akhir.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#total_harga_gabungan').html("Rp. "+total_harga_gabungan.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#grand_total_show1').html("Rp. "+biaya_akhir1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   // $('#total_harga_gabungan').html("Rp. "+total_harga_gabungan.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   //$('#total_harga_gabungan').html("Rp. "+total_harga_gabungan.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#total_harga_gabungan1').html("Rp. "+total_harga_gabungan1.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#grand_total_show3').html("Rp. "+biaya_akhir3.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#total_harga_gabungan3').html("Rp. "+total_harga_gabungan3.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#total_harga_gabungan4').html("Rp. "+total_harga_gabungan4.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#total_harga_gabungan5').html("Rp. "+total_harga_gabungan5.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   $('#total_harga_gabungan6').html("Rp. "+total_harga_gabungan6.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
   
}

function showswal() {
	var base = "<?php echo base_url(); ?>";
   var jenis = "<?php echo $jenis ?>"
	new swal({
		title: "",
		text: "MOHON REFRESH HALAMAN",
		type: "success",
		showConfirmButton: true,
		showCancelButton: false,
		closeOnConfirm: false,
		showLoaderOnConfirm: true
	},
	function () {
      if(jenis == 'UMUM'){
         window.location.href = base+"iri/rickwitansi/";
      }else{
         window.location.href = base+"iri/rickwitansi/kwitansi_ranap_iri";
      }
		
	});
}

$(document).ready(function() {
   $('#kd_inacbg').select2();
   $('#kd_inacbg2').select2();
   $('#kd_inacbg3').select2();
   $('#kd_inacbg_vip').select2();
   $('.select2').select2();
});
</script>

<style>
   i{
      font-size: 13px;
   }
</style>

<section class="content-header">
   <div class="row">
      <div class="col-sm-6">
         <div class="card card-outline-success">
            <div class="card-header text-white" align="center">Data Pasien</div>
               <div class="card-block">
                  <br/>
                  <div class="row">
                     <div class="col-sm-12">
                        <div align="center"><img height="100px" class="img-rounded" src="<?php 
                           if($data_pasien[0]['foto']==''){
                              echo site_url("upload/photo/unknown.png");
                           }else{
                              echo site_url("upload/photo/".$data_pasien[0]['foto']);
                           }
                           ?>"></div>
                     </div>
                     <div class="col-sm-12">
                        <form target="_blank" action="<?php echo site_url('iri/ricstatus/kalkulasi_harga/'); ?>" method="post">
                           <table class="table-sm table-striped" style="font-size:15">
                              <tbody>
                                 <tr>
                                    <th>Nama</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien[0]['nama'];?></td>
                                 </tr>
                                 <tr>
                                    <th>No. MR</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien[0]['no_cm'];?></td>
                                 </tr>
                                 <tr>
                                    <th>No. Register</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien[0]['no_ipd'];?></td>
                                 </tr>
                                 <tr>
                                    <th>Umur</th>
                                    <td>:&nbsp;</td>
                                    <td><?php
                                       $interval = date_diff(date_create(), date_create($data_pasien[0]['tgl_lahir']));
                                       echo $interval->format("%Y Tahun, %M Bulan, %d Hari");
                                       ?>
                                    </td>
                                 </tr>
                                 <tr>
                                    <th>Gol Darah</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo $data_pasien[0]['goldarah'];?></td>
                                 </tr>
                                 <tr>
                                    <th>Tanggal Kunjungan</th>
                                    <td>:&nbsp;</td>
                                    <td><?php echo date("j F Y", strtotime($data_pasien[0]['tgl_masuk'])); ?></td>
                                 </tr>
                                 <tr>
                                    <th>Kelas Terakhir</th>
                                    <td>:&nbsp;</td>
                                    <td name="kls"><?php echo $data_pasien[0]['klsiri'];?></td>
                                 </tr>
                                 <tr>
                                    <th>Jatah Kelas</th>
                                    <td>:&nbsp;</td>
                                    <td name="jatahkls"><?php echo $data_pasien[0]['jatahklsiri'];?></td>
                                 </tr>
                                 <!-- <tr>
                                    <th>Status</th>
                                    <td>:&nbsp;</td>
                                    <?php
                                    if($get_jatahkls = $get_kls){ ?>
                                       <td>Tidak Naik Kelas</td>
                                    <?php
                                    }else if($get_jatahkls ){ ?>
                                       <td></td>
                                    <?php
                                    }
                                    ?>
                                 </tr> -->
                                 <tr>
                                    <th></th>
                                    <td>&nbsp;</td>
                                    <!-- <td><a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'];?>" target="_blank"> <input type="button" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak Detail Pembayaran"></a></td> -->
                                    <td>
                                    <input type="hidden" value="<?php echo $data_pasien[0]['no_ipd'];?>" name="no_ipd" id="no_ipd">
                                 </tr>
                        </form>
                        </tbody>
                        </table>
                     </div>
                  </div>
                  <br/>
               </div>
            </div>

            <!-- <div class="card card-outline-info">
               <div class="card-header text-white" align="center">Kelengkapan Administrasi</div>
               <div class="card-block">
                  <form action="<?php echo site_url('iri/rickwitansi/insert_adm_tertunda'); ?>" method="post">
                     <div class="form-check adm">
                        <div class="form-group row">
                           
                           <div class="col-sm-6">
                              <input class="form-check-input" type="checkbox" id="admin_tunda" name="admin_tunda" value=1 <?php echo isset($data_pasien[0]['administrasi_tertunda']) ? $data_pasien[0]['administrasi_tertunda'] == "1" ? "checked" : '' : '' ?>>
                              <label for="admin_tunda" class="form-check-label">Belum Selesai Administrasi</label><br>
                           </div>
                        </div>
                        <div class="form-group row">
                           <p class="col-sm-3 form-control-label" id="lbl_nmgudang">Alasan Titipan</p>
                           <div class="col-sm-6">
                              <input type="text" class="form-control" name="alasan_titipan" id="alasan_titipan" value="<?= $data_pasien[0]['alasan_titipan'] ?>">
                           </div>
                        </div>
                        <div class="form-group row">
                           <p class="col-sm-3 form-control-label" id="lbl_nmgudang">Jaminan</p>
                           <div class="col-sm-6">
                              <input type="text" class="form-control" name="jaminan_adm" id="jaminan_adm" value="<?= $data_pasien[0]['jaminan_adm'] ?>">
                           </div>
                        </div>
                        <div class="form-group row">
                           <p class="col-sm-3 form-control-label" id="lbl_nmgudang">Uang Muka(jika ada)</p>
                           <div class="col-sm-6">
                              <input type="text" class="form-control" name="uang_muka_adm" id="uang_muka_adm" value="<?= $data_pasien[0]['uang_muka_adm'] ?>">
                           </div>
                        </div>
                      
                        
                     </div>
                     <div class="form-inline" align="right">
                        <input type="hidden" class="form-control" value="<?php echo $data_pasien[0]['no_ipd']; ?>" name="no_ipd">
                        <div class="form-group" align="right">
                           <button type="reset" class="btn btn-warning btn-sm">Reset</button>&nbsp;
                           <input type="submit" class="btn btn-primary btn-sm" id="btn_simpan" value="Simpan">&nbsp;
                           <?php 
                           if($data_pasien[0]['administrasi_tertunda'] == 1){ ?>
                              <a href="<?php echo site_url('iri/rickwitansi/cetak_surat_adm/'.$data_pasien[0]['no_ipd']); ?>" class="btn btn-default btn-sm-primary" target = "_blank">Cetak</a>
                           <?php }
                           ?>
                         
                        </div>
                     </div>
                  </form>

               </div>
            </div> -->

      </div>
       <div class="col-sm-6">
         <div class="card card-outline-danger">
            <div class="card-header text-white" align="center">Pembayaran</div>
            <div class="card-block">
               <div class="row">
                  <div class="col-sm-12">
                     <form target="_blank" action="<?php echo site_url('iri/ricstatus/kalkulasi_harga/'); ?>" method="post">
                        <table class="table-sm table-striped" style="font-size:15">
                           <tbody>
                              <tr>
                                 <th>Cara Bayar</th>
                                 <td>:&nbsp;</td>
                                 <td>
                                    <?php echo $data_pasien[0]['carabayar'];?>
                                    <!-- <select name="carabayar" onchange="update_cara_bayar(this.value)">
                                       <?php
                                          foreach ($cara_bayar as $r) { 
                                          	if($r['cara_bayar'] == $data_pasien[0]['carabayar']){ ?>
                                       	<option value="<?php echo $r['cara_bayar'] ;?>" selected><?php echo $r['cara_bayar'] ;?></option>
                                       	<?php
                                          }else{ ?>
                                       	<option value="<?php echo $r['cara_bayar'] ;?>"><?php echo $r['cara_bayar'] ;?></option>
                                       	<?php
                                          }
                                          ?>
                                       <?php
                                          }
                                          ?>
                                       ?> -->
                                 </td>
                              </tr>
                              <!-- <tr>
                                 <th></th>
                                 <td>&nbsp;</td>
                                 <td>
                                    <?php //echo $data_pasien[0]['nmkontraktor'];?>                             
                                 </td>
                              </tr> -->
                              <tr>
                                 <th>Jenis Pembayaran</th>
                                 <td>:&nbsp;</td>
                                 <td>
                                    <select name="jenis_pembayaran" class="form-control">
                                       <option value="TUNAI" selected>TUNAI</option>
                                       <option value="BANK">BANK</option>
                                       <option value="VA">Virtual Account</option>
                                       <!-- <option value="split">Split Payment</option>
                                       <option value="PIUTANG/IKS">Piutang/Cicilan</option> -->
                                    </select>
                                 </td>
                              </tr> 
                              <!-- <tr>
                                 <th>Biaya Total</th>
                                 <td>:&nbsp;</td>
                                    <td>Rp. <?php// echo number_format($total,0);?></td>
                                    <input type="hidden" value="<?php // echo $total;?>" id="biaya_total" name="biaya_total">
                              </tr>
                              <tr>
                                 <th>Total Dibayar Pasien</th>
                                 <td>:&nbsp;</td>
                                    <td><div id="total_harga_gabungan">Rp. <?php // echo number_format($grand_total,0);?></div></td>
                                    <input type="hidden" value="<?php // echo $grand_total;?>" id="total_gabungan" name="total_gabungan">
                              </tr> -->

                              <tr>
                                 <th></th>
                                 <td>&nbsp;</td>
                               
                                    <td><input type="hidden" name="dibayar_tunai" id="dibayar_tunai" value="<?php echo $grand_total; ?>" class="form-control" value="0"></td>
                                    <td><input type="hidden" name="kode_inacbg" id="kode_inacbg" class="form-control"></td>
                                    <td><input type="hidden" name="ket_impas" id="ket_impas" class="form-control"></td>
                              </tr>
                              <tr>
                                 <th>Penerima</th>
                                 <td>:&nbsp;</td>
                                 <td><input type="text" name="penerima" id="penerima" class="form-control input-sm" value="<?php echo $data_pasien[0]['nama'];?>" required></td>
                              </tr>
                              <tr>
                                 <th></th>
                                 <td>&nbsp;</td>
                                 <td>
                                    <input type="submit" class="btn btn-primary btn-sm" id="btn_simpan" value="Cetak Kwitansi" onclick="showswal()">
                                    <br><br>
                                    <a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'].'/0';?>" target="_blank"><input type="button" class="btn btn-info btn-sm" value="Cetak Rincian Kwitansi"></a>
                                    <a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_pasien/<?php echo $data_pasien[0]['no_ipd'].'/7';?>" target="_blank"><input type="button" class="btn btn-info btn-sm" value="Cetak Kwitansi (e-Klaim)"></a>
                                    <!-- <a href="<?php echo base_url();?>iri/ricstatus/cetak_list_pembayaran_skrd/<?php echo $data_pasien[0]['no_ipd'];?>" target="_blank"><input type="button" class="btn btn-info btn-sm" value="Cetak Kwitansi(SKRD)"></a> -->
                                 </td>
                                 <input type="hidden" value="<?php echo $data_pasien[0]['no_ipd'];?>" name="no_ipd" id="no_ipd">                                 
                              </tr>
                             
                     </form>
                     </tbody>
                     </table>
                  </div>
               </div>
               <br/>
            </div>
         </div>
      </div>
      <!-- <div class="col-sm-6">
         <div class="panel panel-default">
         	<div class="panel-heading" align="center">Pemerikasaan Lanjutan</div>
         	<div class="panel-body">
         	<br/>
         		<form action="<?php //echo site_url('iri/rictindakan/update_tindakan_lain'); ?>" method="post">
         			<div class="form-group row">
         				<p class="col-sm-4 form-control-label" id="ket_pulang">Pilih Identitas</p>
         					<div class="col-sm-8">
         						<div class="form-inline">
         							<div class="form-group">
         								<select class="form-control" name="ket_pulang">
         									<option value="">-Pilih Ket Pulang-</option>
         									<option value="PULANG">PULANG</option>
         									<option value="DIPULANGKAN">DIPULANGKAN</option>
         									<option value="MENINGGAL">MENINGGAL</option>
         									<option value="MELARIKAN DIRI">MELARIKAN DIRI</option>
         								</select>
         							</div>
         						</div>
         					</div>
         			</div>
         			<div class="form-group row">
         				<p class="col-sm-4 form-control-label" id="ket_pulang">Diagnosa</p>
         					<div class="col-sm-8">
         						<div class="form-inline">
         							<div class="form-group">
         								<input type="text" value="" class="form-control input-sm auto_diagnosa_pasien" name="diagnosa1" id="diagnosa1" />
         							</div>
         						</div>
         					</div>
         			</div>
         			<div class="form-group row">
         				<div class="col-sm-8">
         					<label class="checkbox-inline">
         						<input type="checkbox" id="lab" name="lab" value="1" <?php if($data_pasien[0]['lab'] == 1){echo "checked='true'" ; }?> > Laboratotium
         					</label>
         					<label class="checkbox-inline">
         						<input type="checkbox" id="rad" name="rad" value="1" <?php if($data_pasien[0]['rad'] == 1){echo "checked='true'" ;}?>> Radiologi
         					</label>
         					<label class="checkbox-inline">
         						<input type="checkbox" id="obat" name="obat" value="1" <?php if($data_pasien[0]['obat'] == 1){echo "checked='true'" ;}?>> Obat
         					</label>
         				</div>
         			</div>
         			
         			<div class="form-inline" align="right">
         				<input type="hidden" class="form-control" value="<?php echo $data_pasien[0]['no_ipd'];?>" name="no_ipd">
         				<input type="hidden" class="form-control" value="" name="id_row_diagnosa" id="id_row_diagnosa">
         				<div class="form-group">
         					<button type="reset" class="btn btn-default btn-sm">Reset</button>
         					<input type="submit" class="btn btn-primary btn-sm" id="btn_simpan" value="Simpan">
         				</div>
         			</div>
         		</form>					</div>
         </div>
         </div> -->
   </div>
</section>

<script type="text/javascript">
 $(document).ready(function() {
     $('#kd_inacbg').select2();
 });

 $(document).ready(function() {
     $('#kd_inacbg2').select2();
 });

 $(document).ready(function() {
     $('#kd_inacbg_vip').select2();
 });
</script>