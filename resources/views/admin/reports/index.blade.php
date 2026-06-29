@extends('admin.layouts.app')

@section('title', 'Reports - StyleHub Admin')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .page-header h4 {
        font-weight: 700;
        font-size: 22px;
        color: #1a1a2e;
        margin: 0;
    }
    .page-header h4 i {
        color: #db4444;
        margin-right: 8px;
    }
    .page-header p {
        color: #8c8c9c;
        margin: 0;
        font-size: 14px;
    }

    .report-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid rgba(0,0,0,0.04);
        box-shadow: 0 2px 15px rgba(0,0,0,0.04);
        padding: 24px 20px;
        transition: all 0.3s;
        height: 100%;
        text-align: center;
    }
    .report-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0,0,0,0.08);
    }
    .report-card .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin: 0 auto 12px;
    }
    .report-card .icon-circle.primary { background: #fef0f0; color: #db4444; }
    .report-card .icon-circle.success { background: #e8f5e9; color: #28a745; }
    .report-card .icon-circle.info { background: #e3f2fd; color: #0d6efd; }
    .report-card .icon-circle.warning { background: #fef3e2; color: #ff9800; }
    .report-card h5 { 
        font-weight: 700; 
        font-size: 18px; 
        color: #1a1a2e; 
        margin-bottom: 4px;
    }
    .report-card p { 
        color: #8c8c9c; 
        font-size: 14px; 
        margin-bottom: 14px; 
    }
    
   
    .format-selector {
        display: flex;
        gap: 6px;
        justify-content: center;
        margin-bottom: 16px;
    }
    .format-selector .format-option {
        padding: 5px 16px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        border: 2px solid #e0e0e0;
        background: #fff;
        color: #666;
        transition: all 0.2s;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        flex: 1;
        max-width: 70px;
        text-align: center;
    }
    .format-selector .format-option.active {
        background: #db4444;
        color: #fff;
        border-color: #db4444;
    }
    .format-selector .format-option:hover:not(.active) {
        background: #f5f5f5;
        border-color: #ccc;
    }

  
    .report-card .generate-btn {
        background: #db4444;
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        display: inline-block;
        width: 100%;
        max-width: 180px;
    }
    .report-card .generate-btn:hover {
        background: #b33232;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(219, 68, 68, 0.3);
    }
    .report-card .generate-btn:active {
        transform: scale(0.95);
    }
    .report-card .generate-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }
    .report-card .generate-btn i {
        margin-right: 8px;
    }
    .report-card .generate-btn .spinner {
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    
    #toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        max-width: 380px;
        width: 100%;
    }
    .toast {
        background: #1a1a2e;
        color: #fff;
        padding: 15px 20px;
        border-radius: 10px;
        margin-bottom: 10px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        animation: slideIn 0.3s ease;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .toast.success { border-left: 4px solid #28a745; }
    .toast.error { border-left: 4px solid #dc3545; }
    .toast.info { border-left: 4px solid #0d6efd; }
    .toast .toast-icon { font-size: 20px; }
    .toast .toast-close {
        margin-left: auto;
        cursor: pointer;
        opacity: 0.6;
        transition: 0.2s;
        padding: 0 5px;
    }
    .toast .toast-close:hover { opacity: 1; }
    
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }

    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
        .report-card .generate-btn {
            max-width: 100%;
        }
        .format-selector .format-option {
            max-width: 60px;
            font-size: 11px;
            padding: 4px 10px;
        }
    }
</style>

<div class="page-header">
    <div>
        <h4><i class="fas fa-file-alt"></i> Reports</h4>
        <p>Generate and download reports</p>
    </div>
</div>


<div id="toast-container"></div>

<div class="row g-4">
    @foreach($reportTypes as $key => $report)
    <div class="col-md-3 col-6">
        <div class="report-card">
            <div class="icon-circle {{ $report['color'] }}">
                <i class="fas {{ $report['icon'] }}"></i>
            </div>
            <h5>{{ $report['name'] }}</h5>
            <p>{{ $report['description'] }}</p>
            
         
            <div class="format-selector" data-report="{{ $key }}">
                <span class="format-option active" data-format="csv">CSV</span>
                <span class="format-option" data-format="excel">Excel</span>
                <span class="format-option" data-format="pdf">PDF</span>
            </div>
            
         
            <button class="generate-btn" data-report="{{ $key }}">
                <i class="fas fa-download"></i> Generate
            </button>
        </div>
    </div>
    @endforeach
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    
   
    document.querySelectorAll('.format-selector').forEach(selector => {
        const options = selector.querySelectorAll('.format-option');
        options.forEach(option => {
            option.addEventListener('click', function(e) {
                e.stopPropagation();
                options.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
 
    document.querySelectorAll('.generate-btn').forEach(button => {
        button.addEventListener('click', function() {
            const reportType = this.dataset.report;
            const card = this.closest('.report-card');
            const formatSelector = card.querySelector('.format-selector');
            const activeFormat = formatSelector ? formatSelector.querySelector('.format-option.active') : null;
            const format = activeFormat ? activeFormat.dataset.format : 'csv';
            
        
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner spinner"></i> Generating...';
            
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
                         document.querySelector('input[name="_token"]')?.value;
            
            const formData = new FormData();
            formData.append('type', reportType);
            formData.append('format', format);
            formData.append('_token', token || '{{ csrf_token() }}');
            
            showToast('Generating ' + reportType + ' report...', 'info');
            
           
            fetch('{{ url("/admin/reports/generate") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token || '{{ csrf_token() }}'
                }
            })
            .then(async response => {
                if (!response.ok) {
                    const text = await response.text();
                    throw new Error(text || 'Server error occurred');
                }
                return response.blob();
            })
            .then(blob => {
              
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                const extension = format === 'excel' ? 'xlsx' : format;
                const date = new Date().toISOString().split('T')[0];
                a.download = `${reportType}_report_${date}.${extension}`;
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
                
                showToast('✅ ' + reportType + ' report downloaded successfully!', 'success');
            })
            .catch(error => {
                console.error('Error:', error);
                let message = 'Failed to generate report. Please try again.';
                if (error.message.includes('CSRF')) {
                    message = 'Session expired. Please refresh the page.';
                }
                showToast('❌ ' + message, 'error');
            })
            .finally(() => {
               
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-download"></i> Generate';
            });
        });
    });

   
    function showToast(message, type = 'info') {
        const container = document.getElementById('toast-container');
        if (!container) return;
        
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-circle',
            info: 'fa-info-circle'
        };
        
        toast.innerHTML = `
            <span class="toast-icon"><i class="fas ${icons[type] || icons.info}"></i></span>
            <span>${message}</span>
            <span class="toast-close"><i class="fas fa-times"></i></span>
        `;
        
     
        toast.querySelector('.toast-close').addEventListener('click', function() {
            removeToast(toast);
        });
        
        container.appendChild(toast);
        
      
        setTimeout(() => {
            removeToast(toast);
        }, 5000);
    }
    
    function removeToast(toast) {
        if (toast && toast.parentElement) {
            toast.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 300);
        }
    }
});
</script>
@endpush
@endsection