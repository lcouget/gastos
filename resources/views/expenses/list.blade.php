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
                    <h3 class="box-title">Listado de gastos</h3>
                    &nbsp;&nbsp;
                    <a href="{{ url('/gasto/agregar') }}" class="btn btn-default btn-xs btn-flat"><i class="fa fa-plus"></i> Agregar </a>
                </div>
                <div class="box-body">
                    <table id="table" class="table table-bordered table-hover">
                      <thead class="center">
                          <tr>
                              <th>Fecha</th>
                              <th class="desktop-only">Descripción</th>
                              <th class="mobile-only">Desc.</th>
                              <th>Monto</th>
                              <th class="desktop-only">Categoría</th>
                              <th>Acción</th>
                          </tr>
                      </thead>
                      <tfoot class="center">
                          <tr>
                              <th>Fecha</th>
                              <th class="desktop-only">Descripción</th>
                              <th class="mobile-only">Desc.</th>
                              <th>Monto</th>
                              <th class="desktop-only">Categoría</th>
                              <th>Acción</th>
                          </tr>
                      </tfoot>
                      <tbody class="center">
                        @isset($expenses)
                          @foreach ($expenses as $expense)
                          <tr>
                              <td><span class="hidden">{{ $expense->expense_date }}</span>{{ $expense->expense_date_formatted }}</td>
                              <td class="desktop-only">{{ $expense->description }}</td>
                              <td class="mobile-only">{{ $expense->description }}</td>
                              <td>$ {{ $expense->amount_formatted }}</td>
                              <td class="desktop-only">{{ $expense->category->category }}</td>
                              <td>
                                <a href="{{ url('/gasto/editar')}}/{{$expense->id}}"><i class="fa fa-edit" title="editar"></i></a>&nbsp;&nbsp;
                                <a href="{{ url('/gasto/borrar')}}/{{$expense->id}}" onclick="if (confirm('Se va a borrar el gasto solicitado. Continuar?')) return true; else return false;"><i class="fa fa-remove" title="borrar"></i></a>
                              </td>
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
