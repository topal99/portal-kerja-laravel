<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Lamaran Saya') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
             @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Posisi</th>
                                <th>Perusahaan</th>
                                <th>Tanggal Melamar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($applications as $application)
                                <tr>
                                    <td>{{ $application->jobListing->title }}</td>
                                    <td>{{ $application->jobListing->companyProfile->company_name }}</td>
                                    <td>{{ $application->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if ($application->status == 'Rejected')
                                            {{-- Tampilan khusus jika ditolak --}}
                                            <div class="progress-tracker-rejected">
                                                <i class="bi bi-x-circle-fill text-danger me-2"></i> Ditolak
                                            </div>
                                        @else
                                            {{-- Tampilan progress tracker normal --}}
                                            @php
                                                // Cari tahu di tahap mana lamaran ini sekarang
                                                $currentStageIndex = array_search($application->status, $stages);
                                            @endphp
                                            <div class="progress-tracker">
                                                @foreach ($stages as $index => $stage)
                                                    @php
                                                        // Tentukan class berdasarkan perbandingan index
                                                        $class = '';
                                                        if ($index < $currentStageIndex) {
                                                            $class = 'completed';
                                                        } elseif ($index == $currentStageIndex) {
                                                            $class = 'active';
                                                        }
                                                    @endphp
                                                    <div class="progress-step {{ $class }}">
                                                        <div class="progress-dot"></div>
                                                        <div class="progress-label">{{ $stage == 'Applied' ? 'Terkirim' : $stage }}</div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Anda belum melamar pekerjaan apapun.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>