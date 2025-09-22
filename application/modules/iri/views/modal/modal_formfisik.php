<!-- Modal -->
<?php 
function createForm($name,$label){
    return '
    <div class="form-group row">
        <label for="'.$name.'" class="col-sm-3 col-form-label">'.$label.'</label>									
        <div class="col-md-6 col-sm-6">
            <input name="'.$name.'" id="'.$name.'" type="text" class="form-control" disabled>
        </div>
    </div>
    ';
}

function createTextAreaForm($name,$label,$id_hide=''){
  return '
  <div class="col-sm-6" id="'.$id_hide.'">
			<label class="col-form-label" for="'.$name.'">'.$label.'</label><br>
			<textarea rows="5" cols="60" name="'.$name.'" id="'.$name.'_assesment" disabled></textarea>
		</div>
  ';
}

?>
<!-- modal assesment dokter -->


<!-- modal pemeriksaan_fisik -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detail Pemeriksaan Fisik</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col">
                <?= createForm('td_','Tekanan Darah'); ?>
                <?= createForm('bb_','Berat Badan'); ?>
                <?= createForm('nadi_','Nadi'); ?>
                <?= createForm('frek_nafas_','Frekuensi Nafas'); ?>
                <?= createForm('gcs_','GCS'); ?>
            </div>
            <div class="col">
                <?= createForm('suhu_','Suhu'); ?>
                <?= createForm('lingkar_kepala_','Lingkar Kepala'); ?>
                <?= createForm('kead_umum_','Keadaan Umum'); ?>
                <?= createForm('kesadaran_pasien_','Kesadaran Pasien'); ?>
            </div>
        </div>
        <?= createTextAreaForm('kel_umum_','Keluhan'); ?>

               
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script>
// Restricts input for the given textbox to the given inputFilter.
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

$(document).ready(function(){

    const validation = ['sitolic_id','text_diatolic','nadi','frekuensi_nafas','lingkar_kepala','e','m','v'];

    for(let item of validation){
      setInputFilter(document.getElementById(item), function(value) {
      return /^-?\d*$/.test(value); });
    }

   



    $('.dataparsing').on('click',function(){
      console.log('testing');
      // alert('hello wolrd');
        var value = $(this).data('value');
        console.log(value);
     
    });

});
</script>