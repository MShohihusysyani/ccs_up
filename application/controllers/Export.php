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
    }

	public function rekap_pelaporan()
    {
		$data['user'] = $this->db->get_where('user', ['username' => $this->session->userdata('username')])->row_array();
        $this->load->model('Export_model', 'export_model');
        $data['waktu_pelaporan'] = $this->db->get('pelaporan')->result_array();
		$data['no_tiket'] = $this->db->get('pelaporan')->result_array();
		$data['nama'] = $this->db->get('pelaporan')->result_array();
		// $data['judul'] = $this->db->get('pelaporan')->result_array();
		$data['perihal'] = $this->db->get('pelaporan')->result_array();
		$data['tags'] = $this->db->get('pelaporan')->result_array();
		$data['kategori'] = $this->db->get('pelaporan')->result_array();
		$data['priority'] = $this->db->get('pelaporan')->result_array();
		$data['impact'] = $this->db->get('pelaporan')->result_array();
		$data['maxday'] = $this->db->get('pelaporan')->result_array();
		$data['status_ccs'] = $this->db->get('pelaporan')->result_array();
        $data['rekapPelaporan'] = $this->Export_model->getPelaporan();

        $this->load->view('cetak/rekap_pelaporan', $data);
    }


    public function rekap_pelaporan_excel() {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'  => Border::BORDER_THIN],
                'right' => ['borderStyle'  => Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => Border::BORDER_THIN],
                'left' => ['borderStyle'  => Border::BORDER_THIN]
            ]
        ];

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'  => Border::BORDER_THIN],
                'right' => ['borderStyle'  => Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => Border::BORDER_THIN],
                'left' => ['borderStyle'  => Border::BORDER_THIN]
            ]
        ];

        $sheet->setCellValue('A1', "CCS | REKAP PELAPORAN");
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(15);

		date_default_timezone_set('Asia/Jakarta'); # add your city to set local time zone
        $current_date = date('Y-m-d H:i:s');

		$this->db->where('id_user', $this->session->userdata('id_user')); // Assuming user_id is stored in session
        $user_query = $this->db->get('user');
        $user = $user_query->row_array(); // Fetching the user data
		$sheet->setCellValue('A2', "CCS | REKAP PELAPORAN");
		$sheet->setCellValue('A2','Rekap Pelaporan dicetak oleh' .  $user['nama_user']. 'Pada Hari' . format_indo($current_date));
        $sheet->mergeCells('A2:F2');
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getFont()->setSize(15);

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

        // Fetch data from database
        $this->db->select('kategori,id_pelaporan,waktu_pelaporan,status_ccs,priority,maxday,perihal,file,nama,no_tiket,impact,handle_by,status,tags');
        $this->db->from('pelaporan');
        $this->db->where('status_ccs', 'FINISH');
        $query = $this->db->get();
        $no = 1;
        $row = 4;

        foreach ($query->result() as $data) {
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
        $sheet->getColumnDimension('D')->setWidth(35);
        $sheet->getColumnDimension('E')->setWidth(50);
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
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];
    
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
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
