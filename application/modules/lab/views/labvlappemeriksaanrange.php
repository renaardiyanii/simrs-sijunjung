<?php 
    if ($role_id == 1) {
        $this->load->view("layout/header_left");
    } else {
        $this->load->view("layout/header_horizontal");
    }
?> 
<script type="text/javascript">
$(document).ready(function() {
    // $('.date_day_pickers').datepicker({
    //     format: "yyyy-mm-dd",
    //     autoclose: true,
    //     todayHighlight: true,
    //     minDate: '0'
    // });

    tablelaprange('','');

	var v00 = $("#formsearchlaprange").validate({
      rules: {
        tglawal: {
          required: true
        },
        tglakhir: {
          required: true
        }
      },
    highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass('has-success').addClass('has-error'); // set error class to the control group
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    $(element)
                        .closest('.form-group').removeClass('has-error'); // set error class to the control group
                },
     errorElement: "span",
     errorClass: "help-block help-block-error",
     submitHandler: function(form) {
     		var tgl_awal = document.getElementById('tglawal').value;
     		var tgl_akhir = document.getElementById('tglakhir').value;
            tablelaprange(tgl_awal,tgl_akhir);
        }
    });

});

function tablelaprange(date0,date1){
	var url = "<?php echo site_url();?>lab/Labclaporan/showlap_pemeriksaan/";
	if(date0!='' && date1!=''){
		url = url+date0+"/"+date1;	
	}
	table = $('#laplab').DataTable({
        ajax: url,
        columns: [
            { data: "idtindakan" },
            { data: "nmtindakan" },
            { data: "banyak" }
        ],
        columnDefs: [
            { targets: [ 0 ], visible: false }
        ],
        bFilter: true,
        bPaginate: true,
        destroy: true,
        order:  [[ 2, "asc" ],[ 1, "asc" ]]/*,
        drawCallback: function ( data ) {
                //Make your callback here.
                console.log(data.aoData);
                alert(data);
                return data;
            }*/               
    	});	
}

function down_excel(){
	var date0 = document.getElementById('tglawal').value;
    var date1 = document.getElementById('tglakhir').value;
    if(date0=='' && date1==''){
		window.open('<?php echo site_url('lab/Labclaporan/excel_lappemeriksaan');?>/', '_blank'); 
    }else{    	
    	window.open('<?php echo site_url('lab/Labclaporan/excel_lappemeriksaan');?>/'+date0+"/"+date1, '_blank');    
    }
}

</script>
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

<section class="content-header">
	<div class="row">
	<div class="form-group">
		<form class="form-horizontal" method="POST" id="formsearchlaprange">
            <div class="col-sm-12" >
                <div class="form-group row">
					<div>
                    <input type="date" id="tglawal" class="form-control date_day_pickers" placeholder="Tanggal Awal" name="date0" required>&nbsp;
                    </div>
                    <div >											
                    
                    <input type="date" id="tglakhir" class="form-control date_day_pickers" placeholder="Tanggal Akhir" name="date1" required>
					</div>
					<div>
                            <button class="btn btn-primary" type="submit">Cari</button>
					</div>
				</div>                                
            </div>                              
        </form>
	</div>				
</div>

</section>
              
<section class="content">
	<div class="row">
		<div class="card card-block" style="width:97%;margin:0 auto">
			<div class="card-title"> Laporan Pemeriksaan Laboratorium
			</div>
			<div class="">				
				<table id="laplab" class="display" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Tindakan</th>
							<th>Banyak</th>
						</tr>
					</thead>
					<tbody>						
					</tbody>
				</table>		
					</div><!--- end panel body -->
					<br>
					<div class="col-lg-6">
						<button type="button" class="btn btn-danger" onClick="down_excel()">Excel</button>
					</div>					
					<br><br><br>
				</div><!-- end panel -->
				
			</div><!-- end row -->
		</section>
<?php $this->load->view("layout/footer_left"); ?>
