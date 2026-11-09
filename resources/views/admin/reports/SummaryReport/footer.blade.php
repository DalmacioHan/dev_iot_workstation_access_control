<style>
    html, body {
        margin: 0;
        padding: 0;
        width: 100%;
        box-sizing: border-box;
    }
    
    .footer-content {
        width: 78%;
        margin: 0 auto;
        padding-top: 15px; 
        border-top: 1.5px solid #000; 
        display: flex;
        justify-content: flex-end; 
        align-items: center;
        gap: 25px; 
    }
    
    .qs-logo {
        height: 55px; 
        width: auto;
    }
    
    .socotec-logo {
        height: 50px; 
        width: auto;
    }
</style>

<div class="footer-content">
    
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('image/qs_rating.png'))) }}" class="qs-logo" alt="QS Stars Rated Good">
    
    
    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('image/socotec.jpg'))) }}" class="socotec-logo" alt="SOCOTEC ISO 9001">
</div>