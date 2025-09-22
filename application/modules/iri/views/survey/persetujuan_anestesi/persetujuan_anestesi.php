<?php 
$this->load->view('layout/header_form');
?>
<?php 
$diag = (isset($persetujuan_tind_kedokteran->row()->formjson)?json_decode($persetujuan_tind_kedokteran->row()->formjson):''); 
// var_dump($diag->question2->{'Row 1'}->isi_informasi);die();


?>
<style>

</style>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->

<div class="card m-5">
    <div class="body">
    <div id="SurveyPersetujuanAnestesi"></div>

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

surveyJSONPersetujuanAnestesi = <?php echo file_get_contents("persetujuan_anestesi.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerPersetujuanAnestesi(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/persetujuan_anestesi/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd ;?>',
                ews_json:JSON.stringify(survey.data),
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


    var survey_persetujuan_anestesi = new Survey.Model(surveyJSONPersetujuanAnestesi);
    
    

    
        survey_persetujuan_anestesi.data = {
        "info_penelitian":
        {"diagnosis":{"Column 1":"<?= isset($diag->question2->{'Row 1'}->isi_informasi)?$diag->question2->{'Row 1'}->isi_informasi:'' ?>",
            "Column 2":["item1"]}},
        
            "mt_bio_pasien1":{"nama":"<?= $data_pasien[0]['nama'] ?>",
               "umur":"<?= $umur ?>",
                "jk":"<?= $data_pasien[0]['sex'] ?>",
                "alamat":"<?= $data_pasien[0]['alamat'] ?>"}}
            
       

	// survey_ews.showNavigationButtons = false;







// survey.css = myCss;
$("#SurveyPersetujuanAnestesi").Survey({
    model: survey_persetujuan_anestesi,
    onComplete: sendDataToServerPersetujuanAnestesi
});
</script>