<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ผลการเรียน | ARU Student System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body { background: #f4f6fb; font-family: 'Segoe UI', sans-serif; }
        .topbar {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: #fff; padding: 2rem 0 3.5rem;
        }
        .topbar-content {
            max-width: 1100px; margin: 0 auto; padding: 0 1.5rem;
            display: flex; justify-content: space-between; align-items: flex-start;
        }
        .back-link { color: #fff; text-decoration: none; font-size: 0.9rem; opacity: 0.9; }
        .back-link:hover { opacity: 1; color: #fff; }
        .container-main {
            max-width: 1100px; margin: -2rem auto 2rem; padding: 0 1.5rem;
            position: relative; z-index: 2;
        }
        .card-panel {
            background: #fff; border-radius: 18px; padding: 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06); margin-bottom: 1.5rem;
        }
        .gpa-summary-card {
            background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%);
            border-radius: 18px; padding: 1.5rem;
            box-shadow: 0 4px 16px rgba(0,0,0,0.06); margin-bottom: 1.5rem;
            display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
        }
        .gpa-summary-card .gpa-value { font-size: 2.2rem; font-weight: 800; color: #1e40af; }
        .semester-badge {
            background: #dbeafe; color: #1e40af; border-radius: 50px;
            padding: 0.35rem 0.9rem; font-size: 0.85rem; font-weight: 600;
        }
        .semester-gpa-badge {
            background: #dcfce7; color: #16a34a; border-radius: 50px;
            padding: 0.35rem 0.9rem; font-size: 0.85rem; font-weight: 700;
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
    </style>
</head>
<body>
    <div class="topbar">
        <div class="topbar-content">
            <div>
                <a href="{{ route('student.dashboard') }}" class="back-link mb-2 d-inline-block">
                    <i class="bi bi-arrow-left"></i> กลับหน้าหลัก
                </a>
                <h5 class="mb-0 fw-bold mt-1"><i class="bi bi-journal-check me-2"></i>ผลการเรียน</h5>
                <small class="opacity-85">รายวิชาที่ลงทะเบียนและเกรดในแต่ละภาคเรียน</small>
            </div>
        </div>
    </div>

    <div class="container-main">

        {{-- สรุปเกรดเฉลี่ยสะสมทั้งหมด --}}
        <div class="gpa-summary-card">
            <div>
                <div class="text-muted small mb-1"><i class="bi bi-award me-1"></i>เกรดเฉลี่ยสะสมทั้งหมด (GPAX)</div>
                <div class="gpa-value">{{ $overallGpa !== null ? number_format($overallGpa, 2) : '-' }}</div>
            </div>
            <a href="{{ route('student.gpa') }}" class="btn btn-primary btn-sm rounded-pill px-3">
                ดูรายละเอียดเกรดเฉลี่ย <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        @forelse($details as $semester => $items)
        <div class="card-panel">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <span class="semester-badge">
                    <i class="bi bi-calendar3 me-1"></i>ภาคเรียน {{ $semester }}
                </span>
                <span class="semester-gpa-badge">
                    <i class="bi bi-bar-chart-line me-1"></i>
                    เกรดเฉลี่ยภาคนี้ {{ isset($semesterGpa[$semester]) ? number_format($semesterGpa[$semester], 2) : '-' }}
                </span>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="text-muted small">
                        <tr>
                            <th>รหัสวิชา</th>
                            <th>ชื่อวิชา</th>
                            <th class="text-center">หน่วยกิต</th>
                            <th>ผู้สอน</th>
                            <th class="text-center">เกรด</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $d)
                        <tr>
                            <td>{{ $d->subject_code }}</td>
                            <td>{{ $d->subject->subject_name ?? '-' }}</td>
                            <td class="text-center">{{ $d->subject->credit ?? '-' }}</td>
                            <td>{{ $d->teacher->teacher_name ?? '-' }}</td>
                            <td class="text-center">
                                @php
                                    $grade = $d->grade;
                                    $gradeClass = match(true) {
                                        $grade === 'A' => 'grade-A',
                                        in_array($grade, ['B+', 'B']) => 'grade-B',
                                        in_array($grade, ['C+', 'C']) => 'grade-C',
                                        in_array($grade, ['D+', 'D']) => 'grade-D',
                                        $grade === 'F' => 'grade-F',
                                        default => 'grade-pending',
                                    };
                                @endphp
                                <span class="grade-pill {{ $gradeClass }}">
                                    {{ $grade ?: 'รอผล' }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @empty
        <div class="card-panel text-center text-muted py-5">
            <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
            ยังไม่มีรายวิชาที่ลงทะเบียน
        </div>
        @endforelse

    </div>
</body>
</html>
