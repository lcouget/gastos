@extends('adminlte::page')
@section('title', 'Gastos - Agregar Gasto')
@section('content_header')
@stop

@section('css')
<!--select 2-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css">
<link rel="styleshhet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/i18n/es.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.es.min.js"></script>
<script type="text/javascript">
  var isMobile = {{ ($isMobile) }};

  $(function() {
        $(".select2").select2();
        if (!isMobile ) {
            $('#expense_date').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true,
                clearBtn: true,
                language: "es",
                todayHighlight: true,
                todayBtn:true
             });
        }
  });
</script>
@stop

@section('content')
<div class="content">
    <div class="row">
        <div class="col-sm-12">
            <div class="box">
                @include('layouts.messages')
                <div class="box-header">
                    <h3 class="box-title">Agregar Gasto</h3>
                </div>
                <form class="form-horizontal" method="POST" action="{{ action('ExpenseController@add') }}">
                    <div class="box-body">
                        <div class="col-sm-10">
                            <div class="form-group">
                               <label for="category_id" class="control-sm-2 control-label">Categoría</label>
                                <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;">
                                    <option value="0">Seleccionar Categoría</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Fecha de gasto</label>
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    @if($isMobile)
                                        <input type="date" class="form-control pull-right" id="expense_date" name="expense_date" placeholder="dd/mm/aaaa" value="{{ old('expense_date') }}">
                                    @else
                                        <input type="text" class="form-control pull-right" id="expense_date" name="expense_date" placeholder="dd/mm/aaaa" value="{{ old('expense_date') }}">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Descripción</label>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                      <i class="fa fa-book"></i>
                                  </div>
                                    <input type="text" class="form-control" id="description" name="description" placeholder="opcional" value="{{ old('description') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Monto</label>
                                <div class="input-group">
                                    <span class="input-group-addon">$</span>
                                    <input type="number" class="form-control" min="0" step="0.01" id="amount" name="amount" placeholder="1234.56" value="{{ old('amount') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <a class="btn btn-default" href="{{ url('/gasto/listar') }}">Cancelar</a>
                        <button type="submit" class="btn btn-info pull-right">Agregar</button>
                    </div>
                    {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
