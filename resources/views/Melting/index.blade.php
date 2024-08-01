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
                        <label for="by_user" class="col-sm-4">Dibuat Oleh</label>
                        <div class="col-sm-4">
                            <input type="text" name="by_user" class="form-control" id="by_user">
                        </div>
                        <div class="col-sm-4">
                            <button type="submit" class="btn btn-primary rounded form-control">Create</button>
                        </div>
                    </div>
                    
                </form>
            </section>
        </div>
        {{-- Tabel Barcode --}}
        <div class="col-lg-6">
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
        </div>
    </div>
    <div class="row">
        <div class="col">
            <section>
                <div class="sub-title">
                    <h4>Box Produced</h4>
                </div>
                <form action="#" id="melt-final">
                    <div class="row">
                        <div class="col">
                            <label for="box-barcode" class="form-label">Barcode</label>
                            <input type="text" class="form-control" id="box-barcode" @readonly(true)>
                        </div>
                        <div class="col">
                            <label for="box-weight" class="form-label">Final Weight</label>
                            <input type="number" min="0" step="0.01" class="form-control" id="box-weight">
                        </div>
                        <div class="col">
                            <label for="box-granule" class="form-label">Granule Weight</label>
                            <input type="number" min="0" step="0.01" class="form-control" id="box-granule" >
                        </div>
                        <div class="col">
                            <label for="box-by-person" class="form-label">Received By</label>
                            <input type="text" class="form-control" id="box-by-person" >
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col d-flex justify-content-center align-item-middle">
                            <button type="submit" class="btn btn-success" id="box-submit">Finish</button>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('js/shared.js')}}"></script>
    <script src="{{asset('js/melting.js')}}"></script>
@endsection
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
                <div class="col">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="sendToJujo" disabled>Send</button>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
{{-- Modal Melt --}}
{{-- Modals --}}