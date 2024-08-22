// page on init
var collected_barcodes =[];
var weightdatas ={};

$(document).ready(function () {
    // get sending melts
    // melts = get_melts().then((data) => {console.log(data) showMeltData(data)})
    // sending melts
    socket.on('newMessage', (message) => {
        // do action based on message
        console.log('got message:',message.message);
        if(message.message == 'reload'){
            meltreceive()
            .then((data) => {
                // console.log(data)
                showMeltData("melt-tbody",data.received)
                showMeltData("pmelt-tbody",data.proccesd)
            })
        }
    });
    meltreceive()
    .then((data) => {
        // console.log(data)
        showMeltData("melt-tbody",data.received)
        showMeltData("pmelt-tbody",data.proccesd)
    })
})

$("#melt-tbody").on("click", ".melt-detail", function () {
    let id = $(this).data("id");
    // console.log(id);
    let detail = melt_detail(id)
    .then((data) => {
        console.log(data)
        showMeltDetail(data)
    })
})

$("#pwh-barcodes").on("change", function () {
    let id = $(this).val();
    meltreduce(id)
    .then((data) => {
        console.log(data)
        showMeltWeight(data)
    })
    setTimeout(() => {
        console.log(weightdatas);        
    }, 3000);
})


$("#rcvButton").on('click', function () {
    // e.preventDefault();
    let postData = {
        barcode: $("#barcode").text(),
        alloy : $("#alloy-weight").text(),
        original : $("#original-weight").text(),
        pohon : $("#pohon-weight").text(),
        potongan : $("#potongan-weight").text(),
        by_person : $("#by_person").val(),
        status:'3'
    }
    processBarcode(postData)
    .then((response) => {
        $("#qcv-notif").text(response.message);
        $(".qcv-notif").show();
        setTimeout(function () {
            tellTheServer();
            location.reload();
        },3000);
    })
})

function returnData() {
    let data = {
        barcode : $("#barcode").text(),
        status :1
    }
    endpoint = `/api/melt-retur`;
    postData(endpoint,data)
    .then((data) => {
        $("#qcv-notif").text(data.message);
        $(".qcv-notif").show();
        setTimeout(function () {
            tellTheServer();
            location.reload();
        },3000);
    })
}
function showMeltData(tbody,mdata) {
    $("#"+tbody+" tr").remove();
        mdata.forEach((element) => {
            // collected_barcodes.push(element.barcode);
            $("#pwh-barcodes").append(`<option value="${element.barcode}">${element.barcode}</option>`)
            $("#"+tbody).append(`
                <tr>
                    <td scope="col">${element.barcode}</td>
                    <td scope="col">${element.recorded_at} by ${element.by_person}</td>
                    <td scope="col" class="text-end">${element.initial_weight}</td>
                    <td scope="col" class="text-center">${element.status}</td>
                    <td scope="col" class="text-end">${element.final_weight}</td>
                    <td scope="col" width="150px">
                        <button class="btn btn-sm btn-success rounded melt-detail" data-id="${element.barcode}">
                            <img src="icon/details.png" alt="detail" class="icon" />
                        </button>
                        <button class="btn btn-sm btn-warning rounded">
                            <img src="icon/edit.png" alt="detail" class="icon" />
                        </button>
                        <button class="btn btn-sm btn-danger rounded">
                            <img src="icon/remove.png" alt="detail" class="icon" />
                        </button>
                    </td>
                </tr>
            `);
        });
}

// REquest edit
$("#requestEdit").change(function () {
    if(this.checked){
        $("#respondedBy").text("Requested By");
        $("#rcvButton").hide();
        $("#rtrButton").show();
    }else{
        $("#respondedBy").text("Received By");
        $("#rcvButton").show();
        $("#rtrButton").hide();
    }
})
function showMeltDetail(data) {
    $("#barcode").text(data.barcode);
    // data alloy
    $("#alloy-karat").text(data.alloy.karat);
    $("#alloy-color").text(data.alloy.color);
    $("#alloy-weight").text(data.alloy.weight);
    $("#alloy-remark").text(data.alloy.remark);

    // data original
    $("#original-karat").text(data.original.karat);
    $("#original-color").text(data.original.color);
    $("#original-weight").text(data.original.weight);
    $("#original-remark").text(data.original.remark);

    // data pohon
    $("#pohon-karat").text(data.pohon.karat);
    $("#pohon-color").text(data.pohon.color);
    $("#pohon-weight").text(data.pohon.weight);
    $("#pohon-remark").text(data.pohon.remark);

    // data potongan
    $("#potongan-karat").text(data.potongan.karat);
    $("#potongan-color").text(data.potongan.color);
    $("#potongan-weight").text(data.potongan.weight);
    $("#potongan-remark").text(data.potongan.remark);

    let total_weight = parseFloat(data.alloy.weight) + parseFloat(data.original.weight) + parseFloat(data.pohon.weight) + parseFloat(data.potongan.weight);
    $("#total-weight").text(parseFloat(total_weight).toFixed(2));
    $("#total-weight").css("font-weight", "700");

    // enable input by_person and submit
    $("#process-barcode").attr("disabled", false);
    $("#by_person").attr("disabled", false);
    $("button[type=submit]").attr("disabled", false);
}

function showCollectedBarcodes(){
    for( let i = 0; i < collected_barcodes.length; i++){
        // console.log(collected_barcodes[i])
        $("#pwh-barcodes").append(`<option value="${collected_barcodes[i]}">${collected_barcodes[i]}</option>`)
    }
}

function showMeltWeight(data) {
    $("#pwh-tbody tr").remove();
    let rows = 0;
    data.forEach((melt) => {
        ++rows;
        weightdatas[melt.on_status] = {
            'alloy' : melt.alloy,
            'origin' : melt.origin,
            'pohon' : melt.pohon,
            'potongan' : melt.potongan,
            'total_weight' : melt.total_weight,
            'box_weight' : melt.box_weight,
            'granule_weight' : melt.granule_weight
        }

        $("#pwh-tbody").append(`
        <tr>
            <td scope="col" class="text-center">${melt.on_status}</td>
            <td scope="col" class="text-end">${wform(melt.alloy)}</td>
            <td scope="col" class="text-end">${wform(melt.origin)}</td>
            <td scope="col" class="text-end">${wform(melt.pohon)}</td>
            <td scope="col" class="text-end">${wform(melt.potongan)}</td>
            <td scope="col" class="text-end">${wform(melt.total_weight)}</td>
            <td scope="col" class="text-end">${wform(melt.box_weight)}</td>
            <td scope="col" class="text-end">${wform(melt.granule_weight)}</td>
            <td scope="col" class="text-center">${melt.recorded_at} <br/>by ${melt.by_person}</td>
        </tr>`);    
    })

    if (rows ==2) {
        console.log("hitung melt loss");
        loss_alloy=weightdatas[1].alloy-weightdatas[3].alloy;
        loss_origin=weightdatas[1].origin-weightdatas[3].origin;
        loss_pohon=weightdatas[1].pohon-weightdatas[3].pohon;
        loss_potongan=weightdatas[1].potongan-weightdatas[3].potongan;
        loss_total=weightdatas[1].total_weight-weightdatas[3].total_weight;
        $("#pwh-tbody").append(`
        <tr>
            <td scope="col" class="text-center">Loss</td>
            <td scope="col" class="text-end">${wform(loss_alloy)}</td>
            <td scope="col" class="text-end">${wform(loss_origin)}</td>
            <td scope="col" class="text-end">${wform(loss_pohon)}</td>
            <td scope="col" class="text-end">${wform(loss_potongan)}</td>
            <td scope="col" class="text-end">${wform(loss_total)}</td>
            <td scope="col" class="text-end"></td>
            <td scope="col" class="text-end"></td>
            <td scope="col" class="text-center"></td>
        </tr>
        `);
    }else if(rows == 4){
        console.log("hitung melt dan box loss");
    }
    // console.log(weightdatas)

}

// function wform(data){
//     // let alloy = 1000;
//     let formattedData = data.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
//     // console.log(formattedAlloy); // Output: "1,000.00"
//     return formattedData;
// }

async function get_melts() {
    const details = await $.ajax({
        type: "GET",
        url: "/api/melt-sending",
        dataType: "json"
    })
    return details
}

async function meltreceive() {
    const details = await $.ajax({
        type: "GET",
        url: `/api/melt-receive`,
        dataType: "json"
    })
    return details
}

async function melt_detail(barcode) {
    const details = await $.ajax({
        type: "GET",
        url: `/api/melt-details/${barcode}`,
        dataType: "json"
    })
    return details
}

async function processBarcode(data) {
    const process_result = await $.ajax({
        type: "POST",
        url: "/api/melt-process",
        data: data,
        dataType: "json"
    })
    return process_result
}

async function meltreduce(barcode) {
    const reduce_result = await $.ajax({
        type: "GET",
        url: `/api/melt-reduce/${barcode}`,
        dataType: "json"
    })
    return reduce_result
}

