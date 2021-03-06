<?php

namespace App\Controllers;

use App\Models\TahunPelajaranModel;


class TahunPelajaran extends BaseController
{


    protected $tahun_pelajaran;
    public function __construct()
    {
        $this->tahun_pelajaran = new TahunPelajaranModel();
        $this->req = \Config\Services::request();
    }

    public function index()
    {
        $currentPage = $this->request->getGet('page_tahun_pelajaran') ? $this->request->getGet('page_tahun_pelajaran') : 1;
        $dataPerPage = 6;
        $data = [
            "tahunPelajaran" => $this->tahun_pelajaran->getTahunPelajaran(),
            'tahunPelajaran' => $this->tahun_pelajaran->paginate($dataPerPage, 'tahun_pelajaran'),
            'dataPerPage' => $dataPerPage,
            'currentPage' => $currentPage,
            'pager' => $this->tahun_pelajaran->pager,
            "validation" => \Config\Services::validation(),
        ];
        return view('dashboard/tahun_pelajaran/index', $data);
    }

    public function tambah()
    {
        $valid = [
            'awal' => [
                'rules' => 'required|numeric|is_unique[tahun_pelajaran.tahun_awal]|min_length[4]|max_length[4]',
                'errors' => [
                    'numeric' => "Harus menggunakan angka",
                    'required' => 'Tingkat Barang Harus di isi',
                    'is_unique' => 'Tahun Awal Sudah ada',
                    'min_length' => 'Minimal 4 karakter',
                    'max_length' => 'Maximal 4 karakter',
                ],
            ],
            'akhir' => [
                'rules' => 'required|numeric|is_unique[tahun_pelajaran.tahun_akhir]|min_length[4]|max_length[4]',
                'errors' => [
                    'numeric' => "Harus menggunakan angka",
                    'required' => 'Spesifikasi Harus di isi',
                    'is_unique' => 'Tahun akhir sudah ada',
                    'min_length' => 'Minimal 4 karakter',
                    'max_length' => 'Maximal 4 karakter',
                ],
            ],
        ];

        if (!$this->validate($valid)) {
            return redirect()->to(base_url('TahunPelajaran'))->withInput();
        } else {
            $tahunActive = $this->tahun_pelajaran->getActive('1');
            $resultTP = $this->tahun_pelajaran->getActive($this->req->getVar('active'));
            // Jika menambah tahun dengan ceklis aktif
            if ($this->req->getVar('active') == '1') {
                // Cek apakah ada tahun aktif di database
                // Jika ada ganti dengan yang baru di input

                if ($resultTP != null) {
                    $resultTP["status"] = 0;
                    $this->tahun_pelajaran->save([
                        'id' => $resultTP["id"],
                        'tahun_awal' => $resultTP["tahun_awal"],
                        'tahun_akhir' => $resultTP["tahun_akhir"],
                        'titimangsa_siswa_baru' => $resultTP["titimangsa_siswa_baru"],
                        'titimangsa_semester_ganjil' => $resultTP["titimangsa_semester_ganjil"],
                        'titimangsa_semester_genap' => $resultTP["titimangsa_semester_genap"],
                        'status' => 0,
                    ]);
                }


                // Jika tidak ada langsung tambah
                $this->tahun_pelajaran->save([
                    'tahun_awal' => $this->req->getVar('awal'),
                    'tahun_akhir' => $this->req->getVar('akhir'),
                    'titimangsa_siswa_baru' => $this->req->getVar('titimangsa_siswa_baru'),
                    'titimangsa_semester_ganjil' => $this->req->getVar('titimangsa_semester_ganjil'),
                    'titimangsa_semester_genap' => $this->req->getVar('titimangsa_semester_genap'),
                    'status' => $this->req->getVar('active')
                ]);
                session()->setFlashdata('success', 'Data berhasil di buat');
                return redirect()->to(base_url('TahunPelajaran'));
            }
            // Cek Apakah ketika menambah tahun pelajaran ternyata tidak ada yang aktif
            if ($this->req->getVar('active') == null && $tahunActive == null) {
                session()->setFlashdata('danger', 'Tahun pelajaran harus ada yang aktif');
                return redirect()->to(base_url('TahunPelajaran'));
            }

            // Jika tidak memakai ceklis langsung tambah
            $this->tahun_pelajaran->save([
                'tahun_awal' => $this->req->getVar('awal'),
                'tahun_akhir' => $this->req->getVar('akhir'),
                'titimangsa_siswa_baru' => $this->req->getVar('titimangsa_siswa_baru'),
                'titimangsa_semester_ganjil' => $this->req->getVar('titimangsa_semester_ganjil'),
                'titimangsa_semester_genap' => $this->req->getVar('titimangsa_semester_genap'),
                'status' => $this->req->getVar('active')
            ]);
            session()->setFlashdata('success', 'Data berhasil di buat');
            return redirect()->to(base_url('TahunPelajaran'));
        }
    }

    public function update()
    {

        $id = $this->req->getVar('id');
        $awal = $this->req->getVar('update_awal');
        $akhir = $this->req->getVar('update_akhir');

        $uniqueAwal = '';
        $uniqueAkhir = '';
        $dataB = $this->tahun_pelajaran->getTahunPelajaran($id);
        if ($awal != $dataB['tahun_awal']) {
            $uniqueAwal = 'is_unique[tahun_pelajaran.tahun_awal]|';
        } elseif ($akhir != $dataB['tahun_akhir']) {
            $uniqueAkhir = 'is_unique[tahun_pelajaran.tahun_akhir]|';
        }

        $valid = [
            'update_awal' => [
                'rules' => $uniqueAwal . 'required|numeric|min_length[4]|max_length[4]',
                'errors' => [
                    'numeric' => "Harus menggunakan angka",
                    'required' => 'Tingkat Barang Harus di isi',
                    'is_unique' => 'Tahun Awal Sudah ada',
                    'min_length' => 'Minimal 4 karakter',
                    'max_length' => 'Maximal 4 karakter',
                ],
            ],
            'update_akhir' => [
                'rules' => $uniqueAkhir . 'required|numeric|min_length[4]|max_length[4]',
                'errors' => [
                    'numeric' => "Harus menggunakan angka",
                    'required' => 'Spesifikasi Harus di isi',
                    'is_unique' => 'Tahun akhir sudah ada',
                    'min_length' => 'Minimal 4 karakter',
                    'max_length' => 'Maximal 4 karakter',
                ],
            ],
        ];

        if (!$this->validate($valid)) {
            return redirect()->to(base_url('/TahunPelajaran'))->withInput();
        } else {
            // Jika menambah tahun dengan ceklis aktif
            if ($this->req->getVar('active') == '1') {
                $resultTP = $this->tahun_pelajaran->getActive($this->req->getVar('active'));

                // Cek apakah ada tahun aktif di database
                // Jika ada ganti dengan yang baru di input
                if ($resultTP != null) {
                    $resultTP["status"] = 0;
                    $this->tahun_pelajaran->save([
                        'id' => $resultTP["id"],
                        'tahun_awal' => $resultTP["tahun_awal"],
                        'tahun_akhir' => $resultTP["tahun_akhir"],
                        'titimangsa_siswa_baru' => $resultTP["titimangsa_siswa_baru"],
                        'titimangsa_semester_ganjil' => $resultTP["titimangsa_semester_ganjil"],
                        'titimangsa_semester_genap' => $resultTP["titimangsa_semester_genap"],
                        'status' => '0',
                    ]);

                    // Jika tidak ada langsung Ubah
                    $this->tahun_pelajaran->save([
                        'id' => $this->req->getVar('id'),
                        'tahun_awal' => $this->req->getVar('update_awal'),
                        'tahun_akhir' => $this->req->getVar('update_akhir'),
                        'titimangsa_siswa_baru' => $this->req->getVar('titimangsa_siswa_baru'),
                        'titimangsa_semester_ganjil' => $this->req->getVar('titimangsa_semester_ganjil'),
                        'titimangsa_semester_genap' => $this->req->getVar('titimangsa_semester_genap'),
                        'status' => $this->req->getVar('active')
                    ]);
                    session()->setFlashdata('success', 'Data berhasil di ubah');
                    return redirect()->to(base_url('TahunPelajaran'));
                }
            }
            $activeForm = $this->req->getVar('id');
            $resultTP = $this->tahun_pelajaran->getActive('1');
            // Jika ada tahun pelajaran yang non-aktif
            // Cek jika ada tahun yang aktif
            if ($resultTP) {
                // Cek jika user menonaktifkan tahun aktif, tapitidak ada tahun aktif lagi
                if ($resultTP['id'] == $activeForm) {
                    session()->setFlashdata('peringatan', 'Tahun pelajaran harus ada yang aktif');
                    return redirect()->to(base_url('TahunPelajaran'));
                }
            }
            if ($resultTP == null) {
                $this->tahun_pelajaran->save([
                    'id' => $this->req->getVar('id'),
                    'tahun_awal' => $this->req->getVar('update_awal'),
                    'tahun_akhir' => $this->req->getVar('update_akhir'),
                    'titimangsa_siswa_baru' => $this->req->getVar('titimangsa_siswa_baru'),
                    'titimangsa_semester_ganjil' => $this->req->getVar('titimangsa_semester_ganjil'),
                    'titimangsa_semester_genap' => $this->req->getVar('titimangsa_semester_genap'),
                    'status' => $this->req->getVar('active')
                ]);
            }
            session()->setFlashdata('success', 'Data berhasil di ubah');
            return redirect()->to(base_url('TahunPelajaran'));
        }
    }

    public function hapus($id)
    {
        $tahunPelajaran = $this->tahun_pelajaran->find($id);
        if (!$tahunPelajaran) {
            session()->setFlashdata('warning', 'Data yang di cari tidak ada');
            return redirect()->to(base_url('TahunPelajaran'));
        }
        $this->tahun_pelajaran->delete($id);
        session()->setFlashdata('success', 'Data berhasil di hapus');
        return redirect()->to(base_url('TahunPelajaran'));
    }
}
