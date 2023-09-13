@extends('layouts.default')

@section('title', 'Cadastro de Funcionário - SISRH ')

@section('content')
    <h1 class="fs-2 mb-3">Cadastro de Funcionário</h1>

    <form class="row g-3" method="POST" action="{{ route('funcionarios.store') }}" enctype="multipart/form-data">
        @csrf
        @include('funcionarios.partials.form')
        <div class="col-12">
          <button type="submit" class="btn btn-primary">Cadastrar</button>
          <a href="{{ route('funcionarios.index') }}" class="btn btn-danger">Cancelar</a>
        </div>
      </form>
@endsection
