<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
	public function index()
	{
		Carbon::setLocale('id'); // Set locale untuk Carbon ke bahasa Indonesia
		$user = auth()->user(); // Ambil data pengguna yang sedang login
		return view('profile.index', compact('user')); // Kirim data ke view
	}
}
