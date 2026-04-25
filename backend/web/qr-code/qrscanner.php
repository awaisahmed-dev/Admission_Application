<?php

use yii\helpers\Html;?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>QR Scanner</title>
<script src="https://unpkg.com/html5-qrcode"></script>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    min-height: 100vh;
    padding: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.container {
    max-width: 800px;
    width: 100%;
    margin: 0 auto;
}

.card {
    background: white;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    overflow: hidden;
}

.header {
    text-align: center;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eaeaea;
}

.header h3 {
    color: #2c3e50;
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 8px;
    background: linear-gradient(to right, #2575fc, #6a11cb);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.header p {
    color: #7f8c8d;
    font-size: 15px;
}

.controls-section {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
}

.select-container {
    margin-bottom: 15px;
}

.select-container label {
    display: block;
    margin-bottom: 8px;
    color: #2c3e50;
    font-weight: 600;
    font-size: 14px;
}

select, input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    font-size: 15px;
    transition: all 0.3s ease;
    background-color: white;
}

select:focus, input:focus {
    outline: none;
    border-color: #6a11cb;
    box-shadow: 0 0 0 3px rgba(106, 17, 203, 0.1);
}

#feeAmount {
    margin-top: 10px;
}

.scanner-section {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
    text-align: center;
}

.scanner-section h4 {
    color: #2c3e50;
    margin-bottom: 15px;
    font-size: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.scanner-section h4::before {
    content: "📷";
    font-size: 20px;
}

#reader {
    margin: 15px auto;
    border-radius: 8px;
    overflow: hidden;
    max-width: 500px;
}

.data-section {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 25px;
}

.data-section h4 {
    color: #2c3e50;
    margin-bottom: 15px;
    font-size: 18px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.data-section h4::before {
    content: "📋";
    font-size: 20px;
}

.table-container {
    overflow-x: auto;
    border-radius: 8px;
    border: 1px solid #e0e0e0;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 500px;
}

thead {
    background: linear-gradient(to right, #2575fc, #6a11cb);
}

th {
    padding: 15px 12px;
    text-align: left;
    color: white;
    font-weight: 600;
    font-size: 14px;
}

tbody tr {
    border-bottom: 1px solid #eaeaea;
    transition: background-color 0.2s ease;
}

tbody tr:hover {
    background-color: #f5f7ff;
}

td {
    padding: 15px 12px;
    color: #2c3e50;
    font-size: 14px;
}

td:nth-child(3) {
    font-weight: 600;
}

.buttons-section {
    display: flex;
    gap: 15px;
    margin-top: 10px;
}

button {
    flex: 1;
    padding: 14px 20px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

button:first-child {
    background: linear-gradient(to right, #2575fc, #6a11cb);
    color: white;
}

button:first-child:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(37, 117, 252, 0.3);
}

button:last-child {
    background: #f1f3f9;
    color: #2c3e50;
    border: 2px solid #e0e0e0;
}

button:last-child:hover {
    background: #e74c3c;
    color: white;
    border-color: #e74c3c;
}

.empty-state {
    text-align: center;
    padding: 30px;
    color: #95a5a6;
    font-style: italic;
}

.status-indicator {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
    margin-right: 8px;
}

.present {
    background-color: #2ecc71;
}

.fee {
    background-color: #3498db;
}

.record {
    background-color: #9b59b6;
}

@media (max-width: 768px) {
    .card {
        padding: 20px;
    }
    
    .buttons-section {
        flex-direction: column;
    }
    
    th, td {
        padding: 12px 8px;
    }
}

@media (max-width: 480px) {
    body {
        padding: 10px;
    }
    
    .card {
        padding: 15px;
    }
    
    .header h3 {
        font-size: 24px;
    }
}
</style>
</head>

<body>

<div class="container">
    <div class="card">
        <div class="header">
            <h3>QR Scan Hub</h3>
            <p>Scan student QR codes for attendance, records, or fee payments</p>
        </div>

        <div class="controls-section">
            <div class="select-container">
                <label for="purpose">Select Scan Purpose</label>
                <select id="purpose" onchange="toggleAmount()">
                    <option value="">-- Choose Purpose --</option>
                    <option value="attendance">Attendance</option>
                    <option value="record">Student Record</option>
                    <option value="fee">Fee Payment</option>
                </select>
            </div>
            
            <input type="number" id="feeAmount" placeholder="Enter Fee Amount (e.g., 2500)" style="display:none;">
            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->getCsrfToken()); ?>

        </div>

        <div class="scanner-section">
            <h4>QR Code Scanner</h4>
            <div id="reader"></div>
        </div>

        <div class="data-section">
            <h4>Local Scans</h4>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Scanned ID</th>
                            <th>Purpose</th>
                            <th>Info</th>
                            <th>Sync</th>
                        </tr>
                    </thead>
                    <tbody id="list">
                        <tr>
                            <td colspan="3" class="empty-state">No scans yet. Scan a QR code to get started.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="buttons-section">
            <button onclick="syncToServer()">
                <span>📤</span> Sync to Server
            </button>
            <button onclick="clearLocal()">
                <span>🗑️</span> Clear All
            </button>
        </div>
    </div>
</div>

<script>
    let audioCtx;
    let beepBuffer = null;

    // Create beep sound
    function initBeep() {
        audioCtx = new (window.AudioContext || window.webkitAudioContext)();

        const sampleRate = audioCtx.sampleRate;
        const duration = 0.08;
        const buffer = audioCtx.createBuffer(1, sampleRate * duration, sampleRate);
        const data = buffer.getChannelData(0);

        for (let i = 0; i < data.length; i++) {
            data[i] = Math.sin(2 * Math.PI * 1000 * i / sampleRate);
        }

        beepBuffer = buffer;
    }

    // Play beep
    function playBeep() {
        if (!audioCtx || audioCtx.state !== "running") return;

        const src = audioCtx.createBufferSource();
        src.buffer = beepBuffer;
        src.connect(audioCtx.destination);
        src.start();
    }


    document.addEventListener('click', () => {
        if (!audioCtx) {
            initBeep();
            audioCtx.resume();
        }
    }, { once: true });



    let scanLocked = false;
    const SCAN_COOLDOWN = 1500; // 1 second


   

    function toggleAmount() {
        const purpose = document.getElementById('purpose').value;
        document.getElementById('feeAmount').style.display = purpose === 'fee' ? 'block' : 'none';
    }

    // Extract student_id from QR URL
    function extractStudentId(text) {
        try {
            const url = new URL(text);
            return url.searchParams.get('id');
        } catch {
            return null;
        }
    }

    function isDuplicate(scan, scans) {
        const today = new Date().toISOString().slice(0, 10); // YYYY-MM-DD
        const month = today.slice(0, 7); // YYYY-MM

        return scans.some(s => {
            if (s.student_id !== scan.student_id) return false;

            // Attendance: once per day
            if (scan.purpose === 'attendance') {
                return s.purpose === 'attendance' &&
                       s.time.startsWith(today);
            }

            // Fee: once per month
            if (scan.purpose === 'fee') {
                return s.purpose === 'fee' &&
                       s.time.startsWith(month);
            }

            return false;
        });
    }

        function onScanSuccess(decodedText) {
        let scans = JSON.parse(localStorage.getItem('qr_data') || '[]');
        
        if (scans.includes(decodedText)) {
            notify("Duplicate ignored", "#fff3cd");
        } else {
            scans.push(decodedText);
            localStorage.setItem('qr_data', JSON.stringify(scans));
            renderList();
            notify("Scan saved locally!");
        }
    }

    function __onScanSuccess(decodedText) {

        let purpose = document.getElementById('purpose').value;
        if (!purpose) {
            alert("Please select a purpose first");
            return;
        }

        let studentId = extractStudentId(decodedText);
        if (!studentId) return;

        // 🔒 LOCK EARLY to stop rapid callbacks
        if (scanLocked) return;
        scanLocked = true;

        let scan = {
            is_sync: 0,
            purpose: purpose,
            student_id: studentId,
            time: new Date().toISOString()
        };

        if (purpose === 'fee') {
            const amount = document.getElementById('feeAmount').value;
            if (amount) scan.amount = amount;
        }

        if (purpose === 'attendance') {
            scan.status = 'present';
        }

        let scans = JSON.parse(localStorage.getItem('qr_data') || '[]');

        // DUPLICATE CHECK (NOW SAFE)
        if (scan.purpose !== 'record' && isDuplicate(scan, scans)) {
            alert("Duplicate scan ignored");

            // 🔓 RELEASE LOCK EVEN ON DUPLICATE
            setTimeout(() => scanLocked = false, SCAN_COOLDOWN);
            return;
        }

        scans.push(scan);
        localStorage.setItem('qr_data', JSON.stringify(scans));
        renderList();

       playBeep();

        // 🔓 UNLOCK AFTER COOLDOWN
        setTimeout(() => {
            scanLocked = false;
        }, SCAN_COOLDOWN);
    }



    function renderList() {
        const scans = JSON.parse(localStorage.getItem('qr_data') || '[]');
        const listElement = document.getElementById('list');
        
        if (scans.length === 0) {
            listElement.innerHTML = `<tr><td colspan="3" class="empty-state">No scans yet. Scan a QR code to get started.</td></tr>`;
            return;
        }
        
        listElement.innerHTML = scans.map(s => {
            let purposeClass = '';
            let purposeIcon = '';
            
            if (s.purpose === 'attendance') {
                purposeClass = 'present';
                purposeIcon = '✅';
            } else if (s.purpose === 'fee') {
                purposeClass = 'fee';
                purposeIcon = '💰';
            } else {
                purposeClass = 'record';
                purposeIcon = '📁';
            }
            
            return `
                <tr>
                    
                    <td><strong>${s.student_id}</strong></td>
                    <td><span class="status-indicator ${purposeClass}"></span> ${purposeIcon} ${s.purpose}</td>
                    <td>${s.amount ? 'Rs.' + s.amount : s.status || '-'}</td>
                    <td><strong>${s.is_sync == 0  || s.is_sync == null? 'Pending' : 'Synced'}</strong></td>
                </tr>
            `;
        }).join('');
    }

    function clearLocal() {
        if (confirm("Are you sure you want to clear all local scans? This action cannot be undone.")) {
            localStorage.removeItem('qr_data');
            renderList();
        }
    }
async function syncToServer() {
    const scans = JSON.parse(localStorage.getItem('qr_data') || '[]');
    if (!scans.length) {
        alert("Nothing to sync");
        return;
    }

    try {
        const res = await fetch('/fee-management/student-fee/process-scans', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
                '<?= Yii::$app->request->csrfParam?>': '<?= Yii::$app->request->getCsrfToken()?>' ,

            body: JSON.stringify({ scans })
        });

        const data = await res.json();

        alert(`Successfully synced!\nSaved: ${data.saved}, Skipped: ${data.skipped}`);

        // localStorage.removeItem('qr_data');
        renderList();

    } catch (err) {
        console.error(err);
        alert("Sync failed – check console");
    }
}

    let scanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
    scanner.render(onScanSuccess);
    renderList();
</script>

</body>
</html>