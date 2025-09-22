<?php

require_once __DIR__.'/../vendor/autoload.php';

//use your own bpjs config
$vclaim_conf = [
    'cons_id' => '18320',
    'secret_key' => '4mMCB9E795',
    'base_url' => 'https://new-api.bpjs-kesehatan.go.id:8080/',
    'service_name' => 'new-vclaim-rest'
];

//use referensi serivce
$referensi = new Nsulistiyawan\Bpjs\VClaim\Referensi($vclaim_conf);
var_dump($referensi->diagnosa('A00'));

//use peserta service
$peserta = new \Nsulistiyawan\Bpjs\VClaim\Peserta($vclaim_conf);
var_dump($peserta->getByNoKartu('0002187948879','2021-05-07'));
