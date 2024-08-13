import "./bootstrap"; // Correctly importing the `bootstrap.js` file

import "https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js";


Echo.channel("chat").listen("NewMessage", (e) => {
    console.log(e.message);
    
    const messagesDiv = document.getElementById("chat-messages");
    messagesDiv.innerHTML += `<p>${e.message}</p>`;
});






    Echo.channel("Bidding").listen("NewBid", function (f) {
        console.log(f);
        const messagesDiv = $("#result");
        messagesDiv.append(`<p>${f.price}</p>`);
    });

