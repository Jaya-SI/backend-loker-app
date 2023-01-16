<?php

namespace App\Http\Controllers\Api\Pelamar;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function getInterviewWhereIdSeleksiByIdPelamar($id)
    {
        $interview = Interview::with('idSeleksi')->whereHas('idSeleksi', function ($query) use ($id) {
            $query->where('id_pelamar', $id);
        })->get();

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
