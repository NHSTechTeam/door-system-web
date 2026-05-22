messageBox = document.getElementById("message");
statusMessage = document.getElementById("status-message");
originalMessage = messageBox.innerText;

//make sure we are actually getting these passed through
//console.log(mqtt_url);
//console.log(mqtt_username);
//console.log(mqtt_password);


//WARNING: These variable should be set in index.php and should not be written here or there. They are loaded from env vars in docker
const client = mqtt.connect(mqtt_url)//, {username: mqtt_username, password: mqtt_password});

client.on("connect", () => {
  console.log("connected");
  client.subscribe("door/kiosk", (err) => {
    console.log("subscribed");
    if (!err) {
      client.publish("presence", "Hello mqtt");
    }
  });
  statusMessage.hidden = true;
});

function errorMessage() {
  statusMessage.hidden = false;
}

client.on("reconnect", errorMessage);
client.on("offline", errorMessage);
client.on("close", errorMessage);
client.on("error", errorMessage);

client.on("message", (topic, message) => {
    if(topic == "door/kiosk"){
        const msg = JSON.parse(message.toString());
        console.log(msg);
        colorStyle = msg.success ? "text-success" : "text-danger"
        messageBox.classList.add(colorStyle);
        messageBox.innerText = msg.message;
        setTimeout(() => {
            messageBox.classList.remove(colorStyle);
            messageBox.innerText = originalMessage;
        }, 5000);
        
    }   
});