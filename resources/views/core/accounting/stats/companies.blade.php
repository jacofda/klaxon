@extends('jacofda::layouts.app')

@section('css')
<style>
figure{margin-bottom: 0;}
    .sparklist {overflow: visible;width: 100%;margin: 0;padding: 0;}
    .sparklist li {list-style: none;margin-right: 0;}
    .sparkline {display: inline-block;height: 1.3em;margin: 0 0.5em;-webkit-transition: all .5s ease;transition: all .5s ease;}
    .sparkline .index {position: relative;float: left;width: 10px;height: 1.3em;}
    .sparkline .index .count {display: block;position: absolute;bottom: 0;left: 1px;width: 100%;height: 0;font: 0/0 a;text-shadow: none;color: transparent;}
    .c1{background: #666;}
    .c2{background: #888;}
    .c3{background: #aaa;}
    .c4{background: #ccc;}
</style>
@stop

@include('jacofda::layouts.elements.title', ['title' => 'Statistiche Aziende'])

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <div class="card-tools">
                        {!!Form::open(['method' => 'GET'])!!}
                            <div class="input-group">
                                {!!Form::select('id', $companiesId, $companiesIdSelected, [ 'class'=> 'form-control form-control-sm selectCompany', 'multiple' => 'multiple'])!!}
                                <div class="input-group-append">
                                    <button class="input-group-text overlay btn btn-sm" style="padding:3px 9px;font-size:15px;">Confronta</button>
                                </div>
                            </div>
                        {!!Form::close()!!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width:50%">Ragione Sociale</th>
                                    <th>{{date('Y')-3}}</th>
                                    <th>{{date('Y')-2}}</th>
                                    <th>{{date('Y')-1}}</th>
                                    <th>{{date('Y')}}</th>
                                    <th class="d-none d-lg-table-cell"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($companies as $company)

                                    @php
                                        $temp = [];
                                        foreach(range((date('Y')-3), date('Y'), 1) as $key => $year)
                                        {
                                            if($year > 2018)
                                            {
                                                $e = $company->invoices()->anno($year)->consegnate()->entrate()->sum(\DB::raw('iva + imponibile'));
                                                $u = $company->invoices()->anno($year)->consegnate()->notediaccredito()->sum(\DB::raw('iva + imponibile'));
                                                $temp[$key] = $e - abs($u);
                                            }
                                            else
                                            {
                                                $e = $company->invoices()->anno($year)->entrate()->sum(\DB::raw('iva + imponibile'));
                                                $u = $company->invoices()->anno($year)->notediaccredito()->sum(\DB::raw('iva + imponibile'));
                                                $temp[$key] = $e - abs($u);
                                            }
                                        }

                                        $tot = array_sum($temp);
                                        $a_perc = ($tot > 0) ? round(($temp[0]/$tot)*100) : 0;
                                        $b_perc = ($tot > 0) ? round(($temp[1]/$tot)*100) : 0;
                                        $c_perc = ($tot > 0) ? round(($temp[2]/$tot)*100) : 0;
                                        $d_perc = ($tot > 0) ? round(($temp[3]/$tot)*100) : 0;
                                    @endphp

                                    <tr>
                                        <td style="width:50%"><a class="defaultColor" href="{{$company->url}}">{{$company->rag_soc}}</a></td>
                                        <td>{{\App\Classes\Primitive::NF($temp[0])}}</td>
                                        <td>{{\App\Classes\Primitive::NF($temp[1])}}</td>
                                        <td>{{\App\Classes\Primitive::NF($temp[2])}}</td>
                                        <td>{{\App\Classes\Primitive::NF($temp[3])}}</td>
                                        <td class="d-none d-lg-table-cell">
                                            <figure>
                                                <ul class="sparklist">
                                                    <li>
                                                        <span class="sparkline">
                                                        <span class="index"><span class="count c1" style="height: {{$a_perc}}%;"></span> </span>
                                                        <span class="index"><span class="count c2" style="height: {{$b_perc}}%;"></span> </span>
                                                        <span class="index"><span class="count c3" style="height: {{$c_perc}}%;"></span> </span>
                                                        <span class="index"><span class="count c4" style="height: {{$d_perc}}%;"></span> </span>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </figure>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th style="width:50%"></th>
                                    <th>{{date('Y')-3}}</th>
                                    <th>{{date('Y')-2}}</th>
                                    <th>{{date('Y')-1}}</th>
                                    <th>{{date('Y')}}</th>
                                    <th class="d-none d-lg-table-cell"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="width:50%"><strong>Totale</strong></td>
                                    <td>{{$annualStats[(date('Y')-3)]}}</td>
                                    <td>{{$annualStats[(date('Y')-2)]}}</td>
                                    <td>{{$annualStats[(date('Y')-1)]}}</td>
                                    <td>{{$annualStats[date('Y')]}}</td>
                                    <td class="d-none d-lg-table-cell"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="card-footer text-center">
                    {{ $companies->links() }}
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
<script>
    $('select.selectCompany').select2({placeholder:'Seleziona Aziende'});
$('button.overlay').on('click', function(e){
    e.preventDefault();
    let selected = 'stats/aziende?ids=';let count = 0;
    $.each($('select.selectCompany').select2('data'), function(){
        selected += $(this)[0].id+'-';
        count++;
    })
    if(count > 0)
    {
        selected = selected.substring(0, selected.length - 1);
        window.location.href = baseURL+''+selected;
    }
    else
    {
        window.location.href = baseURL+'stats/aziende'
    }
});

$('a#menu-stats-aziende').addClass('active');
$('a#menu-stats-aziende').parent('ul.nav-treeview').css('display', 'block');
$('a#menu-stats-aziende').parent('ul').parent('li.has-treeview ').addClass('menu-open');

</script>
@stop
