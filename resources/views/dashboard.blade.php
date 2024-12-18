@extends('layouts.app')

@push('styles')
<style>
    .stat-card {
        transition: transform 0.2s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.7;
    }
    #map {
        height: 300px;
        width: 100%;
        border-radius: 0.25rem;
    }
    .card {
        border: none;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .card-header {
        background-color: #f0f9ff;
        border-bottom: 1px solid #e5e7eb;
    }
    .bg-primary {
        background: linear-gradient(135deg, #2563eb, #3b82f6) !important;
    }
    .bg-warning {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8) !important;
    }
    .bg-info {
        background: linear-gradient(135deg, #0284c7, #0ea5e9) !important;
    }
    .bg-success {
        background: linear-gradient(135deg, #1d4ed8, #2563eb) !important;
    }
    .marker-pin {
        box-shadow: 0 0 4px rgba(0,0,0,0.5);
    }
    .badge.bg-success {
        background: linear-gradient(135deg, #1d4ed8, #2563eb) !important;
    }
    .badge.bg-info {
        background: linear-gradient(135deg, #0284c7, #0ea5e9) !important;
    }
    a {
        color: #2563eb;
        text-decoration: none;
    }
    a:hover {
        color: #1d4ed8;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Dashboard</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="card bg-primary text-white stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title">Total Keluarga</h6>
                                        <h2 class="mb-0">{{ $totalKeluarga ?? 0 }}</h2>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="bi bi-people-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-warning text-white stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title">Belum Dibantu</h6>
                                        <h2 class="mb-0">{{ $belumDibantu ?? 0 }}</h2>
                                        <small>{{ $totalKeluarga > 0 ? round(($belumDibantu / $totalKeluarga) * 100) : 0 }}%</small>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="bi bi-hourglass"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-info text-white stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title">Sedang Diproses</h6>
                                        <h2 class="mb-0">{{ $sedangDiproses ?? 0 }}</h2>
                                        <small>{{ $totalKeluarga > 0 ? round(($sedangDiproses / $totalKeluarga) * 100) : 0 }}%</small>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="bi bi-building-gear"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="card bg-success text-white stat-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title">Sudah Dibantu</h6>
                                        <h2 class="mb-0">{{ $sudahDibantu ?? 0 }}</h2>
                                        <small>{{ $totalKeluarga > 0 ? round(($sudahDibantu / $totalKeluarga) * 100) : 0 }}%</small>
                                    </div>
                                    <div class="stat-icon">
                                        <i class="bi bi-house-check-fill"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Statistik Status Bantuan</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="statusChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Peta Sebaran</h6>
                            </div>
                            <div class="card-body">
                                <div id="map"></div>
                            </div>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->role == 'Admin')
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">Aktivitas Terbaru</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Tanggal</th>
                                                <th>Nama KK</th>
                                                <th>RT/RW</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($recentActivities ?? [] as $activity)
                                            <tr>
                                                <td>{{ $activity->tanggal_mulai->format('d/m/Y') }}</td>
                                                <td>
                                                    <a href="{{ route('detail-bantuan.index', $activity->keluarga->id) }}">
                                                        {{ $activity->keluarga->nama_kk }}
                                                    </a>
                                                </td>
                                                <td>{{ $activity->keluarga->rt }}/{{ $activity->keluarga->rw }}</td>
                                                <td>
                                                    @if($activity->tanggal_selesai)
                                                        <span class="badge bg-success">Selesai</span>
                                                    @else
                                                        <span class="badge bg-info">Dalam Proses</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Belum ada aktivitas</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data GeoJSON batas desa
    var ngabulGeoJSON = {
        "type": "Feature",
        "properties": {
            "id": 1,
            "Batas": null
        },
        "geometry": {
            "type": "MultiPolygon",
            "coordinates": [[[[110.690318, -6.6564685], [110.6907183, -6.6567648], [110.6911725, -6.6571719], [110.6913813, -6.6573611], [110.6915958, -6.6575778], [110.691768, -6.6578312], [110.6918275, -6.6579858], [110.6918466, -6.6580354], [110.6918637, -6.6580795], [110.6918811, -6.6581246], [110.6918991, -6.6581713], [110.6919148, -6.6582121], [110.691935, -6.6582646], [110.6919529, -6.6583111], [110.6919239, -6.6584312], [110.6919608, -6.6584816], [110.6920382, -6.6586175], [110.692051, -6.6587121], [110.6920569, -6.6587553], [110.6919314, -6.658989], [110.6918839, -6.6590742], [110.6918831, -6.6591114], [110.6918826, -6.6591441], [110.6918819, -6.6591916], [110.6918852, -6.6592213], [110.6918945, -6.6593073], [110.6918995, -6.6593542], [110.6919038, -6.659392], [110.6917395, -6.6595294], [110.6916639, -6.6596493], [110.6916848, -6.6598234], [110.6917265, -6.6599741], [110.6917855, -6.660191], [110.691784, -6.6602419], [110.6917845, -6.6604025], [110.6917845, -6.6605597], [110.6917845, -6.6607298], [110.6918124, -6.6608937], [110.6918701, -6.6609568], [110.6920188, -6.6610037], [110.6920443, -6.6610189], [110.6922136, -6.661147], [110.692435, -6.661363], [110.6927563, -6.6618409], [110.6931506, -6.6622625], [110.6935954, -6.6622285], [110.6936895, -6.6621996], [110.6938468, -6.6620331], [110.6939272, -6.6614384], [110.6940196, -6.6613331], [110.6941496, -6.6612634], [110.6942553, -6.6612579], [110.6947205, -6.6612413], [110.6950704, -6.6612316], [110.6954707, -6.6614877], [110.6956759, -6.6616504], [110.6959826, -6.6617944], [110.6963414, -6.6617931], [110.6963593, -6.6617918], [110.6967404, -6.6618581], [110.6968306, -6.6618734], [110.6969709, -6.6618742], [110.6972634, -6.6617358], [110.6973977, -6.6614074], [110.6974678, -6.6610633], [110.6974901, -6.6608611], [110.6975944, -6.660659], [110.697833, -6.6604576], [110.6982812, -6.6601263], [110.6985447, -6.6599445], [110.6987457, -6.6598655], [110.6989373, -6.6599623], [110.6990921, -6.6600702], [110.6993376, -6.6601518], [110.6993421, -6.6601537], [110.6994587, -6.6601463], [110.699639, -6.6599994], [110.6999435, -6.6597509], [110.7001288, -6.6599139], [110.7002967, -6.6600811], [110.7004146, -6.6601304], [110.7005858, -6.6602264], [110.7016549, -6.6608276], [110.70183, -6.6608352], [110.702034, -6.660992], [110.7019474, -6.6612787], [110.7019666, -6.6612725], [110.7021225, -6.6613231], [110.7025031, -6.6614469], [110.7024285, -6.6614445], [110.7044757, -6.6622612], [110.704913, -6.6625379], [110.7055981, -6.662859], [110.7060378, -6.6630712], [110.7073513, -6.6614961], [110.707613, -6.6612209], [110.7082423, -6.6605886], [110.7086874, -6.6607224], [110.7088192, -6.6607736], [110.7090607, -6.6608763], [110.7091882, -6.6609523], [110.709727, -6.6618125], [110.7099195, -6.662168], [110.7106623, -6.6630817], [110.7108182, -6.6631925], [110.7111319, -6.6634965], [110.7114071, -6.6636245], [110.7116342, -6.6636513], [110.7119344, -6.6634869], [110.7120691, -6.6634678], [110.7123539, -6.6636264], [110.7125041, -6.6637354], [110.712658, -6.6637927], [110.7128235, -6.6637545], [110.7132084, -6.6632346], [110.7137203, -6.6634353], [110.7140302, -6.6632059], [110.7142977, -6.6626229], [110.7143554, -6.6625121], [110.7145709, -6.66234], [110.7146325, -6.6623056], [110.7150174, -6.6621049], [110.7151714, -6.6619329], [110.7153118, -6.6615162], [110.7153523, -6.6613136], [110.7157408, -6.6607984], [110.7161275, -6.6604658], [110.7153729, -6.657388], [110.7152503, -6.656861], [110.7152267, -6.6567181], [110.7151819, -6.6563516], [110.7148918, -6.6547787], [110.714491, -6.6527503], [110.7144367, -6.6524505], [110.7143636, -6.651633], [110.7143188, -6.6511809], [110.7144391, -6.650579], [110.7145287, -6.6503424], [110.7146749, -6.6499231], [110.7147645, -6.64945], [110.7148011, -6.6492521], [110.7147869, -6.6491736], [110.7147598, -6.6490752], [110.7146124, -6.6487297], [110.7145293, -6.6484615], [110.714488, -6.6483216], [110.7144768, -6.6482156], [110.7144632, -6.6481061], [110.7144503, -6.6479556], [110.7144538, -6.6478543], [110.7144644, -6.647572], [110.7144715, -6.6473501], [110.7144762, -6.6471943], [110.7144957, -6.6471557], [110.715064, -6.6454873], [110.7153859, -6.6445047], [110.7154469, -6.6443171], [110.7154873, -6.6441876], [110.7155289, -6.6440559], [110.7155695, -6.6439325], [110.7155837, -6.6438666], [110.7156627, -6.6434836], [110.7157087, -6.6431264], [110.7157806, -6.6426158], [110.7167368, -6.6387772], [110.7169184, -6.6381167], [110.7171259, -6.637079], [110.7172851, -6.6364542], [110.7169308, -6.636566], [110.7166985, -6.6365403], [110.7165806, -6.6364969], [110.7163141, -6.636388], [110.7160712, -6.6362147], [110.7158743, -6.6359711], [110.7157116, -6.6356396], [110.7156173, -6.6355202], [110.7153803, -6.6353656], [110.7151079, -6.6351606], [110.7148921, -6.6350154], [110.7147754, -6.6349732], [110.7145514, -6.6348994], [110.7142814, -6.6346383], [110.7139642, -6.6342998], [110.7137567, -6.6340925], [110.7135503, -6.6339894], [110.7131565, -6.6337927], [110.7127886, -6.633361], [110.7125575, -6.6336755], [110.7122168, -6.6338266], [110.7121437, -6.6339836], [110.7120729, -6.6340819], [110.711823, -6.6341991], [110.711672, -6.6341803], [110.7112989, -6.6341071], [110.7108555, -6.6341399], [110.710806, -6.6341171], [110.7106987, -6.6340655], [110.7106232, -6.6340292], [110.7105802, -6.6340093], [110.7105254, -6.6339695], [110.7104611, -6.6339232], [110.7103827, -6.6338694], [110.7103255, -6.6338301], [110.7102465, -6.6337751], [110.7101239, -6.6336908], [110.7099983, -6.6336146], [110.7098619, -6.6335274], [110.7097773, -6.6334753], [110.7097068, -6.6334299], [110.7095942, -6.6334068], [110.7095123, -6.6333912], [110.7094108, -6.6333947], [110.7092322, -6.6334018], [110.7091544, -6.6334603], [110.7089687, -6.633814], [110.7088107, -6.6340389], [110.7086875, -6.6341619], [110.708556, -6.6342948], [110.7082194, -6.6342919], [110.7081109, -6.6342052], [110.7080001, -6.6339874], [110.7080307, -6.6336313], [110.7080614, -6.6334556], [110.7080048, -6.633383], [110.7078704, -6.6333174], [110.7074152, -6.6332074], [110.7068068, -6.6336501], [110.7067502, -6.633472], [110.706729, -6.6332472], [110.7065168, -6.6331465], [110.7064154, -6.6330223], [110.7063069, -6.6329286], [110.7061689, -6.6327389], [110.705952, -6.6323524], [110.7057209, -6.6323969], [110.7055818, -6.6324625], [110.7054382, -6.6325868], [110.7053713, -6.6325879], [110.7053463, -6.6325877], [110.7052999, -6.6325695], [110.7052057, -6.632529], [110.705175, -6.6325218], [110.7050311, -6.6324913], [110.7048889, -6.6325182], [110.7046338, -6.6327404], [110.7045219, -6.632582], [110.7043271, -6.6323813], [110.7040824, -6.6321426], [110.7039468, -6.6320049], [110.7037945, -6.6317591], [110.7035794, -6.6314178], [110.7034365, -6.63123], [110.703093, -6.6308085], [110.7027423, -6.6304071], [110.7024276, -6.63003], [110.7020697, -6.6296042], [110.7015486, -6.6296315], [110.7005917, -6.6296816], [110.7000728, -6.6292186], [110.6996658, -6.6291669], [110.6990892, -6.6292272], [110.6989282, -6.6292393], [110.6987933, -6.6292061], [110.6987322, -6.6291904], [110.6986516, -6.6291693], [110.6985429, -6.6291397], [110.6984428, -6.6291139], [110.6983552, -6.6290924], [110.6979145, -6.6291101], [110.6977379, -6.629118], [110.6977135, -6.6291067], [110.697689, -6.6290828], [110.6973787, -6.6289581], [110.6971162, -6.6287935], [110.697077, -6.6287684], [110.6970277, -6.6287464], [110.696968, -6.6287182], [110.6968783, -6.6286749], [110.6968213, -6.6286477], [110.6967366, -6.6286162], [110.6965526, -6.6289299], [110.696212, -6.6297108], [110.6958858, -6.6306006], [110.6957616, -6.6309978], [110.6956, -6.6315153], [110.6953965, -6.632063], [110.6953286, -6.6322437], [110.6952002, -6.632658], [110.6950746, -6.633253], [110.6949548, -6.6338551], [110.6947924, -6.6345834], [110.6947159, -6.6348716], [110.6946979, -6.6348988], [110.6947549, -6.6349211], [110.6955552, -6.6353552], [110.6957554, -6.6354728], [110.6964116, -6.6358742], [110.6968326, -6.6361203], [110.6955966, -6.6379817], [110.6953426, -6.6382876], [110.6947691, -6.639186], [110.6941725, -6.6400003], [110.6937414, -6.6407802], [110.693626, -6.6410249], [110.6933123, -6.6415516], [110.6931901, -6.6417427], [110.6931179, -6.6418756], [110.6929572, -6.6422273], [110.6928485, -6.642386], [110.6926378, -6.6427788], [110.6925781, -6.6429011], [110.6924934, -6.6433331], [110.6915389, -6.6444418], [110.6912233, -6.6448165], [110.6908538, -6.6446616], [110.690467, -6.6445947], [110.6902572, -6.6446081], [110.6896731, -6.644676], [110.6894585, -6.6447883], [110.6892988, -6.6448695], [110.6890987, -6.6450645], [110.6886705, -6.6455431], [110.6885006, -6.6455809], [110.6886815, -6.6464554], [110.688543, -6.6468033], [110.6886469, -6.6473041], [110.6887277, -6.6475182], [110.689205, -6.648321], [110.6895899, -6.6488104], [110.6900056, -6.6495215], [110.6902192, -6.6500032], [110.6903962, -6.6503931], [110.6904674, -6.650655], [110.6904905, -6.6508786], [110.6904559, -6.6511348], [110.6901817, -6.6513699], [110.6900056, -6.6516165], [110.6899473, -6.6516786], [110.6895199, -6.6521515], [110.689397, -6.6522867], [110.6893426, -6.6523983], [110.6893153, -6.6524539], [110.6892932, -6.6524983], [110.6892597, -6.652566], [110.6892721, -6.6525659], [110.6891576, -6.6527604], [110.68895, -6.6531633], [110.6888259, -6.6535389], [110.6887903, -6.6539432], [110.6888345, -6.6543016], [110.688975, -6.6546929], [110.689179, -6.655274], [110.690318, -6.6564685]]]]
        }
    };

    // Inisialisasi peta
    var map = L.map('map', {
        center: [-6.6564685, 110.690318],
        zoom: 14,
        minZoom: 12,
        maxZoom: 19
    });

    // Base layers
    var openStreetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Layer groups
    var markers = L.markerClusterGroup();

    // Tambahkan GeoJSON ke peta
    var boundaryLayer = L.geoJSON(ngabulGeoJSON, {
        style: {
            color: '#2563eb',
            weight: 3,
            fillColor: '#2563eb',
            fillOpacity: 0.1,
            dashArray: '5, 5'
        },
        onEachFeature: function(feature, layer) {
            layer.bindPopup('Desa Ngabul, Kec. Tahunan');
        }
    }).addTo(map);

    // Sesuaikan view ke batas desa
    try {
        var bounds = boundaryLayer.getBounds();
        map.fitBounds(bounds);
    } catch (e) {
        console.error('Error setting bounds:', e);
    }

    // Tampilkan markers
    var keluarga = @json($keluarga);
    keluarga.forEach(function(k) {
        var color = k.status_bantuan == 'Sudah Dibantu' ? '#06b6d4' : 
                    k.status_bantuan == 'Sedang Diproses' ? '#8b5cf6' : '#f97316';
                    
        var marker = L.marker([k.latitude, k.longitude], {
            icon: L.divIcon({
                className: 'custom-div-icon',
                html: `<div style='background-color:${color};' class='marker-pin'></div>`,
                iconSize: [30, 42],
                iconAnchor: [15, 42]
            })
        }).bindPopup(
            `<strong>${k.nama_kk}</strong><br>
            ${k.alamat}<br>
            RT/RW: ${k.rt}/${k.rw}<br>
            Status: ${k.status_bantuan}`
        );
        
        markers.addLayer(marker);
    });

    map.addLayer(markers);

    // Inisialisasi Chart.js
    var ctx = document.getElementById('statusChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Belum Dibantu', 'Sedang Diproses', 'Sudah Dibantu'],
            datasets: [{
                data: [{{ $belumDibantu }}, {{ $sedangDiproses }}, {{ $sudahDibantu }}],
                backgroundColor: [
                    '#f97316', // orange
                    '#8b5cf6', // purple
                    '#06b6d4'  // cyan
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection 