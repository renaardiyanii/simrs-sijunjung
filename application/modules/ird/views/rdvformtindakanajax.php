<?php 
$this->load->view('layout/header_form');
?>

<?php 
	//include('script_rdvpelayanan.php');	
	?>
  
<script type="text/javascript">
 

  $(document).ready(function(){
    $('#pelaksana').select2();
    // hide biaya @aldi
    $('.hidden').hide();
    $('#prop').select2();

    $('.clockpicker').clockpicker({
        	donetext: 'Done',
    	}).find('input').change(function() {
        	console.log(this.value);
    	});
    $("#intime_jadwal_ok").timepicker({
      showInputs: false,
      showMeridian: false
    });

 
  });
	function surat_tindakan()
	{	
			$("#MyModalSurat").modal('show');

	}
	function surat_tindakan_jiwa()
	{	
			$("#MyModalSuratJiwa").modal('show');

	}

	function insert(){
    console.log($('#MyModalSurat').serialize());
    var noreg = "<?php echo $no_register; ?>";
    var amphe = $('#amphetamin').val();
    var opiat = $('#opiat').val();
    var thc = $('#thc').val();
    var ket = $('#keterangan').val();
    var hasil = $('#hasil').val();
    var nosur = $('#nosur').val();
    var bulan = $('#bulan').val();
    
    //document.cookie = "no_register='"+noreg+"'"; 
    //document.cookie = "a='a'"; 
    //document.cookie = "id_loket='.$data9['id_loket'].'"; document.cookie = "no_kwitansi='.$data9['no_kwitansi'].'";'.$txtpilih.' 
    //window.open("<?php //echo site_url("ird/rdcpelayanan/cetak_surat_keterangan")?>", "_blank");
   // 	window.focus();
    document.getElementById("submit_add").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'ird/rdcpelayanan/cetak_surat_keterangan_st/';?>",
       // dataType: "JSON",
        data:{no_register:noreg, opiat:opiat, amphe:amphe, thc:thc, ket:ket, hasil:hasil, nosur:nosur, bulan:bulan},
        success: function(data){
        	window.open("<?php echo site_url("ird/rdcpelayanan/cetak_surat_keterangan")?>","_blank");window.focus();
        	$("#MyModalSurat").modal('hide');
        },
       error:function(event, textStatus, errorThrown) {
              // document.getElementById("alert-modal-add").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Gagal menyimpan data.</div>';
              // document.getElementById("submit_add").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
  } 

function insert2(){
    console.log($('#MyModalSuratJiwa').serialize());
    var noreg = "<?php echo $no_register; ?>";
   
    var ket = $('#keterangan2').val();
    var hasil = $('#hasil2').val();
    var nosur = $('#nosur2').val();
    var bulan = $('#bulan2').val();
    
    //document.cookie = "no_register='"+noreg+"'"; 
    //document.cookie = "a='a'"; 
    //document.cookie = "id_loket='.$data9['id_loket'].'"; document.cookie = "no_kwitansi='.$data9['no_kwitansi'].'";'.$txtpilih.' 
    //window.open("<?php //echo site_url("ird/rdcpelayanan/cetak_surat_keterangan")?>", "_blank");
   // 	window.focus();
    document.getElementById("submit_add2").innerHTML = '<i class="fa fa-spinner fa-spin"></i> Processing...';
    $.ajax({
        type: "POST",
        url: "<?php echo base_url().'ird/rdcpelayanan/cetak_surat_keterangan_st_jiwa/';?>",
       // dataType: "JSON",
        data:{no_register:noreg, ket2:ket, hasil2:hasil, nosur2:nosur, bulan2:bulan},
        success: function(data){
        	window.open("<?php echo site_url("ird/rdcpelayanan/cetak_surat_keterangan_jiwa")?>","_blank");window.focus();
        	$("#MyModalSuratJiwa").modal('hide');
        },
       error:function(event, textStatus, errorThrown) {
              // document.getElementById("alert-modal-add").innerHTML = '<div class="alert alert-danger alert-dismissable"><button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>Gagal menyimpan data.</div>';
              // document.getElementById("submit_add").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
        },
        timeout: 0
    });
  } 


  function pilih_tindakan(tindakan) {
	//alert(tindakan);	
	if(tindakan!=''){
		var result = tindakan.split('@');
		var id_tindakan = result[0];
		
		if(id_tindakan.substring(0,2)=='1B') {
			$("#dokterDiv").show();
			document.getElementById("id_dokter").required = false;
		} else {
			$("#dokterDiv").show();
			document.getElementById("id_dokter").required = true;
		}
		//var cara_bayar = document.getElementById("cara_bayar").required = true;
		$.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('ird/rdcpelayanan/get_biaya_tindakan')?>",
			data: {
				id_tindakan: id_tindakan,
				kelas : "<?php echo $kelas_pasien ?>",
        cara_bayar : "<?php echo $cara_bayar ?>"
			},
			success: function(data){
				// alert(data.tarif);
				$('#biaya_tindakan').val(data.tarif);
				$('#biaya_tindakan_hide').val(data.tarif);
        $('#tmno').val(data.tmno);
				$('#qtyind').val(1);
				$('#vtot').val(data.tarif);
				$('#vtot_hide').val(data.tarif);

			},
			error: function(xhr, status, error) {
				alert(xhr.responseText);
			}
	    });
	}else
		document.getElementById("id_dokter").required = true;
	
	
};



 

  

</script>

<div class="card m-5">
	<div class="card-header">
        <div class="container-fluid">
            <h5>Tindakan</h5>
        </div>
  </div>

  <div class="card-body">	
        <form class="form" id="form_add_tindakan_tindakan">
            <div class="form-group row mb-4">
                <p class="col-sm-2 form-control-label" >Tindakan *</p>
                <div class="col-sm-6">
                      <select id="prop" class="form-control select2" name="idtindakan" onchange="pilih_tindakan(this.value)" style="width:100%;" required>
                        <option value="">-Pilih Tindakan-</option>
                        <?php 
                        foreach($tindakans as $row){
                          
                            echo '<option value="'.$row->idtindakan.'@'.$row->nmtindakan.'">'.$row->nmtindakan.' | '.$row->tmno.' | Rp. '.number_format($row->tarif, 2 , ',' , '.' ).'</option>';
                          
                        }
                        ?>
                      </select>
                </div>
            </div> 

            <div class="form-group row mb-4 ">
              <p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Jenis</p>
              <div class="col-sm-3">
                <div class="input-group">
                  <!-- <span class="input-group-addon">Rp</span> -->
                  <input type="text" class="form-control" name="tmno" id="tmno">
                  <!-- <input type="hidden" class="form-control" name="biaya_tindakan_hide" id="biaya_tindakan_hide"> -->
                </div>
              </div>
            </div>

              <div class="form-group row mb-4" id="dokterDiv" hidden>
              <p class="col-sm-2 form-control-label" id="label_dokter">Pelaksana Dokter*</p>
              <div class="col-sm-10">
                  
                  <select id="id_dokter" class="form-control select2" name="id_dokter" style="width:100%;">
                    <option value="">-Pilih Pelaksana-</option>
                    <?php 
                    foreach($dokter_tindakan as $row){
                      
                      
                      if($row->id_dokter==$id_dokterrawat){
                        echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'" selected>'.$row->nm_dokter.'</option>';
                      }else{
                        echo '<option value="'.$row->id_dokter.'@'.$row->nm_dokter.'">'.$row->nm_dokter.'</option>';
                      }
                      
                    }
                    
                    ?>
                  </select>
              </div>
            </div>  

            <div class="form-group row mb-4">
						<label class="col-md-2 col-form-label">Pelaksana</label>
						<div class="col-md-6">
							<select class="select2 form-control" name="pelaksana" id="pelaksana" required >
								<option value="" selected>-Pilih Pelaksana-</option>
								<?php foreach($users as $r){
									echo '<option value="'.$r->userid.'-'.$r->username.'">'.$r->name.'</option>';
								} ?>
							</select>
						</div>
					</div>
					
					<div class="form-group row mb-4">
						<label class="col-md-2 col-form-label">Waktu Tindakan</label>
						<div class="col-md-6">
							<div class=' date' id='tgl_tindakan'>
								<input type="datetime-local" id="tgl_tindakan" class="form-control" placeholder="Tanggal Tindakan" name="tgl_tindakan" value="<?php echo date("Y-m-d H:i:s") ?>" required="">
							</div>
						</div>
					</div>
            
            <div class="form-group row mb-4 ">
              <p class="col-sm-2 form-control-label" id="lbl_biaya_poli">Biaya Tindakan</p>
              <div class="col-sm-3">
                <div class="input-group">
                  <span class="input-group-addon">Rp</span>
                  <input type="text" class="form-control" name="biaya_tindakan" id="biaya_tindakan" disabled>
                  <input type="hidden" class="form-control" name="biaya_tindakan_hide" id="biaya_tindakan_hide">
                </div>
              </div>
            </div>

            <div class="form-group row hidden mb-4">
              <p class="col-sm-2 form-control-label">Biaya Alkes</p>
              <div class="col-sm-3">
                <div class="input-group">
                  <span class="input-group-addon">Rp</span>
                  <input type="text" class="form-control" name="biaya_alkes" id="biaya_alkes" disabled>
                  <input type="hidden" class="form-control" name="biaya_alkes_hide" id="biaya_alkes_hide">
                </div>
              </div>
            </div>

            <div class="form-group row mb-4">
              <p class="col-sm-2 form-control-label" id="lbl_qtyind">Qtyind *</p>
              <div class="col-sm-2">
                <input type="number" class="form-control" name="qtyind" id="qtyind" min=1 onchange="set_total(this.value)" required>
              </div>
            </div>
        
            <div class="form-group row hidden mb-4">
              <p class="col-sm-2 form-control-label" id="lbl_vtot">Total</p>
              <div class="col-sm-3">
                <div class="input-group">
                  <span class="input-group-addon">Rp</span>
                  <input type="text" class="form-control" name="vtot" id="vtot" disabled>
                  <input type="hidden" class="form-control" name="vtot_hide" id="vtot_hide">
                </div>
              </div>
            </div>	

              <input type="hidden" class="form-control" value="<?php echo $kelas_pasien;?>" name="id_poli">
              <input type="hidden" class="form-control" value="<?php echo $id_poli;?>" name="id_poli">
              <input type="hidden" class="form-control" value="<?php echo $no_register;?>" name="no_register">
              <input type="hidden" class="form-control" value="<?php echo $cara_bayar;?>" name="cara_bayar" id="cara_bayar">	
            <div class="form-group row">
                <div class="offset-sm-2 col-sm-6">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button type="submit" class="btn btn-primary" id="btn-tindakan">Simpan</button>
                </div>
            </div>		
        </form>
  </div>
</div>


<div class="card m-5">
	<div class="card-body">
      <div class="table-responsive m-t-0">
        <table id="tabel_tindakan" class="display nowrap table table-hover table-bordered table-striped w-100" cellspacing="0">
          <thead>
            <tr>
              <th>No</th>
              <th>Tindakan</th>
              <th>Jenis</th>
              <th>User</th>
              <th>Biaya Tindakan</th>
              <th>Qtyind</th>
              <th>Biaya Alkes</th>
              <th>Total</th>
              <th>TTD</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>	
                
          </tbody>
        </table>
      </div>
  </div>

  
  <div class="card-foother">
        <div class="pull-right">
									<?php //if($unpaid!=''){?>
									<a href="<?php echo site_url('emedrec/C_emedrec/cetak_list_tindakan/'.$no_register); ?>" target="_blank" class="btn btn-danger">Cetak</a>
									<?php //} else {?>
									<!-- <a href="javascript:void(0)" class="btn btn-danger" disabled>Cetak</a> -->
									<?php //}?>
					</div>
  </div>
</div>


 						                    <div class="modal" id="MyModalSurat" tabindex="-1" role="dialog" aria-labelledby="MyModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel1">Data Surat Keterangan </h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="alert-modal-edit"></div>  
                                                <form class="form-horizontal" id="form_add">  
                                                  
                                                  <div class="form-group row">
                                                    <label for="nama" class="col-2 col-form-label">Nama</label>
                                                    <div class="col-10">
                                                      <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" disabled="true" value="<?php echo $data_pasien_daftar_ulang->nama;?>">
                                                    </div>
                                                  </div>  

                                                  <div class="form-group row">
                                                    <label for="tgllhr" class="col-2 col-form-label">Tanggal Lahir</label>
                                                    <div class="col-10">
                                                      <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" disabled="true" value="<?php echo $data_pasien_daftar_ulang->tgl_lahir;?>">
                                                    </div>
                                                  </div> 

                                                  <div class="form-group row">
                                                    <label for="almt" class="col-2 col-form-label">Alamat</label>
                                                    <div class="col-10">
                                                      <input type="text" class="form-control" id="alamat" name="alamat" disabled="true" value="<?php echo $data_pasien_daftar_ulang->alamat;?>">
                                                    </div>
                                                  </div>  
                                                  
                                                  <div class="form-group row">
                                                    <label for="thcc" class="col-2 col-form-label">THC</label>
                                                    <div class="col-10">
                                                      <select id="thc" class="form-control" name="thc" required>
                                                        <option value="negatif">Negatif</option>
                                                        <option value="positif">Positif</option>
                                                      </select>
                                                    </div>
                                                  </div>  
                                                  
                                                  <div class="form-group row">
                                                    <label for="add_nmtindakan" class="col-2 col-form-label">Opiat</label>
                                                    <div class="col-10">
                                                      <select id="opiat" class="form-control" name="opiat" required>
                                                        <option value="negatif">Negatif</option>
                                                        <option value="positif">Positif</option>
                                                      </select>
                                                    </div>
                                                  </div> 

                                                  <div class="form-group row">
                                                    <label for="amph" class="col-2 col-form-label">Amphetamin</label>
                                                    <div class="col-10">
                                                      <select id="amphetamin" class="form-control" name="amphetamin" required>
                                                          <option value="negatif">Negatif</option>
                                                          <option value="positif">Positif</option>
                                                        </select>
                                                    </div>
                                                  </div>  


                                                  <div class="form-group row">
                                                    <label for="thcc" class="col-2 col-form-label">Hasil</label>
                                                    <div class="col-10">
                                                      <select id="hasil" class="form-control" name="hasil" required>
                                                        <option value="negatif">Negatif</option>
                                                        <option value="positif">Positif</option>
                                                      </select>
                                                      </div>
                                                  </div>
                                                  <div class="form-group row">
                                                    <label for="almt" class="col-2 col-form-label">Bulan</label>
                                                    <div class="col-10">
                                                      <input type="text" class="form-control" id="bulan" name="bulan">
                                                    </div>
                                                  </div>
                                                  <div class="form-group row">
                                                    <label for="almt" class="col-2 col-form-label">No. Surat</label>
                                                    <div class="col-10">
                                                      <input type="text" class="form-control" id="nosur" name="nosur">
                                                    </div>
                                                  </div>  

                                                  <div class="form-group row">
                                                    <label for="ket" class="col-3 col-form-label">Keterangan</label>
                                                    <div class="col-12">
                                                      <textarea class="form-control" id="keterangan" name="keterangan" required> </textarea>
                                                    </div>
                                                  </div>           
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>  
                                                <button type="button" class="btn btn-primary" id="submit_add" onclick="insert()"><i class="fa fa-floppy-o"></i>Cetak</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.modal -->

                                <div class="modal" id="MyModalSuratJiwa" tabindex="-1" role="dialog" aria-labelledby="MyModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="exampleModalLabel1">Data Surat Keterangan </h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            </div>
                                            <div class="modal-body">
                                             <div id="alert-modal-edit"></div>  
                                              <form class="form-horizontal" id="form_add">  
                                                
                                                <div class="form-group row">
                                                  <label for="nama" class="col-2 col-form-label">Nama</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" disabled="true" value="<?php echo $data_pasien_daftar_ulang->nama;?>">
                                                  </div>
                                                </div>  

                                                <div class="form-group row">
                                                  <label for="tgllhr" class="col-2 col-form-label">Tanggal Lahir</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir" disabled="true" value="<?php echo $data_pasien_daftar_ulang->tgl_lahir;?>">
                                                  </div>
                                                </div> 

                                                <div class="form-group row">
                                                  <label for="almt" class="col-2 col-form-label">Alamat</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="alamat" name="alamat" disabled="true" value="<?php echo $data_pasien_daftar_ulang->alamat;?>">
                                                  </div>
                                                </div> 

                                                <div class="form-group row">
                                                  <label for="hasil" class="col-2 col-form-label">Hasil</label>
                                                  <div class="col-10">
                                                    <select id="hasil2" class="form-control" name="hasil" required>
                                                      <option value="tidak">Tidak ada</option>
                                                      <option value="ada">ada</option>
                                                    </select>
                                                  </div>
                                                </div>

                                                <div class="form-group row">
                                                  <label for="bulan" class="col-2 col-form-label">Bulan</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="bulan2" name="bulan">
                                                  </div>
                                                </div>

                                                <div class="form-group row">
                                                  <label for="nosur" class="col-2 col-form-label">No. Surat</label>
                                                  <div class="col-10">
                                                    <input type="text" class="form-control" id="nosur2" name="nosur">
                                                  </div>
                                                </div>  

                                                <div class="form-group row">
                                                  <label for="ket" class="col-3 col-form-label">Keterangan</label>
                                                  <div class="col-12">
                                                    <textarea class="form-control" id="keterangan2" name="keterangan" required> </textarea>
                                                  </div>
                                                </div>           
                                              </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" id="submit_add2" onclick="insert2()"><i class="fa fa-floppy-o"></i>Cetak</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.modal -->



<script>

  
function tabeltindakan(no_register){
    table = $('#tabel_tindakan').DataTable({
        ajax: "<?php echo site_url();?>ird/rdcpelayanan/tindakan_pasien/"+no_register,
        columns: [
            { data: "id_pelayanan_poli" },
            { data: "nmtindakan" },
            { data: "tmno" },
            { data: "nm_dokter" },
            { data: "biaya_tindakan" },
            { data: "qtyind" },
            { data: "biaya_alkes" },
            { data: "vtot" },
            { data: "ttd" },
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
  var carabayar="<?php echo $data_pasien_daftar_ulang->cara_bayar;?>"		

  var no_register = "<?php echo $no_register;?>";
  tabeltindakan(no_register);
  $(function(){
    $('#form_add_tindakan_tindakan').submit((e)=>{
        e.preventDefault();
         $.ajax({
	        type: "POST",
	        url: "<?php echo base_url().'ird/rdcpelayanan/insert_tindakan'; ?>",
	        dataType: "JSON",
	        data: $('#form_add_tindakan_tindakan').serialize(),
	        success: function(data){   
			    if (data == true) {
			    	document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
			    	$("#pelaksana").val("").change();
            $("#prop").val("").change();
			    	$("#id_dokter").prop("selected", false).change();
			    	$('#form_add_tindakan_tindakan')[0].reset();
            //$('#pelaksana').reset();
			        tabeltindakan(no_register);
              swal("Sukses", "Tindakan berhasil disimpan.", "success");

			    } else {
			    	document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';
					swal("Error", "Gagal menginput tindakan. Silahkan coba lagi.", "error");	        	
			    }
	        },
	        error:function(event, textStatus, errorThrown) { 
	        	document.getElementById("btn-tindakan").innerHTML = '<i class="fa fa-floppy-o"></i> Simpan';       
	            console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
	        },
	        timeout: 0
	    });
      });

  })
      
</script>