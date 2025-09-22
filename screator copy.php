<html>
	<head>
        <title>ERM Form Creator</title>
    <script src="assets/surveyjs/knockout-latest.js"></script>
        <script src="assets/surveyjs//survey.ko.min.js"></script>
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.10/ace.min.js" type="text/javascript" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.10/ext-language_tools.js" type="text/javascript" charset="utf-8"></script>-->
        <!-- Uncomment to enable Select2 <script src="https://unpkg.com/jquery"></script> <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" /> <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script> -->
        <link href="assets/surveyjs/survey-creator.min.css" type="text/css" rel="stylesheet"/>
        <script src="assets/surveyjs//survey-creator.min.js"></script>
        <link rel="stylesheet" href="assets/css/bootstrap3/css/bootstrap.min.css">
        <script src="assets/surveyjs/ckeditor.js"></script>
        <script src="assets/surveyjs/surveyjs.widgets.js"></script>
        <link rel="stylesheet" href="./index.css"></head>	</head>
	<body>
        <div id="surveyContainer">
            <div id="creatorElement"></div>
        </div>
        <script>
            var options = {
                showLogicTab: true,
                showEmbeddedSurveyTab: true,
            };
            //create the SurveyJS Creator and render it in div with id equals to "creatorElement"
            var creator = new SurveyCreator.SurveyCreator("creatorElement", options);
            //Show toolbox in the right container. It is shown on the left by default
            creator.showToolbox = "right";
            //Show property grid in the right container, combined with toolbox
            creator.showPropertyGrid = "right";
            //Make toolbox active by default
            creator.rightContainerActiveItem("toolbox");
            
        </script>
    </body>
</html>
