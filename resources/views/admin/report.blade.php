@extends('layouts.main')
@section('content')

  <div class="container">
      <hr class="w-100">
    <div class="row card">
        <div class="card-header">
            <h5 class="card-title text-center">Available Assets</h5>
        </div>
        <div class="card-body">
            <table class="table table-light table-bordered table-striped">
                <tr>
                    <th>Name</th><th>description<th>
                </tr>
              @foreach($availableAssets as $asset)
                <tr>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->description }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
      <hr class="w-100">
      <div class="row card">
          <div class="card-header">
              <h5 class="card-title text-center">Borrowed Assets</h5>
          </div>
          <div class="card-body">
              <table class="table table-light table-bordered table-striped">
                  <tr>
                      <th>Name</th><th>description</th>
                  </tr>
                  @foreach($leasedAssets as $asset)
                      <tr>
                          <td>{{ $asset->name }}</td>
                          <td>{{ $asset->description }}</td>
                      </tr>
                  @endforeach
              </table>
          </div>
      </div>
  </div>
@stop
@section('scripts')
    <script src="/js/app.js"></script>
@stop