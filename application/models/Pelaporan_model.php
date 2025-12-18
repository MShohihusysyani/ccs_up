<?php
class Pelaporan_model extends CI_Model
{

    public function add_pelaporan()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $user_id = $this->session->userdata('id_user');

        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        $this->db->select('user_id, perihal, file, nama, no_tiket, kategori, tags, judul');
        $this->db->from('tiket_temp');
        $this->db->where('user_id', $user_id);
        $tiket_temp_data = $this->db->get()->result_array();

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
        $this->db->where('status_ccs', 'FINISHED');
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
    function updateFinish($id, $data)
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

    // REJECT TICKET
    function updateReject($id, $data)
    {
        $this->db->where('id_pelaporan', $id);
        $this->db->update('pelaporan', $data);
    }

    //LAPORAN status
    public function getAll()
    {
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

    public function getDateFiltered($filter_jenis_tgl = null, $tanggal_awal = null, $tanggal_akhir = null, $nama_klien = null, $nama_user = null, $status_ccs = null, $rating = null)
    {
        // $this->db->select('no_tiket, waktu_pelaporan, waktu_approve, kategori, status_ccs, priority, maxday, judul, perihal, nama, handle_by, handle_by2, handle_by3, rating');
        // $this->db->from('pelaporan');

        $this->db->select('pelaporan.*, klien.id_user_klien, klien.nama_klien');
        $this->db->from('pelaporan');
        $this->db->join('klien', 'pelaporan.user_id = klien.id_user_klien', 'left');

        // $filter_jenis_tgl = 'pelaporan.waktu_pelaporan';

        if (!empty($filter_jenis_tgl['filter_jenis_tgl'])) {
            $filter_jenis_tgl = 'pelaporan.' . $filter_jenis_tgl['filter_jenis_tgl'];
        }
        // Filter berdasarkan tanggal
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $tanggal_akhir_plus = date('Y-m-d', strtotime($tanggal_akhir . ' +1 day'));
            $this->db->where($filter_jenis_tgl . ' >=', $tanggal_awal . ' 00:00:00');
            $this->db->where($filter_jenis_tgl . ' <', $tanggal_akhir_plus . ' 00:00:00');
        }
        // if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
        //     $tanggal_akhir_plus = date('Y-m-d', strtotime($tanggal_akhir . ' +1 day'));
        //     $this->db->where('waktu_pelaporan >=', $tanggal_awal . ' 00:00:00');
        //     $this->db->where('waktu_pelaporan <', $tanggal_akhir_plus . ' 00:00:00');
        // }

        // Filter nama klien
        if (!empty($nama_klien)) {
            $this->db->where('klien.id_user_klien', $nama_klien);
        }

        // Filter nama_user
        if (!empty($nama_user)) {
            $this->db->group_start();
            $this->db->like('pelaporan.handle_by', $nama_user);
            $this->db->or_like('pelaporan.handle_by2', $nama_user);
            $this->db->or_like('pelaporan.handle_by3', $nama_user);
            $this->db->group_end();
        }

        if (!empty($status_ccs)) {
            $this->db->where('pelaporan.status_ccs', $status_ccs);
        }

        if (!empty($rating)) {
            $this->db->where('pelaporan.rating', $rating);
        }

        $query = $this->db->get();
        return $query->result();
    }


    public function getDateFilteredHandle($tanggal_awal = null, $tanggal_akhir = null, $nama_klien = null, $nama_user = null,   $status_ccs = null, $rating = null)
    {
        $this->db->select('*');
        $this->db->from('pelaporan');

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
        return $query->result();
    }

    // Rekap pelaporan per user helpdesk
    public function getDateH($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien)
    {
        $user_id = $this->session->userdata('id_user');

        $this->db->select('pelaporan.*');
        $this->db->from('forward');
        $this->db->join('pelaporan', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('forward.user_id', $user_id);
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

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
            $this->db->like('nama', $nama_klien);
        }


        $query = $this->db->get();
        return $query->result();
    }

    public function getDateFilteredH($tanggal_awal = null, $tanggal_akhir = null, $status_ccs = null, $nama_klien = null, $rating = null)
    {
        $user_id = $this->session->userdata('id_user');

        $this->db->select('pelaporan.*');
        $this->db->from('forward');
        $this->db->join('pelaporan', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'FINISHED');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $this->db->where('waktu_pelaporan >=', $tanggal_awal);
            $this->db->where('waktu_pelaporan <=', $tanggal_akhir);
        }

        if (!empty($status_ccs)) {
            $this->db->where('status_ccs', $status_ccs);
        }

        if (!empty($nama_klien)) {
            $this->db->like('nama', $nama_klien);
        }

        if (!empty($rating)) {
            $this->db->where('rating', $rating);
        }

        $query = $this->db->get();
        return $query->result();
    }

    // FILTER TEKNISI

    public function getDateFilteredTeknisi($tanggal_awal = null, $tanggal_akhir = null, $status_ccs = null, $nama_klien = null, $rating = null)
    {
        $user_id = $this->session->userdata('id_user');

        $this->db->select('pelaporan.*');
        $this->db->from('t1_forward');
        $this->db->join('pelaporan', 't1_forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('t1_forward.user_id', $user_id);
        $this->db->where('pelaporan.status_ccs', 'FINISHED');
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $this->db->where('waktu_pelaporan >=', $tanggal_awal);
            $this->db->where('waktu_pelaporan <=', $tanggal_akhir);
        }

        if (!empty($status_ccs)) {
            $this->db->where('status_ccs', $status_ccs);
        }

        if (!empty($nama_klien)) {
            $this->db->like('nama', $nama_klien);
        }

        if (!empty($rating)) {
            $this->db->where('rating', $rating);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function getDateTeknisi($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien)
    {
        $user_id = $this->session->userdata('id_user');

        $this->db->select('pelaporan.*');
        $this->db->from('t1_forward');
        $this->db->join('pelaporan', 't1_forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('t1_forward.user_id', $user_id);
        $this->db->order_by('pelaporan.waktu_pelaporan', 'DESC');

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
            $this->db->like('nama', $nama_klien);
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
        $user_id = $this->session->userdata('user_id');

        $this->db->select('COUNT(*) as ticket_count');
        $this->db->from('forward');
        $this->db->join('pelaporan', 'forward.pelaporan_id = pelaporan.id_pelaporan', 'left');
        $this->db->where('forward.user_id', $user_id);
        $this->db->where_in('pelaporan.status_ccs', $status);

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

        echo '<pre>';
        print_r($result);
        echo '</pre>';
        exit;

        return $result;
    }

    // REKAP PROGRESS
    public function get_rekap_progress($periode, $tahun, $nama_klien)
    {
        $bulan_range = ($periode == 1) ? range(1, 6) : range(7, 12);

        $this->db->select('MONTH(waktu_pelaporan) AS bulan');
        $this->db->select('SUM(CASE WHEN status_ccs IN ("FINISHED", "CLOSED") THEN 1 ELSE 0 END) AS finished', false);
        $this->db->select('SUM(CASE WHEN status_ccs IN ("HANDLED", "HANDLED 2", "ADDED 2") THEN 1 ELSE 0 END) AS handled', false);
        $this->db->select('SUM(CASE WHEN status_ccs IN ("FINISHED", "CLOSED", "HANDLED", "HANDLED 2", "ADDED 2") THEN 1 ELSE 0 END) AS total', false);

        $this->db->from('pelaporan');
        $this->db->where('YEAR(waktu_pelaporan)', $tahun);
        $this->db->where_in('MONTH(waktu_pelaporan)', $bulan_range);
        if (!empty($nama_klien)) $this->db->where('user_id', $nama_klien);
        $this->db->group_by('MONTH(waktu_pelaporan)');
        $this->db->order_by('MONTH(waktu_pelaporan)', 'ASC');

        $query = $this->db->get();
        $results = $query->result_array();

        // Bulan dalam nama Indonesia
        $bulan_nama = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        // Lengkapi bulan yang kosong
        $rekap = [];
        foreach ($bulan_range as $b) {
            $data = array_filter($results, function ($item) use ($b) {
                return (int)$item['bulan'] === $b;
            });
            $data = reset($data);

            $rekap[] = [
                'bulan_num' => $b,
                'bulan'    => $bulan_nama[$b],
                'finished' => isset($data['finished']) ? (int)$data['finished'] : 0,
                'handled'  => isset($data['handled']) ? (int)$data['handled'] : 0,
                'total'    => isset($data['total']) ? (int)$data['total'] : 0,
            ];
        }

        return $rekap;
    }

    public function get_rekap_progress_detail($tahun, $klien, $status, $bulan, $periode)
    {
        // Tentukan status yang dicari
        $status_where = [];
        if ($status == 'finished') {
            $status_where = ["FINISHED", "CLOSED"];
        } elseif ($status == 'handled') {
            $status_where = ["HANDLED", "HANDLED 2", "ADDED 2"];
        } elseif ($status == 'total') {
            $status_where = ["FINISHED", "CLOSED", "HANDLED", "HANDLED 2", "ADDED 2"];
        }

        // Tentukan range bulan
        if (!empty($bulan)) {
            // Jika parameter 'bulan' ada (klik dari baris bulanan)
            $this->db->where('MONTH(waktu_pelaporan)', $bulan);
        } elseif (!empty($periode)) {
            // Jika parameter 'periode' ada (klik dari grand total)
            $bulan_range = ($periode == 1) ? range(1, 6) : range(7, 12);
            $this->db->where_in('MONTH(waktu_pelaporan)', $bulan_range);
        }

        $this->db->select('pelaporan.*, klien.nama_klien');
        $this->db->from('pelaporan');
        $this->db->join('klien', 'pelaporan.user_id = klien.id_user_klien', 'left');

        $this->db->where('YEAR(waktu_pelaporan)', $tahun);

        if (!empty($klien)) {
            $this->db->where('pelaporan.user_id', $klien);
        }

        if (!empty($status_where)) {
            $this->db->where_in('pelaporan.status_ccs', $status_where);
        }

        $this->db->order_by('pelaporan.waktu_pelaporan', 'ASC');

        return $this->db->get()->result_array();
    }


    // REKAP KATEGORI
    public function get_rekap_kategori($periode, $tahun, $nama_klien)
    {
        $this->db->select('kategori, MONTH(waktu_pelaporan) as bulan, COUNT(*) as jumlah');
        $this->db->from('pelaporan');
        $this->db->where('YEAR(waktu_pelaporan)', $tahun);
        if (!empty($nama_klien)) $this->db->where('user_id', $nama_klien);

        if ($periode == 1) {
            $this->db->where('MONTH(waktu_pelaporan) >=', 1);
            $this->db->where('MONTH(waktu_pelaporan) <=', 6);
        } elseif ($periode == 2) {
            $this->db->where('MONTH(waktu_pelaporan) >=', 7);
            $this->db->where('MONTH(waktu_pelaporan) <=', 12);
        }

        $this->db->group_by(['kategori', 'MONTH(waktu_pelaporan)']);
        $this->db->order_by('kategori');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_rekap_kategori_detail($tahun, $klien, $bulan, $periode, $kategori)
    {
        $this->db->select('pelaporan.*, klien.nama_klien');
        $this->db->from('pelaporan');
        $this->db->join('klien', 'pelaporan.user_id = klien.id_user_klien', 'left');

        // Filter Tahun
        $this->db->where('YEAR(waktu_pelaporan)', $tahun);

        // Filter Klien (jika ada)
        if (!empty($klien)) {
            $this->db->where('user_id', $klien);
        }

        // Filter Kategori
        if (isset($kategori) && $kategori !== '') {
            // filter kategori tanpa kategori
            if ($kategori == '(Tanpa Kategori)') {
                $this->db->group_start();
                $this->db->where('kategori', NULL);
                $this->db->or_where('kategori', '');
                $this->db->group_end();
            } else {
                // Filter kategori
                $this->db->where('kategori', $kategori);
            }
        }

        // Filter Bulan
        if (!empty($bulan)) {
            $this->db->where('MONTH(waktu_pelaporan)', $bulan);
        }

        // Filter Periode
        if (empty($bulan) && !empty($periode)) {
            if ($periode == 1) {
                $this->db->where('MONTH(waktu_pelaporan) >=', 1);
                $this->db->where('MONTH(waktu_pelaporan) <=', 6);
            } elseif ($periode == 2) {
                $this->db->where('MONTH(waktu_pelaporan) >=', 7);
                $this->db->where('MONTH(waktu_pelaporan) <=', 12);
            }
        }

        $this->db->order_by('waktu_pelaporan', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // REKAP PETUGAS
    public function get_rekap_gabungan($bulan, $tahun, $user_id_filter = null)
    {

        // Bulan Terpilih (Current)
        $curr_start = "$tahun-$bulan-01";
        $curr_end   = date("Y-m-t", strtotime($curr_start));

        //Bulan Sebelumnya (Previous)
        $prev_start = date("Y-m-01", strtotime("-1 month", strtotime($curr_start)));
        $prev_end   = date("Y-m-t", strtotime($prev_start));

        $sql = "
        SELECT 
            u.nama_user as nama_petugas, 
            stats.*
        FROM user u
        JOIN (
            SELECT 
                user_id,
                
                -- Akumulasi: Semua tiket SEBELUM bulan lalu
                SUM(CASE WHEN status_ccs IN ('HANDLED', 'HANDLED 2', 'ADDED 2') AND date(waktu_pelaporan) < ? THEN 1 ELSE 0 END) as handle_akumulasi,
                -- Bulan Lalu
                SUM(CASE WHEN status_ccs IN ('HANDLED', 'HANDLED 2', 'ADDED 2') AND date(waktu_pelaporan) BETWEEN ? AND ? THEN 1 ELSE 0 END) as handle_prev,
                -- Bulan Ini
                SUM(CASE WHEN status_ccs IN ('HANDLED', 'HANDLED 2', 'ADDED 2') AND date(waktu_pelaporan) BETWEEN ? AND ? THEN 1 ELSE 0 END) as handle_current,

                -- Akumulasi: Semua tiket selesai SEBELUM bulan lalu
                SUM(CASE WHEN status_ccs IN ('FINISHED', 'CLOSED') AND date(waktu_approve) < ? THEN 1 ELSE 0 END) as finish_akumulasi,
                -- Bulan Lalu
                SUM(CASE WHEN status_ccs IN ('FINISHED', 'CLOSED') AND date(waktu_approve) BETWEEN ? AND ? THEN 1 ELSE 0 END) as finish_prev,
                -- Bulan Ini
                SUM(CASE WHEN status_ccs IN ('FINISHED', 'CLOSED') AND date(waktu_approve) BETWEEN ? AND ? THEN 1 ELSE 0 END) as finish_current

            FROM (
                SELECT f.user_id, p.status_ccs, p.waktu_pelaporan, p.waktu_approve
                FROM forward f
                JOIN pelaporan p ON f.pelaporan_id = p.id_pelaporan
                
                UNION ALL
                
                SELECT t1.user_id, p.status_ccs, p.waktu_pelaporan, p.waktu_approve
                FROM t1_forward t1
                JOIN pelaporan p ON t1.pelaporan_id = p.id_pelaporan
            ) as gabungan_tugas
            
            GROUP BY user_id
        ) as stats ON u.id_user = stats.user_id

        WHERE u.active = 'Y'";

        // Filter Petugas Spesifik
        if ($user_id_filter != 'all' && !empty($user_id_filter)) {
            $sql .= " AND u.id_user = " . $this->db->escape($user_id_filter);
        }

        $sql    .= "ORDER BY u.nama_user ASC";

        $params = [
            $prev_start,   // Handle Akum
            $prev_start,
            $prev_end,     // Handle Prev
            $curr_start,
            $curr_end,     // Handle Curr

            $prev_start,   // Finish Akum
            $prev_start,
            $prev_end,     // Finish Prev
            $curr_start,
            $curr_end      // Finish Curr
        ];

        return $this->db->query($sql, $params)->result_array();
    }

    public function get_detail_tugas($user_id, $status_type, $periode, $bulan, $tahun)
    {
        $date_column = 'waktu_pelaporan';
        $status_array = [];

        if ($status_type == 'handle') {
            $status_array = ['HANDLED', 'HANDLED 2', 'ADDED 2'];
            $date_column  = 'waktu_pelaporan';
        } elseif ($status_type == 'finish') {
            $status_array = ['FINISHED', 'CLOSED'];
            $date_column  = 'waktu_approve';
        }

        // Setup Periode Waktu
        $where_date = "";
        $selected_date_start = "$tahun-$bulan-01";
        $selected_date_end   = date("Y-m-t", strtotime($selected_date_start));

        if ($periode == 'bulan') {
            $where_date = "AND date($date_column) BETWEEN '$selected_date_start' AND '$selected_date_end'";
        } elseif ($periode == 'akumulasi') {
            $where_date = "AND date($date_column) < '$selected_date_start'";
        } elseif ($periode == 'total_semua') {
            $where_date = "";
        }

        $safe_user_id = $this->db->escape($user_id);

        $sql = "
    SELECT * FROM (
        -- Ambil dari tabel forward
        SELECT 
            'forward' as sumber_data,
            f.user_id AS id_petugas_handler,
            p.*,
            k.nama_klien,
            k.id_user_klien
        FROM forward f
        JOIN pelaporan p ON f.pelaporan_id = p.id_pelaporan
        LEFT JOIN klien  k ON p.user_id = k.id_user_klien
        WHERE f.user_id = $safe_user_id
        
        UNION ALL
        
        -- Ambil dari tabel t1_forward
        SELECT 
            't1_forward' as sumber_data,
            t1.user_id AS id_petugas_handler,
            p.*,
            k.nama_klien,
            k.id_user_klien
        FROM t1_forward t1
        JOIN pelaporan p ON t1.pelaporan_id = p.id_pelaporan
        LEFT JOIN klien k ON p.user_id = k.id_user_klien
        WHERE t1.user_id = $safe_user_id
    ) as tabel_gabungan
    WHERE 1=1
    ";

        //Filter Status
        if (!empty($status_array)) {
            $status_list = "'" . implode("','", $status_array) . "'";
            $sql .= " AND status_ccs IN ($status_list)";
        }

        //Filter Tanggal & Sorting
        $sql .= " $where_date";
        $sql .= " ORDER BY waktu_pelaporan DESC";

        return $this->db->query($sql)->result_array();
    }

    // REKAP ALL KLIEN
    public function get_rekap_all_klien($bulan, $tahun)
    {

        // Bulan Terpilih (Current)
        $curr_start = "$tahun-$bulan-01";
        $curr_end   = date("Y-m-t", strtotime($curr_start));

        //Bulan Sebelumnya (Previous)
        $prev_start = date("Y-m-01", strtotime("-1 month", strtotime($curr_start)));
        $prev_end   = date("Y-m-t", strtotime($prev_start));

        $sql = "
        SELECT 
            k.nama_klien, 
            k.no_klien,
            k.id,
            COALESCE(stats.klien_akumulasi, 0) as klien_akumulasi,
            COALESCE(stats.klien_prev, 0) as klien_prev,
            COALESCE(stats.klien_current, 0) as klien_current
        FROM klien k
        LEFT JOIN (
            SELECT 
                user_id,
                -- Akumulasi
                SUM(CASE WHEN date(waktu_pelaporan) < ? THEN 1 ELSE 0 END) as klien_akumulasi,
                -- Prev
                SUM(CASE WHEN date(waktu_pelaporan) BETWEEN ? AND ? THEN 1 ELSE 0 END) as klien_prev,
                -- Current
                SUM(CASE WHEN date(waktu_pelaporan) BETWEEN ? AND ? THEN 1 ELSE 0 END) as klien_current
            FROM pelaporan 
            GROUP BY user_id
        ) AS stats ON k.id_user_klien = stats.user_id
    ";

        $sql    .= "ORDER BY k.no_klien ASC";

        $params = [
            $prev_start,   // Klien Akum
            $prev_start,
            $prev_end,     // Klien Prev
            $curr_start,
            $curr_end,     // Klien Curr
        ];

        return $this->db->query($sql, $params)->result_array();
    }

    // REKAP KLIEN 20 BESAR
    public function get_rekap_klien_20_besar($bulan, $tahun)
    {

        // Bulan Terpilih (Current)
        $curr_start = "$tahun-$bulan-01";
        $curr_end   = date("Y-m-t", strtotime($curr_start));

        $sql = "
        SELECT 
            k.nama_klien, 
            k.no_klien,
            k.id,
            COALESCE(stats.klien_current, 0) as klien_current
        FROM klien k
        LEFT JOIN (
            SELECT 
                user_id,
                -- Current
                SUM(CASE WHEN date(waktu_pelaporan) BETWEEN ? AND ? THEN 1 ELSE 0 END) as klien_current
            FROM pelaporan 
            GROUP BY user_id
        ) AS stats ON k.id_user_klien = stats.user_id
    ";

        $sql    .= "ORDER BY stats.klien_current DESC LIMIT 20";

        $params = [
            $curr_start,
            $curr_end,     // Klien Curr
        ];

        return $this->db->query($sql, $params)->result_array();
    }

    public function get_by_no_tiket($id)
    {
        $this->db->from('pelaporan');
        $this->db->where('no_tiket', $id);

        return $this->db->get()->row();
    }
}
