@extends('layouts.app')

@section('title', 'แก้ไขสาขาวิชา')

@section('breadcrumb')
    <a href="{{ url('programs') }}">รายการสาขาวิชา</a>
    <i class="bi bi-chevron-right" style="font-size:11px"></i>
    <span>แก้ไขสาขาวิชา</span>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card border-0 shadow-sm rounded-3">

            {{-- Header --}}
            <div class="card-header bg-white border-bottom py-3">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-pencil-square text-primary"></i>
                    แก้ไขสาขาวิชา
                </h6>
            </div>

            {{-- Form Body --}}
            <div class="card-body p-4">
                <form action="{{ URL('programs/update', $program->program_id) }}" method="POST">
                    @csrf

                    {{-- รหัสสาขา --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            รหัสสาขาวิชา
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="text"
                               name="program_id"
                               class="form-control"
                               value="{{ $program->program_id }}"
                               maxlength="10"
                               readonly>
                        <div class="form-text" style="font-size:11.5px">
                            รหัสสาขาวิชาไม่สามารถแก้ไขได้
                        </div>
                    </div>

                    {{-- ชื่อสาขาวิชา --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            ชื่อสาขาวิชา
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <input type="text"
                               name="program_name"
                               class="form-control @error('program_name') is-invalid @enderror"
                               value="{{ old('program_name', $program->program_name) }}"
                               placeholder="เช่น วิศวกรรมคอมพิวเตอร์"
                               maxlength="100"
                               autofocus>
                        @error('program_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text" style="font-size:11.5px">
                            กรอกชื่อสาขาวิชาเต็มเป็นภาษาไทย
                        </div>
                    </div>

                    {{-- คณะ --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold" style="font-size:13.5px">
                            คณะ
                            <span class="text-danger ms-1">*</span>
                        </label>
                        <select name="faculty_id"
                                class="form-select @error('faculty_id') is-invalid @enderror">
                            <option value="">-- เลือกคณะ --</option>
                            @foreach($faculties as $f)
                                <option value="{{ $f->faculty_id }}"
                                    {{ old('faculty_id', $program->faculty_id) == $f->faculty_id ? 'selected' : '' }}>
                                    {{ $f->faculty_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('faculty_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ url('programs') }}"
                           class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left me-1"></i> ยกเลิก
                        </a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-floppy me-1"></i> บันทึกสาขาวิชา
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
@endsection
