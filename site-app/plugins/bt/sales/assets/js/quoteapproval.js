document.addEventListener('DOMContentLoaded', function () {
    const signatureInput = document.getElementById('signature');
    const canvas = document.getElementById('signature-canvas');
    const context = canvas.getContext('2d');
    let isDrawing = false;

    // Resize canvas on window resize
    window.addEventListener('resize', function(){
        canvas.width = canvasContainer.clientWidth;
        canvas.height = canvasContainer.clientHeight;
        canvas.getContext('2d');
    });

    // Handle mouse/touch events for drawing
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('touchstart', startDrawing);

    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('touchmove', draw);

    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseleave', stopDrawing);
    canvas.addEventListener('touchend', stopDrawing);

    // Clear signature button
    document.getElementById('clear-signature').addEventListener('click', clearSignature);

    function startDrawing(e) {
        isDrawing = true;
        draw(e);
    }

    function draw(e) {
        if (!isDrawing) return;

        // Adjust coordinates for touch events
        var x, y;
        if (e.touches) {
            x = e.touches[0].clientX - canvas.getBoundingClientRect().left;
            y = e.touches[0].clientY - canvas.getBoundingClientRect().top;
        } else {
            x = e.clientX - canvas.getBoundingClientRect().left;
            y = e.clientY - canvas.getBoundingClientRect().top;
        }

        // Drawing settings
        context.lineWidth = 2;
        context.lineCap = 'round';
        context.strokeStyle = '#000';

        context.lineTo(x, y);
        context.stroke();
        context.beginPath();
        context.moveTo(x, y);

        submitSignature();
    }

    function stopDrawing() {
        isDrawing = false;
        context.beginPath();
    }

    function clearSignature() {
        context.clearRect(0, 0, canvas.width, canvas.height);
        signatureInput.value = null;
    }

    function submitSignature() {
        const imageData = canvas.toDataURL();
        signatureInput.value = imageData;
    }
});