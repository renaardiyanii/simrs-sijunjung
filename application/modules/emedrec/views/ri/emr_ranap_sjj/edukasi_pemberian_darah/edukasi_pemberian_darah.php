<?php
$data = (isset($edukasi_pemberian_darah->formjson)?json_decode($edukasi_pemberian_darah->formjson):'');
// var_dump($data);
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

        <table border="1" width="100%">
            <tr>
                <td width="70%" style="font-style:italic">(Diisi Oleh Petugas)</td>
                <td style="text-align:right;font-style:italic">Halaman 1 dari 2</td>
            </tr>
        </table>
   
        <div style="font-size:10px;min-height:850px">
            <table border="1" width="100%" cellpadding="5px" cellspacing="5px">
                <tr>
                    <td style="line-height: 1.8;font-size:11px">
                        <p>1. APA ITU DARAH DAN PRODUK DARAH ?</p>
                        <p style="margin-left:15px;text-align: justify">
                            Darah yang mengalir dalam tubuh manusia adalan cairan yang mempunyai banyak kegunaan. Salah satu kegunaannya adalah mengantarkan oksigen dan makanan ke dalam sel. Untuk itu, darah mempunyai banyak komponen yang membuat darah menjadi cairan yang kompleks. Sebagai satu kesatuan darah biasanya disebut sebagai Darah lengkap atau  Whole Blood/WB.
                            Darah lengkap ini bisa dipisahkan menjadi beberapa bagian yang biasa dikenal sebagai Komponen Darah atau Produk Darah. Beberapa komponen darah yang biasa diberikan adalah :
                        </p>
                        <span>
                            <ol type="a">
                                <li>Sel Darah Merah atau Eritrosit ; Sel darah yang membawa oksigen ke dalam sel.</li>
                                <li>Sel Darah Putih atau Leukosit ; Sel darah yang menjaga tubuh dari penyakit infeksi seperti bakteri.</li>
                                <li>Keping Darah atau Trombosit ; Sel darah yang menghentikan perdarahan untuk sementara.</li>
                                <li>Plasma;  terdiri dari 92% air, 7% protein, 1% mineral. Sesuai kebutuhan, plasma dapat dibagi lagi menjadi beberapa bagian seperti faktor pembekuan, albumin dan globulin.</li>
                            </ol>
                       
                        </span>

                        <p>2. KENAPA ANDA DAN KELUARGA ANDA MEMBUTUHKAN PEMBERIAN DARAH DAN PRODUK DARAH ?</p>
                        <p style="margin-left:15px;text-align: justify">
                            Pemberian darah dan produk darah yang biasa dikenal sebagai trasfusi darah, biasanya perlu dilakukan ketika seseorang mengalami suatu hal yang menyebabkan darah atau komponen darah berkurang, baik dalam jumlah maupun fungsinya. Salah satu hal yang mungkin menyebabkan anda membutuhkan darah adalah pelaksanaan operasi dengan perdarahan yang banyak.
                            Dokter memutuskan untuk memberikan darah setelah mempertimbangkan banyak hal seperti keadaaan kesehatan anda dan riwayat penyakit yang pernah anda derita. Anda bisa menanyakan lebih lanjut mengenai alasan pemberian darah ini kepada dokter yang merawat anda.
                        </p>

                        <p>3. DARI MANA DARAH YANG DIBERIKAN BERASAL ?</p>
                        <p style="margin-left:15px;text-align: justify">
                            Darah yang anda terima berasal dari seseorang yang menyumbangkan darah. Umumnya, darah yang ditransfusikan kepada pasien di RSUD Sijunjung adalah darah yaaang disumbangkan di Unit Trasfusi Darah PMI Kabupaten Sijunjung.
                        </p>
                        
                        <p>4. APA MANFAAT PEMBERIAN DARAH DAN PRODUK DARAH ?</p>
                        <p style="margin-left:15px;text-align: justify">
                            Darah dan produk darah diberikan dengan maksud untuk menyelamatkan nyawa atau untuk memperbaiki kualitas hidup dari seseorang.
                        </p>

                        <p>5. APA RESIKO DARI PEMBERIAN DARAH DAN PRODUK DARAH ?</p>
                        <p style="margin-left:15px;text-align: justify">
                            Seperti umumnya tindakan medik yang lain, pemberian darah dan produk darah mempunyai berbagai resiko. Namun, darah yang diberikan telah melalui berbagai proses yang membuat risiko ini menjadi sangat kecil.
                            Beberapa risiko yang mungkin terjadi mencakup ;<br>

                            <ol type="a">
                                <li>Penularan Penyakit Menular Melalui Trasfusi Darah, seperti penularan HIV, Hepatitis B, Hepatitis C dan Sifilis. 
                                    Darah yang berasal dari Unit Trasfusi Darah PMI Kabupaten Sijunjung telah melalui proses pemeriksaan terhadap keempat penyakit tersebut di atas. Bila hasil pemeriksaan memperlihatkan adanya kemungkinan darah didapatkan dari pendonor yang memiliki salah satu dari penyakit ini, maka darah tersebut akan dibuang.
                                </li>
                                <li>
                                    Reaksi transfusi darah ringan dan sementara<br>
                                    Reaksi transfusi yang ringan dan sementara dapat terjadi pada 1 dari 100 pasien yang mendapat transfusi. Hal yang biasanya terjadi dapat berupa demam, menggigil atau timbulnya bengkak atau warna kemerahan pada kulit. Beritahu kepada dokter apabila hal ini pernah terjadi pada pelaksanaan transfusi sebelumnya atau bila hal ini terjadi saat pelaksanaan transfusi. 
                                </li>
                            
                        </p>


                       
                    </td>
                </tr>
            </table>
        </div>

        <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:380px;font-family:arial">
                No. Dokumen : Rev.I.I/2018/RM.8.d/RI
            </div>
        </div>
    </div>


    <div class="A4 sheet  padding-fix-10mm">
        <table border="1" width="100%" style="margin-top:50px">
            <tr>
                <td width="70%" style="font-style:italic">(Diisi Oleh Petugas)</td>
                <td style="text-align:right;font-style:italic">Halaman 2 dari 2</td>
            </tr>
        </table>

        <div style="font-size:10px;min-height:850px">
            <table border="1" width="100%" cellpadding="5px" cellspacing="5px">
                <tr>
                    <td style="line-height: 1.8;font-size:11px">
                        <p style="margin-left:15px;text-align: justify">
                            <ol type="a" start="3">
                                <li>Alloimunisasi atau pembentukan zat kekebalan atau antibodi<br>
                                    Pada beberapa keadaaan, pemberian darah dan produk darah dapat menyebabkan tubuh membuat zat kekebalan atau antibodi terhadap darah yang diberikan. Umumnya hal ini tidak menimbulkan gejala dan tidak membahayakan nyawa pasien. Namun, pemeriksaan tambahan biasanya perlu dilakukan sebelum pelaksanaan pemberian darah dan produk darah berikutnya.
                                </li>
                                <li>Nyeri atau pembengkakan di tempat pemasangan jarum.</li>
                            </ol>
                        </p>

                        <p>6. MENGAPA ANDA/KELUARGA HARUS MENUNGGU DARAH YANG DIMINTA OLEH DOKTER UNTUK DI PROSES SEBELUM DITRANSFUSIKAN ?</p>
                        <p style="margin-left:15px;text-align: justify">
                        Walaupun golongan darah yang terdapat dalam kantong darah sama dengan golongan darah pasien, sesuai standar yang ditetapkan WHO setiap darah yang akan ditransfusikan harus dilakukan uji pra transfusi (uji kecocokan/uji silang serasi) terlebih dahulu, sebelum ditransfusikan ke tubuh pasien.<br>

                        Hal ini dimaksud untuk menghindari ketidakcocokan yang masih mungkin terjadi sekalipun golongan darah sistem ABO dan Rhesus sudah sama. Untuk prosedur ini diperlukan waktu + 90 menit (sangat tergantung dengan jumlah pasien yang akan dikerjakan). Uji ini dilakukan dalam 2 jenis pemeriksaan (mayor dan minor) dengan tiga tahapan (fase 1 s/d 3), sehingga kesabaran anda menunggu merupakan salah satu kunci ketenangan dan ketelitian petugas kami dalam menjalankan seluruh proses uji pra transfusi tersebut.

                        </p>

                        <p>7. KENAPA ANDA HARUS MEMBAYAR UNTUK PEMBERIAN DARAH DAN PRODUK DARAH ?</p>
                        <p style="margin-left:15px;text-align: justify">
                            Darah diberikan secara cuma-cuma atau gratis oleh orang yang menyumbangkan darah. Namun, darah tersebut perlu diolah terlebih dahulu sebelum diberikan kepada pasien. Pengolahan ini menimbulkan biaya yang biasa disebut sebagai biaya pengganti pengolahan darah atau service cost.<br>
                            Beberapa pengolahan yang membutuhkan biaya tersebut mencakup:
                            <ol type="a">
                                <li>Rekrutmen Donor atau usaha untuk mencari donor darah sehingga persediaan darah cukup dan pasien tidak perlu menunggu lama sebelum bisa mendapatkan darah.</li>
                                <li>Proses pendonoran darah yang memerlukan biaya seperti pembelian kantong darah dan berbagai alat pendukung proses pendonoran darah.</li>
                                <li>Pemeriksaan keadaan darah seperti pemeriksaan terhadap penyakit menular lewat transfusi darah dan pemeriksaan kecocokan antara pasien dengan donor.</li>
                            </ol>
                        </p>

                        <p>8.  APA PILIHAN YANG DAPAT ANDA AMBIL ?</p>
                        <p style="margin-left:15px;text-align: justify">
                            Beberapa pilihan mengenai transfusi yang dapat anda ambil adalah :<br>
                            <ol type="a">
                                <li>Transfusi Autologus<br>
                                 Transfusi Autologus adalah pemberian darah yang diambil dari tubuh pasien sendiri. Cara ini umumnya dapat dilakukan pada pasien yang akan menjalani operasi.
                                </li>
                                <li>Transfusi darah dari keluarga<br>
                                    Transfusi darah dari keluarga adalah pemberian darah yang didonorkan oleh keluarga pasien. Unit Transfusi Darah PMI Kabupaten Sijunjung biasanya membutuhkan waktu sekitar 12 jam untuk melakukan pemprosesan darah sebelum pemeriksaan kecocokan antara pasien dan donor bisa dilakukan.
                                </li>
                                <li>Tidak transfusi<br>
                                    Pilihan ini mempunyai risiko terhadap kesehatan pasien. Diskusikan kemungkinan yang dapat terjadi bila anda menolak pemberian darah dan produk darah dengan dokter yang merawat anda.
                                </li>
                            </ol>
                        </p>

                        <p>9.  HAL LAIN </p>
                        <p style="margin-left:15px;text-align: justify">
                            Anda mempunyai hak untuk menanyakan dan mendiskusikan lebih lanjut mengenai berbagai hal mengenai pemberian darah dan produk darah dengan dokter yang merawat anda. Jangan ragu untuk melakukan hal tersebut.
                        </p>
                    </td>
                </tr>
            </table>
        </div><br><br><br>

        <div style="display:flex;font-size:12px;font-family:arial">
            <div style="font-family:arial;font-style:italic">
                KOMITE REKAM MEDIS
            </div>
            <div style="margin-left:380px;font-family:arial">
                No. Dokumen : Rev.I.I/2018/RM.8.d/RI
            </div>
        </div>

    </div>