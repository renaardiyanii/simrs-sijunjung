    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 


    <?php
	$this->load->view('layout/header_left.php');
?>
<script type='text/javascript'>
	function selesai_pengambilan(no_resep) {
	var r = confirm("Anda Yakin Resep Telah Selesai?");
	if (r == true) {
	   $.ajax({
			type:'POST',
			dataType: 'json',
			url:"<?php echo base_url('farmasi/Frmcdaftar/selesai_pengambilan')?>",
			data: {
				no_resep: no_resep
			},
			success: function(data){
				//alert(data);
				location.reload();
			},
			error: function(){
				alert("error");
			}
	    });
	   return true;
	} else {
	    return false;
	}
}
var site = "<?php echo site_url();?>";
	//-----------------------------------------------Data Table
	$(document).ready(function() {
	    var objTable;

        objTable = $('#example2').DataTable( {
            ajax: "<?php echo site_url('farmasi/frmcdaftar/get_list_pengambilan'); ?>",
            columns: [
                { data: "no" },
                { data: "tgl_kunjungan" },
                { data: "no_cm" },
                { data: "no_register" },
                { data: "nama" },
                { data: "kelas" },
                { data: "idrg" },
                { data: "bed" },
                { data: "cara_bayar" },
                { data: "aksi" }
            ],
            columnDefs: [
                { targets: [ 0 ], visible: true }
            ] ,
            searching: true,
            paging: true,
            bDestroy : true,
            bSort : false,
            lengthMenu: [[50, 75, 100, -1], [50, 75, 100, "All"]]
        } );

        $("#find_by_date").click(function () {
            var tgl = $("#date_picker").val();

            $.ajax({
                dataType: "json",
                type: 'POST',
                data: { tgl: tgl },
                url: "<?php echo site_url('farmasi/frmcdaftar/get_list_pengambilan'); ?>",
                success: function( response ) {
                    objTable.clear().draw();
                    objTable.rows.add(response.data);
                    objTable.columns.adjust().draw();
                }
            });
        });
    
	//---------------------------------------------------------

	$(function() {
		$('#date_picker').datepicker({
			format: "yyyy-mm-dd",
			endDate: '0',
			autoclose: true,
			todayHighlight: true
		});  
			
	});
	});
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
				<h3 align="center">DAFTAR LIST PENGAMBILAN RESEP PASIEN</h3>
			</div>
			<div class="card-block">
				<div class="row p-t-0">
					<div class="col-md-4">
						<div class="form-group">
							<div class="input-group">
								<input type="text" id="date_picker" class="form-control" placeholder="Tanggal Kunjungan" name="date" required>
								<span class="input-group-btn">
									<button class="btn btn-primary" type="submit" id="find_by_date">Cari</button>
								</span>
							</div><!-- /input-group -->
						</div><!-- /.col-lg-6 -->
					</div>
				</div>
			</div>
			<div class="card-block">
			<div class="table-responsive m-t-0">				
				<table id="example2" class="display nowrap table table-hover table-bordered table-striped" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal Kunjungan</th>
							<th>No RM</th>
							<th>No Registrasi</th>
							<th>Nama</th>
							<th>Kelas</th>
							<th>Ruangan</th>
							<th>Bed</th>
							<th>Cara Bayar</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						/*$i=1;
						foreach($farmasi as $row){
						$no_register=$row->no_register;*/
						?>
						<!--<tr>
							<td><?php /*echo $i++;*/?></td>
							<td><?php /*echo date('d-m-Y | H:i',strtotime($row->tgl_kunjungan));*/?></td>
							<td><?php /*echo $row->no_cm;*/?></td>
							<td><?php /*echo $row->no_register;*/?></td>
							<td><?php /*echo $row->nama;*/?></td>
							<td><?php /*echo $row->kelas;*/?></td>
							<td><?php /*echo $row->idrg;*/?></td>
							<td><?php /*echo $row->bed;*/?></td>
							<td><?php /*echo $row->cara_bayar;*/?></td>
							<td>
				                <a href="<?php /*echo site_url('farmasi/Frmcdaftar/permintaan_obat/'.$no_register); */?>" class="btn btn-primary btn-sm">Resep</a>
				                <?php /*$getrdrj=substr($no_register, 0,2);
				                if($getrdrj=='RJ'){*/?>
				                	<a href="<?php /*echo site_url('farmasi/Frmcdaftar/force_selesai/'.$no_register); */?>" class="btn btn-danger btn-sm">Selesai</a>
				                <?php /*} */?>
							</td>
						</tr>-->
						<?php
						//}
						?>
					</tbody>
				</table>						
			</div>
			</div>
		</div>
	</div>
</div>
<?php
	$this->load->view('layout/footer_left.php');
?>