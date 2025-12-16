<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Donor - {{ $pendonor->nama }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #dc2626;
            padding-bottom: 20px;
        }
        
        .header h1 {
            color: #dc2626;
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header h2 {
            font-size: 18px;
            color: #666;
            font-weight: normal;
            margin-bottom: 10px;
        }
        
        .header .info {
            font-size: 11px;
            color: #999;
        }
        
        .donor-info {
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            border: 1px solid #e5e7eb;
        }
        
        .donor-info h3 {
            color: #dc2626;
            font-size: 14px;
            margin-bottom: 12px;
            border-bottom: 2px solid #dc2626;
            padding-bottom: 5px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            font-weight: bold;
            padding: 5px 10px 5px 0;
            width: 30%;
        }
        
        .info-value {
            display: table-cell;
            padding: 5px 0;
        }
        
        .stats-container {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }
        
        .stat-box {
            display: table-cell;
            text-align: center;
            padding: 15px;
            border: 2px solid #dc2626;
            border-radius: 8px;
            margin: 0 5px;
        }
        
        .stat-box:first-child {
            margin-left: 0;
        }
        
        .stat-box:last-child {
            margin-right: 0;
        }
        
        .stat-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        .stat-value {
            font-size: 28px;
            color: #dc2626;
            font-weight: bold;
        }
        
        .stat-desc {
            font-size: 9px;
            color: #999;
            margin-top: 5px;
        }
        
        .section-title {
            font-size: 16px;
            color: #dc2626;
            margin-bottom: 15px;
            font-weight: bold;
            border-bottom: 2px solid #dc2626;
            padding-bottom: 8px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        thead {
            background-color: #dc2626;
            color: white;
        }
        
        th {
            padding: 10px 8px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
        }
        
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 11px;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        tbody tr:hover {
            background-color: #fee2e2;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .status-berhasil {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-gagal {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .golongan-badge {
            display: inline-block;
            padding: 3px 8px;
            background-color: #fee2e2;
            color: #dc2626;
            border-radius: 8px;
            font-weight: bold;
            font-size: 10px;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        
        .footer .thank-you {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
        
        .footer .thank-you h3 {
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .footer .thank-you p {
            font-size: 10px;
            line-height: 1.5;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        
        .no-data p {
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <h1>RIWAYAT DONASI DARAH</h1>
        <h2>KSR PMI UNHAS</h2>
        <div class="info">
            Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y, H:i') }} WIT
        </div>
    </div>

    {{-- Informasi Pendonor --}}
    <div class="donor-info">
        <h3>Informasi Pendonor</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Nama</div>
                <div class="info-value">: {{ $pendonor->nama }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email</div>
                <div class="info-value">: {{ $pendonor->user->email ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">No. HP</div>
                <div class="info-value">: {{ $pendonor->no_hp ?? '-' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Golongan Darah</div>
                <div class="info-value">: <span class="golongan-badge">{{ $pendonor->golongan_darah }}</span></div>
            </div>
            <div class="info-row">
                <div class="info-label">Tanggal Lahir</div>
                <div class="info-value">: {{ $pendonor->tanggal_lahir ? \Carbon\Carbon::parse($pendonor->tanggal_lahir)->format('d F Y') : '-' }}</div>
            </div>
        </div>
    </div>

    {{-- Statistik Donasi --}}
    <div class="stats-container">
        <div class="stat-box">
            <div class="stat-label">Total Berhasil</div>
            <div class="stat-value">{{ $totalBerhasil }}</div>
            <div class="stat-desc">Kantong darah didonasikan</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Nyawa Terselamatkan</div>
            <div class="stat-value">~{{ $nyawaTerselamatkan }}</div>
            <div class="stat-desc">Estimasi dampak donasi</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Tingkat Keberhasilan</div>
            <div class="stat-value">{{ $persentaseKeberhasilan }}%</div>
            <div class="stat-desc">Dari {{ $riwayatDonasi->count() }} percobaan</div>
        </div>
    </div>

    {{-- Tabel Riwayat --}}
    <div class="section-title">Detail Riwayat Donasi</div>
    
    @if($riwayatDonasi->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 8%;">No</th>
                <th style="width: 18%;">Tanggal</th>
                <th style="width: 22%;">Jenis Donor</th>
                <th style="width: 30%;">Lokasi</th>
                <th style="width: 12%;">Volume</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayatDonasi as $index => $donasi)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $donasi->tanggal_donasi->format('d/m/Y') }}</td>
                <td>{{ $donasi->jenis_donor }}</td>
                <td>{{ $donasi->lokasi_donor }}</td>
                <td>{{ $donasi->jumlah_darah }} ml</td>
                <td>
                    @if($donasi->status_donasi == 'Berhasil')
                        <span class="status-badge status-berhasil"> Berhasil</span>
                    @elseif($donasi->status_donasi == 'Terdaftar')
                        <span class="status-badge" style="background-color: #dbeafe; color: #1e40af;">⏳ Terdaftar</span>
                    @elseif($donasi->status_donasi == 'Gagal')
                        <span class="status-badge status-gagal"> Gagal</span>
                    @else
                        <span class="status-badge" style="background-color: #f3f4f6; color: #6b7280;">⊘ Dibatalkan</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="no-data">
        <p><strong>Belum ada riwayat donasi</strong></p>
        <p>Mulai donor darah untuk membantu menyelamatkan nyawa</p>
    </div>
    @endif

    {{-- Footer --}}
    <div class="footer">
        @if($riwayatDonasi->count() > 0)
        <div class="thank-you">
            <h3>Terima Kasih atas Dedikasi Anda!</h3>
            <p>Setiap tetes darah yang Anda donasikan adalah hadiah kehidupan bagi mereka yang membutuhkan.<br>
            Anda telah menunjukkan kepedulian luar biasa kepada sesama.</p>
        </div>
        @endif
        <p>Dokumen ini digenerate secara otomatis oleh sistem KSR PMI UNHAS</p>
        <p>Untuk informasi lebih lanjut, hubungi KSR PMI Universitas Hasanuddin</p>
    </div>
</body>
</html>
