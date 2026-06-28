<?php

if (! function_exists('rupiah')) {
    /** Format angka ke Rupiah: Rp 1.000.000 */
    function rupiah($angka): string
    {
        return 'Rp ' . number_format((float) $angka, 0, ',', '.');
    }
}

if (! function_exists('angka')) {
    /** Format angka tanpa Rp: 1.000.000 */
    function angka($angka): string
    {
        return number_format((float) $angka, 0, ',', '.');
    }
}

if (! function_exists('tgl_id')) {
    /** Format tanggal Indonesia: 15 Januari 2024 */
    function tgl_id($date): string
    {
        if (! $date || $date === '0000-00-00') {
            return '-';
        }

        $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $ts = is_numeric($date) ? $date : strtotime((string) $date);

        return date('d', $ts) . ' ' . $bulan[(int) date('n', $ts)] . ' ' . date('Y', $ts);
    }
}

if (! function_exists('terbilang_rupiah')) {
    function terbilang_rupiah($x): string
    {
        return \App\Support\Terbilang::rupiah($x);
    }
}
