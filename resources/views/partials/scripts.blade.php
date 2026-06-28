<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // 1. Notifikasi kalau ada Error Validasi (Dinamis sesuai error aslinya)
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Waduh!',
            text: "{{ $errors->first() }}", // 🔥 Mengambil pesan error pertama yang dikirim Laravel
            confirmButtonColor: '#F6921E',
        });
    @endif

    // 2. Notifikasi kalau ada Session Error Manual (Misal dari Auth::attempt)
    @if (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Waduh!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#F6921E',
        });
    @endif

    // 3. Notifikasi kalau Berhasil (Login/Logout/Daftar)
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    // 4. Notifikasi Status Umum dari Laravel Breeze
    @if (session('status'))
        Swal.fire({
            icon: 'info',
            title: 'Info',
            text: "{{ session('status') }}",
            confirmButtonColor: '#F6921E',
        });
    @endif
</script>