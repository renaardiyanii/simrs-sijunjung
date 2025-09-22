<?php 
$this->load->view('layout/header_form');

if($user->userid == 1139) {
    include('jawabankonsultasirehabmedik.php');
} else {
    include('jawabankonsultasi.php');
}
?>
