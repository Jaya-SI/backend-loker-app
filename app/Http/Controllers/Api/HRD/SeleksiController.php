<?php

namespace App\Http\Controllers\Api\HRD;

use App\Http\Controllers\Controller;
use App\Models\Seleksi;
use Illuminate\Http\Request;

class SeleksiController extends Controller
{
    public function listSeleksi()
    {
        $seleksi = Seleksi::with('idPelamar')->with('idLoker')->get();

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

    public function getSeleksiWhereCategoryLoker($id)
    {
        $seleksi = Seleksi::with('idPelamar')->with('idLoker')->whereHas('idLoker', function ($query) use ($id) {
            $query->where('id_category', $id);
        })->get();

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

    public function getSeleksiByStatus($status)
    {
        $seleksi = Seleksi::with('idPelamar')->with('idLoker')->where('status', $status)->get();

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

    public function updateSeleksi(Request $request, $id)
    {
        $seleksi = Seleksi::find($id);
        $data = $request->all();

        if ($seleksi) {
            // $seleksi->update([
            //     'id_pelamar' => $request->id_pelamar,
            //     'id_loker' => $request->id_loker,
            //     'surat_lamaran' => $request->surat_lamaran,
            //     'status' => $request->status,
            //     'keterangan' => $request->keterangan,
            // ]);
            $seleksi->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengubah data seleksi',
                'data' => $seleksi
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah data seleksi',
                'data' => ''
            ], 400);
        }
    }
}
