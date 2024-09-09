<?php

use App\Rules\TrimmedRule;
use Illuminate\Contracts\Validation\ValidationRule;

beforeEach(function () {
    $this->rule = new TrimmedRule();
});

it('check the rule trimed instace of ValidationRule', function () {
    expect($this->rule)->toBeInstanceOf(ValidationRule::class);
});

it('check the valitation rule failed when not trimmed', function ($value) {
    $pass = false;
    $this->rule->validate('name', $value, function ($fail) use (&$pass) {
        $pass = true;
    });
    expect($pass)->toBeTrue();
})->with([
    'Left whritespace' => [' trimmed'],
    'Right whitespace' => [' trimmed '],
    'Both whitespace'  => ['  trimmed  '],
]);

it('check validation rule if passed when not needed', function ($value) {
    $pass = true;
    $this->rule->validate('name', $value, function ($fail) use (&$pass) {
        $pass = false;
    });
    expect($pass)->toBeTrue();
})->with([
    ["nullable" => null],
    ["string empty" => ''],
    ["writespace"   => '      '],
    ["Normal"       => 'Lorem ipsum dolor...'],
]);
