<?php
function generate_tot_notif()
{
  $CI = &get_instance();
  $CI->load->model('notif/M_notif', '', TRUE);

  $datan = $CI->M_notif->get_allowed_notif();

  $tnotif = 0;
  foreach ($datan->result() as $data) {
    $CI->db->db_debug = false;
    if (!@$CI->db->query("$data->notif_query")) {
      $error = $CI->db->error();
      $tnotif = 0;
    } else {
      $tnotif = $tnotif + $CI->db->query("$data->notif_query")->row()->total;
    }
  }
  $CI->db->db_debug = true;
  return $tnotif;
}

function generate_notif()
{

  $notif = '';
  $CI = &get_instance();
  $CI->load->model('notif/M_notif', '', TRUE);

  $datan = $CI->M_notif->get_allowed_notif();

  if ($datan->num_rows() > 0) {
    foreach ($datan->result() as $data) {
      $CI->db->db_debug = false;
      if (!@$CI->db->query("$data->notif_query")) {
        $error = $CI->db->error();
        $countr = 0;
      } else {
        $countr = $CI->db->query("$data->notif_query")->row()->total;
      }

      $notif .= '<a href="' . site_url($data->url) . '"><div class="btn btn-circle btn-sm btn-outline-' . $data->colour . ' "><i class="' . $data->icon . '"></i></div><div class="mail-contnet" style="width: 85%; padding: 5px;"><h5 class="pull-left">' . $data->notif_title . '</h5><span class="pull-right label label-light-' . $data->colour . ' mt-1" id="nid' . $data->notif_id . 'ar">' . $countr . '</span></div></a>';
    }
    $notif .= '<audio loop="loop" id="sound_notif" allow="autoplay;" src="' . base_url() . 'assets/notif/soundnotif-ekamek.mp3" type="audio/ogg"></audio>';
    $CI->db->db_debug = true;
  } else {
    $notif .= '<a  class="text-center" id="no-notif-allowed" style="pointer-events: none; cursor: default; border-bottom: 0;"><img src="' . site_url() . 'assets/notif/no-notif.png"></a>';
  }
  return $notif;
}

function get_notif_count($notif_id)
{
  $CI = &get_instance();
  $CI->load->model('notif/M_notif', '', TRUE);
  $rnotif = $CI->M_notif->get_allowed_notif_by_id($notif_id);
  return $rnotif;
}
