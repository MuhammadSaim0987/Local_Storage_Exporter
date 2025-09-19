<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Local Storage Data Exporter</title>
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #7209b7;
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --success-color: #4cc9f0;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: var(--dark-color);
            line-height: 1.6;
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
        }
        
        header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 25px;
            text-align: center;
        }
        
        h1 {
            font-size: 2.2rem;
            margin-bottom: 10px;
        }
        
        .subtitle {
            font-size: 1rem;
            opacity: 0.9;
        }
        
        .content {
            padding: 25px;
        }
        
        .actions {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background-color: var(--accent-color);
            color: white;
        }
        
        .btn-secondary:hover {
            background-color: #5a0895;
            transform: translateY(-2px);
        }
        
        .btn i {
            margin-right: 8px;
        }
        
        .data-section {
            margin-bottom: 30px;
        }
        
        h2 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--secondary-color);
            display: flex;
            align-items: center;
        }
        
        h2 i {
            margin-right: 10px;
        }
        
        .data-container {
            background-color: var(--light-color);
            border-radius: var(--border-radius);
            padding: 20px;
            margin-bottom: 15px;
            border-left: 4px solid var(--primary-color);
        }
        
        pre {
            white-space: pre-wrap;
            word-break: break-all;
            font-family: 'Consolas', monospace;
            line-height: 1.5;
        }
        
        .empty-data {
            color: #6c757d;
            font-style: italic;
        }
        
        .info-box {
            background-color: #e9ecef;
            border-radius: var(--border-radius);
            padding: 15px;
            margin-top: 20px;
            font-size: 0.9rem;
        }
        
        footer {
            text-align: center;
            padding: 20px;
            color: #6c757d;
            font-size: 0.9rem;
            border-top: 1px solid #dee2e6;
        }
        
        @media (max-width: 600px) {
            .actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Local Storage Data Exporter</h1>
            <p class="subtitle">View and export your locally stored data</p>
        </header>
        
        <div class="content">
            <div class="actions">
                <button class="btn btn-primary" onclick="exportData()">
                    <i class="fas fa-download"></i> Export Data to TXT File
                </button>
            </div>
            
            <div class="data-section">
                <h2><i class="fas fa-database"></i> Local Storage (products):</h2>
                <div class="data-container">
                    <pre id="localData" class="empty-data">No data found in local storage</pre>
                </div>
            </div>
            
            <div class="info-box">
                <p><i class="fas fa-info-circle"></i> This tool allows you to view and export data stored in your browser's local storage. 
                Data will persist even when you close the browser.</p>
            </div>
        </div>
        
        <footer>
            <p>Local Storage Data Exporter &copy; 2025</p>
            <p>Developed by Shaikh Muhammad Saim</p>
        </footer>
    </div>

    <script>
        // Function to export data to text file
        function exportData() {
            try {
                // Get data from storage
                const localData = localStorage.getItem('products');
                
                // Update display
                document.getElementById('localData').textContent = 
                    localData ? JSON.stringify(JSON.parse(localData), null, 2) : 'No data found in local storage';
                
                document.getElementById('localData').className = localData ? '' : 'empty-data';
                
                // Create text content
                let fileContent = '=== LOCAL STORAGE DATA EXPORT ===\n\n';
                fileContent += 'Generated on: ' + new Date().toLocaleString() + '\n';
                fileContent += '====================================\n\n';
                
                fileContent += '=== LOCAL STORAGE (products) ===\n\n';
                fileContent += localData ? JSON.stringify(JSON.parse(localData), null, 2) : 'No data found';
                
                fileContent += '\n\n=== EXPORT INFO ===\n';
                fileContent += `Exported on: ${new Date().toLocaleString()}\n`;
                fileContent += `User Agent: ${navigator.userAgent}\n`;
                
                // Create and download file
                const blob = new Blob([fileContent], { type: 'text/plain' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = `local_storage_export_${new Date().toISOString().replace(/[:.]/g, '-')}.txt`;
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);
                
                // Show confirmation
                showToast('Data exported successfully!', 'success');
                
            } catch (error) {
                console.error('Error exporting data:', error);
                showToast('Error exporting data: ' + error.message, 'error');
            }
        }
        
        // Function to add sample data for testing
        function addSampleData() {
            const sampleProducts = [
                { id: 1, name: "Premium Headphones", price: 129.99, category: "Electronics" },
                { id: 2, name: "Ergonomic Office Chair", price: 249.99, category: "Furniture" },
                { id: 3, name: "Stainless Steel Water Bottle", price: 24.99, category: "Kitware" },
                { id: 4, name: "Wireless Keyboard", price: 59.99, category: "Electronics" },
                { id: 5, name: "Desk Lamp", price: 34.99, category: "Home Decor" }
            ];
            
            localStorage.setItem('products', JSON.stringify(sampleProducts));
            
            showToast('Sample data added to local storage!', 'success');
            updateDisplay();
        }
        
        // Function to update the display
        function updateDisplay() {
            const localData = localStorage.getItem('products');
            const localDataElement = document.getElementById('localData');
            
            localDataElement.textContent = 
                localData ? JSON.stringify(JSON.parse(localData), null, 2) : 'No data found in local storage';
            
            localDataElement.className = localData ? '' : 'empty-data';
        }
        
        // Simple toast notification function
        function showToast(message, type = 'info') {
            // Remove existing toasts
            const existingToasts = document.querySelectorAll('.toast');
            existingToasts.forEach(toast => toast.remove());
            
            // Create toast element
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
                <div class="toast-content">
                    <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                    <span>${message}</span>
                </div>
            `;
            
            // Add styles for toast
            toast.style.cssText = `
                position: fixed;
                bottom: 20px;
                right: 20px;
                background: ${type === 'success' ? '#4caf50' : '#f44336'};
                color: white;
                padding: 12px 20px;
                border-radius: 4px;
                box-shadow: 0 2px 10px rgba(0,0,0,0.2);
                display: flex;
                align-items: center;
                z-index: 1000;
                animation: fadeIn 0.3s, fadeOut 0.3s 2.7s forwards;
            `;
            
            document.body.appendChild(toast);
            
            // Remove toast after 3 seconds
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 3000);
        }
        
        // Add CSS for toast animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            @keyframes fadeOut {
                from { opacity: 1; transform: translateY(0); }
                to { opacity: 0; transform: translateY(20px); }
            }
            
            .toast-content i {
                margin-right: 10px;
            }
        `;
        document.head.appendChild(style);
        
        // Initialize display on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateDisplay();
        });
    </script>
</body>
</html>