<?php
if ($role_id == 1) {
	$this->load->view("layout/header_left");
} else {
	$this->load->view("layout/header_left");
}
?>
<html>

<?php
echo $this->session->flashdata('success_msg');
?>

<img src="<?php echo base_url('assets/msg/404.jpg') ?>" width="100%" alt="">

<?php
$this->load->view('layout/footer_left.php');
?>