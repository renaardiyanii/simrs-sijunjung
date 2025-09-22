<?php
        if ($role_id == 1) {
            $this->load->view("layout/header_left");
        } else {
            $this->load->view("layout/header_left");
        }
?>
<div id="surveyContainer"></div>
<script>
Survey.StylesManager.applyTheme("modern");

var surveyJSON = {"pages":[{"name":"page1","elements":[{"type":"signaturepad","name":"ttd","titleLocation":"hidden","hideNumber":true,"penColor":"#262626"}]}]}

function sendDataToServer(survey) {
    //send Ajax request to your web server.
    // alert("The results are:" + JSON.stringify(survey.data));
    console.log(survey.data.ttd);
}

var survey = new Survey.Model(surveyJSON, "surveyContainer");
survey.onComplete.add(sendDataToServer);
</script>
<?php 
        if ($role_id == 1) {
            $this->load->view("layout/footer_left");
        } else {
            $this->load->view("layout/footer_horizontal");
        }
    ?> 