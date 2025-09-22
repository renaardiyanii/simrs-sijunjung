<?php 
$this->load->view('layout/header_form');
// var_dump($lembar_ppi);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveycatatan_perawat"></div>

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

surveyJSONcatatan_perawat = <?php echo file_get_contents("catatan_perawat.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServercatatan_perawat(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_catatan_perawat/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                catatan_perawat_json:JSON.stringify(survey.data),
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


    var survey_catatan_perawat = new Survey.Model(surveyJSONcatatan_perawat);

    <?php if($catatan_perawat){ ?>
		survey_catatan_perawat.data = <?php echo isset($catatan_perawat->formjson)?$catatan_perawat->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveycatatan_perawat").Survey({
    model: survey_catatan_perawat,
    onComplete: sendDataToServercatatan_perawat
});
</script>