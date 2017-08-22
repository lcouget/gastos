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
                <div class="box-header">
                    <h3 class="box-title">Ingresos</h3>
                </div>
                <div class="box-body">
                    <table id="table" class="table table-bordered table-hover">
                      <thead>
                          <tr>
                              <th>Fecha</th>
                              <th>Descripción</th>
                              <th>Monto</th>
                              <th>Categoría</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                              <th>Fecha</th>
                              <th>Descripción</th>
                              <th>Monto</th>
                              <th>Categoría</th>
                              <th>Acciones</th>
                          </tr>
                      </tfoot>
                      <tbody>
                        @isset($incomes)
                          @foreach ($incomes as $income)
                          <tr>
                              <td>{{ $income->income_date }}</td>
                              <td>{{ $income->description }}</td>
                              <td>{{ $income->amount }}</td>
                              <td>{{ $income->category->category }}</td>
                              <td> Editar | Borrar </td>
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
