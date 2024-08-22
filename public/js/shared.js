function wform(data){
    // let alloy = 1000;
    // let formattedData = data.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    let formattedData = data.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    // console.log(formattedAlloy); // Output: "1,000.00"
    return formattedData;
}

function replacenull(data){
    return (data == null) ? "-" : data
}

function normaldate(date){
    // console.log(date);
    segment = date.split("T");
    datestr = segment[0];
    timestr = segment[1].slice(0,8);
    return `${datestr} ${timestr}`
}

function losscount(totalReceive,BoxWeight,GranuleWeight) {
    let totalReceived = parseFloat(totalReceive);
    let totalBoxWeight = parseFloat(BoxWeight);
    let granuleWeight = parseFloat(GranuleWeight);
    let minLossGram = totalReceived - (totalBoxWeight + granuleWeight);
    let maxLossGram = totalReceived - totalBoxWeight;

    let minLossRate = (minLossGram / totalReceived) * 100;
    let maxLossRate = (maxLossGram / totalReceived) * 100;
    $("#minLossRate").text(minLossRate.toFixed(2));
    // $("#maxLossRate").text(maxLossRate.toFixed(2));
    $("#maxLossRate").text('-');
    $("#minLossGram").text(minLossGram.toFixed(2));
    // $("#maxLossGram").text(maxLossGram.toFixed(2));
    $("#maxLossGram").text('-');
}

function toFloat(string){
    let newFloat="";
    let str=string.split(",");
    newFloat = str.join("");
    console.log("new Number:",newFloat);
    return newFloat
} 
async function postData(endpoint,data){
    response = await  $.ajax({
        type: "POST",
        url: endpoint,
        data: data,
        dataType: "json"
    }) 
    return response;
}

async function getData(endpoint){
    response = await  $.ajax({
        type: "GET",
        url: endpoint,
        dataType: "json"
    }) 
    return response;
}

function tellTheServer() {
    // curl -X POST http://localhost:3000/gotmessage -H "Content-Type: application/json" -d '{"message": "Hello, world!"}'

    let message = "reload"
    url = 'http://10.10.10.10:3010/gotmessage';
    $.ajax({
        type: "POST",
        url: url,
        data: JSON.stringify({ message: message }),
        contentType: "application/json",
        success: function (data) {
            console.log(data);
        }
    })
}