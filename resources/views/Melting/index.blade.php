@extends('Templatez.index')
@section('content')
<div class="qcv-notif">
    <div class="col bg-info d-flex justify-content-center align-items-center" style="font-size: 16 pt;"><p id="qcv-notif"></p></div>
</div>
    <div class="row">
        {{-- Form Barcode --}}
        <div class="col-lg-6">
            <section>
                <div class="sub-title">
                    <h4>Package Details</h4>
                </div>
                
                {{-- Form Barcode: Begin --}}
                <form action="#" id="melt-barcode">
                    <div class="form-group row my-3">
                        <label for="barcode" class="col-sm-4 col-form-label">Generate Barcode ke-<span id="sequence"></span></label>
                        <div class="col-sm-2">
                            <select id="bc-karat" class="form-control">
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
                            <select id="bc-color" class='form-control'>
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
                        <label for="xxx" class='col-sm-4'>Original</label>
                        <div class="col-sm-2"><input type="text" class="form-control" name ="original-karat" id="original-karat" placeholder="karat"></div>
                        <div class="col-sm-2"><input type="text" class="form-control" name ="original-color" id="original-color" placeholder="color"></div>
                        <div class="col-sm-2"><input type="number" min="0" step="0.01" class="form-control text-end weights" name ="original-weight" id="original-weight" placeholder="weight" @required(true)></div>
                        <div class="col-sm-2"><input type="text" class="form-control" name ="original-remark" id="original-remark" placeholder="remark"></div>
                    </div>

                    <div class="form-group row my-3">
                        <label for="xxx" class='col-sm-4'>Alloy</label>
                        <div class="col-sm-2"><input type="text" class="form-control" name ="alloy-karat" id="alloy-karat" placeholder="karat"></div>
                        <div class="col-sm-2"><input type="text" class="form-control" name ="alloy-color" id="alloy-color" placeholder="color"></div>
                        <div class="col-sm-2"><input type="number" min="0" step="0.01" class="form-control text-end weights" name ="alloy-weight" id="alloy-weight" placeholder="weight" @required(true)></div>
                        <div class="col-sm-2"><input type="text" class="form-control" name ="alloy-remark" id="alloy-remark" placeholder="remark"></div>
                    </div>
                    
                    <div class="form-group row my-3">
                        <label for="xxx" class='col-sm-4'>Pohon</label>
                        <div class="col-sm-2"><input type="text" class="form-control" name ="pohon-karat" id="pohon-karat" placeholder="karat"></div>
                        <div class="col-sm-2"><input type="text" class="form-control" name ="pohon-color" id="pohon-color" placeholder="color"></div>
                        <div class="col-sm-2"><input type="number" min="0" step="0.01" class="form-control text-end weights" name ="pohon-weight" id="pohon-weight" placeholder="weight" @required(true)></div>
                        <div class="col-sm-2"><input type="text" class="form-control" name ="pohon-remark" id="pohon-remark" placeholder="remark"></div>
                    </div>
                    <div class="form-group row my-3">
                        <label for="xxx" class='col-sm-4'>Potongan</label>
                        <div class="col-sm-2"><input type="text" class="form-control" name ="potongan-karat" id="potongan-karat" placeholder="karat"></div>
                        <div class="col-sm-2"><input type="text" class="form-control" name ="potongan-color" id="potongan-color" placeholder="color"></div>
                        <div class="col-sm-2"><input type="number" min="0" step="0.01" class="form-control text-end weights" name ="potongan-weight" id="potongan-weight" placeholder="weight" @required(true)></div>
                        <div class="col-sm-2"><input type="text" class="form-control" name ="potongan-remark" id="potongan-remark" placeholder="remark"></div>
                    </div>
                    <div class="form-group row py-0 my-0">
                        <label for="xxx" class="col-sm-4">Total Weight</label>
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-2">
                            <input type="number" id="total-weight" class="form-control text-end" @readonly(true) @disabled(true) value="0.00">
                        </div>
                        <div class="col-sm-2">&nbsp;</div>
                    </div>
                    <div class="form-group row py-3 my-3"style="border-top:1px solid black;">
                        <label for="by_user" class="col-sm-4">Dibuat Oleh</label>
                        <div class="col-sm-4">
                            <input type="text" name="by_user" class="form-control" id="by_user">
                        </div>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary rounded form-control">Create</button>
                        </div>
                    </div>
                </form>
                {{-- Form Barcode:ended --}}
            </section>
        </div>
        {{-- Tabel Barcode --}}
        <div class="col-lg-6">
            <section class="mb-3">

                <div class="sub-title">
                    <h4>Packages Histories</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Barcode</th>
                                <th scope="col">Statused</th>
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

            </section>
            <section class="mb-3">

                <div class="sub-title">
                    <h4>Box Production</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Barcode</th>
                                <th scope="col">Statused</th>
                                <th scope="col">Initial Weight</th>
                                <th scope="col">Current Status</th>
                                <th scope="col">Final Weight</th>
                                <th scope="col" class='text-center'>Control</th>
                            </tr>
                        </thead>
                        <tbody id="box-tbody">
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

            </section>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col-lg-4 col-md-6 mx-auto">
            <section>
                <div class="sub-title">
                    <h4>Box Produced</h4>
                </div>
                {{-- Box Production Table --}}
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col" colspan="3" id="box-barcode" class='h4 text-center'>Barcode</th>
                            </tr>
                            <tr>
                                <th scope="col" widht="33%">Melt Weight</th>
                                <th scope="col" widht="33%">Box Weight</th>
                                <th scope="col" widht="33%">Granule Weight</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="col" class="text-end" id="box-melt">0.00</td>
                                <td scope="col" class="text-end" id="box-weight">0.00</td>
                                <td scope="col" class="text-end" id="box-granule">0.00</td>
                            </tr>
                        </tbody>
                    </table>
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
                            <tr>
                                <td>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input hybernated" @disabled(true) type="checkbox" id="requestEdit">
                                        <label class="form-check-label" for="requestEdit">Return Data</label>
                                    </div>
                                </td>
                                <td id="response_type">Received By</td>
                                <td><input type="text" class='form-control hybernated' @disabled(true) id="box-by-person"></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-around">
                        <button class="btn btn-success rounded" id="box-finish">Accepted</button>
                        <button class="btn btn-danger rounded" style="display:none" id="box-revised">Returned</button>
                    </div>
                </div>
                
            </section>
        </div>
    </div>
@endsection
@section('modals')
    {{-- Modals --}}
{{-- Modal Melt --}}
<div class="modal" tabindex="-1" id="melt-details">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Melting</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table table-sm">
            <thead>
                <tr class='bg-secondary'>
                    <th scope="col" class="bg-transparent text-light">Barcode</th>
                    <th scope="col" class="bg-transparent text-light" colspan="2">Created By</th>
                    <th scope="col" class="bg-transparent text-light" colspan="2">Created At</th>
                </tr>
                <tr>
                    <th id="mbc-barcode"></th> 
                    <th id="mbc-createdby" colspan="2">Suparlan</th>
                    <th id="mbc-createdat" colspan="2">2024-07-25 08:48:37</th>
                </tr>
            </thead>
            <tbody id="mbc-tbody"></tbody>
          </table>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col">
                    <input type="text" id="sendBy" class="form-control" placeholder="Send By">
                </div>
                <div class="col" id="mbc-control">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="sendToJujo" disabled>Send</button>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
{{-- Modal Melt --}}

{{-- Modal Edit Weight --}}
<div class="modal" tabindex="-1" id="melt-weights">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Melt Weights</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p class="h5">Bobot Timbang Ulang</p>
          <form action="#" id="melt-weights-form">
            <div class="form-group row mb-2">
                <label for="we-barcode" class="col-sm-6">Barcode</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="we-barcode" @readonly(true)>
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="we-original" class="col-sm-6">Original</label>
                <div class="col-sm-6">
                    <input type="number" min="0" step="0.01" class="form-control text-end" id="we-original">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="we-alloy" class="col-sm-6">Alloy</label>
                <div class="col-sm-6">
                    <input type="number" min="0" step="0.01" class="form-control text-end" id="we-alloy">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="we-pohon" class="col-sm-6">Pohon</label>
                <div class="col-sm-6">
                    <input type="number" min="0" step="0.01" class="form-control text-end" id="we-pohon">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="we-potongan" class="col-sm-6">Potongan</label>
                <div class="col-sm-6">
                    <input type="number" min="0" step="0.01" class="form-control text-end" id="we-potongan">
                </div>
            </div>
            <div class="form-group row mb-2">
                <label for="we-potongan" class="col-sm-6">Di edit oleh</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control text-end" id="we-by-person">
                </div>
            </div>
            <div class="form-group row mt-2">
                <div class="col-sm-6 ms-auto text-end">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
            <div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
      </div>
    </div>
  </div>
{{-- Modal Edit Weight--}}
{{-- Modals --}}
@endsection

@section('scripts')
    <script src="{{asset('js/shared.js')}}"></script>
    <script src="{{asset('js/melting.js')}}"></script>
@endsection
