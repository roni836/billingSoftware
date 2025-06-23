<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Response;

class BarcodeController extends Controller
{
    /**
     * Generate a PNG barcode image for a product
     */
    public function generateBarcode(Request $request, $productId)
    {
        try {
            $product = Product::findOrFail($productId);
            
            // Get barcode type from request or default to code128
            $barcodeType = $request->input('type', 'C128');
            
            // Map user-friendly types to Picqer types
            $typeMap = [
                'code128' => 'C128',
                'qrcode' => 'QRCODE',
                'ean13' => 'EAN13',
                'code39' => 'C39'
            ];
            
            $type = $typeMap[$barcodeType] ?? 'C128';
            
            // Generate barcode
            $generator = new BarcodeGeneratorPNG();
            
            // Prepare data for barcode
            $data = $product->sku;
            if ($type === 'EAN13') {
                // Ensure EAN13 data is valid (12 digits, 13th is check digit)
                $numericSku = preg_replace('/[^0-9]/', '', $product->sku);
                $data = str_pad($numericSku, 12, '0', STR_PAD_LEFT);
                $data = substr($data, 0, 12);
            }
            
            // Generate the barcode
            $barcode = $generator->getBarcode($data, constant("Picqer\\Barcode\\BarcodeGenerator::TYPE_$type"));
            
            // Return as PNG image
            return Response::make($barcode, 200, [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'inline; filename="barcode-' . $product->sku . '.png"'
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}