<?php
session_start();
require_once '../koneksi.php';
require_once '../vendor/autoload.php';

if (!isset($_SESSION['pelanggan'])) {
    header("Location: login_pengguna.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: riwayat_sewa.php");
    exit();
}

$id_penyewaan = $_GET['id'];
$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];

$query_detail_pemesanan = "SELECT penyewaan.*, skuter.gambar AS gambar, pelanggan.Nama AS nama_pelanggan, skuter.Merek, skuter.Tipe
                           FROM penyewaan 
                           JOIN skuter ON penyewaan.ID_Skuter = skuter.ID_Skuter 
                           JOIN pelanggan ON penyewaan.ID_Pelanggan = pelanggan.id_pelanggan 
                           WHERE penyewaan.ID_Penyewaan = $id_penyewaan 
                           AND penyewaan.ID_Pelanggan = $id_pelanggan";
$result_detail_pemesanan = mysqli_query($db, $query_detail_pemesanan);

if (mysqli_num_rows($result_detail_pemesanan) == 0) {
    header("Location: riwayat_sewa.php");
    exit();
}

$row = mysqli_fetch_assoc($result_detail_pemesanan);

// Generate HTML for table
$html = '<table border="1">
            <tr>
                <th>Nama Pelanggan</th>
                <td>' . $row['nama_pelanggan'] . '</td>
            </tr>
            <tr>
                <th>Tanggal Sewa</th>
                <td>' . $row['tanggal_sewa'] . '</td>
            </tr>
            <tr>
                <th>Merek Skuter</th>
                <td>' . $row['Merek'] . '</td>
            </tr>
            <tr>
                <th>Tipe Skuter</th>
                <td>' . $row['Tipe'] . '</td>
            </tr>
            <tr>
                <th>Durasi Sewa</th>
                <td>' . $row['durasi_sewa'] . ' Menit</td>
            </tr>
            <tr>
                <th>Total Bayar</th>
                <td>' . $row['total_bayar'] . '</td>
            </tr>
            <tr>
                <th>Bukti Pembayaran</th>
                <td><img src="../bukti_pembayaran/' . $row['bukti_pembayaran'] . '" alt="Bukti Pembayaran"></td>
            </tr>
            <tr>
                <th>Status Pembayaran</th>
                <td>' . $row['status_pembayaran'] . '</td>
            </tr>
        </table>';

// Include TCPDF library
require_once('../vendor/tecnickcom/tcpdf/tcpdf.php');

// Create new TCPDF object
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Detail Pemesanan');
$pdf->SetSubject('Detail Pemesanan');
$pdf->SetKeywords('Pemesanan, Detail, PDF');

// Set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 009', PDF_HEADER_STRING);

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('times', 'BI', 20);

// Add HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('detail_pemesanan.pdf', 'I');
