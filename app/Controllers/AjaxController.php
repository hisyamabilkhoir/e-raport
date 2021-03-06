<?php

namespace App\Controllers;

use App\Models\AnggotaKelasModel;
use App\Models\KelasModel;
use App\Models\TahunPelajaranModel;
use App\Models\PegawaiModel;
use App\Models\SiswaModel;
use App\Models\MataPelajaranModel;
use App\Models\KelompokMataPelajaranModel;

class AjaxController extends BaseController
{
    protected $tahun_pelajaran;
    protected $pegawai;
    protected $kelas;
    protected $siswa;
    protected $anggota_kelas;
    protected $mapel;
    protected $KelompokMapel;

    public function __construct()
    {
        $this->tahun_pelajaran = new TahunPelajaranModel();
        $this->pegawai = new PegawaiModel();
        $this->kelas = new KelasModel();
        $this->siswa = new SiswaModel();
        $this->anggota_kelas = new AnggotaKelasModel();
        $this->mapel = new MataPelajaranModel();
        $this->KelompokMapel = new KelompokMataPelajaranModel();
        $this->req = \Config\Services::request();
    }

    public function index()
    {
        $data = [];
        return view('dashboard/tahun_pelajaran/index', $data);
    }

    public function edit_tahun_pelajaran()
    {
        // $year = Year::where("id",)->first();
        $tahunPelajaran = $this->req->getVar('id');
        // dd($tahunPelajaran);
        $data = [
            "tahunPelajaran" => $this->tahun_pelajaran->getTahunPelajaran($tahunPelajaran),
        ];
        return view("ajaxs/form_edit_tahun_pelajaran", $data);
    }

    public function edit_pegawai()
    {
        // $year = Year::where("id",)->first();
        $kode = $this->req->getVar('kode');
        // dd($tahunPelajaran);
        $data = [
            "DetailPegawai" => $this->pegawai->getPegawai($kode),
        ];
        return view("ajaxs/form_edit_pegawai", $data);
    }

    public function edit_kelas()
    {
        // $year = Year::where("id",)->first();
        $kelas = $this->req->getVar('id');
        // dd($kelas);
        $data = [
            "walas" => $this->pegawai->getWalas('2'),
            "kelas" => $this->kelas->getKelas($kelas),
        ];

        return view("ajaxs/form_edit_kelas", $data);
    }

    public function detail_kelas()
    {
        // $year = Year::where("id",)->first();
        $tahunActive = $this->tahun_pelajaran->getActive('1');
        $kelas = $this->req->getVar('id');
        // return '<h1>asd</h1>';
        $data = [
            'walas' => $this->kelas->getDataKelas($tahunActive['tahun_awal'], $tahunActive['tahun_akhir']),
            'semua_kelas' => $this->kelas->getDetailKelas($kelas),
            'id_kelas' => $kelas,
        ];
        // dd($data);
        return view("ajaxs/detail_kelas", $data);
    }

    public function kelas_siswa()
    {
        $kode = $this->req->getVar('kode');
        $idKelas = $this->req->getVar('idKelas');
        $s = $this->siswa->save([
            'kode' => $kode,
            'status' => '2',
        ]);
        $a = $this->anggota_kelas->save([
            'kode_siswa' => $kode,
            'id_kelas' => $idKelas,
        ]);
        // return dd($a);
        if ($s && $a) {
            # code...
            return 'Siswa Berhasil di Tambahkan';
        }
    }

    public function delete_anggota()
    {
        $idAnggota = $this->req->getVar('idAnggota');
        $kodeSiswa = $this->req->getVar('kodeSiswa');
        $s = $this->siswa->save([
            'kode' => $kodeSiswa,
            'status' => '1',
        ]);
        $a = $this->anggota_kelas->delete($idAnggota);
        // return dd($a);
        if ($s && $a) {
            # code...
            return 'Siswa Berhasil di Keluarkan';
        }
    }

    public function tambah_mapel()
    {
        // $year = Year::where("id",)->first();
        $tahunActive = $this->tahun_pelajaran->getActive('1');
        $idKelompokMapel = $this->req->getVar('id');
        $idKelas = $this->req->getVar('idKelas');

        // dd($kelas);
        $data = [
            "idKelompokMapel" => $idKelompokMapel,
            "idKelas" => $idKelas,
            "walas" => $this->pegawai->getWalas('2'),
            "tahunActive" => $tahunActive,
        ];

        return view("ajaxs/tambah_mata_pelajaran", $data);
    }

    public function edit_mapel()
    {
        $tahunActive = $this->tahun_pelajaran->getActive('1');
        $idMapel = $this->req->getVar('id');
        $idKelompok = $this->req->getVar('idKelompok');
        $idKelas = $this->req->getVar('idKelas');
        $data = [
            "walas" => $this->pegawai->getWalas('2'),
            "idKelas" => $idKelas,
            "idKelompok" => $idKelompok,
            "tahunActive" => $tahunActive,
            "mapel" => $this->mapel->getMatapelajaran($idMapel),
            "idKelas" => $idKelas,
        ];

        return view("ajaxs/form_edit_mapel", $data);
    }

    public function edit_kelompok_mapel()
    {
        $tahunActive = $this->tahun_pelajaran->getActive('1');
        $idKelompok = $this->req->getVar('id');
        $idKelas = $this->req->getVar('idKelas');
        $kelompokMapel = $this->KelompokMapel->getKelompokMapel($idKelompok);
        // d($idKelompok);
        // dd($kelompokMapel);
        // dd($idKelas);
        // dd($kelompokMapel);
        $data = [
            "idKelas" => $idKelas,
            "idKelompok" => $idKelompok,
            "tahunActive" => $tahunActive,
            "kelompokMapel" => $kelompokMapel,
        ];
        return view("ajaxs/form_edit_kelompok_mapel", $data);
    }
}
