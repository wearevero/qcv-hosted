@extends('Templatez.index')
@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="table-responsiv">
            {{-- // no, metal, color, original gold, alloy, potongan, in_jujo, out_jujo, loss, 24K, granule, kadarkarat, remark --}}
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Metal</th>
                        <th>Color</th>
                        <th>Original</th>
                        <th>Alloy</th>
                        <th>Pohon</th>
                        <th>Potongan</th>
                        <th>In_Jujo</th>
                        <th>Out_Jujo</th>
                        <th>Loss</th>
                        <th>24K</th>
                        <th>%</th>
                        <th>Granule</th>
                        <th>Kadar Karat</th>
                        <th>Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $no=>$r)
                        <?php $lossRate = number_format((($r['loss'])/$r['in_jujo']*100),2) ?>
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $r['metal'] }}</td>
                            <td>{{ $r['color'] }}</td>
                            <td class="text-end pe-2">{{ $r['orig'] }}</td>
                            <td class="text-end pe-2">{{ $r['allo'] }}</td>
                            <td class="text-end pe-2">{{ $r['poho'] }}</td>
                            <td class="text-end pe-2">{{ $r['poto'] }}</td>
                            <td class="text-end pe-2">{{ $r['in_jujo'] }}</td>
                            <td class="text-end pe-2">{{ $r['out_jujo'] }}</td>
                            <td class="text-end pe-2">{{ $r['loss'] }}</td>
                            <td class="text-end pe-2">{{ $r['24k'] }}</td>
                            <td class="text-end pe-2">{{ $lossRate }} %</td>
                            <td class="text-end pe-2">{{ $r['granule'] }}</td>
                            <td class="text-end pe-2">{{ number_format(($r['kadarkarat']*100),2) }} %</td>
                            <td>{{ $r['remark'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
