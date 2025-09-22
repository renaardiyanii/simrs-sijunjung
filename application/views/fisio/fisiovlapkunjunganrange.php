<?php $this->load->view("layout/header_left"); ?>
<?php include('script_laprdkunjungan.php');?>

<?php include('lap_cari.php');	?>
     
<div class="row">
    <div class="col-lg-12">
        <div class="card card-outline-info">
            <div class="card-header">
                <h4 class="m-b-0 text-white" align="center"><?php echo $date_title; ?></h4>
            </div>
            <div class="card-block">				
			<?php if($tampil_per=='TGL'){ 
				include('kunj_tgl.php');
			} else if($tampil_per=='BLN'){ 
				include('kunj_bln.php');
			} else {include('kunj_thn.php');} ?>											
			</div>
		</div>
	</div>
</div>
<?php $this->load->view("layout/footer_left"); ?>
