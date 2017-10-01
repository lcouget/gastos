@extends('adminlte::page')
@section('title', 'Gastos - Gastos')
@section('content_header')
@stop

@section('css')
@stop

@section('js')
<script>
$(function () {
    $('#table').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false,
      'responsive'  : true,
      'order': [[ 0, 'desc' ]]
  });
});
</script>
@stop

@section('content')
<div class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                @include('layouts.messages')
                <div class="box-header">
                    <h3 class="box-title">Listado de gastos/ingresos del mes actual</h3>
                </div>
                <div class="box-body">
                    <table id="table" class="table table-bordered table-hover">
                      <thead class="center">
                          <tr>
                              <th>Fecha</th>
                              <th class="desktop-only">Ingreso/gasto</th>
                              <th class="desktop-only">Descripción</th>
                              <th class="mobile-only">Desc.</th>
                              <th>Monto</th>
                              <th class="desktop-only">Categoría</th>
                          </tr>
                      </thead>
                      <tfoot class="center">
                          <tr>
                              <th>Fecha</th>
                              <th class="desktop-only">Ingreso/gasto</th>
                              <th class="desktop-only">Descripción</th>
                              <th class="mobile-only">Desc.</th>
                              <th>Monto</th>
                              <th class="desktop-only">Categoría</th>
                          </tr>
                      </tfoot>
                      <tbody class="center">
                        @isset($currentMonth)
                          @foreach ($currentMonth as $current)
                          <tr>
                              <td><span class="hidden">{{ $current->date }}</span>
                               {{ $current->date_formatted }}
                              </td>
                              <td class="desktop-only"><span class="label @if($current->class == 'Gasto') label-danger @else label-success @endif">{{ $current->class }}</td>
                              <td class="desktop-only">{{ $current->description }}</td>
                              <td class="mobile-only">{{ $current->description }}</td>
                              <td class="@if($current->class == 'Gasto') text-danger @else text-success @endif">@if($current->class == 'Gasto') - @else +@endif $ {{ $current->amount_formatted }}</td>
                              <td class="desktop-only">{{ $current->category->category }}</td>
      
                          </tr>
                          @endforeach
                        @endisset
                      </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
