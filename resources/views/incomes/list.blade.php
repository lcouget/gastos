@extends('adminlte::page')
@section('title', 'Gastos - Ingresos')
@section('content_header')
    <h1>Ingresos</h1>
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
      'responsive'  : true
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
                    <h3 class="box-title">Listado de ingresos</h3>
                    &nbsp;&nbsp;
                    <a href="{{ url('/ingreso/agregar') }}" class="btn btn-default btn-xs btn-flat"><i class="fa fa-plus"></i> Agregar </a>
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
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tfoot class="center">
                          <tr>
                              <th>Fecha</th>
                              <th class="desktop-only">Descripción</th>
                              <th class="mobile-only">Desc.</th>
                              <th>Monto</th>
                              <th class="desktop-only">Categoría</th>
                              <th>Acciones</th>
                          </tr>
                      </tfoot>
                      <tbody class="center">
                        @isset($incomes)
                          @foreach ($incomes as $income)
                          <tr>
                              <td>{{ $income->income_date_formatted }}</td>
                              <td class="desktop-only">{{ $income->description }}</td>
                              <td class="mobile-only">{{ $income->description }}</td>
                              <td>$ {{ $income->amount_formatted }}</td>
                              <td class="desktop-only">{{ $income->category->category }}</td>
                              <td>
                                <a href="{{ url('/ingreso/editar')}}/{{$income->id}}"><i class="fa fa-edit" title="editar"></i></a>&nbsp;&nbsp;
                                <a href="{{ url('/ingreso/borrar')}}/{{$income->id}}" onclick="if (confirm('Se va a borrar el ingreso solicitado. Continuar?')) return true; else return false;"><i class="fa fa-remove" title="borrar"></i></a>
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
