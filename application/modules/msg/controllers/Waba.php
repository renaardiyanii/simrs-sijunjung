<?php
defined('BASEPATH') or exit('No direct script access allowed');

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException as Exception;
use GuzzleHttp\Psr7\Request;

class Waba extends Secure_area
{
  private $_client;

  public function __construct()
  {
    parent::__construct();

    $this->load->model('admin/appconfig', '', TRUE);
    $this->load->model('M_check', '', TRUE);
    $this->load->model('M_crud', '', TRUE);
    $this->load->model('admin/M_user', '', TRUE);

    $this->_client = new Client();
  }

  public function t_hasil_penunjang()
  {
    $check_conf = $this->M_check->check_config_waba();
    $roleid = $this->M_user->get_role_id()->row()->roleid;

    // check status
    if ($check_conf->status == 'R' or ($check_conf->status == 'D' and $roleid == 1)) {
      // url for API server doc.rsomh.co.id, API meta developer and Self API
      $url_serv0 = 'http://' . ((($_SERVER['HTTP_HOST'] == '36.66.44.99:8926') OR ($_SERVER['HTTP_HOST']=='36.66.44.99:8927')) ? '36.66.44.101:8101' : '192.168.115.5:8101') . '/api/';
      $url_self = ($_SERVER['SERVER_NAME']=='36.66.44.99') ? 'http://36.66.44.99:8926/msg/openuri/' : str_replace('https', 'http', base_url() . 'msg/openuri/');
      $url_ippublic = 'http://36.66.44.99:8926/msg/openuri/';
      $url_apiwaba = 'https://graph.facebook.com/';


      // get data from database
      $check_limit_h = $this->M_check->check_limit_harian();
      $check_limit_b = $this->M_check->check_limit_bulan();
      $user_name = $this->M_check->check_user_login();


      // catat variable penting
      $doc_version = '1.0.0';
      $file_json = json_encode('');
      $code = 999;
      $code_getjson = 999;
      $code_sendapiwa = 999;
      $code_sendapiserv0 = 999;
      date_default_timezone_set("Asia/Jakarta");
      $tgl = date("Y-m-d H:i:s");
      $jns_penunjang = $this->input->post('jns_penunjang');
      $nopnj = $this->input->post('nopnj');
      $noreg = $this->input->post('noreg');
      $nomr = $this->input->post('nomr');
      $nohp = $this->input->post('nohp');
      $nama = $this->input->post('pasienname');
      $file_name = '';
      $qrcode_doc = md5($nopnj . $noreg . $nomr . $tgl) . substr($jns_penunjang, 0, 2);

      // check limit
      if ($check_conf->limit_harian_unit >= $check_limit_h && $check_conf->limit_bulanan_unit >= $check_limit_b) {
        $data['limit'] = 'N';

        // ambil data sesuai jenis penunjang
        if ($jns_penunjang == 'lab') {
          // get data json
          $req_lab = new Request('GET', $url_self . 'waba_lab/' . $nopnj . '/' . $qrcode_doc . '?view=json');
          $res_lab = $this->_client->sendAsync($req_lab)->wait();
          $file_json = $res_lab->getBody()->getContents();
          $code_getjson = $res_lab->getStatusCode();

          // catat variable dari hasil get data json
          $file_name = strtoupper($jns_penunjang) . '-' . $nomr . '-' . $nama;
          $url_doc = $url_ippublic . 'waba_lab/' . $nopnj . '/' . $qrcode_doc;
          $param_isi = 'hasil pemeriksaan laboratorium :';
          $data['getjson_code'] = $code_getjson;
        } elseif ($jns_penunjang == 'rad') {
          // get data json
          $req_rad = new Request('GET', $url_self . 'waba_rad/' . $nopnj . '/' . $qrcode_doc . '?view=json');
          $res_rad = $this->_client->sendAsync($req_rad)->wait();
          $file_json = $res_rad->getBody()->getContents();
          $code_getjson = $res_rad->getStatusCode();

          // catat variable dari hasil get data json
          $file_name = strtoupper($jns_penunjang) . '-' . $nomr . '-' . $nama;
          $url_doc = $url_ippublic . 'waba_rad/' . $nopnj . '/' . $qrcode_doc;
          $param_isi = 'hasil pemeriksaan radiologi :';
          $data['getjson_code'] = $code_getjson;
        } elseif ($jns_penunjang == 'udt') {
          // get data json
          $req_udt = new Request('GET', $url_self . 'waba_udt/' . $nopnj . '/' . $qrcode_doc . '?view=json');
          $res_udt = $this->_client->sendAsync($req_udt)->wait();
          $file_json = $res_udt->getBody()->getContents();
          $code_getjson = $res_udt->getStatusCode();

          // catat variable dari hasil get data json
          $file_name = strtoupper($jns_penunjang) . '-' . $nomr . '-' . $nama;
          $url_doc = $url_ippublic . 'waba_udt/' . $nopnj . '/' . $qrcode_doc;
          $param_isi = 'hasil pemeriksaan unit diagnostik terpadu :';
          $data['getjson_code'] = $code_getjson;
        }

        if ($code_getjson == 200) {
          // kirim ke server 5
          $code_sendapiserv0 = $this->_client->request(
            'POST',
            $url_serv0 . 'penunjang',
            [
              'json' => [
                'file' => $file_json,
                'jenis' => $jns_penunjang,
                'tgl_input' => $tgl,
                'id_doc' => $qrcode_doc,
                'no_order' => (int) $nopnj,
                'doc_version' => $doc_version
              ]
            ]
          );
          $data['sendapiserv0_code'] = $code_sendapiserv0->getStatusCode();
          $data['sendapiserv0_body'] = $code_sendapiserv0->getBody()->getContents();

          if ($code_sendapiserv0->getStatusCode() == 200) {
            // kirim ke api meta dev (whatsapp)
            $headers = [
              'Authorization' => 'Bearer ' . $check_conf->user_access_token,
              'Content-Type' => 'application/json'
            ];
            $body = '{
                    "messaging_product": "whatsapp",
                    "recipient_type": "individual",
                    "to": "' . $nohp . '",
                    "type": "template",
                    "template": {
                      "name": "ekamek_hasil_penunjang",
                      "language": {
                        "code": "id"
                      },
                      "components": [
                        {
                          "type": "header",
                          "parameters": [
                            {
                              "type": "document",
                              "document": {
                                "filename": "' . $file_name . '",
                                "link": "' . $url_doc . '"
                              }
                            }
                          ]
                        },
                        {
                          "type": "body",
                          "parameters": [
                            {
                              "type": "text",
                              "text":"' . $param_isi . '"
                            },
                            {
                              "type": "text",
                              "text":"' . $nomr . '"
                            },
                            {
                              "type": "text",
                              "text": "' . $nama . '"
                            }
                          ]
                        }
                      ]
                    }
                  }';
            $request = new Request('POST', $url_apiwaba . $check_conf->version . '/' . $check_conf->phone_number_id . '/messages', $headers, $body);
            $res = $this->_client->sendAsync($request)->wait();
            $code_sendapiwa = $res->getStatusCode();
            $data['sendapiwa_code'] = $code_sendapiwa;
            $data['sendapiwa_body'] = $res->getBody()->getContents();
          } else {
            $data['sendapiserv0_code'] = 999;
          }
        } else {
          $data['getjson_code'] = 999;
        }
      } else {
        $data['limit'] = 'Y';
      }
      $data['status'] = 'R';
      $code = ($code_getjson != 200 and $code_sendapiwa != 200 and $code_sendapiserv0 != 200) ? 999 : 200;
      $data['code'] = $code;

      // simpan history
      $history['created_date'] = $tgl;
      $history['created_by_role'] = $roleid;
      $history['jenis_penunjang'] = $jns_penunjang;
      $history['response_code'] = $code;
      $history['response_body'] = json_encode($data);
      $history['created_user'] = $user_name;

      $this->M_crud->insert_history_waba($history);

      echo json_encode($data);
    } else {
      $data['status'] = $check_conf->status;
      echo json_encode($data);
    }
  }


  public function check_token()
  {
    $roleid = $this->M_user->get_role_id()->row()->roleid;
    if ($roleid == 1) {
      $data['check_tgl_token'] = $this->M_check->check_created_tgl_token();
      $this->load->view('msg/token_date', $data);
    } else {
      $data['title'] = 'Page Not Found';
      $this->load->view('msg/404', $data);
    }
  }

  public function history()
  {
    $roleid = $this->M_user->get_role_id()->row()->roleid;
    if ($roleid == 1) {
      $data['title'] = 'Whatsapp Business History';
      $data['history'] = $this->M_crud->get_history();

      $this->load->view('msg/history', $data);
    } else {
      $data['title'] = 'Page Not Found';
      $this->load->view('msg/404', $data);
    }
  }

  public function history_by_date()
  {
    $roleid = $this->M_user->get_role_id()->row()->roleid;
    if ($roleid == 1) {
      $tgl = $this->input->post('tgl');
      $data = $this->M_crud->get_history_by_date($tgl);

      echo json_encode($data);
    }
  }
}
