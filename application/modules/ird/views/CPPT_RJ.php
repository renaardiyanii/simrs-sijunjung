<?php 
var_dump($data_fisik);
// echo $data_fisik->tb;
?>

<!DOCTYPE html>
<html>

<head>
    <title></title>
</head>
<style>
    #div1 {
        position: relative;
    }

    .header-parent {
        display: flex;
        justify-content: space-between;

    }

    .right {
        display: flex;
        align-items: flex-end;
        flex-direction: column;
        height: 50px;
        font-size: 12px;
    }

    .patient-info {
        border: 1px solid black;
        padding: 1em;
        display: flex;
        border-radius: 10px;
    }

    #date {
        display: flex;
        justify-content: space-between;
    }

    .kotak {

        height: 10;
        width: 10;
        /* border: 1px solid black; */
    }

    #data {
        margin-top: 20px;
        border-collapse: collapse;
        border: 1px solid black;
        width: 100%;
        font-size: 12px;
        position: relative;
    }

    #data thead tr th {
        text-align: center;
    }


    #column01 {
        text-align: center;
    }



    #footer {
        position: relative;
    }


    #text-footer2 {
        position: absolute;
        left: 10px;
        top: 20px;
    }
    .padding-fix-10mm {padding-top:5mm; padding-left: 10mm;padding-right: 10mm;}

</style>
<link rel="stylesheet" href="<?= base_url('assets/css/paper.css') ?>">


<body class="A4">
    <div id="div1 " class="A4 sheet padding-fix-10mm">

        <header>
            <div class="header-parent">
                <img src="logo.PNG" height="80px" alt="">
                <div class="right">
                    <span>Rev.27.01.2017.RM.RJ.02</span>
                    <div class="patient-info">
                        <div id="identity">
                            <span>No. RM</span><br>
                            <span>NAMA</span><br>
                            <span>Tanggal Lahir</span>
                        </div>
                        <div id="result-identity">
                            <span>: ...............................................</span><br>
                            <span>: .................................Lk / Pr</span><br>
                            <span>: ...............................................</span>
                        </div>
                    </div>
                </div>
            </div>
        </header><br>
        <div style="height:0px;border: 2px solid black;"></div>

        <div style="width: 100%;font-size: 12px;">
            <p style="font-weight: bold;text-align: center;">CATATAN PERKEMBANGAN PASIEN TERINTEGRASI
                RAWAT JALAN
            </p>
        </div>

        <table id="data" border="1" style="height: 100px;">
            <thead>
                <tr>
                    <th style="width: 25%">Tanggal / Jam</th>
                    <th style="width: 50%">
                        HASIL PEMERIKSAAN, ANALISA, RENCANA, PENATALAKSANAAN PASIEN
                        <p style="font-weight: normal;font-size: 11px;">(Dituliskan dengan format SOAP, disertai dengan
                            target yang terukur, evaluasi hasil tatalaksana dituliskan dalam assesmen, harap bubuhkan
                            stempel nama, dan paraf pada setiap akhir catatan)</p>
                    </th>
                    <th style="width: 25%">Nama Jelas Petugas dan Tanda Tangan</th>
                </tr>
            </thead>
            <tbody>
                <tr style="height: 730px;">
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div id="footer">
            <p id="text-footer2">Hal 1 dari 2</p>
        </div>

    </div>
    <!-- <button onclick="printContent('div1')">Print</button> -->
</body>


<body class="A4">
    <div id="div1" class="A4 sheet padding-fix-10mm">

        <header>
            <div class="header-parent">
                <img src="logo.PNG" height="80px" alt="">
                <div class="right">
                    <span>Rev.27.01.2017.RM.RJ.02 </span>
                </div>
            </div>
        </header><br>
        <div style="height:0px;border: 2px solid black;"></div>

        <div style="width: 100%;font-size: 12px;">
            <p style="font-weight: bold;text-align: center;">CATATAN PERKEMBANGAN PASIEN TERINTEGRASI
                RAWAT JALAN
            </p>
        </div>

        <table id="data" border="1" style="height: 100px;">
            <thead>
                <tr>
                    <th style="width: 25%">Tanggal / Jam</th>
                    <th style="width: 50%">
                        HASIL PEMERIKSAAN, ANALISA, RENCANA, PENATALAKSANAAN PASIEN
                        <p style="font-weight: normal;font-size: 11px;">(Dituliskan dengan format SOAP, disertai dengan
                            target yang terukur, evaluasi hasil tatalaksana dituliskan dalam assesmen, harap bubuhkan
                            stempel nama, dan paraf pada setiap akhir catatan)</p>
                    </th>
                    <th style="width: 25%">Nama Jelas Petugas dan Tanda Tangan</th>
                </tr>
            </thead>
            <tbody>
                <tr style="height: 730px;">
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

        <div id="footer">
            <p id="text-footer2">Hal 2 dari 2</p>
        </div>

    </div>
    <!-- <button onclick="printContent('div1')">Print</button> -->
</body>

</html>
