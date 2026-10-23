# ⚡ MyApp // System Interface

A modern, user-friendly web application built with Laravel. MyApp features a sleek, subtle cyberpunk-inspired interface with comprehensive dark/light mode support, focusing on high contrast, readability, and smooth micro-interactions without being overly flashy.

## 🚀 Fitur Utama

- **Multi-Provider Authentication**: Login mulus menggunakan Google, Facebook, GitHub, X (Twitter), dan Discord.
- **Account Linking & Security**: Sistem konfirmasi penautan akun ganda (via Provider atau OTP Email) untuk keamanan ekstra saat terjadi konflik email.
- **Interactive Dashboard**: Ringkasan statistik akun media sosial yang terhubung dengan visualisasi data yang bersih dan UI yang terstruktur.
- **Video Management**: Kelola galeri video informasi terintegrasi YouTube (Preview, Tambah, Edit, Hapus, dan pengaturan status Publik/Pribadi) dilengkapi dengan DataTables.
- **User Profile (HUD Style)**: Halaman profil dengan desain potongan sudut (clip-path) futuristik, menampilkan detail identitas, status koneksi, dan keamanan akun.
- **Smart Dark Mode**: Transisi tema instan (Dark/Light) dengan penyimpanan preferensi pengguna di `localStorage` agar tidak terjadi *flash* saat halaman dimuat.
- **Responsive & Accessible**: Dioptimalkan untuk perangkat mobile hingga desktop, dengan dukungan navigasi keyboard (ARIA labels) dan kontras teks yang ramah pengguna.

## 🛠️ Tech Stack

- **Framework**: [Laravel 11.x](https://laravel.com)
- **Styling**: [Tailwind CSS](https://tailwindcss.com) (Custom Theme & Variables)
- **Frontend Bundler**: [Vite](https://vitejs.dev)
- **Icons**: Heroicons (SVG) & Simple Icons (CDN)
- **Libraries**:
  - [SweetAlert2](https://sweetalert2.github.io/) (Notifikasi UI Interaktif)
  - [DataTables](https://datatables.net/) (Manajemen Tabel & Paginasi)
  - [Chart.js](https://www.chartjs.org/) (Statistik Dashboard)

## 📦 Persyaratan Sistem

- PHP >= 8.2
- Composer
- Node.js & NPM
- Database (MySQL / PostgreSQL / SQLite)

## ⚙️ Instalasi & Setup

1. **Clone repositori:**

   ```bash
   git clone https://github.com/username/myapp.git
   cd myapp
   ```

2. **Install dependensi:**

   ```bash
   composer install
   npm install
   ```

3. **Salin file environment dan generate application key:**

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Atur koneksi database** di file `.env`, lalu jalankan migrasi:

   ```bash
   php artisan migrate
   ```

5. **Build aset frontend:**

   ```bash
   npm run build
   # atau jalankan mode development
   npm run dev
   ```

6. **Jalankan server lokal:**

   ```bash
   php artisan serve
   ```

   Aplikasi dapat diakses di `http://localhost:8000`.

## 🔐 Konfigurasi OAuth (Social Login)

Tambahkan kredensial untuk tiap provider ke dalam file `.env`:

```env
# Google
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"

# Facebook
FACEBOOK_CLIENT_ID=your_facebook_client_id
FACEBOOK_CLIENT_SECRET=your_facebook_client_secret
FACEBOOK_REDIRECT_URI="${APP_URL}/auth/facebook/callback"

# GitHub
GITHUB_CLIENT_ID=your_github_client_id
GITHUB_CLIENT_SECRET=your_github_client_secret
GITHUB_REDIRECT_URI="${APP_URL}/auth/github/callback"

# X (Twitter)
X_CLIENT_ID=your_x_client_id
X_CLIENT_SECRET=your_x_client_secret
X_REDIRECT_URI="${APP_URL}/auth/x/callback"

# Discord
DISCORD_CLIENT_ID=your_discord_client_id
DISCORD_CLIENT_SECRET=your_discord_client_secret
DISCORD_REDIRECT_URI="${APP_URL}/auth/discord/callback"
```

> **Catatan:** Pastikan Redirect URI yang didaftarkan di dashboard masing-masing provider sama persis dengan nilai di atas.

## 📄 Lisensi

Proyek ini bersifat open-source dan dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).