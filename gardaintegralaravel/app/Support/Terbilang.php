<?php

namespace App\Support;

/**
 * Helper konversi angka ke terbilang (Bahasa Indonesia).
 * Port dari includes/functions.php aplikasi PHP lama.
 */
class Terbilang
{
    public static function convert($x): string
    {
        $x = abs((int) $x);
        $angka = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam',
                  'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
        $hasil = '';

        if ($x < 12) {
            $hasil = ' ' . $angka[$x];
        } elseif ($x < 20) {
            $hasil = self::convert($x - 10) . ' belas';
        } elseif ($x < 100) {
            $hasil = self::convert(intval($x / 10)) . ' puluh' . self::convert($x % 10);
        } elseif ($x < 200) {
            $hasil = ' seratus' . self::convert($x - 100);
        } elseif ($x < 1000) {
            $hasil = self::convert(intval($x / 100)) . ' ratus' . self::convert($x % 100);
        } elseif ($x < 2000) {
            $hasil = ' seribu' . self::convert($x - 1000);
        } elseif ($x < 1000000) {
            $hasil = self::convert(intval($x / 1000)) . ' ribu' . self::convert($x % 1000);
        } elseif ($x < 1000000000) {
            $hasil = self::convert(intval($x / 1000000)) . ' juta' . self::convert($x % 1000000);
        } elseif ($x < 1000000000000) {
            $hasil = self::convert(intval($x / 1000000000)) . ' miliar' . self::convert(fmod($x, 1000000000));
        } else {
            $hasil = self::convert(intval($x / 1000000000000)) . ' triliun' . self::convert(fmod($x, 1000000000000));
        }

        return $hasil;
    }

    public static function rupiah($x): string
    {
        return ucfirst(trim(self::convert($x))) . ' rupiah';
    }
}
