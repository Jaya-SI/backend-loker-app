<?php

namespace App\Http\Controllers\Api\HRD;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function addInterview(Request $request)
    {
        $interview = new Interview();
        $interview->id_seleksi = $request->id_seleksi;
        $interview->id_hrd = $request->id_hrd;
        $interview->id_pelamar = $request->id_pelamar;
        $interview->jadwal = $request->jadwal;
        $interview->token = $request->token;
        $interview->keterangan = $request->keterangan;
        $interview->status = $request->status;

        if ($interview->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menambahkan data interview',
                'data' => $interview
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data interview',
                'data' => ''
            ], 400);
        }
    }

    public function updateInterview(Request $request, $id)
    {
        $interview = Interview::find($id);
        $interview->id_seleksi = $request->id_seleksi;
        $interview->id_hrd = $request->id_hrd;
        $interview->jadwal = $request->jadwal;
        $interview->token = $request->token;
        $interview->keterangan = $request->keterangan;
        $interview->status = $request->status;

        if ($interview->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mengubah data interview',
                'data' => $interview
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah data interview',
                'data' => ''
            ], 400);
        }
    }

    public function deleteInterview($id)
    {
        $interview = Interview::find($id);

        if ($interview->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menghapus data interview',
                'data' => $interview
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa menghapus data interview',
                'data' => ''
            ], 400);
        }
    }

    public function checkPelamarInterview($id)
    {
        $interview = Interview::with('idSeleksi')->with('idHrd')->with('idPelamar')->where('id_seleksi', $id)->first();

        if ($interview) {
            return response()->json([
                'success' => true,
                'message' => 'interview',
                'data' => $interview
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Pelamar tidak ditemukan',
                'data' => ''
            ], 400);
        }
    }

    public function listInterview()
    {
        $interview = Interview::with(['idSeleksi','idHrd','idPelamar'])->get();

        if ($interview) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menampilkan data interview',
                'data' => $interview
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menampilkan data interview',
                'data' => ''
            ], 400);
        }
    }

    public function detailInterview($id)
    {
        $interview = Interview::with('idSeleksi')->with('idHrd')->find($id);

        if ($interview) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil menampilkan data interview',
                'data' => $interview
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menampilkan data interview',
                'data' => ''
            ], 400);
        }
    }
}
