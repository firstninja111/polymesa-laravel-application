<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Binaries
    |--------------------------------------------------------------------------
    |
    | Paths to ffmpeg nad ffprobe binaries
    |
    */

    'binaries' => [
        'ffmpeg'  => env('FFMPEG', 'C:\FFmpeg\bin\ffmpeg.exe'),
        'ffprobe' => env('FFPROBE', 'C:\FFmpeg\bin\ffprobe.exe')
    ]
];