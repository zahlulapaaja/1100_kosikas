@extends('layouts.app')

@section('title', 'Kalender Jadwal')

@section('content')
    <div class="cal-page">

        {{-- ====== Header + filter ====== --}}
        <div class="cal-hero mb-3">
            <div>
                <h4 class="section-title mb-1"><i class="bi bi-calendar3 me-2"></i>Kalender Jadwal</h4>
                <div class="cal-sub">
                    Jadwal penerbangan dan hotel semua pesanan. Jam penerbangan mengikuti zona waktu bandara
                    masing-masing.
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <div id="calLoading" class="spinner-border spinner-border-sm text-secondary d-none" role="status">
                    <span class="visually-hidden">Memuat jadwal</span>
                </div>

                <div class="btn-group type-filter" role="group" aria-label="Filter jenis jadwal">
                    <input type="radio" class="btn-check" name="type" id="type-all" value="all" checked>
                    <label class="btn btn-outline-secondary" for="type-all">Semua</label>

                    <input type="radio" class="btn-check" name="type" id="type-flight" value="flight">
                    <label class="btn btn-outline-secondary" for="type-flight">
                        <i class="bi bi-airplane-fill dot-flight me-1"></i>Penerbangan
                    </label>

                    <input type="radio" class="btn-check" name="type" id="type-hotel" value="hotel">
                    <label class="btn btn-outline-secondary" for="type-hotel">
                        <i class="bi bi-building dot-hotel me-1"></i>Hotel
                    </label>
                </div>
            </div>
        </div>

        {{-- ====== Penerbangan terdekat ====== --}}
        @php
            $todayCount = $upcoming->where('level', 'today')->count();
            $tomorrowCount = $upcoming->where('level', 'tomorrow')->count();
        @endphp

        @if ($todayCount > 0)
            <div class="alert alert-urgent d-flex align-items-center gap-3 mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                <div>
                    <strong>{{ $todayCount }} penerbangan berangkat hari ini.</strong>
                    Pastikan e-ticket sudah terkirim ke penumpang.
                </div>
            </div>
        @endif

        <div class="mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                <h6 class="next-heading mb-0">Berangkat dalam 7 hari ke depan</h6>

                @if ($upcoming->isNotEmpty())
                    <div class="stat-chips">
                        <span class="stat-chip stat-chip--today {{ $todayCount ? 'is-on' : '' }}">
                            Hari ini <b>{{ $todayCount }}</b>
                        </span>
                        <span class="stat-chip stat-chip--tomorrow {{ $tomorrowCount ? 'is-on' : '' }}">
                            Besok <b>{{ $tomorrowCount }}</b>
                        </span>
                        <span class="stat-chip">7 hari <b>{{ $upcoming->count() }}</b></span>
                    </div>
                @endif
            </div>

            @if ($upcoming->isEmpty())
                <div class="next-empty">
                    <i class="bi bi-check2-circle me-2"></i>Tidak ada keberangkatan dalam 7 hari ke depan.
                </div>
            @else
                <div class="row g-3">
                    @foreach ($upcoming as $f)
                        <div class="col-12 col-md-6 col-xl-3">
                            <button type="button" class="next-flight next-flight--{{ $f['level'] }}"
                                data-event-id="flight-{{ $f['id'] }}" data-date="{{ $f['date_iso'] }}">
                                <span class="nf-top">
                                    <span class="nf-chip">{{ $f['label'] }}</span>
                                    <span class="nf-time">
                                        {{ $f['time'] ?? 'Jam belum diisi' }}
                                        @if (!empty($f['tz']))
                                            <small class="nf-tz">{{ $f['tz'] }}</small>
                                        @endif
                                    </span>
                                </span>
                                <span class="nf-route">
                                    <i class="bi bi-airplane-fill nf-plane"></i>{{ $f['route'] }}
                                </span>
                                <span class="nf-code">{{ $f['airline'] }} &nbsp;{{ $f['code'] }}</span>
                                @if (!empty($f['arrival']))
                                    <span class="nf-arrival">
                                        <i class="bi bi-box-arrow-in-down-right me-1"></i>{{ $f['arrival'] }}
                                    </span>
                                @endif
                                @if ($f['detail'])
                                    <span class="nf-detail">{{ $f['detail'] }}</span>
                                @endif
                                <span class="nf-pax"><i class="bi bi-person-fill me-1"></i>{{ $f['passenger'] }}</span>
                                <span class="nf-foot">
                                    <span class="badge bg-primary">{{ $f['pnr'] }}</span>
                                    <span class="nf-date">{{ $f['date_text'] }}</span>
                                </span>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- ====== Kalender ====== --}}
        <div class="card card-section cal-card">
            <div class="card-body">
                <div class="cal-legend">
                    <span class="legend-item"><i class="bi bi-circle-fill legend-flight"></i>Penerbangan</span>
                    <span class="legend-item"><i class="bi bi-circle-fill legend-hotel"></i>Hotel</span>
                    <span class="legend-item legend-note"><i class="bi bi-clock me-1"></i>Jam = waktu lokal bandara</span>
                </div>

                <div id="calendar" data-events-url="{{ route('travel.calendar.events') }}"></div>
                <div id="calEmpty" class="cal-empty d-none">
                    <i class="bi bi-calendar-x me-2"></i>Tidak ada jadwal pada periode ini.
                </div>
            </div>
        </div>

        {{-- ====== Modal detail ====== --}}
        <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="detailHeadline" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 overflow-hidden">
                    <div class="detail-head" id="detailHead">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="detail-kind"><i id="detailIcon" class="bi me-1"></i><span
                                    id="detailKind"></span></span>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                aria-label="Tutup"></button>
                        </div>
                        <div class="detail-headline" id="detailHeadline"></div>
                        <div class="detail-subline" id="detailSubline"></div>
                    </div>
                    <div class="modal-body">
                        <dl class="detail-list mb-0" id="detailList"></dl>
                    </div>
                    <div class="modal-footer">
                        <a href="#" id="detailLink" target="_blank" class="btn btn-primary d-none"></a>
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .cal-page {
                --k-blue: #2E75B6;
                --k-navy: #16324F;
                --k-urgent: #B42318;
                --k-urgent-bg: #FEF3F2;
                --k-line: #E6ECF2;
                --k-muted: #5B6B7B;

                /* penerbangan = oranye, hotel = biru; versi pekat untuk aksen, versi lembut untuk latar */
                --c-flight: #D4411F;
                --c-flight-bg: #FDEEE8;
                --c-flight-bd: #F6C9B8;
                --c-flight-tx: #9A3412;
                --c-hotel: #2E75B6;
                --c-hotel-bg: #EAF2FA;
                --c-hotel-bd: #BBD3EA;
                --c-hotel-tx: #1F5A94;
            }

            /* ===== Header ===== */
            .cal-page .cal-hero {
                display: flex;
                flex-wrap: wrap;
                justify-content: space-between;
                align-items: center;
                gap: .75rem;
            }

            .cal-page .cal-sub {
                font-size: .85rem;
                color: var(--k-muted);
                max-width: 46rem;
            }

            /* Filter: segmented control */
            .cal-page .type-filter {
                background: #fff;
                border: 1px solid #D5DEE8;
                border-radius: 999px;
                padding: 3px;
                gap: 2px;
            }

            .cal-page .type-filter>.btn {
                border: 0;
                border-radius: 999px !important;
                padding: .35rem .95rem;
                font-size: .85rem;
                font-weight: 500;
                color: var(--k-muted);
            }

            .cal-page .type-filter>.btn:hover {
                background: #EEF3F8;
                color: var(--k-navy);
            }

            .cal-page .type-filter .btn-check:checked+.btn {
                background: var(--k-navy);
                color: #fff;
            }

            .cal-page .btn-check:focus-visible+.btn {
                box-shadow: 0 0 0 3px rgba(46, 117, 182, .35);
            }

            .cal-page .dot-flight {
                color: var(--c-flight);
            }

            .cal-page .dot-hotel {
                color: var(--c-hotel);
            }

            .cal-page .btn-check:checked+.btn .dot-flight,
            .cal-page .btn-check:checked+.btn .dot-hotel {
                color: #fff;
            }

            /* ===== Alert hari ini ===== */
            .cal-page .alert-urgent {
                background: var(--k-urgent-bg);
                border: 1px solid #FDA29B;
                border-left: 5px solid var(--k-urgent);
                border-radius: .75rem;
                color: #7A1B12;
            }

            /* ===== Penerbangan terdekat ===== */
            .cal-page .next-heading {
                color: var(--k-navy);
                font-weight: 600;
            }

            .cal-page .stat-chips {
                display: flex;
                gap: .4rem;
                flex-wrap: wrap;
            }

            .cal-page .stat-chip {
                font-size: .78rem;
                padding: .15rem .65rem;
                border-radius: 999px;
                background: #EEF3F8;
                color: var(--k-muted);
            }

            .cal-page .stat-chip b {
                margin-left: .2rem;
                color: var(--k-navy);
            }

            .cal-page .stat-chip--today.is-on {
                background: var(--k-urgent);
                color: #fff;
            }

            .cal-page .stat-chip--today.is-on b {
                color: #fff;
            }

            .cal-page .stat-chip--tomorrow.is-on {
                background: var(--k-navy);
                color: #fff;
            }

            .cal-page .stat-chip--tomorrow.is-on b {
                color: #fff;
            }

            .cal-page .next-empty {
                padding: .85rem 1rem;
                background: #F4F7FA;
                border-radius: .75rem;
                color: var(--k-muted);
            }

            .cal-page .next-flight {
                display: flex;
                flex-direction: column;
                gap: .3rem;
                width: 100%;
                height: 100%;
                text-align: left;
                padding: .9rem 1rem;
                background: #fff;
                border: 1px solid var(--k-line);
                border-top: 4px solid #9FB3C8;
                border-radius: .85rem;
                box-shadow: 0 1px 2px rgba(22, 50, 79, .05);
                transition: box-shadow .15s, transform .15s;
            }

            .cal-page .next-flight:hover {
                box-shadow: 0 8px 20px rgba(22, 50, 79, .12);
                transform: translateY(-2px);
            }

            .cal-page .next-flight:focus-visible {
                outline: 3px solid rgba(46, 117, 182, .45);
                outline-offset: 2px;
            }

            .cal-page .next-flight--today {
                background: var(--k-urgent-bg);
                border-color: #FDA29B;
                border-top-color: var(--k-urgent);
            }

            .cal-page .next-flight--tomorrow {
                border-top-color: var(--k-navy);
            }

            .cal-page .nf-top {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .cal-page .nf-chip {
                font-size: .75rem;
                font-weight: 600;
                padding: .15rem .6rem;
                border-radius: 999px;
                background: #E8F0F8;
                color: var(--k-navy);
            }

            .cal-page .next-flight--today .nf-chip {
                background: var(--k-urgent);
                color: #fff;
            }

            .cal-page .next-flight--tomorrow .nf-chip {
                background: var(--k-navy);
                color: #fff;
            }

            .cal-page .nf-time {
                font-weight: 700;
                color: var(--k-navy);
                font-variant-numeric: tabular-nums;
            }

            .cal-page .nf-tz {
                font-size: .68rem;
                font-weight: 500;
                color: var(--k-muted);
                margin-left: .15rem;
            }

            .cal-page .nf-route {
                font-size: 1.3rem;
                font-weight: 700;
                color: var(--k-navy);
                line-height: 1.25;
            }

            .cal-page .nf-plane {
                font-size: 1rem;
                color: var(--c-flight);
                margin-right: .45rem;
            }

            .cal-page .nf-code {
                font-size: .85rem;
                color: var(--k-muted);
            }

            .cal-page .nf-arrival {
                font-size: .82rem;
                color: var(--k-muted);
            }

            .cal-page .nf-detail {
                font-size: .85rem;
                font-weight: 600;
                color: var(--k-urgent);
            }

            .cal-page .nf-pax {
                font-size: .9rem;
                color: #1F2D3D;
            }

            .cal-page .nf-foot {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: auto;
                padding-top: .5rem;
                border-top: 1px dashed var(--k-line);
                font-size: .8rem;
                color: var(--k-muted);
            }

            /* ===== Kalender ===== */
            .cal-page .cal-card {
                border-radius: 1rem;
            }

            .cal-page .cal-legend {
                display: flex;
                flex-wrap: wrap;
                align-items: center;
                gap: .4rem 1.1rem;
                margin-bottom: .85rem;
                font-size: .82rem;
                color: var(--k-muted);
            }

            .cal-page .legend-item i {
                font-size: .6rem;
                margin-right: .4rem;
                vertical-align: .1em;
            }

            .cal-page .legend-flight {
                color: var(--c-flight);
            }

            .cal-page .legend-hotel {
                color: var(--c-hotel);
            }

            .cal-page .legend-note {
                margin-left: auto;
            }

            .cal-page .legend-note i {
                font-size: .8rem;
                vertical-align: baseline;
                margin-right: 0;
            }

            .cal-page #calendar {
                --fc-border-color: var(--k-line);
                --fc-today-bg-color: #F3F8FD;
                --fc-page-bg-color: #fff;
                transition: opacity .15s;
            }

            .cal-page #calendar.is-loading {
                opacity: .6;
            }

            .cal-page #calendar .fc-toolbar {
                gap: .5rem;
            }

            .cal-page #calendar .fc-toolbar-title {
                font-size: 1.2rem;
                color: var(--k-navy);
                font-weight: 700;
            }

            .cal-page #calendar .fc-col-header-cell {
                background: #F7FAFC;
            }

            .cal-page #calendar .fc-col-header-cell-cushion {
                color: var(--k-muted);
                font-size: .75rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: .04em;
                text-decoration: none;
                padding: .5rem 0;
            }

            .cal-page #calendar .fc-daygrid-day-number {
                color: #3B4B5C;
                font-size: .85rem;
                text-decoration: none;
                padding: .3rem .45rem;
            }

            .cal-page #calendar .fc-day-sun .fc-daygrid-day-number {
                color: var(--k-urgent);
            }

            .cal-page #calendar .fc-day-other .fc-daygrid-day-number {
                color: #A6B3C0;
            }

            /* tanggal hari ini: lingkaran biru */
            .cal-page #calendar .fc-day-today .fc-daygrid-day-number {
                background: var(--k-blue);
                color: #fff;
                border-radius: 999px;
                min-width: 1.7rem;
                height: 1.7rem;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin: .25rem;
                padding: 0;
                font-weight: 600;
            }

            .cal-page #calendar .fc-button-primary {
                background-color: #fff;
                border-color: #D5DEE8;
                color: var(--k-navy);
                font-size: .85rem;
                font-weight: 500;
                border-radius: .6rem;
            }

            .cal-page #calendar .fc-button-primary:hover {
                background-color: #F1F5F9;
                color: var(--k-navy);
            }

            .cal-page #calendar .fc-button-primary:disabled {
                opacity: .5;
                color: var(--k-navy);
                background-color: #fff;
            }

            .cal-page #calendar .fc-button-primary:not(:disabled).fc-button-active,
            .cal-page #calendar .fc-button-primary:not(:disabled):active {
                background-color: var(--k-navy);
                border-color: var(--k-navy);
                color: #fff;
            }

            .cal-page #calendar .fc-button:focus {
                box-shadow: 0 0 0 3px rgba(46, 117, 182, .35);
            }

            .cal-page #calendar .fc-more-link {
                color: var(--k-blue);
                font-weight: 600;
                font-size: .75rem;
            }

            /* event: pil lembut dengan garis aksen di kiri */
            .cal-page .fc-event {
                cursor: pointer;
                font-size: .78rem;
                font-weight: 500;
                border-radius: 6px;
                border-left-width: 3px;
                margin-bottom: 2px;
            }

            .cal-page .fc-event.ev-flight {
                --fc-event-bg-color: var(--c-flight-bg);
                --fc-event-border-color: var(--c-flight-bd);
                --fc-event-text-color: var(--c-flight-tx);
                border-left-color: var(--c-flight);
            }

            .cal-page .fc-event.ev-hotel {
                --fc-event-bg-color: var(--c-hotel-bg);
                --fc-event-border-color: var(--c-hotel-bd);
                --fc-event-text-color: var(--c-hotel-tx);
                border-left-color: var(--c-hotel);
            }

            .cal-page .fc-event.ev-past {
                opacity: .55;
            }

            .cal-page .fc-event:hover {
                filter: brightness(.97);
            }

            .cal-page .fc-event:focus-visible {
                outline: 3px solid var(--k-navy);
                outline-offset: 1px;
            }

            .cal-page .ev {
                display: flex;
                align-items: center;
                gap: .3rem;
                padding: 1px 4px;
                overflow: hidden;
                white-space: nowrap;
            }

            .cal-page .ev i {
                font-size: .72rem;
                flex-shrink: 0;
            }

            .cal-page .ev-text {
                overflow: hidden;
                text-overflow: ellipsis;
                font-variant-numeric: tabular-nums;
            }

            .cal-page .ev-tz {
                font-size: .65rem;
                font-weight: 500;
                opacity: .75;
                margin-right: .25rem;
            }

            /* tampilan daftar (listWeek / listMonth) */
            .cal-page .fc-list {
                border-radius: .75rem;
                overflow: hidden;
            }

            .cal-page .fc-list-day-cushion {
                background: #F7FAFC;
                color: var(--k-navy);
            }

            .cal-page .fc-list-event {
                cursor: pointer;
            }

            .cal-page .fc-list-event.ev-flight {
                --fc-event-border-color: var(--c-flight);
            }

            .cal-page .fc-list-event.ev-hotel {
                --fc-event-border-color: var(--c-hotel);
            }

            .cal-page .cal-empty {
                text-align: center;
                padding: 1rem;
                color: var(--k-muted);
            }

            /* ===== Modal detail ===== */
            .cal-page .detail-head {
                padding: 1.1rem 1.25rem 1.2rem;
                color: #fff;
            }

            .cal-page .detail-head--flight {
                background: linear-gradient(135deg, #D4411F, #E2672F);
            }

            .cal-page .detail-head--hotel {
                background: linear-gradient(135deg, #2E75B6, #3B8AD0);
            }

            .cal-page .detail-kind {
                font-size: .8rem;
                font-weight: 600;
                background: rgba(255, 255, 255, .22);
                padding: .2rem .7rem;
                border-radius: 999px;
            }

            .cal-page .detail-headline {
                font-size: 1.6rem;
                font-weight: 700;
                line-height: 1.2;
            }

            .cal-page .detail-subline {
                opacity: .92;
                margin-top: .15rem;
            }

            .cal-page .detail-row {
                display: flex;
                gap: 1rem;
                padding: .6rem 0;
                border-bottom: 1px solid #EEF2F6;
            }

            .cal-page .detail-row:last-child {
                border-bottom: 0;
            }

            .cal-page .detail-row dt {
                width: 36%;
                font-size: .8rem;
                font-weight: 500;
                color: var(--k-muted);
                margin: 0;
                padding-top: .1rem;
            }

            .cal-page .detail-row dd {
                flex: 1;
                margin: 0;
                color: #1F2D3D;
                font-weight: 600;
            }

            @media (max-width: 767.98px) {
                .cal-page .legend-note {
                    margin-left: 0;
                    width: 100%;
                }
            }

            @media (prefers-reduced-motion: reduce) {

                .cal-page .next-flight,
                .cal-page #calendar {
                    transition: none;
                }

                .cal-page .next-flight:hover {
                    transform: none;
                }
            }
        </style>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/locales/id.global.min.js"></script>
    <script>
        const calendarEl = document.getElementById('calendar');
        const loadingEl = document.getElementById('calLoading');
        const emptyEl = document.getElementById('calEmpty');
        const detailModal = new bootstrap.Modal(document.getElementById('eventModal'));
        const isMobile = window.matchMedia('(max-width: 767.98px)').matches;

        const selectedType = () => document.querySelector('input[name="type"]:checked').value;
        let pendingEventId = null;

        function openDetail(event) {
            const p = event.extendedProps;
            const isHotel = p.kind === 'Hotel';

            document.getElementById('detailHead').className =
                'detail-head ' + (isHotel ? 'detail-head--hotel' : 'detail-head--flight');
            document.getElementById('detailIcon').className =
                'bi me-1 ' + (isHotel ? 'bi-building' : 'bi-airplane-fill');
            document.getElementById('detailKind').textContent = p.kind;
            document.getElementById('detailHeadline').textContent = p.headline || event.title;
            document.getElementById('detailSubline').textContent = p.subline || '';

            const list = document.getElementById('detailList');
            list.innerHTML = '';
            (p.details || []).forEach(([label, value]) => {
                const row = document.createElement('div');
                row.className = 'detail-row';
                const dt = document.createElement('dt');
                const dd = document.createElement('dd');
                dt.textContent = label;
                dd.textContent = value;
                row.appendChild(dt);
                row.appendChild(dd);
                list.appendChild(row);
            });

            const link = document.getElementById('detailLink');
            if (p.url) {
                link.href = p.url;
                link.textContent = p.urlText;
                link.classList.remove('d-none');
            } else {
                link.classList.add('d-none');
            }

            detailModal.show();
        }

        function renderEvent(arg) {
            const p = arg.event.extendedProps;

            const wrap = document.createElement('div');
            wrap.className = 'ev';

            const icon = document.createElement('i');
            icon.className = 'bi ' + (p.kind === 'Hotel' ? 'bi-building' : 'bi-airplane-fill');
            wrap.appendChild(icon);

            const text = document.createElement('span');
            text.className = 'ev-text';

            // jam + singkatan zona waktu bandara (kalau dikirim controller), lalu judul
            if (!arg.event.allDay && arg.timeText) {
                text.appendChild(document.createTextNode(arg.timeText + ' '));
                if (p.tz_abbr) {
                    const tz = document.createElement('span');
                    tz.className = 'ev-tz';
                    tz.textContent = p.tz_abbr;
                    text.appendChild(tz);
                }
            }
            text.appendChild(document.createTextNode(arg.event.title));

            wrap.appendChild(text);
            return {
                domNodes: [wrap]
            };
        }

        // Jam acuan "sekarang" = WIB (zona waktu kantor), bukan zona browser.
        const nowWib = () => new Date().toLocaleString('sv-SE', {
            timeZone: 'Asia/Jakarta'
        }).replace(' ', 'T');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'id',
            /*
             * Jam event dikirim controller sebagai waktu lokal bandara TANPA offset
             * (mis. 2026-10-22T19:20:00). Dengan timeZone 'UTC', FullCalendar menampilkan
             * angka itu apa adanya, tidak bergeser mengikuti zona waktu browser.
             */
            timeZone: 'UTC',
            now: nowWib,
            initialView: isMobile ? 'listWeek' : 'dayGridMonth',
            height: 'auto',
            firstDay: 1,
            dayMaxEvents: 3,
            eventDisplay: 'block',
            displayEventTime: true,
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            headerToolbar: isMobile ? {
                left: 'prev,next',
                center: 'title',
                right: 'today'
            } : {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek,listMonth'
            },
            buttonText: {
                today: 'Hari ini',
                month: 'Bulan'
            },
            views: {
                dayGridMonth: {
                    eventContent: renderEvent
                },
                listWeek: {
                    buttonText: 'Minggu'
                },
                listMonth: {
                    buttonText: 'Agenda'
                }
            },
            moreLinkText: n => '+' + n + ' lagi',
            noEventsText: 'Tidak ada jadwal pada periode ini',
            events: {
                url: calendarEl.dataset.eventsUrl,
                extraParams: () => ({
                    type: selectedType()
                })
            },
            loading: isLoading => {
                loadingEl.classList.toggle('d-none', !isLoading);
                calendarEl.classList.toggle('is-loading', isLoading);
            },
            eventsSet: function(events) {
                emptyEl.classList.toggle('d-none', events.length > 0 || calendar.view.type !== 'dayGridMonth');

                if (pendingEventId) {
                    const ev = calendar.getEventById(pendingEventId);
                    if (ev) {
                        pendingEventId = null;
                        openDetail(ev);
                    }
                }
            },
            eventClassNames: arg => arg.isPast ? ['ev-past'] : [],
            eventDidMount: function(info) {
                const p = info.event.extendedProps;
                info.el.setAttribute('tabindex', '0');
                info.el.setAttribute('role', 'button');
                // tooltip: jam lengkap dengan zona waktu kalau ada
                info.el.title = (p.time_label ? p.time_label + ' · ' : '') + info.event.title;
                info.el.addEventListener('keydown', e => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        openDetail(info.event);
                    }
                });
            },
            eventClick: function(info) {
                info.jsEvent.preventDefault();
                openDetail(info.event);
            }
        });

        calendar.render();

        document.querySelectorAll('input[name="type"]').forEach(r =>
            r.addEventListener('change', () => calendar.refetchEvents())
        );

        // Klik kartu "penerbangan terdekat": pindah ke tanggalnya lalu buka detail
        document.querySelectorAll('.next-flight').forEach(btn => {
            btn.addEventListener('click', () => {
                const id = btn.dataset.eventId;
                const existing = calendar.getEventById(id);

                if (existing) {
                    openDetail(existing);
                    return;
                }

                pendingEventId = id;
                document.getElementById('type-all').checked = true;
                calendar.gotoDate(btn.dataset.date);
                calendar.refetchEvents();
            });
        });
    </script>
@endpush
