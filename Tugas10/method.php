<?php
require_once "koneksi.php";

class Mahasiswa
{
    // GET ALL - Ambil semua data mahasiswa
    public function get_all_mahasiswa()
    {
        global $koneksi;

        $query  = "SELECT * FROM mahasiswa ORDER BY id ASC";
        $result = $koneksi->query($query);
        $data   = array();

        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }

        if (count($data) > 0) {
            $response = array(
                'status'  => 1,
                'message' => 'Get All Mahasiswa Successfully.',
                'total'   => count($data),
                'data'    => $data
            );
        } else {
            $response = array(
                'status'  => 0,
                'message' => 'Data mahasiswa tidak ditemukan.',
                'data'    => $data
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // GET BY ID - Ambil satu data mahasiswa berdasarkan ID
    public function get_mahasiswa($id = 0)
    {
        global $koneksi;

        $query  = "SELECT * FROM mahasiswa WHERE id = " . intval($id) . " LIMIT 1";
        $result = $koneksi->query($query);
        $data   = array();

        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }

        if (count($data) > 0) {
            $response = array(
                'status'  => 1,
                'message' => 'Get Mahasiswa Successfully.',
                'data'    => $data[0]
            );
        } else {
            $response = array(
                'status'  => 0,
                'message' => 'Mahasiswa dengan ID ' . $id . ' tidak ditemukan.'
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // Endpoint : POST /mahasiswa
    public function insert_mahasiswa()
    {
        global $koneksi;

        // Field yang wajib diisi
        $required_fields = array('nim' => '', 'nama' => '', 'jurusan' => '', 'semester' => '');
        $count_match     = count(array_intersect_key($_POST, $required_fields));

        if ($count_match == count($required_fields)) {

            $nim      = mysqli_real_escape_string($koneksi, $_POST['nim']);
            $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
            $jurusan  = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
            $semester = intval($_POST['semester']);
            $ipk      = isset($_POST['ipk'])   ? floatval($_POST['ipk'])   : 0.00;
            $email    = isset($_POST['email']) ? mysqli_real_escape_string($koneksi, $_POST['email']) : '';

            // Cek NIM sudah ada atau belum
            $cek = $koneksi->query("SELECT id FROM mahasiswa WHERE nim = '$nim'");
            if ($cek->num_rows > 0) {
                $response = array(
                    'status'  => 0,
                    'message' => 'NIM ' . $nim . ' sudah terdaftar. (Conflict 409)'
                );
                http_response_code(409);
                header('Content-Type: application/json');
                echo json_encode($response);
                return;
            }

            $result = mysqli_query($koneksi,
                "INSERT INTO mahasiswa SET
                    nim      = '$nim',
                    nama     = '$nama',
                    jurusan  = '$jurusan',
                    semester = '$semester',
                    ipk      = '$ipk',
                    email    = '$email'"
            );

            if ($result) {
                http_response_code(201);
                $response = array(
                    'status'  => 1,
                    'message' => 'Mahasiswa berhasil ditambahkan.',
                    'id'      => $koneksi->insert_id
                );
            } else {
                http_response_code(500);
                $response = array(
                    'status'  => 0,
                    'message' => 'Mahasiswa gagal ditambahkan.'
                );
            }
        } else {
            http_response_code(400);
            $response = array(
                'status'  => 0,
                'message' => 'Parameter tidak lengkap. Field wajib: nim, nama, jurusan, semester.'
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // PUT / POST with ID - Update data mahasiswa
    public function update_mahasiswa($id)
    {
        global $koneksi;

        // Cek apakah mahasiswa dengan ID tersebut ada
        $cek = $koneksi->query("SELECT id FROM mahasiswa WHERE id = " . intval($id));
        if ($cek->num_rows == 0) {
            http_response_code(404);
            $response = array(
                'status'  => 0,
                'message' => 'Mahasiswa dengan ID ' . $id . ' tidak ditemukan.'
            );
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $required_fields = array('nim' => '', 'nama' => '', 'jurusan' => '', 'semester' => '');
        $count_match     = count(array_intersect_key($_POST, $required_fields));

        if ($count_match == count($required_fields)) {

            $nim      = mysqli_real_escape_string($koneksi, $_POST['nim']);
            $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
            $jurusan  = mysqli_real_escape_string($koneksi, $_POST['jurusan']);
            $semester = intval($_POST['semester']);
            $ipk      = isset($_POST['ipk'])   ? floatval($_POST['ipk'])   : 0.00;
            $email    = isset($_POST['email']) ? mysqli_real_escape_string($koneksi, $_POST['email']) : '';

            $result = mysqli_query($koneksi,
                "UPDATE mahasiswa SET
                    nim      = '$nim',
                    nama     = '$nama',
                    jurusan  = '$jurusan',
                    semester = '$semester',
                    ipk      = '$ipk',
                    email    = '$email'
                 WHERE id = '$id'"
            );

            if ($result) {
                $response = array(
                    'status'  => 1,
                    'message' => 'Data mahasiswa ID ' . $id . ' berhasil diperbarui.'
                );
            } else {
                http_response_code(500);
                $response = array(
                    'status'  => 0,
                    'message' => 'Data mahasiswa gagal diperbarui.'
                );
            }
        } else {
            http_response_code(400);
            $response = array(
                'status'  => 0,
                'message' => 'Parameter tidak lengkap. Field wajib: nim, nama, jurusan, semester.'
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    // DELETE - Hapus data mahasiswa
    public function delete_mahasiswa($id)
    {
        global $koneksi;

        // Cek apakah mahasiswa dengan ID tersebut ada
        $cek = $koneksi->query("SELECT id FROM mahasiswa WHERE id = " . intval($id));
        if ($cek->num_rows == 0) {
            http_response_code(404);
            $response = array(
                'status'  => 0,
                'message' => 'Mahasiswa dengan ID ' . $id . ' tidak ditemukan.'
            );
            header('Content-Type: application/json');
            echo json_encode($response);
            return;
        }

        $query = "DELETE FROM mahasiswa WHERE id = " . intval($id);

        if (mysqli_query($koneksi, $query)) {
            $response = array(
                'status'  => 1,
                'message' => 'Mahasiswa ID ' . $id . ' berhasil dihapus.'
            );
        } else {
            http_response_code(500);
            $response = array(
                'status'  => 0,
                'message' => 'Mahasiswa ID ' . $id . ' gagal dihapus.'
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
?>