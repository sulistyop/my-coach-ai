<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
	public function index()
	{
		$user = auth()->user(); // Ambil data pengguna yang sedang login
		return view('profile.index', compact('user')); // Kirim data ke view
	}
}
