<?php
// =====================================================
// 🔹 BAGIAN LOGIKA KONVERSI 
// =====================================================
function konversiPanjang($nilai, $dari, $ke) {
    $satuan = ["km"=>1000,"hm"=>100,"dam"=>10,"m"=>1,"dm"=>0.1,"cm"=>0.01,"mm"=>0.001];
    if (!isset($satuan[$dari]) || !isset($satuan[$ke])) return "error_satuan";
    $meter = $nilai * $satuan[$dari];
    return $meter / $satuan[$ke];
}

function konversiBerat($nilai, $dari, $ke) {
    $satuan = ["kg"=>1000,"hg"=>100,"dag"=>10,"g"=>1,"dg"=>0.1,"cg"=>0.01,"mg"=>0.001];
    if (!isset($satuan[$dari]) || !isset($satuan[$ke])) return "error_satuan";
    $gram = $nilai * $satuan[$dari];
    return $gram / $satuan[$ke];
}

function konversiSuhu($nilai, $dari, $ke) {
    if ($dari == $ke) return $nilai;

    // Ubah ke Celsius dulu
    switch ($dari) {
        case "F": $nilai = ($nilai - 32) * 5/9; break;
        case "K": $nilai = $nilai - 273.15; break;
    }

    // Ubah dari Celsius ke target satuan
    switch ($ke) {
        case "F": return ($nilai * 9/5) + 32;
        case "K": return $nilai + 273.15;
        default: return $nilai;
    }
}
?>
