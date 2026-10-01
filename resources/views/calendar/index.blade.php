@extends('layouts.app')

@section('title', 'Kalender Jadwal')

@section('content')
    <div class="cal-page">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h4 class="section-title mb-0"><i class="bi bi-calendar3 me-2"></i>Kalender Jadwal</h4>

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
        @php $todayCount = $upcoming->where('level', 'today')->count(); @endphp

        @if ($todayCount > 0)
            <div class="alert alert-urgent d-flex align-items-center gap-2 mb-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                <div>
                    <strong>{{ $todayCount }} penerbangan berangkat hari ini.</strong>
                    Pastikan e-ticket sudah terkirim ke penumpang.
                </div>
            </div>
        @endif

        <div class="mb-4">
            <h6 class="next-heading mb-2">Berangkat dalam 7 hari ke depan</h6>

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
                                    <span class="nf-time">{{ $f['time'] ?? 'Jam belum diisi' }}</span>
                                </span>
                                <span class="nf-route">{{ $f['route'] }}</span>
                                <span class="nf-code">{{ $f['airline'] }} &nbsp;{{ $f['code'] }}</span>
                                @if ($f['detail'])
                                    <span class="nf-detail">{{ $f['detail'] }}</span>
                                @endif
                                <span class="nf-pax">{{ $f['passenger'] }}</span>
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
        <div class="card card-section">
            <div class="card-body">
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
                            <span class="detail-kind" id="detailKind"></span>
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
                --k-hotel: #D4411F;
                --k-urgent: #B42318;
                --k-urgent-bg: #FEF3F2;
            }

            /* Filter */
            .cal-page .type-filter .btn-check:checked+.btn {
                background: var(--k-navy);
                border-color: var(--k-navy);
                color: #fff;
            }

            .cal-page .dot-flight {
                color: var(--k-blue);
            }

            .cal-page .dot-hotel {
                color: var(--k-hotel);
            }

            .cal-page .btn-check:checked+.btn .dot-flight,
            .cal-page .btn-check:checked+.btn .dot-hotel {
                color: #fff;
            }

            /* Alert hari ini */
            .cal-page .alert-urgent {
                background: var(--k-urgent-bg);
                border: 1px solid #FDA29B;
                border-left: 5px solid var(--k-urgent);
                color: #7A1B12;
            }

            /* Kartu penerbangan terdekat */
            .cal-page .next-heading {
                color: var(--k-navy);
                font-weight: 600;
            }

            .cal-page .next-empty {
                padding: .75rem 1rem;
                background: #F4F7FA;
                border-radius: .5rem;
                color: #5B6B7B;
            }

            .cal-page .next-flight {
                display: flex;
                flex-direction: column;
                gap: .25rem;
                width: 100%;
                height: 100%;
                text-align: left;
                padding: .85rem 1rem;
                background: #fff;
                border: 1px solid #DDE4EB;
                border-left: 5px solid #9FB3C8;
                border-radius: .6rem;
                transition: box-shadow .15s, border-color .15s;
            }

            .cal-page .next-flight:hover {
                box-shadow: 0 4px 14px rgba(22, 50, 79, .12);
            }

            .cal-page .next-flight:focus-visible {
                outline: 3px solid rgba(46, 117, 182, .45);
                outline-offset: 2px;
            }

            .cal-page .next-flight--today {
                background: var(--k-urgent-bg);
                border-color: #FDA29B;
                border-left-color: var(--k-urgent);
            }

            .cal-page .next-flight--tomorrow {
                border-left-color: var(--k-blue);
            }

            .cal-page .nf-top {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .cal-page .nf-chip {
                font-size: .75rem;
                font-weight: 600;
                padding: .15rem .55rem;
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
                font-weight: 600;
                color: var(--k-navy);
                font-variant-numeric: tabular-nums;
            }

            .cal-page .nf-route {
                font-size: 1.35rem;
                font-weight: 700;
                color: var(--k-navy);
                line-height: 1.2;
            }

            .cal-page .nf-code {
                font-size: .85rem;
                color: #5B6B7B;
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
                margin-top: .35rem;
                font-size: .8rem;
                color: #5B6B7B;
            }

            /* Kalender */
            .cal-page #calendar .fc-toolbar-title {
                font-size: 1.15rem;
                color: var(--k-navy);
                font-weight: 600;
            }

            .cal-page #calendar .fc-col-header-cell-cushion {
                color: var(--k-navy);
                font-weight: 600;
                text-decoration: none;
            }

            .cal-page #calendar .fc-daygrid-day-number {
                color: #3B4B5C;
                text-decoration: none;
            }

            .cal-page #calendar .fc-day-today {
                background: #EEF5FB !important;
            }

            .cal-page #calendar .fc-button-primary {
                background-color: #fff;
                border-color: #C9D3DD;
                color: var(--k-navy);
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

            .cal-page #calendar .fc-button-primary:not(:disabled).fc-button-active {
                background-color: var(--k-navy);
                border-color: var(--k-navy);
                color: #fff;
            }

            .cal-page #calendar .fc-button:focus {
                box-shadow: 0 0 0 3px rgba(46, 117, 182, .35);
            }

            .cal-page .fc-event {
                cursor: pointer;
                font-size: .78rem;
                font-weight: 500;
                border-radius: 4px;
            }

            .cal-page .fc-event.ev-flight {
                --fc-event-bg-color: var(--k-blue);
                --fc-event-border-color: var(--k-blue);
                --fc-event-text-color: #fff;
            }

            .cal-page .fc-event.ev-hotel {
                --fc-event-bg-color: var(--k-hotel);
                --fc-event-border-color: var(--k-hotel);
                --fc-event-text-color: #fff;
            }

            .cal-page .fc-event.ev-past {
                opacity: .55;
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

            .cal-page .ev-text {
                overflow: hidden;
                text-overflow: ellipsis;
                font-variant-numeric: tabular-nums;
            }

            .cal-page .cal-empty {
                text-align: center;
                padding: 1rem;
                color: #5B6B7B;
            }

            /* Modal detail */
            .cal-page .detail-head {
                padding: 1rem 1.25rem 1.1rem;
                color: #fff;
            }

            .cal-page .detail-head--flight {
                background: var(--k-blue);
            }

            .cal-page .detail-head--hotel {
                background: var(--k-hotel);
            }

            .cal-page .detail-kind {
                font-size: .8rem;
                font-weight: 600;
                background: rgba(255, 255, 255, .22);
                padding: .15rem .6rem;
                border-radius: 999px;
            }

            .cal-page .detail-headline {
                font-size: 1.6rem;
                font-weight: 700;
                line-height: 1.2;
            }

            .cal-page .detail-subline {
                opacity: .9;
            }

            .cal-page .detail-row {
                display: flex;
                gap: 1rem;
                padding: .55rem 0;
                border-bottom: 1px solid #EEF2F6;
            }

            .cal-page .detail-row:last-child {
                border-bottom: 0;
            }

            .cal-page .detail-row dt {
                width: 38%;
                font-weight: 500;
                color: #5B6B7B;
                margin: 0;
            }

            .cal-page .detail-row dd {
                flex: 1;
                margin: 0;
                color: #1F2D3D;
                font-weight: 500;
            }

            @media (prefers-reduced-motion: reduce) {
                .cal-page .next-flight {
                    transition: none;
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

            document.getElementById('detailHead').className =
                'detail-head ' + (p.kind === 'Hotel' ? 'detail-head--hotel' : 'detail-head--flight');
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

            const text = document.createElement('span');
            text.className = 'ev-text';
            text.textContent = (!arg.event.allDay && arg.timeText ? arg.timeText + ' ' : '') + arg.event.title;

            wrap.appendChild(icon);
            wrap.appendChild(text);
            return {
                domNodes: [wrap]
            };
        }

        const calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'id',
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
            loading: isLoading => loadingEl.classList.toggle('d-none', !isLoading),
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
                info.el.setAttribute('tabindex', '0');
                info.el.setAttribute('role', 'button');
                info.el.title = info.event.title;
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
