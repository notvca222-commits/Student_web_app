{{-- @extends('layouts.app')
@section('content')
<div class="container py-4">
  <h4>เกรดเฉลี่ยรายภาคเรียน</h4>
  <table class="table">
    <thead><tr><th>ภาคเรียน</th><th>GPA</th></tr></thead>
    <tbody>
      @foreach($semesterGpa as $sem => $gpa)
      <tr><td>{{ $sem }}</td><td>{{ number_format($gpa, 2) }}</td></tr>
      @endforeach
    </tbody>
  </table>
  <h5>เกรดเฉลี่ยสะสมทั้งหมด: {{ number_format($overallGpa, 2) }}</h5>
</div>
@endsection --}}




<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ประวัติการลงทะเบียน | ARU Student System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background: #f4f6fb; font-family: 'Segoe UI', sans-serif; }

        .topbar {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: #fff;
            padding: 2rem 0 3.5rem;
        }
        .topbar-content {
            max-width: 1100px; margin: 0 auto; padding: 0 1.5rem;
            display: flex; justify-content: space-between; align-items: flex-start;
        }
        .topbar-content h5 { margin-bottom: 0.35rem; }
        .topbar-content small { display: block; opacity: 0.85; }

        .container-main {
            max-width: 1100px; margin: -2rem auto 2rem; padding: 0 1.5rem;
            position: relative; z-index: 2;
        }

        .card-panel {
            background: #fff; border-radius: 18px; padding: 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06);
        }

        .semester-badge {
            background: #dbeafe; color: #1e40af; border-radius: 50px;
            padding: 0.35rem 0.9rem; font-size: 0.85rem; font-weight: 600;
        }

        .grade-pill {
            display: inline-block; min-width: 32px; text-align: center;
            border-radius: 50px; padding: 0.2rem 0.6rem; font-weight: 700; font-size: 0.8rem;
        }
        .grade-A { background: #dcfce7; color: #16a34a; }
        .grade-B { background: #dbeafe; color: #2563eb; }
        .grade-C { background: #fef3c7; color: #d97706; }
        .grade-D { background: #fee2e2; color: #dc2626; }
        .grade-F { background: #fee2e2; color: #991b1b; }
        .grade-pending { background: #f1f5f9; color: #94a3b8; }

        .back-link {
            color: #fff; text-decoration: none; font-size: 0.9rem;
            display: inline-flex; align-items: center; gap: 0.3rem; opacity: 0.9;
        }
        .back-link:hover { opacity: 1; color: #fff; }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="topbar-content">
            <div>
                <a href="{{ route('student.dashboard') }}" class="back-link mb-2">
                    <i class="bi bi-arrow-left"></i> กลับหน้าหลัก
                </a>
                <h5 class="mb-0 fw-bold mt-2"><i class="bi bi-clock-history me-2"></i>เกรดเฉลี่ย</h5>

            </div>
        </div>
    </div>

    <div class="container-main">
        <div class="card-panel">
        <h4>เกรดเฉลี่ยรายภาคเรียน</h4>
        <table class="table">
            <thead><tr><th>ภาคเรียน</th><th>GPA</th></tr></thead>
            <tbody>
            @foreach($semesterGpa as $sem => $gpa)
            <tr><td>{{ $sem }}</td><td>{{ number_format($gpa, 2) }}</td></tr>
            @endforeach
            </tbody>
        </table>
        <h5>เกรดเฉลี่ยสะสมทั้งหมด: {{ number_format($overallGpa, 2) }}</h5>
    </div>
    </div>

</body>
</html>
