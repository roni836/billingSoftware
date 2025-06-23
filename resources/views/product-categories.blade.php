<x-layouts.app>
    @livewire('product-categories')
    
    <script>
    window.addEventListener('DOMContentLoaded', (event) => {
        console.log("Debug script loaded for categories");
        
        // Check for Livewire
        if (typeof window.Livewire !== 'undefined') {
            console.log("Livewire detected");
            
            // Listen for the category-saved event
            window.addEventListener('category-saved', event => {
                console.log('Category saved event received');
                // Refresh the component if needed
                Livewire.emit('refresh');
            });
            
            // Monitor for when components are initialized
            document.addEventListener('livewire:load', function () {
                console.log("Livewire loaded");
                
                // Check if we're on the categories page
                const categoriesComponent = document.querySelector('[wire\\:id]');
                if (categoriesComponent && categoriesComponent.getAttribute('wire:initial-data').includes('product-categories')) {
                    console.log("Product Categories component detected");
                    
                    // Monitor button clicks for debugging
                    document.querySelector('button[wire\\:click\\.prevent="create"]').addEventListener('click', function(e) {
                        console.log("Add Category button clicked");
                        
                        // Check if modal becomes visible after a short delay
                        setTimeout(() => {
                            const modal = document.getElementById('categoryModal');
                            console.log("Modal display style:", modal.style.display);
                            
                            if (modal.style.display === 'none') {
                                console.log("Modal is still hidden, attempting to show it manually");
                                modal.style.display = 'block';
                            }
                        }, 500);
                    });
                }
            });
        }
    });
    </script>
</x-layouts.app>