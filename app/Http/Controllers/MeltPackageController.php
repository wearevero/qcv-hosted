<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MeltPackage;
use App\Models\Melt_statuse;
use App\Models\Melt_weight;
use App\Models\HistoryStatus;
use Illuminate\Support\Facades\DB;

class MeltPackageController extends Controller
{
    // api handler
    public function melt_init(Request $request)
    {
        $initial_weight = $request->alloy['weight'] + $request->original['weight'] + $request->potongan['weight'] + $request->pohon['weight'];
        $data = [
            'barcode' => $request->barcode,
            'alloy' => json_encode($request->alloy),
            'original' => json_encode($request->original),
            'pohon' => json_encode($request->pohon),
            'potongan' => json_encode($request->potongan),
            'initial_weight' => $initial_weight,
            'final_weight' => 0,
            'granule_weight' => 0,
            'by_person' => $request->by_person
        ];


        // Create Melt Package Record
        $melt_init = MeltPackage::create($data);

        // Create Melt Status
        $data['status'] = '1';
        $melt_status = $this->init_status($data);
        $data['weights'] = [
            'alloy' => $request->alloy['weight'],
            'original' => $request->original['weight'],
            'pohon' => $request->pohon['weight'],
            'potongan' => $request->potongan['weight']
        ];
        $data['box_weight'] = 0;
        $data['granule_weight'] = 0;
        $melt_weight = $this->melt_weight($data);

        // Send to Jujo
        $meltData = [
            'barcode' => $request->barcode,
            'status' => 2,
            'by_person' => $request->by_person
        ];
        $send = Melt_statuse::create($meltData);

        if ($melt_init && $melt_status && $melt_weight && $send) {
            return response()->json([
                'success' => 'ok',
                'message' => 'Melt Package Saved. Melt Status Created',
            ]);
        } else {
            return response()->json([
                'success' => 'bad',
                'message' => 'Melt Package Unsuccessfully Saved. Melt Status Is Not Created',
            ]);
        }
        // return response()->json(['success' => true, 'data' => $request->all(), 'total_weight' => $initial_weight]);
    }

    public function melt_sequence()
    {
        $today = date('ymd');
        $result = MeltPackage::where('barcode', 'like', '%' . $today . '%')->count() + 1;
        return response()->json(['sequence' => $result]);
        // $melt = MeltPackage::where('barcode', 'like', '%' . $today . '%')->get();
    }

    private function init_status($data)
    {
        if (Melt_statuse::create($data)) {
            return 1;
        } else {
            return 0;
        }
    }

    private function melt_weight($data)
    {
        $weighting = [1, 3, 5, 6];
        if ($data['status'] == 1 || $data['status'] == 3) {
            $materials = [
                'barcode' => $data['barcode'],
                'on_status' => $data['status'],
                'alloy' => $data['weights']['alloy'],
                'origin' => $data['weights']['original'],
                'pohon' => $data['weights']['pohon'],
                'potongan' => $data['weights']['potongan'],
                'total_weight' => $data['weights']['alloy'] + $data['weights']['original'] + $data['weights']['pohon'] + $data['weights']['potongan'],
                'box_weight' => 0,
                'granule_weight' => 0,
                'by_person' => $data['by_person']
            ];
        } elseif ($data['status'] == 5 || $data['status'] == 6) {
            $materials = [
                'barcode' => $data['barcode'],
                'on_status' => $data['status'],
                'alloy' => 0,
                'origin' => 0,
                'pohon' => 0,
                'potongan' => 0,
                'total_weight' => 0,
                'box_weight' => $data['box_weight'],
                'granule_weight' => $data['granule_weight'],
                'by_person' => $data['by_person']
            ];
        } else {
            $materials = [
                'barcode' => $data['barcode'],
                'on_status' => $data['status'],
                'alloy' => 0,
                'origin' => 0,
                'pohon' => 0,
                'potongan' => 0,
                'total_weight' => 0,
                'box_weight' => 0,
                'granule_weight' => 0,
                'by_person' => 0
            ];
        }

        if (in_array($data['status'], $weighting)) {
            Melt_weight::create($materials);
        }
        return 1;
    }

    public function get_weight($object)
    {
        $obj = json_decode($object);
        return $obj->weight;
    }

    // MELT DETAILS
    // Barcode;Created;Initial Weight;Current Status;Final Weight
    function created_melt()
    {
        $subQuery = DB::table('melt_statuses as sub')
            ->select('sub.barcode', DB::raw('MAX(sub.status) as max_status'))
            ->join('melt_weights as mw', 'sub.barcode', '=', 'mw.barcode')
            ->where('sub.deleted_at', null)
            ->groupBy('sub.barcode');

        $details = DB::table('melt_statuses as main')
            ->joinSub($subQuery, 'max_table', function ($join) {
                $join->on('main.barcode', '=', 'max_table.barcode')
                    ->on('main.status', '=', 'max_table.max_status');
            })
            ->select('main.barcode', 'main.status', 'main.by_person', 'main.edited', 'pkg.initial_weight', 'pkg.final_weight', 'pkg.created_at', 'pkg.by_person as created_by')
            ->join('melt_packages as pkg', 'main.barcode', '=', 'pkg.barcode')
            ->where('main.status', '!=', 6)
            ->where('main.deleted_at', null)
            // ->where('main.recorded_at', 'like', '%' . date('Y-m-d') . '%')
            ->get();

        return response()->json($details);
    }

    public function melt_detail($barcode)
    {
        $melt = MeltPackage::where('barcode', $barcode)->first();
        $melt->original = json_decode($melt->original);
        $melt->alloy = json_decode($melt->alloy);
        $melt->potongan = json_decode($melt->potongan);
        $melt->pohon = json_decode($melt->pohon);
        return response()->json($melt);
    }

    public function melt_wg_edit(Request $request)
    {
        // delete old status where edited = 1 and status=2 and barcode=barcode;
        // Melt_statuse::where('barcode', $request->barcode)->where('status', '1')->where('edited', '1')->delete();
        $data = [
            'original' => $request->original,
            'alloy' => $request->alloy,
            'pohon' => $request->pohon,
            'potongan' => $request->potongan,
            'barcode' => $request->barcode,
            'status' => $request->status,
            'on_status' => '1',
            'by_person' => $request->by_person,
            'total_weight' => $request->alloy + $request->original + $request->pohon + $request->potongan,
        ];
        // update table melt_package
        $pgupdate = DB::table('melt_packages')
            ->where('barcode', $request->barcode)
            ->update([
                'original' => DB::raw("JSON_REPLACE(original, '$.weight', $request->original)"),
                'alloy' => DB::raw("JSON_REPLACE(alloy, '$.weight', $request->alloy)"),
                'pohon' => DB::raw("JSON_REPLACE(pohon, '$.weight', $request->pohon)"),
                'potongan' => DB::raw("JSON_REPLACE(potongan, '$.weight', $request->potongan)"),
                'initial_weight' => $data['total_weight']
            ]);

        // update table melt_weight
        $wgupdate = $this->weight_update($data);

        // update table melt_statuses
        $upstatus = $this->init_status($data);
        if ($pgupdate && $wgupdate && $upstatus) {
            return response()->json(['success' => 'ok', 'message' => "Weight updated"]);
        } else {
            return response()->json(['success' => 'bad', 'message' => "Weight does not updated"]);
        }
    }

    private function weight_update($data)
    {
        $wgupdate = Melt_weight::where('barcode', $data['barcode'])
            ->update([
                'origin' => $data['original'],
                'alloy' => $data['alloy'],
                'pohon' => $data['pohon'],
                'potongan' => $data['potongan'],
                'total_weight' => $data['total_weight'],
                'on_status' => $data['on_status'],
                'by_person' => $data['by_person']
            ]);
        return $wgupdate;
    }

    public function melt_information($barcode)
    {
        $info = MeltPackage::with(
            [
                'statuses' => function ($stt) {
                    $stt->select('barcode', 'status', 'by_person', 'recorded_at', 'hs.name as status_name')
                        ->join('history_statuses as hs', 'hs.id', '=', 'melt_statuses.status');
                }
            ]
        )
            ->with([
                'weights' => function ($wgt) {
                    $wgt->select('barcode', 'on_status', 'alloy', 'origin', 'pohon', 'potongan', 'total_weight', 'box_weight', 'granule_weight');
                }
            ])
            ->where('barcode', $barcode)->first();
        $info->alloy = json_decode($info->alloy);
        $info->original = json_decode($info->original);
        $info->potongan = json_decode($info->potongan);
        $info->pohon = json_decode($info->pohon);
        return response()->json($info);
    }

    public function melt_return(Request $request)
    {
        // update melt package where barcode = $request->barcode  set edited = 1
        // update melt
        $package = Melt_statuse::where('barcode', $request->barcode)
            ->where('status', $request->status)
            ->update([
                'edited' => 1
            ]);

        // delete melt status where barcode = $request->barcode && status = $request->status
        $status = Melt_statuse::where('barcode', $request->barcode)->where('status', ">", $request->status)->delete();
        if ($package && $status) {
            return response()->json(['success' => 'ok', 'message' => "Returned to Inventory"]);
        } else {
            return response()->json(['success' => 'bad', 'message' => "Rejection Failed"]);
        }
    }

    public function melt_sendtojujo(Request $request)
    {
        $meltData = [
            'barcode' => $request->barcode,
            'status' => 2,
            'by_person' => $request->by_person
        ];
        $response = Melt_statuse::create($meltData);
        if ($response) {
            return response()->json(['success' => 'ok', 'message' => "Status updated"]);
        } else {
            return response()->json(['success' => 'bad', 'message' => "Status does not updated"]);
        }
    }

    // function melt_sending()
    // {
    //     $barcodes = Melt_statuse::with(['melt_package' => function ($query) {
    //         $query->select('barcode', 'initial_weight', 'final_weight', 'created_at');
    //     }])
    //         ->where('status', 2)->get();
    //     return response()->json($barcodes);
    // }

    public function melt_receive()
    {
        $received = $this->melt_current_status(2);
        $proccesd = $this->melt_current_status(3);
        return response()->json(['received' => $received, 'proccesd' => $proccesd]);
    }

    public function melt_current_status($status, $barcode = "%")
    {
        $melts = DB::table('melt_current_status as mcs')
            ->select('mcs.barcode', 'mcs.status', 'ms.by_person', 'ms.recorded_at', 'ms.edited', 'pkg.initial_weight', 'pkg.final_weight', 'pkg.created_at')
            ->join('melt_statuses as ms', 'ms.barcode', '=', 'mcs.barcode')
            ->join('melt_packages as pkg', 'pkg.barcode', '=', 'ms.barcode')
            ->where('ms.status', $status)
            ->where('mcs.barcode', 'like', $barcode)
            ->where('mcs.status', $status)
            ->where('ms.deleted_at', null)->get();

        return $melts;
    }

    public function melt_process(Request $request)
    {
        // data preparation
        $data = [
            'barcode' => $request->barcode,
            'status' => $request->status,
            'by_person' => $request->by_person,
            'weights' => [
                'alloy' => $request->alloy,
                'original' => $request->original,
                'pohon' => $request->pohon,
                'potongan' => $request->potongan
            ],
            'box_weight' => 0,
            'granule_weight' => 0
        ];

        $processed = [
            'barcode' => $request->barcode,
            'by_person' => $request->by_person,
            'status' => 4
        ];

        $procesStatus = $this->init_status($processed);

        // Entry melt weight
        $weight = $this->melt_weight($data);

        // Entry melt status
        $status = $this->init_status($data);

        if ($weight && $status && $procesStatus) {
            return response()->json(['success' => 'ok', 'message' => "Status updated"]);
        } else {
            return response()->json(['success' => 'bad', 'message' => "Status does not updated"]);
        }
    }



    public function melt_reduce($barcode)
    {
        // SELECT barcode, alloy, origin, pohon, potongan, total_weight, box_weight, granule_weight, recorded_at, by_person FROM melt_weights WHERE barcode = 'MEL-240727-18KVWG.01';
        $weight = Melt_weight::where('barcode', $barcode)->get(['barcode', 'on_status', 'alloy', 'origin', 'pohon', 'potongan', 'total_weight', 'box_weight', 'granule_weight', 'recorded_at', 'by_person']);
        return response()->json($weight);
    }

    // Processing Melt to box
    public function melt_proccessed()
    {
        $received = $this->melt_current_status(3);
        $proccesd = $this->melt_current_status(4);
        return response()->json(['received' => $received, 'proccesd' => $proccesd]);
    }

    public function melt_preprocess_detail($barcode)
    {
        // main data of barcode
        $main_melt = MeltPackage::where('barcode', $barcode)->first();
        $main_melt->original = json_decode($main_melt->original);
        $main_melt->alloy = json_decode($main_melt->alloy);
        $main_melt->potongan = json_decode($main_melt->potongan);
        $main_melt->pohon = json_decode($main_melt->pohon);
        // melt weight on received
        $weighted_melt = Melt_weight::where('barcode', $barcode)
            ->where('on_status', 3)
            ->get();
        return response()->json(['main' => $main_melt, 'weighted' => $weighted_melt]);
    }

    public function getProccessed(Request $request)
    {
        $proccessedStatus = $this->init_status($request->all());
        if ($proccessedStatus) {
            return response()->json(['success' => 'ok', 'message' => "Status is now proccessed"]);
        } else {
            return response()->json(['success' => 'bad', 'message' => "Status does not updated"]);
        }
    }

    public function melt_send_box(Request $request)
    {
        // save status
        $meltData = [
            'barcode' => $request->barcode,
            'status' => $request->status,
            'by_person' => $request->by_person
        ];
        $statuse = Melt_statuse::create($meltData);

        // Update package set final_weight = $request->box_weight && granule_weight = $request->granule_weight
        $meltUpdate = MeltPackage::where('barcode', $request->barcode)->update([
            'final_weight' => $request->box_weight,
            'granule_weight' => $request->granule_weight
        ]);

        // save weights
        $weight = $this->melt_weight($request->all());

        if ($statuse && $weight && $meltUpdate) {
            return response()->json(['success' => 'ok', 'message' => "Box Ready to be sent. Status updated"]);
        } else {
            return response()->json(['success' => 'bad', 'message' => "Status does not updated"]);
        }
    }

    public function box_return(Request $request)
    {
        $box = Melt_weight::where('barcode', $request->barcode)
            ->where('on_status', $request->status)
            ->where('deleted_at', null)
            ->get();
        return response()->json($box);
    }

    public function melt_finish(Request $request)
    {
        // Update melt packege
        $meltUpdate = MeltPackage::where('barcode', $request->barcode)->update([
            'final_weight' => $request->box_weight,
            'granule_weight' => $request->granule_weight
        ]);

        // Save status
        $meltStatus = Melt_statuse::create([
            'barcode' => $request->barcode,
            'status' => $request->status,
            'by_person' => $request->by_person
        ]);

        // Save Weight
        $meltWeight = $this->melt_weight($request->all());

        if ($meltUpdate && $meltStatus && $meltWeight) {
            return response()->json(['success' => 'ok', 'message' => "Melting Process Finished. Status updated"]);
        } else {
            return response()->json(['success' => 'bad', 'message' => "Status does not updated"]);
        }
    }

    public function melt_edit_box(Request $request)
    {
        // update melt status where barcode = $request->barcode  set edited = 1
        $setEdit = Melt_statuse::where('barcode', $request->barcode)->where('status', $request->status)->update([
            'edited' => 1
        ]);

        // Delete melt weight where barcode = $request->barcode on status > 3
        $removeWeight = Melt_weight::where('barcode', $request->barcode)->where('on_status', '>', $request->status)->delete();


        // delete melt status where barcode = $request->barcode and status = $request->status
        $setStatus = Melt_statuse::where('barcode', $request->barcode)->where('status', '>', $request->status)->delete();
        if ($setEdit && $setStatus && $removeWeight) {
            return response()->json(['success' => 'ok', 'message' => "Returned to Jujo"]);
        } else {
            return response()->json(['success' => 'bad', 'message' => "Rejection Failed"]);
        }
    }

    public function bcstatuses()
    {
        $barcodes = DB::table('melt_current_status')->select("*")->get();
        return response()->json($barcodes);
    }

    public function dailyReport()
    {
        // bc example: MEL-241101-14KVRG.01
        $today = date('ymd');
        $result = MeltPackage::with(['weights'])
            ->where('barcode', 'like', '%' . $today . '%')->get();
        // return response()->json($result);

        $outputs = [];
        foreach ($result as $key => $value) {
            // dd($value->barcode);
            $bc = $this->extract_barcode($value->barcode);
            $seq = $bc['sequence'];
            $karat = $bc['karat'];
            $color = $bc['color'];
            $all = json_decode($value->alloy);
            $ori = json_decode($value->original);
            $poh = json_decode($value->pohon);
            $pot = json_decode($value->potongan);
            $loss = $value->weights[1]->total_weight - ($value->weights[3]->box_weight + $value->weights[3]->granule_weight);
            $outputs[$seq] = [
                'color' => $color,
                'metal' => $karat,
                'allo' => $all->weight,
                'orig' => $ori->weight,
                'poho' => $poh->weight,
                'poto' => $pot->weight,
                'in_jujo' => $value->weights[1]->total_weight,
                'out_jujo' => $value->weights[3]->box_weight,
                'granule' => $value->weights[3]->granule_weight,
                'loss' => $loss,
                '24k' => $this->K24K($karat) * $loss,
                'kadarkarat' => $this->K24K($karat),
                'remark' => "",
            ];
        }
        return $outputs;
        // return response()->json($outputs);
    }

    private function extract_barcode($barcode)
    {
        list($bc, $seq) = explode('.', $barcode);
        list($type, $date, $spec) = explode('-', $bc);
        $color = substr($spec, -2);
        $karat = substr($spec, 0, strlen($spec) - 2);
        return array('sequence' => $seq, 'type' => $type, 'date' => $date, 'karat' => $karat, 'color' => $color);
    }

    private function K24K($karat)
    {
        // =IF(J5="","",IF(B5="14K",J5*0.585,IF(B5="18K",J5*0.75,IF(B5="18KV",J5*0.751,IF(B5="9KV",J5*0.377,IF(B5="22K",J5*0.916,IF(B5="10K",J5*0.416,J5*0.587)))))))
        switch ($karat) {
            case '':
                return 0;
            case '14K':
                return 0.585;
            case '18K':
                return 0.75;
            case '18KV':
                return 0.751;
            case '9KV':
                return 0.377;
            case '22K':
                return 0.916;
            case '10K':
                return 0.416;
            default:
                return 0.587;
        }
    }
}
