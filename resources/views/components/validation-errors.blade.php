<!-- Global validation error summary -->
@if($errors->any())
    <!-- Le HTML doit être affiché dans le conteneur principal si possible, mais on peut utiliser un overlay fixe si on l'injecte globalement -->
    <div id="global-error-overlay" class="fixed top-4 right-4 z-50 max-w-sm w-full bg-red-50 border border-red-200 rounded-2xl shadow-2xl p-4 animate-fadeInUp" style="display: none;">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-sm font-bold text-red-800"><i class="fas fa-exclamation-triangle mr-2"></i> Erreurs de formulaire</h3>
            <button onclick="document.getElementById('global-error-overlay').remove()" class="text-red-500 hover:text-red-700">&times;</button>
        </div>
        <ul class="list-disc list-inside text-sm text-red-700 space-y-1 ml-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('global-error-overlay');
            if (overlay) overlay.style.display = 'block';

            const serverErrors = @json($errors->messages());
            for (const [field, messages] of Object.entries(serverErrors)) {
                // Handle array names (e.g., field[] becomes field)
                const inputName = field.replace(/\./g, '[').replace(/\]$/, '') + (field.includes('.') ? ']' : '');
                
                const inputElement = document.querySelector(`[name="${inputName}"], [name="${inputName}[]"], #${field}`);
                if (inputElement) {
                    const block = document.createElement('p');
                    block.className = 'text-red-500 text-[11px] font-bold mt-1 bg-red-50 p-1.5 rounded flex items-center shadow-sm animate-fadeInUp validation-error-msg';
                    block.innerHTML = `<i class="fas fa-exclamation-circle mr-1.5"></i> ${messages[0]}`;
                    
                    // Insert right after the input
                    inputElement.parentNode.insertBefore(block, inputElement.nextSibling);

                    // Red border for emphasis
                    inputElement.style.borderColor = '#ef4444';
                    inputElement.style.boxShadow = '0 0 0 1px #ef4444';

                    // Remove error styling on typing
                    inputElement.addEventListener('input', function() {
                        inputElement.style.borderColor = '';
                        inputElement.style.boxShadow = '';
                        if (block.parentNode) block.remove();
                    }, {once: true});
                }
            }
        });
    </script>
@endif
