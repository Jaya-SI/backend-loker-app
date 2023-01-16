<?php

namespace App\Http\Controllers\Api\HRD;

use App\Http\Controllers\Controller;
use App\Models\CategoryLoker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function getBytesFromHexString($hexdata)
    {
        for ($count = 0; $count < strlen($hexdata); $count += 2)
            $bytes[] = chr(hexdec(substr($hexdata, $count, 2)));

        return implode($bytes);
    }

    public function getImageMimeType($imagedata)
    {
        $imagemimetypes = array(
            "jpeg" => "FFD8",
            "png" => "89504E470D0A1A0A",
            "gif" => "474946",
            "bmp" => "424D",
            "tiff" => "4949",
            "tiff" => "4D4D"
        );

        foreach ($imagemimetypes as $mime => $hexbytes) {
            $bytes = $this->getBytesFromHexString($hexbytes);
            if (substr($imagedata, 0, strlen($bytes)) == $bytes)
                return $mime;
        }

        return NULL;
    }

    public function addCategory(Request $request)
    {
        $img_category = request()->img_category;
        $img_category_decode = base64_decode($img_category);
        $img_category_ex = $this->getImageMimeType($img_category_decode);
        $img_category = str_replace('data:image/png;base64,', '', $img_category);
        $img_category = str_replace(' ', '+', $img_category);
        $img_category_name = Str::random(10) . '.' . $img_category_ex;
        Storage::disk('upload')->put('categories/' . $img_category_name, $img_category_decode);

        //create category
        $category = CategoryLoker::create([
            'nama_category' => $request->nama_category,
            'img_category' => "uploads/categories/" . $img_category_name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category berhasil ditambahkan',
            'data' => $category
        ], 200);
    }

    public function editCategory(Request $request, $id)
    {
        $category = CategoryLoker::find($id);

        if ($request->img_category) {
            $img_category = request()->img_category;
            $img_category_decode = base64_decode($img_category);
            $img_category_ex = $this->getImageMimeType($img_category_decode);
            $img_category = str_replace('data:image/png;base64,', '', $img_category);
            $img_category = str_replace(' ', '+', $img_category);
            $img_category_name = Str::random(10) . '.' . $img_category_ex;
            Storage::disk('upload')->put('categories/' . $img_category_name, $img_category_decode);

            $category->img_category = "uploads/categories/" . $img_category_name;
        }

        $category->nama_category = $request->nama_category;
        $category->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Category berhasil diubah',
            'data' => $category
        ], 200);
    }

    public function deleteCategory($id)
    {
        $category = CategoryLoker::find($id);
        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category berhasil dihapus',
            'data' => $category
        ], 200);
    }

    public function getCategory()
    {
        $category = CategoryLoker::all();

        return response()->json(
            $category
        , 200);
    }

    public function getCategoryById($id)
    {
        $category = CategoryLoker::find($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Category berhasil didapatkan',
            'data' => $category
        ], 200);
    }
}
