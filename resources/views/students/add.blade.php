@extends('layouts.app')

@section('title', 'เพิ่มข้อมูลนักศึกษาใหม่')

@section('breadcrumb')
    <a href="{{ url('students') }}">นักศึกษา</a>
    <i class="bi bi-chevron-right" style="font-size:11px"></i>
    <span>เพิ่มข้อมูลนักศึกษาใหม่</span>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">

        <div class="card border-0 shadow-sm rounded-3">

            {{-- Header --}}
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-diagram-3 text-primary"></i>
                    เพิ่มข้อมูลนักศึกษาใหม่
                </h6>
            </div>

            <div class="card-body p-4">

                {{-- Info Box --}}
                <div class="info-box mb-4">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>
                        กรอกข้อมูลนักศึกษาให้ครบถ้วน
                        และเลือกคณะที่สาขาวิชานี้สังกัดอยู่
                    </div>
                </div>

                <form action="{{ url('students/create') }}"
                      method="POST" id="studentForm">
                    @csrf

                    {{-- รหัสนักศึกษา --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold"
                               style="font-size:13.5px">
                            รหัสนักศึกษา
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="text"
                               name="student_id"
                               id="student_id"
                               class="form-control @error('student_id') is-invalid @enderror"
                               value="{{ old('student_id') }}"
                               placeholder="เช่น CS001, IT002, ACC003"
                               maxlength="10"
                               autofocus>
                        @error('student_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" style="font-size:11.5px">
                            รหัสนักศึกษาต้องไม่ซ้ำกัน ความยาวไม่เกิน 80 ตัวอักษร
                        </div>
                    </div>

                    {{-- ชื่อนักศึกษา --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold"
                               style="font-size:13.5px">
                            ชื่อนักศึกษา
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="text"
                               name="student_name"
                               id="student_name"
                               class="form-control @error('student_name') is-invalid @enderror"
                               value="{{ old('student_name') }}"
                               placeholder="เช่น วิทยาการคอมพิวเตอร์"
                               maxlength="100">
                        @error('student_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                     {{-- Dropdown คณะ (ไม่แสดง preview) --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold"
                               style="font-size:13.5px">
                            คณะที่สังกัด
                            <span class="text-danger ms-1">*</span>
                        </label>

                        <select name="faculty_id"
                                id="faculty_id"
                                class="form-select @error('faculty_id') is-invalid @enderror">
                            <option value="">-- เลือกคณะ --</option>
                            @foreach($faculties as $faculty)
                                <option value="{{ $faculty->faculty_id }}"
                                    data-name="{{ $faculty->faculty_name }}"
                                    {{ old('faculty_id') == $faculty->faculty_id
                                        ? 'selected' : '' }}>
                                    {{ $faculty->faculty_name }}
                                    ({{ $faculty->faculty_id }})
                                </option>
                            @endforeach
                        </select>

                        @error('faculty_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" style="font-size:11.5px">
                            เลือกคณะที่สาขาวิชานี้สังกัดอยู่
                        </div>
                    </div>

                    {{-- Dropdown สาขาวิชา --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            สาขาวิชา
                            <span class="text-danger ms-1">*</span>
                        </label>

                        <select name="program_id"
                                id="program_id"
                                class="form-select @error('program_id') is-invalid @enderror"
                                disabled>
                            <option value="">-- กรุณาเลือกคณะก่อน --</option>
                        </select>

                        @error('program_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" style="font-size:11.5px">
                            เลือกสาขาวิชาที่นักศึกษาสังกัด
                        </div>
                    </div>



                    {{-- อีเมล --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold"
                               style="font-size:13.5px">
                            อีเมล
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="เช่น example@email.com"
                               maxlength="100">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold"
                               style="font-size:13.5px">
                            ที่อยู่
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="text"
                               name="address"
                               id="address"
                               class="form-control @error('address') is-invalid @enderror"
                               value="{{ old('address') }}"
                               placeholder="เช่น 123 ถนน example"
                               maxlength="100">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-3">

                    {{-- ชื่อผู้ใช้งาน --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            ชื่อผู้ใช้งาน (Username)
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="text"
                               name="username"
                               id="username"
                               class="form-control @error('username') is-invalid @enderror"
                               value="{{ old('username') }}"
                               placeholder="เช่น 6512345001"
                               maxlength="50"
                               autocomplete="off">
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" style="font-size:11.5px">
                            ใช้สำหรับเข้าสู่ระบบ ต้องไม่ซ้ำกับผู้ใช้งานอื่น
                        </div>
                    </div>

                    {{-- รหัสผ่าน --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            รหัสผ่าน
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password"
                                   name="password"
                                   id="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="อย่างน้อย 8 ตัวอักษร"
                                   autocomplete="new-password">
                            <button class="btn btn-outline-secondary"
                                    type="button"
                                    id="togglePassword"
                                    tabindex="-1">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        {{-- แถบวัดความปลอดภัยของรหัสผ่าน --}}
                        <div class="strength-wrap mt-2" id="strengthWrap" style="display:none">
                            <div class="strength-bar">
                                <div class="strength-fill" id="strengthFill"></div>
                            </div>
                            <div class="strength-label" id="strengthLabel"></div>
                        </div>

                        {{-- เช็คลิสต์เงื่อนไขความปลอดภัย --}}
                        <ul class="password-checklist mt-2" id="passwordChecklist">
                            <li id="check-length">
                                <i class="bi bi-circle"></i> อย่างน้อย 8 ตัวอักษร
                                 <i class="bi bi-circle"></i> ตัวพิมพ์ใหญ่ (A-Z) อย่างน้อย 1 ตัว
                                 <i class="bi bi-circle"></i> ตัวพิมพ์เล็ก (a-z) อย่างน้อย 1 ตัว
                            </li>
                            {{-- <li id="check-upper">
                                <i class="bi bi-circle"></i> ตัวพิมพ์ใหญ่ (A-Z) อย่างน้อย 1 ตัว
                            </li> --}}
                            <li id="check-lower">

                                <i class="bi bi-circle"></i> ตัวเลข (0-9) อย่างน้อย 1 ตัว
                                 <i class="bi bi-circle"></i> อักขระพิเศษ (!@#$%^&* ฯลฯ) อย่างน้อย 1 ตัว
                            </li>
                            {{-- <li id="check-number">
                                <i class="bi bi-circle"></i> ตัวเลข (0-9) อย่างน้อย 1 ตัว
                            </li> --}}
                            {{-- <li id="check-special">
                                <i class="bi bi-circle"></i> อักขระพิเศษ (!@#$%^&* ฯลฯ) อย่างน้อย 1 ตัว
                            </li> --}}
                        </ul>
                    </div>

                    {{-- ยืนยันรหัสผ่าน --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            ยืนยันรหัสผ่าน
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="password"
                               name="password_confirmation"
                               id="password_confirmation"
                               class="form-control"
                               placeholder="กรอกรหัสผ่านอีกครั้ง"
                               autocomplete="new-password">
                        <div class="form-text" id="matchFeedback" style="font-size:11.5px"></div>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ url('students') }}"
                           class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i> ยกเลิก
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-floppy me-1"></i> บันทึกข้อมูลนักศึกษา
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@section('styles')
<style>
    .info-box {
        background: #e6f1fb; border: 1px solid #b5d4f4;
        border-radius: 8px; padding: .65rem .9rem;
        display: flex; align-items: flex-start;
        gap: 8px; font-size: 12.5px; color: #0c447c;
    }
    .info-box i { font-size: 15px; color: #185fa5;
                  flex-shrink: 0; margin-top: 1px; }

    /* Password strength meter */
    .strength-bar {
        height: 6px; border-radius: 3px;
        background: #e9ecef; overflow: hidden;
    }
    .strength-fill {
        height: 100%; width: 0%;
        border-radius: 3px;
        transition: width .25s ease, background-color .25s ease;
    }
    .strength-label {
        font-size: 11.5px; font-weight: 600;
        margin-top: 4px;
    }

    /* Password checklist */
    .password-checklist {
        list-style: none; padding-left: 0; margin-bottom: 0;
    }
    .password-checklist li {
        font-size: 12px; color: #6c757d;
        display: flex; align-items: center; gap: 6px;
        margin-bottom: 3px; transition: color .2s;
    }
    .password-checklist li i { font-size: 13px; }
    .password-checklist li.valid {
        color: #198754;
    }
</style>
@endsection

@section('scripts')
<script>
    /* ---------- Dropdown สาขาวิชา (โหลดตามคณะที่เลือก) ---------- */
    const facultySelect  = document.getElementById('faculty_id');
    const programSelect  = document.getElementById('program_id');

    const oldProgramId = "{{ old('program_id') }}";

    function loadPrograms(facultyId, selectedProgramId = null) {
        programSelect.innerHTML = '<option value="">กำลังโหลด...</option>';
        programSelect.disabled = true;

        if (!facultyId) {
            programSelect.innerHTML = '<option value="">-- กรุณาเลือกคณะก่อน --</option>';
            return;
        }

        fetch(`/programs/by-faculty/${facultyId}`)
            .then(res => res.json())
            .then(programs => {
                programSelect.innerHTML = '<option value="">-- เลือกสาขาวิชา --</option>';

                if (programs.length === 0) {
                    programSelect.innerHTML = '<option value="">-- คณะนี้ยังไม่มีสาขาวิชา --</option>';
                    return;
                }

                programs.forEach(program => {
                    const opt = document.createElement('option');
                    opt.value = program.program_id;
                    opt.textContent = `${program.program_name} (${program.program_id})`;
                    if (selectedProgramId && selectedProgramId === program.program_id) {
                        opt.selected = true;
                    }
                    programSelect.appendChild(opt);
                });

                programSelect.disabled = false;
            })
            .catch(err => {
                console.error(err);
                programSelect.innerHTML = '<option value="">เกิดข้อผิดพลาดในการโหลดข้อมูล</option>';
            });
    }

    facultySelect.addEventListener('change', function () {
        loadPrograms(this.value);
    });

    window.addEventListener('DOMContentLoaded', function () {
        if (facultySelect.value) {
            setTimeout(() => loadPrograms(facultySelect.value, oldProgramId), 100);
        }
    });

    /* ---------- ปุ่มแสดง/ซ่อนรหัสผ่าน ---------- */
    const passwordInput = document.getElementById('password');
    const toggleBtn      = document.getElementById('togglePassword');
    const toggleIcon     = document.getElementById('toggleIcon');

    toggleBtn.addEventListener('click', function () {
        const isHidden = passwordInput.type === 'password';
        passwordInput.type = isHidden ? 'text' : 'password';
        toggleIcon.classList.toggle('bi-eye');
        toggleIcon.classList.toggle('bi-eye-slash');
    });

    /* ---------- ตรวจสอบความปลอดภัยของรหัสผ่าน ---------- */
    const strengthWrap  = document.getElementById('strengthWrap');
    const strengthFill  = document.getElementById('strengthFill');
    const strengthLabel = document.getElementById('strengthLabel');

    const rules = {
        length : { el: document.getElementById('check-length'),  test: v => v.length >= 8 },
        lower  : { el: document.getElementById('check-lower'),   test: v => /[a-z]/.test(v) },
        number : { el: document.getElementById('check-number'),  test: v => /[0-9]/.test(v) },
    };

    function setCheck(item, passed) {
        const icon = item.el.querySelector('i');
        item.el.classList.toggle('valid', passed);
        icon.classList.toggle('bi-circle', !passed);
        icon.classList.toggle('bi-check-circle-fill', passed);
    }

    passwordInput.addEventListener('input', function () {
        const value = this.value;

        if (!value) {
            strengthWrap.style.display = 'none';
        } else {
            strengthWrap.style.display = 'block';
        }

        let passedCount = 0;
        Object.values(rules).forEach(rule => {
            const passed = rule.test(value);
            setCheck(rule, passed);
            if (passed) passedCount++;
        });

        const percent = (passedCount / 5) * 100;
        strengthFill.style.width = percent + '%';

        if (passedCount <= 2) {
            strengthFill.style.backgroundColor = '#dc3545';
            strengthLabel.textContent = 'ความปลอดภัย: ต่ำ';
            strengthLabel.style.color = '#dc3545';
        } else if (passedCount <= 4) {
            strengthFill.style.backgroundColor = '#fd7e14';
            strengthLabel.textContent = 'ความปลอดภัย: ปานกลาง';
            strengthLabel.style.color = '#fd7e14';
        } else {
            strengthFill.style.backgroundColor = '#198754';
            strengthLabel.textContent = 'ความปลอดภัย: สูง';
            strengthLabel.style.color = '#198754';
        }

        checkMatch();
    });

    /* ---------- ตรวจสอบรหัสผ่านยืนยันให้ตรงกัน ---------- */
    const confirmInput   = document.getElementById('password_confirmation');
    const matchFeedback  = document.getElementById('matchFeedback');

    function checkMatch() {
        if (!confirmInput.value) {
            matchFeedback.textContent = '';
            return;
        }
        if (passwordInput.value === confirmInput.value) {
            matchFeedback.textContent = 'รหัสผ่านตรงกัน';
            matchFeedback.style.color = '#198754';
        } else {
            matchFeedback.textContent = 'รหัสผ่านไม่ตรงกัน';
            matchFeedback.style.color = '#dc3545';
        }
    }

    confirmInput.addEventListener('input', checkMatch);

    /* ---------- ป้องกันการ submit ถ้ารหัสผ่านยังไม่ผ่านเงื่อนไข ---------- */
    document.getElementById('studentForm').addEventListener('submit', function (e) {
        const value = passwordInput.value;
        const allPassed = Object.values(rules).every(rule => rule.test(value));

        if (!allPassed || passwordInput.value !== confirmInput.value) {
            e.preventDefault();
            alert('กรุณาตั้งรหัสผ่านให้ครบตามเงื่อนไข และยืนยันรหัสผ่านให้ตรงกัน');
        }
    });
</script>
@endsection
