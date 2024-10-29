<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Export extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Export_model');
        $this->load->helper('tanggal_helper');
        $this->load->model('Pelaporan_model');
    }

    public function print_detail($no_tiket)
    {
        $this->load->model('superadmin_model', 'superadmin_model');

        // Ambil data berdasarkan no_tiket
        $data['datapelaporan'] = $this->superadmin_model->getPelaporanByNoTiket($no_tiket);

        // Debugging: Pastikan data diambil dengan benar
        // echo '<pre>';
        // print_r($data['datapelaporan']);
        // echo '</pre>';
        // exit; // Hentikan eksekusi untuk memeriksa data

        $this->load->view('cetak/print_tiket', $data);
    }


    // public function cetak_tiket()
    // {
    //     $this->load->model('superadmin_model', 'superadmin_model');
    //     $data['no_tiket'] = $this->db->get('pelaporan')->result_array();
    //     $data['nama'] = $this->db->get('pelaporan')->result_array();
    //     $data['judul'] = $this->db->get('pelaporan')->result_array();
    //     $data['perihal'] = $this->db->get('pelaporan')->result_array();
    //     $data['kategori'] = $this->db->get('pelaporan')->result_array();
    //     $data['priority'] = $this->db->get('pelaporan')->result_array();
    //     $data['status_ccs'] = $this->db->get('pelaporan')->result_array();
    //     $data['handle_by'] = $this->db->get('pelaporan')->result_array();
    //     $data['datapelaporan'] = $this->superadmin_model->getPelaporanById();

    //     $this->load->view('cetak/print_tiket', $data);
    // }

    public function print_detail1($no_tiket)
    {
        $this->load->model('Superadmin_model', 'superadmin_model');

        // Fetch ticket details
        $ticket = $this->superadmin_model->getTicketDetail($no_tiket);

        if (empty($ticket)) {
            show_404();
        }

        // Load the view for printing
        $this->load->view('cetak/print_tiket', ['ticket' => $ticket]);
    }

    public function rekap_pelaporan_pdf_server_side()
    {
        $tanggal_awal = $this->input->post('tanggal_awal');
        $tanggal_akhir = $this->input->post('tanggal_akhir');
        $nama_klien = $this->input->post('nama_klien');
        $tags = $this->input->post('tags');
        $status_ccs = $this->input->post('status_ccs');

        $filters = array(
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'nama_klien' => $nama_klien,
            'tags' => $tags,
            'status_ccs' => $status_ccs
        );

        $data = $this->serverside_model->get_filtered_data($filters);
        // Generate PDF using $data
    }

    public function rekap_pelaporan_excel_server_side()
    {
        $tanggal_awal = $this->input->post('tanggal_awal');
        $tanggal_akhir = $this->input->post('tanggal_akhir');
        $nama_klien = $this->input->post('nama_klien');
        $tags = $this->input->post('tags');
        $status_ccs = $this->input->post('status_ccs');

        $filters = array(
            'tanggal_awal' => $tanggal_awal,
            'tanggal_akhir' => $tanggal_akhir,
            'nama_klien' => $nama_klien,
            'tags' => $tags,
            'status_ccs' => $status_ccs
        );

        $data = $this->serverside_model->get_filtered_data($filters);
        // Generate Excel using $data
    }

    public function rekap_pelaporan_pdf()
    {
        $this->load->model('Export_model', 'export_model');

        // Retrieve POST data
        $tanggal_awal  = $this->input->post('tanggal_awal');
        $tanggal_akhir = $this->input->post('tanggal_akhir');
        $status_ccs    = $this->input->post('status_ccs');
        $nama_klien    = $this->input->post('nama_klien');
        $nama_user     = $this->input->post('nama_user');
        $rating        = $this->input->post('rating');

        // Get filtered data
        if (empty($tanggal_awal) && empty($tanggal_akhir)) {
            // Fetch all data if no date range is selected
            $filteredData = $this->export_model->getAllPelaporan($nama_klien, $nama_user, $status_ccs, $rating);
            $periode = "Semua Data";
        } else {
            // Fetch data based on the selected date range
            $filteredData = $this->export_model->getPelaporan($tanggal_awal, $tanggal_akhir,  $nama_klien, $nama_user, $status_ccs, $rating);
            $periode = 'Periode ' . tanggal_indo($tanggal_awal) . ' s/d ' . tanggal_indo($tanggal_akhir);
        }

        // Load the mPDF library
        $this->load->library('pdf');
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'margin_top' => 30, // Margin atas yang cukup untuk header
            'margin_bottom' => 20, // Adjusted margin bottom
            'margin_left' => 15,
            'margin_right' => 15,
        ]);

        $header = '
        <div class="pdf-header" style="text-align: center; margin-bottom: 20px;"> <!-- Added margin-bottom -->
            <h3>CCS | REKAP PELAPORAN</h3>
            <p>' . $periode . '</p>
        </div>
    ';
        $mpdf->SetHTMLHeader($header, 'O');
        $mpdf->SetHTMLHeader($header, 'E');

        // Set HTML Footer
        $footer = '
        <div style="width: 100%; text-align: right; margin-top: 25px;">
            <div style="display: inline-block; width: 100%; text-align: right;">
                <div style="float: right; width: 100px; height: 50px; border: 1px solid black; margin-bottom: 10px;"></div>
                <div style="float: right; width: 100px; height: 50px; border: 1px solid black; margin-bottom: 10px;"></div>
                <div style="float: right; width: 100px; height: 50px; border: 1px solid black;"></div>
            </div>
        </div>
        <div style="width: 100%; text-align: left;">
            <span style="font-size: 11px;">Dicetak oleh: ' . $this->session->userdata('nama_user') . ' | ' . tanggal_indo(date("Y-m-d")) . '</span>
        </div>';

        $mpdf->SetHTMLFooter($footer);
        $mpdf->setAutoTopMargin = 'pad';
        $mpdf->setAutoBottomMargin = 'pad';

        $tableHtml = '
    <style>
        .pdf-header {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            margin-bottom: 20px; /* Margin bawah untuk header */
        }
        .table-bordered {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px; /* Adjusted margin atas untuk tabel */
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid black;
            padding: 7px;
            text-align: left;
        }
        .table-bordered th {
            background-color: #f2f2f2; /* Background color for table header */
            color: #000000; /* Text color for table header */
        }
        .table-bordered tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        .page-break {
                page-break-before: always;
            }
        
    </style>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>No Tiket</th>
                    <th>Judul</th>
    
                    <th>BPR/Klien</th>
                    <th>Kategori</th>
                    <th>Priority</th>
                    <th>Maxday</th>
                    <th>Handle By</th>
                    <th>Status</th>
                    <th>Create at</th>
                    <th>Finish at</th>
                </tr>
            </thead>
            <tbody>
    ';

        // Isi tabel dengan data
        $no = 1;
        foreach ($filteredData as $data) {
            // Initialize an array to hold the handler names
            $handleBy = [];

            // Check and add handle_by, handle_by2, and handle_by3 to the array
            if (!empty($data['handle_by'])) {
                $handleBy[] = $data['handle_by'];
            }
            if (!empty($data['handle_by2'])) {
                $handleBy[] = $data['handle_by2'];
            }
            if (!empty($data['handle_by3'])) {
                $handleBy[] = $data['handle_by3'];
            }

            // Join handlers with a comma
            $handleByString = implode(', ', $handleBy);
            $tableHtml .= '
            <tr>
                <td>' . $no . '</td>
                <td>' . $data['no_tiket'] . '</td>
                <td>' . $data['judul'] . '</td>
                
                <td>' . $data['nama'] . '</td>
                <td>' . $data['kategori'] . '</td>
                <td>' . $data['priority'] . '</td>
                <td>' . $data['maxday'] . '</td>
                <td>' . $handleByString . '</td>
                <td>' . $data['status_ccs'] . '</td>
                <td>' . tanggal_indo($data['waktu_pelaporan']) . '</td>
                <td>' . tanggal_indo($data['waktu_approve']) . '</td>
            </tr>
        ';
            $no++;
        }

        $tableHtml .= '
            </tbody>
        </table>
    ';

        // Tulis Header dan Table ke PDF
        $mpdf->WriteHTML('<div style="margin-bottom: 10px;"></div>'); // Tambahkan jarak antara header dan tabel
        $mpdf->WriteHTML($tableHtml);

        // Add additional margin below the table to separate it from the footer
        $mpdf->WriteHTML('<div style="margin-bottom: 50px;"></div>');

        $mpdf->Output('Rekap_Pelaporan.pdf', 'D');
    }

    public function rekap_pelaporan_pdf_hd()
    {
        $this->load->model('Export_model', 'export_model');

        // Retrieve POST data
        $tanggal_awal = $this->input->post('tanggal_awal');
        $tanggal_akhir = $this->input->post('tanggal_akhir');
        $status_ccs = $this->input->post('status_ccs');
        $nama_klien = $this->input->post('nama_klien');
        $tags = $this->input->post('tags');

        // Get filtered data
        if (empty($tanggal_awal) && empty($tanggal_akhir)) {
            // Fetch all data if no date range is selected
            $filteredData = $this->export_model->getAllPelaporanHD($status_ccs, $nama_klien, $tags);
            $periode = "Semua Data";
        } else {
            // Fetch data based on the selected date range
            $filteredData = $this->export_model->getPelaporanHD($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $tags);
            $periode = 'Periode ' . tanggal_indo($tanggal_awal) . ' s/d ' . tanggal_indo($tanggal_akhir);
        }

        // Load the mPDF library
        $this->load->library('pdf');
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4',
            'margin_top' => 30, // Margin atas yang cukup untuk header
            'margin_bottom' => 20, // Adjusted margin bottom
            'margin_left' => 15,
            'margin_right' => 15,
        ]);

        $header = '
        <div class="pdf-header" style="text-align: center; margin-bottom: 20px;"> <!-- Added margin-bottom -->
            <h3>CCS | REKAP PELAPORAN</h3>
            <p>' . $periode . '</p>
        </div>
    ';
        $mpdf->SetHTMLHeader($header, 'O');
        $mpdf->SetHTMLHeader($header, 'E');

        // Set HTML Footer
        $footer = '
        <div style="width: 100%; text-align: right; margin-top: 25px;">
            <div style="display: inline-block; width: 100%; text-align: right;">
                <div style="float: right; width: 100px; height: 50px; border: 1px solid black; margin-bottom: 10px;"></div>
                <div style="float: right; width: 100px; height: 50px; border: 1px solid black; margin-bottom: 10px;"></div>
                <div style="float: right; width: 100px; height: 50px; border: 1px solid black;"></div>
            </div>
        </div>
        <div style="width: 100%; text-align: left;">
            <span style="font-size: 11px;">Dicetak oleh: ' . $this->session->userdata('nama_user') . ' | ' . tanggal_indo(date("Y-m-d")) . '</span>
        </div>';

        $mpdf->SetHTMLFooter($footer);
        $mpdf->setAutoTopMargin = 'pad';
        $mpdf->setAutoBottomMargin = 'pad';

        $tableHtml = '
    <style>
        .pdf-header {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            margin-bottom: 20px; /* Margin bawah untuk header */
        }
        .table-bordered {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px; /* Adjusted margin atas untuk tabel */
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid black;
            padding: 7px;
            text-align: left;
        }
        .table-bordered th {
            background-color: #f2f2f2; /* Background color for table header */
            color: #000000; /* Text color for table header */
        }
        .table-bordered tr {
            page-break-inside: avoid;
        }
    </style>
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No Tiket</th>
                    <th>Nama Klien</th>
                    <th>Perihal</th>
                    <th>Tags</th>
                    <th>Kategori</th>
                    <th>Priority</th>
                    <th>Impact</th>
                    <th>Maxday</th>
                    <th>Status CCS</th>
                    <th>Handle By</th>
                </tr>
            </thead>
            <tbody>
    ';

        // Isi tabel dengan data
        $no = 1;
        foreach ($filteredData as $data) {
            $tableHtml .= '
            <tr>
                <td>' . $no . '</td>
                <td>' . tanggal_indo($data['waktu_pelaporan']) . '</td>
                <td>' . $data['no_tiket'] . '</td>
                <td>' . $data['nama'] . '</td>
                <td>' . $data['perihal'] . '</td>
                <td>' . $data['tags'] . '</td>
                <td>' . $data['kategori'] . '</td>
                <td>' . $data['priority'] . '</td>
                <td>' . $data['impact'] . '</td>
                <td>' . $data['maxday'] . '</td>
                <td>' . $data['status_ccs'] . '</td>
                <td>' . $data['handle_by'] . '</td>
            </tr>
        ';
            $no++;
        }

        $tableHtml .= '
            </tbody>
        </table>
    ';

        // Tulis Header dan Table ke PDF
        $mpdf->WriteHTML('<div style="margin-bottom: 10px;"></div>'); // Tambahkan jarak antara header dan tabel
        $mpdf->WriteHTML($tableHtml);

        // Add additional margin below the table to separate it from the footer
        $mpdf->WriteHTML('<div style="margin-bottom: 50px;"></div>');

        $mpdf->Output('Rekap_Pelaporan.pdf', 'D');
    }

    public function rekap_pelaporan_excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'    => Border::BORDER_THIN],
                'right' => ['borderStyle'  => Border::BORDER_THIN],
                'bottom' => ['borderStyle' => Border::BORDER_THIN],
                'left' => ['borderStyle'   => Border::BORDER_THIN]
            ]
        ];

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'    => Border::BORDER_THIN],
                'right' => ['borderStyle'  => Border::BORDER_THIN],
                'bottom' => ['borderStyle' => Border::BORDER_THIN],
                'left' => ['borderStyle'   => Border::BORDER_THIN]
            ]
        ];

        $sheet->setCellValue('A1', "CCS | RINCIAN PELAPORAN");
        $sheet->mergeCells('A1:L1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(15);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $current_date = date('Y-m-d');

        // Mendapatkan informasi user dari sesi
        $this->db->where('id_user', $this->session->userdata('id_user'));
        $user_query = $this->db->get('user');
        $user = $user_query->row_array();

        $tanggal_awal = $this->input->post('tanggal_awal');
        $tanggal_akhir = $this->input->post('tanggal_akhir');
        $nama_klien = $this->input->post('nama_klien');
        $nama_user = $this->input->post('nama_user');
        $rating = $this->input->post('rating');
        $status_ccs = $this->input->post('status_ccs');

        // Membuat teks untuk periode berdasarkan tanggal_awal dan tanggal_akhir
        $periode_text = "Semua Data";
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $periode_text = "Periode : " . tanggal_indo($tanggal_awal) . " s/d " . tanggal_indo($tanggal_akhir);
        }

        $sheet->setCellValue('A2', $periode_text);
        $sheet->setCellValue('A3', "NO");
        $sheet->setCellValue('B3', "No Tiket");
        $sheet->setCellValue('C3', "Judul");
        $sheet->setCellValue('D3', "Perihal");
        $sheet->setCellValue('E3', "BPR/Klien");
        $sheet->setCellValue('F3', "Kategori");
        $sheet->setCellValue('G3', "Priority");
        $sheet->setCellValue('H3', "Maxday");
        $sheet->setCellValue('I3', "Handled By");
        $sheet->setCellValue('J3', "Status");
        $sheet->setCellValue('K3', "Rating");
        $sheet->setCellValue('L3', "Create at");
        $sheet->setCellValue('M3', "Finish at");

        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('A2:L2');
        // $sheet->getStyle('A3:M3')->applyFromArray($style_col);

        $sheet->getRowDimension('1')->setRowHeight(20);
        $sheet->getRowDimension('2')->setRowHeight(20);
        $sheet->getRowDimension('3')->setRowHeight(20);

        $this->load->model('Pelaporan_model', 'pelaporan_model');

        // // Mendapatkan data berdasarkan filter tanggal jika diisi
        // if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
        //     $query = $this->pelaporan_model->getDate($tanggal_awal, $tanggal_akhir);

        // } else {
        //     // Mendapatkan semua data jika tanggal tidak diisi
        //     $query = $this->pelaporan_model->getDate();
        // }

        $query = $this->pelaporan_model->getDateFiltered($tanggal_awal, $tanggal_akhir, $nama_klien,  $nama_user,  $status_ccs, $rating);
        // var_dump($query);
        // die();

        $no = 1;
        $row = 4;

        foreach ($query as $data) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $data->no_tiket);
            $sheet->setCellValue('C' . $row, $data->judul);
            $sheet->setCellValue('D' . $row, $data->perihal);
            $sheet->setCellValue('E' . $row, $data->nama);
            $sheet->setCellValue('F' . $row, $data->kategori);
            $sheet->setCellValue('G' . $row, $data->priority);
            $sheet->setCellValue('H' . $row, $data->maxday);

            $handleBy = [];

            if (!empty($data->handle_by)) {
                $handleBy[] = $data->handle_by;
            }
            if (!empty($data->handle_by2)) {
                $handleBy[] = $data->handle_by2;
            }
            if (!empty($data->handle_by3)) {
                $handleBy[] = $data->handle_by3;
            }
            $sheet->setCellValue('I' . $row, implode(', ', $handleBy));
            $sheet->setCellValue('J' . $row, $data->status_ccs);
            $sheet->setCellValue('K' . $row, $data->rating);
            $sheet->setCellValue('L' . $row, tanggal_indo($data->waktu_pelaporan));
            $sheet->setCellValue('M' . $row, tanggal_indo($data->waktu_approve));

            // Apply style untuk setiap sel data
            // $sheet->getStyle('A' . $row . ':M' . $row)->applyFromArray($style_row);

            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getRowDimension($row)->setRowHeight(20);

            $no++;
            $row++;
        }

        // $sheet->getColumnDimension('A')->setWidth(5);
        // $sheet->getColumnDimension('B')->setWidth(15);
        // $sheet->getColumnDimension('C')->setWidth(20);
        // $sheet->getColumnDimension('D')->setWidth(40);
        // $sheet->getColumnDimension('E')->setWidth(235);
        // $sheet->getColumnDimension('F')->setWidth(30);
        // $sheet->getColumnDimension('G')->setWidth(83);
        // $sheet->getColumnDimension('H')->setWidth(10);
        // $sheet->getColumnDimension('I')->setWidth(10);
        // $sheet->getColumnDimension('J')->setWidth(10);
        // $sheet->getColumnDimension('K')->setWidth(15);
        // $sheet->getColumnDimension('L')->setWidth(10);

        // Set orientasi halaman dan judul sheet
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle("Data Rekap Pelaporan");

        // Set header untuk mendownload file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Rekap_Pelaporan.xlsx"');
        header('Cache-Control: max-age=0');

        // Simpan file Excel
        $writer = new Xlsx($spreadsheet);
        ob_end_clean(); //digunakan ketika file tidak bisa dibuka diexcel
        $writer->save('php://output');
    }

    public function rekap_pelaporan_excel_hd()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'    => Border::BORDER_THIN],
                'right' => ['borderStyle'  => Border::BORDER_THIN],
                'bottom' => ['borderStyle' => Border::BORDER_THIN],
                'left' => ['borderStyle'   => Border::BORDER_THIN]
            ]
        ];

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'    => Border::BORDER_THIN],
                'right' => ['borderStyle'  => Border::BORDER_THIN],
                'bottom' => ['borderStyle' => Border::BORDER_THIN],
                'left' => ['borderStyle'   => Border::BORDER_THIN]
            ]
        ];

        $sheet->setCellValue('A1', "CCS | REKAP PELAPORAN");
        $sheet->mergeCells('A1:E1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(15);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $current_date = date('Y-m-d');

        $this->db->where('id_user', $this->session->userdata('id_user')); // Assuming user_id is stored in session
        $user_query = $this->db->get('user');
        $tanggal_awal = $this->input->post('tanggal_awal');
        $tanggal_akhir = $this->input->post('tanggal_akhir');

        $tanggal_awal = $this->input->post('tanggal_awal');
        $tanggal_akhir = $this->input->post('tanggal_akhir');
        $nama_klien = $this->input->post('nama_klien');
        $tags = $this->input->post('tags');
        $status_ccs = $this->input->post('status_ccs');

        // Membuat teks untuk periode berdasarkan tanggal_awal dan tanggal_akhir
        $periode_text = "Semua Data";
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $periode_text = "Periode : " . tanggal_indo($tanggal_awal) . " s/d " . tanggal_indo($tanggal_akhir);
        }

        // Buat header tabel pada baris ke 3
        $sheet->setCellValue('A2', $periode_text);
        $sheet->setCellValue('A3', "NO");
        $sheet->setCellValue('B3', "TANGGAL");
        $sheet->setCellValue('C3', "NO TIKET");
        $sheet->setCellValue('D3', "NAMA KLIEN");
        $sheet->setCellValue('E3', "PERIHAL");
        $sheet->setCellValue('F3', "TAGS");
        $sheet->setCellValue('G3', "KATEGORI");
        $sheet->setCellValue('H3', "PRIORITY");
        $sheet->setCellValue('I3', "IMPACT");
        $sheet->setCellValue('J3', "MAXDAY");
        $sheet->setCellValue('K3', "STATUS CCS");
        $sheet->setCellValue('L3', "HANDLE BY");

        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('A2:E2');
        $sheet->getStyle('A3:L3')->applyFromArray($style_col);

        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);
        $sheet->getStyle('I3')->applyFromArray($style_col);
        $sheet->getStyle('J3')->applyFromArray($style_col);
        $sheet->getStyle('K3')->applyFromArray($style_col);
        $sheet->getStyle('L3')->applyFromArray($style_col);


        $sheet->getRowDimension('1')->setRowHeight(20);
        $sheet->getRowDimension('2')->setRowHeight(20);
        $sheet->getRowDimension('3')->setRowHeight(20);

        $this->load->model('Pelaporan_model', 'pelaporan_model');

        // Retrieve POST data
        $tanggal_awal = $this->input->post('tanggal_awal');
        $tanggal_akhir = $this->input->post('tanggal_akhir');
        $status_ccs = $this->input->post('status_ccs');
        $nama_klien = $this->input->post('nama_klien');
        $tags = $this->input->post('tags');

        // Get filtered data
        $query = $this->pelaporan_model->getDateH($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $tags);
        $no = 1;
        $row = 4;

        foreach ($query as $data) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, tanggal_indo($data->waktu_pelaporan));
            $sheet->setCellValue('C' . $row, $data->no_tiket);
            $sheet->setCellValue('D' . $row, $data->nama);
            $sheet->setCellValue('E' . $row, $data->perihal);
            $sheet->setCellValue('F' . $row, $data->tags);
            $sheet->setCellValue('G' . $row, $data->kategori);
            $sheet->setCellValue('H' . $row, $data->priority);
            $sheet->setCellValue('I' . $row, $data->impact);
            $sheet->setCellValue('J' . $row, $data->maxday);
            $sheet->setCellValue('K' . $row, $data->status_ccs);
            $sheet->setCellValue('L' . $row, $data->handle_by);

            $sheet->getStyle('A' . $row)->applyFromArray($style_row);
            $sheet->getStyle('B' . $row)->applyFromArray($style_row);
            $sheet->getStyle('C' . $row)->applyFromArray($style_row);
            $sheet->getStyle('D' . $row)->applyFromArray($style_row);
            $sheet->getStyle('E' . $row)->applyFromArray($style_row);
            $sheet->getStyle('F' . $row)->applyFromArray($style_row);
            $sheet->getStyle('G' . $row)->applyFromArray($style_row);
            $sheet->getStyle('H' . $row)->applyFromArray($style_row);
            $sheet->getStyle('I' . $row)->applyFromArray($style_row);
            $sheet->getStyle('J' . $row)->applyFromArray($style_row);
            $sheet->getStyle('K' . $row)->applyFromArray($style_row);
            $sheet->getStyle('L' . $row)->applyFromArray($style_row);

            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getRowDimension($row)->setRowHeight(20);

            $no++;
            $row++;
        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(40);
        $sheet->getColumnDimension('E')->setWidth(235);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(83);
        $sheet->getColumnDimension('H')->setWidth(10);
        $sheet->getColumnDimension('I')->setWidth(10);
        $sheet->getColumnDimension('J')->setWidth(10);
        $sheet->getColumnDimension('K')->setWidth(15);
        $sheet->getColumnDimension('L')->setWidth(10);

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle("Data Rekap Pelaporan");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Rekap_Pelaporan.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        ob_end_clean(); //digunakan ketika file tidak bisa dibuka diexcel
        $writer->save('php://output');
    }

    public function rekap_pelaporan_excel_finish()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'    => Border::BORDER_THIN],
                'right' => ['borderStyle'  => Border::BORDER_THIN],
                'bottom' => ['borderStyle' => Border::BORDER_THIN],
                'left' => ['borderStyle'   => Border::BORDER_THIN]
            ]
        ];

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'    => Border::BORDER_THIN],
                'right' => ['borderStyle'  => Border::BORDER_THIN],
                'bottom' => ['borderStyle' => Border::BORDER_THIN],
                'left' => ['borderStyle'   => Border::BORDER_THIN]
            ]
        ];

        $sheet->setCellValue('A1', "CCS | RINCIAN PELAPORAN");
        $sheet->mergeCells('A1:L1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(15);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $current_date = date('Y-m-d');

        // Mendapatkan informasi user dari sesi
        $this->db->where('id_user', $this->session->userdata('id_user'));
        $user_query = $this->db->get('user');
        $user = $user_query->row_array();

        $tanggal_awal = $this->input->post('tanggal_awal');
        $tanggal_akhir = $this->input->post('tanggal_akhir');
        $nama_klien = $this->input->post('nama_klien');
        $nama_user = $this->input->post('nama_user');
        $rating = $this->input->post('rating');
        $status_ccs = 'FINISHED';

        // Membuat teks untuk periode berdasarkan tanggal_awal dan tanggal_akhir
        $periode_text = "Semua Data";
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $periode_text = "Periode : " . tanggal_indo($tanggal_awal) . " s/d " . tanggal_indo($tanggal_akhir);
        }

        $sheet->setCellValue('A2', $periode_text);
        $sheet->setCellValue('A3', "NO");
        $sheet->setCellValue('B3', "No Tiket");
        $sheet->setCellValue('C3', "Judul");
        $sheet->setCellValue('D3', "Perihal");
        $sheet->setCellValue('E3', "BPR/Klien");
        $sheet->setCellValue('F3', "Kategori");
        $sheet->setCellValue('G3', "Priority");
        $sheet->setCellValue('H3', "Maxday");
        $sheet->setCellValue('I3', "Handled By");
        $sheet->setCellValue('J3', "Status");
        $sheet->setCellValue('K3', "Rating");
        $sheet->setCellValue('L3', "Create at");
        $sheet->setCellValue('M3', "Finish at");

        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('A2:L2');
        // $sheet->getStyle('A3:M3')->applyFromArray($style_col);

        $sheet->getRowDimension('1')->setRowHeight(20);
        $sheet->getRowDimension('2')->setRowHeight(20);
        $sheet->getRowDimension('3')->setRowHeight(20);

        $this->load->model('Pelaporan_model', 'pelaporan_model');

        // // Mendapatkan data berdasarkan filter tanggal jika diisi
        // if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
        //     $query = $this->pelaporan_model->getDate($tanggal_awal, $tanggal_akhir);

        // } else {
        //     // Mendapatkan semua data jika tanggal tidak diisi
        //     $query = $this->pelaporan_model->getDate();
        // }

        $query = $this->pelaporan_model->getDateFiltered($tanggal_awal, $tanggal_akhir, $nama_klien,  $nama_user,  $status_ccs, $rating);
        // var_dump($query);
        // die();

        $no = 1;
        $row = 4;

        foreach ($query as $data) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $data->no_tiket);
            $sheet->setCellValue('C' . $row, $data->judul);
            $sheet->setCellValue('D' . $row, $data->perihal);
            $sheet->setCellValue('E' . $row, $data->nama);
            $sheet->setCellValue('F' . $row, $data->kategori);
            $sheet->setCellValue('G' . $row, $data->priority);
            $sheet->setCellValue('H' . $row, $data->maxday);

            $handleBy = [];

            if (!empty($data->handle_by)) {
                $handleBy[] = $data->handle_by;
            }
            if (!empty($data->handle_by2)) {
                $handleBy[] = $data->handle_by2;
            }
            if (!empty($data->handle_by3)) {
                $handleBy[] = $data->handle_by3;
            }
            $sheet->setCellValue('I' . $row, implode(', ', $handleBy));
            $sheet->setCellValue('J' . $row, $data->status_ccs);
            $sheet->setCellValue('K' . $row, $data->rating);
            $sheet->setCellValue('L' . $row, tanggal_indo($data->waktu_pelaporan));
            $sheet->setCellValue('M' . $row, tanggal_indo($data->waktu_approve));

            // Apply style untuk setiap sel data
            // $sheet->getStyle('A' . $row . ':M' . $row)->applyFromArray($style_row);

            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getRowDimension($row)->setRowHeight(20);

            $no++;
            $row++;
        }

        // $sheet->getColumnDimension('A')->setWidth(5);
        // $sheet->getColumnDimension('B')->setWidth(15);
        // $sheet->getColumnDimension('C')->setWidth(20);
        // $sheet->getColumnDimension('D')->setWidth(40);
        // $sheet->getColumnDimension('E')->setWidth(235);
        // $sheet->getColumnDimension('F')->setWidth(30);
        // $sheet->getColumnDimension('G')->setWidth(83);
        // $sheet->getColumnDimension('H')->setWidth(10);
        // $sheet->getColumnDimension('I')->setWidth(10);
        // $sheet->getColumnDimension('J')->setWidth(10);
        // $sheet->getColumnDimension('K')->setWidth(15);
        // $sheet->getColumnDimension('L')->setWidth(10);

        // Set orientasi halaman dan judul sheet
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle("Data Rekap Pelaporan");

        // Set header untuk mendownload file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Rekap_Pelaporan.xlsx"');
        header('Cache-Control: max-age=0');

        // Simpan file Excel
        $writer = new Xlsx($spreadsheet);
        ob_end_clean(); //digunakan ketika file tidak bisa dibuka diexcel
        $writer->save('php://output');
    }

    public function rekap_pelaporan_excel_handle()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'    => Border::BORDER_THIN],
                'right' => ['borderStyle'  => Border::BORDER_THIN],
                'bottom' => ['borderStyle' => Border::BORDER_THIN],
                'left' => ['borderStyle'   => Border::BORDER_THIN]
            ]
        ];

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'    => Border::BORDER_THIN],
                'right' => ['borderStyle'  => Border::BORDER_THIN],
                'bottom' => ['borderStyle' => Border::BORDER_THIN],
                'left' => ['borderStyle'   => Border::BORDER_THIN]
            ]
        ];

        $sheet->setCellValue('A1', "CCS | RINCIAN PELAPORAN");
        $sheet->mergeCells('A1:L1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(15);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $current_date = date('Y-m-d');

        // Mendapatkan informasi user dari sesi
        $this->db->where('id_user', $this->session->userdata('id_user'));
        $user_query = $this->db->get('user');
        $user = $user_query->row_array();

        $tanggal_awal = $this->input->post('tanggal_awal');
        $tanggal_akhir = $this->input->post('tanggal_akhir');
        $nama_klien = $this->input->post('nama_klien');
        $nama_user = $this->input->post('nama_user');
        $status_ccs = ['HANDLED', 'HANDLED 2'];

        // Membuat teks untuk periode berdasarkan tanggal_awal dan tanggal_akhir
        $periode_text = "Semua Data";
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $periode_text = "Periode : " . tanggal_indo($tanggal_awal) . " s/d " . tanggal_indo($tanggal_akhir);
        }

        $sheet->setCellValue('A2', $periode_text);
        $sheet->setCellValue('A3', "NO");
        $sheet->setCellValue('B3', "No Tiket");
        $sheet->setCellValue('C3', "Judul");
        $sheet->setCellValue('D3', "Perihal");
        $sheet->setCellValue('E3', "BPR/Klien");
        $sheet->setCellValue('F3', "Kategori");
        $sheet->setCellValue('G3', "Priority");
        $sheet->setCellValue('H3', "Maxday");
        $sheet->setCellValue('I3', "Handled By");
        $sheet->setCellValue('J3', "Status");
        $sheet->setCellValue('K3', "Create at");
        $sheet->setCellValue('L3', "Finish at");

        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('A2:L2');
        // $sheet->getStyle('A3:M3')->applyFromArray($style_col);

        $sheet->getRowDimension('1')->setRowHeight(20);
        $sheet->getRowDimension('2')->setRowHeight(20);
        $sheet->getRowDimension('3')->setRowHeight(20);

        $this->load->model('Pelaporan_model', 'pelaporan_model');

        // // Mendapatkan data berdasarkan filter tanggal jika diisi
        // if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
        //     $query = $this->pelaporan_model->getDate($tanggal_awal, $tanggal_akhir);

        // } else {
        //     // Mendapatkan semua data jika tanggal tidak diisi
        //     $query = $this->pelaporan_model->getDate();
        // }

        $query = $this->pelaporan_model->getDateFilteredHandle($tanggal_awal, $tanggal_akhir, $nama_klien,  $nama_user,  $status_ccs);
        // var_dump($query);
        // die();

        $no = 1;
        $row = 4;

        foreach ($query as $data) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $data->no_tiket);
            $sheet->setCellValue('C' . $row, $data->judul);
            $sheet->setCellValue('D' . $row, $data->perihal);
            $sheet->setCellValue('E' . $row, $data->nama);
            $sheet->setCellValue('F' . $row, $data->kategori);
            $sheet->setCellValue('G' . $row, $data->priority);
            $sheet->setCellValue('H' . $row, $data->maxday);

            $handleBy = [];

            if (!empty($data->handle_by)) {
                $handleBy[] = $data->handle_by;
            }
            if (!empty($data->handle_by2)) {
                $handleBy[] = $data->handle_by2;
            }
            if (!empty($data->handle_by3)) {
                $handleBy[] = $data->handle_by3;
            }
            $sheet->setCellValue('I' . $row, implode(', ', $handleBy));
            $sheet->setCellValue('J' . $row, $data->status_ccs);
            $sheet->setCellValue('K' . $row, tanggal_indo($data->waktu_pelaporan));
            $sheet->setCellValue('L' . $row, tanggal_indo($data->waktu_approve));

            // Apply style untuk setiap sel data
            // $sheet->getStyle('A' . $row . ':M' . $row)->applyFromArray($style_row);

            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('E' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('H' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('I' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('J' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('K' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('L' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
            $sheet->getRowDimension($row)->setRowHeight(20);

            $no++;
            $row++;
        }

        // $sheet->getColumnDimension('A')->setWidth(5);
        // $sheet->getColumnDimension('B')->setWidth(15);
        // $sheet->getColumnDimension('C')->setWidth(20);
        // $sheet->getColumnDimension('D')->setWidth(40);
        // $sheet->getColumnDimension('E')->setWidth(235);
        // $sheet->getColumnDimension('F')->setWidth(30);
        // $sheet->getColumnDimension('G')->setWidth(83);
        // $sheet->getColumnDimension('H')->setWidth(10);
        // $sheet->getColumnDimension('I')->setWidth(10);
        // $sheet->getColumnDimension('J')->setWidth(10);
        // $sheet->getColumnDimension('K')->setWidth(15);
        // $sheet->getColumnDimension('L')->setWidth(10);

        // Set orientasi halaman dan judul sheet
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle("Data Rekap Pelaporan");

        // Set header untuk mendownload file Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Rekap_Pelaporan.xlsx"');
        header('Cache-Control: max-age=0');

        // Simpan file Excel
        $writer = new Xlsx($spreadsheet);
        ob_end_clean(); //digunakan ketika file tidak bisa dibuka diexcel
        $writer->save('php://output');
    }

    public function rekap_pelaporan_excel1()
    {
        try {
            // Load PhpSpreadsheet
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Define column and row styles
            $style_col = [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                ],
            ];

            $style_row = [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                ],
            ];

            // Set header title
            $sheet->setCellValue('A1', "CCS | REKAP PELAPORAN");
            $sheet->mergeCells('A1:L1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            // Set timezone and get current date
            date_default_timezone_set('Asia/Jakarta');
            $current_date = date('Y-m-d H:i:s');

            // Get user information
            $this->db->where('id_user', $this->session->userdata('id_user'));
            $user_query = $this->db->get('user');
            $user = $user_query->row_array();

            // Print user and date information
            $sheet->setCellValue('A2', 'Rekap Pelaporan dicetak oleh ' . $user['nama_user'] . ' pada ' . format_indo($current_date));
            $sheet->mergeCells('A2:L2');
            $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(15);
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            // Set table headers
            $headers = ["NO", "TANGGAL", "NO TIKET", "NAMA KLIEN", "PERIHAL", "TAGS", "KATEGORI", "PRIORITY", "IMPACT", "MAXDAY", "STATUS CCS", "HANDLE BY"];
            $column = 'A';
            foreach ($headers as $header) {
                $sheet->setCellValue($column . '3', $header);
                $sheet->getStyle($column . '3')->applyFromArray($style_col);
                $column++;
            }
            $sheet->getRowDimension('1')->setRowHeight(20);
            $sheet->getRowDimension('2')->setRowHeight(20);
            $sheet->getRowDimension('3')->setRowHeight(20);

            // Fetch data based on date range
            $tanggal_awal = $this->input->post('tanggal_awal');
            $tanggal_akhir = $this->input->post('tanggal_akhir');

            if (empty($tanggal_awal) || empty($tanggal_akhir)) {
                throw new Exception('Tanggal awal dan akhir harus diisi.');
            }

            $query = "SELECT * FROM pelaporan WHERE waktu_pelaporan BETWEEN '$tanggal_awal' AND  '$tanggal_akhir'";
            $data = $this->db->query($query, [$tanggal_awal, $tanggal_akhir])->result_array();

            // Display data or message if no data found
            if (empty($data)) {
                $sheet->setCellValue('A4', 'Tidak ada data ditemukan untuk rentang tanggal yang dipilih.');
                $sheet->mergeCells('A4:L4');
                $sheet->getStyle('A4')->getFont()->setBold(true);
                $sheet->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            } else {
                $row = 4;
                foreach ($data as $no => $item) {
                    $sheet->setCellValue('A' . $row, $no + 1);
                    $sheet->setCellValue('B' . $row, tanggal_indo($item['waktu_pelaporan']));
                    $sheet->setCellValue('C' . $row, $item['no_tiket']);
                    $sheet->setCellValue('D' . $row, $item['nama']);
                    $sheet->setCellValue('E' . $row, $item['perihal']);
                    $sheet->setCellValue('F' . $row, $item['tags']);
                    $sheet->setCellValue('G' . $row, $item['kategori']);
                    $sheet->setCellValue('H' . $row, $item['priority']);
                    $sheet->setCellValue('I' . $row, $item['impact']);
                    $sheet->setCellValue('J' . $row, $item['maxday']);
                    $sheet->setCellValue('K' . $row, $item['status_ccs']);
                    $sheet->setCellValue('L' . $row, $item['handle_by']);
                    foreach (range('A', 'L') as $columnID) {
                        $sheet->getStyle($columnID . $row)->applyFromArray($style_row);
                        $sheet->getStyle($columnID . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                    }
                    $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $row++;
                }
                var_dump($data);
                die;

                // Set column widths
                $columnWidths = [5, 15, 20, 35, 50, 30, 20, 10, 10, 10, 15, 10];
                foreach (range('A', 'L') as $index => $columnID) {
                    $sheet->getColumnDimension($columnID)->setWidth($columnWidths[$index]);
                }

                // Set page orientation
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
            }

            // Output the file
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            ob_end_clean();
            $filename = 'Rekap_Pelaporan_' . date('Y-m-d_H:i:s') . '.xlsx';

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="' . $filename . '"');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
        } catch (Exception $e) {
            // Improved error handling
            error_log('Error generating report: ' . $e->getMessage());
            echo 'Error generating report. Please try again later.';
        }
    }



    // REKAP KATEGORI
    public function rekap_kategori()
    {
        $data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Export_model', 'export_model');
        $data['kategori'] = $this->db->get('pelaporan')->result_array();
        $data['total'] = $this->db->get('pelaporan')->result_array();
        $data['rekapCategory'] = $this->Export_model->getCategory();
        $this->load->view('cetak/rekap_kategori', $data);
    }

    public function rekap_kategori_excel()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'    => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'   => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top'   => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left'  => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];

        $sheet->setCellValue('A1', "CCS | REKAP KATEGORI");
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15);

        date_default_timezone_set('Asia/Jakarta'); // Set local time zone
        $current_date = date('Y-m-d H:i:s');

        $this->db->where('id_user', $this->session->userdata('id_user')); // Assuming user_id is stored in session
        $user_query = $this->db->get('user');
        $user = $user_query->row_array(); // Fetching the user data

        $sheet->setCellValue('A2', "Rekap Pelaporan dicetak oleh " . $user['nama_user'] . " pada tanggal " . format_indo($current_date));
        $sheet->mergeCells('A2:F2');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(15);

        // Buat header tabel pada baris ke 3
        $sheet->setCellValue('A3', "NO");
        $sheet->setCellValue('B3', "KATEGORI");
        $sheet->setCellValue('C3', "TOTAL");

        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);

        $sheet->getRowDimension('1')->setRowHeight(20);
        $sheet->getRowDimension('2')->setRowHeight(20);
        $sheet->getRowDimension('3')->setRowHeight(20);

        // Fetch data from database
        $this->db->select('kategori, COUNT(*) AS total');
        $this->db->from('pelaporan');
        $this->db->where('status_ccs', 'FINISH');
        $this->db->group_by('kategori');
        $query = $this->db->get();

        $no = 1;
        $row = 4;

        foreach ($query->result() as $data) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $data->kategori);
            $sheet->setCellValue('C' . $row, $data->total);

            $sheet->getStyle('A' . $row)->applyFromArray($style_row);
            $sheet->getStyle('B' . $row)->applyFromArray($style_row);
            $sheet->getStyle('C' . $row)->applyFromArray($style_row);

            $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->getStyle('C' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getRowDimension($row)->setRowHeight(20);

            $no++;
            $row++;
        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(10);

        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle("Data Rekap Kategori");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Rekap_Kategori.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        ob_end_clean(); // Used to fix issue with file not opening in Excel
        $writer->save('php://output');
    }


    public function rekap_pelaporan_pdf1()
    {
        $this->load->model('Export_model', 'export_model');

        // Retrieve POST data
        $tanggal_awal = $this->input->post('tanggal_awal');
        $tanggal_akhir = $this->input->post('tanggal_akhir');
        $status_ccs = $this->input->post('status_ccs');
        $nama_klien = $this->input->post('nama_klien');
        $tags = $this->input->post('tags');

        // Get filtered data
        $filteredData = $this->export_model->getPelaporan($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $tags);

        // Load the mPDF library
        $this->load->library('pdf');
        $mpdf = new \Mpdf\Mpdf();

        $mpdf->SetHTMLFooter('
    <table width="100%">
        <tr>
            <td width="33%" style="text-align: right;">Dicetak oleh : ' . $this->session->userdata('nama_user') . '</td>
        </tr>
    </table>');

        // Create PDF content
        $html = '<h3 style="text-align: center;">CCS | REKAP PELAPORAN</h3>';
        $html .= '<p style="text-align: center; font-weight: bold;">Periode  ' . tanggal_indo($tanggal_awal) . ' s/d ' . tanggal_indo($tanggal_akhir) . '</p>';
        $html .= '<table border="1" cellpadding="5" cellspacing="0" style="width:100%;">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>No</th>';
        $html .= '<th>Tanggal</th>';
        $html .= '<th>No Tiket</th>';
        $html .= '<th>Nama Klien</th>';
        $html .= '<th>Perihal</th>';
        $html .= '<th>Tags</th>';
        $html .= '<th>Kategori</th>';
        $html .= '<th>Priority</th>';
        $html .= '<th>Impact</th>';
        $html .= '<th>Maxday</th>';
        $html .= '<th>Status CCS</th>';
        $html .= '<th>Handle By</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        $no = 1;
        foreach ($filteredData as $data) {
            $html .= '<tr>';
            $html .= '<td>' . $no . '</td>';
            $html .= '<td>' . tanggal_indo($data['waktu_pelaporan']) . '</td>';
            $html .= '<td>' . $data['no_tiket'] . '</td>';
            $html .= '<td>' . $data['nama'] . '</td>';
            $html .= '<td>' . $data['perihal'] . '</td>';
            $html .= '<td>' . $data['tags'] . '</td>';
            $html .= '<td>' . $data['kategori'] . '</td>';
            $html .= '<td>' . $data['priority'] . '</td>';
            $html .= '<td>' . $data['impact'] . '</td>';
            $html .= '<td>' . $data['maxday'] . '</td>';
            $html .= '<td>' . $data['status_ccs'] . '</td>';
            $html .= '<td>' . $data['handle_by'] . '</td>';
            $html .= '</tr>';
            $no++;
        }

        $html .= '</tbody>';
        $html .= '</table>';

        // Write content to PDF
        $mpdf->WriteHTML($html);


        // Output to browser
        $mpdf->Output('Rekap_Pelaporan.pdf', 'D');
    }

    // public function import_excel()
    // {
    //     $file = $_FILES['file']['tmp_name'];

    //     // Load the Excel file using PHPSpreadsheet
    //     $spreadsheet = IOFactory::load($file);
    //     $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    //     // Process each row of the Excel file
    //     foreach ($sheetData as $row) {
    //         $tanggal = $row['J'];  // Assuming 'B' is the "waktu pelaporan" column
    //         $dateOnly = date('Y-m-d', strtotime($tanggal)); // Extracts the date (YYYY-MM-DD) only

    //         $waktuApprove = !empty($row['K']) && strtotime($row['K']) !== false ? date('Y-m-d', strtotime($row['K'])) : null;

    //         // Map and validate the data as needed
    //         $data = [
    //             'no_tiket' => $row['A'],
    //             'judul' => $row['B'],
    //             'user_id' => $row['C'],
    //             'perihal' => $row['D'],
    //             'nama' => $row['E'],
    //             'kategori' => $row['F'],
    //             'priority' => $row['G'],
    //             'handle_by' => $row['H'],
    //             'status_ccs' => $row['I'],
    //             'waktu_pelaporan' => $dateOnly,
    //             'waktu_approve' => $waktuApprove,
    //             'rating' => $row['L'],
    //             'has_rated' => $row['M'],
    //             // Map other fields as necessary
    //         ];

    //         // Insert into the database
    //         $this->db->insert('pelaporan', $data);
    //     }

    //     // Redirect back with a success message
    //     redirect('superadmin/AllTicket');
    // }

    // public function import_excel()
    // {
    //     $file = $_FILES['file']['tmp_name'];

    //     // Load the Excel file using PHPSpreadsheet
    //     $spreadsheet = IOFactory::load($file);
    //     $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

    //     // Process each row of the Excel file
    //     foreach ($sheetData as $row) {
    //         $noTiket = $row['A']; // Assuming 'B' is the "no_tiket" column

    //         // Skip if no_tiket is empty
    //         if (empty($noTiket)) {
    //             log_message('error', 'No Tiket is missing in one of the rows.');
    //             continue; // Skip this row
    //         }

    //         // Check if no_tiket already exists in the database
    //         $existingTicket = $this->db->get_where('pelaporan', ['no_tiket' => $noTiket])->row_array();
    //         if ($existingTicket) {
    //             log_message('info', 'Duplicate no_tiket: ' . $noTiket . ' - Skipping row.');
    //             continue; // Skip this row if no_tiket already exists
    //         }

    //         // Remove the comma from the datetime format and convert it
    //         $tanggal = !empty($row['K']) ? date('Y-m-d H:i:s', strtotime(str_replace(',', '', $row['K']))) : null;
    //         $waktuApprove = !empty($row['L']) ? date('Y-m-d H:i:s', strtotime(str_replace(',', '', $row['L']))) : null;

    //         $data = [
    //             'no_tiket' => $noTiket,
    //             'judul' => $row['B'],
    //             'user_id' => $row['C'],
    //             'perihal' => $row['D'],
    //             'nama' => $row['E'],
    //             'kategori' => $row['F'],
    //             'priority' => $row['G'],
    //             'handle_by' => $row['H'],
    //             'handle_by2' => $row['I'],
    //             'status_ccs' => $row['J'],
    //             'waktu_pelaporan' => $tanggal, // Converted datetime
    //             'waktu_approve' => $waktuApprove, // Converted datetime
    //             'rating' => $row['M'],
    //             'has_rated' => $row['N'],
    //             'maxday' => $row['O'],
    //             'catatan_finish' => $row['P'],
    //             // Map other fields as necessary
    //         ];

    //         // Insert the data into the database
    //         $this->db->insert('pelaporan', $data);
    //     }

    //     // Redirect back with a success message
    //     redirect('superadmin/AllTicket');
    // }
    public function import_excel()
    {
        $file = $_FILES['file']['tmp_name'];

        // Load the Excel file using PHPSpreadsheet
        $spreadsheet = IOFactory::load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // Process each row of the Excel file
        foreach ($sheetData as $row) {
            $noTiket = $row['A']; // Assuming 'B' is the "no_tiket" column

            // Skip if no_tiket is empty
            if (empty($noTiket)) {
                log_message('error', 'No Tiket is missing in one of the rows.');
                continue; // Skip this row
            }

            // Check if no_tiket already exists in the database
            $existingTicket = $this->db->get_where('pelaporan', ['no_tiket' => $noTiket])->row_array();
            if ($existingTicket) {
                log_message('info', 'Duplicate no_tiket: ' . $noTiket . ' - Skipping row.');
                continue; // Skip this row if no_tiket already exists
            }

            // Handle inconsistent date formats
            $tanggal = $this->convert_date_format($row['K']);
            $waktuApprove = $this->convert_date_format($row['L']);

            $data = [
                'no_tiket' => $noTiket,
                'judul' => $row['B'],
                'user_id' => $row['C'],
                'perihal' => $row['D'],
                'nama' => $row['E'],
                'kategori' => $row['F'],
                'priority' => $row['G'],
                'handle_by' => $row['H'],
                'handle_by2' => $row['I'],
                'status_ccs' => $row['J'],
                'waktu_pelaporan' => $tanggal, // Converted datetime
                'waktu_approve' => $waktuApprove, // Converted datetime
                'rating' => $row['M'],
                'has_rated' => $row['N'],
                'maxday' => $row['O'],
                'catatan_finish' => $row['P'],
            ];

            // Insert the data into the database
            $this->db->insert('pelaporan', $data);
        }

        // Redirect back with a success message
        redirect('superadmin/AllTicket');
    }

    private function convert_date_format($dateString)
    {
        // If the date is empty, return null
        if (empty($dateString)) {
            return null;
        }

        // Check if the date contains a month name (e.g., "10 Oktober 2024")
        $monthNames = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December'
        ];

        // Replace Indonesian month names with English ones
        foreach ($monthNames as $indonesian => $english) {
            if (stripos($dateString, $indonesian) !== false) {
                $dateString = str_ireplace($indonesian, $english, $dateString);
                break;
            }
        }

        // Try to convert the date string to a valid format
        $timestamp = strtotime($dateString);
        if ($timestamp === false) {
            log_message('error', 'Invalid date format: ' . $dateString);
            return null;
        }

        // Return the date in 'Y-m-d H:i:s' format
        return date('Y-m-d H:i:s', $timestamp);
    }



    public function import_excel_to_forward()
    {
        $file = $_FILES['file']['tmp_name'];

        // Load the Excel file using PHPSpreadsheet
        $spreadsheet = IOFactory::load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // Process each row of the Excel file
        foreach ($sheetData as $row) {
            // Map and validate the data as needed
            $data = [
                'pelaporan_id' => $row['A'],
                'user_id' => $row['B'],
                // Map other fields as necessary
            ];

            // Insert into the database
            $this->db->insert('forward', $data);
        }

        // Redirect back with a success message
        redirect('superadmin/AllTicket');
    }

    public function import_excel_to_t1_forward()
    {
        $file = $_FILES['file']['tmp_name'];

        // Load the Excel file using PHPSpreadsheet
        $spreadsheet = IOFactory::load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // Process each row of the Excel file
        foreach ($sheetData as $row) {
            // Map and validate the data as needed
            $data = [
                'pelaporan_id' => $row['A'],
                'user_id' => $row['B'],
                'status' => $row['C'],
                // Map other fields as necessary
            ];

            // Insert into the database
            $this->db->insert('t1_forward', $data);
        }

        // Redirect back with a success message
        redirect('superadmin/AllTicket');
    }

    public function import_excel_to_s_forward()
    {
        $file = $_FILES['file']['tmp_name'];

        // Load the Excel file using PHPSpreadsheet
        $spreadsheet = IOFactory::load($file);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // Process each row of the Excel file
        foreach ($sheetData as $row) {
            // Map and validate the data as needed
            $data = [
                'pelaporan_id' => $row['A'],
                'user_id' => $row['B'],
                // Map other fields as necessary
            ];

            // Insert into the database
            $this->db->insert('s_forward', $data);
        }

        // Redirect back with a success message
        redirect('superadmin/AllTicket');
    }
}
