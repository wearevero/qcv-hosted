$(document).ready(function () {
    let endpoint = `/api/melt-info/${barcode}`;
    getData(endpoint).then((data) => {
        // console.log(data)
        // Material Information
        $("#melt-material thead").remove();
        $("#melt-material tbody").remove();
        $("#melt-material").append(`
            <thead>
                <tr>
                    <th scope="col">&nbsp;</th>
                    <th scope="col">Alloy</th>
                    <th scope="col">Origin</th>
                    <th scope="col">Pohon</th>
                    <th scope="col">Potongan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td scope="col">Color</td>
                    <td scope="col">${data.alloy.color}</td>
                    <td scope="col">${data.original.color}</td>
                    <td scope="col">${data.pohon.color}</td>
                    <td scope="col">${data.potongan.color}</td>
                </tr>
                <tr>
                    <td scope="col">Karat</td>
                    <td scope="col">${data.alloy.karat}</td>
                    <td scope="col">${data.original.karat}</td>
                    <td scope="col">${data.pohon.karat}</td>
                    <td scope="col">${data.potongan.karat}</td>
                </tr>
                <tr>
                    <td scope="col">Remark</td>
                    <td scope="col">${data.alloy.remark}</td>
                    <td scope="col">${data.original.remark}</td>
                    <td scope="col">${data.pohon.remark}</td>
                    <td scope="col">${data.potongan.remark}</td>
                </tr>
            </tbody>
        `)

        // Status information
        $("#melt-histories tr").remove();
        data.statuses.forEach(status => {
            $("#melt-histories").append(`
                <tr>
                    <td scope="col">${status.status}</td>
                    <td scope="col">${status.status_name}</td>
                    <td scope="col">${status.by_person}</td>
                    <td scope="col">${status.recorded_at}</td>
                </tr>
            `)
        })

        // Weight information
        $("#melt-weights tr").remove();
        // var wd =[];
        var wdt={}
        data.weights.forEach(weight => {
            wdt[weight.on_status] = {
                'alloy':weight.alloy,
                'origin':weight.origin,
                'pohon':weight.pohon,
                'potongan':weight.potongan,
                'total_weight':weight.total_weight,
                'box_weight':weight.box_weight,
                'granule_weight':weight.granule_weight
            }
            // wd.push(wdt)
            $("#melt-weights").append(`
                <tr>
                    <td scope="col">${weight.on_status}</td>
                    <td scope="col" class='text-end'>${wform(weight.alloy)}</td>
                    <td scope="col" class='text-end'>${wform(weight.origin)}</td>
                    <td scope="col" class='text-end'>${wform(weight.pohon)}</td>
                    <td scope="col" class='text-end'>${wform(weight.potongan)}</td>
                    <td scope="col" class='text-end'>${wform(weight.total_weight)}</td>
                    <td scope="col" class='text-end'>${wform(weight.box_weight)}</td>
                    <td scope="col" class='text-end'>${wform(weight.granule_weight)}</td>
                </tr>
            `)
        })
        // console.log("weight diff:",wdt);
        alloy_diff = wdt[1]['alloy'] - wdt[3]['alloy'];
        original_diff = wdt[1]['origin'] - wdt[3]['origin'];
        pohon_diff = wdt[1]['pohon'] - wdt[3]['pohon'];
        potongan_diff = wdt[1]['potongan'] - wdt[3]['potongan'];
        total_diff = wdt[1]['total_weight'] - wdt[3]['total_weight'];
        box_diff = wdt[5]['box_weight'] - wdt[6]['box_weight'];
        granule_diff = wdt[5]['granule_weight'] - wdt[6]['granule_weight'];
        // console.log(alloy_diff,original_diff,pohon_diff,potongan_diff,total_diff,box_diff,granule_diff)
        $("#melt-weights").append(`
            <tr>
                <td scope="col">Difference</td>
                <td scope="col" class='text-end'>${wform(alloy_diff)}</td>
                <td scope="col" class='text-end'>${wform(original_diff)}</td>
                <td scope="col" class='text-end'>${wform(pohon_diff)}</td>
                <td scope="col" class='text-end'>${wform(potongan_diff)}</td>
                <td scope="col" class='text-end'>${wform(total_diff)}</td>
                <td scope="col" class='text-end'>${wform(box_diff)}</td>
                <td scope="col" class='text-end'>${wform(granule_diff)}</td>
            </tr>
        `);
    })
})