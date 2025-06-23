<x-layouts.app>
    @livewire('products')
    
    <script>
    window.addEventListener('DOMContentLoaded', (event) => {
        console.log("Debug script loaded for products");
        
        // Check for Livewire
        if (typeof window.Livewire !== 'undefined') {
            console.log("Livewire detected for products");
            
            // Listen for the product-saved event
            window.addEventListener('product-saved', event => {
                console.log('Product saved event received');
                // Refresh the component if needed
                Livewire.emit('refresh');
            });
            
            // Monitor for when components are initialized
            document.addEventListener('livewire:load', function () {
                console.log("Livewire loaded for products");
                
                // Check if we're on the products page
                const productsComponent = document.querySelector('[wire\\:id]');
                if (productsComponent && productsComponent.getAttribute('wire:initial-data').includes('products')) {
                    console.log("Products component detected");
                    
                    // Monitor button clicks for debugging
                    const createButton = document.querySelector('button[wire\\:click\\.prevent="create"]');
                    if (createButton) {
                        createButton.addEventListener('click', function(e) {
                            console.log("Add Product button clicked");
                            
                            // Check if modal becomes visible after a short delay
                            setTimeout(() => {
                                const modal = document.querySelector('.fixed.z-10.inset-0.overflow-y-auto');
                                if (modal) {
                                    console.log("Modal display style:", modal.style.display);
                                    
                                    if (modal.style.display === 'none') {
                                        console.log("Modal is still hidden, attempting to show it manually");
                                        modal.style.display = 'block';
                                    }
                                }
                            }, 500);
                        });
                    }
                }
            });
        }
    });
    </script>
</x-layouts.app>