<?php
if ($role_id == 1) {
    $this->load->view("layout/header_left");
} else {
    $this->load->view("layout/header_horizontal");
}
?>
<style>
    hr {
        border-color:#7DBE64 !important;
    }

    thead {
        background: #c4e8b6 !important;
        color:#4B5F43 !important;
        background: -moz-linear-gradient(top,  #c4e8b6 0%, #7DBE64 100%) !important;
        background: -webkit-linear-gradient(top,  #c4e8b6 0%,#7DBE64 100%) !important;
        background: linear-gradient(to bottom,  #c4e8b6 0%,#7DBE64 100%) !important;
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#c4e8b6', endColorstr='#7DBE64',GradientType=0 )!important;
    }
</style>
<style type="text/css">
    .table-wrapper-scroll-y {
        display: block;
        max-height: 350px;
        overflow-y: auto;
        -ms-overflow-style: -ms-autohiding-scrollbar;
    }
    input:focus::-webkit-input-placeholder { color:transparent; }
    input:focus:-moz-placeholder { color:transparent; } /* FF 4-18 */
    input:focus::-moz-placeholder { color:transparent; } /* FF 19+ */
    input:focus:-ms-input-placeholder { color:transparent; } /* IE 10+ */
    ::-webkit-input-placeholder {
        font-style: italic;
    }
    :-moz-placeholder {
       font-style: italic;  
    }
    ::-moz-placeholder {
       font-style: italic;  
    }
    :-ms-input-placeholder {  
       font-style: italic; 
    }
    .demo-radio-button label{
        min-width:120px;
    }
    .ui-state-highlight, .ui-widget-content .ui-state-highlight, .ui-widget-header .ui-state-highlight {
        border: 1px solid #dad55e;
        background: #fffa90;
        color: #777620;
        font-weight: normal;
    }
    .ui-widget-content {    
        font-size: 15px;
    }
    .ui-widget-content .ui-state-active {    
        font-size: 15px;
    }
    .ui-autocomplete-loading {
        background: white url("<?php echo site_url('assets/plugins/jquery/ui-anim_basic_16x16.gif'); ?>") right 10px center no-repeat;
    }   
    .ui-autocomplete { 
        max-height: 270px; overflow-y: scroll; overflow-x: scroll;
    }
</style>	

<script type='text/javascript'>
	$(document).ready(function () {	
		$('#tanggal_laporan').daterangepicker({
          	opens: 'left',
			format: 'DD/MM/YYYY',
			startDate: moment(),
          	endDate: moment(),
		});

		$('#cari_obat').autocomplete({
            serviceUrl: '<?php echo site_url();?>logistik_farmasi/Frmcpo/cari_data_obat',
            onSelect: function (suggestion) {
                $('#cari_obat').val('' + suggestion.nama);
                $("#id_obat").val(suggestion.idobat);
                $('#batch').val(suggestion.batch_no);
            }
        });
    });

	$(document).ready(function() {
    $('#example').DataTable();
    $('.select_obat').select2();

      });
    
	function download(){	
		var startDate = $('#tanggal_laporan').data('daterangepicker').startDate;
		var endDate = $('#tanggal_laporan').data('daterangepicker').endDate;
		startDate = startDate.format('YYYY-MM-DD');
		endDate = endDate.format('YYYY-MM-DD');
        var filter = $("#filter").val();
        var obat = $("#id_obat").val();
        var batch = $("#batch").val();
		
		swal({
		  title: "Download?",
		  text: "Download Kartu Obat?",
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
			window.open("<?php echo base_url('logistik_farmasi/Frmckartu_stock/download_kartu')?>/"+startDate+"/"+endDate);
		  } else {
		    swal("Close", "Tidak Jadi", "error");
			document.getElementById("ok1").checked = false;
		  }
		});
		
		
	}

    
    function buatajax(){
        if (window.XMLHttpRequest){
        return new XMLHttpRequest();
        }
        if (window.ActiveXObject){
        return new ActiveXObject("Microsoft.XMLHTTP");
        }
        return null;
    }

    function ajaxdokter(id_poli){
        var id = id_poli.substr(0,4);
        var pokpoli = id_poli.substr(4,4);

        ajaxku = buatajax();
        var url="<?php echo site_url('iri/rictindakan/data_dokter_poli'); ?>";
        url=url+"/"+id;
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
                document.getElementById("data_obat").innerHTML = data;
            }
        }
    }	
    
</script>
 <div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <?php echo form_open('logistik_farmasi/frmckartu_stock');?>
                <form class="form-material m-t-40 row">
                    <div class="form-group col-md-4 m-t-10">
                        <label>Filter Gudang</label>
                    </div>
                    <div class="form-group col-md-8 m-t-10">
                        <select name="filter" id="filter" class="form-control" style="width:100%">
		                    <?php
                            	foreach ($gudang as $row) {
                                    echo '<option value="' . $row->id_gudang . '">' . $row->nama_gudang . '</option>';
                                }
                            ?>
		                </select>
                    </div>

                    <div class="col-sm-8">
                        <div class="form-inline">
                            <select id="data_obat" class="form-control select_obat" style="width: 100%" name="id_obat" required>
                                <option value="">-- Pilih Obat --</option>
                                <?php 
                                foreach($obat as $row){
                                    echo '<option value="'.$row->id_obat.'">'.$row->nm_obat.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group col-md-10 m-t-10">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>&nbsp;&nbsp;
                            <input type="text" class="form-control pull-right" id="tanggal_laporan" name="tanggal_laporan">
                        </div>
                    </div>
                    <div class="form-group col-md-2 m-t-10">
                        <!-- <span class="input-group-btn"> -->
                            <div>
                            <button class="btn btn-primary" type="submit">Lihat</button>
                           
                            <!-- <button class="btn btn-primary pull-right" type="button" onclick="download()">Download</button> -->
                        </div>
                        <!-- </span> -->
                    </div>
                </form>
                <?php echo form_close();?>
            </div>     
            <div class="">
                        <div style="display:block;overflow:auto;">
                            <?php 
                            if ($data_stok != 0){
                                $vtottotal=0;
                            ?>
                 
                                    <br />
                            <?php } else {
                                echo "<div class=\"content-header\">
                                            <div class=\"alert alert-danger alert-dismissable\">
                                                <button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\">×</button>              
                                            <h4><i class=\"icon fa fa-close\"></i>
                                                Tidak Ditemukan Data
                                            </h4>                           
                                            </div>
                                        </div>";
                            }
                            ?> 

                            </div>
                        </div>  
                        <div class="table-responsive col-sm-12">
                    <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                                <th><b>No</b></th>
                                                <th><b>Tanggal</b></th>
                                                <th><b>Nama Obat</b></th>
                                                <th><b>Batch</b></th>
                                                <th><b>Expire Date</b></th>  
                                                <th><b>Keterangan</b></th>
                                                <th><b>Stokawal</b></th>
                                                <th><b>Stok Masuk</b></th>
                                                <th><b>Stok Keluar</b></th>
                                                <th><b>Stok Akhir</b></th> 
                                                <!-- <th><b>Harga Beli</b></th>  -->
                                                <th><b>User</b></th>   
                                                 
                            
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i=1;
                                            //$vtot=0;
                                            foreach($data_stok as $row2){
                                            //$vtot+=$row2->vtot;
                                             ?>  
                                             <tr>
                                                <td><?php echo $i++;?></td>
                                                <td><?php echo $row2->tanggal;?></td>
                                                <td><?php echo $row2->nm_obat;?></td>
                                                <td><?php echo $row2->batch_no;?></td>
                                                <td><?php echo isset($row2->expire_date)?date('d-m-Y',strtotime($row2->expire_date)):'';?></td>
                                                <td>
                                                    <?php echo $row2->keterangan;?><br>
                                                    <?php 
                                                    if($row2->keterangan == 'Penerimaan Obat'){
                                                        echo isset($row2->pbf)?'('.$row2->pbf.')':'';
                                                    }else if($row2->keterangan == 'Distribusi Masuk' || $row2->keterangan == 'Distribusi Keluar' || $row2->keterangan == 'Pengurangan Distribusi Langsung' || $row2->keterangan == 'Penambahan Distribusi Langsung' ){
                                                        echo isset($row2->gd)?'('.$row2->gd.')':'';
                                                    }else if($row2->keterangan == 'Transaksi Penjualan'){
                                                        echo isset($row2->nama_pasien)?'('.$row2->nama_pasien.')':'';
                                                    }
                                                    
                                                    ?>
                                                
                                                </td>
                                                <td><?php echo $row2->stok_awal;?></td>   
                                                <td><?php echo $row2->masuk;?></td>
                                                <td><?php echo $row2->keluar;?></td>
                                                <td><?php echo $row2->stok_akhir;?></td>
                                                <!-- <td><?php //echo $row2->hargabeli;?></td> -->
                                                <td><?php echo $row2->created_by;?></td>       
                                            </tr>
                                            <?php
                                            }
                                            ?>    
                                        </tbody>
                                    </table>  
                            </div>     
                            <a href="<?php echo site_url('logistik_farmasi/frmckartu_stock/download_kartu_stock/'.$id_gudang.'/'.$id_obat.'/'.$tanggal1.'/'.$tanggal2);?>">
                        <input type="button" class="btn" style="background-color: lime;color:white;margin:5px" value="EXCEL"></a>
           
        </div>
       
    </div>
</div>
<?php $this->load->view("layout/footer_left"); ?>
