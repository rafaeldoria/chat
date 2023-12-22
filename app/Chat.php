<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
     <h3>welcome at chat</h3>
    <input id="name" placeholder="Type your name and press enter" size="40" />
    <input id="message" placeholder="Click here, then press enter to send your message." size="80" style="display:none"/>
    <p id="log"></p>
</body>
</html>

<script>
    const name = document.getElementById("name")
    const message = document.getElementById("message")
    const log = document.getElementById("log")
    var conn = new WebSocket('ws://localhost:8080')

    name.addEventListener("keyup", (e) => {
        if(e.code === 'Enter'){
            name.style.display = 'none'
            message.style.display = 'block'
        }
    })

    conn.onopen = (e) => {
        console.log("Connection established!")
    }

    conn.onmessage = (mensageReceive) => {
        let data = JSON.parse(mensageReceive.data);
        log.insertAdjacentHTML('beforeend', `${data.mensage} <br>`) 
    }

    message.addEventListener("keyup", (e) => {
        if(e.code === 'Enter'){
            let data = {
                mensage: name.value + ' : ' + message.value
            }
            conn.send(JSON.stringify(data))
            message.value = ""
            log.insertAdjacentHTML('beforeend', `${data.mensage} <br>`) 
        }
    });
</script>