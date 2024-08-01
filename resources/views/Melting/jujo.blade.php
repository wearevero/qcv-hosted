@extends('Templatez.index')
@section('content')
<div class="qcv-notif">
    <div class="col bg-info d-flex justify-content-center align-items-center" style="font-size: 16 pt;"><p id="qcv-notif"></p></div>
</div>
    <div class="row">
        {{-- Form Barcode --}}
        <div class="col-lg-4 col-xl-6">
            <div class="sub-title">
                <h4>Package Details</h4>
            </div>
            <form action="#" id="process-barcode" @disabled(true)>
                <div class="form-group row my-3">
                    <label for="barcode" class="col-sm-4 col-form-label">Barcode</span></label>
                    <div class="col-sm-2">
                        <select id="bc-karat" class="form-control" disabled>
                            <option value="" disabled selected>Pilih Karat</option>
                            <option value="9KV">9KV</option>
                            <option value="10K">10K</option>
                            <option value="14K">14K</option>
                            <option value="14KV">14KV</option>
                            <option value="18K">18K</option>
                            <option value="18KV">18KV</option>
                            <option value="22K">22K</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select id="bc-color" class='form-control' disabled>
                            <option value="" disabled selected>Pilih Color</option>
                            <option value="RG">RG</option>
                            <option value="WG">WG</option>
                            <option value="YG">YG</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <input type="text" name="barcode" id="barcode" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row my-3">
                    <label for="xxx" class='col-sm-4'>Alloy</label>
                    <div class="col-sm-2"><input type="text" class="form-control" name ="alloy-karat" id="alloy-karat" placeholder="karat" disabled></div>
                    <div class="col-sm-2"><input type="text" class="form-control" name ="alloy-color" id="alloy-color" placeholder="color" disabled></div>
                    <div class="col-sm-2"><input type="number" min="0" step="0.01" class="form-control" name ="alloy-weight" id="alloy-weight" placeholder="weight"></div>
                    <div class="col-sm-2"><input type="text" class="form-control" name ="alloy-remark" id="alloy-remark" placeholder="remark"></div>
                </div>
                <div class="form-group row my-3">
                    <label for="xxx" class='col-sm-4'>Original</label>
                    <div class="col-sm-2"><input type="text" class="form-control" name ="original-karat" id="original-karat" placeholder="karat"></div>
                    <div class="col-sm-2"><input type="text" class="form-control" name ="original-color" id="original-color" placeholder="color"></div>
                    <div class="col-sm-2"><input type="number" min="0" step="0.01" class="form-control" name ="original-weight" id="original-weight" placeholder="weight"></div>
                    <div class="col-sm-2"><input type="text" class="form-control" name ="original-remark" id="original-remark" placeholder="remark"></div>
                </div>
                <div class="form-group row my-3">
                    <label for="xxx" class='col-sm-4'>Pohon</label>
                    <div class="col-sm-2"><input type="text" class="form-control" name ="pohon-karat" id="pohon-karat" placeholder="karat"></div>
                    <div class="col-sm-2"><input type="text" class="form-control" name ="pohon-color" id="pohon-color" placeholder="color"></div>
                    <div class="col-sm-2"><input type="number" min="0" step="0.01" class="form-control" name ="pohon-weight" id="pohon-weight" placeholder="weight"></div>
                    <div class="col-sm-2"><input type="text" class="form-control" name ="pohon-remark" id="pohon-remark" placeholder="remark"></div>
                </div>
                <div class="form-group row my-3">
                    <label for="xxx" class='col-sm-4'>Potongan</label>
                    <div class="col-sm-2"><input type="text" class="form-control" name ="potongan-karat" id="potongan-karat" placeholder="karat"></div>
                    <div class="col-sm-2"><input type="text" class="form-control" name ="potongan-color" id="potongan-color" placeholder="color"></div>
                    <div class="col-sm-2"><input type="number" min="0" step="0.01" class="form-control" name ="potongan-weight" id="potongan-weight" placeholder="weight"></div>
                    <div class="col-sm-2"><input type="text" class="form-control" name ="potongan-remark" id="potongan-remark" placeholder="remark"></div>
                </div>
                <div class="form-group row py-3 my-3"style="border-top:1px solid black;">
                    <label for="by_user" class="col-sm-4">Received By</label>
                    <div class="col-sm-4">
                        <input type="text" name="by_user" class="form-control" id="by_person" disabled>
                    </div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary rounded form-control" disabled>Received</button>
                    </div>
                </div>
                
            </form>
        </div>
        {{-- Tabel Barcode --}}
        <div class="col-lg-8 col-xl-6">

            <div class="sub-title">
                <h4>Incoming Package</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Barcode</th>
                            <th scope="col">Send</th>
                            <th scope="col">Initial Weight</th>
                            <th scope="col">Current Status</th>
                            <th scope="col">Final Weight</th>
                            <th scope="col" class='text-center'>Control</th>
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
                <h4>Received Package</h4>
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
                                <button class="btn btn-sm btn-success rounded">Details</button>
                                <button class="btn btn-sm btn-warning rounded">Edit</button>
                                <button class="btn btn-sm btn-danger rounded">Delete</button>
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
