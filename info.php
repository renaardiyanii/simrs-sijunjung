<?php 

require_once "/home/ptipo/rsomh4/rsomh/vendor/xemlock/php-latex/library/PhpLatex/Parser.php";
require_once "/home/ptipo/rsomh4/rsomh/vendor/xemlock/php-latex/library/PhpLatex/Lexer.php";
require_once "/home/ptipo/rsomh4/rsomh/vendor/xemlock/php-latex/library/PhpLatex/Node.php";
require_once "/home/ptipo/rsomh4/rsomh/vendor/xemlock/php-latex/library/PhpLatex/Utils.php";
require_once "/home/ptipo/rsomh4/rsomh/vendor/xemlock/php-latex/library/PhpLatex/Renderer/Abstract.php";
require_once "/home/ptipo/rsomh4/rsomh/vendor/xemlock/php-latex/library/PhpLatex/Renderer/Html.php";
require_once "/home/ptipo/rsomh4/rsomh/vendor/xemlock/php-latex/library/PhpLatex/Renderer/Typestyle.php";
require_once "/home/ptipo/rsomh4/rsomh/vendor/xemlock/php-latex/library/PhpLatex/Utils/PeekableIterator.php";
require_once "/home/ptipo/rsomh4/rsomh/vendor/xemlock/php-latex/library/PhpLatex/Utils/PeekableArrayIterator.php";
require_once "/home/ptipo/rsomh4/rsomh/vendor/xemlock/php-latex/library/PhpLatex/Utils/PeekableArrayIterator.php";
function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
$input = <<<EOT
\begin{document}
\section*{Soal 9}
Berikut ada pertanyaan mengenai pengalaman Anda selama bekerja (MOHON DIFOKUSKAN PADA PENGALAMAN KERJA DI 2-4 TAHUN TERAKHIR, namun jika tidak ada bisa pada pengalaman ditahun-tahun lain). Cara menjawab pertanyaan ialah menceritakan pengalaman Anda secara mendetil dan spesifik dan berisi hal hal dibawah ini :
\begin{enumerate}
\item Menceritakan SITUASI yang dialami (siapa yang terlibat, kapan waktunya, dimana) 
\item Apa JABATAN SECARA FORMAL beserta tugas  anda pada situasi tersebut serta peran yang secara aktual anda jalankan?  
\item Bagaimana TINDAKAN ANDA dalam situasi tersebut dan pertimbangannya?
\item Bagaimana HASIL DAN DAMPAK/PENGARUH TINDAKAN Anda bagi lingkungan kerja anda?
\\end{enumerate}
Jawablah di kolom yang sudah disediakan.
\begin{enumerate}
\item \\textbf{Ceritakan cara Bapak/Ibu dalam membina komunikasi yang efektif baik kepada atasan, rekan kerja maupun bawahan?}

\item Dalam melaksanakan pekerjaan, bagaimana cara Bapak/Ibu menyampaikan pendapat pada rapat/meeting agar dapat berjalan efektif?

\item Apakah Bapak/Ibu pernah ditugaskan untuk menyusun presentasi bagi pimpinan? Apa saja hal yang dipersiapkan?
\\end{enumerate}
\\end{document}
EOT;
$parser = new PhpLatex_Parser();
$parsedTree = $parser->parse($input);
$htmlRenderer = new PhpLatex_Renderer_Html();
$html = $htmlRenderer->render($parsedTree);
$latex = PhpLatex_Renderer_Abstract::toLatex($parsedTree);
//echo "Selesai";
//echo p
console_log($input);
echo $html;
?>
