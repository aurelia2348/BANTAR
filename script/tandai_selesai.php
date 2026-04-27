<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['sewa_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$sewa_id      = (int)$_POST['sewa_id'];
$actual_date  = $_POST['actual_date'] ?? date('Y-m-d');
$denda_late   = (float)($_POST['late_fee']  ?? 0);
$denda_other  = (float)($_POST['other_fee'] ?? 0);
$other_fee_map= json_decode($_POST['other_fee_map'] ?? '{}', true);
$total_denda  = $denda_late + $denda_other;

// ── Validate sewa ─────────────────────────────────────────────────────────────
$sewa = mysqli_fetch_assoc(
    mysqli_query($koneksi, "SELECT * FROM sewa WHERE id = $sewa_id")
);

if (!$sewa) {
    echo json_encode(['success' => false, 'message' => 'Transaksi tidak ditemukan']);
    exit;
}
if ($sewa['status'] !== 'dipinjam') {
    echo json_encode(['success' => false, 'message' => 'Transaksi sudah selesai']);
    exit;
}

// ── Hitung hari sewa ──────────────────────────────────────────────────────────
$d1        = new DateTime($sewa['tanggal_sewa']);
$d2        = new DateTime($sewa['tanggal_kembali']);
$days_rent = max(1, (int)$d1->diff($d2)->days);

// ── Ambil semua detail_sewa + info kostum ────────────────────────────────────
$det_result = mysqli_query($koneksi, "
    SELECT ds.*,
           sk.kategori,
           sk.rental_model_price AS harga_model_db
    FROM detail_sewa ds
    JOIN stok_kostum sk ON sk.id = ds.kostum_id
    WHERE ds.sewa_id = $sewa_id
");
$details = [];
while ($d = mysqli_fetch_assoc($det_result)) {
    $details[] = $d;
}

// ── Hitung share per item ─────────────────────────────────────────────────────
/*  Logika:
 *  KOSTUM KARNAVAL:
 *    bantar_share  += rental_fee_item   (harga sewa × qty × hari)
 *    model_share   += model_fee_item    (harga_model × jml_model × hari_model)
 *    designer_share = 0
 *    denda → bantar_share
 *
 *  BUSANA DESAINER:
 *    designer_share += 90% × rental_fee_item + denda
 *    bantar_share   += 10% × rental_fee_item
 *    model_share     = 0
 *    denda → designer_share
 *
 *  MIXED: denda → bantar_share (bantar sebagai kolektor)
 */

$rental_fee_total = 0;   // total sewa kostum (tanpa model)
$model_fee_total  = 0;   // total model fee
$bantar_share     = 0.0;
$designer_share   = 0.0;
$model_share      = 0.0;

$has_karnaval  = false;
$has_desainer  = false;

$total_qty = 0;
foreach ($details as $d) {
    $total_qty += (int)$d['qty'];
}
$denda_late_per_qty = $total_qty > 0 ? ($denda_late / $total_qty) : 0;

foreach ($details as $d) {
    $is_karnaval = (stripos($d['kategori'], 'karnaval') !== false);
    $ds_id = (int)$d['id'];

    $rental_item = (float)$d['harga'] * (int)$d['qty'] * $days_rent;
    $model_item  = 0.0;
    if ((int)$d['include_model'] && (int)$d['jumlah_model'] > 0 && (int)$d['hari_model'] > 0) {
        $model_item = (float)$d['harga_model_db'] * (int)$d['jumlah_model'] * (int)$d['hari_model'];
    }

    $item_other_denda = isset($other_fee_map[$ds_id]) ? (float)$other_fee_map[$ds_id] : 0;
    $item_late_denda  = $denda_late_per_qty * (int)$d['qty'];
    
    $item_total_denda = $item_late_denda + $item_other_denda;

    $rental_fee_total += $rental_item;
    $model_fee_total  += $model_item;

    if ($is_karnaval) {
        $has_karnaval   = true;
        $bantar_share  += $rental_item + $item_total_denda;
        $model_share   += $model_item;
    } else {
        $has_desainer   = true;
        $designer_share += (0.9 * $rental_item) + $item_total_denda;
        $bantar_share   += 0.1 * $rental_item;
    }
}


// ── Total pemasukan ───────────────────────────────────────────────────────────
$rental_fee_col    = (float)$sewa['total_harga']; // sudah include model fees
$total_pemasukan   = $rental_fee_col + $total_denda;
$today             = date('Y-m-d');
$tgl_seharusnya    = $sewa['tanggal_kembali'];

// ── Database transaction ──────────────────────────────────────────────────────
mysqli_begin_transaction($koneksi);

try {

    // 1. Update status sewa
    $st = mysqli_prepare($koneksi, "UPDATE sewa SET status = 'selesai' WHERE id = ?");
    mysqli_stmt_bind_param($st, 'i', $sewa_id);
    mysqli_stmt_execute($st);
    mysqli_stmt_close($st);

    // 1.5. Update detail_sewa denda_lain
    foreach ($other_fee_map as $ds_id => $val) {
        $val = (float)$val;
        $ds_id = (int)$ds_id;
        mysqli_query($koneksi, "UPDATE detail_sewa SET denda_lain = $val WHERE id = $ds_id");
    }

    // 2. Insert pengembalian
    $pen = mysqli_prepare($koneksi, "
        INSERT INTO pengembalian
            (sewa_id, tanggal_kembali_seharusnya, tanggal_kembali_sebenarnya,
             denda_keterlambatan, denda_lain, total_denda)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    mysqli_stmt_bind_param($pen, 'issddd',
        $sewa_id,
        $tgl_seharusnya,
        $actual_date,
        $denda_late,
        $denda_other,
        $total_denda
    );
    mysqli_stmt_execute($pen);
    mysqli_stmt_close($pen);

    // 3. Insert laporan_keuangan
    $lk = mysqli_prepare($koneksi, "
        INSERT INTO laporan_keuangan
            (sewa_id, tanggal_transaksi,
             denda_keterlambatan, denda_lain, rental_fee,
             total_pemasukan,
             bantar_share, designer_share, model_share)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    mysqli_stmt_bind_param($lk, 'isddddddd',
        $sewa_id,
        $actual_date,
        $denda_late,
        $denda_other,
        $rental_fee_col,
        $total_pemasukan,
        $bantar_share,
        $designer_share,
        $model_share
    );
    mysqli_stmt_execute($lk);
    mysqli_stmt_close($lk);

    // 4. Restore stok kostum
    foreach ($details as $d) {
        $k_id = (int)$d['kostum_id'];
        $qty  = (int)$d['qty'];
        mysqli_query($koneksi,
            "UPDATE stok_kostum SET jumlah = jumlah + $qty WHERE id = $k_id"
        );
    }

    mysqli_commit($koneksi);

    echo json_encode([
        'success'        => true,
        'total_denda'    => $total_denda,
        'bantar_share'   => round($bantar_share,   2),
        'designer_share' => round($designer_share, 2),
        'model_share'    => round($model_share,    2),
        'total_pemasukan'=> round($total_pemasukan,2),
    ]);

} catch (Exception $e) {
    mysqli_rollback($koneksi);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
