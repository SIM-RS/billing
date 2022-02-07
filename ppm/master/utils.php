<?php

require '../function/connection.php';
$konek = new Connection();

$name = $_REQUEST['nama'];
$id = $_REQUEST['id'];
$act = $_REQUEST['act'];

switch ($act) {
    case 'simpanRuangan':
        $sql = "INSERT INTO ppi_ruangan(nama_ruangan) VALUES('{$name}')";
        if ($konek->rawQuery($sql)) {
            echo json_encode(200);
        } else {
            echo json_encode(500);
        }
        break;
    case 'simpanIpcn':
        $sql = "INSERT INTO ppi_ipcn(nama) VALUES('{$name}')";
        if ($konek->rawQuery($sql)) {
            echo json_encode(200);
        } else {
            echo json_encode(500);
        }
        break;
    case 'editRuangan':
        $sql = "UPDATE ppi_ruangan SET nama_ruangan = '{$name}' WHERE id = {$id}";

        if ($konek->rawQuery($sql)) echo json_encode(200);
        else echo json_encode(500);
        break;
    case 'editIpcn':
        $sql = "UPDATE ppi_ipcn SET nama = '{$name}' WHERE id = {$id}";

        if ($konek->rawQuery($sql)) echo json_encode(200);
        else echo json_encode(500);
        break;
    case 'deleteRuangan':
        $sql = "DELETE FROM ppi_ruangan WHERE id = {$id}";
        if ($konek->rawQuery($sql)) echo json_encode(200);
        else echo json_encode(500);
        break;
    case 'deleteIpcn':
        $sql = "DELETE FROM ppi_ipcn WHERE id = {$id}";
        if ($konek->rawQuery($sql)) echo json_encode(200);
        else echo json_encode(500);
        break;
    case 'getDataRuangan' :
        $sql = "SELECT * FROM ppi_ruangan";
        $data = $konek->rawQuery($sql);
        $no = 0;
        while($rows = $data->fetch_assoc()){
            echo '<tr>';
                echo '<td>'.++$no.'</td>';
                echo '<td>'.$rows['nama_ruangan'].'</td>';
                echo '<td><button class="btn btn-sm btn-danger" type="button" value="'.$rows['id'] .'" onclick="deleteData(this.value)">Delete</button>
                <button class="btn btn-sm btn-primary" type="button" value="'.$rows['id'] . '|' . $rows['nama_ruangan'].'" onclick="edit(this.value)">Edit</button></td>';
            echo '</tr>';
        }
    case 'getDataIpcn' :
        $sql = "SELECT * FROM ppi_ipcn";
        $data = $konek->rawQuery($sql);
        $no = 0;
        while($rows = $data->fetch_assoc()){
            echo '<tr>';
                echo '<td>'.++$no.'</td>';
                echo '<td>'.$rows['nama'].'</td>';
                echo '<td><button class="btn btn-sm btn-danger" type="button" value="'.$rows['id'] .'" onclick="deleteData(this.value)">Delete</button>
                <button class="btn btn-sm btn-primary" type="button" value="'.$rows['id'] . '|' . $rows['nama'].'" onclick="edit(this.value)">Edit</button></td>';
            echo '</tr>';
        }
}
