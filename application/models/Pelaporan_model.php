<?php
class Pelaporan_model extends CI_Model
{
    // public function add_pelaporan()
    // {
    //     $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    //     $user_id = $this->session->userdata('id_user');
    //     date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
    //     $now = date('Y-m-d');



    //     $query = "INSERT INTO pelaporan ( user_id,waktu_pelaporan, perihal, file, nama, no_tiket, kategori, tags, judul) select  user_id, '$now',perihal, file, nama, no_tiket, kategori, tags, judul
    //                 from tiket_temp 
    //                 where user_id = $user_id 
    //                 ";
    //     // $query2 = "DELETE FROM barang_temp where user_id = $user_id";

    //     $this->db->query($query);
    //     // $this->db->delete($query2);
    // }

    public function add_pelaporan()
    {
        // Get user data from the session
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        // Set the timezone and get the current date
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        // Retrieve data from tiket_temp for the given user
        $this->db->select('user_id, perihal, file, nama, no_tiket, kategori, tags, judul');
        $this->db->from('tiket_temp');
        $this->db->where('user_id', $user_id);
        $tiket_temp_data = $this->db->get()->result_array();

        // Insert the retrieved data into pelaporan
        foreach ($tiket_temp_data as $row) {
            $data_to_insert = [
                'user_id' => $row['user_id'],
                'waktu_pelaporan' => $now,
                'perihal' => $row['perihal'],
                'file' => $row['file'],
                'nama' => $row['nama'],
                'no_tiket' => $row['no_tiket'],
                'kategori' => $row['kategori'],
                'tags' => $row['tags'],
                'judul' => $row['judul']
            ];

            $this->db->insert('pelaporan', $data_to_insert);
        }

        // Optionally delete the data from tiket_temp after insertion
        // $this->db->delete('tiket_temp', ['user_id' => $user_id]);
    }


    public function delete_pelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        $query = "DELETE FROM tiket_temp where user_id = $user_id
                    ";
        // $query2 = "DELETE FROM barang_temp where user_id = $user_id";
        $this->db->query($query);
    }

    public function has_unrated_finished_tickets($user_id)
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        $this->db->where('user_id', $user_id);
        $this->db->where('status_ccs', 'FINISHED'); // Status tiket yang sudah selesai
        $this->db->group_start();
        $this->db->where('rating', '0');
        $this->db->or_where('rating IS NULL');
        $this->db->group_end();
        $query = $this->db->get('pelaporan');

        return $query->num_rows() > 0;
    }

    // fungsi cek klien sudah rating atau belum
    // public function has_unrated_finished_tickets($user_id)
    // {
    //     $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
    //     $user_id = $this->session->userdata('id_user');

    //     $this->db->where('user_id', $user_id);
    //     $this->db->where('status_ccs', 'FINISHED'); // Status tiket yang sudah selesai
    //     $this->db->where_in('rating', ['0', 'Null']); // Tiket yang belum diberi rating
    //     $query = $this->db->get('pelaporan');

    //     return $query->num_rows() > 0;
    // }

    function updateCP($id_pelaporan, $data)
    {
        $this->db->where('id_pelaporan', $id_pelaporan);
        $this->db->update('pelaporan', $data);
    }

    function updateImpact($id_pelaporan, $data)
    {
        $this->db->where('id_pelaporan', $id_pelaporan);
        $this->db->update('pelaporan', $data);
    }

    // update finish HELPDESK
    function updateHD($id, $data)
    {
        $this->db->where('id_pelaporan', $id);
        $this->db->update('pelaporan', $data);
    }


    // APPROVE SPV
    function approveSPV($id, $data)
    {
        $this->db->where('id_pelaporan', $id);
        $this->db->update('pelaporan', $data);
    }

    // REJECT HD1
    function rejecthd1($id, $data)
    {
        $this->db->where('id_pelaporan', $id);
        $this->db->update('pelaporan', $data);
    }



    // forward to implementator

    function updateForward($id, $data)
    {
        $this->db->where('id_pelaporan', $id);
        $this->db->update('pelaporan', $data);
    }

    //FINISH IMPLEMENTATOR
    function updateImplementator($id, $data)
    {
        $this->db->where('id_pelaporan', $id);
        $this->db->update('pelaporan', $data);
    }

    //LAPORAN status
    public function getAll()
    {
        // Build the query using Query Builder
        $this->db->select('
            pelaporan.no_tiket,
            pelaporan.waktu_pelaporan,
            pelaporan.id_pelaporan,
            pelaporan.kategori,
            pelaporan.status,
            pelaporan.status_ccs,
            pelaporan.priority,
            pelaporan.perihal,
            pelaporan.handle_by,
            pelaporan.nama,
            pelaporan.user_id,
            pelaporan.tags,
            user.nama_user,
            pelaporan.maxday,
            pelaporan.impact
        ');
        $this->db->from('pelaporan');
        $this->db->join('user', 'pelaporan.user_id = user.id_user', 'left');
        $this->db->where('pelaporan.status_ccs', 'FINISHED');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        // Execute the query and return the result
        return $this->db->get()->result_array();
    }

    public function getDate($tanggal_awal = null, $tanggal_akhir = null, $status_ccs = null, $nama_klien = null, $nama_user = null, $rating = null, $tags = null)
    {
        $this->db->select('*');
        $this->db->from('pelaporan');

        if (!empty($tanggal_awal)) {
            $this->db->where('waktu_pelaporan >=', $tanggal_awal);
        }

        if (!empty($tanggal_akhir)) {
            $this->db->where('waktu_pelaporan <=', $tanggal_akhir);
        }

        if (!empty($status_ccs)) {
            $this->db->where('status_ccs', $status_ccs);
        }

        if (!empty($nama_klien)) {
            $this->db->where('nama', $nama_klien);
        }

        if (!empty($nama_user)) {
            $this->db->group_start();
            $this->db->like('handle_by', $nama_user);
            $this->db->or_like('handle_by2', $nama_user);
            $this->db->or_like('handle_by3', $nama_user);
            $this->db->group_end();
        }

        if (!empty($tags)) {
            $this->db->where('tags', $tags);
        }

        if (!empty($tags)) {
            $this->db->where('rating', $tags);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function getDateFiltered($tanggal_awal = null, $tanggal_akhir = null, $nama_klien = null, $nama_user = null,   $status_ccs = null, $rating = null)
    {
        $this->db->select('*');
        $this->db->from('pelaporan'); // Sesuaikan dengan nama tabel yang sesuai

        // Filter berdasarkan tanggal_awal dan tanggal_akhir jika ada
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $this->db->where('waktu_pelaporan >=', $tanggal_awal);
            $this->db->where('waktu_pelaporan <=', $tanggal_akhir);
        }

        // Filter berdasarkan nama_klien jika ada
        if (!empty($nama_klien)) {
            $this->db->like('nama', $nama_klien);
        }

        // Filter berdasarkan nama_user jika ada
        if (!empty($nama_user)) {
            $this->db->group_start();
            $this->db->like('handle_by', $nama_user);
            $this->db->or_like('handle_by2', $nama_user);
            $this->db->or_like('handle_by3', $nama_user);
            $this->db->group_end();
        }

        if (!empty($status_ccs)) {
            $this->db->where('status_ccs', $status_ccs);
        }

        if (!empty($rating)) {
            $this->db->where('rating', $rating);
        }

        $query = $this->db->get();
        return $query->result(); // Mengembalikan hasil query
    }

    public function getDateFilteredHandle($tanggal_awal = null, $tanggal_akhir = null, $nama_klien = null, $nama_user = null,   $status_ccs = null, $rating = null)
    {
        $this->db->select('*');
        $this->db->from('pelaporan'); // Sesuaikan dengan nama tabel yang sesuai

        // Filter berdasarkan tanggal_awal dan tanggal_akhir jika ada
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $this->db->where('waktu_pelaporan >=', $tanggal_awal);
            $this->db->where('waktu_pelaporan <=', $tanggal_akhir);
        }

        // Filter berdasarkan nama_klien jika ada
        if (!empty($nama_klien)) {
            $this->db->like('nama', $nama_klien);
        }

        // Filter berdasarkan nama_user jika ada
        if (!empty($nama_user)) {
            $this->db->group_start();
            $this->db->like('handle_by', $nama_user);
            $this->db->or_like('handle_by2', $nama_user);
            $this->db->or_like('handle_by3', $nama_user);
            $this->db->group_end();
        }

        if (!empty($status_ccs)) {
            $this->db->where_in('status_ccs', $status_ccs);
        }

        if (!empty($rating)) {
            $this->db->where('rating', $rating);
        }

        $query = $this->db->get();
        return $query->result(); // Mengembalikan hasil query
    }

    // Rekap pelaporan per user helpdesk
    public function getDateH($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $tags)
    {
        $user_id = $this->session->userdata('id_user');

        $this->db->select('pelaporan.*'); // Select fields from both tables
        $this->db->from('forward'); // Specify the base table
        $this->db->join('pelaporan', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('forward.user_id', $user_id);
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC'); // Order by waktu_pelaporan in descending order

        // Apply date filters
        if (!empty($tanggal_awal)) {
            $this->db->where('waktu_pelaporan >=', $tanggal_awal);
        }
        if (!empty($tanggal_akhir)) {
            $this->db->where('waktu_pelaporan <=', $tanggal_akhir);
        }

        // Apply status_ccs filter
        if (!empty($status_ccs)) {
            $this->db->where('status_ccs', $status_ccs);
        }

        // Apply client name filter
        if (!empty($nama_klien)) {
            $this->db->like('nama', $nama_klien);
        }


        $query = $this->db->get();
        return $query->result();
    }

    public function getDateFilteredH($tanggal_awal = null, $tanggal_akhir = null, $status_ccs = null, $nama_klien = null, $rating = null)
    {
        $user_id = $this->session->userdata('id_user');

        $this->db->select('pelaporan.*'); // Select fields from both tables
        $this->db->from('forward'); // Specify the base table
        $this->db->join('pelaporan', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'FINISHED');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC'); // Order by waktu_pelaporan in descending order

        // Filter berdasarkan tanggal_awal dan tanggal_akhir jika ada
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $this->db->where('waktu_pelaporan >=', $tanggal_awal);
            $this->db->where('waktu_pelaporan <=', $tanggal_akhir);
        }

        // Apply status_ccs filter
        if (!empty($status_ccs)) {
            $this->db->where('status_ccs', $status_ccs);
        }

        // Apply client name filter
        if (!empty($nama_klien)) {
            $this->db->like('nama', $nama_klien);
        }

        // Apply tags filter
        if (!empty($rating)) {
            $this->db->where('rating', $rating);
        }

        $query = $this->db->get();
        return $query->result();
    }

    // LAPORAN KATEGORI

    public function getAllCategory()
    {
        $query = "SELECT kategori, COUNT(*) AS 'total', waktu_pelaporan FROM pelaporan WHERE status_ccs='FINISH' GROUP BY kategori";
        return $this->db->query($query)->result_array();
    }

    public function getDateKategori($tgla, $tglb, $kategori)
    {
        $query = "SELECT kategori, COUNT(*) AS 'total', waktu_pelaporan FROM pelaporan WHERE status_ccs='FINISH' AND  waktu_pelaporan  BETWEEN '$tgla' AND '$tglb' AND kategori = '$kategori' ";
        return $this->db->query($query)->result_array();
    }

    public function getHelpdesk()
    {
        $query = "SELECT handle_by, COUNT(*) AS 'totalH', waktu_approve FROM pelaporan WHERE status_ccs='FINISH' GROUP BY handle_by ";
        return $this->db->query($query)->result_array();
    }

    public function getDateHelpdesk($tgla, $tglb)
    {
        $query = "SELECT handle_by, COUNT(*) AS 'totalH', waktu_approve FROM pelaporan 
        WHERE status_ccs='FINISH' AND waktu_approve BETWEEN '$tgla' AND '$tglb' GROUP BY handle_by  ";
        return $this->db->query($query)->result_array();
    }

    public function getProgres()
    {
        $query = "SELECT status_ccs, COUNT(*) AS 'totalP', waktu_pelaporan FROM pelaporan 
        WHERE status_ccs='FINISH'  OR status_ccs='HANDLE' GROUP BY status_ccs ";
        return $this->db->query($query)->result_array();
    }

    public function getDateProgres($tgla, $tglb, $status_ccs)
    {
        $query = "SELECT status_ccs, COUNT(*) AS 'totalP', waktu_pelaporan FROM pelaporan 
        WHERE waktu_pelaporan 
        BETWEEN '$tgla' AND '$tglb' AND status_ccs='$status_ccs'  GROUP BY status_ccs";
        return $this->db->query($query)->result_array();
    }
    public function count_tickets_by_status($user_id, $status)
    {
        // Ambil data pengguna dari sesi
        $user_id = $this->session->userdata('user_id');

        // Bangun query untuk menghitung jumlah tiket berdasarkan status
        $this->db->select('COUNT(*) as ticket_count');
        $this->db->from('forward');
        $this->db->join('pelaporan', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('forward.user_id', $user_id);
        $this->db->where_in('pelaporan.status_ccs', $status);

        // Eksekusi query
        $query = $this->db->get();
        $result = $query->row_array();

        // Ambil jumlah tiket dari hasil query
        $ticket_count = isset($result['ticket_count']) ? $result['ticket_count'] : 0;

        return $ticket_count;
    }


    public function get_total_active()
    {
        $user_id = $this->session->userdata('user_id');

        $query = "
            SELECT handle_by, COUNT(*) AS 'totalF'
            FROM forward
            LEFT JOIN pelaporan ON forward.pelaporan_id = pelaporan.id_pelaporan
            WHERE forward.user_id = ? AND pelaporan.status_ccs = 'FINISH'
            GROUP BY handle_by
        ";

        $result = $this->db->query($query, array($user_id))->result_array();

        // Debugging: Print the result
        echo '<pre>';
        print_r($result);
        echo '</pre>';
        exit; // Stop further execution to check the printed result

        return $result;
    }
}
