<?php 
$this->load->view('layout/header_form');
// var_dump($data_fisik);

?>
<style>
.container-cover{
    background-color:transparent;
}
</style>
<!-- <link href="https://unpkg.com/survey-jquery@1.8.47/modern.css" type="text/css" rel="stylesheet" /> -->
<!-- <script src="https://unpkg.com/survey-jquery@1.8.47/survey.jquery.min.js"></script> -->


<div id="surveyFungsionalStatus"></div>
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

var surveyJsonStatusFungsional = <?php echo file_get_contents("penilaian_status_fungsional.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToFungsionalStatus(survey) {
    //send Ajax request to your web server.
    // alert("The results are:" + JSON.stringify(survey.data));
    $.ajax({
        type: "POST",
        url: '<?= base_url('ird/rdcpelayanan/penilaian_fungsional_status/') ?>',
        data: {
            no_register : '<?php echo $no_register;?>',
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

var surveyFungsionalStatus = new Survey.Model(surveyJsonStatusFungsional);

<?php 
if(isset($penilaian_fungsional_status)){
?>
surveyFungsionalStatus.data = <?php echo isset($penilaian_fungsional_status->formjson)?$penilaian_fungsional_status->formjson:'' ?>
<?php } ?>

// survey.css = myCss;
$("#surveyFungsionalStatus").Survey({
    model: surveyFungsionalStatus,
    onComplete: sendDataToFungsionalStatus
});
</script>