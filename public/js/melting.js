var barcode="MEL"
var today = new Date();
var yr=( today.getFullYear() ).toString()
yr=yr.slice(-2)
var mt=(today.getMonth()+1).toString().padStart(2, '0')
var dt=today.getDate().toString().padStart(2, '0')
const sequence = 1;

// barcode format = MEL-231225-14KYG.1

$(document).ready(function () {
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
})
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
    let postData = {
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

    let initiate = melt_init(postData)
    .then((data) => {
        console.log(data);
        $("#qcv-notif").text(data.message);
        $(".qcv-notif").show();
        setTimeout(function () {
            location.reload();
        },3000);
    })
    
})

$("#melt-tbody").on("click", ".melt-detail", function () {
    let id = $(this).data("id");
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

$("#melt-tbody").on('click','.btn-final',function(){
    let postData = {
        barcode : $(this).data("barcode"),
        status : 5
    }
    meltreturn(postData)
    .then((data) => {
        // console.log(data);
        $("#box-barcode").val(data[0].barcode);
        $("#box-weight").val(data[0].box_weight);
        $("#box-granule").val(data[0].granule_weight);
    })
})


$("#melt-final").on('submit',function(e){
    e.preventDefault();
    let postData = {
        barcode: $("#box-barcode").val(),
        final_weight: $("#box-weight").val(),
        box_weight: $("#box-weight").val(),
        granule_weight: $("#box-granule").val(),
        by_person: $("#box-by-person").val(),
        status:6
    }
    meltfinish(postData)
    .then((data) => {
        // console.log(data);
        $("#qcv-notif").text(data.message);
        $(".qcv-notif").show();
        setTimeout(function () {
            window.location = "Melt/info/"+postData.barcode
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


function normaldate(date){
    segment = date.split("T");
    datestr = segment[0];
    timestr = segment[1].slice(0,8);
    return `${datestr} ${timestr}`
}

function showMeltData(data){
    $("#melt-tbody tr").remove();
    data.forEach((element) => {
        let buttons;
        if(element.status == "1"){
            buttons=`
                <button class="btn btn-sm btn-warning rounded"><img src="icon/edit.png" alt="edit" class="icon" /></button>
                <button class="btn btn-sm btn-danger rounded"><img src="icon/remove.png" alt="remove" class="icon" /></button>
            `;
        }else if(element.status == "5"){
            buttons=`<button class="btn btn-sm btn-warning rounded btn-final" data-barcode="${element.barcode}"><img src="icon/gold_bars.png" alt="edit" class="icon" /></button>`;
        }
        else{
            buttons=``;
        }

        let style="";
        if(element.edited == '1'){
            style="class='bg-warning'";
        }else{
            style="";
        }
        $("#melt-tbody").append(`
            <tr>
                <td ${style} scope="col">${element.barcode}</td>
                <td ${style} scope="col">${element.created_at} by ${element.by_person}</td>
                <td ${style} scope="col" class="text-end">${element.initial_weight}</td>
                <td ${style} scope="col" class="text-center">${element.status}</td>
                <td ${style} scope="col" class="text-end">${element.final_weight}</td>
                <td ${style} scope="col" width="150px">
                    <button class="btn btn-sm btn-success rounded melt-detail" data-id="${element.barcode}"><img src="icon/details.png" alt="detail" class="icon" /></button>
                    ${buttons}
                </td>
            </tr>
        `);
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