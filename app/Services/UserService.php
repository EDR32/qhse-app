<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserService
{
    /**
     * Cari user (sistem login) berdasarkan ID.
     * JANGAN UBAH - Ini mungkin digunakan untuk mengambil data pelapor/PIC.
     */
    public function findById(int $id): ?User
    {
        // Menggunakan koneksi master secara eksplisit
        return User::on('pgsql_master')->find($id);
    }

    /**
     * Cari banyak user (sistem login) berdasarkan array of IDs.
     * JANGAN UBAH - Ini mungkin digunakan untuk mengambil data pelapor/PIC.
     */
    public function findByIds(array $ids): Collection
    {
        return User::on('pgsql_master')->whereIn('id', $ids)->get()->keyBy('id');
    }

    /**
     * Cari karyawan di master data berdasarkan payroll_id.
     */
    public function findByPayrollId(string $payrollId)
    {
        return DB::connection('pgsql_master')
            ->table('m_karyawan')
            ->leftJoin('m_division', 'm_karyawan.div_id', '=', 'm_division.div_code')
            ->where('m_karyawan.payroll_id', $payrollId)
            ->select('m_karyawan.payroll_id', 'm_karyawan.nama_karyawan', 'm_division.div_name', 'm_karyawan.tgl_lahir')
            ->first();
    }

    /**
     * Ambil semua user (sistem login).
     */
    public function getAllUsers(): Collection
    {
        return User::on('pgsql_master')->get();
    }

    /**
     * Cari karyawan di master data berdasarkan nama atau payroll_id.
     */
    public function searchByNameOrNik(string $query, int $limit = 10): Collection
    {
        if (empty($query)) {
            return collect();
        }

        return DB::connection('pgsql_master')
            ->table('m_karyawan')
            ->leftJoin('m_division', 'm_karyawan.div_id', '=', 'm_division.div_code')
            ->where(function ($q) use ($query) {
                $q->where('m_karyawan.nama_karyawan', 'ilike', "%{$query}%")
                  ->orWhere('m_karyawan.payroll_id', 'ilike', "%{$query}%");
            })
            ->select('m_karyawan.payroll_id', 'm_karyawan.nama_karyawan', 'm_division.div_name', 'm_karyawan.tgl_lahir')
            ->take($limit)
            ->get();
    }
}
