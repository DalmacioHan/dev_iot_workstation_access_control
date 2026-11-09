<style>
    
    * {
        box-sizing: border-box;
    }
    
    html, body {
        margin: 0;
        padding: 0;
        width: 100%;
        font-family: Georgia, 'Times New Roman', serif;
    }
    
    .header-wrapper {
        width: 78%;
        margin: 0 auto;
        padding-top: 10px;
    }
    
    .logos-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 18px;
        margin-bottom: 6px;
    }
    
    .slsu-logo {
        height: 90px;
        width: auto;
    }
    
    .bagong-pilipinas-logo {
        height: 70px;
        width: auto;
        position: relative;
        top: -8px;
    }
    
    
    .core-values-box {
        width: 100%;
        border-bottom: 1.5px solid #000;
        text-align: center;
        padding-bottom: 4px;
    }
    
    
    .core-values-text {
        font-size: 8px; 
        white-space: nowrap; 
        color: #000;
    }
</style>

<div class="header-wrapper">
    <div class="logos-row">
    
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('image/slsu.png'))) }}" class="slsu-logo" alt="SLSU Logo">
        <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('image/bagong_pilipinas.jpeg'))) }}" class="bagong-pilipinas-logo" alt="Bagong Pilipinas Logo">
    </div>

    
    <div class="core-values-box">
        <div class="core-values-text">Excellence | Service | Leadership and Good Governance | Innovation | Social Responsibility | Integrity | Professionalism | Spirituality</div>
    </div>
</div>