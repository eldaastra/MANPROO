<?php
include 'validasi_input.php';
include 'logic_konversi.php';

$hasil = "";
$nilai = $_POST["nilai"] ?? '';
$jenis = $_POST["jenis"] ?? '';
$dari  = $_POST["dari"] ?? '';
$ke    = $_POST["ke"] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $validasi = validasiInput($nilai, $jenis, $dari, $ke);

    if ($validasi !== null) {
        $hasil = $validasi;
    } else {
        switch ($jenis) {
            case "panjang": $hasil = konversiPanjang($nilai, $dari, $ke); break;
            case "berat":   $hasil = konversiBerat($nilai, $dari, $ke); break;
            case "suhu":    $hasil = konversiSuhu($nilai, $dari, $ke); break;
            default:        $hasil = "⚠ Jenis konversi tidak valid.";
        }

        if (is_numeric($hasil)) {
            $hasil = "✅ <b>$nilai $dari = " . round($hasil, 4) . " $ke</b>";
        } elseif ($hasil == "error_satuan") {
            $hasil = "⚠ Maaf, Anda salah memilih satuan.";
        }
    }
}
?>

