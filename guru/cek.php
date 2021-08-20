<?php
include_once '../function/core.php';

$id_mapel =  @$_SESSION['mapel_id'];
$sms = @$_SESSION['semester'];

$sql = "SELECT * FROM tbl_mapel JOIN tbl_kkm ON tbl_mapel.kode_mapel = tbl_kkm.kode_mapel WHERE tbl_mapel.id = '$id_mapel'";
$sqlmap = mysqli_query($link, $sql);
$map = mysqli_fetch_object($sqlmap);
$kkm = $map->kkm;
$kode = $map->kode_mapel;

if ($kkm == 70) {
	$pred_A = array(91, 92, 93, 94, 95, 96, 97, 98, 99, 100);
	$pred_B = array(81, 82, 83, 84, 85, 86, 87, 88, 89, 90);
	$pred_C = array(70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80);
} elseif($kkm == 75) {
	$pred_A = array(92, 93, 94, 95, 96, 97, 98, 99, 100);
	$pred_B = array(84, 85, 86, 87, 88, 89, 90, 91);
	$pred_C = array(75, 76, 77, 78, 79, 80, 81, 82, 83);
} elseif($kkm == 76) {
	$pred_A = array(92, 93, 94, 95, 96, 97, 98, 99, 100);
	$pred_B = array(84, 85, 86, 87, 88, 89, 90, 91);
	$pred_C = array(76, 77, 78, 79, 80, 81, 82, 83);
} elseif($kkm == 77) {
	$pred_A = array(93, 94, 95, 96, 97, 98, 99, 100);
	$pred_B = array(85, 86, 87, 88, 89, 90, 91, 92);
	$pred_C = array(77, 78, 79, 80, 81, 82, 83, 84);
} elseif($kkm == 78) {
	$pred_A = array(93, 94, 95, 96, 97, 98, 99, 100);
	$pred_B = array(85, 86, 87, 88, 89, 90, 91, 92);
	$pred_C = array(78, 79, 80, 81, 82, 83, 84);
} elseif($kkm == 80) {
	$pred_A = array(94, 95, 96, 97, 98, 99, 100);
	$pred_B = array(87, 88, 89, 90, 91, 92, 93);
	$pred_C = array(80, 81, 82, 83, 84, 85, 86);
}

$q = @$_GET['q'];

if ($q == "pth") {
	$p_angka = @$_POST['p_angka'];

	if (in_array($p_angka, $pred_A)) {
		$pred = "A";
	} elseif (in_array($p_angka, $pred_B)) {
		$pred = "B";
	} elseif (in_array($p_angka, $pred_C)) {
		$pred = "C";
	} else {
		die(0);
	}

	$sqldes = select("*", "tbl_deskripsi_pth", "kode_mapel = '$kode' AND predikat = '$pred' AND semester = '$sms'");
	$des = mysqli_fetch_object($sqldes);
	$cek = mysqli_num_rows($sqldes);

	if ($cek > 0) {
		$data = array(
			'predikat' => $pred,
			'deskripsi' => $des->deskripsi
			);
		$data[] = $data;

		echo json_encode($data);			
	} else {
		echo "";
	}
} else if($q == "ktr") {
	$k_angka = @$_POST['k_angka'];

	if (in_array($k_angka, $pred_A)) {
		$pred = "A";
	} elseif (in_array($k_angka, $pred_B)) {
		$pred = "B";
	} elseif (in_array($k_angka, $pred_C)) {
		$pred = "C";
	} else {
		die(0);
	}

	$sqldes = select("*", "tbl_deskripsi_ktr", "kode_mapel = '$kode' AND predikat = 'C'  AND semester = '$sms'");
	$des = mysqli_fetch_object($sqldes);
	$cek = mysqli_num_rows($sqldes);

	if ($cek > 0) {
		$data = array(
			'predikat' => $pred,
			'deskripsi' => $des->deskripsi
			);
		$data[] = $data;

		echo json_encode($data);			
	} else {
		echo "";
	}
} else if($q == "otr") {
	$pred = "C";
	$data = anti_inject($_POST['core']);

	$sqldes = select("*", "tbl_deskripsi_".$data, "kode_mapel = '$kode' AND predikat = 'C'  AND semester = '$sms'");
	$des = mysqli_fetch_object($sqldes);
	$cek = mysqli_num_rows($sqldes);

	if ($cek > 0) {
		$data = array(
			'predikat' => $pred,
			'deskripsi' => $des->deskripsi
			);
		$data[] = $data;

		echo json_encode($data);			
	} else {
		echo "";
	}
} else if($q == "edit") {
	$id_siswa = anti_inject($_POST['s_id']);
	$id_mapel = anti_inject($_SESSION['mapel_id']);

    $p_angka    = $_POST['p_agk'];
    $p_predikat = $_POST['p_pre'];
    $k_angka    = $_POST['k_agk'];
    $k_predikat = $_POST['k_pre'];

    $update = update('tbl_rapot', "p_angka = '$p_angka', p_predikat = '$p_predikat', k_angka = '$k_angka', k_predikat = '$k_predikat'", "id_siswa = '$id_siswa' AND id_mapel = '$id_mapel'");
    //$update = TRUE;

    if ($update === TRUE) {
    	echo "true";
    } else {
    	echo "false";
    }
} else if ($q == "add") {
	$id_siswa 	= anti_inject($_POST['s_id']);
	$id_mapel 	= anti_inject($_SESSION['mapel_id']);
	$id_kelas 	= anti_inject($_SESSION['kelas_id']);
	$semester   = anti_inject($_SESSION['semester']);
	$id_guru 	= anti_inject($_SESSION['guru']['id']);
    $p_angka    = anti_inject($_POST['p_agk']);
    $p_predikat = anti_inject($_POST['p_pre']);
    $k_angka    = anti_inject($_POST['k_agk']);
    $k_predikat = anti_inject($_POST['k_pre']);

    $insert = insert('tbl_rapot', "id, id_siswa, id_kelas, id_guru, id_mapel, semester, p_angka, p_predikat, k_angka, k_predikat", "NULL, '$id_siswa', '$id_kelas', '$id_guru', '$id_mapel', '$semester', '$p_angka', '$p_predikat', '$k_angka', '$k_predikat'");
 
    //($insert === TRUE) ? echo "true"; : echo "false";
   if ($insert === TRUE) {
    	echo "true";
    } else {
    	echo "false";
    }

}

?>