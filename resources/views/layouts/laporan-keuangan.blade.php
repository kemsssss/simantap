<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ config('app.name', 'berita') }}</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-700 bg-[#f5f5f2] antialiased">
  <header class="bg-white shadow-sm">
    <div class="max-w-6xl mx-auto flex items-center justify-between py-2 px-4">
      <div class="flex items-center gap-3">
        <a href="/home" class="flex items-center gap-3">
          <img src="{{ asset('aset/logoMasjid.svg') }}" alt="Logo" class="w-16 h-16 object-contain">
          <span class="text-xl font-bold text-gray-700">Masjid Jami Tangkubanperahu</span>
        </a>
      </div>
      <nav class="flex gap-2 md:gap-4">
        <a href="/home" class="bg-[#d2cc8c] rounded-full px-3 py-1 text-xs md:text-sm font-semibold shadow hover:bg-[#c6be7b] transition">Home</a>
        <a href="/agenda" class="bg-[#d2cc8c] rounded-full px-3 py-1 text-xs md:text-sm font-semibold shadow hover:bg-[#c6be7b] transition">Agenda</a>
        <a href="/artikel" class="bg-[#d2cc8c] rounded-full px-3 py-1 text-xs md:text-sm font-semibold shadow hover:bg-[#c6be7b] transition">Artikel</a>
        <a href="/berita" class="bg-[#d2cc8c] rounded-full px-3 py-1 text-xs md:text-sm font-semibold shadow hover:bg-[#a5a15a] transition font-bold">Berita</a>
        <a href="/informasi" class="bg-[#d2cc8c] rounded-full px-3 py-1 text-xs md:text-sm font-semibold shadow hover:bg-[#c6be7b] transition">Informasi</a>
	<a href="/laporan-keuangan" class="bg-[#d2cc8c] rounded-full px-3 py-1 text-xs md:text-sm font-semibold shadow hover:bg-[#c6be7b] transition">Laporan-keuangan</a>
        <span id="currentTimeHome" class="font-mono text-xs text-gray-700 bg-white px-3 py-1 rounded-full ml-1"></span>
      </nav>
    </div>
  </header>

  <main class="max-w-6xl mx-auto py-10 px-4">
  <h1 class="text-2xl md:text-3xl font-bold mb-6 text-center text-gray-800">Laporan Keuangan Masjid</h1>

<!-- Ringkasan -->
    <section class="mb-10">
      <h2 class="text-xl font-semibold mb-2 text-gray-700">Ringkasan Saldo</h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow p-4">
          <p class="text-sm text-gray-500">Saldo Awal</p>
          <p class="text-xl font-bold text-green-600">Rp {{ number_format($saldoAwal, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
          <p class="text-sm text-gray-500">Pemasukan</p>
          <p class="text-xl font-bold text-blue-600">Rp {{ number_format($pemasukan, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-xl shadow p-4">
          <p class="text-sm text-gray-500">Pengeluaran</p>
          <p class="text-xl font-bold text-red-600">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</p>
        </div>
      </div>
      <div class="mt-4 bg-gray-100 rounded-xl p-4">
        <p class="text-sm text-gray-500">Saldo Akhir</p>
        <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</p>
      </div>
    </section>

    <!-- Tabel Pemasukan -->
    <section class="mb-10">
      <h2 class="text-xl font-semibold mb-2 text-gray-700">Detail Pemasukan</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-xl shadow text-sm">
          <thead class="bg-[#d2cc8c] text-gray-800">
            <tr>
              <th class="py-2 px-4 text-left">Tanggal</th>
              <th class="py-2 px-4 text-left">Keterangan</th>
              <th class="py-2 px-4 text-left">Jumlah</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @forelse ($laporans->where('jenis', 'pemasukan') as $laporan)
              <tr>
                <td class="py-2 px-4">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</td>
                <td class="py-2 px-4">{{ $laporan->keterangan }}</td>
                <td class="py-2 px-4 text-green-700 font-semibold">Rp {{ number_format($laporan->jumlah, 0, ',', '.') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="py-2 px-4 text-center text-gray-500">Belum ada data pemasukan.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>

    <!-- Tabel Pengeluaran -->
    <section class="mb-10">
      <h2 class="text-xl font-semibold mb-2 text-gray-700">Detail Pengeluaran</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-xl shadow text-sm">
          <thead class="bg-[#d2cc8c] text-gray-800">
            <tr>
              <th class="py-2 px-4 text-left">Tanggal</th>
              <th class="py-2 px-4 text-left">Keterangan</th>
              <th class="py-2 px-4 text-left">Jumlah</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @forelse ($laporans->where('jenis', 'pengeluaran') as $laporan)
              <tr>
                <td class="py-2 px-4">{{ \Carbon\Carbon::parse($laporan->tanggal)->format('d M Y') }}</td>
                <td class="py-2 px-4">{{ $laporan->keterangan }}</td>
                <td class="py-2 px-4 text-red-600 font-semibold">Rp {{ number_format($laporan->jumlah, 0, ',', '.') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="3" class="py-2 px-4 text-center text-gray-500">Belum ada data pengeluaran.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </section>
  </main>

  
   <!-- Footer dengan peta -->
   <footer class="mt-10 bg-[#e8e8e3] border-t border-gray-200 relative overflow-hidden">
    <img src="{{ asset('aset/imagemasjid.svg') }}" alt="Footer Background" class="absolute inset-0 w-full h-full object-cover opacity-30 pointer-events-none select-none" />
    <div class="relative max-w-6xl mx-auto py-8 px-4 grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
      <div class="flex flex-col items-center md:items-start gap-2">
        <img src="{{ asset('aset/logoMasjid.svg') }}" alt="Logo" class="w-21 h-21 object-contain">
        <p class="text-sm font-semibold">Selamat Datang Di Website Resmi Masjid Jami<br>Tangkubanperahu, Jakarta</p>
      </div>
      <div class="md:col-span-2 flex justify-center">
  <div class="relative w-full">
    <button id="toggleMapFullscreen" type="button" class="absolute z-20 top-2 right-2 bg-[#d2cc8c] hover:bg-[#c6be7b] text-gray-800 px-3 py-1 rounded shadow-md text-xs font-semibold transition focus:outline-none focus:ring-2 focus:ring-yellow-400">
      <span id="fullscreenIcon">⛶</span> Fullscreen
    </button>
    <iframe id="mapFrame" src="https://www.openstreetmap.org/export/embed.html?bbox=106.833574%2C-6.208285%2C106.835574%2C-6.206285&layer=mapnik&marker=-6.207285,106.834574" class="w-full h-96 rounded-xl border border-gray-300 shadow transition-all duration-300" allowfullscreen loading="lazy"></iframe>
  </div>
</div>
    </div>
  </footer>
</body>
<script>
// Toggle fullscreen untuk map (sama seperti home.blade.php)
const toggleMapFullscreenBtn = document.getElementById('toggleMapFullscreen');
const mapFrame = document.getElementById('mapFrame');
const fullscreenIcon = document.getElementById('fullscreenIcon');

if (toggleMapFullscreenBtn && mapFrame) {
  toggleMapFullscreenBtn.addEventListener('click', function() {
    const mapContainer = mapFrame.parentElement;
    if (!document.fullscreenElement) {
      if (mapContainer.requestFullscreen) {
        mapContainer.requestFullscreen();
      } else if (mapContainer.webkitRequestFullscreen) { /* Safari */
        mapContainer.webkitRequestFullscreen();
      } else if (mapContainer.msRequestFullscreen) { /* IE11 */
        mapContainer.msRequestFullscreen();
      }
    } else {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      } else if (document.webkitExitFullscreen) { /* Safari */
        document.webkitExitFullscreen();
      } else if (document.msExitFullscreen) { /* IE11 */
        document.msExitFullscreen();
      }
    }
  });

  document.addEventListener('fullscreenchange', function() {
    const mapContainer = mapFrame.parentElement;
    if (document.fullscreenElement === mapContainer) {
      fullscreenIcon.textContent = '🗗';
      toggleMapFullscreenBtn.innerHTML = '<span id="fullscreenIcon">🗗</span> Exit Fullscreen';
      toggleMapFullscreenBtn.classList.add('bg-yellow-300');
      // Ubah map agar benar-benar fullscreen
      mapContainer.style.position = 'fixed';
      mapContainer.style.top = '0';
      mapContainer.style.left = '0';
      mapContainer.style.width = '100vw';
      mapContainer.style.height = '100vh';
      mapContainer.style.zIndex = '9999';
      mapContainer.style.background = '#fff';
      mapFrame.style.width = '100vw';
      mapFrame.style.height = '100vh';
      mapFrame.classList.remove('rounded-xl','border','border-gray-300','shadow');
    } else {
      fullscreenIcon.textContent = '⛶';
      toggleMapFullscreenBtn.innerHTML = '<span id="fullscreenIcon">⛶</span> Fullscreen';
      toggleMapFullscreenBtn.classList.remove('bg-yellow-300');
      // Kembalikan ke semula
      mapContainer.style.position = '';
      mapContainer.style.top = '';
      mapContainer.style.left = '';
      mapContainer.style.width = '';
      mapContainer.style.height = '';
      mapContainer.style.zIndex = '';
      mapContainer.style.background = '';
      mapFrame.style.width = '';
      mapFrame.style.height = '';
      mapFrame.classList.add('rounded-xl','border','border-gray-300','shadow');
    }
  });
}

function pad(n){return n<10?'0'+n:n;}
function updateCurrentTimeHome() {
    const now = new Date();
    const jam = pad(now.getHours());
    const mnt = pad(now.getMinutes());
    const dtk = pad(now.getSeconds());
    const str = `${jam}:${mnt}:${dtk} (WIB)`;
    const el = document.getElementById('currentTimeHome');
    if(el) el.textContent = str;
}
setInterval(updateCurrentTimeHome, 1000);
updateCurrentTimeHome();
</script>
</html>
