<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Tps;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Membuat user admin
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'pdip@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('ateblukup'),
            'role' => 'admin', // Role admin
        ]);

        // Data Kecamatan
        $kecamatans = [
            'Kota Soe',
            'Mollo Selatan',
            'Mollo Utara',
            'Amanuban Timur',
            'Amanuban Tengah',
            'Amanuban Selatan',
            'Amanuban Barat',
            'Amanatun Selatan',
            'Amanatun Utara',
            'Kie',
            'Kuanfatu',
            'Fatumnasi',
            'Polen',
            'Batu Putih',
            'Boking',
            'Toianas',
            'Nunkolo',
            'Oenino',
            'Kolbano',
            'Kot\'olin',
            'Kualin',
            'Mollo Barat',
            'Kokbaun',
            'Noebana',
            'Santian',
            'Noebeba',
            'Kuatnana',
            'Fautmolo',
            'Fatukopa',
            'Mollo Tengah',
            'Tobu',
            'Nunbena',
        ];

        $kecamatanIds = [];
        foreach ($kecamatans as $kecamatan) {
            $kecamatanId = Str::uuid();
            $kecamatanModel = Kecamatan::create([
                'kecamatan_id' => $kecamatanId,
                'nama_kecamatan' => $kecamatan,
            ]);
            $kecamatanIds[$kecamatan] = $kecamatanId;
        }

        // Data Kelurahan
        $kelurahans = [
            'Kota Soe' => [
                'Kuatae',
                'Noemeto',
                'Cendana',
                'Kampung Baru',
                'Karang Sirih',
                'Kobekamusa',
                'Kuatae',
                'Nonohonis',
                'Nunumeu',
                'Oekefan',
                'Oebesa',
                'Soe',
                'Taubneno'
            ],
            'Mollo Selatan' => [
                'Bikekneno',
                'Biloto',
                'Bisene',
                'Kesetnana',
                'Noinbila',
                'Oinlasi',
                'Tuasene'
            ],
            'Mollo Utara' => [
                'Ajaobaki',
                'Bijaepunu',
                'Bosen',
                'Eonbesi',
                'Fatukoto',
                'Halmei',
                'Iusmolo',
                'Kokfe\'u',
                'Lelobatan',
                'Leloboko',
                'Nefokoko',
                'Netpala',
                'O\'besi',
                'Sebot',
                'Taiftob',
                'To\'fen',
                'To\'manat',
                'Tunua'
            ],
            'Amanuban Timur' => [
                'Billa',
                'Mauleum',
                'Mnelaanen',
                'Nifukiu',
                'Oe Ekam',
                'Oelet',
                'Pisan',
                'Sini',
                'Telukh',
                'Tliu'
            ],
            'Amanuban Tengah' => [
                'Baki',
                'Bone',
                'Maunum',
                'Niki-niki',
                'Nakfunu',
                'Nobi-nobi',
                'Noebesa',
                'Oeekam',
                'Sopo',
                'Taebesa',
                'Tumu'
            ],
            'Amanuban Selatan' => [
                'Batnun',
                'Bena',
                'Eno Neten',
                'Kiubaat',
                'Linamnutu',
                'Mio',
                'Noemuke',
                'Oebelo',
                'Oekiu',
                'Pollo'
            ],
            'Amanuban Barat' => [
                'Haumenibaki',
                'Mnelalete',
                'Nifukani',
                'Nulle',
                'Nusa',
                'Pusu',
                'Tublopo',
                'Tubuhue'
            ],
            'Amanatun Selatan' => [
                'Anin',
                'Fae',
                'Fatulunu',
                'Fenun',
                'Kokoi',
                'Kuale\'u',
                'Lanu',
                'Netutnana',
                'Nifuleo',
                'Nunle\'u',
                'Oinlasi',
                'Sunu',
                'To\'i'
            ],
            'Amanatun Utara' => [
                'Fatu Oni',
                'Fotilo',
                'Lilo',
                'Muna',
                'Nasi',
                'Snok',
                'Sono',
                'Tauanas',
                'Tumu'
            ],
            'Kie' => [
                'Belle',
                'Boti',
                'Eno Napi',
                'Falas',
                'Fatukusi',
                'Fatuulan',
                'Naile\'u',
                'Napi',
                'Nekmese',
                'Pilli',
                'Oenai',
                'Oinlasi',
                'Tesiayofanu'
            ],
            'Kuanfatu' => [
                'Basmuti',
                'Kakan',
                'Kelle',
                'Kelle Tunan',
                'Kuanfatu',
                'Kusi',
                'Kusi Utara',
                'Lasi',
                'Noebeba',
                'Oebo',
                'Oehan',
                'Olais',
                'Taupi'
            ],
            'Fatumnasi' => [
                'Fatumnasi',
                'Kuanoel',
                'Mutis',
                'Nenas',
                'Nuapin'
            ],
            'Polen' => [
                'Balu',
                'Bijeli',
                'Fatumnutu',
                'Konbaki',
                'Laob',
                'Loli',
                'Mnesatbubuk',
                'Oelnunuh',
                'Puna',
                'Sainoni',
                'Usapimnasi'
            ],
            'Batu Putih' => [
                'Benlutu',
                'Boentuka',
                'Hane',
                'Oebobo',
                'Oehela',
                'Tuakole',
                'Tupan'
            ],
            'Boking' => [
                'Baus',
                'Boking',
                'Fatu Manufui',
                'Leonmeni',
                'Meusin',
                'Nano',
                'Sabun'
            ],
            'Toianas' => [
                'Bokong',
                'Lobus',
                'Milli',
                'Noeolin',
                'Oeleu',
                'Sambet',
                'Skinu',
                'Toianas',
                'Tuataum'
            ],
            'Nunkolo' => [
                'Fat',
                'Fat',
                'Haumeni',
                'Hoineno',
                'Nenoat',
                'Nunkolo',
                'Op',
                'Putun',
                'Saenam',
                'Sahan'
            ],
            'Oenino' => [
                'Abi',
                'Hoi',
                'Neke',
                'Niki Niki Un',
                'Noenoni',
                'Oenino',
                'Pene Utara'
            ],
            'Kolbano' => [
                'Babuin',
                'Haunobenak',
                'Kolbano',
                'Noesiu',
                'Nununamat',
                'Oeleu',
                'Oetuke',
                'Ofu',
                'Pana',
                'Pene Selatan',
                'Spaha',
                'Sei'
            ],
            'Kot\'olin' => [
                'Binenok',
                'Fatuat',
                'Hoibeti',
                'Kot\'olin',
                'Nualunat',
                'Nunbena',
                'O\'obibi',
                'Ponite'
            ],
            'Kualin' => [
                'Kiufatu',
                'Kualin',
                'Nunusunu',
                'Oemaman',
                'Oni',
                'Toineke',
                'Tuafanu',
                'Tuapakas'
            ],
            'Mollo Barat' => [
                'Besana',
                'Fatukoko',
                'Koa',
                'Oel Uban',
                'Salbait'
            ],
            'Kokbaun' => [
                'Benehe',
                'Koloto',
                'Lotas',
                'Niti',
                'Obaki',
                'Sabnala'
            ],
            'Noebana' => [
                'Fatumnasi',
                'Mella',
                'Mnelapetu',
                'Noebana',
                'Suni'
            ],
            'Santian' => [
                'Manufui',
                'Naifatu',
                'Nenotes',
                'Poli',
                'Santian'
            ],
            'Noebeba' => [
                'Eno Nabuasa',
                'Fatutnana',
                'Naip',
                'Oe\'ekam',
                'Oebaki',
                'Oepliki',
                'Teas'
            ],
            'Kuatnana' => [
                'Enoneontes',
                'Lakat',
                'Naukae',
                'O\'of',
                'Oe Oe',
                'Supul',
                'Tetaf',
                'Tubmonas'
            ],
            'Fautmolo' => [
                'Besle\'u',
                'Fautmolo',
                'Kualin',
                'Suhun',
                'Tuakae'
            ],
            'Fatukopa' => [
                'Fatukopa',
                'Matan',
                'Nifo',
                'Oelroet',
                'Salabau'
            ],
            'Mollo Tengah' => [
                'Buna',
                'Oelobok',
                'Oinanar',
                'Sona',
                'Sunu'
            ],
            'Tobu' => [
                'Alieu',
                'Kali',
                'Nefina',
                'Nokoni',
                'Oeleli',
                'Poli',
                'Putuk',
                'Sake'
            ],
            'Nunbena' => [
                'Andinok',
                'Bikekanan',
                'Bokok',
                'Dabone',
                'Nunbena',
                'Pakole',
                'Tumbo'
            ]
        ];

        // Mengisi Kelurahan dan TPS
        foreach ($kelurahans as $kecamatanName => $kelurahanNames) {
            $kecamatanId = $kecamatanIds[$kecamatanName];
            foreach ($kelurahanNames as $kelurahan) {
                $kelurahanId = Str::uuid();
                Kelurahan::create([
                    'kelurahan_id' => $kelurahanId,
                    'nama_kelurahan' => $kelurahan,
                    'kecamatan_id' => $kecamatanId,
                ]);

                // Menambahkan 5 TPS untuk setiap Kelurahan
                for ($i = 1; $i <= 5; $i++) {
                    Tps::create([
                        'tps_id' => Str::uuid(),
                        'kelurahan_id' => $kelurahanId,
                        'nama_tps' => sprintf('%03d', $i),
                    ]);
                }
            }
        }
    }
}
