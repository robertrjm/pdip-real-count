@extends('admin.layout.layouts')
@section('title', 'Admin | Rekapitulasi')

<style>
    /* Accordion Styles */
    .accordion-custom {
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .accordion-header-custom {
        background-color: #f1f1f1;
        padding: 10px;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }

    .accordion-body-custom {
        display: none;
        padding: 10px;
        background-color: #fff;
    }

    .accordion-body-custom.show {
        display: block;
    }

    .accordion-icon {
        font-size: 12px;
    }

    .no-data-message {
        padding: 10px;
        background-color: #f8f9fa;
        border: 1px solid #ddd;
        margin-bottom: 10px;
        color: #555;
        text-align: center;
    }

    /* Progress Bar Styling */
    .progress {
        width: 60%;
        height: 10px;
        margin-left: 10px;
        background-color: #e9ecef;
    }

    .progress-bar {
        background-color: #007bff;
    }

    /* Accordion Header Styling with Progress Bar */
    .accordion-header-custom .progress {
        flex-grow: 1;
        margin-left: 15px;
    }

    /* Image Styling */
    .calon-photo {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-right: 10px;
    }

    /* Input form styling */
    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: bold;
    }

    .form-group input {
        width: 100%;
        padding: 8px;
        box-sizing: border-box;
    }

    .btn {
        margin-top: 10px;
    }

    /* Basic styling for the card */
    .card {
        width: 100%;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        background-color: #fff;
    }

    /* Image at the top of the card */
    .card img {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }

    /* Content inside the card */
    .card-body {
        padding: 15px;
    }

    .card-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .card-text {
        font-size: 1rem;
        color: #666;
        margin-bottom: 20px;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        background-color: #f1f1f1;
    }

    .btn {
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        background-color: #007bff;
        color: white;
        cursor: pointer;
        text-decoration: none;
    }

    .btn:hover {
        background-color: #0056b3;
    }
</style>

@section('content')
    <div class="container">
        <h1>Rekapitulasi Suara</h1>

        <br><br>
        <div class="row">
            @foreach ($calons as $t)
                <div class="col-sm-4">
                    <div class="card">
                        @if ($t->foto)
                            <a target="_blank" href="{{ asset($t->foto) }}"><img src="{{ asset($t->foto) }}" alt="Foto Calon"
                                    width="100%"></a>
                        @endif
                        <div class="card-body">
                            <h2 class="card-title">{{ $t->nama }}</h2>
                            <p class="card-text">
                                {{ $t->partai }}
                            </p>
                        </div>
                        <div class="card-footer">
                            <span>Nomor Urut {{ $t->no_urut }}</span>
                            {{-- <a href="#" class="btn">Read More</a> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- Search Form -->
        <br>
        <div class="row">
            <div class="col-sm-10">
                <form method="GET" action="{{ route('suara.index') }}" class="mb-3">

                    <div class="input-group">
                        <input type="text" name="search" value="{{ request()->get('search') }}" class="form-control"
                            placeholder="Cari Kecamatan...">
                    </div>
            </div>
            <div class="col-sm-2" style="margin-top: -10px">
                <div class="input-group">
                    <button class="btn btn-primary btn-lg" type="submit">Search</button>
                </div>
            </div>
            </form>
        </div>
        <!-- Kecamatan Pagination -->
        <div class="row mb-4">
            <h3>Kecamatan</h3>
            @foreach ($kecamatans as $kecamatan)
                <div class="col-sm-6">
                    <div class="accordion-custom">
                        <div class="accordion-header-custom" onclick="toggleAccordion(this)" aria-expanded="false">
                            Kecamatan: {{ $kecamatan->nama_kecamatan }}

                            @php
                                // Convert $kelurahanData to a collection if it's an array
$kelurahanDataCollection = collect($kelurahanData);

// Hitung total suara di semua kelurahan dalam kecamatan
$totalKelurahan = $kelurahanDataCollection
    ->where('kecamatan_id', $kecamatan->kecamatan_id)
    ->count();

$kelurahanTerisi = $kelurahanDataCollection
    ->where('kecamatan_id', $kecamatan->kecamatan_id)
    ->filter(function ($kelurahan) {
        return isset($kelurahan['total_suara']) && $kelurahan['total_suara'] > 0; // Cek kelurahan terisi
                                    })
                                    ->count();

                                // Progres Kecamatan
                                $kecamatanPercentage =
                                    $totalKelurahan > 0 ? ($kelurahanTerisi / $totalKelurahan) * 100 : 0;
                            @endphp


                            <span class="accordion-icon">&#9660;</span>
                        </div>

                        <div class="accordion-body-custom">
                            @if ($tps->where('nama_kecamatan', $kecamatan->nama_kecamatan)->isEmpty())
                                <div class="no-data-message">Data belum tersedia</div>
                            @else
                                <center>
                                    <h6>Nama Kel/Desa Per TPS</h6>
                                </center>
                                @foreach ($tps->where('nama_kecamatan', $kecamatan->nama_kecamatan)->groupBy('nama_kelurahan') as $kelurahan => $tpsItems)
                                    <div class="accordion-custom">
                                        <div class="accordion-header-custom" onclick="toggleAccordion(this)"
                                            aria-expanded="false">
                                            {{ $kelurahan }}
                                            @php
                                                // Hitung total suara di kelurahan
                                                $kelurahanTotalSuara = $kelurahanDataCollection
                                                    ->where('nama_kelurahan', $kelurahan)
                                                    ->sum('total_suara');

                                                $totalTpsCount = $tpsItems->count();
                                                $filledTpsCount = $tpsItems
                                                    ->filter(function ($item) {
                                                        return $item->total_suara > 0; // Cek apakah TPS sudah terisi
                                                    })
                                                    ->count();

                                                // Progres Kelurahan
                                                $kelurahanPercentage =
                                                    $filledTpsCount === $totalTpsCount
                                                        ? 100
                                                        : ($totalTpsCount > 0
                                                            ? ($filledTpsCount / $totalTpsCount) * 100
                                                            : 0);
                                            @endphp
                                            @if ($kelurahanPercentage >= 1)
                                                <span
                                                    class="badge text-bg-success">{{ number_format($kelurahanPercentage, 2) }}%</span>
                                            @else
                                                <span class="badge text-bg-danger">0%</span>
                                            @endif

                                            <span class="accordion-icon">&#9660;</span>
                                        </div>
                                        <div class="accordion-body-custom">
                                            @if ($tpsItems->isEmpty())
                                                <div class="no-data-message">Data belum tersedia</div>
                                            @else
                                                <ul>
                                                    @foreach ($tpsItems as $item)
                                                        <li>
                                                            <div class="accordion-custom">
                                                                <div class="accordion-header-custom"
                                                                    onclick="toggleAccordion(this)">
                                                                    TPS: {{ $item->nama_tps }}
                                                                    @php
                                                                        // Progres TPS
                                                                        $expectedTotalSuara = 1; // Total suara yang diharapkan
                                                                        $tpsPercentage =
                                                                            $item->total_suara >= $expectedTotalSuara
                                                                                ? 100
                                                                                : ($expectedTotalSuara > 0
                                                                                    ? ($item->total_suara /
                                                                                            $expectedTotalSuara) *
                                                                                        100
                                                                                    : 0);
                                                                    @endphp
                                                                    @if ($tpsPercentage >= 100)
                                                                        <span class="badge text-bg-success">Selesai</span>
                                                                    @else
                                                                        <span class="badge text-bg-danger">Belum</span>
                                                                    @endif
                                                                    <span class="accordion-icon">&#9660;</span>
                                                                </div>

                                                                <div class="accordion-body-custom">
                                                                    <form action="{{ route('suara.updateAll') }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <input type="hidden" name="tps_id"
                                                                            value="{{ $item->tps_id }}">
                                                                        <input type="hidden" name="kelurahan_id"
                                                                            value="{{ $item->kelurahan_id }}">
                                                                        <div class="row">
                                                                            @foreach ($calons as $calon)
                                                                                <div class="col-md-3 mb-3">
                                                                                    <div class="form-group">
                                                                                        <label
                                                                                            for="calon_{{ $calon->calon_id }}">
                                                                                            {{ $calon->no_urut }} |
                                                                                            {{ $calon->nama }}
                                                                                        </label>
                                                                                        @php
                                                                                            $voteKey =
                                                                                                $item->tps_id .
                                                                                                '-' .
                                                                                                $item->kelurahan_id .
                                                                                                '-' .
                                                                                                $calon->calon_id;
                                                                                            $existingVote =
                                                                                                $suaraVotes[$voteKey] ??
                                                                                                null;
                                                                                        @endphp
                                                                                        <input type="hidden"
                                                                                            name="suara_ids[{{ $calon->calon_id }}]"
                                                                                            value="{{ $existingVote->suara_id ?? '' }}">
                                                                                        <input type="number"
                                                                                            name="suara[{{ $calon->calon_id }}]"
                                                                                            id="calon_{{ $calon->calon_id }}"
                                                                                            class="form-control"
                                                                                            placeholder="Jumlah Suara"
                                                                                            value="{{ old('suara.' . $calon->calon_id, $existingVote->jumlah_suara ?? 0) }}">
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                        <button type="submit" class="btn btn-primary">Save
                                                                            All Votes</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            {{ $kecamatans->links() }}
        </div>
    </div>
    <script>
        function toggleAccordion(element) {
            const body = element.nextElementSibling;
            const icon = element.querySelector('.accordion-icon');

            if (body.classList.contains('show')) {
                body.classList.remove('show');
                icon.innerHTML = '&#9660;'; // down arrow
            } else {
                body.classList.add('show');
                icon.innerHTML = '&#9650;'; // up arrow
            }
        }
    </script>
@endsection
