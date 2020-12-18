@php
    $l = explode(',',$aziende->labels);
    $d = explode(',',$aziende->data);
    $summary = [];
    foreach($l as $key => $label)
    {
        $label = str_replace('"', '', $label);
        $id = Jacofda\Klaxon\Models\Client::where('nome', $label)->first()->id;
        $summary[$id]['value'] = $d[$key];
        $summary[$id]['label'] = $label;
    }
@endphp
<div class="col-6">
    <div class="card card-outline card-info">

        <div class="card-header">
            <h3 class="card-title">Aziende ({{$aziende->total}})</h3>
        </div>
        <div class="card-body">
            <canvas id="pieChartCompanies" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
        </div>
        <div class="card-footer bg-info">
            <div class="row">
                @foreach($summary as $id => $values)
                    <div class="col text-center">
                        <a href="{{url('companies?tipo='.$id)}}" style="color:#fff;">{{$values['label']}}: {{$values['value']}}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@push('scripts')
<script>

    var pieCompanies  = {
      labels: [{!!$aziende->labels!!}],
      datasets: [
        {
          data: [{{$aziende->data}}],
          backgroundColor : [ '#00c0ef', '#3c8dbc', '#d2d6de'],
        }
      ]
  }

    var pieChartCanvas = $('#pieChartCompanies').get(0).getContext('2d')
    var pieOptions     = {maintainAspectRatio : false,responsive : true}

    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieCompanies,
      options: pieOptions
    });
</script>

@endpush
