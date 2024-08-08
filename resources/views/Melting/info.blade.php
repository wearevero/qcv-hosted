@extends('Templatez.index')
@section('content')
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="sub-title">
                <h4>Melting Process Information</h4>
            </div>
            <div>
                <h3>Melt Barcode: {{ $barcode}}</h3>
                <div class="table-responsive">
                    <h5>Material</h5>
                    <table class="table table-sm table-bordered" id="melt-material"></table>
                </div>
                <div class="table-responsive">
                    <h5>Status Histories</h5>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Status #</th>
                                <th>Status Name</th>
                                <th>Recorded By</th>
                                <th>Recorded At</th>
                            </tr>
                        </thead>
                        <tbody id="melt-histories"></tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <h5>Weights Histories</h5>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>On Status #</th>
                                <th>Alloy</th>
                                <th>Original</th>
                                <th>Pohon</th>
                                <th>Potongan</th>
                                <th>Melt Weight</th>
                                <th>Box Weight</th>
                                <th>Granule Weigt</th>
                            </tr>
                        </thead>
                        <tbody  id="melt-weights"></tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <h5>Loss Calculation</h5>
                    <table class="table table-sm mt-3">
                        <thead>
                            <tr>
                                <th width="40%">Loss Calculation</th>
                                <th width="30%">Gram</th>
                                <th width="30%">Rate (%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Minimum</th>
                                <td class="text-end" id="minLossGram">0</td>
                                <td class="text-end" id="minLossRate">0</td>
                            </tr>
                            <tr>
                                <th>Maximum</th>
                                <td class="text-end" id="maxLossGram">0</td>
                                <td class="text-end" id="maxLossRate">0</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const barcode="<?php echo $barcode?>";
    </script>
    <script src="{{asset('js/shared.js')}}"></script>
    <script src="{{asset('js/meltinfo.js')}}"></script>
@endsection