<?php

use App\Http\Controllers\CertificadoMinistrante;
use App\Http\Controllers\FormQacademico;
use App\Http\Controllers\ValidaCertificadoMinistrante;
use App\Http\Controllers\ValidaCertificadoParticipante;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () { return redirect('/admin'); })->name('login');
Route::get('/', function () {
     return view('welcome');
//   return redirect()->name('login');
});
//*/
Route::get('pdf/CertificadoMinistrante/{id}',[CertificadoMinistrante::class, 'print'])->name('imprimirCertificadoMinistrante');

// CERTIFICADO PARTICIPANTE
Route::get('ValidaCertificadoParticipante',[ValidaCertificadoParticipante::class, 'index'])->name('ValidaCertificadoParticipante');
Route::post('validarParticipante', [ValidaCertificadoParticipante::class, 'validar'])->name('validarParticipante');

// CERTIFICADO MINISTRANTE
Route::get('ValidaCertificadoMinistrante',[ValidaCertificadoMinistrante::class, 'index'])->name('ValidaCertificadoMinistrante');
Route::post('validarMinistrante', [ValidaCertificadoMinistrante::class, 'validar'])->name('validarMinistrante');

Route::get('pdf/Form-qacademico/{id}',[FormQacademico::class, 'print'])->name('imprimirFormQacademico');
