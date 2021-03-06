<?php

namespace App\Models;

use CodeIgniter\Model;

class PegawaiModel extends Model
{
    protected $table = 'pegawai';
    protected $primaryKey = 'kode';
    protected $allowedFields = ['kode', 'nip', 'nik', 'no_hp', 'jk', 'alamat', 'nama', 'akun_email', 'akun_password', 'status', 'level'];
    public function getPegawai($kode = false)
    {
        if ($kode == false) {
            return $this->findAll();
        }

        return $this->where(['kode' => $kode])->first();
    }

    public function getWalas($level)
    {
        return $this->where(['level' => $level])->findAll();
    }

    public function search($keyword)
    {
        return $this->table('pegawai')->like('nama', $keyword)
            ->orLike('akun_email', $keyword);
    }
}