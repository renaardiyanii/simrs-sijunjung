<?php 
$this->load->view('layout/header_form');
?>
<style>

</style>
<link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" />
<script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script>


<div class="card m-5">
    <div class="body">
    <div id="surveySkriningCovid"></div>

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

var surveyJsonSkriningCovid = <?php echo file_get_contents(__DIR__ ."/form/skrining_covid.json");?>;

function sendDataToSkriningCovid(survey) {
    // send Ajax request to your web server.
    // alert("The results are:" + JSON.stringify(survey.data));
    $.ajax({
        type: "POST",
        url: '<?= base_url('ird/rdcpelayanan/skrining_covid/') ?>',
        data: {
            no_register : '<?= $data_pasien_daftar_ulang->no_register ?>',
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

var surveySkriningCovid = new Survey.Model(surveyJsonSkriningCovid);

<?php 
if($skrining_covid!=null){
?>
surveySkriningCovid.data = <?php echo $skrining_covid->formjson ?>
<?php 
}else{
?>
surveySkriningCovid.data = {"identitas":{"alamat":"<?= isset($data_pasien_daftar_ulang->alamat)?$data_pasien_daftar_ulang->alamat:'' ?>"}};

<?php } ?>




// survey.css = myCss;
$("#surveySkriningCovid").Survey({
    model: surveySkriningCovid,
    onComplete: sendDataToSkriningCovid
});
</script>