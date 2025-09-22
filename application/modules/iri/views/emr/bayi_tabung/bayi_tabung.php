<?php 
$this->load->view('layout/header_form');
// var_dump($lembar_ppi);die();
?>
<style>

</style>

<div class="card m-5">
    <div class="body">
    <div id="surveyserah_bayi_tabung"></div>

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

surveyJSONserah_bayi_tabung = <?php echo file_get_contents("bayi_tabung.json",FILE_USE_INCLUDE_PATH);?>;

function sendDataToServerbayi_tabung(survey) {

        $.ajax({
            type: "POST",
            url: '<?= base_url('iri/rictindakan/insert_bayi_tabung/') ?>',
            data: {
                no_ipd : '<?php echo $no_ipd;?>',
                bayi_tabung_json:JSON.stringify(survey.data),
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


    var survey_bayi_tabung = new Survey.Model(surveyJSONserah_bayi_tabung);

    <?php if($bayi_tabung){ ?>
		survey_bayi_tabung.data = <?php echo isset($bayi_tabung->formjson)?$bayi_tabung->formjson:''; ?>
	<?php }else{ ?>
       

    <?php } ?>
    

// survey.css = myCss;
$("#surveyserah_bayi_tabung").Survey({
    model: survey_bayi_tabung,
    onComplete: sendDataToServerbayi_tabung
});
</script>