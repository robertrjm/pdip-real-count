@extends('admin.layout.layouts')
@section('title', 'Admin | Tambah TPS')
@section('content')
    <div class="container">
        <h1>Tambah TPS</h1>
        <form method="POST" action="{{ route('tps.store') }}">
            @csrf
            <div class="form-group">
                <label for="kecamatan_id">Kecamatan</label>
                <select name="kecamatan_id" id="kecamatan_id" class="form-select" required>
                    <option value="">Pilih Kecamatan</option>
                    @foreach ($kecamatans as $kecamatan)
                        <option value="{{ $kecamatan->kecamatan_id }}"
                            {{ old('kecamatan_id') == $kecamatan->kecamatan_id ? 'selected' : '' }}>
                            {{ $kecamatan->nama_kecamatan }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="kelurahan_id">Kelurahan</label>
                <select name="kelurahan_id" id="kelurahan_id" class="form-select" required>
                    <option value="">Pilih Kelurahan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="nama_tps">Nama TPS</label>
                <input type="text" name="nama_tps" id="nama_tps" class="form-control" value="{{ old('nama_tps') }}"
                    required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('tps.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

    <!-- Load Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('kecamatan_id').addEventListener('change', function() {
            const kecamatanId = this.value;
            const kelurahanSelect = document.getElementById('kelurahan_id');
            kelurahanSelect.innerHTML = '<option value="">Loading...</option>';

            if (kecamatanId) {
                axios.get(`/admin/get-kelurahans/${kecamatanId}`)
                    .then(response => {
                        kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
                        // Tangani respons yang merupakan array langsung
                        const kelurahans = response.data;

                        if (Array.isArray(kelurahans)) {
                            kelurahans.forEach(kelurahan => {
                                const option = document.createElement('option');
                                option.value = kelurahan.kelurahan_id; // Gunakan properti yang benar
                                option.text = kelurahan.nama_kelurahan; // Gunakan properti yang benar
                                kelurahanSelect.appendChild(option);
                            });
                        } else {
                            kelurahanSelect.innerHTML = '<option value="">Tidak ada kelurahan</option>';
                        }
                    })
                    .catch(error => {
                        kelurahanSelect.innerHTML = '<option value="">Gagal memuat kelurahan</option>';
                        console.error('Error:', error);
                    });
            } else {
                kelurahanSelect.innerHTML = '<option value="">Pilih Kelurahan</option>';
            }
        });
    </script>
@endsection
