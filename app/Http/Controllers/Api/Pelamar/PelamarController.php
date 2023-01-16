<?php

namespace App\Http\Controllers\Api\Pelamar;

use App\Models\Pelamar;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class PelamarController extends Controller
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

    public function register(Request $request)
    {
        // $foto_pelamar = $request->file('image_pelamar');
        // $extensions = $foto_pelamar->getClientOriginalExtension();
        // $photoPelamar = Str::random(10).".".$extensions;
        // $uploadPath = env('UPLOAD_PATH')."/pelamars";

        //upload foto pelamar base64
        $foto_user = request()->img_pelamar;
        $foto_userdecode = base64_decode($foto_user);
        $foto_user_ex = $this->getImageMimeType($foto_userdecode);
        $foto_user = str_replace('data:image/png;base64,', '', $foto_user);
        $foto_user = str_replace(' ', '+', $foto_user);
        $foto_user_name = Str::random(10) . '.' . $foto_user_ex;
        Storage::disk('upload')->put('pelamars/' . $foto_user_name, $foto_userdecode );

        //upload cv
        $cv_pelamar = $request->file('cv');
        $extensionsCv = $cv_pelamar->getClientOriginalExtension();
        $cvPelamar = Str::random(10).".".$extensionsCv;
        $uploadPathCv = env('UPLOAD_PATH')."/cv";

        //create pelamar
        $pelamar = Pelamar::create([
            'nama' => $request->nama,
            'img_pelamar' => "uploads/pelamars/" . $foto_user_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'role' => 'pelamar',
            'token' => $request->token,
            'cv' => $request->file('cv')->move($uploadPathCv, $cvPelamar)
        ]);


        $credentials = $request->only('email', 'password');
        $token = auth()->guard('api_pelamar')->attempt($credentials);

        if ($pelamar) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil register',
                'data' => $pelamar,
                'token' => $token,
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Gagal Register'
        ], 409);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $token = auth()->guard('api_pelamar')->attempt($credentials);

        if ($token) {
            return response()->json([
                'success' => true,
                'pelamar' => auth()->guard('api_pelamar')->user(),
                'token' => $token,
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Gagal Login'
        ], 409);
    }

    public function updateDataPelamar(Request $request)
    {
        //upload foto pelamar base64
        $foto_user = request()->img_pelamar;
        $foto_userdecode = base64_decode($foto_user);
        $foto_user_ex = $this->getImageMimeType($foto_userdecode);
        $foto_user = str_replace('data:image/png;base64,', '', $foto_user);
        $foto_user = str_replace(' ', '+', $foto_user);
        $foto_user_name = Str::random(10) . '.' . $foto_user_ex;
        Storage::disk('upload')->put('pelamars/' . $foto_user_name, $foto_userdecode );

        //upload cv
        $cv_pelamar = $request->file('cv');
        $extensionsCv = $cv_pelamar->getClientOriginalExtension();
        $cvPelamar = Str::random(10).".".$extensionsCv;
        $uploadPathCv = env('UPLOAD_PATH')."/cv";

        $pelamar = Pelamar::find($request->id);

        if ($pelamar) {
            $pelamar->nama = $request->nama;
            $pelamar->img_pelamar = "uploads/pelamars/" . $foto_user_name;
            $pelamar->email = $request->email;
            $pelamar->alamat = $request->alamat;
            $pelamar->no_hp = $request->no_hp;
            $pelamar->jenis_kelamin = $request->jenis_kelamin;
            $pelamar->token = $request->token;
            $pelamar->cv = $request->file('cv')->move($uploadPathCv, $cvPelamar);
            $pelamar->save();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil update data pelamar',
                'data' => $pelamar,
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Gagal update data pelamar'
        ], 409);
    }

    public function getUser()
    {
        //response data "user" yang sedang login
        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api_pelamar')->user()
        ], 200);
    }

    public function refreshToken(Request $request)
    {
        //refresh "token"
        $refreshToken = JWTAuth::refresh(JWTAuth::getToken());

        //set user dengan "token" baru
        $user = JWTAuth::setToken($refreshToken)->toUser();

        //set header "Authorization" dengan type Bearer + "token" baru
        $request->headers->set('Authorization','Bearer '.$refreshToken);

        //response data "user" dengan "token" baru
        return response()->json([
            'success' => true,
            'user'    => $user,
            'token'   => $refreshToken,
        ], 200);
    }

    public function logout()
    {
        //remove "token" JWT
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        //response "success" logout
        return response()->json([
            'success' => true,
        ], 200);

    }
}
