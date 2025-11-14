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
            default:        $hasil = "Jenis konversi tidak valid.";
        }

        if (is_numeric($hasil)) {
            $hasil = "✅ <b>$nilai $dari = " . round($hasil, 4) . " $ke</b>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Konversi Satuan</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #a18cd1, #fbc2eb);
        height: 100vh;
        margin: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        animation: fadeIn 1s ease-in-out;
    }

    header {
        text-align: center;
        margin-bottom: 20px;
        animation: slideIn 1s ease;
    }

    header h1 {
        color: #2c2c2c;
        font-weight: 600;
        margin: 0;
        font-size: 34px;
        text-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    header h2 {
        color: #6541c1;
        margin-top: 8px;
        font-weight: 500;
        font-size: 18px;
    }

    .container {
        background: #ffffff;
        padding: 30px 25px;
        width: 420px;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    input, select, button {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border-radius: 10px;
        font-size: 15px;
        border: 1px solid #ccc;
        outline: none;
        transition: all 0.3s ease;
    }

    input:focus, select:focus {
        border-color: #7a5eff;
        box-shadow: 0 0 8px rgba(122, 94, 255, 0.3);
    }

    button {
        background: linear-gradient(90deg, #7a5eff, #5f33e1);
        color: white;
        border: none;
        cursor: pointer;
        font-size: 16px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    button:hover {
        background: linear-gradient(90deg, #6847e6, #5022cc);
        transform: scale(1.03);
    }

    .result-box {
        background: #f3f0ff;
        color: #2c2c2c;
        padding: 15px;
        border-left: 4px solid #7a5eff;
        border-radius: 10px;
        margin-top: 20px;
        text-align: center;
        font-size: 16px;
        font-weight: 500;
    }

    .error {
        background: #ffe6e6;
        color: #b30000;
        padding: 12px;
        border-left: 4px solid #e60000;
        border-radius: 8px;
        margin-top: 15px;
        text-align: center;
        font-weight: 500;
    }
</style>

<script>
function updateSatuan() {
    const jenis = document.getElementById("jenis").value;
    const dari = document.getElementById("dari");
    const ke = document.getElementById("ke");

    const satuan = {
        suhu: ['celsius', 'fahrenheit', 'kelvin'],
        panjang: ['km', 'hm', 'dam', 'm', 'dm', 'cm', 'mm'],
        berat: ['kg', 'hg', 'dag', 'g', 'dg', 'cg', 'mg']
    };

    dari.innerHTML = "";
    ke.innerHTML = "";

    if (satuan[jenis]) {
        satuan[jenis].forEach(s => {
            dari.innerHTML += `<option value="${s}">${s}</option>`;
            ke.innerHTML += `<option value="${s}">${s}</option>`;
        });
    }
}
</script>
</head>
<body>

<header>
    <h1>Konversi Satuan</h1>
    <h2>Suhu 🌡 | Panjang 📏 | Berat ⚖</h2>
</header>

<div class="container">
    <form method="POST">

        <select id="jenis" name="jenis" required onchange="updateSatuan()">
            <option value="">-- Pilih Jenis Konversi --</option>
            <option value="suhu" <?= $jenis=='suhu'?'selected':'' ?>>Suhu</option>
            <option value="panjang" <?= $jenis=='panjang'?'selected':'' ?>>Panjang</option>
            <option value="berat" <?= $jenis=='berat'?'selected':'' ?>>Berat</option>
        </select>

        <input type="number" step="0.01" name="nilai" placeholder="Masukkan nilai angka..." 
            value="<?= htmlspecialchars($nilai) ?>" required>

        <select id="dari" name="dari" required></select>
        <select id="ke" name="ke" required></select>

        <button type="submit">🚀 Konversi Sekarang</button>
    </form>

    <?php if ($hasil): ?>
        <div class="<?= strpos($hasil, '⚠') !== false ? 'error' : 'result-box' ?>">
            <?= $hasil ?>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    updateSatuan();
    <?php if ($dari): ?> document.getElementById("dari").value = "<?= $dari ?>"; <?php endif; ?>
    <?php if ($ke): ?> document.getElementById("ke").value = "<?= $ke ?>"; <?php endif; ?>
});
</script>

</body>
</html>
