@extends('Templatez.index')
@section('content')
<div class="qcv-notif">
    <div class="col bg-info d-flex justify-content-center align-items-center" style="font-size: 16 pt;"><p id="qcv-notif"></p></div>
</div>
    <div class="row">
        {{-- Form Barcode --}}
        <div class="col-lg-4 col-xl-6">
            <div class="sub-title">
                <h4>Detail Paket</h4>
            </div>
                <div class="table-responsiv">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Barcode</td>
                                <td colspan="4" class="h5" id="barcode"></td>
                            </tr>
                            <tr>
                                <th>Spek.</th>
                                <th>Karat</th>
                                <th>Warna</th>
                                <th>Bobot</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Original</td>
                                <td id="original-karat"></td>
                                <td id="original-color"></td>
                                <td id="original-weight" class='text-end'></td>
                                <td id="original-remark"></td>
                            </tr>
                            <tr>
                                <td>Alloy</td>
                                <td id="alloy-karat"></td>
                                <td id="alloy-color"></td>
                                <td id="alloy-weight" class='text-end'></td>
                                <td id="alloy-remark"></td>
                            </tr>
                            <tr>
                                <td>Pohon</td>
                                <td id="pohon-karat"></td>
                                <td id="pohon-color"></td>
                                <td id="pohon-weight" class='text-end'></td>
                                <td id="pohon-remark"></td>
                            </tr>
                            <tr>
                                <td>Potongan</td>
                                <td id="potongan-karat"></td>
                                <td id="potongan-color"></td>
                                <td id="potongan-weight" class='text-end'></td>
                                <td id="potongan-remark"></td>
                            </tr>
                            <tr>
                                <td>Total Weight</td>
                                <td colspan="2" ></td>
                                <td id="total-weight" class='text-end bg-warning text-danger'></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <th id="respondedBy">Diterima Oleh</th>
                                <td>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="requestEdit">
                                        <label class="form-check-label" for="requestEdit">Kembalikan Data</label>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <input type="text" class="form-control" id="by_person">
                                </td>
                                <td>
                                    <button class="btn btn-primary rounded form-control" id="rcvButton">Terima</button>
                                    <button class="btn btn-primary rounded form-control" id="rtrButton" style="display:none;" onclick="returnData()">Return</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
        </div>
        {{-- Tabel Barcode --}}
        <div class="col-lg-8 col-xl-6">

            <div class="sub-title">
                <h4>Antrian Paket Masuk</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Barcode</th>
                            <th scope="col">Dikirim</th>
                            <th scope="col">Bobot Awal</th>
                            <th scope="col">Status</th>
                            <th scope="col">Bobot Akhir</th>
                            <th scope="col" class='text-center'>Kontrol</th>
                        </tr>
                    </thead>
                    <tbody id="melt-tbody">
                        <tr>
                            <td scope="col">MEL-240725-18KWG-01</td>
                            <td scope="col">2024-07-25 08:48:37 By Ika</td>
                            <td scope="col" class="text-end">6.250 gr</td>
                            <td scope="col" class="text-center">3</td>
                            <td scope="col" class="text-center"> - </td>
                            <td scope="col">
                                <button class="btn btn-sm btn-success rounded">Details</button>
                                <button class="btn btn-sm btn-warning rounded">Edit</button>
                                <button class="btn btn-sm btn-danger rounded">Delete</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- Processed Melt --}}
            <hr>
            <div class="sub-title">
                <h4>Paket Diterima</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Barcode</th>
                            <th scope="col">Received</th>
                            <th scope="col">Initial Weight</th>
                            <th scope="col">Current Status</th>
                            <th scope="col">Final Weight</th>
                            <th scope="col" class='text-center'>Control</th>
                        </tr>
                    </thead>
                    <tbody id="pmelt-tbody">
                        <tr>
                            <td scope="col">MEL-240725-18KWG-01</td>
                            <td scope="col">2024-07-25 08:48:37 By Ika</td>
                            <td scope="col" class="text-end">6.250 gr</td>
                            <td scope="col" class="text-center">3</td>
                            <td scope="col" class="text-center"> - </td>
                            <td scope="col">
                                &nbsp;
                                {{-- <button class="btn btn-sm btn-success rounded">Details</button>
                                <button class="btn btn-sm btn-warning rounded">Edit</button>
                                <button class="btn btn-sm btn-danger rounded">Delete</button> --}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="sub-title">Package Weight History</div>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th colspan="2">Barcode</th>
                            <th colspan="2">
                                <select id="pwh-barcodes" class="form-control">
                                    <option value="" disabled @selected(true)>Choose Barcode</option>
                                </select>
                            </th>
                            <th colspan="5">&nbsp;</th>
                        </tr>
                        <tr>
                            <th>On Status</th>
                            <th>Alloy</th>
                            <th>Original</th>
                            <th>Pohon</th>
                            <th>Potongan</th>
                            <th>Total Weight</th>
                            <th>Box Weight</th>
                            <th>Granule Weight</th>
                            <th>Recorded By</th>
                        </tr>
                    </thead>
                    <tbody id="pwh-tbody"></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/shared.js')}}"></script>
    <script src="{{asset('js/melting-jujo.js')}}"></script>
@endsection
