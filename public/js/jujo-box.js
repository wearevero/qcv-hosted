// Global Variables
WgoMlt=0;
WgoBox=0;
WgoGrn=0;
// Events
$(document).ready(function () {
    // Call Processed Melts
    socket.on('newMessage', (message) => {
        // do action based on message
        console.log('got message:',message.message);
        if(message.message == 'reload'){
            get_melts().then((data) => {
                showMeltData(data.received,"rcvd-tbody");
                showMeltData(data.proccesd,"prcd-tbody");
            })
        }
    });
    get_melts().then((data) => {
        showMeltData(data.received,"rcvd-tbody");
        showMeltData(data.proccesd,"prcd-tbody");
    })
})
$("#rcvd-tbody").on("click", ".melt-detail", function () {
    let id = $(this).data("id");
    melt_detail(id).then((data) => {
        let rcvd = {
            alloy:data.weighted[0].alloy,
            original:data.weighted[0].origin,
            pohon:data.weighted[0].pohon,
            potongan:data.weighted[0].potongan
        }
        console.log(data.main)
        showMeltDetail(data.main,rcvd)
    })
})
$("#prcd-tbody").on("click", ".melt-detail", function () {
    let id = $(this).data("id");
    melt_detail(id).then((data) => {
        let rcvd = {
            alloy:data.weighted[0].alloy,
            original:data.weighted[0].origin,
            pohon:data.weighted[0].pohon,
            potongan:data.weighted[0].potongan
        }
        reportMeltProduct(data.main,rcvd)
    })
})

$("#pickBy").on("keyup", function () {
    if($(this).val().length >= 3) {
        $("#getProccessed").attr("disabled", false);
    }
})
$("#getProccessed").on("click", function () {
    let barcode = $("#mbc-barcode").text();
    let by_person = $("#pickBy").val();
    let data = {
        barcode : barcode,
        by_person : by_person,
        status : 4
    }
    // console.log(data)
    getProccessed(data).then((data) => {
        // console.log(data)
        if(data.success == "ok"){
            tellTheServer();
            location.reload();
        }
    })
})

$("#send-box").on("submit", function (e) {
    e.preventDefault();
    let postData = {
        barcode : $("#box-barcode").val(),
        box_weight : $("#box-weight").val(),
        granule_weight: $("#granule-weight").val(),
        by_person : $("#by-person").val(),
        status : 5
    }
    // console.log(postData)
    sendBox(postData).then((data) => {
        // console.log(data)
        if(data.success == "ok"){
            tellTheServer();
            location.reload();
        }
    })
})
$("#box-weight").on('change', function () {
    getLossWeight();
})
$("#granule-weight").on('change', function () {
    let gw = $(this).val();
    let fgw = parseFloat(gw).toFixed(2)
    $("#box-granule").val(fgw)
    getLossWeight();
})
// Static Functions
function showMeltData(data,tbody) {
    $("#" + tbody + " tr").remove();
    let trbg,tdbg;
    data.forEach((melt)=>{
        if(melt.edited == "1" && melt.status == 3 ){
            trbg = 'bg-danger';
            tdbg = 'bg-transparent text-light';
        }else{
            trbg = 'bg-white';
            tdbg = 'bg-white';
        }
        button = showButton(melt.status,melt.barcode);
        $("#"+tbody).append(`
            <tr class="${trbg}">
                <td class="${tdbg}" scope="col">${melt.barcode}</td>
                <td class="${tdbg}" scope="col">${melt.created_at} by ${melt.by_person}</td>
                <td scope="col" class="${tdbg} text-end">${melt.initial_weight}</td>
                <td scope="col" class="${tdbg} text-center">${melt.status}</td>
                <td scope="col" class="${tdbg} text-end">${melt.final_weight}</td>
                <td scope="col" width="150px" class="${tdbg} text-center">
                    ${button}
                </td>
            </tr>
        `)
    })
}

function showButton(current_status,barcode) {
    if(current_status == 3){
        button =`<button class="btn btn-sm btn-success rounded melt-detail" data-id="${barcode}"><img src="${iconasset}/details.png" alt="detail" class="icon" /></button>`;
    }
    else if(current_status == 4) {
        button =`<button class="btn btn-sm btn-warning rounded melt-detail" data-id="${barcode}"><img src="${iconasset}/gold_bars.png" alt="smelting" class="icon" /></button>`;
    }
    else{
        button =`<button class="btn btn-sm btn-success rounded smelted" data-id="${barcode}"><img src="${iconasset}/gold_bars.png" alt="detail" class="icon" /></button>`
    }

    return button
}

function showMeltDetail(data,rcvd) {
    console.log(rcvd)
    $("#mbc-barcode").text(data.barcode);
    $("#mbc-createdby").text(data.by_person);
    $("#mbc-createdat").text(normaldate(data.created_at));
    $("#mbc-tbody tr").remove();
    
    $("#mbc-tbody").append(`
        <tr>
            <td>&nbsp;</td>
            <td scope="col">Alloy</td>            
            <td scope="col">Original</td>            
            <td scope="col">Pohon</td>            
            <td scope="col">Potongan</td>            
        </tr>
        <tr>
            <td scope="col">Karat</td>
            <td scope="col">${replacenull(data.alloy.karat)}</td>
            <td scope="col">${replacenull(data.original.karat)}</td>
            <td scope="col">${replacenull(data.pohon.karat)}</td>
            <td scope="col">${replacenull(data.potongan.karat)}</td>
        </tr>
        <tr>
            <td scope="col">Color</td>
            <td scope="col">${replacenull(data.alloy.color)}</td>
            <td scope="col">${replacenull(data.original.color)}</td>
            <td scope="col">${replacenull(data.pohon.color)}</td>
            <td scope="col">${replacenull(data.potongan.color)}</td>
        </tr>
        <tr>
            <td scope="col">Remark</td>
            <td scope="col">${replacenull(data.alloy.remark)}</td>
            <td scope="col">${replacenull(data.original.remark)}</td>
            <td scope="col">${replacenull(data.pohon.remark)}</td>
            <td scope="col">${replacenull(data.potongan.remark)}</td>
        </tr>
        <tr>
            <td scope="col">Weight On Created</td>
            <td scope="col" class="text-end">${wform(parseFloat(data.alloy.weight))}</td>
            <td scope="col" class="text-end">${wform(parseFloat(data.original.weight))}</td>
            <td scope="col" class="text-end">${wform(parseFloat(data.pohon.weight))}</td>
            <td scope="col" class="text-end">${wform(parseFloat(data.potongan.weight))}</td>
        </tr>
        <tr>
            <td scope="col">Weight On Received</td>
            <td scope="col" class="text-end">${wform(rcvd.alloy)}</td>
            <td scope="col" class="text-end">${wform(rcvd.original)}</td>
            <td scope="col" class="text-end">${wform(rcvd.pohon)}</td>
            <td scope="col" class="text-end">${wform(rcvd.potongan)}</td>
        </tr>
            <td scope="col">Total Weight</td>
            <td scope="col" class="text-center bg-warning">${wform(parseFloat(rcvd.alloy) + parseFloat(rcvd.original) + parseFloat(rcvd.pohon) + parseFloat(rcvd.potongan))}</td>
            <td scope="col" colspan="3">&nbsp;</td>
        <tr>
        </tr>
    `)

    $("#melt-details").modal('show');
}

function reportMeltProduct(data,rcvd) {
    
    $("#bc-barcode").text(data.barcode);
    $("#box-barcode").val(data.barcode);
    $("#bc-createdby").text(data.by_person);
    $("#bc-createdat").text(normaldate(data.created_at));
    // DAta Karat
    $("#alloy-karat").text(replacenull(data.alloy.karat));
    $("#original-karat").text(replacenull(data.original.karat));
    $("#pohon-karat").text(replacenull(data.pohon.karat));
    $("#potongan-karat").text(replacenull(data.potongan.karat));
    // Data Color
    $("#alloy-color").text(replacenull(data.alloy.color));
    $("#original-color").text(replacenull(data.original.color));
    $("#pohon-color").text(replacenull(data.pohon.color));
    $("#potongan-color").text(replacenull(data.potongan.color));
    // Data Remark
    $("#alloy-remark").text(replacenull(data.alloy.remark));
    $("#original-remark").text(replacenull(data.original.remark));
    $("#pohon-remark").text(replacenull(data.pohon.remark));
    $("#potongan-remark").text(replacenull(data.potongan.remark));
    // Data incoming weight
    $("#alloy-weight").text(wform(parseFloat(data.alloy.weight)));
    $("#original-weight").text(wform(parseFloat(data.original.weight)));
    $("#pohon-weight").text(wform(parseFloat(data.pohon.weight)));
    $("#potongan-weight").text(wform(parseFloat(data.potongan.weight)));
    let totalDataWeight = parseFloat(data.alloy.weight) + parseFloat(data.original.weight) + parseFloat(data.pohon.weight) + parseFloat(data.potongan.weight);
    $("#totalDataWeight").text(wform(totalDataWeight));
    // Data received weight
    $("#rcv-alloy-weight").text(wform(rcvd.alloy));
    $("#rcv-original-weight").text(wform(rcvd.original));
    $("#rcv-pohon-weight").text(wform(rcvd.pohon));
    $("#rcv-potongan-weight").text(wform(rcvd.potongan));
    let totalRcvdWeight = parseFloat(rcvd.alloy) + parseFloat(rcvd.original) + parseFloat(rcvd.pohon) + parseFloat(rcvd.potongan);
    let fBoxWeight = parseFloat(totalRcvdWeight).toFixed(2);
    $("#box-weight").val(fBoxWeight);
    WgoMlt = totalRcvdWeight;
    $("#totalRcvdWeight").text(wform(totalRcvdWeight));
    // Data diff
    $("#alloy-diff").text(wform(parseFloat(data.alloy.weight) - parseFloat(rcvd.alloy)));
    $("#original-diff").text(wform(parseFloat(data.original.weight) - parseFloat(rcvd.original)));
    $("#pohon-diff").text(wform(parseFloat(data.pohon.weight) - parseFloat(rcvd.pohon)));
    $("#potongan-diff").text(wform(parseFloat(data.potongan.weight) - parseFloat(rcvd.potongan)));

    let totalWeightReduced = parseFloat(totalDataWeight) - parseFloat(totalRcvdWeight);
    $("#total-weight-reduced").text(wform(totalWeightReduced));
}

function getLossWeight() {
    // let totalReceived = parseFloat($("#totalRcvdWeight").text());
    let totalReceived = WgoMlt;
    // console.log(totalReceived);
    let totalBoxWeight = parseFloat($("#box-weight").val());
    let granuleWeight = parseFloat($("#granule-weight").val());

    losscount(totalReceived, totalBoxWeight, granuleWeight);
}

// function replacenull(data){
//     return (data == null) ? "-" : data
// }
// function normaldate(date){
//     console.log(date);
//     segment = date.split("T");
//     datestr = segment[0];
//     timestr = segment[1].slice(0,8);
//     return `${datestr} ${timestr}`
// }

// API interaction Functions
async function get_melts() {
    const details = await $.ajax({
        type: "GET",
        url: "/api/melt_proccessed",
        dataType: "json"
    })
    return details
}

async function melt_detail(barcode) {
    const details = await $.ajax({
        type: "GET",
        url: `/api/melt_preproccess_detail/${barcode}`,
        dataType: "json"
    })
    return details
}

async function getProccessed(data){
    const response = await $.ajax({
        type: "POST",
        url: "/api/melt_get_proccessed",
        data: data,
        dataType: "json"
    })
    return response
}

async function sendBox(data){
    const response = await $.ajax({
        type: "POST",
        url: "/api/melt_send_box",
        data: data,
        dataType: "json"
    })
    return response
}