<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tes Radiologi</title>
	<script type="text/javascript" src="../theme/js/ajax.js"></script>
</head>
<body>
<button id="btnRadView" onclick="ShowStudyPx('view')">Tes View</button>&nbsp;&nbsp;<button id="btnRadData" onclick="ShowStudyPx('data')">Tes Data</button>
<br />
<div id="div_rad"></div>
</body>
<script>
function ShowStudyPx(tipe){
	alert(tipe);
	Request("tes_rad_utils.php?remoteAE=DCM4CHEE@localhost:11112&act=list&QueryLevel=IMAGE&Modality=&PatientId=XsaDYa&PatientName=&StudyId=&StudyIuid=&SeriesIuid=1.2.840.113704.1.111.4848.1161868385.1&SOPIuid=&tipe="+tipe, "div_rad", "", "GET");
}
</script>
</html>