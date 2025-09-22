<?php 
$this->load->view('layout/header_form');
?>

<?php
$endTransfer = isset($transfer_ruangan[0]->formjson)?($transfer_ruangan[0]->formjson!=""?json_decode($transfer_ruangan[0]->formjson):null):null;
if (isset($endTransfer->question7) != null && isset($endTransfer->question8) != null){
    $data_edit = null;
} else {
    $data_edit = isset($transfer_ruangan[0]->formjson)?$transfer_ruangan[0]->formjson:null;
}
//var_dump($data_edit); die();
?>

<style>
.container-cover{
    background-color:transparent;
}
</style>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> -->
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" /> -->
<!-- <script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->

<div class="card m-5">
    <div class="body">
    <div id="surveyTransferRuangan"></div>

    </div>
</div>

<div class="card m-5">
    <div class="body">
    <div>
	<table class="table table-hover table-striped table-bordered data-table" id="datatablecppt" style="width:100%;" style="table-layout: fixed;">
		<thead>
            <tr>
                <th>No.</th>
                <th>Tgl Input</th>
                <th>Dokter Pengirim</th>
                <th>Dokter Penerima</th>
                <th>Perawat Penerima</th>
            </tr>
		</thead>
		<tbody>
            <?php
            $i = 1;
            foreach($transfer_ruangan as $val){
                $values = ($val->formjson!="" || $val->formjson!=null)?json_decode($val->formjson):null;
            ?>
			<tr>
                <td><?= $i; ?></td>
                <td><?= isset($values->tgl_pindah)?date('d-m-Y',strtotime($values->tgl_pindah)):''; ?></td>
                <td><?= $values->dokter_yang_merawat??""; ?></td>
                <td><?= $values->question7??""; ?></td>
                <td><?= $values->question8??""; ?></td>
            </tr>
            <?php 
        $i++;
        } ?>
		</tbody>
	</table>
</div>

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

Survey.CustomWidgetCollection.Instance.addCustomWidget(widget, "type");

Survey.StylesManager.applyTheme("modern");

var surveyJsonTransferRuangan = <?php echo file_get_contents("transfer_ruangan.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToTransferRuangan(survey) {
    $.ajax({
        type: "POST",
        url: '<?= base_url('iri/rictindakan/transfer_ruangan/') ?>',
        data: {
            no_register : '<?php echo $no_ipd ?>',
            <?php 
            if($data_edit){
                ?>
                id: '<?= $transfer_ruangan[0]->id ?>',
            <?php } ?>
            formjson:JSON.stringify(survey.data),
        },
        success: function(data)
        {
             location.reload();
        },
        error: function(data)
        {
            
        }
    }); 
    
}

var surveyTransferRuangan = new Survey.Model(surveyJsonTransferRuangan);
<?php 
 if($data_edit){
?>
 surveyTransferRuangan.data =  <?php echo $data_edit ?>;
 // surveyTransferRuangan.data = <?php // echo $transfer_ruangan->formjson ?>;
<?php } ?>

// survey.css = myCss;
$("#surveyTransferRuangan").Survey({
    model: surveyTransferRuangan,
    onComplete: sendDataToTransferRuangan
});
</script>