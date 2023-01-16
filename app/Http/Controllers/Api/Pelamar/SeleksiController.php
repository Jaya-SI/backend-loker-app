<?php

namespace App\Http\Controllers\Api\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Seleksi;
use Illuminate\Http\Request;

class SeleksiController extends Controller
{
    public function addSeleksi(Request $request)
    {
        //create seleksi
        $seleksi = Seleksi::create([
            'id_pelamar' => $request->id_pelamar,
            'id_loker' => $request->id_loker,
            'surat_lamaran' => $request->surat_lamaran,
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        if ($seleksi) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambahkan data seleksi',
                'data' => $seleksi
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data seleksi',
                'data' => ''
            ], 400);
        }
    }

    public function getSeleksiByIdPelamar($id)
    {
        $seleksi = Seleksi::with('idPelamar')->with('idLoker')->where('id_pelamar', $id)->get();

        if ($seleksi) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menampilkan data seleksi',
                'data' => $seleksi
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menampilkan data seleksi',
                'data' => ''
            ], 400);
        }
    }

    public function checkRegistered(Request $request)
    {
        $seleksi = Seleksi::where('id_pelamar', $request->id_pelamar)->where('id_loker', $request->id_loker)->first();

        if ($seleksi) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menampilkan data seleksi',
                'data' => $seleksi
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menampilkan data seleksi',
                'data' => ''
            ], 400);
        }
    }

    public function detailSeleksi($id)
    {
        $seleksi = Seleksi::with('idPelamar')->with('idLoker')->where('id', $id)->first();

        if ($seleksi) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menampilkan data seleksi',
                'data' => $seleksi
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menampilkan data seleksi',
                'data' => ''
            ], 400);
        }
    }

    public function deleteSeleksi($id)
    {
        $seleksi = Seleksi::where('id', $id)->first();

        if ($seleksi) {
            $seleksi->delete();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus data seleksi',
                'data' => ''
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data seleksi',
                'data' => ''
            ], 400);
        }
    }
}
