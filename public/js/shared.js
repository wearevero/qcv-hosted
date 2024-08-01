function wform(data){
    // let alloy = 1000;
    let formattedData = data.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    // console.log(formattedAlloy); // Output: "1,000.00"
    return formattedData;
}

function replacenull(data){
    return (data == null) ? "-" : data
}

function normaldate(date){
    console.log(date);
    segment = date.split("T");
    datestr = segment[0];
    timestr = segment[1].slice(0,8);
    return `${datestr} ${timestr}`
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