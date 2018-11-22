<?php

namespace App\Http\Controllers;

use App\Images;
use App\Sent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class ImagesController extends Controller
{
    public function index(Request $request)
    {

        $imgs = Images::all();
        $img1 = $imgs[0];
        $img2 = $imgs[1];

        $imgURL1 = 'http://transitocurumani.com/ettcurumaniServe/public/images/banners/' . $img1->name_actually;
        $imgID1 = $img1->id;
        $imgURL2 = 'http://transitocurumani.com/ettcurumaniServe/public/images/banners/' . $img2->name_actually;
        $imgID2 = $img2->id;

        $id = Session::get('adminId');
        $pendientes = Sent::where('estado', 'P')->count();

        if ($request->isMethod('post')) {

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $ext = $file->getClientOriginalExtension();

                if ($ext == 'jpg' || $ext == 'jpge' || $ext == 'png' || $ext == 'csv') {

                    $str = Carbon::now() . $file->getClientOriginalName();
                    $name = str_replace(' ', '', $str);
                    $ruta = $file->move(public_path() . '/images/banners/', $name);


                    $data = getimagesize($ruta);
                    $width = $data[0];
                    $height = $data[1];

                    if ($width < 1400 && $height < 1000) {
                        File::delete($ruta);
                        return view('admin.img', [
                            'id' => $id,
                            'pendientes' => $pendientes,
                            'error' => 'La Resolucion de la imagen no es valida, debe ser minimo 1400 x 1000 o mayor.',
                            'imgURL1' => $imgURL1,
                            'imgID1' => $imgID1,
                            'imgURL2' => $imgURL2,
                            'imgID2' => $imgID2
                        ]);
                    } else {
                        $img = Images::where('id', $request->id)->first();

                        $img->real_name = $file->getClientOriginalName();
                        $img->name_actually = $name;
                        $img->url = $ruta;

                        $img->title = $request->title;
                        $img->content = $request->contenido;

                        $img->save();

                        if ($img->id) {
                            $imgs = Images::all();
                            $img1 = $imgs[0];
                            $img2 = $imgs[1];

                            $imgURL1 = 'http://transitocurumani.com/ettcurumaniServe/public/images/banners/' . $img1->name_actually;
                            $imgID1 = $img1->id;
                            $imgURL2 = 'http://transitocurumani.com/ettcurumaniServe/public/images/banners/' . $img2->name_actually;
                            $imgID2 = $img2->id;

                            return view('admin.img', [
                                'id' => $id,
                                'pendientes' => $pendientes,
                                'success' => 'Imagen Subida Correctamente!.',
                                'imgURL1' => $imgURL1,
                                'imgID1' => $imgID1,
                                'imgURL2' => $imgURL2,
                                'imgID2' => $imgID2
                            ]);
                        } else {
                            $imgs = Images::all();
                            $img1 = $imgs[0];
                            $img2 = $imgs[1];

                            $imgURL1 = 'http://transitocurumani.com/ettcurumaniServe/public/images/banners/' . $img1->name_actually;
                            $imgID1 = $img1->id;
                            $imgURL2 = 'http://transitocurumani.com/ettcurumaniServe/public/images/banners/' . $img2->name_actually;
                            $imgID2 = $img2->id;

                            return view('admin.img', [
                                'id' => $id,
                                'pendientes' => $pendientes,
                                'error' => 'Error al Subir Imagen.',
                                'imgURL1' => $imgURL1,
                                'imgID1' => $imgID1,
                                'imgURL2' => $imgURL2,
                                'imgID2' => $imgID2
                            ]);
                        }


                    }

                } else {
                    return view('admin.img', [
                        'id' => $id,
                        'pendientes' => $pendientes,
                        'error' => 'El Archivo subido no tiene un formato valido.',
                        'imgURL1' => $imgURL1,
                        'imgID1' => $imgID1,
                        'imgURL2' => $imgURL2,
                        'imgID2' => $imgID2
                    ]);
                }

            }

        }

        $imgURL1 = 'http://transitocurumani.com/ettcurumaniServe/public/images/banners/' . $img1->name_actually;
        $imgID1 = $img1->id;
        $imgURL2 = 'http://transitocurumani.com/ettcurumaniServe/public/images/banners/' . $img2->name_actually;
        $imgID2 = $img2->id;

        return view('admin.img', [
            'id' => $id,
            'pendientes' => $pendientes,
            'imgURL1' => $imgURL1,
            'imgID1' => $imgID1,
            'imgURL2' => $imgURL2,
            'imgID2' => $imgID2
        ]);
    }

    public function validateSize($ruta, $file)
    {
        $dataIMG = getimagesize($ruta);
        $width = $dataIMG[0];
        $height = $dataIMG[1];

        if ($width >= 1600 && $height >= 1200) {
            return true;
        } else {
            $this->clearTMP($file);
            return false;
        }
    }

    public function clearTMP($path)
    {
        $fileSys = new \Illuminate\Filesystem\Filesystem;
        $fileSys->cleanDirectory($path);
    }


    public function getBanners()
    {
        $array = [];

        $imgs = Images::all();
        $img1 = $imgs[0];
        $img2 = $imgs[1];

        $imgURL1 = 'http://transitocurumani.com/ettcurumaniServe/public/images/banners/' . $img1->name_actually;
        $imgURL2 = 'http://transitocurumani.com/ettcurumaniServe/public/images/banners/' . $img2->name_actually;

        array_push($array, (object)array(
            'imgURL1' => $imgURL1,
            'imgURL2' => $imgURL2
        ));

        return $array;
    }
}
