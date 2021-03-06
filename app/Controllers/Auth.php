<?php

namespace App\Controllers;

use App\Models\PegawaiModel;
use App\Models\KelasModel;
use App\Models\TahunPelajaranModel;

class Auth extends BaseController
{
    public function __construct()
    {

        $this->pegawai = new PegawaiModel();
        $this->kelas = new KelasModel();
        $this->tahun_pelajaran = new TahunPelajaranModel();
    }

    public function index()
    {
        return view("auth/login");
    }

    public function proces_login()
    {

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        //$user = $this->db->get_where('user', ['akun_email' => $email])->row_array();
        $user = $this->pegawai->where(['akun_email' => $email])->first();

        if ($user) {

            //jika usernya aktif
            if ($user['status'] == 1) {
                //cek password
                $pass = $user['akun_password'];
                $verify_pass = password_verify($password, $pass);
                if ($verify_pass) {

                    $tahunActive = $this->tahun_pelajaran->getActive('1');
                    if ($user['level'] == '1' && $tahunActive == null) {
                        $data = [
                            'logged_in'     => true,
                            'email' => $user['akun_email'],
                            'level' => $user['level'],
                            'nama' => $user['nama'],
                        ];
                        session()->set($data);
                        session()->setFlashdata('danger', 'Tahun Pelajaran Tidak ada yang aktif, di mohon untuk mengaktifkan tahun pelajaran!');
                        return redirect()->to(base_url('/TahunPelajaran'));
                    }
                    if ($user['level'] != '1'  && $tahunActive == null) {
                        session()->setFlashdata('msg', 'Tahun Pelajaran Tidak ada yang aktif, di mohon untuk memberitahukan operator!');
                        return redirect()->to(base_url('/auth'));
                    }
                    $walas = $this->kelas->where(['kode_walas' => $user['kode'], 'id_tahun_pelajaran' => $tahunActive['id']])->first();

                    if ($walas == null) {
                        $walas = false;
                    } else {
                        $walas = $walas['id'];
                    }

                    $data = [
                        'email' => $user['akun_email'],
                        'level' => $user['level'],
                        'nama' => $user['nama'],
                        'is_walas' => $walas,
                        'tahun_awal' => $tahunActive['tahun_awal'],
                        'tahun_akhir' => $tahunActive['tahun_akhir'],
                        'logged_in'     => true,
                    ];
                    session()->set($data);

                    if ($data['level'] == 1) {
                        return redirect()->to(base_url('/home'));
                    }
                } else {
                    session()->setFlashdata('msg', 'Password salah !');
                    return redirect()->to("/auth");
                }
            } else {
                session()->setFlashdata('msg', 'Email Belum Diaktivasi !');
                return redirect()->to("/auth");
            }
        } else {
            session()->setFlashdata('msg', 'Email Tidak Terdaftar!');
            return redirect()->to("/auth");
        }
    }

    public function logout()
    {
        // session() = session();
        session()->destroy();

        session()->setFlashdata('msg', 'Berhasil Logout!');
        // session()->des
        return redirect()->to("/auth");
        //return redirect()->to("/");
    }
}
