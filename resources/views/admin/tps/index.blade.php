@extends('admin.layout.layouts')
@section('title', 'Admin | TPS')
{{-- 
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> --}}
<style>
    .accordion-custom {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .accordion-header-custom {
        background-color: #007bff;
        color: white;
        cursor: pointer;
        padding: 10px;
        border-bottom: 1px solid #ddd;
        position: relative;
        user-select: none;
    }

    .accordion-header-custom:hover {
        background-color: #0056b3;
    }

    .accordion-body-custom {
        overflow: hidden;
        transition: max-height 0.5s ease, opacity 0.5s ease;
        max-height: 0;
        opacity: 0;
        padding: 0 15px;
        background-color: #f8f9fa;
    }

    .accordion-body-custom.show {
        max-height: 1000px;
        /* Large value to ensure it can show all content */
        opacity: 1;
    }

    .accordion-body-custom ul {
        list-style: none;
        padding: 0;
    }

    .accordion-body-custom li {
        margin-bottom: 10px;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .accordion-body-custom .btn {
        margin-left: 5px;
    }

    .accordion-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.2em;
        transition: transform 0.3s;
    }

    .accordion-header-custom.active .accordion-icon {
        transform: translateY(-50%) rotate(180deg);
    }

    .no-data-message {
        padding: 15px;
        color: #dc3545;
        text-align: center;
    }
</style>
@section('content')
    <div class="container">
        <h1>Data TPS</h1>
        <a href="{{ route('tps.create') }}" class="btn btn-primary">
            + Tambah TPS
        </a>
        <br><br>

        <!-- Search Form -->
        <form method="GET" action="{{ route('tps.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" value="{{ request()->get('search') }}" class="form-control"
                    placeholder="Cari Kecamatan...">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

        <!-- Kecamatan Pagination -->
        <div class="row mb-4">
            <h3>Kecamatan</h3>
            @foreach ($kecamatans as $kecamatan)
                <div class="col-sm-3">
                    <div class="accordion-custom">
                        <div class="accordion-header-custom" onclick="toggleAccordion(this)" aria-expanded="false">
                            Kecamatan: {{ $kecamatan->nama_kecamatan }}
                            <span class="accordion-icon">&#9660;</span>
                        </div>
                        <div class="accordion-body-custom">
                            @if ($tps->where('nama_kecamatan', $kecamatan->nama_kecamatan)->isEmpty())
                                <div class="no-data-message">Data belum tersedia</div>
                            @else
                                <center>
                                    <h6>Nama Kel/Desa Per TPS </h6>
                                </center>
                                @foreach ($tps->where('nama_kecamatan', $kecamatan->nama_kecamatan)->groupBy('nama_kelurahan') as $kelurahan => $tpsItems)
                                    <div class="accordion-custom">
                                        <div class="accordion-header-custom" onclick="toggleAccordion(this)"
                                            aria-expanded="false">
                                            {{ $kelurahan }}
                                            <span class="accordion-icon">&#9660;</span>
                                        </div>
                                        <div class="accordion-body-custom">
                                            @if ($tpsItems->isEmpty())
                                                <div class="no-data-message">Data belum tersedia</div>
                                            @else
                                                <ul>
                                                    @foreach ($tpsItems as $item)
                                                        <li>
                                                            Tps: {{ $item->nama_tps }}
                                                            <form action="{{ route('tps.destroy', $item->tps_id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="btn-group" role="group"
                                                                    aria-label="TPS actions">
                                                                    {{-- Uncomment if you want to include a view button --}}
                                                                    {{-- <a href="{{ route('tps.show', $item->tps_id) }}"
                                                                        class="btn btn-info btn-sm">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a> --}}
                                                                    <a href="{{ route('tps.edit', $item->tps_id) }}"
                                                                        class="btn btn-primary btn-sm">
                                                                        <i class="fa fa-pencil"></i>
                                                                    </a>

                                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                                        onclick="return confirm('Are you sure?');">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                            </form>
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
