@extends('layouts.admin')

@section('title', 'Jadwal Ronda - JagaRT')

@section('navbar')
    @include('partials.sidebar-admin')
@endsection

@section('content')

@push('styles')
<style>
.calendar-box {
    background: white;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.07);
}

/* BACKDROP */
.modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 999999 !important;
}

/* Modal box */
.modal-box {
    background:white;
    width: 420px;
    padding: 22px;
    border-radius: 12px;
    animation: popUp .25s ease;
    position: relative !important;
    z-index: 1000000 !important;
}

@keyframes popUp {
    from { transform: scale(0.9); opacity: 0; }
    to   { transform: scale(1);   opacity: 1; }
}

.user-list-box {
    max-height: 200px;
    overflow-y: auto;
    border: 1px solid #ddd;
    padding: 10px;
    border-radius: 8px;
}

.modal-btns {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.btn-cancel {
    background: #ccc;
    padding: 7px 16px;
    border-radius: 6px;
}

.btn-save {
    background: #0066ff;
    color: white;
    padding: 7px 16px;
    border-radius: 6px;
}

/* ====== CUSTOM CALENDAR THEME ====== */
/* ====== TOOLBAR ====== */
.fc-toolbar-title {
    color: #111827; /* navy */
    font-weight: 700;
}

.fc .fc-button {
    background: #111827 !important; /* navy */
    border: none !important;
    color: #ffffff !important;
    border-radius: 6px !important;
}

.fc .fc-button:hover {
    background: #1a2340 !important;
}

.fc-button-primary:not(:disabled).fc-button-active {
    background: #ff9977 !important; /* peach */
    color: #111827 !important;
}

/* ====== GRID HARI ====== */
.fc-daygrid-day {
    background: #ffffff;
    border-color: #e5e7eb;
}

/* Nama hari (Sun, Mon, ...) */
.fc-col-header-cell {
    background: #ff9977 !important;
}

.fc .fc-col-header-cell-cushion {
    color: #ffffff !important;
    font-weight: 700;
}

/* Angka tanggal */
.fc-daygrid-day-number {
    color: #111827; 
    font-weight: 600;
}

/* Hari ini */
.fc-day-today {
    background: #fff2ec !important; /* very soft peach */
    border: 1px solid #ff9977 !important;
    border-radius: 6px;
}

/* ====== EVENT ====== */
.fc-event {
    background: #ff9977 !important;
    border: 1px solid #e57c5b !important;
    color: #111827 !important;
    border-radius: 6px !important;
    padding: 3px 6px !important;
    font-weight: 600;
}

.fc-event:hover {
    background: #ff8a63 !important;
}

/* ====== HOVER DAY ====== */
.fc-daygrid-day:hover {
    background: #fff7f3;
}
</style>
@endpush

<div class="jadwal-container">

    <h3 class="page-title">Jadwal Ronda</h3>

    <div id="calendar" data-events='@json($events)' class="calendar-box"></div>

</div>

@push('modal')
<!-- Modal Jadwal Ronda -->
<div class="modal fade" id="modalJadwal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Buat Jadwal Ronda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.jadwal.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <!-- Tanggal -->
                    <label class="form-label">Tanggal Ronda</label>
                    <input type="date" id="tanggal_ronda" name="tanggal" class="form-control" required>

                    <!-- Lokasi -->
                    <label class="form-label mt-3">Lokasi Ronda</label>
                    <input type="text" name="lokasi" class="form-control" placeholder="Pos ronda blok A" required>

                    <!-- Pilih Warga -->
                    <label class="form-label mt-3">Pilih Warga</label>
                    <select name="users[]" class="form-select select2" multiple required>
                        @foreach($users as $u)
                            <option value="{{ $u->user_id }}">
                                {{ $u->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Keterangan -->
                    <label class="form-label mt-3">Keterangan (opsional)</label>
                    <textarea name="keterangan" rows="3" class="form-control"></textarea>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Modal Hapus User dari Jadwal -->
<div class="modal fade" id="modalHapusUser" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Hapus dari Jadwal Ronda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('admin.jadwal.destroy') }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <input type="hidden" name="jadwal_id" id="hapus_jadwal_id">
                    <input type="hidden" name="user_id" id="hapus_user_id">

                    <p class="mb-2 text-muted">Anda akan menghapus:</p>
                    <h5 id="hapus_user_nama" class="fw-bold"></h5>

                    <p class="mt-3">Dari jadwal ronda tanggal:</p>
                    <h6 id="hapus_tanggal_ronda"></h6>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>

            </form>

        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const calendarEl = document.getElementById('calendar');
    const events = JSON.parse(calendarEl.dataset.events || "[]");

    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        height: 650,
        events: events,

        dateClick: function(info) {

            // SET TANGGAL KE INPUT
            document.getElementById('tanggal_ronda').value = info.dateStr;

            // BUKA MODAL BOOTSTRAP
            let modal = new bootstrap.Modal(document.getElementById('modalJadwal'));
            modal.show();
        },

        // KLIK EVENT → buka modal hapus user dari jadwal
        eventClick: function(info) {
            const event = info.event;

            document.getElementById('hapus_jadwal_id').value = event.extendedProps.jadwal_id;
            document.getElementById('hapus_user_id').value = event.extendedProps.user_id;
            document.getElementById('hapus_user_nama').innerHTML = event.title;
            document.getElementById('hapus_tanggal_ronda').innerHTML = event.startStr;

            let modal = new bootstrap.Modal(document.getElementById('modalHapusUser'));
            modal.show();
        }        
    });

    calendar.render();
});
</script>

<script>
    $('.select2').select2({
        dropdownParent: $('#modalJadwal'),
        width: '100%'
    });
</script>
@endpush