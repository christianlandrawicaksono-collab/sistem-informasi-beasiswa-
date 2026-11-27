@extends('layouts.app')

@section('title', 'Perangkingan SPK SAW')

@section('content')
<div data-motion="hero-item" class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <span class="nomu-label text-[#FF7448] block mb-1.5">Decision Support System</span>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0F151D]">
            Perangkingan Metode <span class="text-[#FF7448]">SAW</span>
        </h1>
        <p class="text-xs text-[#5B6573] mt-1">Normalisasi matriks keputusan Benefit/Cost dan perhitungan preferensi kandidat secara objektif.</p>
    </div>

    @if($beasiswaDipilih)
        <form action="{{ route('reviewer.hitung.saw', $beasiswaDipilih->id) }}" method="POST">
            @csrf
            <button type="submit" data-motion="pill-press" class="nomu-cta-btn px-6 py-3 rounded-full text-xs font-bold inline-flex items-center gap-2 cursor-pointer">
                <svg class="size-4" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/></svg>
                <span>Hitung Ulang Skor SAW</span>
            </button>
        </form>
    @endif
</div>

<!-- Panel Bobot Kriteria SAW -->
@if($beasiswaDipilih && $beasiswaDipilih->kriteria->isNotEmpty())
<div data-motion="reveal" class="nomu-panel p-6 sm:p-7 mb-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5 pb-4 border-b border-[#0F151D]/8">
        <div>
            <span class="nomu-label text-[#526991] block">Matriks Kriteria</span>
            <h2 class="text-base font-extrabold text-[#0F151D]">{{ $beasiswaDipilih->nama_program }}</h2>
        </div>
        <span class="px-3.5 py-1.5 rounded-full bg-[#E4EDFF] text-[#243C61] text-xs font-mono font-bold tabular-nums self-start sm:self-auto">
            Alokasi Kuota: {{ $beasiswaDipilih->kuota }} Mahasiswa
        </span>
    </div>

    <div data-motion="stagger-grid" class="grid grid-cols-2 sm:grid-cols-4 gap-3.5">
        @foreach($beasiswaDipilih->kriteria as $crit)
            <div data-motion-card class="p-4 rounded-[20px] bg-[#FFF9F6] border border-[#0F151D]/8">
                <div class="flex justify-between items-center mb-2">
                    <span class="nomu-label text-[#5B6573]">{{ $crit->kode_kriteria }}</span>
                    <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase {{ $crit->sifat === 'benefit' ? 'bg-[#E5F3EE] text-[#237C65]' : 'bg-[#FFEAE3] text-[#B83209]' }}">
                        {{ $crit->sifat }}
                    </span>
                </div>
                <h3 class="text-xs font-bold text-[#0F151D] mb-1">{{ $crit->nama_kriteria }}</h3>
                <p class="text-2xl font-extrabold text-[#0F151D] font-mono tabular-nums">{{ $crit->bobot }}%</p>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- Nomu-Signature Highlighted SAW Ranking Table -->
<div data-motion="reveal" class="nomu-panel p-2 sm:p-3 overflow-hidden mb-8">
    <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <span class="nomu-label text-[#FF7448] block">Hasil Evaluasi Otomatis</span>
            <h2 class="text-base font-extrabold text-[#0F151D]">Peringkat Kandidat Penerima Beasiswa</h2>
        </div>
        <button type="button" onclick="window.print()" data-motion="pill-press" class="px-4 py-2 rounded-full bg-[#F1EBE9] hover:bg-[#E4EDFF] text-[#0F151D] text-xs font-bold transition inline-flex items-center gap-2 cursor-pointer self-start sm:self-auto">
            <svg class="size-3.5" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect width="12" height="8" x="6" y="14"/></svg>
            <span>Cetak / Ekspor PDF</span>
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[760px]">
            <thead>
                <tr class="text-[11px] font-mono uppercase tracking-wider text-[#5B6573]">
                    <th class="p-4 text-center">Rank</th>
                    <th class="p-4">Mahasiswa</th>
                    <th class="p-4 text-center">C1 · IPK</th>
                    <th class="p-4 text-center">C2 · Gaji Ortu</th>
                    <th class="p-4 text-center">C3 · Tanggungan</th>
                    <th class="p-4 text-center">C4 · Prestasi</th>
                    <th class="p-4 text-right bg-[#D3E1FF] text-[#243C61] rounded-tl-[20px]">Skor SAW (Vi)</th>
                    <th class="p-4 text-center bg-[#D3E1FF] text-[#243C61] rounded-tr-[20px]">Rekomendasi</th>
                </tr>
            </thead>
            <tbody data-motion="table-stagger" class="text-sm">
                @forelse($ranking as $idx => $r)
                    @php
                        $isWinner = ($idx + 1) <= ($beasiswaDipilih->kuota ?? 0);
                        $isOdd = $idx % 2 === 0;
                    @endphp
                    <tr class="border-t border-[#0F151D]/6 transition hover:bg-[#FFF9F6]/60">
                        <td class="p-4 text-center {{ $isOdd ? 'bg-[#F8F9FB]' : '' }}">
                            @if($idx === 0)
                                <span class="size-7 rounded-full bg-[#FF7448] text-white font-mono font-extrabold text-xs inline-flex items-center justify-center shadow-xs">01</span>
                            @elseif($idx === 1)
                                <span class="size-7 rounded-full bg-[#0F151D] text-white font-mono font-extrabold text-xs inline-flex items-center justify-center">02</span>
                            @elseif($idx === 2)
                                <span class="size-7 rounded-full bg-[#D3E1FF] text-[#243C61] font-mono font-extrabold text-xs inline-flex items-center justify-center">03</span>
                            @else
                                <span class="font-mono font-bold text-[#5B6573] tabular-nums">{{ str_pad($idx + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            @endif
                        </td>
                        <td class="p-4 {{ $isOdd ? 'bg-[#F8F9FB]' : '' }}">
                            <span class="font-bold text-[#0F151D] block">{{ $r->profil->nama_lengkap }}</span>
                            <span class="text-xs font-mono text-[#5B6573]">{{ $r->profil->nim }} · {{ $r->profil->prodi }}</span>
                        </td>
                        <td class="p-4 text-center font-mono text-xs font-semibold tabular-nums {{ $isOdd ? 'bg-[#F8F9FB]' : '' }}">
                            {{ number_format($r->profil->ipk, 2) }}
                        </td>
                        <td class="p-4 text-center font-mono text-xs text-[#5B6573] tabular-nums {{ $isOdd ? 'bg-[#F8F9FB]' : '' }}">
                            Rp {{ number_format($r->profil->penghasilan_ortu, 0, ',', '.') }}
                        </td>
                        <td class="p-4 text-center font-mono text-xs tabular-nums {{ $isOdd ? 'bg-[#F8F9FB]' : '' }}">
                            {{ $r->profil->jumlah_tanggungan }}
                        </td>
                        <td class="p-4 text-center font-mono text-xs tabular-nums {{ $isOdd ? 'bg-[#F8F9FB]' : '' }}">
                            {{ $r->profil->skor_prestasi }}
                        </td>
                        <td class="p-4 text-right font-mono font-extrabold text-base text-[#243C61] tabular-nums {{ $isOdd ? 'bg-[#DCE7FF]' : 'bg-[#E4EDFF]' }} {{ $loop->last ? 'rounded-bl-[20px]' : '' }}">
                            {{ number_format($r->total_skor_saw, 4) }}
                        </td>
                        <td class="p-4 text-center {{ $isOdd ? 'bg-[#DCE7FF]' : 'bg-[#E4EDFF]' }} {{ $loop->last ? 'rounded-br-[20px]' : '' }}">
                            @if($r->status_tahap === 'diterima')
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full bg-white text-[#237C65]">
                                    <svg class="size-3" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                                    Diterima
                                </span>
                            @elseif($r->status_tahap === 'ditolak')
                                <span class="text-xs font-bold px-3 py-1 rounded-full bg-[#FFEAE3] text-[#B83209]">Ditolak</span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full {{ $isWinner ? 'bg-white text-[#237C65] shadow-2xs' : 'bg-white/60 text-[#5B6573]' }}">
                                    @if($isWinner)
                                        <svg class="size-3" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>
                                    @endif
                                    {{ $isWinner ? 'Masuk Kuota' : 'Cadangan' }}
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-12 text-center text-xs text-[#5B6573]">
                            Belum ada perangkingan SAW yang dihitung untuk beasiswa ini.<br>
                            Klik tombol <strong>"Hitung Ulang Skor SAW"</strong> di kanan atas untuk memulai kalkulasi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
