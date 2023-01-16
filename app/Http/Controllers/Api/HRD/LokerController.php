<?php

namespace App\Http\Controllers\Api\HRD;

use App\Http\Controllers\Controller;
use App\Models\Loker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LokerController extends Controller
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

    public function addloker(Request $request)
    {
        $img_loker = request()->img_loker;
        $img_loker_decode = base64_decode($img_loker);
        $img_loker_ex = $this->getImageMimeType($img_loker_decode);
        $img_loker = str_replace('data:image/png;base64,', '', $img_loker);
        $img_loker = str_replace(' ', '+', $img_loker);
        $img_loker_name = Str::random(10) . '.' . $img_loker_ex;
        Storage::disk('upload')->put('lokers/' . $img_loker_name, $img_loker_decode);

        //create loker
        $loker = Loker::create([
            'id_category' => $request->id_category,
            'id_hrd' => $request->id_hrd,
            'nama' => $request->nama,
            'img_loker' => "uploads/lokers/" . $img_loker_name,
            'alamat' => $request->alamat,
            'tanggal' => $request->tanggal,
            'deskripsi1' => $request->deskripsi1,
            'deskripsi2' => $request->deskripsi2,
            'deskripsi3' => $request->deskripsi3,
            'gaji' => $request->gaji,
            'status' => $request->status,
        ]);

        if ($loker) {
            return response()->json([
                'status' => 'success',
                'message' => 'Loker berhasil ditambahkan',
                'data' => $loker
            ],200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Loker gagal ditambahkan',
            'data' => null
        ],409);
    }

    public function getLoker()
    {
        $loker = Loker::with('idCategory')->with('idHrd')->get();

        if ($loker) {
            return response()->json([
                'status' => 'success',
                'message' => 'Loker berhasil ditampilkan',
                'data' => $loker
            ],200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Loker gagal ditampilkan',
            'data' => null
        ],409);
    }

    public function getLokerById($id)
    {
        $loker = Loker::with('idCategory')->with('idHrd')->where('id', $id)->first();

        if ($loker) {
            return response()->json([
                'status' => 'success',
                'message' => 'Loker berhasil ditampilkan',
                'data' => $loker
            ],200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Loker gagal ditampilkan',
            'data' => null
        ],409);
    }

    public function deleteLoker($id)
    {
        $loker = Loker::where('id', $id)->first();

        if ($loker) {
            $loker->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Loker berhasil dihapus',
                'data' => null
            ],200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Loker gagal dihapus',
            'data' => null
        ],409);
    }

    public function getLokerStatusOpen()
    {
        $loker = Loker::with('idCategory')->with('idHrd')->where('status', 'open')->get();

        if ($loker) {
            return response()->json([
                'status' => 'success',
                'message' => 'Loker berhasil ditampilkan',
                'data' => $loker
            ],200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Loker gagal ditampilkan',
            'data' => null
        ],409);
    }

    public function getLokerbyIdCategory($id)
    {
        $loker = Loker::with('idCategory')->with('idHrd')->where('id_category', $id)->get();

        if ($loker) {
            return response()->json([
                'status' => 'success',
                'message' => 'Loker berhasil ditampilkan',
                'data' => $loker
            ],200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Loker gagal ditampilkan',
            'data' => null
        ],409);
    }

    public function updateLoker(Request $request, $id)
    {
        $loker = Loker::where('id', $id)->first();

        $img_loker = request()->img_loker;
        $img_loker_decode = base64_decode($img_loker);
        $img_loker_ex = $this->getImageMimeType($img_loker_decode);
        $img_loker = str_replace('data:image/png;base64,', '', $img_loker);
        $img_loker = str_replace(' ', '+', $img_loker);
        $img_loker_name = Str::random(10) . '.' . $img_loker_ex;
        Storage::disk('upload')->put('lokers/' . $img_loker_name, $img_loker_decode);

        if ($loker) {
           if ($img_loker!= null) {
            $loker->update([
                'id_category' => $request->id_category,
                'id_hrd' => $request->id_hrd,
                'nama' => $request->nama,
                'img_loker' => "uploads/lokers/" . $img_loker_name,
                'alamat' => $request->alamat,
                'tanggal' => $request->tanggal,
                'deskripsi1' => $request->deskripsi1,
                'deskripsi2' => $request->deskripsi2,
                'deskripsi3' => $request->deskripsi3,
                'gaji' => $request->gaji,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Loker berhasil diupdate',
                'data' => $loker
            ],200);
           }else {
            $loker->update([
                'id_category' => $request->id_category,
                'id_hrd' => $request->id_hrd,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'tanggal' => $request->tanggal,
                'deskripsi1' => $request->deskripsi1,
                'deskripsi2' => $request->deskripsi2,
                'deskripsi3' => $request->deskripsi3,
                'gaji' => $request->gaji,
                'status' => $request->status,
            ]);
           }
           

        return response()->json([
            'status' => 'success',
            'message' => 'Loker berhasil diupdate',
            'data' => $loker
        ],200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Loker gagal diupdate',
            'data' => null
        ],409);
    }
}
