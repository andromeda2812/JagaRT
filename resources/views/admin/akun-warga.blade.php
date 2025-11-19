@extends('layouts.app')

@section('title', 'Akun Warga - JagaRT')

@section('content')

{{-- Sidebar --}}
@include('partials.navbar-admin')

<div class="akunwarga-container">

    <h3 class="page-title">Akun Warga</h3>

    <div class="table-box">
        <table class="table akun-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Nomor Rumah</th>
                    <th>Nomor HP</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($warga as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->no_rumah }}</td>
                    <td>{{ $item->no_hp }}</td>

                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.akun-warga.edit', $item->user_id) }}"
                               class="btn-manage btn-edit">
                               Edit
                            </a>

                            <form action="{{ route('admin.akun-warga.delete', $item->user_id) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Hapus akun warga ini?')"
                                    class="btn-manage btn-delete">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="no-data text-center py-3">
                        Belum ada data warga.
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>

@endsection
