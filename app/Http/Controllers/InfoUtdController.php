<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InfoUtdController extends Controller
{
    public function index()
    {
        // Data UTD/PMI Makassar
        $utds = [
            (object)[
                'name' => 'UTD PMI Kota Makassar',
                'address' => 'Jl. A. P. Pettarani No.1, Makassar, Sulawesi Selatan 90222',
                'phone' => '(0411) 452952',
                'hours' => 'Senin - Jumat: 08:00 - 16:00, Sabtu: 08:00 - 12:00',
                'services' => ['Donor Darah', 'Permintaan Darah', 'Skrining Darah', 'Mobile Unit']
            ],
            (object)[
                'name' => 'UTD RS Wahidin Sudirohusodo',
                'address' => 'Jl. Perintis Kemerdekaan KM.11, Tamalanrea, Makassar',
                'phone' => '(0411) 584677',
                'hours' => 'Senin - Minggu: 24 Jam',
                'services' => ['Donor Darah', 'Permintaan Darah', 'Bank Darah Rumah Sakit']
            ],
            (object)[
                'name' => 'Bank Darah RS Stella Maris',
                'address' => 'Jl. Somba Opu No.273, Makassar',
                'phone' => '(0411) 321721',
                'hours' => 'Senin - Minggu: 24 Jam',
                'services' => ['Donor Darah', 'Permintaan Darah']
            ],
            (object)[
                'name' => 'Bank Darah RS Hermina',
                'address' => 'Jl. Emmy Saelan No.9, Makassar',
                'phone' => '(0411) 421777',
                'hours' => 'Senin - Minggu: 24 Jam',
                'services' => ['Donor Darah', 'Permintaan Darah', 'Tes Laboratorium']
            ],
            (object)[
                'name' => 'Bank Darah RS Siloam',
                'address' => 'Jl. Metro Tanjung Bunga, Makassar',
                'phone' => '(0411) 8911911',
                'hours' => 'Senin - Minggu: 24 Jam',
                'services' => ['Donor Darah', 'Permintaan Darah']
            ],
            (object)[
                'name' => 'UTD PMI Kabupaten Gowa',
                'address' => 'Jl. Tumanurung Raya No.1, Sungguminasa, Gowa',
                'phone' => '(0411) 861234',
                'hours' => 'Senin - Jumat: 08:00 - 15:00',
                'services' => ['Donor Darah', 'Permintaan Darah', 'Mobile Unit']
            ],
            (object)[
                'name' => 'Bank Darah RS Awal Bros',
                'address' => 'Jl. Jenderal Urip Sumoharjo No.43, Makassar',
                'phone' => '(0411) 452696',
                'hours' => 'Senin - Minggu: 24 Jam',
                'services' => ['Donor Darah', 'Permintaan Darah']
            ],
            (object)[
                'name' => 'Bank Darah RS Universitas Hasanuddin',
                'address' => 'Jl. Perintis Kemerdekaan KM.10, Tamalanrea, Makassar',
                'phone' => '(0411) 590721',
                'hours' => 'Senin - Minggu: 24 Jam',
                'services' => ['Donor Darah', 'Permintaan Darah', 'Bank Darah Rumah Sakit']
            ],
            (object)[
                'name' => 'UTD PMI Kabupaten Maros',
                'address' => 'Jl. Sultan Hasanuddin, Maros, Sulawesi Selatan',
                'phone' => '(0411) 371234',
                'hours' => 'Senin - Jumat: 08:00 - 14:00',
                'services' => ['Donor Darah', 'Permintaan Darah']
            ],
        ];

        return view('infoUtd', compact('utds'));
    }
}