<?php 
$this->load->view('layout/header_form');
// var_dump($tindakan_hemodialisa);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="LembarKonsul"></div>

    </div>
</div>


<script>
    var widget = {
    name: "emptyRadio",
    isFit : function(question) {  
        return question.getType() === 'radiogroup'; 
    },
    isDefaultRender: true,
    afterRender: function(question, el) {
      var $el = $(el);
      $el.find("input:radio").click(function(event){
           var UnCheck = "UnCheck",
                  $clickedbox = $(this),
                  radioname = $clickedbox.prop("name"),
                  $group = $('input[name|="'+ radioname + '"]'),
                  doUncheck = $clickedbox.hasClass(UnCheck),
                  isChecked = $clickedbox.is(':checked');
              if(doUncheck){
                  $group.removeClass(UnCheck);
                  $clickedbox.prop('checked', false);
                  question.value = null;
              }
              else if(isChecked){
                  $group.removeClass(UnCheck);
                  $clickedbox.addClass(UnCheck);
              }
      });    
    },
    willUnmount: function(question, el) {
    }
};

// function openModal(data){
// 	var value = data;
		
//         const data_json = JSON.parse(value.formjson);
//         // console.log(data_json.penderita.penderita1);
	
// 		$("#penderita").val(data_json.penderita?.penderita1 ?? "");
// 		$("#diag_kerja").val(data_json.penderita?.diagnosis ?? "");
//         $("#ikhtisar").val(data_json.ikhtisar ?? "");
//         $("#kesimpulan").val(data_json.kesimpulan ?? "");
//         $("#konsul_diminta").val(data_json.konsul ?? "");

//         $("#no_ipd").val(data.no_ipd);
//         $("#id_konsul").val(data.id);

//         $("#penemuan").val(data.penemuan);
//         $("#kesimpulan_jawaban").val(data.kesimpulan);
//         $("#anjuran").val(data.anjuran);
//         $("#tgl_jawaban").val(data.tgl_jawaban);

		
// 	    $('#exampleKonsultasijawaban').modal('show');
	

// }
function openModal(elOrObj) {
    // support dipanggil openModal(this) atau openModal(obj)
    let data;
    if (elOrObj && elOrObj.dataset && elOrObj.dataset.json) {
        try {
            data = JSON.parse(elOrObj.dataset.json);
        } catch (e) {
            console.error("Gagal parse data-json:", e, elOrObj.dataset.json);
            data = {};
        }
    } else {
        data = elOrObj || {};
    }

    // parse formjson (karena val.formjson adalah string JSON di dalam JSON)
    let data_json = {};
    if (data.formjson) {
        try {
            data_json = JSON.parse(data.formjson);
        } catch (e) {
            console.warn("formjson tidak valid, gunakan {} sebagai fallback", e);
            data_json = {};
        }
    }

    // Isi field (gunakan fallback supaya ga error)
    $("#penderita").val(data_json.penderita?.penderita1 ?? "");
    $("#diag_kerja").val(data_json.penderita?.diagnosis ?? "");
    $("#ikhtisar").val(data_json.ikhtisar ?? "");
    $("#kesimpulan").val(data_json.kesimpulan ?? "");
    $("#konsul_diminta").val(data_json.konsul ?? "");

    $("#no_ipd").val(data.no_ipd ?? "");
    $("#id_konsul").val(data.id ?? "");

    $("#penemuan").val(data.penemuan ?? "");
    $("#kesimpulan_jawaban").val(data.kesimpulan ?? "");
    $("#anjuran").val(data.anjuran ?? "");
    $("#tgl_jawaban").val(data.tgl_jawaban ?? "");

    $('#exampleKonsultasijawaban').modal('show');
}







Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");

Survey.StylesManager.applyTheme("modern");

Survey.CustomWidgetCollection.Instance.setActivatedBy("select2", "type");

lembar_konsul = <?php echo file_get_contents("lembar_konsul.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerlembar_konsul(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_lembar_konsultasi_ri/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                konsul:JSON.stringify(survey.data),
                tgl_konsul:JSON.stringify(survey.data.tanggal),
                tgl_jawaban:JSON.stringify(survey.data.question5),
                dokter_konsul:JSON.stringify(survey.data.yth),
            },
            success: function(data)
            {
            
                 location.reload();
                

            },
            error: function(data)
            {
                
            }
        }); 
            //  console.log(JSON.stringify(survey.data));
        
        }


    var lembar_konsultasi = new Survey.Model(lembar_konsul);



    
    

// survey.css = myCss;
$("#LembarKonsul").Survey({
    model: lembar_konsultasi,
    onComplete: sendDataToServerlembar_konsul
});
</script>

<div class="card m-5">
        <div class="card-header">
            <h5>Riwayat Konsultasi</h5>
        </div>
        <div class="card-body">
            
            <table class="table table-hover table-striped table-bordered datatable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tgl Konsultasi</th>
                        <th>Tgl Jawaban</th>
                        <th>Dokter</th>
                        <th>Dokter Konsultasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $i=1;
                    foreach($histo_konsultasi as $val){ ?>
                    <tr>
                        <td><?= $i++ ?></td>
                        <td><?= isset($val->tgl_konsul)?date('d-m-Y',strtotime($val->tgl_konsul)):'' ?></td>
                        <td><?= isset($val->tgl_jawaban)?date('d-m-Y',strtotime($val->tgl_jawaban)):'-' ?></td>
                        <td><?= isset($val->dokter_dpjp)?$val->dokter:'' ?></td>
                        <td><?= isset($val->dokter_konsul)?$val->dokter_konsulen:'' ?></td>
                        <td>
                            <button type="button" class="btn btn-primary"
                                    data-json='<?= htmlspecialchars(json_encode($val), ENT_QUOTES, 'UTF-8'); ?>'
                                    onclick="openModal(this)">
                                Jawab Konsul
                            </button>
                            </td>

                        </tr>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="exampleKonsultasijawaban" tabindex="-1" role="dialog" aria-labelledby="exampleKonsultasiLabeljawaban" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Lembar Konsultasi</h5>
        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">

            <div class="form-group row" >
				<label class="col-sm-2 control-label col-form-label">Penderita Kami rawat dengan</label>
				<div class="col-sm-8">
					<div class="form-inline">
						<input type="text" id="penderita" class="form-control"  name="penderita" readonly>
					</div>
				</div>
	 		</div>

             <div class="form-group row" >
				<label class="col-sm-2 control-label col-form-label">Diagnosis Kerja</label>
				<div class="col-sm-8">
					<div class="form-inline">
						<input type="text" id="diag_kerja" class="form-control"  name="diag_kerja" readonly>
					</div>
				</div>
	 		</div>

             <div class="form-group row mb-4">
                <label for="ikhtisar" class="col-2 col-form-label">Ikhtisar Klinis</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <textarea name="ikhtisar" id="ikhtisar" class="form-control" style="height: 100px" readonly></textarea>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-4">
                <label for="kesimpulan" class="col-2 col-form-label">Kesimpulan</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <textarea name="kesimpulan" id="kesimpulan" class="form-control" style="height: 100px" readonly></textarea>
                    </div>
                </div>
            </div>

            <div class="form-group row mb-4">
                <label for="konsul_diminta" class="col-2 col-form-label">Konsul Yang Diminta</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <textarea name="konsul_diminta" id="konsul_diminta" class="form-control" style="height: 100px" readonly ></textarea>
                    </div>
                </div>
            </div>

            <hr>

            <h5 class="modal-title" id="exampleModalLabel">Jawaban Konsultasi</h5>
            <form method="POST" id="form_jawab_konsul" class="form-horizontal">
                <div class="form-group row mb-4" >
                    <label class="col-sm-2 control-label col-form-label">Tanggal Jawab</label>
                    <div class="col-sm-8">
                        <div class="form-inline">
                            <input type="date" id="tgl_jawaban" class="form-control"  name="tgl_jawaban" required>
                            <input type="hidden" id="no_ipd" class="form-control"  name="no_ipd">
                            <input type="hidden" id="id_konsul" class="form-control"  name="id_konsul">
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label for="penemuan" class="col-2 col-form-label">Penemuan</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <textarea name="penemuan" id="penemuan" class="form-control" style="height: 100px" ></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label for="kesimpulan" class="col-2 col-form-label">Kesimpulan</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <textarea name="kesimpulan" id="kesimpulan_jawaban" class="form-control" style="height: 100px" ></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <label for="anjuran" class="col-2 col-form-label">Anjuran</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <textarea name="anjuran" id="anjuran" class="form-control" style="height: 100px" ></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 control-label col-form-label" id="dokter">Catatan</label>
                    <div class="col-sm-8">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="catatan" id="inlineRadio1" value="Kami Setuju">
                            <label class="form-check-label" for="inlineRadio1">Kami Setuju</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="catatan" id="inlineRadio2" value="Tidak Setuju Pindah Rawat">
                            <label class="form-check-label" for="inlineRadio2">Tidak Setuju Pindah Rawat</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="catatan" id="inlineRadio3" value="Rawat Bersama">
                            <label class="form-check-label" for="inlineRadio3">Rawat Bersama</label>
                        </div>
                    </div>
                </div>
			
			
      </div>
      <div class="modal-footer">
            <button type="submit" class="btn btn-primary" id="btn-form-jawab-konsul-insert">Simpan</button>
	        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
      </div>

      </form>
    </div>
  </div>
</div> 

<?php 
function textareaModel($name,$title){
	return '<div class="form-group row mb-4">
		<label for="'.$name.'" class="col-2 col-form-label">'.$title.'</label>
		<div class="col-sm-8">
			<div class="input-group">
				<textarea name="'.$name.'" id="'.$name.'_modal" class="form-control" style="height: 100px" ></textarea>
			</div>
		</div>
	</div>';
}

?>

<script>
$(document).on("submit","#form_jawab_konsul",function(e){
		e.preventDefault();

		$.ajax({  
			url:"<?php echo base_url(); ?>iri/rictindakan/insert_jawaban_konsul_sjj",                         
			method:"POST",  
			data: new FormData(this),  
			contentType: false,  
			cache: false,  
			processData:false,  
			success: function(data)  
			{ 
			
			    window.location.reload();
				
			},
			error:function(event, textStatus, errorThrown) {
				new swal("Error","Data gagal disimpan.", "error"); 
				console.log('Error Message: '+ textStatus + ' , HTTP Error: '+errorThrown);
			}  
		});

	});

</script>