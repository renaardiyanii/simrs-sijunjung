<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Select2 Widget, Knockoutjs Survey Library Example</title><meta name="viewport" content="width=device-width"/>
        <script src="https://unpkg.com/jquery"></script>
        <script src="https://unpkg.com/knockout@3.5.1/build/output/knockout-latest.js"></script>
        <script src="https://unpkg.com/survey-knockout@1.8.71/survey.ko.min.js"></script>
        <link href="https://unpkg.com/survey-core@1.8.71/modern.min.css" type="text/css" rel="stylesheet"/>
        <!-- <link rel="stylesheet" href="./index.css"> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script><link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet"/>
        <script src="https://unpkg.com/surveyjs-widgets@1.8.71/surveyjs-widgets.min.js"></script>
    </head>
    <body>
        <div id="surveyElement" style="display:inline-block;width:100%;"></div>
        <div id="surveyResult"></div>
        <!-- <script type="text/javascript" src="./index.js"></script> -->
        <script>
Survey
    .StylesManager
    .applyTheme("modern");

var json = {
    "elements": [
        {
            "type": "dropdown",
            "renderAs": "select2",
            "choicesByUrl": {
                "url": "https://surveyjs.io/api/CountriesExample"
            },
            "name": "countries",
            "title": "Please select the country you have arrived from:"
        }
    ]
};

window.survey = new Survey.Model(json);

survey
    .onComplete
    .add(function (sender) {
        document
            .querySelector('#surveyResult')
            .textContent = "Result JSON:\n" + JSON.stringify(sender.data, null, 3);
    });

survey.data = {
    countries: 'Andorra'
};

survey.render("surveyElement");;

</script>
    </body>
</html>
