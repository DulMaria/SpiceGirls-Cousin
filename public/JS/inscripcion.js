document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const qrPaymentBtn = document.getElementById('qrPaymentBtn');
    const cashPaymentBtn = document.getElementById('cashPaymentBtn');
    const qrModal = document.getElementById('qrModal');
    const cashModal = document.getElementById('cashModal');
    const closeQrModal = document.getElementById('closeQrModal');
    const closeCashModal = document.getElementById('closeCashModal');
    const closeQrModalBtn = document.getElementById('closeQrModalBtn');
    const closeCashModalBtn = document.getElementById('closeCashModalBtn');
    const printReceiptBtn = document.getElementById('printReceiptBtn');
    
    // Event Listeners
    qrPaymentBtn.addEventListener('click', openQRModal);
    cashPaymentBtn.addEventListener('click', openCashModal);
    closeQrModal.addEventListener('click', () => closeModal('qrModal'));
    closeCashModal.addEventListener('click', () => closeModal('cashModal'));
    closeQrModalBtn.addEventListener('click', () => closeModal('qrModal'));
    closeCashModalBtn.addEventListener('click', () => closeModal('cashModal'));
    printReceiptBtn.addEventListener('click', printReceipt);
    
    // Cerrar modal al hacer clic fuera del contenido
    window.addEventListener('click', function(event) {
        if (event.target === qrModal) {
            closeModal('qrModal');
        }
        if (event.target === cashModal) {
            closeModal('cashModal');
        }
    });
    
    // Función para abrir modal de pago QR
    function openQRModal() {
        if (validateForm()) {
            qrModal.classList.remove('hidden');
        }
    }
    
    // Función para abrir modal de pago en efectivo
    function openCashModal() {
        if (validateForm()) {
            // Generar número aleatorio para número de inscripción
            document.getElementById('random-num').textContent = Math.floor(Math.random() * 10000);
            
            // Llenar datos del recibo
            document.getElementById('receipt-name').textContent = document.getElementById('nombre').value;
            document.getElementById('receipt-document').textContent = document.getElementById('documento').value;
            
            // Obtener horario seleccionado
            const horarioSelect = document.getElementById('horario');
            document.getElementById('receipt-schedule').textContent = horarioSelect.options[horarioSelect.selectedIndex].text;
            
            // Mostrar modal
            cashModal.classList.remove('hidden');
        }
    }
    
    // Función para cerrar modales
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
    
    // Función para validar formulario
    function validateForm() {
        const requiredFields = ['nombre', 'documento', 'email', 'telefono', 'codigo_estudiante', 'horario'];
        
        for (const field of requiredFields) {
            const element = document.getElementById(field);
            if (!element.value.trim()) {
                alert(`Por favor complete el campo: ${element.previousElementSibling.textContent.replace('*', '')}`);
                element.focus();
                return false;
            }
        }
        
        // Validación simple de email
        const email = document.getElementById('email').value;
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            alert('Por favor ingrese un correo electrónico válido');
            document.getElementById('email').focus();
            return false;
        }
        
        return true;
    }
    
    // Función para imprimir recibo
    function printReceipt() {
        window.print();
    }
});