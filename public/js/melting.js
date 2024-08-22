var barcode="MEL"
var today = new Date();
var yr=( today.getFullYear() ).toString()
yr=yr.slice(-2)
var mt=(today.getMonth()+1).toString().padStart(2, '0')
var dt=today.getDate().toString().padStart(2, '0')
const sequence = 1;
WgoMlt=0;
WgoBox=0;
WgoGrn=0;
// barcode format = MEL-231225-14KYG.1

$(document).ready(function () {
    // configure socket
    // let socket = socketConfig();
    socket.on('newMessage', (message) => {
        // do action based on message
        console.log('got message:',message.message);
        if(message.message == 'reload'){
            // location.reload();
            docInit();
        } 
    }); 
    docInit();
})

function docInit(){
    // get melting sequence of the day
    get_sequence()
    .then((data) => {
        console.log("urut:",data);
        let karut = data.toString().padStart(2, '0');
        $("#sequence").text(karut);
    });

    // get created melting barcode
    created_melt()
    .then((data) => {
        console.log("created:",data);
        showMeltData(data);
    })
}
const strtime=`${yr}${mt}${dt}`;
$("#bc-karat").on("change", function () {
    let kar = $(this).val();
    let col = (($("#bc-color").val() == "" )|| $("#bc-color").val() ==null) ? "XX" : $("#bc-color").val();
    let sqe = $("#sequence").text();
    barcode = `MEL-${strtime}-${kar}${col}.${sqe}`;
    $("#barcode").val(barcode);
    $("#original-karat").val(kar);
    $("#pohon-karat").val(kar);
    $("#potongan-karat").val(kar);
    
})

$("#bc-color").on("change", function () {
    let kar = ($("#bc-karat").val() == "" || $("#bc-karat").val() == null) ? "00" : $("#bc-karat").val();
    let col = $(this).val();
    let sqe = $("#sequence").text();
    barcode = `MEL-${strtime}-${kar}${col}.${sqe}`;
    $("#barcode").val(barcode);
    $("#alloy-color").val(col);
    $("#original-color").val(col);
    $("#pohon-color").val(col);
    $("#potongan-color").val(col);
})

$("form#melt-barcode").on("submit", function (e) {
    e.preventDefault();
    let payload = {
        barcode: $("#barcode").val(),
        original :{
            karat : $("#original-karat").val(),
            color : $("#original-color").val(),
            weight : $("#original-weight").val(),
            remark : $("#original-remark").val()
        },
        alloy :{
            karat : $("#alloy-karat").val(),
            color : $("#alloy-color").val(),
            weight : $("#alloy-weight").val(),
            remark : $("#alloy-remark").val()
        },
        potongan :{
            karat : $("#potongan-karat").val(),
            color : $("#potongan-color").val(),
            weight : $("#potongan-weight").val(),
            remark : $("#potongan-remark").val()
        },
        pohon :{
            karat : $("#pohon-karat").val(),
            color : $("#pohon-color").val(),
            weight : $("#pohon-weight").val(),
            remark : $("#pohon-remark").val()
        },
        by_person : $("#by_user").val(),
        status:'1'
    }

    melt_init(payload)
    .then((data) => {
        console.log(data);
        $("#qcv-notif").text(data.message);
        $(".qcv-notif").show();
        tellTheServer();
        setTimeout(function () {
            location.reload();
            // $(".qcv-notif").hide();
            // $("#qcv-notif").text("");
            // docInit();
        },1000);
    })
    
})

$("#melt-tbody").on("click", ".melt-detail", function () {
    let id = $(this).data("id");
    let status = $(this).data("status");
    if( parseInt(status) > 1){
        $("#sendBy").attr('disabled',true);
        $("#mbc-control").hide();
    }
    // console.log(id);
    let detail=melt_detail(id)
    .then((data) => {
        console.log(data.barcode)
        $("#mbc-barcode").text(data.barcode);
        $("#mbc-createdby").text(data.by_person);
        $("#mbc-createdat").text(normaldate(data.created_at));
        let totalWeight = parseFloat(data.alloy.weight) + parseFloat(data.original.weight) + parseFloat(data.pohon.weight) + parseFloat(data.potongan.weight);
        $("#mbc-tbody tr").remove();
        $("#mbc-tbody").append(`
            <tr class="bg-secondary">
                <th scope="col" class="bg-transparent text-light">Material</th>
                <th scope="col" class="bg-transparent text-light">Karat</th>
                <th scope="col" class="bg-transparent text-light">Color</th>
                <th scope="col" class="bg-transparent text-light">Weight</th>
                <th scope="col" class="bg-transparent text-light">Remark</th>
            </tr>
            <tr>
                <td scope="col">Alloy</td>
                <td scope="col">${replacenull(data.alloy.karat)}</td>
                <td scope="col">${replacenull(data.alloy.color)}</td>
                <td scope="col" class="text-end">${replacenull(data.alloy.weight)}</td>
                <td scope="col">${replacenull(data.alloy.remark)}</td>
            </tr>
            <tr>
                <td scope="col">Original</td>
                <td scope="col">${replacenull(data.original.karat)}</td>
                <td scope="col">${replacenull(data.original.color)}</td>
                <td scope="col" class="text-end">${replacenull(data.original.weight)}</td>
                <td scope="col">${replacenull(data.original.remark)}</td>
            </tr>
            <tr>
                <td scope="col">Pohon</td>
                <td scope="col">${replacenull(data.pohon.karat)}</td>
                <td scope="col">${replacenull(data.pohon.color)}</td>
                <td scope="col" class="text-end">${replacenull(data.pohon.weight)}</td>
                <td scope="col">${replacenull(data.pohon.remark)}</td>
            </tr>
            <tr>
                <td scope="col">Potongan</td>
                <td scope="col">${replacenull(data.potongan.karat)}</td>
                <td scope="col">${replacenull(data.potongan.color)}</td>
                <td scope="col" class="text-end">${replacenull(data.potongan.weight)}</td>
                <td scope="col">${replacenull(data.potongan.remark)}</td>
            </tr>
            <tr>
                <td scope="col" colspan="3">Total Weight</td>
                <td scope="col" class="text-end bg-warning">${parseFloat(totalWeight).toFixed(2)}</td>
                <td scope="col">&nbsp;</td>
            </tr>
        `)        
        $("#melt-details").modal("show");
    })
})

$("#sendBy").keyup(function(){
    let nama = $(this).val();
    if(nama.length >= 3){
        $("#sendToJujo").attr("disabled", false);
    }
})

$("#sendToJujo").click(function(){
    // $("#sendToJujo").prop("disabled", true);
    let postData = {
        barcode : $("#mbc-barcode").text(),
        by_person : $("#sendBy").val()
    }
    response = sendToJujo(postData)
    .then((data) => {
        $("#qcv-notif").text(data.message);
        $(".qcv-notif").show();
        setTimeout(function () {
            location.reload();
        },3000);
    })
})

$("#box-tbody").on('click','.btn-final',function(){
    let iw = $(this).parent('td').parent('tr').find('td:eq(2)').text();
    fiw=toFloat(iw);
    let postData = {
        barcode : $(this).data("barcode"),
        status : 5
    }
    meltreturn(postData)
    .then((data) => {
        // console.log(data);
        $("#box-barcode").text(data[0].barcode);
        $("#box-melt").text(fiw);
        $("#box-weight").text(wform(data[0].box_weight));
        $("#box-granule").text(wform(data[0].granule_weight));
        console.log(fiw,parseFloat(data[0].box_weight),parseFloat(data[0].granule_weight));
        losscount(fiw,parseFloat(data[0].box_weight),parseFloat(data[0].granule_weight));
        $(".hybernated").attr('disabled',false);
    })
})


$("#box-finish").on('click',function(){
    let boxData = {
        barcode: $("#box-barcode").text(),
        // final_weight: $("#box-melt").text(),
        box_weight: $("#box-weight").text(),
        granule_weight: $("#box-granule").text(),
        by_person: $("#box-by-person").val(),
        status:6
    }
    let url = `/api/melt-finish`;
    postData(url,boxData)
    .then((data) => {
        // console.log(data);
        $("#qcv-notif").text(data.message);
        $(".qcv-notif").show();
        setTimeout(function () {
            window.location = "Melt/info/"+boxData.barcode
        },3000);
    })
})

$("#requestEdit").change(function () {
    if(this.checked){
        $("#box-finish").hide();
        $("#box-revised").show();
    }else{
        $("#box-finish").show();
        $("#box-revised").hide();
    }
})

$("#box-revised").click(function(){
    let url = 'api/melt_edit_box';
    let postDatas = {
        barcode: $("#box-barcode").text(),
        status: 3
    }
    postData(url,postDatas)
    .then((data) => {
        // console.log(data);
        $("#qcv-notif").text(data.message);
        $(".qcv-notif").show();
        setTimeout(function () {
            tellTheServer();
            location.reload();
        },3000);
    })
})
// function replacenull(data){
//     return (data == null) ? "-" : data
// }

$(".weights").keyup( function(){
    tw = totalWeight();
    console.log("Total Weight:",tw);
    $("#total-weight").val(parseFloat(tw).toFixed(2))
})

// Trigger edit melt weight
$("#melt-tbody").on('click','.melt-edit',function(){
    let id = $(this).data("id");
    melt_detail(id)
    .then((data) => {
        console.log(data);
        $("#we-barcode").val(data.barcode);
        $("#we-original").val(data.original.weight);
        $("#we-alloy").val(data.alloy.weight);
        $("#we-pohon").val(data.pohon.weight);
        $("#we-potongan").val(data.potongan.weight);
        $("#melt-weights").modal('show');
    })
});

$("#box-tbody").on('click','.melt-detail',function(){
    let barcode = $(this).data("id");
    window.location='Melt/info/'+barcode;
});

$("#melt-weights-form").on('submit',function(e){
    e.preventDefault();
    let meltdata = {
        barcode : $("#we-barcode").val(),
        original : $("#we-original").val(),
        alloy : $("#we-alloy").val(),
        pohon : $("#we-pohon").val(),
        potongan : $("#we-potongan").val(),
        by_person: $("#we-by-person").val(),
        status: '2'
    }
    postData(`/api/melt-edit`,meltdata)
    .then((data) => {
        $("#qcv-notif").text(data.message);
        $(".qcv-notif").show();
        setTimeout(function () {
            tellTheServer();
            location.reload();
        },3000);
    })
})

function normaldate(date){
    segment = date.split("T");
    datestr = segment[0];
    timestr = segment[1].slice(0,8);
    return `${datestr} ${timestr}`
}

function showMeltData(data){
    $("#melt-tbody tr").remove();
    $("#box-tbody tr").remove();
    data.forEach((element) => {
        let buttons;
        if(element.status == "1" && element.edited == '0'){
            buttons=`
                <button class="btn btn-sm btn-success rounded melt-detail" data-id="${element.barcode}"><img src="icon/details.png" alt="detail" class="icon" /></button>
                <button class="btn btn-sm btn-warning rounded"><img src="icon/edit.png" alt="edit" class="icon" /></button>
                <button class="btn btn-sm btn-danger rounded"><img src="icon/remove.png" alt="remove" class="icon" /></button>
            `;
        }else if(element.status == '1' && element.edited == '1'){
            buttons=`
                <button class="btn btn-sm btn-warning rounded melt-edit" data-id="${element.barcode}"><img src="icon/edit.png" alt="edit" class="icon" /></button>
                <button class="btn btn-sm btn-dark rounded"><img src="icon/remove.png" alt="remove" class="icon" /></button>
            `;
        }else if(element.status == "5"){
            buttons=`<button class="btn btn-sm btn-warning rounded btn-final" data-barcode="${element.barcode}"><img src="icon/gold_bars.png" alt="edit" class="icon" /></button>`;
        }
        else{
            buttons=`
                <button class="btn btn-sm btn-primary rounded melt-detail" data-id="${element.barcode}" data-status="${element.status}"><img src="icon/histories.png" alt="detail" class="icon" /></button>
                <button class="btn btn-sm btn-warning rounded invisible"><img src="icon/edit.png" alt="edit" class="icon invisible"/></button>
                <button class="btn btn-sm btn-danger rounded invisible"><img src="icon/remove.png" alt="remove" class="icon invisible" /></button>
            `;
        }

        let bg="";
        if(element.edited == '1' && element.status == '1'){
            bg="bg-bahaja";
        }else{
            bg="";
        }
        if(parseInt(element.status) < 5 ){

            $("#melt-tbody").append(`
                <tr>
                    <td scope="col" class="${bg}">${element.barcode}</td>
                    <td scope="col" class="${bg}">${element.created_at} by ${element.by_person}</td>
                    <td scope="col" class="${bg} text-end">${wform(parseFloat(element.initial_weight))}</td>
                    <td scope="col" class="${bg} text-center">${element.status}</td>
                    <td scope="col" class="${bg} text-end">${element.final_weight}</td>
                    <td scope="col" width="150px" class="${bg} text-end">
                        ${buttons}
                    </td>
                </tr>
            `);
            
        }else{
            $("#box-tbody").append(`
                <tr>
                    <td scope="col" class="${bg}">${element.barcode}</td>
                    <td scope="col" class="${bg}">${element.created_at} by ${element.by_person}</td>
                    <td scope="col" class="${bg} text-end">${wform(parseFloat(element.initial_weight))}</td>
                    <td scope="col" class="${bg} text-center">${element.status}</td>
                    <td scope="col" class="${bg} text-end">${element.final_weight}</td>
                    <td scope="col" width="150px" class="${bg} text-end">
                        ${buttons}
                    </td>
                </tr>
            `);

        }
    });
}

function totalWeight(){
    let al,or,ph,pt;
    let alw = $("#alloy-weight").val();
    let orw = $("#original-weight").val();
    let ptw = $("#potongan-weight").val();
    let phw = $("#pohon-weight").val();
    al = alw == "" ? 0 : parseFloat(alw);
    or = orw == "" ? 0 : parseFloat(orw);
    ph = phw == "" ? 0 : parseFloat(phw);
    pt = ptw == "" ? 0 : parseFloat(ptw);

    return (al+or+ph+pt);
}

async function melt_init(data){
    const init_result = await $.ajax({
        type: "POST",
        url: "/api/melt-init",
        data: data,
        dataType: "json"
    })
    return init_result;
}

async function get_sequence(){
    const sequence = await $.ajax({
        type: "GET",
        url: "/api/melt-sequence",
        dataType: "json"
    });
    // console.log(sequence.sequence);
    return sequence.sequence;
}

async function created_melt(){
    const details = await $.ajax({
        type: "GET",
        url: "/api/melt-created",
        dataType: "json"
    });
    return details;
}

async function melt_detail(barcode){    
    const details = await $.ajax({
        type: "GET",
        url: `/api/melt-details/${barcode}`,
        dataType: "json"
    });
    return details;
}

async function sendToJujo(data){
    const send_result = await $.ajax({
        type: "POST",
        url: "/api/melt-send",
        data: data,
        dataType: "json"
    })
    return send_result;
}

async function meltreturn(data){
    const details = await $.ajax({
        type: "POST",
        url: `/api/melt-return`,
        data: data,
        dataType: "json"
    })
    return details
}

async function meltfinish(data){
    const details = await $.ajax({
        type: "POST",
        url: `/api/melt-finish`,
        data: data,
        dataType: "json"
    })
    return details
}

// function tellTheServer() {
//     // curl -X POST http://localhost:3000/gotmessage -H "Content-Type: application/json" -d '{"message": "Hello, world!"}'

//     let message = "reload"
//     url = 'http://10.10.10.10:3010/gotmessage';
//     $.ajax({
//         type: "POST",
//         url: url,
//         data: JSON.stringify({ message: message }),
//         contentType: "application/json",
//         success: function (data) {
//             console.log(data);
//         }
//     })
// }