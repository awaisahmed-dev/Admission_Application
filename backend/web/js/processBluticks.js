function formatWithOffset(date) {
			const tzo = -date.getTimezoneOffset();
			const dif = tzo >= 0 ? '+' : '-';
			const pad = (num) => (num < 10 ? '0' : '') + num;

			return date.getFullYear() +
				'-' + pad(date.getMonth() + 1) +
				'-' + pad(date.getDate()) +
				'T' + pad(date.getHours()) +
				':' + pad(date.getMinutes()) +
				':' + pad(date.getSeconds()) +
				dif + pad(Math.floor(Math.abs(tzo) / 60)) +
				':' + pad(Math.abs(tzo) % 60);
		}


function SendWAMessage(entry, due_time, apiKey){
	if(entry.phone.length > 7){
        
		var message_body = {
        apiKey: apiKey,
        to: entry.phone, 
        message: entry.fullMessage,
		dueDate: due_time,
		}
		console.log(message_body);

        fetch("https://api.blueticks.co/messages", {
    method: "POST", // Added missing comma here
    headers: { 
        "Content-Type": "application/json" 
    },
    body: JSON.stringify(message_body)
})
.then(response => response.json())
.then(data => console.log(data))
.catch(error => console.error('Error:', error));
	}
}

function processWAMessages(apiKey){

    var proceed = confirm("Please confirm Whatsapp web is running and Login with Blue ticks in browser. ");

    if (!proceed) {
       
        console.log("Action cancelled by user.");
        return;
    }

if(apiKey.length < 1) { alert('Please contact admin to enable WAM notifications');return;}
// 1. Retrieve history and Cleanup ONCE (outside the loop)
let historyLog = JSON.parse(localStorage.getItem('fee_noti_logs')) || [];
const thirtyDaysInMs = 30 * 24 * 60 * 60 * 1000;
const now = Date.now();

// Filter out items older than 30 days
historyLog = historyLog.filter(item => (now - item.timestamp) < thirtyDaysInMs);

var processCount = 0; var sentCount = 0; var duplicateCount = 0;
var nowTime = new Date();
var plus5 = new Date(nowTime.getTime() + 5 * 60000);
$.each($('.wamlink'), function (i, k) {
    // k is the element, use k.href to get the string
    var urlStr = $(k).attr('href'); 
    if(!urlStr) return; // Skip if no href

    var url = new URL(urlStr);
    var phoneNumber = url.pathname.replace('/', '');
    var fullText = url.searchParams.get("text");
    var today = new Date().toISOString().split('T')[0];

    // Extract Unique ID from the link inside the text
    // var uniqueKey = fullText.split('id%3D')[1] || fullText.split('id=')[1] || "no-id";
    var idMatch = fullText.match(/(?:id|parent_id)(?:%3D|=)(\d+)/);
    var uniqueKey = idMatch ? idMatch[1] : "no-id";

    var newEntry = {
        phone: phoneNumber,
        key: uniqueKey,
        fullMessage: fullText,
        dateSaved: today,
        timestamp: now // ADDED: needed for cleanup logic
    };

    // Verify Duplicate (Match BOTH date and unique key)
    var isDuplicate = historyLog.some(item => 
        item.dateSaved === newEntry.dateSaved && 
        item.key === newEntry.key // FIXED: was uniqueKey
    );

    if (!isDuplicate) {
		plus5 = new Date(plus5.getTime() + 5 * 60000);
		var plus5Time = formatWithOffset(plus5);
		SendWAMessage(newEntry, plus5Time, apiKey);
        historyLog.push(newEntry);
        console.log("✅ New entry added to list:", uniqueKey);
        sentCount++;
    } else {
        console.warn("⚠️ Duplicate blocked for ID:", uniqueKey);
        duplicateCount++;
    }

    processCount++;
});

// 2. Save the final updated list ONCE after the loop finishes
localStorage.setItem('fee_noti_logs', JSON.stringify(historyLog));
console.log("Final log count:", historyLog.length);
alert("Total Messages Processed: " + processCount+ ", Sent:"+ sentCount + ", Duplicates:" + duplicateCount);
}

