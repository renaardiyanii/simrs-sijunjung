<?php
//if ($role_id == 1) {
//    $this->load->view("layout/header_left_emr");
//} else if ($role_id == 37){
//    $this->load->view("layout/header_dashboard_emr");
//} else {
//    $this->load->view("layout/header_horizontal_emr");
//}
$this->load->view("layout/header_left_emr");
?>
<div id="surveyContainer"></div>
<div id="surveyResult"></div>
<?php
//var_dump($data_pasien);
?>
<script>
            Survey.StylesManager.applyTheme("bootstrap");
            Survey.defaultBootstrapCss.navigationButton = "btn btn-green";
            var surveyValueChanged = function (sender, options) {
                var el = document.getElementById(options.name);
                if (el) {
                    el.value = options.value;
                }
            };

            var surveyJSON = 
            {
                "title": "SLIP ADMISSION (RM001A)",
                    "elements": [
                        {"type": "panel",
                        "name": "panel1",
                        "elements": [
                                {
                                    "type": "text",
                                    "name": "tgl",
                                    "inputType": "date",
                                    "title": "Tanggal :",
                                    "titleLocation": "left",
                                    "hideNumber": true
                                },
                                {
                                    "type": "text",
                                    "name": "pukul",
                                    "inputType": "time",
                                    "title": "Pukul :",
                                    "titleLocation": "left",
                                    "startWithNewLine": false,
                                    "hideNumber": true
                                },
                                {
                                    "type": "text",
                                    "name": "dari_poli",
                                    "title": "Dari Poli/IGD :",
                                    "hideNumber": true,
                                    "titleLocation": "left",
                                }
                            ]},
                            {"type": "panel",
                            "name": "panel2",
                            "title": "I. Identitas Pasien",
                            "elements": [
                                {
                                    "type": "text",
                                    "name": "nama_pasien",
                                    "readOnly": true,
                                    "titleLocation": "left",
                                    "hideNumber": true,
                                    "title": "Nama Lengkap"
                                },
                                {
                                    "type": "text",
                                    "titleLocation": "left",
                                    "readOnly": true,
                                    "name": "ttl",
                                    "hideNumber": true,
                                    "title": "Tanggal Lahir"
                                },
                                {
                                    "type": "comment",
                                    "readOnly": true,
                                    "titleLocation": "left",
                                    "name": "alamat",
                                    "hideNumber": true,
                                    "title": "Alamat Pasien"
                                },
                                {
                                    "type": "text",
                                    "name": "penanggung_jawab",
                                    "titleLocation": "left",
                                    "hideNumber": true,
                                    "title": "Penanggung Jawab :"
                                },
                                {
                                    "type": "text",
                                    "name": "Pekerjaan_Penanggung_Jawab",
                                    "titleLocation": "left",
                                    "hideNumber": true,
                                    "title": "Pekerjaan Penanggung Jawab :"
                                }
                            ]},
                            {
                                "type": "panel",
                                "name": "panel3",
                                "title": "II. Diagnosa Masuk",
                                "elements": [ 
                                    {
                                        "type": "text",
                                        "name": "diagnosa_masuk",
                                        "title": "Diagnosa Masuk :",
                                        "titleLocation": "left",
                                        "hideNumber": true,
                                    },
                                    {
                                        "type": "checkbox",
                                        "name": "rencana_perawatan",
                                        "title": "Rencana Perawatan :",
                                        "titleLocation": "left",
                                        "hideNumber": true,
                                        "choices": [
                                                "MRS",
                                                "Operasi",
                                                "Kemoterapi",
                                                "Persalinan",
                                                "ODC"
                                            ],
                                        "colCount": 5
                                    },
                                    {
                                        "type": "text",
                                        "name": "dokter_yg_merawat",
                                        "title": "Dokter yang merawat",
                                        "titleLocation": "left",
                                        "hideNumber": true
                                    },
                                    {
                                        "type": "checkbox",
                                        "name": "cara_bayar",
                                        "title": "Cara Bayar :",
                                        "titleLocation": "left",
                                        "hideNumber": true,
                                        "choices": [
                                            "Umum",
                                            "BPJS",
                                            "Perusahan",
                                            "Lain - Lain"
                                        ],
                                        "colCount": 4
                                    },
                                    {
                                        "type": "text",
                                        "name": "hak_kelas_perawatan",
                                        "title": "Hak Perawatan di Kelas :",
                                        "titleLocation": "left",
                                        "hideNumber": true
                                    },

                                ]                              
                            },
                            {
                                "type": "panel",
                                "name": "panel3",
                                "title": "III. Kelas Perawatan",
                                "elements": [ 
                                    {
                                        "type": "checkbox",
                                        "name": "kelas_perawatan",
                                        "title": "Kelas Perawatan :",
                                        "titleLocation": "left",
                                        "hideNumber": true,
                                        "choices": [
                                            "III",
                                            "II",
                                            "I",
                                            "VIP",
                                            "SUPER VIP"
                                        ],
                                        "colCount": 5
                                    },
                                    {
                                        "type": "dropdown",
                                        "name": "ruangan",
                                        "title": "Ruangan :",
                                        "titleLocation": "left",
                                        "hideNumber": true,
                                        "choices": [
                                            "Selincah",
                                            "Kikim",
                                            "Kelingi",
                                            "Komering",
                                            "Borang",
                                            "Rambang",
                                            "Lematang",
                                            "Musi",
                                            "Ogan",
                                            "Enim",
                                            "Lakitan",
                                            "Rawas",
                                            "HCU",
                                            "BHC",
                                            "Transit IGD",
                                            "ICU(NICU/PICU/GICU)"
                                        ],
                                    },
                                    {
                                        "type": "text",
                                        "name": "ketersediaan_tt",
                                        "title": "Ketersediaan Tempat Tidur :",
                                        "titleLocation": "left",
                                        "hideNumber": true
                                    },
                                    {
                                        "type": "boolean",
                                        "name": "situasi_kamar",
                                        "title": "Situasi Kamar :",
                                        "defaultValue": true,
                                        "labelTrue": "Siap",
                                        "labelFalse": "Tidak",
                                        "titleLocation": "left",
                                        "hideNumber": true
                                    },
                                    {
                                        "type": "boolean",
                                        "name": "kesiapan_kamar",
                                        "title": "Kesiapan Kamar :",
                                        "titleLocation": "left",
                                        "defaultValue": true,
                                        "labelTrue": "Boleh Kirim",
                                        "labelFalse": "Tidak",
                                        "hideNumber": true
                                    },
                                ]
                            },
                            {
                                "type": "panel",
                                "name": "panel4",
                                "title": "IV. Informasi Biaya",
                                "elements": [ 
                                    {
                                        "type": "text",
                                        "name": "by_ruangan",
                                        "title": "Ruang Perawatan :",
                                        "titleLocation": "left",
                                        "hideNumber": true,
                                        "isRequired": true,
                                        "placeHolder": "Rp."
                                    },
                                    {
                                        "type": "multipletext",
                                        "name": "jenis_tindakan",
                                        "title": "Jenis Tindakan",
                                        "titleLocation": "left",
                                        "hideNumber": true,
                                        "items": [
                                        {
                                        "name": "by_jenis_tindakan",
                                        "title": "Jenis Tindakan :"
                                        },
                                        {
                                        "name": "by_jenis_tindakan_rp",
                                        "title": "Rp (+/-)"
                                        }
                                        ],
                                        "colCount": 2
                                    },
                                    {
                                        "type": "text",
                                        "name": "by_visit_dokter",
                                        "title": "Visit Dokter (per visit):",
                                        "titleLocation": "left",
                                        "hideNumber": true,
                                        "placeHolder": "Rp."
                                    },
                                    {
                                        "type": "text",
                                        "name": "Lain_Lain",
                                        "title": "Lain Lain :",
                                        "titleLocation": "left",
                                        "hideNumber": true,
                                        "placeHolder": "Rp."
                                    },
                                ]
                            },
                            {
                                "type": "panel",
                                "name": "panel5",
                                "title": "V. Informasi dan Evaluasi",
                                "elements": [ 
                                    {
                                        "type": "boolean",
                                        "name": "info_kamar",
                                        "title": "Informasi Ketersediaan & Situasi Kamar :",
                                        "titleLocation": "left",
                                        "hideNumber": true,
                                        "defaultValue": true,
                                        "labelTrue": "Ya",
                                        "labelFalse": "Tidak",
                                    },
                                    {
                                        "type": "boolean",
                                        "name": "info_hak",
                                        "title": "Informasi Hak & Kewajiban :",
                                        "titleLocation": "left",
                                        "hideNumber": true,
                                        "defaultValue": true,
                                        "labelTrue": "Ya",
                                        "labelFalse": "Tidak",
                                    },
                                    {
                                        "type": "boolean",
                                        "name": "info_genconcent",
                                        "title": "Informasi General Concent :",
                                        "titleLocation": "left",
                                        "hideNumber": true,
                                        "defaultValue": true,
                                        "labelTrue": "Ya",
                                        "labelFalse": "Tidak",
                                    },
                                    {
                                        "type": "boolean",
                                        "name": "info_carabayar",
                                        "title": "Informasi Cara Bayar dan Perlengkapan / Persyaratan :",
                                        "titleLocation": "left",
                                        "hideNumber": true,
                                        "defaultValue": true,
                                        "labelTrue": "Ya",
                                        "labelFalse": "Tidak",
                                    },
                                    {
                                        "type": "booleah",
                                        "name": "medrek_lama",
                                        "title": "Rekam Medik Lama :",
                                        "titleLocation": "left",
                                        "defaultValue": true,
                                        "labelTrue": "Ada",
                                        "labelFalse": "Tidak",
                                    },
                                    {
                                        "type": "boolean",
                                        "name": "checklist_pasien",
                                        "title": "Check List Pasien Oleh : ",
                                        "titleLocation": "left",
                                        "hideNumber": true,
                                        "defaultValue": false,
                                        "labelTrue": "IRD",
                                        "labelFalse": "Admission",
                                    },                                    
                                ]
                            },
                            {
                                "type": "panel",
                                "name": "panel6",
                                "elements": [ 

                                    {
                                        "type": "text",
                                        "name": "tgl_ttd",
                                        "inputType": "date",
                                        "indent": 25,
                                        "title": "Palembang, ",
                                        "titleLocation": "left",
                                        "hideNumber": true
                                    },
                                    {
                                        "type": "signaturepad",
                                        "name": "ttd_keluarga_pasien",
                                        "title": "Pasien / Keluarga",
                                        "hideNumber": true,
                                        "penColor": "#040411"
                                    },
                                    {
                                        "type": "signaturepad",
                                        "name": "ttd_petugas_ruangan",
                                        "startWithNewLine": false,
                                        "title": "Petugas Ruangan Rawat Inap",
                                        "hideNumber": true,
                                        "penColor": "#070f1d"
                                    },
                                    {
                                        "type": "signaturepad",
                                        "name": "ttd_pemberi_informasi",
                                        "startWithNewLine": false,
                                        "title": "Pemberi Informasi",
                                        "hideNumber": true,
                                        "penColor": "#030816"
                                    },
                                    {
                                        "type": "text",
                                        "name": "nm_keluarga_pasien",
                                        "hideNumber": true,
                                        "title": "Nama Keluarga Pasien"
                                    },
                                    {
                                        "type": "text",
                                        "name": "nm_petugas_ruangan",
                                        "startWithNewLine": false,
                                        "hideNumber": true,
                                        "title": "Nama Petugas Ruangan"
                                    },
                                    {
                                        "type": "text",
                                        "name": "nm_pemberi_informasi",
                                        "startWithNewLine": false,
                                        "hideNumber": true,
                                        "title": "Nama Pemberi Informasi"
                                   }

                                ]
                            }


                        ],
            }

			function sendDataToServer(survey) {
		    //send Ajax request to your web server.
    			alert("The results are:" + JSON.stringify(survey.data));
			}

            var survey = new Survey.Model(surveyJSON);
            survey.data = {
                "nama_pasien": "<?php echo $data_pasien[0]['nama'];?>",
                "ttl": "<?php echo $data_pasien[0]['tmpt_lahir'].'/'.substr($data_pasien[0]['tgl_lahir'],0,10);?>",
                "alamat": "<?php echo $data_pasien[0]['alamat'].', '.$data_pasien[0]['kecamatan'].', '.$data_pasien[0]['kotakabupaten'].', '.$data_pasien[0]['provinsi'];?>",
            };

            survey
                .onValueChanged
                .add(function (sender, options) {
                    var mySurvey = sender;
                    var questionName = options.name;
                    var newValue = options.value;
                });

            survey
                .onComplete
                .add(function (result) {
                    document
                        .querySelector('#surveyResult')
                        .textContent = "Result JSON:\n" + JSON.stringify(result.data, null, 3);
                });
            
            $("#surveyContainer").Survey({model: survey});    
            console.log(survey.getValue('Diagnosa_Masuk'));
</script>

<?php
if ($role_id == 1) {
    $this->load->view("layout/footer_left");
} else {
    $this->load->view("layout/footer_horizontal");
}
?>