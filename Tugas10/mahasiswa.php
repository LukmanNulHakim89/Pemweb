<?php
require_once "method.php";

$obj_mahasiswa  = new Mahasiswa();
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {

    case 'GET':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            $obj_mahasiswa->get_mahasiswa($id);
        } else {
            $obj_mahasiswa->get_all_mahasiswa();
        }
        break;

    case 'POST':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            $obj_mahasiswa->update_mahasiswa($id);
        } else {
            $obj_mahasiswa->insert_mahasiswa();
        }
        break;

    // DELETE /mahasiswa/{id} -> Hapus data by ID
    case 'DELETE':
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            $obj_mahasiswa->delete_mahasiswa($id);
        } else {
            http_response_code(400);
            header('Content-Type: application/json');
            echo json_encode(array(
                'status'  => 0,
                'message' => 'ID mahasiswa wajib disertakan untuk operasi DELETE.'
            ));
        }
        break;

    default:
        http_response_code(405);
        header('Content-Type: application/json');
        echo json_encode(array(
            'status'  => 0,
            'message' => 'HTTP Method tidak diizinkan. Gunakan GET, POST, atau DELETE.'
        ));
        break;
}
?>
