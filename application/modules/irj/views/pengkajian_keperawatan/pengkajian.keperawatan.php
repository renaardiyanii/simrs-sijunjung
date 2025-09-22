<?php 
$this->load->view('layout/header_form');
// var_dump($data_keperawatan)
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="SurveyPengkajianKeperawatan"></div>

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

surveyJSONpengkajiankeperawatan = <?php echo file_get_contents("assesment_keperawatan.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerPengkajianKeperawatan(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('irj/rjcpelayanan/pengkajian_rawat_jalan/') ?>',
            data: {
                no_register : '<?php echo $no_register;?>',
                pengkajian_keperawatan_json:JSON.stringify(survey.data),
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


    var survey_pengkajian_keperawatan = new Survey.Model(surveyJSONpengkajiankeperawatan);

    
    <?php if($data_keperawatan){ ?>
		survey_pengkajian_keperawatan.data = <?= isset($data_keperawatan->formjson)?$data_keperawatan->formjson:''; ?>
	<?php }else{ ?>
        survey_pengkajian_keperawatan.data = {"tanda_vital":{
            "td":"<?= isset($data_fisik->sitolic)?$data_fisik->sitolic.'/'.$data_fisik->sitolic:'' ?>",
            "nadi":"<?= isset($data_fisik->nadi)?$data_fisik->nadi:'' ?>",
            "suhu":"<?= isset($data_fisik->suhu)?$data_fisik->suhu:'' ?>",
            "pernafasan":"<?= isset($data_fisik->frekuensi_nafas)?$data_fisik->frekuensi_nafas:'' ?>"},
            "nutrisi":{
            "berat_badan":"<?= isset($data_fisik->bb)?$data_fisik->bb:'' ?>"}}
        <?php } ?>

// survey.css = myCss;
$("#SurveyPengkajianKeperawatan").Survey({
    model: survey_pengkajian_keperawatan,
    onComplete: sendDataToServerPengkajianKeperawatan
});
</script>