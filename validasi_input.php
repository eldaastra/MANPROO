<?php
function validasiInput($nilai, $jenis, $dari, $ke) {
    $kelompok = [
        "panjang" => ["km","hm","dam","m","dm","cm","mm"],
        "berat"   => ["kg","hg","dag","g","dg","cg","mg"],
        "suhu"    => ["celsius","fahrenheit","kelvin"]
    ];
    if ($nilai === '') return "⚠️ Harap masukkan nilai sebelum konversi.";
    if (!is_numeric($nilai)) return "⚠️ Nilai harus berupa angka.";
    if (!isset($kelompok[$jenis])) return "⚠️ Jenis konversi tidak valid.";
    if ($dari === '' || $ke === '') return "⚠️ Pilih satuan asal dan tujuan.";
    if ($dari === $ke) return "⚠️ Satuan asal dan tujuan tidak boleh sama.";

    return null;
}
}
?>
