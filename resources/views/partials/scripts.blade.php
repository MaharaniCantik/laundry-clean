<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // 1. Notifikasi kalau ada Error (Misal: Password salah)
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Waduh!',
            text: 'Email atau password kamu salah, cek lagi ya!',
            confirmButtonColor: '#F6921E', // Warna orange desain lu
        });
    @endif

    // 2. Notifikasi kalau Berhasil (Misal: Berhasil Login/Logout)
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    // 3. Notifikasi Status Umum dari Laravel Breeze
    @if (session('status'))
        Swal.fire({
            icon: 'info',
            title: 'Info',
            text: "{{ session('status') }}",
            confirmButtonColor: '#F6921E',
        });
    @endif
</script>