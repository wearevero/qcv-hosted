$(function(){
    const socket=io("10.10.10.10:3010");
    socket.on('newMessage', (data) => {
        console.log('newMessage',data.message)
        if(data.message == 'reload'){
            cekCurrentStatus();
        };
    });
})

async function cekCurrentStatus(){
    let url = `/api/bcstatuses`;
    getData(url).then((data) => {
        // console.log(data)
        updateDasboard(data)
    })
}

function updateDasboard(data){
    // console.log("updating dashboard");
    // console.log("data: " , data)
    $("#bc-tbody tr").remove();
    data.forEach(melt => {
        $("#bc-tbody").append(`
            <tr>
                <td>${melt.barcode}</td>
                <td>${melt.status}</td>
            </tr>    
        `);
    });
}