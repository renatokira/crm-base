<?php

uses()->group('arch');

arch('globals avoid dd,dump,ds')
    ->expect(['dd', 'dump', 'ds', 'die'])
    ->not->toBeUsed();

test('should not use dangerous functions in Blade files', function () {
    $files = collect([
        ...Illuminate\Support\Facades\File::allFiles(__DIR__ . '/../../resources/views/'),
        ...Illuminate\Support\Facades\File::allFiles(__DIR__ . '/../../app/View/Components/'),
        ...Illuminate\Support\Facades\File::allFiles(__DIR__ . '/../../app/Livewire/'),
    ])
        ->map(function (SplFileInfo $file) {
            return [
                'name'    => $file->getFilename(),
                'path'    => $file->getRealPath(),
                'content' => file_get_contents($file->getRealPath()),
            ];
        })
        ->filter(function (array $file) {

            if (!str($file['name'])->endsWith('.php')) {
                return false;
            }

            return str($file['content'])->contains(['@dd', '@dump']);
        })
        ->pluck('path')
        ->implode(', ');

    if (!empty($files)) {
        test()->fail("The following files contain dangerous functions: [{$files}]");
    }

    expect($files)->toBeEmpty();
});

arch('the codebase does not reference env variables outside of config files')
    ->expect('env')
    ->not->toBeUsed();

arch('checks the compliance of the App\Enum')
    ->expect('App\Enum')
    ->toExtendNothing()
    ->toHaveSuffix('Enum');
