<?
session_start();
doInclude('modules/base/root/global.php');
doInclude('form_object.php');
doInclude('import_func.php');
//doInclude(getTemplate("words.inc"));
//--- FILE PHP UNTUK MENJALANKAN PERINTAH PENGAMBILAN KEHADIRAN SECARA OTOMATIS
//--- DIPANGGIL OLEH CRON, MEMBACA SESUAI SETTING
//---- INISIALISASI ----------------------------------------------------
//----------------------------------------------------------------------
//--- DAFTAR FUNSI------------------------------------------------------
$db = new CdbClass;
if ($db->connect()) {
    // ------ AMBIL DATA KRITERIA -------------------------
    getAttendanceData($db);
}
?>