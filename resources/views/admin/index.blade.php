@extends('admin.admin_dashboard')

@section('admin')
    <style>
        :root {
            --ink: #f4f7ff;
            --muted: #a8b9d6;
            --navy: #0f1b2d;
            --navy2: #182b46;
            --shadow: 0 14px 36px rgba(0, 0, 0, .28);
        }

        .hero {
            position: relative;
            overflow: hidden;
            border-radius: 22px;
            padding: 28px 22px;
            background: radial-gradient(1200px 500px at -20% -40%, rgba(255, 255, 255, .12), transparent 65%),
                radial-gradient(900px 400px at 120% 140%, rgba(46, 201, 184, .10), transparent 60%),
                linear-gradient(135deg, var(--navy), var(--navy2));
            color: var(--ink);
            box-shadow: var(--shadow);
        }

        .hero .time {
            font-size: clamp(32px, 6vw, 64px);
            font-weight: 900;
            letter-spacing: .02em;
            line-height: 1;
            text-shadow: 0 10px 30px rgba(0, 0, 0, .35)
        }

        .hero .date {
            color: var(--muted);
            font-weight: 600
        }

        .chips {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 12px
        }

        .chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .06);
            border: 1px dashed rgba(255, 255, 255, .12);
            color: #e6eeff;
            text-decoration: none;
            font-weight: 600;
            transition: transform .2s ease, border-color .2s ease
        }

        .chip:hover {
            transform: translateY(-2px);
            border-color: rgba(255, 255, 255, .28)
        }

        .chip .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: currentColor
        }

        .dashboard-grid {
            display: grid;
            gap: 16px;
            margin-top: 18px
        }

        @media(min-width:992px) {
            .dashboard-grid {
                grid-template-columns: repeat(12, 1fr)
            }
        }

        /* helper: 4 kolom di desktop, full di mobile */
        .col-3-lg {
            grid-column: span 12;
        }

        @media(min-width:992px) {
            .col-3-lg {
                grid-column: span 3;
            }
        }

        .kpi {
            border-radius: 18px;
            padding: 20px 20px 18px;
            background: linear-gradient(135deg, #1b2a41, #253a5e);
            color: #f4f7ff;
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            gap: 6px;
            transform: translateY(10px);
            opacity: 0;
            animation: fadeUp .7s ease forwards;
            text-decoration: none
        }

        .kpi:hover {
            transform: translateY(3px) scale(1.01);
            transition: .25s ease
        }

        @keyframes fadeUp {
            to {
                transform: translateY(0);
                opacity: 1
            }
        }

        .kpi .label {
            font-size: .82rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: #a8b9d6;
            font-weight: 800
        }

        .kpi .value {
            font-size: 42px;
            font-weight: 900;
            line-height: 1;
            margin: 6px 0 0
        }

        .kpi .sub {
            color: #a8b9d6;
            font-size: .9rem
        }

        .kpi i {
            opacity: .85
        }

        .v1 {
            background: linear-gradient(135deg, #203458, #2d4f80)
        }

        .v2 {
            background: linear-gradient(135deg, #2a235a, #4f4596)
        }

        .v3 {
            background: linear-gradient(135deg, #154d4b, #1f7c77)
        }

        .v4 {
            background: linear-gradient(135deg, #4d2340, #8e466f)
        }

        .skeleton {
            height: 42px;
            border-radius: 8px;
            background: rgba(255, 255, 255, .12);
            position: relative;
            overflow: hidden
        }

        .skeleton::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, .22), transparent);
            animation: shimmer 1.4s infinite
        }

        @keyframes shimmer {
            0% {
                transform: translateX(-100%)
            }

            100% {
                transform: translateX(100%)
            }
        }

        .pulse {
            animation: pulse .45s ease
        }

        @keyframes pulse {
            0% {
                transform: scale(1)
            }

            50% {
                transform: scale(1.05)
            }

            100% {
                transform: scale(1)
            }
        }
    </style>

    <div class="page-content">
        <div class="container">
            {{-- HERO tetap --}}
            <div class="hero">
                <div class="d-flex flex-wrap justify-content-between align-items-end">
                    <div>
                        <div id="timenow" class="time">00:00:00</div>
                        <div id="datenow" class="date">–</div>
                    </div>
                    <div class="chips">
                        <a href="{{ route('add.purchaserequest') }}" class="chip"><span class="dot"
                                style="color:#5b8cff"></span> Tambah PR</a>
                        <a href="" class="chip"><span class="dot" style="color:#2ec9b8"></span> Tambah PO</a>
                        <a href="{{ route('all.purchaserequest') }}" class="chip"><span class="dot"
                                style="color:#7a6cf6"></span> Daftar PR</a>
                        <a href="{{ route('all.purchaseorder') }}" class="chip"><span class="dot"
                                style="color:#ff6583"></span> Daftar PO</a>
                    </div>
                </div>
            </div>

            {{-- GRID: Row 1 = 4 kartu sejajar --}}
            <div class="dashboard-grid">
                <a href="{{ route('all.purchaserequest') }}" class="kpi v1 col-3-lg" style="animation-delay:.05s">
                    <div class="d-flex justify-content-between">
                        <span class="label">Request Document (PR)</span>
                        <i data-feather="file-text"></i>
                    </div>
                    <div class="value" id="txt-count-request-pr">
                        <div class="skeleton"></div>
                    </div>
                    <div class="sub">Total PR terdaftar</div>
                </a>

                <a href="{{ route('all.purchaseorder') }}" class="kpi v2 col-3-lg" style="animation-delay:.10s">
                    <div class="d-flex justify-content-between">
                        <span class="label">Purchase Document (PO)</span>
                        <i data-feather="shopping-cart"></i>
                    </div>
                    <div class="value" id="txt-count-purchase-po">
                        <div class="skeleton"></div>
                    </div>
                    <div class="sub">Total PO dibuat</div>
                </a>

                <a href="{{ route('all.purchaserequestwaiting') }}" class="kpi v3 col-3-lg" style="animation-delay:.15s">
                    <div class="d-flex justify-content-between">
                        <span class="label">Pending Document (PR)</span>
                        <i data-feather="clock"></i>
                    </div>
                    <div class="value" id="txt-count-request-pending">
                        <div class="skeleton"></div>
                    </div>
                    <div class="sub">Menunggu approval</div>
                </a>

                <a href="{{ route('all.purchaseordersend') }}" class="kpi v4 col-3-lg" style="animation-delay:.20s">
                    <div class="d-flex justify-content-between">
                        <span class="label">Send PO</span>
                        <i data-feather="send"></i>
                    </div>
                    <div class="value" id="txt-count-send-po">
                        <div class="skeleton"></div>
                    </div>
                    <div class="sub">PO terkirim</div>
                </a>

                {{-- Row terakhir (tetap, tidak dimodif) --}}
                <a href="{{ route('all.purchaserequest') }}" class="kpi v2"
                    style="grid-column:span 6; animation-delay:.30s">
                    <div class="d-flex justify-content-between">
                        <span class="label">Request by Item</span>
                        <i data-feather="package"></i>
                    </div>
                    <div class="value" id="txt-count-request">
                        <div class="skeleton"></div>
                    </div>
                    <div class="sub">Jumlah baris permintaan</div>
                </a>

                <a href="{{ route('all.purchaseorder') }}" class="kpi v1" style="grid-column:span 6; animation-delay:.36s">
                    <div class="d-flex justify-content-between">
                        <span class="label">Purchase by Item</span>
                        <i data-feather="shopping-bag"></i>
                    </div>
                    <div class="value" id="txt-count-purchase">
                        <div class="skeleton"></div>
                    </div>
                    <div class="sub">Jumlah baris pembelian</div>
                </a>
            </div>
        </div>
    </div>

    {{-- Scripts tetap --}}
    <script>
        function pad(n) {
            return n < 10 ? '0' + n : n
        }
        const $t = document.getElementById('timenow'),
            $d = document.getElementById('datenow');

        function tickClock() {
            const now = new Date();
            $t.textContent = `${pad(now.getHours())}:${pad(now.getMinutes())}:${pad(now.getSeconds())}`;
            $d.textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long',
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
        }
        tickClock();
        setInterval(tickClock, 1000);

        function countUp(el, to) {
            const dur = 600,
                start = performance.now(),
                from = Number(el.dataset.from || 0);

            function step(t) {
                const p = Math.min(1, (t - start) / dur);
                const n = Math.floor(from + (to - from) * p);
                el.textContent = n.toLocaleString('id-ID');
                if (p < 1) requestAnimationFrame(step);
                else {
                    el.dataset.from = to;
                    el.classList.add('pulse');
                    setTimeout(() => el.classList.remove('pulse'), 280)
                }
            }
            requestAnimationFrame(step);
        }

        $(function() {
            const endpoints = [{
                    id: '#txt-count-request',
                    route: "{{ route('get.purchaserequestcount') }}",
                    key: 'request'
                },
                {
                    id: '#txt-count-purchase',
                    route: "{{ route('get.purchaseordercount') }}",
                    key: 'request'
                },
                {
                    id: '#txt-count-request-pr',
                    route: "{{ route('get.purchaserequestcountPR') }}",
                    key: 'request'
                },
                {
                    id: '#txt-count-purchase-po',
                    route: "{{ route('get.purchaseordercountPO') }}",
                    key: 'request'
                },
                {
                    id: '#txt-count-request-pending',
                    route: "{{ route('get.purchaserequestcountPending') }}",
                    key: 'request'
                },
                {
                    id: '#txt-count-send-po',
                    route: "{{ route('get.purchaseordersendcount') }}",
                    key: 'request'
                },
            ];

            function hydrate({
                id,
                route,
                key
            }) {
                $.get(route, function(data) {
                    const val = Number(data?.[key] ?? 0);
                    const $el = $(id);
                    if ($el.find('.skeleton').length) $el.empty();
                    countUp($el.get(0), val);
                }).fail(() => {
                    const $el = $(id);
                    if ($el.find('.skeleton').length) $el.empty();
                    $el.text('—');
                });
            }
            endpoints.forEach((e, i) => setTimeout(() => hydrate(e), 150 + i * 120));
            setInterval(() => endpoints.forEach(hydrate), 30000);
            if (window.feather) feather.replace({
                width: 18,
                height: 18,
                color: '#e6eeff'
            });
        });
    </script>
@endsection
