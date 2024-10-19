<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Geometry\Factories\LineFactory;
use Intervention\Image\ImageManager;

class ERDController extends Controller
{
    public function showForm()
    {
        return view('welcome');
    }

    public function generateERD(Request $request)
    {

        $tables = $request->input('tables');

        $this->createERD($tables);
        return response()->download(storage_path('app/erd_' . time() . '.png'));
    }

    protected function createERD($tables)
    {
        $fontSizeTable = 5; 
        $fontSizeField = 4; 
        $padding = 10;     
        $maxWidth = 0;     
        $totalHeight = 0;   

        foreach ($tables as $table) {
            $tableName = $table['name'];
            $maxWidth = max($maxWidth, strlen($tableName) * imagefontwidth($fontSizeTable) + $padding * 2);

            $fields = explode(',', $table['fields']);
            foreach ($fields as $field) {
                $maxWidth = max($maxWidth, strlen(trim($field)) * imagefontwidth($fontSizeField) + $padding * 2);
            }

            if (!empty($table['relations'])) {
                $relations = explode(',', $table['relations']);
                foreach ($relations as $relation) {
                    $maxWidth = max($maxWidth, strlen(trim($relation)) * imagefontwidth($fontSizeField) + $padding * 2);
                }
            }

            $totalHeight += 20 + count($fields) * 15 + (empty($table['relations']) ? 0 : count($relations) * 15) + $padding;
        }

        $width = max($maxWidth, 800);
        $height = max($totalHeight + $padding * 2, 600);

        $image = imagecreate($width, $height);
        $backgroundColor = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);

        $y = $padding;

        foreach ($tables as $table) {
            $tableName = $table['name'];
            imagestring($image, $fontSizeTable, $padding, $y, "Table: $tableName", $textColor);
            $y += 20;

            $fields = explode(',', $table['fields']);
            foreach ($fields as $field) {
                imagestring($image, $fontSizeField, $padding, $y, "Field: " . trim($field), $textColor);
                $y += 15;
            }

            if (!empty($table['relations'])) {
                $relations = explode(',', $table['relations']);
                foreach ($relations as $relation) {
                    imagestring($image, $fontSizeField, $padding, $y, "Relation: " . trim($relation), $textColor);
                    $y += 15;
                }
            }

            $y += $padding; 
        }

        $imagePath = storage_path('app/erd_' . time() . '.png');
        imagepng($image, $imagePath);
        imagedestroy($image);

        return $imagePath;
    }
}
