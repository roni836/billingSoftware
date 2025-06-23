<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductBarcode extends Component
{
    public $product_id;
    public $product;
    public $quantity = 1;
    public $labelSize = '2x1'; // Default label size (2" x 1")
    public $barcodeType = 'code128'; // Default barcode type
    public $showPrice = true;
    public $showSku = true;
    public $barcodeImageUrl;
    
    protected $rules = [
        'quantity' => 'required|integer|min:1|max:100',
        'labelSize' => 'required|in:2x1,3x2,4x3',
        'barcodeType' => 'required|in:code128,qrcode,ean13,code39',
        'showPrice' => 'boolean',
        'showSku' => 'boolean',
    ];
    
    public function mount($product_id)
    {
        $this->product_id = $product_id;
        $this->loadProduct();
    }
    
    public function loadProduct()
    {
        try {
            $this->product = Product::findOrFail($this->product_id);
        } catch (\Exception $e) {
            Log::error('Error loading product for barcode: ' . $e->getMessage());
            session()->flash('error', 'Error loading product: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        return view('livewire.product-barcode');
    }
    
    public function generateBarcode()
    {
        $this->validate();
        
        try {
            // Generate ZPL code for the label
            $zpl = $this->generateZplCode();
            
            // Log the ZPL code for debugging
            Log::info('ZPL Code: ' . $zpl);
            
            // Use cURL directly for more control
            $ch = curl_init();
            
            // Set the label dimensions for the API request
            $dimensions = $this->getLabelDimensions();
            
            // Set cURL options for the Labelary API request
            curl_setopt_array($ch, [
                CURLOPT_URL => "http://api.labelary.com/v1/printers/8dpmm/labels/{$dimensions}/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $zpl,
                CURLOPT_HTTPHEADER => [
                    'Accept: application/pdf',
                    'Content-Type: application/x-www-form-urlencoded'
                ],
                CURLOPT_TIMEOUT => 30
            ]);
            
            // Execute the cURL request
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            
            // Close the cURL session
            curl_close($ch);
            
            // Log the API response details
            Log::info('Labelary API response code: ' . $httpCode);
            
            if ($httpCode === 200 && !empty($response)) {
                // Ensure the barcode directory exists
                $barcodeDir = Storage::disk('public')->path('barcodes');
                if (!file_exists($barcodeDir)) {
                    if (!mkdir($barcodeDir, 0755, true)) {
                        Log::error('Failed to create barcodes directory');
                        session()->flash('error', 'Failed to create storage directory for barcodes');
                        return;
                    }
                }
                
                // Save the barcode PDF
                $filename = 'barcodes/product_' . $this->product_id . '_' . time() . '.pdf';
                if (Storage::disk('public')->put($filename, $response)) {
                    $this->barcodeImageUrl = Storage::disk('public')->url($filename);
                    session()->flash('message', 'Barcode generated successfully!');
                } else {
                    Log::error('Failed to save barcode PDF');
                    session()->flash('error', 'Failed to save barcode file');
                }
            } else {
                // Log the error details
                if (!empty($error)) {
                    Log::error('cURL error: ' . $error);
                    session()->flash('error', 'Connection error: ' . $error);
                } else {
                    Log::error('Labelary API error: HTTP ' . $httpCode);
                    session()->flash('error', 'API error: HTTP ' . $httpCode);
                }
            }
        } catch (\Exception $e) {
            Log::error('Exception in barcode generation: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            session()->flash('error', 'Error: ' . $e->getMessage());
        }
    }
    
    private function generateZplCode()
    {
        // Start ZPL code
        $zpl = "^XA";
        
        // Set label orientation and position
        $zpl .= "^LH20,20";
        
        // Product name
        $productName = $this->escapeZpl($this->product->name);
        if (strlen($productName) > 25) {
            $productName = substr($productName, 0, 22) . '...';
        }
        $zpl .= "^FO10,10^A0N,30,30^FD" . $productName . "^FS";
        
        // Add SKU if enabled
        if ($this->showSku) {
            $zpl .= "^FO10,50^A0N,20,20^FDSKU: " . $this->escapeZpl($this->product->sku) . "^FS";
        }
        
        // Add price if enabled
        if ($this->showPrice) {
            $zpl .= "^FO10,80^A0N,25,25^FDPrice: Rs" . number_format($this->product->selling_price, 2) . "^FS";
        }
        
        // Calculate barcode position
        $barcodeY = 120;
        if (!$this->showSku && !$this->showPrice) {
            $barcodeY = 60;
        } elseif (!$this->showSku || !$this->showPrice) {
            $barcodeY = 90;
        }
        
        // Generate barcode based on selected type
        switch ($this->barcodeType) {
            case 'qrcode':
                // QR Code
                $zpl .= "^FO50," . $barcodeY . "^BQN,2,5^FDMM" . $this->escapeZpl($this->product->sku) . "^FS";
                break;
                
            case 'ean13':
                // EAN-13
                $numericSku = preg_replace('/[^0-9]/', '', $this->product->sku);
                $barcodeData = str_pad($numericSku, 12, '0', STR_PAD_LEFT);
                $barcodeData = substr($barcodeData, 0, 12);
                $zpl .= "^FO20," . $barcodeY . "^BY3^BEN,70,Y,N^FD" . $barcodeData . "^FS";
                break;
                
            case 'code39':
                // Code 39
                $zpl .= "^FO20," . $barcodeY . "^BY3^B3N,50,Y,N,N^FD*" . $this->escapeZpl($this->product->sku) . "*^FS";
                break;
                
            default:
                // Code 128 (default)
                $zpl .= "^FO20," . $barcodeY . "^BY3^BCN,70,Y,N,N^FD" . $this->escapeZpl($this->product->sku) . "^FS";
        }
        
        // End ZPL code
        $zpl .= "^XZ";
        
        return $zpl;
    }
    
    private function getLabelDimensions()
    {
        // Return dimensions in the format expected by Labelary API
        switch ($this->labelSize) {
            case '3x2':
                return '3x2';
            case '4x3':
                return '4x3';
            default:
                return '2x1';
        }
    }
    
    private function escapeZpl($text)
    {
        // Remove non-printable characters
        $text = preg_replace('/[^\x20-\x7E]/', '', $text);
        
        // Escape special ZPL characters
        return str_replace(
            ['\\', '^', '~', ',', ':'],
            ['\\\\', '\\^', '\\~', '\\,', '\\:'],
            $text
        );
    }
    
    public function printBarcode()
    {
        if ($this->barcodeImageUrl) {
            $this->dispatchBrowserEvent('print-barcode', ['url' => $this->barcodeImageUrl]);
        } else {
            session()->flash('error', 'Please generate a barcode first before printing');
        }
    }
}