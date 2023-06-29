@extends('layouts.app')

@include('hak-akses.create')
{{-- @include('data-pengguna.edit') --}}

@section('content')

<div class="section-header">
    <h1>Aktivitas User</h1>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table_id" class="display">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Before</th>
                                <th>After</th>
                                <th>Description</th>
                                <th>Log At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($log->causer !== null)
                                        {{ $log->causer->name }}
                                    @endif
                                </td>
                                <td>
                                    @if (isset($log->changes['old']))
                                        @foreach ($log->changes['old'] as $key => $itemChange)
                                            {{ $key }} : {{ $itemChange }} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if (isset($log->changes['attributes']))
                                        @foreach ($log->changes['attributes'] as $key => $itemChange)
                                            {{ $key }} : {{ $itemChange }} <br>
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $log->description }}</td>
                                <td>{{ $log->created_at->format('d-m-Y H:i:s') }}</td>
                            </tr>
                            @endforeach                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Datatables Jquery -->
<script>
    $(document).ready(function(){
        $('#table_id').DataTable({
            paging: true
        });
    })
</script>


@endsection