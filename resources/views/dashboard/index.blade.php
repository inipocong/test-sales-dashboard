<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Sales Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="p-4">
  <div class="container">
    <h1 class="mb-3">Dashboard Penjualan</h1>

    <form method="GET" class="form-inline mb-3">
      <input type="date" name="start_date" value="{{ $start ?? '' }}" class="form-control mr-2">
      <input type="date" name="end_date" value="{{ $end ?? '' }}" class="form-control mr-2">
      <button class="btn btn-primary" type="submit">Filter</button>
      <a href="{{ route('dashboard') }}" class="btn btn-secondary ml-2">Reset</a>
    </form>

    <h4>Total Penjualan: Rp {{ number_format($total,0,',','.') }}</h4>

    <div class="card mb-4"><div class="card-body">
      <canvas id="salesChart" height="120"></canvas>
    </div></div>

    <div class="card">
      <div class="card-body p-0">
        <table class="table table-sm mb-0">
          <thead class="thead-light">
            <tr><th>Produk</th><th>Tanggal</th><th>Jumlah</th><th>Harga</th><th>Subtotal</th></tr>
          </thead>
          <tbody>
            @forelse($sales as $s)
              <tr>
                <td>{{ $s->product_name }}</td>
                <td>{{ $s->sale_date->format('Y-m-d') }}</td>
                <td>{{ $s->quantity }}</td>
                <td>Rp {{ number_format($s->price,0,',','.') }}</td>
                <td>Rp {{ number_format($s->quantity * $s->price,0,',','.') }}</td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center">Tidak ada data</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

<script>
  const labels = {!! json_encode($labels) !!};
  const totals = {!! json_encode($totals) !!};

  const ctx = document.getElementById('salesChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: [{ label: 'Total Penjualan (Rp)', data: totals, fill: false, borderWidth: 2, tension: 0.2 }]
    },
    options: {
      scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + v.toLocaleString() } } }
    }
  });
</script>
</body>
</html>
