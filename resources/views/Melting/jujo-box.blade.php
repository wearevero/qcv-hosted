@extends('Templatez.index')
@section('content')
    <div class="row">
        {{-- Barcode Diproses --}}
        <div class="col-lg-6">
            <section>
                <div class="sub-title">
                    <h4>Received Melt Package</h4>
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
                        <tbody id="rcvd-tbody">
                        </tbody>
                    </table>
                </div>
            </section>
            <section>
                <div class="sub-title">
                    <h4>Processed Melt</h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Barcode</th>
                                <th scope="col">Proccessed</th>
                                <th scope="col">Initial Weight</th>
                                <th scope="col">Current Status</th>
                                <th scope="col">Final Weight</th>
                                <th scope="col" class='text-center'>Control</th>
                            </tr>
                        </thead>
                        <tbody id="prcd-tbody">
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
        {{-- Box  --}}
        <div class="col-lg-6">
            <section>
                <div class="sub-title">
                    <h4>Produced Melt Box</h4>
                </div>
                <div class="table-responsive">
                    <h5>Melt Information</h5>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th colspan="4" id="bc-barcode">-</th>
                            </tr>
                            <tr>
                                <th>Created By</th>
                                <th colspan="4" id="bc-createdby">-</th>
                            </tr>
                            <tr>
                                <th>Created At</th>
                                <th colspan="4" id="bc-createdat">-</th>
                            </tr>
                            <tr>
                                <td>Information</td>
                                <td>Alloy</td>
                                <td>Original</td>
                                <td>Pohon</td>
                                <td>Potongan</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Karat</td>
                                <td id="alloy-karat">-</td>
                                <td id="original-karat">-</td>
                                <td id="pohon-karat">-</td>
                                <td id="potongan-karat">-</td>
                            </tr>
                            <tr>
                                <td>Color</td>
                                <td id="alloy-color">-</td>
                                <td id="original-color">-</td>
                                <td id="pohon-color">-</td>
                                <td id="potongan-color">-</td>
                            </tr>
                            <tr>
                                <td>Remark</td>
                                <td id="alloy-remark">-</td>
                                <td id="original-remark">-</td>
                                <td id="pohon-remark">-</td>
                                <td id="potongan-remark">-</td>
                            </tr>
                            <tr>
                                <td class="pe-3">
                                    Weight on Created
                                    <span class="float-end" id="totalDataWeight"></span>
                                </td>
                                <td class="text-end" id="alloy-weight">-</td>
                                <td class="text-end" id="original-weight">-</td>
                                <td class="text-end" id="pohon-weight">-</td>
                                <td class="text-end" id="potongan-weight">-</td>
                            </tr>
                            <tr>
                                <td class="pe-3">
                                    Weight on Received
                                    <span class="float-end" id="totalRcvdWeight"></span>
                                </td>
                                <td class="text-end" id="rcv-alloy-weight">-</td>
                                <td class="text-end" id="rcv-original-weight">-</td>
                                <td class="text-end" id="rcv-pohon-weight">-</td>
                                <td class="text-end" id="rcv-potongan-weight">-</td>
                            </tr>
                            <tr>
                                <td>Weight Difference</td>
                                <td class="text-end" id="alloy-diff">-</td>
                                <td class="text-end" id="original-diff">-</td>
                                <td class="text-end" id="pohon-diff">-</td>
                                <td class="text-end" id="potongan-diff">-</td>
                            </tr>
                            <tr>
                                <td>Materal Weight Loss</td>
                                <td id="total-weight-reduced" class="text-end"></td>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
            <section class="row">
                <div class="col-lg-6 mx-auto">
                    <h5>Box Product Report</h5>
                    <div id="produced-box">
                        <form action="#" method="post" id="send-box">
                            <div class="form-group row mb-2">
                                <label for="box-barcode" class="col-sm-4 col-form-label">Barcode</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="box-barcode" id="box-barcode" readonly>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="box-weight" class="col-sm-4 col-form-label">Box Weight (gram)</label>
                                <div class="col-sm-8">
                                    <input type="number" value="0" step="0.01" class="form-control" name="box-weight" id="box-weight">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="granule-weight" class="col-sm-4 col-form-label">Granule Weight (gram)</label>
                                <div class="col-sm-8">
                                    <input type="number" value="0" step="0.01" class="form-control" name="granule-weight" id="granule-weight">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label for="by-person" class="col-sm-4 col-form-label">Send By</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="by-person" id="by-person">
                                </div>
                            </div>
                            <div class="form-group mt-2 text-end pe-3">
                                <button type="submit" class="btn btn-success rounded px-2 py-1">Send Box</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    var iconasset = "{{asset('icon')}}";
</script>
<script src="{{asset('js/shared.js')}}"></script>
<script src="{{asset('js/jujo-box.js')}}"></script>
@endsection

{{-- Modals --}}
{{-- Modal Melt --}}
<div class="modal" tabindex="-1" id="melt-details">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Package Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table table-sm">
            <thead>
                <tr class='bg-secondary'>
                    <th scope="col" class="bg-transparent text-light">Barcode</th>
                    <th id="mbc-barcode" colspan="4"></th> 
                </tr>
                <tr class='bg-secondary'>
                    <th scope="col" class="bg-transparent text-light">Created By</th>
                    <th id="mbc-createdby" colspan="4">Suparlan</th>
                </tr>
                <tr class='bg-secondary'>
                    <th scope="col" class="bg-transparent text-light">Created At</th>
                    <th id="mbc-createdat" colspan="4">2024-07-25 08:48:37</th>
                </tr>
            </thead>
            <tbody id="mbc-tbody"></tbody>
          </table>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col">
                    <input type="text" id="pickBy" class="form-control" placeholder="Proccessed By">
                </div>
                <div class="col">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="getProccessed" disabled>Proccess</button>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
{{-- Modal Melt --}}
{{-- Modals --}}