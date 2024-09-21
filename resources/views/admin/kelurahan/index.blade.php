@extends('admin.layout.layouts')
@section('title', 'Admin | Kelurahan')
@section('content')

    <style>
        /* Accordion Styles */
        .accordion {
            margin: 20px 0;
        }

        .accordion-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .accordion-header {
            background-color: #f1f1f1;
            color: #000000;
            padding: 1rem;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        .accordion-header:hover {
            background-color: #B8001F;
        }

        .accordion-content {
            display: none;
            padding: 1rem;
            background-color: #f8f9fa;
            border-top: 1px solid #ddd;
        }

        .list-group-item {
            border: none;
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
            border-bottom: 1px solid #ddd;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-width: 500px;
            position: relative;
        }

        .close {
            color: #000000;
            float: right;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            padding-top: 15px;
        }

        .modal-footer .btn {
            margin-left: 10px;
        }
    </style>

    <script>
        // Toggle Accordion
        function toggleAccordion(id) {
            var content = document.getElementById(id);
            if (content.style.display === "block") {
                content.style.display = "none";
            } else {
                document.querySelectorAll('.accordion-content').forEach(el => el.style.display = "none");
                content.style.display = "block";
            }
        }

        // Show Modal
        function showModal(id) {
            document.getElementById(id).style.display = "block";
        }

        // Close Modal
        function closeModal(id) {
            document.getElementById(id).style.display = "none";
        }

        // Close modal on clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
            }
        }
    </script>

    <div class="container">
        <h1>Data Kelurahan/Desa Berdasarkan Kecamatan</h1>

        <!-- Search Form -->
        <form method="GET" action="{{ route('kelurahan.index') }}">
            <div class="row mb-4">
                <div class="col-sm-10">
                    <input type="text" name="search_kecamatan" id="search_kecamatan" class="form-control"
                        value="{{ $searchKecamatan }}" placeholder="Search Kecamatan">
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-primary btn-lg" type="submit">Search</button>
                </div>
            </div>
        </form>

        <!-- Display Kecamatan accordion -->
        @if ($kecamatans->isEmpty())
            <p class="text-muted">Data tidak ditemukan</p>
        @else
            <div class="accordion">
                <div class="row">
                    @foreach ($kecamatans as $kecamatan)
                        <div class="col-sm-3">
                            <div class="accordion-item">
                                <div class="accordion-header"
                                    onclick="toggleAccordion('collapse{{ $kecamatan->kecamatan_id }}')">
                                    <h6>{{ $kecamatan->nama_kecamatan }}</h6>
                                    <button class="btn btn-primary btn-sm"
                                        onclick="event.stopPropagation(); showModal('addKelurahanModal{{ $kecamatan->kecamatan_id }}')">+</button>
                                </div>
                                <div id="collapse{{ $kecamatan->kecamatan_id }}" class="accordion-content">
                                    @if (isset($kelurahans[$kecamatan->kecamatan_id]) && $kelurahans[$kecamatan->kecamatan_id]->isNotEmpty())
                                        <ul class="list-group">
                                            @foreach ($kelurahans[$kecamatan->kecamatan_id] as $kelurahan)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    {{ $kelurahan->nama_kelurahan }}
                                                    <div class="btn-group">
                                                        <button class="btn btn-primary btn-sm"
                                                            onclick="showModal('editKelurahanModal{{ $kelurahan->kelurahan_id }}')">
                                                            <i class="fa fa-pencil"></i>
                                                        </button>
                                                        <form
                                                            action="{{ route('kelurahan.destroy', $kelurahan->kelurahan_id) }}"
                                                            method="POST" class="d-inline-block" style="margin-left: -2px">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-sm" type="submit"
                                                                onclick="return confirm('Are you sure?');">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </li>

                                                <!-- Edit Kelurahan Modal -->
                                                <div class="modal" id="editKelurahanModal{{ $kelurahan->kelurahan_id }}">
                                                    <div class="modal-content">
                                                        <span class="close"
                                                            onclick="closeModal('editKelurahanModal{{ $kelurahan->kelurahan_id }}')">&times;</span>
                                                        <h5>Edit Kelurahan/Desa</h5>
                                                        <form method="POST"
                                                            action="{{ route('kelurahan.update', $kelurahan->kelurahan_id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="text" name="nama_kelurahan" class="form-control"
                                                                value="{{ $kelurahan->nama_kelurahan }}" required>
                                                            <input type="hidden" name="kecamatan_id"
                                                                value="{{ $kecamatan->kecamatan_id }}">
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-primary">Update</button>
                                                                <button type="button" class="btn btn-secondary"
                                                                    onclick="closeModal('editKelurahanModal{{ $kelurahan->kelurahan_id }}')">Close</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted">Belum ada kelurahan/Desa</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Add Kelurahan Modal -->
                            <div class="modal" id="addKelurahanModal{{ $kecamatan->kecamatan_id }}">
                                <div class="modal-content">
                                    <span class="close"
                                        onclick="closeModal('addKelurahanModal{{ $kecamatan->kecamatan_id }}')">&times;</span>
                                    <h5>Tambah Kelurahan/Desa</h5>
                                    <form method="POST" action="{{ route('kelurahan.store') }}">
                                        @csrf
                                        <input type="text" name="nama_kelurahan" class="form-control" required>
                                        <input type="hidden" name="kecamatan_id" value="{{ $kecamatan->kecamatan_id }}">
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                            <button type="button" class="btn btn-danger"
                                                onclick="closeModal('addKelurahanModal{{ $kecamatan->kecamatan_id }}')">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="d-flex justify-content-center mt-4">
                {{ $kecamatans->links() }}
            </div>
        @endif
    </div>

@endsection
