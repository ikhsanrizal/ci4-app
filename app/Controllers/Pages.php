<?php

namespace App\Controllers;

class Pages extends BaseController
{
  public function index()
  {
    $data['title'] = "Home";
    return view('pages/home', $data);
  }

  public function about()
  {
    $data['title'] = "About Me";
    echo view('pages/about', $data);
  }

  public function contact()
  {
    $data = [

      'title' => 'Contact Us',
      'alamat' => [
        [
          'tipe' => 'rumah',
          'alamat' => 'jl. abc No. 123',
          'kota' => 'Bandung'
        ],
        [
          'tipe' => 'kantor',
          'alamat' => 'jl. abc No. 123',
          'kota' => 'Jakarta'
        ]
      ]
    ];
    return view('pages/contact', $data);
  }
  //--------------------------------------------------------------------

}
