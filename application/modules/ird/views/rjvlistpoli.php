    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
    ?> 
<html>
<script type='text/javascript'>
var site = "<?php echo site_url();?>";
$(function(){
	$('.auto_search_poli').autocomplete({
		serviceUrl: site+'/irj/rjcautocomplete/data_poli',
		onSelect: function (suggestion) {
			$('#nm_poli').val(''+suggestion.nm_poli+' ('+suggestion.id_poli+')');
			$('#id_poli').val(''+suggestion.id_poli);
		}
	});
});
</script>
	<div class="container-fluid"><br/>
	<div class="row">
	<?php echo form_open('irj/rjcpelayanan/pasien_poli');?>
		<div class="col-lg-12">
			<div class="input-group">
				<select name="poli" id="poli" class="form-control">
					<option value="">Pilih Poli</option>
					<?php foreach($poli as $item){ ?>
						<option value="<?php echo $item->id_poli?>"><?php echo $item->nm_poli ?></option>
					<?php } ?>					
				</select>				
				<!-- <input type="search" class="auto_search_poli form-control" name="nm_poli" id="nm_poli" placeholder="Cari Poli" required>
				<input type="hidden" class="form-control" name="id_poli" id="id_poli" required> -->
				<span class="input-group-btn">
					<button class="btn btn-primary" type="submit">Cari</button>
				</span>
			</div><!-- /input-group -->
		</div><!-- /.col-lg-6 -->
	<?php echo form_close();?>
	</div><!-- /.row --><br/>
	<div class="card">
		<div class="card-block">
			<div style="display:block;overflow:auto;">
				<table class="table table-hover table-striped">
				
			<?php 
						foreach($poliklinik as $row){
					?>
						<tr>
							<td>
								<a href="<?php echo site_url('irj/rjcpelayanan/kunj_pasien_poli/'.$row->id_poli)?>">
									<?php
										echo $row->nm_poli.' ('.$row->id_poli.')';
									if($row->counter>0){
										echo '<span class="label label-danger pull-right">'.$row->counter.'</span>';
									}
									?>
								</a>
							</td>
						</tr>
					<?php
						}
					?>
				</table>
			</div>
		</div>
	</div>
</div>
    <?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 