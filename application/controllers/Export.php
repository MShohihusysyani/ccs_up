<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class Export extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Export_model');
        $this->load->helper('tanggal_helper');
        $this->load->model('Pelaporan_model');
    }
    public function rekap_pelaporan_pdf()
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
        $mpdf = new \Mpdf\Mpdf(['format' => 'A4']);
    
    //     // Set HTML Header
    //     $header = '
    //         <div style="text-align: center; font-weight: bold; margin-header: 10px;">
    //             <h3>CCS | REKAP PELAPORAN </h3>
    //             <p>Periode ' . tanggal_indo($tanggal_awal) . ' s/d ' . tanggal_indo($tanggal_akhir) . '</p>
    //         </div>
    //     ';
    
    //     $mpdf->SetHTMLHeader($header, 'O');
    
    //     // Set HTML Footer
    //     $mpdf->SetHTMLFooter('
    //     <table width="100%">
    //         <tr>
    //             <td width="33%" style="text-align: right;">Dicetak oleh : ' . $this->session->userdata('nama_user') . '</td>
    //         </tr>
    //     </table>');
    //     $footer = '
    //     <div style="width: 100%; display: flex; justify-content: flex-end; margin-top: 20px; position: relative; ">
    //         <div style="width: 20%; height: 50px; border: 1px solid black; margin-right: 10px;"></div>
    //         <div style="width: 20%; height: 50px; border: 1px solid black; margin-right: 10px;"></div>
    //         <div style="width: 20%; height: 50px; border: 1px solid black;"></div>
    //     </div>
    // ';
    // $mpdf->SetHTMLFooter($footer, 'O');

    $header = '
    <div style="text-align: center; font-weight: bold; margin-bottom: 10px;">
        <h3>CCS | REKAP PELAPORAN </h3>
        <p>Periode ' . tanggal_indo($tanggal_awal) . ' s/d ' . tanggal_indo($tanggal_akhir) . '</p>
    </div>
';

// Set HTML Footer
$footer = '
    <div style="width: 100%; display: flex; justify-content: flex-end; margin-top: 20px; position: relative; ">
        <div style="width: 20%; height: 50px; border: 1px solid black; margin-right: 10px;"></div>
        <div style="width: 20%; height: 50px; border: 1px solid black; margin-right: 10px;"></div>
        <div style="width: 20%; height: 50px; border: 1px solid black;"></div>
    </div>
    <table width="100%">
        <tr>
            <td width="33%" style="text-align: right;">Dicetak oleh : ' . $this->session->userdata('nama_user') . '</td>
        </tr>
    </table>
';
    // Set Header & Footer
    $mpdf->SetHTMLHeader($header);
    $mpdf->SetHTMLFooter($footer);

    // $mpdf->SetWatermarkImage('assets/images/mso.png');
    // $mpdf->showWatermarkImage = true;
    
        // Create table
        $tableHtml = '
            <p style="margin-bottom: 30px;">&nbsp;</p>
            <table border="1" cellpadding="7" cellspacing="0" style="width:100%; border-collapse: collapse; overflow: auto; ">
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
    
        // Fill table with data
        $no = 1;
        foreach ($filteredData as $data) {
            $tableHtml .= '
                <tr>
                    <td>' . $no . '</td>
                    <td>' . tanggal_indo($data['waktu_pelaporan']). '</td>
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
                </tr>';
            $no++;
        }
    
        $tableHtml .= '
                </tbody>
            </table>
        ';
    
        // Write table to PDF
        $mpdf->WriteHTML($tableHtml);

    
        // Output to browser
        $mpdf->Output('Rekap_Pelaporan.pdf', 'D');
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


    public function rekap_pelaporan_excel() {

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
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(15);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $current_date = date('Y-m-d');

		$this->db->where('id_user', $this->session->userdata('id_user')); // Assuming user_id is stored in session
        $user_query = $this->db->get('user');
        $tanggal_awal = $this->input->post('tanggal_awal');
        $tanggal_akhir = $this->input->post('tanggal_akhir');

        $user = $user_query->row_array(); // Fetching the user data
		$sheet->setCellValue('A2', "CCS | REKAP PELAPORAN");
        $sheet->setCellValue('A2', "Peroide : " .tanggal_indo($tanggal_awal) . " s/d " . tanggal_indo($tanggal_akhir));
        // $sheet->setCellValue('A2', 'Dicetak Oleh ' . $user['nama_user'] . ' pada tanggal ' . tanggal_indo($current_date));
        $sheet->mergeCells('A2:F2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getFont()->setSize(15);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Buat header tabel pada baris ke 3
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
        $query = $this->pelaporan_model->getDate($tanggal_awal, $tanggal_akhir, $status_ccs, $nama_klien, $tags);
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
		ob_end_clean();//digunakan ketika file tidak bisa dibuka diexcel
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

    public function rekap_kategori_excel() {
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
                'bottom'=> ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
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


    

    public function rekap_pelaporan_excel_error(){

		$data['rekapPelaporan'] = $this->Export_model->getPelaporan('pelaporan')->result();

		require(APPPATH.'PHPExcel-1.8/Classes/PHPExcel.php');
		require(APPPATH.'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

		$object = new PHPExcel();

		$object->getProperties()->setCreator('PT MSO PWT');
		$object->getProperties()->setLastModifiedBy('PT MSO PWT');
		$object->getProperties()->setTitle('CCS | Rekap Pelaporan');

		$object->setActiveSheetIndex(0);

		$object->getActiveSheet('A1', 'NO');
		$object->getActiveSheet('B1', 'TANGGAL');
		$object->getActiveSheet('C1', 'NO TIKET');
		$object->getActiveSheet('D1', 'NAMA KLIEN');
		$object->getActiveSheet('E1', 'PERIHAL');
		$object->getActiveSheet('F1', 'STATUS CCS');

		$baris = 2;
		$no = 1;

		foreach($rekapPelaporan as $rpe){

			$object->getActiveSheet()->setCellValue('A'.$baris, $no++);
			$object->getActiveSheet()->setCellValue('B'.$baris, tanggal_indo($rpe->waktu_pelaporan));
			$object->getActiveSheet()->setCellValue('C'.$baris, $rpe->no_tiket);
			$object->getActiveSheet()->setCellValue('D'.$baris, $rpe->nama);
			$object->getActiveSheet()->setCellValue('E'.$baris, $rpe->perihal);
			$object->getActiveSheet()->setCellValue('F'.$baris, $rpe->status_ccs);

			$baris++;

		}
		$filename="Rekap pelaporan".'xlsx';

		$object->getActiveSheet()->setTitle('Rekap Pelaporan');

		header('Content-Type : application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Conten-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');

		$writer=PHPExcel_IOFactory::createWriter($object, 'Excel2007');
		$writer->save('php"//output');

		exit;


	}

}
