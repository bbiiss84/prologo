<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class ResetController extends Controller
{
    public function reset()
    {
        Artisan::call('migrate:fresh --seed');

        foreach (['categories', 'produsts'] as $folder) {
            Storage::deleteDirectory($folder);
            Storage::makeDirectory($folder);

            $files = Storage::disk('reset')->files($folder); // disk('reset') - устанавливает соединение с диском 'reset'. И берем из папки с одноименным названием все файлы.

            foreach ($files as $file) { // Помещаем эти файлы во вновь созданную папку
                Storage::put($file, Storage::disk('reset')->get($file));
            }
        }

        session()->flash('success', 'Проект был сброшен в начальное состояние');

        return to_route('index');
    }
}
