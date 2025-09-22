<?php
    $this->load->view("layout/header_left");

?>
<style>
hr {
	border-color:#7DBE64 !important;
}

</style>	

<script type='text/javascript'>
	$(document).ready(function () {

        $(".js-example-basic-single").select2({
            placeholder: "Select an option"
        });


        var dataTable = $('#dataTables-example').DataTable( {
			
		});
        $('.datatable').DataTable({});
        //$('.datatables').DataTable();	
		$('#tgl').daterangepicker({
          	opens: 'left',
			format: 'DD/MM/YYYY',
			startDate: moment('<?= $tgl_awal ?>'),
          	endDate: moment('<?= $tgl_akhir ?>'),
		});
       
    });



	function download(){
		swal({
		  title: "Download?",
		  text: "Download !",
		  type: "warning",
		  showCancelButton: true,
	  	  showLoaderOnConfirm: false,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Ya!",
		  cancelButtonText: "Tidak!",
		  closeOnConfirm: false,
		  closeOnCancel: false
		},
		function(isConfirm){
		  if (isConfirm) {
			swal("Download", "Sukses", "success");
			window.open("<?php echo base_url('logistik_farmasi/frmclaporan/download_peneriamaan_obat/'.$supplier.'/'.$jenis.'/'.$jenis_obat.'/'.$tgl_awal.'/'.$tgl_akhir)?>");
		  } else {
		    swal("Close", "Tidak Jadi", "error");
			document.getElementById("ok1").checked = false;
		  }
		});
	}	

    function cek_tgl_awal(tgl_awal){
		//var tgl_akhir=document.getElementById("date_picker2").value;
		var tgl_akhir=$('#date_picker2').val();
		if(tgl_akhir==''){
		//none :D just none
		}else if(tgl_akhir<tgl_awal){
			$('#date_picker2').val('');
			//document.getElementById("date_picker2").value = '';
		}
	}
	function cek_tgl_akhir(tgl_akhir){
		//var tgl_awal=document.getElementById("date_picker1").value;
		var tgl_awal=$('#date_picker1').val();
		if(tgl_akhir<tgl_awal){
			$('#date_picker1').val('');
			//document.getElementById("date_picker1").value = '';
		}
	}

    
</script>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header" style="margin:5px">
            <a class="btn btn-primary" style="float: left;margin-right: 10px;" href="<?php echo base_url().'logistik_farmasi/Frmcstok/index' ?>">Kembali</a><br><br><hr>
            <h4>Minimum Stock</h4><hr>
                <form method="post" action="<?= base_url('logistik_farmasi/Frmclaporan/hitung_stock') ?>">

                <div class="form-group row">
                    <p class="col-sm-2 form-control-label" id="lcomment">Nama Obat</p>
                    <div class="col-sm-2">
                    <select id="idobat" class="form-control js-example-basic-single" name="id_obat" width="100%"  onchange="hitung(this.value)">
                        <option value="">-Pilih Obat-</option>
                        <?php
                            foreach($obat as $row){
                                echo '<option value="'.$row->id_obat.'">'.$row->nm_obat.'</option>';
                            }
                        ?>
                    </select>
                            
                    </div>
                </div>

                    <div class="row mb-4">

                     <label class="col-sm-2 control-label">Waktu Tunggu</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="tngg" id="tngg" required="">
                        </div>
                    </div>

                    <div class="row mb-4">

                    <label class="col-sm-2 control-label">Rata Rata Pemakaian</label>
                        <div class="col-sm-2">
                            <input type="text" class="form-control" name="rata" id="rata" required="">
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit">Hitung</button>
               
                </form>
            </div>
        </div>
    </div>
</div>

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
            <!-- <div class="modal-body table-responsive"> -->
            <table class=" datatable table  table-striped">
                  <thead>
                  <tr>
                    <!-- <th>No</th> -->
                    <th style="text-align:center">Nama Obat</th>
                    <th style="text-align:center">Stock</th>
                    <th style="text-align:center">Maksimum Stock</th>
                  </tr>
                  </thead>
                  <tbody>
                     <!-- <th>No</th> -->
                    <th style="text-align:center"><?= $nmobat ?></th>
                    <td style="text-align:center"><?= isset($rumus)?(int)$rumus:'' ?></td>
                    <?php if($id) {?>
                    <td style="text-align:center"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" onclick="hitung_max('<?php echo $id;?>')">Hitung</button></td>
                    <?php }?>
                  </tbody>
                </table>        
            <!-- </div> -->
        </div>
        </div>
    </div>
</div>

            <div class="modal fade" id="editModal"  tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog" role="document">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Hitung Maximum Stock</h4>
                  </div>
                  <?php echo form_open('logistik_farmasi/Frmclaporan/hitung_stock_max'); ?>
                  <div class="modal-body">
                    <div class="form-group row">
                      <!-- <div class="col-sm-1"></div> -->
                      <p class="col-sm-6 form-control-label">Id Obat</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_id_obat" id="edit_id_obat" readonly="">
                      </div>
                    </div> 
                                                            
                    <div class="form-group row">
                      <!-- <div class="col-sm-1"></div> -->
                      <p class="col-sm-6 form-control-label">Nama Obat</p>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="edit_nm_obat" id="edit_nm_obat">
                      </div>
                    </div>

                    <div class="form-group row">
                      <!-- <div class="col-sm-1"></div> -->
                      <p class="col-sm-6 form-control-label" id="lbl_alamat">Smin</p>
                      <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_smin" id="edit_smin">
                      </div>
                    </div>

                    <div class="form-group row">
                      <!-- <div class="col-sm-1"></div> -->
                      <p class="col-sm-6 form-control-label" id="lbl_alamat">Periode Pengadaan</p>
                      <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_pengadaan" id="edit_pengadaan">
                      </div>
                    </div>

                    <div class="form-group row">
                      <!-- <div class="col-sm-1"></div> -->
                      <p class="col-sm-6 form-control-label" id="lbl_alamat">Rata Rata Pemakaian</p>
                      <div class="col-sm-6">
                      <input type="text" class="form-control" name="edit_rata" id="edit_rata">
                      </div>
                    </div>


                   

                  
                  
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit" id="btn-edit">Hitung</button>
                  </div>
                </div>
                <?php echo form_close(); ?>
              </div>
            </div>

<script>
	$(document).ready(function() {

        $(".js-example-basic-single").select2({
            placeholder: "Select an option"
        });


		var dataTable = $('#dataTables-example').DataTable( {
			
		});
    $('.datatable').DataTable({});
	});

    function hitung(id)
    {
        let idobat = $('#idobat').val();
        console.log(idobat);
        $.ajax({
            url: '<?= base_url('logistik_farmasi/frmclaporan/data_min_stock/') ?>'+idobat,
            beforeSend: function() {
            },
            success: function(data) {
               console.log(data)
               $('#tngg').val(data.tgl);
               $('#rata').val(data.rata);
               

            },
            error: function(xhr) { // if error occured
                // $('#obatsubtitusi').empty();
                // let html = '<option>Silahkan Kontak Admin IT</option>';
                // $('#obatsubtitusi').html(html)
            },
            complete: function() {
               
            },
        });    
           
    }

     
  function hitung_max(id_obat) {
    $.ajax({
      type:'POST',
      dataType: 'json',
      url:"<?php echo base_url('logistik_farmasi/Frmclaporan/get_data_max')?>",
      data: {
        id_obat: id_obat
      },
      success: function(data){
        $('#edit_id_obat').val(data.id_obat);
        $('#edit_nm_obat').val(data.nmobat);
        $('#edit_smin').val(data.rumus);
        $('#edit_rata').val(data.rata);
      },
      error: function(){
        alert("error");
      }
    });
  }

</script>
<?php

    $this->load->view("layout/footer_left");

?>
