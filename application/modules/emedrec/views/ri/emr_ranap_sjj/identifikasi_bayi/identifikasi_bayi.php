<?php
// $data = (isset($edukasi_pemberian_darah->formjson)?json_decode($edukasi_pemberian_darah->formjson):'');

?>

<head>
    <title></title>
</head>

<style>
#data {
    /* margin-top: 10px; */
    /* border-collapse: collapse; */
    /* border: 1px solid black;     */
    width: 100%;
    font-size: 10px;
    position: relative;


}

#data tr td {

    font-size: 10px;
    font-family: arial;

}

#data th {

    font-size: 10px;
    font-family: arial;

}

#noborder td {
    font-family: arial;
    font-size: 12px;
}
</style>

</style>
<link href="<?php echo base_url('assets/style_print.css'); ?>" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">

<body class="A4">
    <div class="A4 sheet  padding-fix-10mm">
        <header>
            <?php $this->load->view('emedrec/ri/header_print_new') ?>
        </header>
   
       

        
    </div>

